<?php  
class ControllerModuleFlyoutmenumodule extends Controller {
	protected function index($setting) {
	
		$this->load->model('catalog/category');
	
		$this->load->model('tool/image'); 
		
		$this->load->model('catalog/information');
		
		$this->load->model('catalog/manufacturer');
		
		$this->load->model('catalog/product');
		
		$this->language->load('common/footer');
      
	    $this->language->load('module/category');
		
	    $this->document->addStyle('catalog/view/flyoutmenu/flyoutmenu.css');
        
		$menu_id = (int)$setting['menu'];
		
		if (!$menu_id) {
			$module_preffix = '';
			$cache_id = 'default';
			$this->data['i_class'] = 'flyoutmenu_default';
		} else {
			$module_preffix = 'menu'.$menu_id.'_';
			$cache_id = 'menu'.$menu_id;
			$this->data['i_class'] = 'flyoutmenu_'.$menu_id;
		}
		
		
        if ($this->config->get($module_preffix.'flyoutmenu_settings_status')) {
			$this->document->addStyle($this->url->link('module/flyoutmenumodule/css'));
        }
        
        $this->document->addScript('catalog/view/flyoutmenu/flyoutmenu.js');
		
		$this->data['skin'] = $setting['theme'] == 'default' ? 'fly_default' : $setting['theme'];
		
		$this->data['categ_text'] = $this->language->get('heading_title');
		
		$this->data['brands_text'] = $this->language->get('text_manufacturer');
        
        $this->language->load('account/login');
        $this->language->load('module/account');
		
		$this->data['direction'] = $this->language->get('direction');
		
		$fl = $this->config->get($module_preffix.'flyoutmenu_language');
		
		$fo = $this->config->get($module_preffix.'flyoutmenu_options');
		
		$flyout_image_width = $fo['image_width'];
		$flyout_image_height = $fo['image_height'];
		
		$this->data['pos_class'] = ($fo['positioning'] == 1) ? '' : ' relat_pos';
		$this->data['col_class'] = ($setting['position'] == 'column_left') ? ' ontheleft' : ' ontheright';
		
		$vmname = $fl['viewmorename'];
		$viewmorecategoriestext = (isset($vmname[$this->config->get('config_language_id')]) && $vmname[$this->config->get('config_language_id')]) ? $vmname[$this->config->get('config_language_id')] : 'view more';
		
		$vaname = $fl['viewallname'];
		$this->data['viewalltext'] = (isset($vaname[$this->config->get('config_language_id')]) && $vaname[$this->config->get('config_language_id')]) ? $vaname[$this->config->get('config_language_id')] : 'View All';
		
		$baname = $fl['brandsdname'];
		if (isset($baname[$this->config->get('config_language_id')]) && $baname[$this->config->get('config_language_id')]) {
			$this->data['brands_text'] = $baname[$this->config->get('config_language_id')];	
			$newbranddname = $baname[$this->config->get('config_language_id')];
		} else {
		    $newbranddname = false;
		}
		$caname = $fl['mobilemenuname'];
		$this->data['categ_text'] = (isset($caname[$this->config->get('config_language_id')]) && $caname[$this->config->get('config_language_id')]) ? $caname[$this->config->get('config_language_id')] : $this->data['categ_text'];
		
		$infodrname = $fl['infodname'];
		$infodrnamenew = (isset($infodrname[$this->config->get('config_language_id')]) && $infodrname[$this->config->get('config_language_id')]) ? $infodrname[$this->config->get('config_language_id')] : false;
		
		$subcatslimit = $fo['3dlevellimit'] ? $fo['3dlevellimit'] : false;
		
		$this->data['linkoftopitem'] = $fo['topitemlink'] ? $fo['topitemlink'] : 'topitem';
		
		$this->data['dropdowntitle'] = $fo['dropdowntitle'] ? true : false;
		
		$this->data['dropdowneffect'] = $fo['dropdowneffect'] ? $fo['dropdowneffect'] : 'fade';
		
		$this->data['usehoverintent'] = $fo['usehoverintent'] ? false : true;
		
		if ($this->data['usehoverintent']) {
			$this->document->addScript('catalog/view/flyoutmenu/jquery.hoverIntent.minified.js');
		}
		
		$this->data['flyout_width'] = $fo['flyout_width'];
		
		$this->data['bspace_width'] = $fo['bannerspace_width'];
		
	    $this->data['mitems'] = array();
	    $mitems = array();
		
		$items = $this->config->get($module_preffix.'flyoutmenu_item');
		
		if ($items) {
		 foreach ($items as $iorder) {
			if (isset($iorder['sorder'])) {
                if(is_numeric($iorder['sorder'])) { $itemsorder[] = $iorder['sorder']; } else { $itemsorder[] = 99; }
			} else {
				$itemsorder[] = 99;
			}
         }
		 array_multisort($itemsorder,SORT_NUMERIC,$items);
		}
		
		$flyoutmenucache = $fo['flyoutcache'] ? true : false;
		
		$flytems = false;
		
        /* check for items */
		if ($items) {
		
		    $increaseid = 0;
            
            if ($flyoutmenucache) {
                $flytems = $this->cache->get('flyoutmenu.items.' . $cache_id . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id'));
            } else {
                $flytems = false;
            }
            
         /* check for cache */
         if (!$flytems) {
             
		 /* loop trough items */
		 foreach ($items as $item) {
             
		  $stores = isset($item['stores']) ? $item['stores'] : array();
            
         /* check if item is activated for active store */   
		 if (in_array($this->config->get('config_store_id'), $stores)) {
             
		  $increaseid++;
		 
		  $item_name = '';
		 
		  if ($item['type'] == 'cat') {
		 
           $katid = $item['category_id']; 
		   
		   $cssid = 'supcat' . $item['category_id'];
		 
           $kat_info = $this->model_catalog_category->getCategory($katid);	
		   
		    if ($kat_info) {
			
		     $item_name = $kat_info['name'];
			 
			 if (isset($item['customname'][$this->config->get('config_language_id')])) { 
				if (strlen($item['customname'][$this->config->get('config_language_id')]) > 2) {
					$item_name = $item['customname'][$this->config->get('config_language_id')];
				}
			 }
			 $item_view = $item['view'];
			 
			 $item_id = $kat_info['category_id'];
			 
			 $item_url = $this->url->link('product/category', 'path=' . $item_id);
			 
			 $firstkids_data = array();
			 
			 if($item['subcatdisplay'] != 'none') {
			
			 $firstkids = $this->model_catalog_category->getCategories($item_id);
			 
			 foreach ($firstkids as $firstkid) {
			 
			  $secondkids_data = array();
			  
			  if ($firstkid['image']) {
				$image = $this->model_tool_image->resize($firstkid['image'], $flyout_image_width, $flyout_image_height);
			  } else {
				$image = $this->model_tool_image->resize('no_image.jpg', $flyout_image_width, $flyout_image_height);
			  }
			if ($item['subcatdisplay'] != 'none' && $item['subcatdisplay'] != 'level1') {
			  $secondkids = $this->model_catalog_category->getCategories($firstkid['category_id']);
			  
			  $countingsubcats = 0;
			  
			  foreach ($secondkids as $secondkid) {
				$countingsubcats++;
				if ($secondkid['image']) {
					$secondimage = $this->model_tool_image->resize($secondkid['image'], $flyout_image_width, $flyout_image_height);
				} else {
					$secondimage = $this->model_tool_image->resize('no_image.jpg', $flyout_image_width, $flyout_image_height);
				}
				if (!$subcatslimit) {
					$secondkids_data[] = array(
						'category_id' => $secondkid['category_id'],
						'cssid'       => "supcat" . $secondkid['category_id'],
						'name'        => $secondkid['name'],
						'thumb'	      => $secondimage,
						'href'        => $this->url->link('product/category', 'path=' . $item_id . '_' . $firstkid['category_id'] . '_' . $secondkid['category_id'])	
					);	
				} else {
					if ($countingsubcats <= $subcatslimit) {
						$secondkids_data[] = array(
							'category_id' => $secondkid['category_id'],
							'cssid'       => "supcat" . $secondkid['category_id'],
							'name'        => $secondkid['name'],
							'thumb'	      => $secondimage,
							'href'        => $this->url->link('product/category', 'path=' . $item_id . '_' . $firstkid['category_id'] . '_' . $secondkid['category_id'])	
						);	
					}
				}	
			  } 
				if ($subcatslimit && $item_view != 'f0' && $item_view != 'f1') {
				 if ($subcatslimit < $countingsubcats) {
				    $secondkids_data[] = array(
						'category_id' => '',
						'cssid'       => "supcat-more-button",
						'name'        => $viewmorecategoriestext,
						'thumb'	      => '',
						'href'        => $this->url->link('product/category', 'path=' . $item_id . '_' . $firstkid['category_id'])	
					);	
				 }
				}
			}
			   
			  $firstkids_data[] = array(
						'category_id' => $firstkid['category_id'],
						'cssid'       => "supcat" . $firstkid['category_id'],
						'name'        => $firstkid['name'],
						'thumb'       => $image,
						'gchildren'   => $secondkids_data,
						'href'        => $this->url->link('product/category', 'path=' . $item_id . '_' . $firstkid['category_id'])	
					);						
			 }
			 }
			 
			 if ($kat_info['image']) {
				$item_image = $this->model_tool_image->resize($kat_info['image'], 100, 100);
			 } else {
				$item_image = $this->model_tool_image->resize('no_image.jpg', 100, 100);
			 }
		   
		   
		    }
		
		  } elseif ($item['type'] == 'more' || $item['type'] == 'more2') {
		     
			 if ($item['type'] == 'more2') {
				$itm = $fl['more2_title'];
			 
				$item_name = (isset($itm[$this->config->get('config_language_id')]) && $itm[$this->config->get('config_language_id')]) ? $itm[$this->config->get('config_language_id')] : 'More Categories';
			 } else {
				$itm = $fl['more_title'];
			 
				$item_name = (isset($itm[$this->config->get('config_language_id')]) && $itm[$this->config->get('config_language_id')]) ? $itm[$this->config->get('config_language_id')] : 'More Categories';
			 }
			 
			 $cssid = 'notcat' . $increaseid;
			 $item_view = $item['view'];
			 
			 $item_id = '';
			 
			 $item_url = '';
			 
			 $firstkids_data = array();
			 $order = array();
			 
			if ($item['type'] == 'more2') {
			 $firstkids =  $this->config->get($module_preffix.'flyoutmenu_more2');
			} else {
			 $firstkids =  $this->config->get($module_preffix.'flyoutmenu_more');
			}
			 if ($subcatslimit && $item_view != 'f0' && $item_view != 'f1') { $scatslimit = $subcatslimit; } else { $scatslimit = false; }
			 
			foreach ($firstkids as $kid) {
			 
			 $firstkid = $this->model_catalog_category->getCategory($kid);
			 if($firstkid) {
			  $secondkids_data = array();
			
			  if ($firstkid['image']) {
				$image = $this->model_tool_image->resize($firstkid['image'], $flyout_image_width, $flyout_image_height);
              } else {
				$image = $this->model_tool_image->resize('no_image.jpg', $flyout_image_width, $flyout_image_height);
			  }
			  if($item['subcatdisplay'] != 'none') {
			  $secondkids = $this->model_catalog_category->getCategories($firstkid['category_id']);
			  $countingsubcatsk = 0;
			  foreach ($secondkids as $secondkid) {
			   $countingsubcatsk++;
			    $thirdkids_data = array();
			   if ($item['subcatdisplay'] != 'none' && $item['subcatdisplay'] != 'level1') {
			    $thirdkids = $this->model_catalog_category->getCategories($secondkid['category_id']);
				 $countingsubcats2 = 0;
				foreach ($thirdkids as $thirdkid) {
				 $countingsubcats2++;
					if (!$subcatslimit) {
						$thirdkids_data[] = array(
							'category_id' => $thirdkid['category_id'],
							'cssid'       => "morecatc" . $thirdkid['category_id'],
							'name'        => $thirdkid['name'],
							'href'        => $this->url->link('product/category', 'path=' . $firstkid['category_id'] . '_' . $secondkid['category_id'] . '_' . $thirdkid['category_id'])	
						);
					} else {
						if ($countingsubcats2 <= $subcatslimit) {
							$thirdkids_data[] = array(
								'category_id' => $thirdkid['category_id'],
								'cssid'       => "morecatc" . $thirdkid['category_id'],
								'name'        => $thirdkid['name'],
								'href'        => $this->url->link('product/category', 'path=' . $firstkid['category_id'] . '_' . $secondkid['category_id'] . '_' . $thirdkid['category_id'])	
							);
						}
					}
				}
				if ($subcatslimit) {
				 if ($subcatslimit < $countingsubcats2) {	
					$thirdkids_data[] = array(
								'category_id' => '',
								'cssid'       => "supcat-more-button",
								'name'        => $viewmorecategoriestext,
								'href'        => $this->url->link('product/category', 'path=' . $firstkid['category_id'] . '_' . $secondkid['category_id'])	
					);
				 }
				}
					
			   }
			   if ($secondkid['image']) {
				$secondimage = $this->model_tool_image->resize($secondkid['image'], $flyout_image_width, $flyout_image_height);
               } else {
				$secondimage = $this->model_tool_image->resize('no_image.jpg', $flyout_image_width, $flyout_image_height);
			   }
			   if (!$scatslimit) {
			    $secondkids_data[] = array(
						'category_id' => $secondkid['category_id'],
						'cssid'       => "morecat" . $secondkid['category_id'],
						'name'        => $secondkid['name'],
						'thumb'       => $secondimage,
						'ggchildren'  => $thirdkids_data,
						'href'        => $this->url->link('product/category', 'path=' . $firstkid['category_id'] . '_' . $secondkid['category_id'])	
					);	
			   } else {
			    if ($countingsubcatsk <= $scatslimit) {
			     $secondkids_data[] = array(
						'category_id' => $secondkid['category_id'],
						'cssid'       => "morecat" . $secondkid['category_id'],
						'name'        => $secondkid['name'],
						'thumb'       => $secondimage,
						'ggchildren'  => $thirdkids_data,
						'href'        => $this->url->link('product/category', 'path=' . $firstkid['category_id'] . '_' . $secondkid['category_id'])	
					);	
			    }
			   }
			  
			  }
			  
				if ($scatslimit) {
				 if ($scatslimit < $countingsubcatsk) {	
			     $secondkids_data[] = array(
						'category_id' => '',
						'cssid'       => "supcat-more-button",
						'name'        => $viewmorecategoriestext,
						'thumb'       => '',
						'ggchildren'  => '',
						'href'        => $this->url->link('product/category', 'path=' . $firstkid['category_id'])	
					);	
				 }
				}
			  }
			   
			  $firstkids_data[] = array(
						'category_id' => $firstkid['category_id'],
						'cssid'       => "morecat" . $firstkid['category_id'],
						'name'        => $firstkid['name'],
						'thumb'       => $image,
						'order'       => $firstkid['sort_order'],
						'gchildren'   => $secondkids_data,
						'href'        => $this->url->link('product/category', 'path=' . $firstkid['category_id'])	
					);						
			 }
			}
			 foreach ($firstkids_data as $itemsmore) {
                $order[] = $itemsmore['order'];
             }


			 array_multisort($order,SORT_NUMERIC,$firstkids_data);
			 $item_image = false;
		   
		
		  } elseif ($item['type'] == 'infol') {
		  
		   $info_id = $item['information_id']; 
		   
		   $cssid = 'notcat' . $increaseid;
		   
		   $item_view = '';
		 
           $info_info = $this->model_catalog_information->getInformation($info_id);
		   
		   if ($info_info) {
		    
			 $item_name = $info_info['title'];
			 
			 $item_id = $info_info['information_id'];
			 
			 $item_url = $this->url->link('information/information', 'information_id=' . $item_id);
			 
			 $firstkids_data = array();
			 
			 $item_image = false;
			
		   }
			
			
		  } elseif ($item['type'] == 'infod') {
			if ($infodrnamenew) {
		     $item_name = $infodrnamenew;
			} else {
		     $item_name = $this->language->get('text_information');
			}
			 $item_view = '';
			 
			 $cssid = 'notcat' . $increaseid;
			 
			 $item_id = '';
			 
			 $item_url = '';
			 
			 $firstkids_data = array();
			 
			 foreach ($this->model_catalog_information->getInformations() as $infolinks) {
			 
				$firstkids_data[] = array(
						'category_id' => false,
						'cssid'       => "supinfo" . $infolinks['information_id'],
						'name'        => $infolinks['title'],
						'gchildren'   => false,
						'href'        => $this->url->link('information/information', 'information_id=' . $infolinks['information_id'])
					);
					
    	     }
			 
			 $item_image = false;
		
		  } elseif ($item['type'] == 'mand') {
		    if ($newbranddname) {
		     $item_name = $newbranddname;
			} else {
		     $item_name = $this->language->get('text_manufacturer');
			}
			 $item_view = $item['view'];
			 
			 $cssid = 'notcat' . $increaseid;
			 
			 $item_id = '';
			 
			 $item_url = '';
			 
			 $firstkids_data = array();
			 
			 foreach ($this->model_catalog_manufacturer->getManufacturers() as $brandlinks) {
			 
			     if ($brandlinks['image']) {
				  $image = $this->model_tool_image->resize($brandlinks['image'],  $flyout_image_width, $flyout_image_height);
                 } else {
			 	  $image = $this->model_tool_image->resize('no_image.jpg',  $flyout_image_width, $flyout_image_height);
			     }
			    if (VERSION == '1.5.2' || VERSION == '1.5.2.1' || VERSION == '1.5.3' || VERSION == '1.5.3.1') {
				$firstkids_data[] = array(
						'category_id' => false,
						'name'        => $brandlinks['name'],
						'cssid'       => "supbrand" . $brandlinks['manufacturer_id'],
						'thumb'       => $image,
						'gchildren'   => false,
						'href'        => $this->url->link('product/manufacturer/product', 'manufacturer_id=' . $brandlinks['manufacturer_id'])
					);
				} else {
                    $firstkids_data[] = array(
						'category_id' => false,
						'name'        => $brandlinks['name'],
						'cssid'       => "supbrand" . $brandlinks['manufacturer_id'],
						'thumb'       => $image,
						'gchildren'   => false,
						'href'        => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $brandlinks['manufacturer_id'])
					);
                }				
    	     }
			 
			 $item_image = false;
			 
			 $item_description = false;
		
		  } elseif ($item['type'] == 'products') {
		  
			 $item_view = $item['view'];
			 
			 $item_id = '';
			 
			 $cssid = 'notcat' . $increaseid;
			 
			 $item_url = '';
			 
			 $firstkids_data = array();
			
			if ($item['products'] == 'special') {
			
			 $itm = $fl['specialpname'];
			 $item_name = (isset($itm[$this->config->get('config_language_id')]) && $itm[$this->config->get('config_language_id')]) ? $itm[$this->config->get('config_language_id')] : 'Special Offers';
			 $data = array(
				'sort'  => 'pd.name',
				'order' => 'ASC',
				'start' => 0,
				'limit' => $item['productlimit']
		     );
			 $productresults = $this->model_catalog_product->getProductSpecials($data);
			
			} elseif ($item['products'] == 'featured') {
			
			 $itm = $fl['featuredpname'];
			 $item_name = (isset($itm[$this->config->get('config_language_id')]) && $itm[$this->config->get('config_language_id')]) ? $itm[$this->config->get('config_language_id')] : 'Featured Products';
			 if ($this->config->get('featured_product')){
			 $productresults = explode(',', $this->config->get('featured_product'));		
		     $productresults = array_slice($productresults, 0, (int)$item['productlimit']);
			 } else {
			 $productresults = array();
			 }
				
			} elseif ($item['products'] == 'bestseller') {
			
			 $itm = $fl['bestpname'];
			 $item_name = (isset($itm[$this->config->get('config_language_id')]) && $itm[$this->config->get('config_language_id')]) ? $itm[$this->config->get('config_language_id')] : 'BestSellers';
			 $productresults = $this->model_catalog_product->getBestSellerProducts($item['productlimit']);
				
			} else {
			
			 $itm = $fl['latestpname'];
			 $item_name = (isset($itm[$this->config->get('config_language_id')]) && $itm[$this->config->get('config_language_id')]) ? $itm[$this->config->get('config_language_id')] : 'Latest Products';
				
			 $data = array(
				'sort'  => 'p.date_added',
				'order' => 'DESC',
				'start' => 0,
				'limit' => $item['productlimit']
			 );
			 $productresults = $this->model_catalog_product->getProducts($data);
			}
			if ($item['products'] == 'featured') {
			foreach ($productresults as $product_id) {
			$product_info = $this->model_catalog_product->getProduct($product_id);
			
			if ($product_info) {
				if ($product_info['image']) {
					$image = $this->model_tool_image->resize($product_info['image'], $flyout_image_width, $flyout_image_height);
				} else {
					$image = $this->model_tool_image->resize('no_image.jpg', $flyout_image_width, $flyout_image_height);
				}

				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$price = false;
				}
						
				if ((float)$product_info['special']) {
					$special = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$special = false;
				}
				
				$secondkids_data = array();
				$firstkids_data[] = array(
						'category_id' => $product_info['product_id'],
						'cssid'       => "morecat" . $product_info['product_id'],
						'name'        => $product_info['name'],
						'thumb'       => $image,
						'price'   	  => $price,
						'special' 	  => $special,
						'gchildren'   => $secondkids_data,
						'href'        => $this->url->link('product/product', 'product_id=' . $product_info['product_id'])	
					);
			}
			}
			} else {
			foreach ($productresults as $product_info) {
				if ($product_info['image']) {
					$image = $this->model_tool_image->resize($product_info['image'], $flyout_image_width, $flyout_image_height);
				} else {
					$image = $this->model_tool_image->resize('no_image.jpg', $flyout_image_width, $flyout_image_height);
				}

				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$price = false;
				}
						
				if ((float)$product_info['special']) {
					$special = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$special = false;
				}
				
				$secondkids_data = array();
				$firstkids_data[] = array(
						'category_id' => $product_info['product_id'],
						'cssid'       => "morecat" . $product_info['product_id'],
						'name'        => $product_info['name'],
						'thumb'       => $image,
						'price'   	  => $price,
						'special' 	  => $special,
						'gchildren'   => $secondkids_data,
						'href'        => $this->url->link('product/product', 'product_id=' . $product_info['product_id'])	
					);
			}
			}
			 
			 $item_image = false;
		   
		
		 } elseif ($item['type'] == 'catprods') {
		 
		   $katid = $item['category_id']; 
		   
		   $cssid = 'supcat' . $item['category_id'];
		 
           $kat_info = $this->model_catalog_category->getCategory($katid);	
		   
		  if ($kat_info) {
			
		     $item_name = $kat_info['name'];
			 
			 $item_view = $item['view'];
			 
			 $item_id = $kat_info['category_id'];
			 
			 $item_url = $this->url->link('product/category', 'path=' . $item_id);
			 
			 $firstkids_data = array();
			
			 $data = array(
				'sort'  => 'p.date_added',
				'filter_category_id' => $item_id,
				'order' => 'DESC',
				'start' => 0,
				'limit' => $item['productlimit']
			 );
			 $productresults = $this->model_catalog_product->getProducts($data);
			
			foreach ($productresults as $product_info) {
				if ($product_info['image']) {
					$image = $this->model_tool_image->resize($product_info['image'], $flyout_image_width, $flyout_image_height);
				} else {
					$image = $this->model_tool_image->resize('no_image.jpg', $flyout_image_width, $flyout_image_height);
				}

				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$price = false;
				}
						
				if ((float)$product_info['special']) {
					$special = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$special = false;
				}
				
				$secondkids_data = array();
				$firstkids_data[] = array(
						'category_id' => $product_info['product_id'],
						'cssid'       => "morecat" . $product_info['product_id'],
						'name'        => $product_info['name'],
						'thumb'       => $image,
						'price'   	  => $price,
						'special' 	  => $special,
						'gchildren'   => $secondkids_data,
						'href'        => $this->url->link('product/product', 'path=' . $item_id . '&product_id=' . $product_info['product_id'])	
					);
			}
			 
			 if ($kat_info['image']) {
				$item_image = $this->model_tool_image->resize($kat_info['image'], 100, 100);
			 } else {
				$item_image = $this->model_tool_image->resize('no_image.jpg', 100, 100);
			 }
		   
		  }
		
		 } elseif($item['type'] == 'login') {
			
		     $item_name = $this->language->get('button_login');
			  
			 if ($this->customer->isLogged()) {
				$item_name = $this->language->get('heading_title');
			 }
			 
			 $item_view = '';
			 
			 $item_id = '';
			 
			 $cssid = 'login_drop';
			  
			 if ($this->customer->isLogged()) {
				 $item_url = $this->url->link('account/account', '', 'SSL');
			 } else {
				 $item_url = $this->url->link('account/login', '', 'SSL');
			 }
			 $firstkids_data = array();
			 
			 $item_image = false;
			 
			 
		  } else {
		  
		     $item_name = $item['customname'][$this->config->get('config_language_id')];
			 
			 $item_view = '';
			 
			 $item_id = '';
			 
			 $cssid = 'notcat' . $increaseid;
			 
			 $item_url = $item['customurl'][$this->config->get('config_language_id')];
			 
			 $firstkids_data = array();
			 
			 $item_image = false;
		  
		  }
		  
		  $item_addurl = $item['addurl'][$this->config->get('config_language_id')];
			 
		  $item_topimg = '';
		  
		  if ($item_name) {
			  
                if (!$item_url && isset($item['customurl'][$this->config->get('config_language_id')]) && $item['customurl'][$this->config->get('config_language_id')]) $item_url = $item['customurl'][$this->config->get('config_language_id')];
			  
		   $mitems[] = array(
				'name'        => $item_name,
				'id'          => $item_id,
				'cssid'       => $cssid,
				'children'    => $firstkids_data,
				'image'       => $item_image,
				'view'        => $item_view,
				'add'         => $item['image'],
				'addurl'      => $item_addurl,
				'href'        => $item_url,
				'tlcolor'     => $item['tlcolor'],
				'tlstyle'     => $item['tlstyle'],
				'chtml'       => $item['chtml'],
				'dwidth'      => $item['dwidth'],
				'iwidth'      => $item['iwidth'],
				'fbrands'     => $item['fbrands'],
				'item_topimg' => $item_topimg,
				'type' 		  => $item['type'],
				'cchtml'      => $item['cchtml']
			);
			
		  }	
		  
		 } /* end store check */
		} /* end loop trough items */
            if ($flyoutmenucache && $mitems) { /* set cache if enabled */
                $this->cache->set('flyoutmenu.items.' . $cache_id . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id'), $mitems);
            }
        } /* end check for cache */
       } /* end check for items */
       
		
		$mitems = $flytems ? $flytems : $mitems;
		
		foreach ($mitems as $item) { /* loop again trough items to not include html areas in cache */
			
			if ($item['cchtml'] && $item['chtml']) { 
				$itemarea = $this->config->get($module_preffix.'flyoutmenu_html'.$item['cchtml']);
				if (isset($itemarea[$this->config->get('config_language_id')])) {
					$cchtml = html_entity_decode($itemarea[$this->config->get('config_language_id')], ENT_QUOTES, 'UTF-8');
				} else {
					$cchtml = '';
				}
			} else {
				$cchtml = '';
			}
			
			$brandsinitem = array();
			
			if ($item['fbrands']) {
				$brandsids = explode(',', $item['fbrands']);
			} else {
				$brandsids  = array();
			}
			
		    foreach ($brandsids as $brandsid) {
					$brand_info = $this->model_catalog_manufacturer->getManufacturer($brandsid);
					if ($brand_info) {
						if (VERSION == '1.5.2' || VERSION == '1.5.2.1' || VERSION == '1.5.3' || VERSION == '1.5.3.1') {
							$brandsinitem[] = array(
								'name' => $brand_info['name'],
								'manufacturer_id' => $brand_info['manufacturer_id'],
								'href' => $this->url->link('product/manufacturer/product', 'manufacturer_id=' . $brand_info['manufacturer_id'])
							);
						} else {
							$brandsinitem[] = array(
								'name' => $brand_info['name'],
								'manufacturer_id' => $brand_info['manufacturer_id'],
								'href' => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $brand_info['manufacturer_id'])
							);
						}
					}
			}
			
			if ($item['dwidth']) {
				$dwidth = $item['dwidth'];
			} elseif ($item['type'] != 'login' && $item['view'] != 'f0' && $item['view'] != 'f1') {
				$dwidth = $this->data['flyout_width'];
			} else {
				$dwidth = '';
			}
			
			if($this->data['skin'] == "imgmenu") {
				$item_add = '';
				$item_topimg_pre = isset($item['add'][$this->config->get('config_language_id')]) ? $item['add'][$this->config->get('config_language_id')] : '';
				if($item_topimg_pre) {
					$item_topimg = $this->model_tool_image->resize($item_topimg_pre, 75, 75);
				} else {
					$item_topimg = $this->model_tool_image->resize('no_image.jpg', 75, 75);
				}
			} else {
				$item_add = isset($item['add'][$this->config->get('config_language_id')]) ? $item['add'][$this->config->get('config_language_id')] : '';
				$item_topimg = '';
			}
				
			$this->data['mitems'][] = array(
				'name'        => $item['name'],
				'id'          => $item['id'],
				'cssid'       => $item['cssid'],
				'children'    => $item['children'],
				'image'       => $item['image'],
				'view'        => $item['view'],
				'add'         => $item_add,
				'addurl'      => $item['addurl'],
				'href'        => $item['href'],
				'tlcolor'     => $item['tlcolor'],
				'tlstyle'     => $item['tlstyle'],
				'chtml'       => $item['chtml'],
				'dwidth'      => $dwidth,
				'iwidth'      => $item['iwidth'],
				'fbrands'     => $brandsinitem,
				'item_topimg' => $item_topimg,
				'cchtml'      => $cchtml
			);
		}
		
			 
		     /* in case the account flyout is enabled */
             $this->data['text_register'] = $this->language->get('text_register');
			 $this->data['text_forgotten'] = $this->language->get('text_forgotten');
			 $this->data['entry_email'] = $this->language->get('entry_email');
			 $this->data['entry_password'] = $this->language->get('entry_password');
			 $this->data['button_login'] = $this->language->get('button_login');
			 $this->data['actiond'] = $this->url->link('account/login', '', 'SSL');
			 $this->data['registerd'] = $this->url->link('account/register', '', 'SSL');
			 $this->data['forgottend'] = $this->url->link('account/forgotten', '', 'SSL');
			 $this->data['text_logout'] = $this->language->get('text_logout');
			 $this->data['text_account'] = $this->language->get('text_account');
			 $this->data['text_edit'] = $this->language->get('text_edit');
			 $this->data['text_password'] = $this->language->get('text_password');
			 $this->data['text_address'] = $this->language->get('text_address');
			 $this->data['text_wishlist'] = $this->language->get('text_wishlist');
			 $this->data['text_order'] = $this->language->get('text_order');
			 $this->data['text_download'] = $this->language->get('text_download');
			 $this->data['text_return'] = $this->language->get('text_return');
			 $this->data['text_transaction'] = $this->language->get('text_transaction');
			 $this->data['text_newsletter'] = $this->language->get('text_newsletter');
			 $this->data['text_recurring'] = $this->language->get('text_recurring');
			 $this->data['logged'] = $this->customer->isLogged();
			 $this->data['logout'] = $this->url->link('account/logout', '', 'SSL');
			 $this->data['forgotten'] = $this->url->link('account/forgotten', '', 'SSL');
			 $this->data['account'] = $this->url->link('account/account', '', 'SSL');
			 $this->data['edit'] = $this->url->link('account/edit', '', 'SSL');
			 $this->data['password'] = $this->url->link('account/password', '', 'SSL');
			 $this->data['address'] = $this->url->link('account/address', '', 'SSL');
			 $this->data['wishlist'] = $this->url->link('account/wishlist');
			 $this->data['order'] = $this->url->link('account/order', '', 'SSL');
			 $this->data['download'] = $this->url->link('account/download', '', 'SSL');
			 $this->data['return'] = $this->url->link('account/return', '', 'SSL');
			 $this->data['transaction'] = $this->url->link('account/transaction', '', 'SSL');
			 $this->data['newsletter'] = $this->url->link('account/newsletter', '', 'SSL');
			 $this->data['recurring'] = $this->url->link('account/recurring', '', 'SSL');
        
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/flyoutmenumodule.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/flyoutmenumodule.tpl';
		} else {
			$this->template = 'default/template/module/flyoutmenumodule.tpl';
		}
		
		$this->render();
  	}
    public function css() { 
		
        header("Content-Type: text/css");
		
		$menus = array();
		
        $output = '';
		
		$added_menus = $this->config->get('flyoutmenumodule_added_menus');
		
		foreach ($added_menus as $menu) {
			$menu_preffix = 'menu'.$menu.'_';
			if ($this->config->get($menu_preffix.'flyoutmenu_settings_status')) {
				$menus[] = array (
					'class' => ' .flyoutmenu_'.$menu,
					'flyout_settings' => $this->config->get($menu_preffix.'flyoutmenu_settings')
				);
			}
		}
		
		if ($this->config->get('flyoutmenu_settings_status')) {
			$menus[] = array (
				'class' => ' .flyoutmenu_default',
				'flyout_settings' => $this->config->get('flyoutmenu_settings')
			);
		}
		
        if ($menus) {
		 foreach ($menus as $menu) {
			 
			$flyout_settings = $menu['flyout_settings'];
			 
			$class = $menu['class'];
			 
            if ($flyout_settings['fontf']) {
                    $output .= $class.'.flyoutmenu.sho { font-family:'.$flyout_settings['fontf'].';}';
            }
            if ($flyout_settings['topfont']) {
                    $output .= $class.'.flyoutmenu.sho ul li a.tll { font-size:'.$flyout_settings['topfont'].';}';
            }
            if ($flyout_settings['dropfont']) {
                    $output .= $class.'.flyoutmenu.sho ul li div a { font-size:'.$flyout_settings['dropfont'].';}';
            }
            if ($flyout_settings['bg'] && $flyout_settings['bg2']) {
                    $output .= $class.'.flyoutmenu.sho { background-color:#'.str_replace('#','',$flyout_settings['bg']).';background-image: linear-gradient(to bottom, #'.str_replace('#','',$flyout_settings['bg']).', #'.str_replace('#','',$flyout_settings['bg2']).'); background-repeat: repeat-x; }';
            }
            if ($flyout_settings['bg'] && !$flyout_settings['bg2']) {
                    $output .= $class.'.flyoutmenu.sho { background:#'.str_replace('#','',$flyout_settings['bg']).';}';
            }
            if (!$flyout_settings['bg'] && $flyout_settings['bg2']) {
                    $output .= $class.'.flyoutmenu.sho { background:#'.str_replace('#','',$flyout_settings['bg2']).';}';
            }
            if ($flyout_settings['tmborderpx'] && $flyout_settings['tmborders'] && $flyout_settings['tmbordero'] && $flyout_settings['tmborderc']) {
                if ($flyout_settings['tmborderpx'] != 'default') {
                    if ($flyout_settings['tmbordero'] == 'all-around') {
                     $output .= $class.'.flyoutmenu.sho { border:none; border: '.str_replace('#','',$flyout_settings['tmborderpx']).' '.str_replace('#','',$flyout_settings['tmborders']).' #'.str_replace('#','',$flyout_settings['tmborderc']).';}';
                    } else {
                     $output .= $class.'.flyoutmenu.sho { border: none; border-'.$flyout_settings['tmbordero'].': '.str_replace('#','',$flyout_settings['tmborderpx']).' '.str_replace('#','',$flyout_settings['tmborders']).' #'.str_replace('#','',$flyout_settings['tmborderc']).';}';
                    }
                }
            }
            if ($flyout_settings['tlc']) {
                $output .= $class.'.flyoutmenu.sho ul li a.tll { color: #'.str_replace('#','',$flyout_settings['tlc']).'; }';
            }
            if ($flyout_settings['ttlc']) {
                $output .= $class.'.flyoutmenu.sho ul li.menu-title span.tll { color: #'.str_replace('#','',$flyout_settings['ttlc']).'; }';
            }
            if ($flyout_settings['tbc']) {
                $output .= $class.'.flyoutmenu.sho ul li a.tll { border-bottom: none !important; }'.$class.'.flyoutmenu.sho ul li a.tll,'.$class.'.flyoutmenu.sho ul li.menu-title span.tll { border-color: #'.str_replace('#','',$flyout_settings['tbc']).' !important; }';
            }
            if ($flyout_settings['tlch']) {
                $output .= $class.'.flyoutmenu.sho ul li.tlli:hover a.tll { color: #'.str_replace('#','',$flyout_settings['tlch']).'; }';
            }
            if ($flyout_settings['tlcts']) {
                $output .= $class.'.flyoutmenu.sho ul li.tlli a.tll { text-shadow: 0px 1px 1px #'.str_replace('#','',$flyout_settings['tlcts']).'; }';
            }
            if ($flyout_settings['tlchts']) {
                $output .= $class.'.flyoutmenu.sho ul li.tlli:hover a.tll { text-shadow: 0px 1px 1px #'.str_replace('#','',$flyout_settings['tlchts']).'; }';
            }
            if ($flyout_settings['tlb']) {
                $output .= $class.'.flyoutmenu.sho ul li.tlli:hover a.tll { background: #'.str_replace('#','',$flyout_settings['tlb']).'; }';
            }
            if ($flyout_settings['dbg']) {
                $output .= $class.'.flyoutmenu.sho ul li div.bigdiv { background: #'.str_replace('#','',$flyout_settings['dbg']).'; }';
            }
            if ($flyout_settings['fybg']) {
                $output .= $class.'.flyoutmenu.sho ul li div.bigdiv.withflyout > .withchildfo > .flyouttoright { background: #'.str_replace('#','',$flyout_settings['fybg']).'; }';
            }
            if ($flyout_settings['slborderpx'] && $flyout_settings['slborders'] && $flyout_settings['slbordero'] && $flyout_settings['slborderc']) {
                if ($flyout_settings['slborderpx'] != 'default') {
                    if ($flyout_settings['slbordero'] == 'all-around') {
                     $output .= $class.'.flyoutmenu.sho ul li div.bigdiv { border:none; border: '.str_replace('#','',$flyout_settings['slborderpx']).' '.str_replace('#','',$flyout_settings['slborders']).' #'.str_replace('#','',$flyout_settings['slborderc']).';}';
                    } else {
                     $output .= $class.'.flyoutmenu.sho ul li div.bigdiv { border: none; border-'.$flyout_settings['slbordero'].': '.str_replace('#','',$flyout_settings['slborderpx']).' '.str_replace('#','',$flyout_settings['slborders']).' #'.str_replace('#','',$flyout_settings['slborderc']).';}';
                    }
                }
            }
            if ($flyout_settings['dic']) {
                 $output .= $class.'.flyoutmenu.sho ul li div .withchild a.theparent,'.$class.'.flyoutmenu.sho ul li div .dropbrands ul li a,'.$class.'.flyoutmenu.sho ul li div .withimage .name a { color: #'.str_replace('#','',$flyout_settings['dic']).'; }';
            }
            if ($flyout_settings['dich']) {
                 $output .= $class.'.flyoutmenu.sho ul li div .withchild a.theparent:hover,'.$class.'.flyoutmenu.sho ul li div .dropbrands ul li a:hover,'.$class.'.flyoutmenu.sho ul li div .withimage .name a:hover { color: #'.str_replace('#','',$flyout_settings['dich']).'; }';
            }
            if ($flyout_settings['dib']) {
                 $output .= $class.'.flyoutmenu.sho ul li div .withchild a.theparent { background: #'.str_replace('#','',$flyout_settings['dib']).'; }';
            }
            if ($flyout_settings['dibh']) {
                 $output .= $class.'.flyoutmenu.sho ul li div .withchild a.theparent:hover { background: #'.str_replace('#','',$flyout_settings['dibh']).'; }';
            }
            if ($flyout_settings['diborderpx'] && $flyout_settings['diborders'] && $flyout_settings['dibordero'] && $flyout_settings['diborderc']) {
                if ($flyout_settings['diborderpx'] != 'default') {
                    if ($flyout_settings['dibordero'] == 'all-around') {
                     $output .= $class.'.flyoutmenu.sho ul li div .withchild a.theparent { border:none; border: '.str_replace('#','',$flyout_settings['diborderpx']).' '.str_replace('#','',$flyout_settings['diborders']).' #'.str_replace('#','',$flyout_settings['diborderc']).';}';
                    } else {
                     $output .= $class.'.flyoutmenu.sho ul li div .withchild a.theparent { border: none; border-'.$flyout_settings['dibordero'].': '.str_replace('#','',$flyout_settings['diborderpx']).' '.str_replace('#','',$flyout_settings['diborders']).' #'.str_replace('#','',$flyout_settings['diborderc']).';}';
                    }
                }
            }
            if ($flyout_settings['slc']) {
                 $output .= $class.'.flyoutmenu.sho ul li div .withchild ul.child-level li a,'.$class.'.flyoutmenu.sho ul li div .withimage .name ul a { color: #'.str_replace('#','',$flyout_settings['slc']).'; }';
            }
            if ($flyout_settings['slch']) {
                 $output .= $class.'.flyoutmenu.sho ul li div .withchild ul.child-level li a:hover,'.$class.'.flyoutmenu.sho ul li div .withimage .name ul a:hover { color: #'.str_replace('#','',$flyout_settings['slch']).'; }';
            }
            if ($flyout_settings['slb']) {
                 $output .= $class.'.flyoutmenu.sho  ul li div .withchild ul.child-level li a { background: #'.str_replace('#','',$flyout_settings['slb']).'; }';
            }
            if ($flyout_settings['slbh']) {
                 $output .= $class.'.flyoutmenu.sho  ul li div .withchild ul.child-level li a:hover { background: #'.str_replace('#','',$flyout_settings['slbh']).'; }';
            }
            if ($flyout_settings['flyic']) {
                 $output .= $class.'.flyoutmenu.sho .withchildfo > a.theparent { color: #'.str_replace('#','',$flyout_settings['flyic']).'; }';
            }
            if ($flyout_settings['flyich']) {
                 $output .= $class.'.flyoutmenu.sho .withchildfo > a.theparent:hover { color: #'.str_replace('#','',$flyout_settings['flyich']).'; }';
            }
            if ($flyout_settings['flyiborderpx'] && $flyout_settings['flyiborders'] && $flyout_settings['flyibordero'] && $flyout_settings['flyiborderc']) {
                if ($flyout_settings['flyiborderpx'] != 'default') {
                    if ($flyout_settings['flyibordero'] == 'all-around') {
                     $output .= $class.'.flyoutmenu.sho .withchildfo { border:none; border: '.str_replace('#','',$flyout_settings['flyiborderpx']).' '.str_replace('#','',$flyout_settings['flyiborders']).' #'.str_replace('#','',$flyout_settings['flyiborderc']).';}';
                    } else {
                     $output .= $class.'.flyoutmenu.sho .withchildfo { border: none; border-'.$flyout_settings['flyibordero'].': '.str_replace('#','',$flyout_settings['flyiborderpx']).' '.str_replace('#','',$flyout_settings['flyiborders']).' #'.str_replace('#','',$flyout_settings['flyiborderc']).';}';
                    }
                }
            }
            if ($flyout_settings['expbm']) {
                 $output .= $class.'.flyoutmenu.sho.respsmall .superdropper span,'.$class.'.flyoutmenu.sho.respsmall .withchildfo.hasflyout .superdropper span { background-color: #'.str_replace('#','',$flyout_settings['expbm']).'; }';
            }
            if ($flyout_settings['expbmc']) {
                 $output .= $class.'.flyoutmenu.sho.respsmall .superdropper span,'.$class.'.flyoutmenu.sho.respsmall .withchildfo.hasflyout .superdropper span { color: #'.str_replace('#','',$flyout_settings['expbmc']).'; }';
            }
            if ($flyout_settings['expbme']) {
                 $output .= $class.'.flyoutmenu.sho.respsmall .superdropper span + span,'.$class.'.flyoutmenu.sho.respsmall .withchildfo.hasflyout.exped .superdropper span + span { background-color: #'.str_replace('#','',$flyout_settings['expbme']).'; }';
            }
            if ($flyout_settings['expbmec']) {
                 $output .= $class.'.flyoutmenu.sho.respsmall .superdropper span + span,'.$class.'.flyoutmenu.sho.respsmall .withchildfo.hasflyout.exped .superdropper span + span { color: #'.str_replace('#','',$flyout_settings['expbmec']).'; }';
            }
            if ($flyout_settings['flyib']) {
                 $output .= $class.'.flyoutmenu.sho .withchildfo:hover { background: #'.str_replace('#','',$flyout_settings['flyib']).'; }';
            }
            if ($flyout_settings['drtc']) {
                 $output .= $class.'.flyoutmenu.sho ul li div.bigdiv .headingoftopitem h2 a,'.$class.'.flyoutmenu.sho ul li div.bigdiv .headingoftopitem h2,'.$class.'.flyoutmenu.sho ul li div .dropbrands span { color: #'.str_replace('#','',$flyout_settings['drtc']).'; }';
            }
            if ($flyout_settings['drtborderpx'] && $flyout_settings['drtborders'] && $flyout_settings['drtbordero'] && $flyout_settings['drtborderc']) {
                if ($flyout_settings['drtborderpx'] != 'default') {
                    if ($flyout_settings['drtbordero'] == 'all-around') {
                     $output .= $class.'.flyoutmenu.sho ul li div.bigdiv .headingoftopitem,'.$class.'.flyoutmenu.sho ul li div .dropbrands span { border:none; border: '.str_replace('#','',$flyout_settings['drtborderpx']).' '.str_replace('#','',$flyout_settings['drtborders']).' #'.str_replace('#','',$flyout_settings['drtborderc']).';}';
                    } else {
                     $output .= $class.'.flyoutmenu.sho ul li div.bigdiv .headingoftopitem,'.$class.'.flyoutmenu.sho ul li div .dropbrands span { border: none; border-'.$flyout_settings['drtbordero'].': '.str_replace('#','',$flyout_settings['drtborderpx']).' '.str_replace('#','',$flyout_settings['drtborders']).' #'.str_replace('#','',$flyout_settings['drtborderc']).';}';
                    }
                }
            }
            if ($flyout_settings['pricec']) {
                 $output .= $class.'.flyoutmenu.sho ul li div .withimage .dropprice { color: #'.str_replace('#','',$flyout_settings['pricec']).'; }';
            }
            if ($flyout_settings['pricech']) {
                 $output .= $class.'.flyoutmenu.sho ul li div .withimage .dropprice span { color: #'.str_replace('#','',$flyout_settings['pricech']).'; }';
            }
            if ($flyout_settings['valc']) {
                 $output .= $class.'.flyoutmenu.sho ul li div.bigdiv .linkoftopitem a { color: #'.str_replace('#','',$flyout_settings['valc']).';}';
            }
            if ($flyout_settings['valch']) {
                 $output .= $class.'.flyoutmenu.sho ul li div.bigdiv .linkoftopitem a:hover { color: #'.str_replace('#','',$flyout_settings['valch']).';}';
            }
            if ($flyout_settings['valb'] && $flyout_settings['valb2']) {
                $output .= $class.'.flyoutmenu.sho ul li div.bigdiv .linkoftopitem a { background-color: #'.str_replace('#','',$flyout_settings['valb']).';
                background-image: linear-gradient(to bottom, #'.str_replace('#','',$flyout_settings['valb']).', #'.str_replace('#','',$flyout_settings['valb2']).');
                background-repeat: repeat-x;
                }';
                $output .= $class.'.flyoutmenu.sho ul li div.bigdiv .linkoftopitem a:hover { background-color: #'.str_replace('#','',$flyout_settings['valb2']).';
                background-image: linear-gradient(to bottom, #'.str_replace('#','',$flyout_settings['valb2']).', #'.str_replace('#','',$flyout_settings['valb']).');
                background-repeat: repeat-x;
                }';
            }
            if ($flyout_settings['valb'] && !$flyout_settings['valb2']) {
                $output .= $class.'.flyoutmenu.sho ul li div.bigdiv .linkoftopitem a,'.$class.'.flyoutmenu.sho ul li div.bigdiv .linkoftopitem a:hover { background: #'.str_replace('#','',$flyout_settings['valb']).';}';
            }
            if (!$flyout_settings['valb'] && $flyout_settings['valb2']) {
                $output .= $class.'.flyoutmenu.sho ul li div.bigdiv .linkoftopitem a,'.$class.'.flyoutmenu.sho ul li div.bigdiv .linkoftopitem a:hover { background: #'.str_replace('#','',$flyout_settings['valb2']).';}';
            }
            if ($flyout_settings['valborderpx'] && $flyout_settings['valborders'] && $flyout_settings['valbordero'] && $flyout_settings['valborderc']) {
                if ($flyout_settings['valborderpx'] != 'default') {
                    if ($flyout_settings['valbordero'] == 'all-around') {
                     $output .= $class.'.flyoutmenu.sho ul li div.bigdiv .linkoftopitem a { border:none; border: '.str_replace('#','',$flyout_settings['valborderpx']).' '.str_replace('#','',$flyout_settings['valborders']).' #'.str_replace('#','',$flyout_settings['valborderc']).';}';
                    } else {
                     $output .= $class.'.flyoutmenu.sho ul li div.bigdiv .linkoftopitem a { border: none; border-'.$flyout_settings['valbordero'].': '.str_replace('#','',$flyout_settings['valborderpx']).' '.str_replace('#','',$flyout_settings['valborders']).' #'.str_replace('#','',$flyout_settings['valborderc']).';}';
                    }
                }
            }
		 }
        }
			
        echo $output;
    }
}
?>