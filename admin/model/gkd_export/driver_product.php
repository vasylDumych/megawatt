<?php
class ModelGkdExportDriverProduct extends Model {
  private $langIdToCode = array();
  private $stores = array();
  private $front_url;
  private $url_alias_table;
  
  public function getItems($data = array(), $count = false) {
    $this->url_alias_table = version_compare(VERSION, '3', '>=') ? 'seo_url' : 'url_alias';
    
    $data['export_fields'] = isset($data['export_fields']) ? $data['export_fields'] : array();
    
    // seo urls
    if (!class_exists('GkdUrl')) {
      require_once(DIR_SYSTEM.'library/gkd_url.php');
    }
    
    $this->load->model('setting/store');
		$this->stores = array();
		$this->stores[0] = array(
			'store_id' => 0,
			'name'     => $this->config->get('config_name'),
			'url'     => HTTP_CATALOG,
      'ssl' => HTTPS_CATALOG,
		);

		$stores = $this->model_setting_store->getStores();

		foreach ($stores as $store) {
			$action = array();

			$this->stores[$store['store_id']] = $store;
		}
    
    // store_id for use with URL and multistore, set to 0 if empty
    if (!empty($data['filter_store'])) {
      $store_id = $data['filter_store'];
    } else {
      $store_id = 0;
    }
    
    $store = $this->stores[$store_id];
    
    $description_field = '';
    if ($store_id && $this->config->get('mlseo_multistore')) {
      $description_field = 'seo_';
    }
      
    $this->front_url = new GkdUrl($this->registry, $store['url'], $store['ssl']);
    
    if ($count) {
      $select = 'COUNT(DISTINCT p.product_id) AS total';
    } else {
      $select = 'p.*, m.name as manufacturer';
      if (isset($data['filter_language']) && $data['filter_language'] !== '') {
        $select .= ", pd.*";
      }
      
      if (empty($data['param_image_path'])) {
        $select .= ", CONCAT('".HTTP_CATALOG."image/', p.image) as image";
        //$select .= ", (SELECT * FROM " . DB_PREFIX . "product_image WHERE product_id = p.product_id ORDER BY sort_order ASC)";
      }
    }
    
    $sql = "SELECT ".$select." FROM " . DB_PREFIX . "product p";

    $sql .= " LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id)";
    
    if (isset($data['filter_language']) && $data['filter_language'] !== '') {
      $sql .= " LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id)";
    }

    if (isset($data['filter_store']) && $data['filter_store'] !== '') {
      $sql .= " LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id)";
    }
    
    if (!empty($data['filter_category'])) {
      $sql .=  " LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id)";
    }
    
    // WHERE
    // languages
    if (isset($data['filter_language']) && $data['filter_language'] !== '') {
      $sql .= " WHERE pd.language_id = '" . (int)$data['filter_language'] . "'";
    } else {
      $lgquery = $this->db->query("SELECT DISTINCT language_id, code FROM " . DB_PREFIX . "language WHERE status = 1")->rows;
      
      foreach ($lgquery as $lang) {
        $this->langIdToCode[$lang['language_id']] = substr($lang['code'], 0, 2);
      }
      
      $sql .= " WHERE 1";
    }
    
    if (isset($data['filter_store']) && $data['filter_store'] !== '') {
      $sql .= " AND p2s.store_id = '" . (int)$data['filter_store'] . "'";
    }
    
    if (!empty($data['filter_category'])) {
      $data['filter_category'] = implode(',', array_map('intval', (array) $data['filter_category']));
			$sql .= " AND p2c.category_id IN (" . $data['filter_category'] . ")";
    }
    
    if (!empty($data['filter_manufacturer'])) {
      $data['filter_manufacturer'] = implode(',', array_map('intval', (array) $data['filter_manufacturer']));
			$sql .= " AND p.manufacturer_id IN (" . $data['filter_manufacturer'] . ")";
		}
    
		if (!empty($data['filter_name'])) {
			$sql .= " AND pd.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_model'])) {
			$sql .= " AND p.model LIKE '" . $this->db->escape($data['filter_model']) . "%'";
		}

		if (isset($data['filter_price']) && !is_null($data['filter_price'])) {
			$sql .= " AND p.price LIKE '" . $this->db->escape($data['filter_price']) . "%'";
		}

		if (isset($data['filter_quantity']) && !is_null($data['filter_quantity'])) {
			$sql .= " AND p.quantity = '" . (int)$data['filter_quantity'] . "'";
		}

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
		}

