<?php
class ModelDesignCoinSlider extends Model {	
	public function getSlider($slider_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "coin_slider_image bi LEFT JOIN " . DB_PREFIX . "coin_slider_image_description bid ON (bi.coin_slider_image_id  = bid.coin_slider_image_id) WHERE bi.coin_slider_id = '" . (int)$slider_id . "' AND bid.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY bi.sort_order ASC");
		
		return $query->rows;
	}

	public function getSliderConfig($slider_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "coin_slider WHERE coin_slider_id = '" . (int)$slider_id . "' LIMIT 1");
		
		return $query->rows;
	}
}
?>
