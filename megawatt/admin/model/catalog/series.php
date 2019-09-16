<?php
class ModelCatalogSeries extends Model {

	public function addSeries($data) {
      	$this->db->query("INSERT INTO " . DB_PREFIX . "series SET name = '" . $this->db->escape($data['name']) . "', sort_order = '" . (int)$data['sort_order'] . "', manufacturer_id = '" . (int)$data['manufacturer'] . "'");
		
		$series_id = $this->db->getLastId();

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "series SET image = '" . $this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "' WHERE series_id = '" . (int)$series_id . "'");
		}
		
		foreach ($data['series_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "series_description SET series_id = '" . (int)$series_id . "', language_id = '" . (int)$language_id . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', description = '" . $this->db->escape($value['description']) . "', seo_title = '" . $this->db->escape($value['seo_title']) . "', seo_h1 = '" . $this->db->escape($value['seo_h1']) . "'");
		}
		
		if (isset($data['series_store'])) {
			foreach ($data['series_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "series_to_store SET series_id = '" . (int)$series_id . "', store_id = '" . (int)$store_id . "'");
			}
		}
				
		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'series_id=" . (int)$series_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}
		
		$this->cache->delete('series');
	}

	public function editSeries($series_id, $data) {
      	$this->db->query("UPDATE " . DB_PREFIX . "series SET name = '" . $this->db->escape($data['name']) . "', sort_order = '" . (int)$data['sort_order'] . "', manufacturer_id = '" . (int)$data['manufacturer'] . "' WHERE series_id = '" . (int)$series_id . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "series SET image = '" . $this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "' WHERE series_id = '" . (int)$series_id . "'");
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "series_description WHERE series_id = '" . (int)$series_id . "'");

		foreach ($data['series_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "series_description SET series_id = '" . (int)$series_id . "', language_id = '" . (int)$language_id . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', description = '" . $this->db->escape($value['description']) . "', seo_title = '" . $this->db->escape($value['seo_title']) . "', seo_h1 = '" . $this->db->escape($value['seo_h1']) . "'");
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "series_to_store WHERE series_id = '" . (int)$series_id . "'");

		if (isset($data['series_store'])) {
			foreach ($data['series_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "series_to_store SET series_id = '" . (int)$series_id . "', store_id = '" . (int)$store_id . "'");
			}
		}
			
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'series_id=" . (int)$series_id. "'");
		
		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'series_id=" . (int)$series_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}
		
		$this->cache->delete('series');
	}

	public function deleteSeries($series_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "series WHERE series_id = '" . (int)$series_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "series_description WHERE series_id = '" . (int)$series_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "series_to_store WHERE series_id = '" . (int)$series_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'series_id=" . (int)$series_id . "'");
			
		$this->cache->delete('series');
	}

	public function getSeriesStores($series_id) {
		$series_store_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "series_to_store WHERE series_id = '" . (int)$series_id . "'");

		foreach ($query->rows as $result) {
			$series_store_data[] = $result['store_id'];
		}
		
		return $series_store_data;
	}

	public function getSeriesDescriptions($series_id) {
		$series_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "series_description WHERE series_id = '" . (int)$series_id . "'");
		
		foreach ($query->rows as $result) {
			$series_description_data[$result['language_id']] = array(
				'seo_title'        => $result['seo_title'],
				'seo_h1'           => $result['seo_h1'],
				'meta_keyword'     => $result['meta_keyword'],
				'meta_description' => $result['meta_description'],
				'description'      => $result['description']
			);
		}
		
		return $series_description_data;
	}	

	public function getSeriesOnce($series_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'series_id=" . (int)$series_id . "') AS keyword FROM " . DB_PREFIX . "series WHERE series_id = '" . (int)$series_id . "'");
		
		return $query->row;
	}

	public function getTotalSeries() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "series");
		
		return $query->row['total'];
	}

	public function getSeries($data = array()) {
			$sql = "SELECT s.*, m.name manufacturer FROM " . DB_PREFIX . "series s LEFT JOIN " . DB_PREFIX . "manufacturer m ON s.manufacturer_id = m.manufacturer_id";
			
			$sort_data = array(
				'name',
				'manufacturer',
				'sort_order'
			);	
			
			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];	
			} else {
				$sql .= " ORDER BY name";	
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

				if ($data['limit'] < 1) {
					$data['limit'] = 20;
				}	
			
				$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
			}				
			
			$query = $this->db->query($sql);
		
			return $query->rows;
	}

	public function getTotalSeriesByManufacturerId($manufacturer_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "series WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");

		return $query->row['total'];
	}

	public function getSeriesByManufacturerId($manufacturer_id) {
		$series_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "series WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");
		
		foreach ($query->rows as $result) {
			$series_data[] = array(
				'series_id' => $result['series_id'],
				'name'		=> $result['name']
			);
		}
		
		return $series_data;
	}

	public function checkSeries() {
		$this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "series (series_id int(11) NOT NULL AUTO_INCREMENT, name varchar(64) NOT NULL DEFAULT '', image varchar(255) DEFAULT NULL, sort_order int(3) NOT NULL, date_modified datetime NOT NULL DEFAULT '0000-00-00 00:00:00', manufacturer_id int(11) DEFAULT NULL, PRIMARY KEY (series_id)) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1");
		
		$this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "series_description (series_id int(11) NOT NULL DEFAULT '0', language_id int(11) NOT NULL DEFAULT '0', description text NOT NULL, meta_description varchar(255) NOT NULL, meta_keyword varchar(255) NOT NULL, seo_title varchar(255) NOT NULL, seo_h1 varchar(255) NOT NULL, PRIMARY KEY (series_id, language_id)) ENGINE=MyISAM DEFAULT CHARSET=utf8");
		
		$this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "series_to_store (series_id int(11) NOT NULL, store_id int(11) NOT NULL, PRIMARY KEY (series_id, store_id)) ENGINE=MyISAM DEFAULT CHARSET=utf8");
		
		$this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "product_to_series (product_id int(11) NOT NULL, series_id int(11) NOT NULL DEFAULT '0', PRIMARY KEY (product_id, series_id)) ENGINE=MyISAM DEFAULT CHARSET=utf8");

		return true;

	}	
	
}
?>