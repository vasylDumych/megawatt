<?php
class ModelCatalogManufacturer extends Model {
	public function getManufacturer($manufacturer_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "manufacturer m LEFT JOIN " . DB_PREFIX . "manufacturer_to_store m2s ON (m.manufacturer_id = m2s.manufacturer_id) WHERE m.manufacturer_id = '" . (int)$manufacturer_id . "' AND m2s.store_id = '" . (int)$this->config->get('config_store_id') . "'");
	
		return $query->row;	
	}

    public function getMinPriceFromManufacturer($manufacturer_id) {
        $sql = 'SELECT LEAST(p.price,IFNULL(ps.price, p.price)) min_price
                FROM '.DB_PREFIX.'product p               
                LEFT JOIN '.DB_PREFIX.'product_special ps ON p.product_id = ps.product_id               
                WHERE p.manufacturer_id = '.$manufacturer_id.' AND p.status = 1 AND p.price > 0
                ORDER BY min_price
                LIMIT 0,1';
        $query = $this->db->query($sql);
        $price = $query->row['min_price'];

        if ($price != null) {
            return $price;
        }

        return 0;
    }

    public function getMinPriceFromSeries($series_id) {
        $sql = 'SELECT LEAST(p.price,IFNULL(ps.price, p.price)) min_price   
                FROM '.DB_PREFIX.'product_to_series pts
                LEFT JOIN '.DB_PREFIX.'product p ON '.DB_PREFIX.'p.product_id = ' . DB_PREFIX . 'pts.product_id    
                LEFT JOIN '.DB_PREFIX.'product_special ps ON p.product_id = ps.product_id               
                WHERE ' . DB_PREFIX .'pts.series_id = '.(int)$series_id.' AND p.status = 1 AND p.price > 0
                ORDER BY min_price
                LIMIT 0,1';
        $query = $this->db->query($sql);
        $price = $query->row['min_price'];

        if ($price != null) {
            return $price;
        }

        return 0;
    }
	
	public function getSeriesOncesmenu($series_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "series s INNER JOIN " . DB_PREFIX . "series_description sd ON s.series_id = sd.series_id LEFT JOIN " . DB_PREFIX . "series_to_store s2s ON (s.series_id = s2s.series_id) WHERE s.series_id = '" . (int)$series_id . "' AND sd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND s2s.store_id = '" . (int)$this->config->get('config_store_id') . "'");
		
		return $query->row;
	}
	
	public function getManufacturers($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "manufacturer m LEFT JOIN " . DB_PREFIX . "manufacturer_to_store m2s ON (m.manufacturer_id = m2s.manufacturer_id) WHERE m2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";
			
			$sort_data = array(
				'name',
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
		} else {
			$manufacturer_data = $this->cache->get('manufacturer.' . (int)$this->config->get('config_store_id'));
		
			if (!$manufacturer_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "manufacturer m LEFT JOIN " . DB_PREFIX . "manufacturer_to_store m2s ON (m.manufacturer_id = m2s.manufacturer_id) WHERE m2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY name");
	
				$manufacturer_data = $query->rows;
			
				$this->cache->set('manufacturer.' . (int)$this->config->get('config_store_id'), $manufacturer_data);
			}

			return $manufacturer_data;
		}	
	} 
}
?>