    // return count
    if ($count) {
      return $this->db->query($sql)->row['total'];
    }
    
		$sql .= " GROUP BY p.product_id";
    
		$sort_data = array(
			'pd.name',
			'p.model',
			'p.price',
			'p.quantity',
			'p.status',
			'p.sort_order',
			'p.date_added',
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY p.product_id";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}
      
			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);
    
    foreach ($query->rows as &$row) {
      if ((!$this->config->get('mlseo_enabled') || (!$this->config->get('mlseo_multistore') && !$this->config->get('mlseo_ml_mode'))) && version_compare(VERSION, '3', '<')) {
        $seoQuery = $this->db->query("SELECT keyword FROM " . DB_PREFIX . $this->url_alias_table . " u WHERE query = 'product_id=".(int) $row['product_id']."' LIMIT 1")->row;
        $row['seo_keyword'] = isset($seoQuery['keyword']) ? $seoQuery['keyword'] : '';
      }
      
      if (!empty($data['price_multiplier'])) {
        $row['price'] = $row['price'] * $data['price_multiplier'];
      }
      
      $row['link'] = $this->front_url->link('product/product', 'product_id='.$row['product_id']);
      $row['store'] =  $this->getProductStores($row['product_id']);
      
      if (empty($data['filter_language'])) {
        $row += $this->getProductDescription($row['product_id'], $store_id);
      } else if ($this->config->get('mlseo_enabled') && $this->config->get('mlseo_multistore') && $store_id) {
        $this->setSeoDescription($row, $store_id, $data['filter_language']);
      }
      
      if (empty($data['export_fields']) || in_array('additional_images', $data['export_fields'])) {
        $row['additional_images'] = $this->getProductImages($row['product_id'], empty($data['param_image_path']));
      }
      if (empty($data['export_fields']) || in_array('product_filter', $data['export_fields'])) {
        $row['product_filter'] = $this->getProductFilters($row['product_id']);
      }
      if (empty($data['export_fields']) || in_array('product_attribute', $data['export_fields'])) {
        $row['product_attribute'] = $this->getProductAttributes($row['product_id']);
      }
      if (empty($data['export_fields']) || in_array('product_option', $data['export_fields'])) {
        $row['product_option'] = $this->getProductOptions($row['product_id']);
      }
      if (empty($data['export_fields']) || in_array('product_category', $data['export_fields'])) {
        $row['product_category'] = $this->getProductCategories($row['product_id']);
      }
      if (empty($data['export_fields']) || in_array('product_discount', $data['export_fields'])) {
        $row['product_discount'] = $this->getProductDiscounts($row['product_id']);
      }
      if (empty($data['export_fields']) || in_array('product_special', $data['export_fields'])) {
        $row['product_special'] = $this->getProductSpecials($row['product_id']);
      }
    }
    
