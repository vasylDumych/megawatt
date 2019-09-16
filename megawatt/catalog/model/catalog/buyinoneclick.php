<?php
class ModelCatalogBuyinoneclick extends Model {

	public function addOrder($data) {
		$this->db->query("INSERT INTO `" . DB_PREFIX . "order` SET telephone = '" . $this->db->escape($data['contact']) . "', firstname = '" . $data['name'] . "', total = '" . (float) $data['total'] . "', date_added = NOW(), currency_id = '" . (int) $data['currency_id'] . "', currency_code = '" . $this->db->escape($data['currency_code']) . "', currency_value = '" . (float) $this->db->escape($data['currency_value']) . "', comment='Купить в один клик', order_status_id='18'");
		$order_id = $this->db->getLastId();
		$this->db->query("INSERT INTO " . DB_PREFIX . "order_product SET order_id = '" . $order_id . "', price = '" . (float) $data['price'] . "', quantity = '" . (int) $data['quantity'] . "', total = '" . (float) $data['total'] . "', name = '" . $this->db->escape($data['product_name']) . "', product_id = '" . $this->db->escape($data['product_id']) . "'");
		
		$this->db->query("UPDATE " . DB_PREFIX . "product SET quantity = (quantity - 1) WHERE product_id = '" . (int) $data['product_id'] . "' AND subtract = '1'");

		return $order_id;
	}

}

?>