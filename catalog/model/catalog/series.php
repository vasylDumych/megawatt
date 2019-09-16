<?php
class ModelCatalogSeries extends Model {

	public function getSeriesOnce($series_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "series s INNER JOIN " . DB_PREFIX . "series_description sd ON s.series_id = sd.series_id LEFT JOIN " . DB_PREFIX . "series_to_store s2s ON (s.series_id = s2s.series_id) WHERE s.series_id = '" . (int)$series_id . "' AND sd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND s2s.store_id = '" . (int)$this->config->get('config_store_id') . "'");

		return $query->row;
	}

	public function getProductSeries($product_id) {
		$query = $this->db->query("SELECT s.series_id, s.name FROM " . DB_PREFIX . "series s INNER JOIN " . DB_PREFIX . "product_to_series pts ON s.series_id = pts.series_id WHERE pts.product_id = '" . (int)$product_id . "'");
		
		return $query->row;
	}

	public function getSeriesByManufacturerId($manufacturer_id) {
		$series_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "series s INNER JOIN " . DB_PREFIX . "product_to_series pts ON s.series_id = pts.series_id INNER JOIN " . DB_PREFIX . "series_to_store s2s ON s.series_id = s2s.series_id WHERE manufacturer_id = '" . (int)$manufacturer_id . "' AND s2s.store_id = '" . (int)$this->config->get('config_store_id') . "' GROUP BY s.series_id ORDER BY s.sort_order");
		
		foreach ($query->rows as $result) {
			$series_data[] = array(
				'series_id' => $result['series_id'],
				'image'		=> $result['image'],
				'name'		=> $result['name']
			);
		}
		
		return $series_data;
	}	
	
}
?>