    if (!empty($data['export_fields'])) {
      $return = array();
      foreach ($query->rows as $i => &$row) {
        foreach ($data['export_fields'] as $field) {
          if (empty($data['filter_language']) && in_array($field, array('name','description','tag','meta_title','meta_description','meta_keyword',/*'seo_keyword',*/'seo_h1','seo_h2','seo_h3','image_title','image_alt'))) {
            foreach ($this->langIdToCode as $lang) {
              $return[$i][$field.'_'.$lang] = isset($row[$field.'_'.$lang]) ? $row[$field.'_'.$lang] : '';
            }
          } else {
            $return[$i][$field] = isset($row[$field]) ? $row[$field] : '';
          }
        }
      }
       
      return $return;
    } else {
      return $query->rows;
    }
	}
  
  public function getProductDescription($product_id, $store_id) {
    $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_description WHERE product_id = '" . (int)$product_id . "' ORDER BY language_id ASC");
    
    if ($store_id && $this->config->get('mlseo_multistore')) {
      $seoDescription = array();
      $seo_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "seo_product_description WHERE product_id = '" . (int)$product_id . "' AND store_id = '".(int) $store_id."' ORDER BY language_id ASC")->rows;
      foreach ($seo_query as $seo_desc) {
        $seoDescription[$seo_desc['language_id']] = $seo_desc;
      }
    }
    
    $res = array();
    
    foreach ($query->rows as &$row) {
      if ($this->config->get('mlseo_enabled') || version_compare(VERSION, '3', '>=')) {
        if (version_compare(VERSION, '3', '>=') || ($this->config->get('mlseo_multistore') && $this->config->get('mlseo_ml_mode'))) {
          $seoQuery = $this->db->query("SELECT keyword FROM " . DB_PREFIX . $this->url_alias_table . " u WHERE query = 'product_id=".(int) $product_id."' AND u.language_id = '".(int) $row['language_id']."' AND store_id = '".(int) $store_id."' LIMIT 1")->row;
        } else if ($this->config->get('mlseo_multistore')) {
          $seoQuery = $this->db->query("SELECT keyword FROM " . DB_PREFIX . $this->url_alias_table . " u WHERE query = 'product_id=".(int) $product_id."' AND store_id = '".(int) $store_id."' LIMIT 1")->row;
        } else if ($this->config->get('mlseo_ml_mode')) {
          $seoQuery = $this->db->query("SELECT keyword FROM " . DB_PREFIX . $this->url_alias_table . " u WHERE query = 'product_id=".(int) $product_id."' AND u.language_id = '".(int) $row['language_id']."' LIMIT 1")->row;
        }
        
        if (isset($seoQuery)) {
          $res['seo_keyword_'.$this->langIdToCode[$row['language_id']]] = isset($seoQuery['keyword']) ? $seoQuery['keyword'] : '';
        }
      }
      
      foreach ($row as $key => $val) {
        if (!in_array($key, array('language_id', 'product_id', 'seo_keyword'))) {
          if (isset($this->langIdToCode[$row['language_id']])) {
            if (isset($seoDescription[$row['language_id']][$key]) && trim(strip_tags($seoDescription[$row['language_id']][$key]))) {
              $res[$key.'_'.$this->langIdToCode[$row['language_id']]] = $seoDescription[$row['language_id']][$key];
            } else {
              $res[$key.'_'.$this->langIdToCode[$row['language_id']]] = $val;
            }
          }
        }
      }
    }
    
		return $res;
	}
  
  private function setSeoDescription(&$row, $store_id, $language_id) {
    $seoDescription = $this->db->query("SELECT * FROM " . DB_PREFIX . "seo_product_description d WHERE product_id = '" . (int)$row['product_id'] . "' AND store_id = '".(int) $store_id."' AND language_id = '".(int) $language_id."'")->row;
		
    if ($this->config->get('mlseo_enabled') || version_compare(VERSION, '3', '>=')) {
      if (version_compare(VERSION, '3', '>=') || ($this->config->get('mlseo_multistore') && $this->config->get('mlseo_ml_mode'))) {
        $seoQuery = $this->db->query("SELECT keyword FROM " . DB_PREFIX . $this->url_alias_table . " u WHERE query = 'product_id=".(int) $row['product_id']."' AND u.language_id = '".(int) $language_id."' AND store_id = '".(int) $store_id."' LIMIT 1")->row;
      } else if ($this->config->get('mlseo_multistore')) {
        $seoQuery = $this->db->query("SELECT keyword FROM " . DB_PREFIX . $this->url_alias_table . " u WHERE query = 'product_id=".(int) $row['product_id']."' AND store_id = '".(int) $store_id."' LIMIT 1")->row;
      } else if ($this->config->get('mlseo_ml_mode')) {
        $seoQuery = $this->db->query("SELECT keyword FROM " . DB_PREFIX . $this->url_alias_table . " u WHERE query = 'product_id=".(int) $row['product_id']."' AND u.language_id = '".(int) $language_id."' LIMIT 1")->row;
      }
      
      if (isset($seoQuery)) {
        $row['seo_keyword'] = isset($seoQuery['keyword']) ? $seoQuery['keyword'] : '';
      }
    }
      
    if (!empty($seoDescription['meta_title'])) {
      $row['meta_title'] = $seoDescription['meta_title'];
    }
    
    if (!empty($seoDescription['meta_description'])) {
      $row['meta_description'] = $seoDescription['meta_description'];
    }
    
    if (!empty($seoDescription['meta_keyword'])) {
      $row['meta_keyword'] = $seoDescription['meta_keyword'];
    }
    
    if (!empty($seoDescription['image_alt'])) {
      $row['image_alt'] = $seoDescription['image_alt'];
    }
    
    if (!empty($seoDescription['image_title'])) {
      $row['image_title'] = $seoDescription['image_title'];
    }
    
    if (!empty($seoDescription['name'])) {
      $row['name'] = $seoDescription['name'];
    }
    
    if (isset($seoDescription['description']) && trim(strip_tags($seoDescription['description']))) {
      $row['description'] = $seoDescription['description'];
    }
    
    if (!empty($seoDescription['seo_h1'])) {
      $row['seo_h1'] = $seoDescription['seo_h1'];
    }
    
    if (!empty($seoDescription['seo_h2'])) {
      $row['seo_h2'] = $seoDescription['seo_h2'];
    }
    
    if (!empty($seoDescription['seo_h3'])) {
      $row['seo_h3'] = $seoDescription['seo_h3'];
    }
    
	}
  
  public function getProductImages($product_id, $full_path) {
		$query = $this->db->query("SELECT image FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int)$product_id . "' ORDER BY sort_order ASC");
    
    $res = '';
    
    foreach ($query->rows as &$row) {
      if ($row['image']) {
        $res .= $res ? '|' : '';
        
        if ($full_path) {
          $res .= HTTP_CATALOG.'image/'.$row['image'];
        } else {
          $res .= $row['image'];
        }
      }
    }
    
		return $res;
	}
  
  public function getProductAttributes($product_id) {
		$product_attribute_data = array();

		$product_attribute_query = $this->db->query("SELECT pa.attribute_id FROM " . DB_PREFIX . "product_attribute pa WHERE pa.product_id = '" . (int)$product_id . "' GROUP BY pa.attribute_id");

		foreach ($product_attribute_query->rows as $product_attribute) {
			$product_attribute_description_data = array();

			$product_attribute_description_query = $this->db->query(
        "SELECT pa.text, pa.language_id, ad.name, agd.name as 'group'
          FROM " . DB_PREFIX . "product_attribute pa
           LEFT JOIN " . DB_PREFIX . "attribute a ON (pa.attribute_id = a.attribute_id)
           LEFT JOIN " . DB_PREFIX . "attribute_description ad ON (pa.attribute_id = ad.attribute_id AND pa.language_id = ad.language_id)
           LEFT JOIN " . DB_PREFIX . "attribute_group_description agd ON (a.attribute_group_id = agd.attribute_group_id AND pa.language_id = agd.language_id)
          WHERE pa.product_id = '" . (int)$product_id . "'
           AND pa.attribute_id = '" . (int)$product_attribute['attribute_id'] . "'");

			foreach ($product_attribute_description_query->rows as $product_attribute_description) {
				$product_attribute_description_data[$product_attribute_description['language_id']] = array(
          'group' => $product_attribute_description['group'],
          'attribute' => $product_attribute_description['name'],
          'value' => $product_attribute_description['text'],
        );
			}

			$product_attribute_data[] = $product_attribute_description_data;
		}
    

    $res = '';
    
    // get formatted string for CSV, take only default language
    foreach ($product_attribute_data as $langs) {
      foreach ($langs as $lang => $item) {
          if ($lang != $this->config->get('config_language_id')) continue;
          
          $res .= $res ? '|' : '';
          $res .= $item['group'] . ':' . $item['attribute'] . ':' . $item['value'];
      }
    }
    
		return $res;
	}
  
  public function getProductOptions($product_id) {
		$product_option_data = array();

		$product_option_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "product_option` po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN `" . DB_PREFIX . "option_description` od ON (o.option_id = od.option_id) WHERE po.product_id = '" . (int)$product_id . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		foreach ($product_option_query->rows as $product_option) {
			$product_option_value_data = array();

			$product_option_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON(pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON(pov.option_value_id = ovd.option_value_id AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "') WHERE pov.product_option_id = '" . (int)$product_option['product_option_id'] . "' ORDER BY ov.sort_order ASC");

      if (!empty($product_option['value'])) {
        $product_option_data[] = array(
          'type'                 => $product_option['type'],
          'name'                 => $product_option['name'],
          'required'             => $product_option['required'],
          'quantity'             => '',
          'subtract'             => '',
          'value'                => $product_option['value'],
          'price'                => '',
          'weight'               => '',
        );
      } else {
  			foreach ($product_option_value_query->rows as $product_option_value) {
  				$product_option_data[] = array(
            'type'                 => $product_option['type'],
            'name'                 => $product_option['name'],
            'required'             => $product_option['required'],
            'quantity'             => $product_option_value['quantity'],
  					'subtract'             => $product_option_value['subtract'],
            'value'                => !empty($product_option_value['name']) ? $product_option_value['name'] : $product_option['value'],
            'price'                => $product_option_value['price_prefix'] . $product_option_value['price'],
            'weight'               => $product_option_value['weight_prefix'] . $product_option_value['weight'],
          );
          /*
  				$product_option_value_data[] = array(
  					'option_name'             => $product_option_value['name'],
  					'product_option_value_id' => $product_option_value['product_option_value_id'],
  					'option_value_id'         => $product_option_value['option_value_id'],
  					'quantity'                => $product_option_value['quantity'],
  					'subtract'                => $product_option_value['subtract'],
  					'price'                   => $product_option_value['price'],
  					'price_prefix'            => $product_option_value['price_prefix'],
  					'points'                  => $product_option_value['points'],
  					'points_prefix'           => $product_option_value['points_prefix'],
  					'weight'                  => $product_option_value['weight'],
  					'weight_prefix'           => $product_option_value['weight_prefix']
  				);
          */
  			}
			}
      /*
			$product_option_data[] = array(
				'product_option_id'    => $product_option['product_option_id'],
				'option_id'            => $product_option['option_id'],
				'name'                 => $product_option['name'],
				'type'                 => $product_option['type'],
				'value'                => $product_option['value'],
				'price'                => $product_option_value['price_prefix'] . $product_option_value['price'],
				'required'             => $product_option['required'],
				'product_option_value' => $product_option_value_data,
			);
      */
		}
    
    // type:name:value:price:qty:subtract:weight:required
    
    $res = '';
    
    // get formatted string for CSV, take only default language
    foreach ($product_option_data as $item) {
          $res .= $res ? '|' : '';
      $res .= $item['type'] . ':' . $item['name'] . ':' . $item['value']. ':' . $item['price'] . ':' . $item['quantity'] . ':' . $item['subtract'] . ':' . $item['weight'] . ':' . $item['required'];
    }
    
		return $res;
	}
  
  public function getProductCategories($product_id) {
		$res = array();
    
		$categories = $this->db->query("
      SELECT pcd.name as parent_name, cd.name, c.category_id, c.parent_id
      FROM " . DB_PREFIX . "product_to_category p2c
       LEFT JOIN " . DB_PREFIX . "category c ON (p2c.category_id = c.category_id)
       LEFT JOIN " . DB_PREFIX . "category_description cd ON (p2c.category_id = cd.category_id AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "')
       LEFT JOIN " . DB_PREFIX . "category_description pcd ON (c.parent_id = pcd.category_id AND pcd.language_id = '" . (int)$this->config->get('config_language_id') . "')
      WHERE product_id = '" . (int)$product_id . "'")->rows;
      
		foreach ($categories as $key => $category) {
      $res[$key] = '';
      
			if (!$category) continue;
      
			$res[$key] = $category['name'];
			
			while (!empty($category['parent_id'])) {
				$res[$key] = $category['parent_name'] . '>' . $res[$key];
				$category = $this->db->query("
          SELECT pcd.name as parent_name, c.category_id, c.parent_id FROM " . DB_PREFIX . "category c
           LEFT JOIN " . DB_PREFIX . "category_description pcd ON (c.parent_id = pcd.category_id AND pcd.language_id = '" . (int)$this->config->get('config_language_id') . "')
          WHERE c.category_id = '" . $category['parent_id']. "'")->row;
			}
		}
    
		if (!count($res)) return '';
    
    $res = implode('|', $res);
    
    return $res;
	}
  
  public function getProductFilters($product_id) {
		$query = $this->db->query("SELECT fd.name as name, fgd.name as group_name FROM " . DB_PREFIX . "product_filter pf
    LEFT JOIN " . DB_PREFIX . "filter f ON (pf.filter_id = f.filter_id)
    LEFT JOIN " . DB_PREFIX . "filter_description fd ON (pf.filter_id = fd.filter_id)
    LEFT JOIN " . DB_PREFIX . "filter_group fg ON (f.filter_group_id = fg.filter_group_id)
    LEFT JOIN " . DB_PREFIX . "filter_group_description fgd ON (f.filter_group_id = fgd.filter_group_id)
    WHERE pf.product_id = '" . (int)$product_id . "'
    AND fd.language_id = '" . (int)$this->config->get('config_language_id') . "'
    AND fgd.language_id = '" . (int)$this->config->get('config_language_id') . "'
    ORDER BY f.sort_order, fg.sort_order, f.filter_id");

    $res = '';
    
    // get formatted string for CSV, take only default language
    foreach ($query->rows as $item) {
      $res .= $res ? '|' : '';
      $res .= $item['group_name'] . ':' . $item['name'];
    }
    
		return $res;
	}
  
  public function getProductStores($product_id) {
    $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_store WHERE product_id = '" . (int)$product_id . "'");
    
    $res = '';
    
    // get formatted string for CSV, take only default language
    foreach ($query->rows as $item) {
      $res .= ($res !== '') ? '|' : '';
      $res .= isset($this->stores[$item['store_id']]['name']) ? $this->stores[$item['store_id']]['name'] : '';
    }
    
		return $res;
  }
  
  public function getProductDiscounts($product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product_id . "' ORDER BY quantity, priority, price");

    $res = '';
    
    // get formatted string for CSV, take only default language
    foreach ($query->rows as $item) {
      $res .= $res ? '|' : '';
      $res .= $item['customer_group_id'] . ':' . $item['quantity'] . ':' . $item['priority'] . ':' . $item['price'] . ':' . $item['date_start'] . ':' . $item['date_end'];
    }
    
		return $res;
	}
  
  public function getProductSpecials($product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product_id . "' ORDER BY priority, price");

    $res = '';
    
    // get formatted string for CSV, take only default language
    foreach ($query->rows as $item) {
      $res .= $res ? '|' : '';
      $res .= $item['customer_group_id'] . ':' . $item['priority'] . ':' . $item['price'] . ':' . $item['date_start'] . ':' . $item['date_end'];
    }
    
		return $res;
	}
  
  public function getTotalItems($data = array()) {
    return $this->getItems($data, true);
  }
}