<?php 
class ModelSaleOrderpro extends Model {
public function editOrder($data) {if ($this->checkLicensee()) {$this->load->model('setting/store');$store_info = $this->model_setting_store->getStore($data['store_id']);$pops = json_decode(urldecode($data['order_products']), true);if (count($pops) > 0) {foreach ($pops as $pop) {if (!isset($pop['option'])) {$pop['option'] = array();}
$this->addToStock($pop['product_id'], $pop['quantity'], $pop['order_option']);}}if (isset($data['order_product'])) {foreach ($data['order_product'] as $pop) {if (!isset($pop['option'])) {$pop['option'] = array();}$this->substractFromStock($pop['product_id'], $pop['quantity'], $pop['option']);
}  
}
if ($store_info) {$store_name = $store_info['name'];$store_url = $store_info['url'];} else {$store_name = $this->config->get('config_name');$store_url = HTTP_CATALOG;}$invoice_prefix = $this->config->get('config_invoice_prefix');
$this->load->model('localisation/country');$this->load->model('localisation/zone');$country_info = $this->model_localisation_country->getCountry($data['shipping_country_id']);if ($country_info) {$shipping_country = $country_info['name'];$data['shipping_country'] = $shipping_country;$fsa = $country_info['address_format'];
$data['shipping_address_format'] = $fsa;} else {$country_info = $this->model_localisation_country->getCountry($this->config->get('config_country_id'));if ($country_info) {$shipping_country = $country_info['name'];$data['shipping_country'] = $country_info['name'];$data['shipping_country_id'] = $this->config->get('config_country_id');
$fsa = $country_info['address_format'];$data['shipping_address_format'] = $fsa;} else {$shipping_country = '';$data['shipping_country'] = $shipping_country;$data['shipping_country_id'] = $this->config->get('config_country_id');$fsa = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
$data['shipping_address_format'] = $fsa;
}
}
$zone_info = $this->model_localisation_zone->getZone($data['shipping_zone_id']);
if ($zone_info) {
$shipping_zone = $zone_info['name'];$data['shipping_zone'] = $shipping_zone;$data['shipping_zone_code'] = $zone_info['code'];} else {$zone_info = $this->model_localisation_zone->getZone($this->config->get('config_zone_id'));if ($zone_info) {
$shipping_zone = $zone_info['name'];
$data['shipping_zone'] = $zone_info['name'];$data['shipping_zone_id'] = $zone_info['zone_id'];$data['shipping_zone_code'] = $zone_info['code'];}  else {$shipping_zone = '';$data['shipping_zone'] = '';
$data['shipping_zone_id'] = $this->config->get('config_zone_id');$data['shipping_zone_code'] = '';}	}$paycountry_info = $this->model_localisation_country->getCountry($data['payment_country_id']);if ($paycountry_info) {$payment_country = $paycountry_info['name'];$data['payment_country'] = $payment_country;$payment_address_format = $paycountry_info['address_format'];
$data['payment_address_format'] = $payment_address_format;} else {$paycountry_info = $this->model_localisation_country->getCountry($this->config->get('config_country_id'));
if ($paycountry_info) {$payment_country = $paycountry_info['name'];$data['payment_country'] = $paycountry_info['name'];$data['payment_country_id'] = $this->config->get('config_country_id');
$payment_address_format = $paycountry_info['address_format'];$data['payment_address_format'] = $payment_address_format;} else {$payment_country = '';$data['payment_country'] = $payment_country;$payment_address_format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';					
$data['payment_address_format'] = $payment_address_format;}}$payzone_info = $this->model_localisation_zone->getZone($data['payment_zone_id']);if ($payzone_info) {
$payment_zone = $payzone_info['name'];$data['payment_zone'] = $payment_zone;$data['payment_zone_code'] = $payzone_info['code'];} else {$payzone_info = $this->model_localisation_zone->getZone($this->config->get('config_zone_id'));if ($payzone_info) {$payment_zone = $payzone_info['name'];$data['payment_zone'] = $payzone_info['name'];$data['payment_zone_id'] = $payzone_info['zone_id'];$data['payment_zone_code'] = $payzone_info['code'];
} else {$payment_zone = '';$data['payment_zone'] = '';$data['payment_zone_code'] = '';}}$this->load->model('localisation/currency');if (isset($data['currency_code'])) {$currency_info = $this->model_localisation_currency->getCurrencyByCode($data['currency_code']);
$currency_id = $currency_info['currency_id'];$currency_code = $currency_info['code'];$currency_value = $currency_info['value'];} elseif ($currency_info = $this->model_localisation_currency->getCurrencyByCode($this->config->get('config_currency'))) {
$currency_id = $currency_info['currency_id'];$currency_code = $currency_info['code'];$currency_value = $currency_info['value'];} else {$currency_id = 0;$currency_code = $this->config->get('config_currency');$currency_value = 1.00000;}$data['currency_id'] = $currency_id;$data['currency_code'] = $currency_code;$data['currency_value'] = $currency_value;
$this->load->model('localisation/language');$languages = $this->model_localisation_language->getLanguages();foreach ($languages as $language) {if ($language['code'] == $data['language']) {$data['lang_dir'] = DIR_CATALOG . 'language/' . $language['directory'] . '/';$language_id = $language['language_id'];
}}$data['payment_token'] = $data['payment_method'];if (isset($data['payment_method'])) {$data['payment_code'] = $data['payment_method'];} else {$data['payment_code'] = '';}$file = $data['lang_dir'] . 'payment/' . $data['payment_method'] . '.php';if (file_exists($file)) {require($file);$data['payment_method'] = $_['text_title'];}if (isset($data['clone']) && !empty($data['clone'])) {$keep_order_id = '';} else {if (isset($this->request->get['order_id']) && !empty($this->request->get['order_id'])) {
$keep_order_id = " order_id ='" . $this->request->get['order_id'] . "',";$this->db->query("DELETE FROM `" . DB_PREFIX . "order` WHERE order_id = '" . (int)$this->request->get['order_id'] . "'");
$this->db->query("DELETE FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$this->request->get['order_id'] . "'");$this->db->query("DELETE FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$this->request->get['order_id'] . "'");
$this->db->query("DELETE FROM " . DB_PREFIX . "order_total WHERE order_id = '" . (int)$this->request->get['order_id'] . "'");$this->db->query("DELETE FROM " . DB_PREFIX . "order_download WHERE order_id = '" . (int)$this->request->get['order_id'] . "'");
} else {$keep_order_id = '';}}if (!empty($data['date_added'])) {$date_added = "'" . $data['date_added'] . "'";} else {$data['date_added'] = date('Y-m-d H:i:s', time());
$date_added = 'NOW()';}$data['date_modified'] = date('Y-m-d H:i:s', time());$order_status_id = $data['order_status_id'];if (isset($data['affiliate_id'])) {
$affiliate_id = $data['affiliate_id'];
} else {
$affiliate_id = 0;
}

if (isset($data['commission'])) {
$commission = $data['commission'];
} else {
$commission = 0;
}
if (isset($data['shipping_method'])) {$data['shipping_code'] = $data['shipping_method'] . '.' . $data['shipping_method'];} else {$data['shipping_code'] = '';}if (isset($data['order_total'])) {
foreach ($data['order_total'] as $order_total) {if ($order_total['code'] == 'shipping') {$shipping_set = true;$data['shipping_method'] = $order_total['title'];}}}if (!isset($shipping_set)) {
$file = $data['lang_dir'] . 'shipping/' . $data['shipping_method'] . '.php';if (file_exists($file)) {require($file);if (isset($_['text_title'])) {$data['shipping_method'] = $_['text_title'];
}}}$this->db->query("INSERT INTO `" . DB_PREFIX . "order` SET " . $keep_order_id . " invoice_prefix = '" . $this->db->escape($invoice_prefix) . "', invoice_no = '" . $this->db->escape($data['invoice_no']) . "', store_id = '" . (int)$data['store_id'] . "', store_name = '" . $this->db->escape($store_name) . "',
store_url = '" . $this->db->escape($store_url) . "', customer_id = '" . (int)$data['customer_id'] . "', customer_group_id = '" . (int)$data['customer_group_id'] . "', firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', 
email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', fax = '" . $this->db->escape($data['fax']) . "', shipping_firstname = '" . $this->db->escape($data['shipping_firstname']) . "', 
shipping_lastname = '" . $this->db->escape($data['shipping_lastname']) . "', shipping_company = '" . $this->db->escape($data['shipping_company']) . "', shipping_address_1 = '" . $this->db->escape($data['shipping_address_1']) . "', shipping_address_2 = '" . $this->db->escape($data['shipping_address_2']) . "', 
shipping_city = '" . $this->db->escape($data['shipping_city']) . "', shipping_postcode = '" . $this->db->escape($data['shipping_postcode']) . "', shipping_country = '" . $this->db->escape($shipping_country) . "', 
shipping_country_id = '" . (int)$data['shipping_country_id'] . "', shipping_zone = '" . $this->db->escape($shipping_zone) . "', shipping_zone_id = '" . (int)$data['shipping_zone_id'] . "', 
shipping_address_format = '" . $this->db->escape($fsa) . "', shipping_method = '" . $this->db->escape($data['shipping_method']) . "', shipping_code = '" . $this->db->escape($data['shipping_code']) . "', 
payment_firstname = '" . $this->db->escape($data['payment_firstname']) . "', payment_lastname = '" . $this->db->escape($data['payment_lastname']) . "', payment_company = '" . $this->db->escape($data['payment_company']) . "', 
payment_company_id = '" . $this->db->escape($data['payment_company_id']) . "', payment_tax_id = '" . $this->db->escape($data['payment_tax_id']) . "', payment_address_1 = '" . $this->db->escape($data['payment_address_1']) . "', payment_address_2 = '" . $this->db->escape($data['payment_address_2']) . "', 
payment_city = '" . $this->db->escape($data['payment_city']) . "', payment_postcode = '" . $this->db->escape($data['payment_postcode']) . "', payment_country = '" . $this->db->escape($payment_country) . "', payment_country_id = '" . (int)$data['payment_country_id'] . "', 
payment_zone = '" . $this->db->escape($payment_zone) . "', payment_zone_id = '" . (int)$data['payment_zone_id'] . "', payment_address_format = '" . $this->db->escape($payment_address_format) . "', payment_method = '" . $this->db->escape($data['payment_method']) . "', 
payment_code = '" . $this->db->escape($data['payment_code']) . "', comment = '" . $this->db->escape($data['comment']) . "', order_status_id = '" . (int)$order_status_id . "', affiliate_id  = '" . (int)$affiliate_id . "', commission  = '" . (float)$commission . "', 
language_id = '" . (int)$language_id . "', currency_id = '" . (int)$currency_id . "', currency_code = '" . $this->db->escape($currency_code) . "', 
currency_value = '" . (float)$currency_value . "', date_added = " . $date_added . ", date_modified = '" . $data['date_modified'] . "'");$this->language->load('sale/orderpro');if (!empty($keep_order_id)) {$iio = $this->request->get['order_id'];
} else {$iio = $this->db->getLastId();$this->db->query("UPDATE " . DB_PREFIX . "customer_reward SET order_id = '" . (int)$iio . "', description = '" . $this->db->escape($this->language->get('text_order_id') . ' № ' . $iio) . "' WHERE order_id = '" . (int)$data['temp_order_id'] . "'");
$this->db->query("UPDATE " . DB_PREFIX . "affiliate_transaction SET order_id = '" . (int)$iio . "' WHERE order_id = '" . (int)$data['temp_order_id'] . "'");
$this->db->query("UPDATE " . DB_PREFIX . "customer_transaction SET order_id = '" . (int)$iio . "' WHERE order_id = '" . (int)$data['temp_order_id'] . "'");
$this->db->query("UPDATE " . DB_PREFIX . "coupon_history SET order_id = '" . (int)$iio . "' WHERE order_id = '" . (int)$data['temp_order_id'] . "'");$this->db->query("UPDATE " . DB_PREFIX . "voucher_history SET order_id = '" . (int)$iio . "' WHERE order_id = '" . (int)$data['temp_order_id'] . "'");
$this->db->query("UPDATE " . DB_PREFIX . "order_history SET order_id = '" . (int)$iio . "' WHERE order_id = '" . (int)$data['temp_order_id'] . "'");}if (empty($data['coupon_id'])) {$this->db->query("DELETE FROM " . DB_PREFIX . "coupon_history WHERE order_id = '" . (int)$iio . "'");} else {if (empty($keep_order_id)) {
$this->db->query("UPDATE " . DB_PREFIX . "coupon_history SET order_id = '" . (int)$iio . "' WHERE order_id = '" . (int)$data['temp_order_id'] . "'");}}if (empty($data['voucher_id'])) {
$this->db->query("DELETE FROM " . DB_PREFIX . "voucher_history WHERE order_id = '" . (int)$iio . "'");} else {if (empty($keep_order_id)) {$this->db->query("UPDATE " . DB_PREFIX . "voucher_history SET order_id = '" . (int)$iio . "' WHERE order_id = '" . (int)$data['temp_order_id'] . "'");
}
}
if (isset($data['order_product'])) {
foreach ($data['order_product'] as $pop) {if (($pop['product_id'] > 0) && ($pop['quantity'] > 0)) {$this->db->query("INSERT INTO " . DB_PREFIX . "order_product SET order_id = '" . (int)$iio . "', product_id = '" . (int)$pop['product_id'] . "', name = '" . $this->db->escape($pop['name']) . "', model = '" . $this->db->escape($pop['model']) . "', sku = '" . $this->db->escape($pop['sku']) . "', upc = '" . $this->db->escape($pop['upc']) . "', ean = '" . $this->db->escape($pop['ean']) . "', jan = '" . $this->db->escape($pop['jan']) . "', isbn = '" . $this->db->escape($pop['isbn']) . "', mpn = '" . $this->db->escape($pop['mpn']) . "', location = '" . $this->db->escape($pop['location']) . "', quantity = '" . (int)$pop['quantity'] . "', price = '" . (float)$pop['price'] . "', discount_amount = '" . (float)$pop['discount_amount'] . "', discount_type = '" . $this->db->escape($pop['discount_type']) . "', total = '" . (float)$pop['total'] . "', tax = '" . (float)$pop['tax'] . "', reward = '" . (int)$pop['reward'] . "'");

$pop_id = $this->db->getLastId();
$download_data = array();     		
$download_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_download p2d LEFT JOIN " . DB_PREFIX . "download d ON (p2d.download_id = d.download_id) LEFT JOIN " . DB_PREFIX . "download_description dd ON (d.download_id = dd.download_id) WHERE p2d.product_id = '" . (int)$pop['product_id'] . "' AND dd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
foreach ($download_query->rows as $download) {$this->db->query("INSERT INTO " . DB_PREFIX . "order_download SET order_id = '" . (int)$iio . "', order_product_id = '" . (int)$pop_id . "', name = '" . $this->db->escape($download['name']) . "', filename = '" . $this->db->escape($download['filename']) . "', mask = '" . $this->db->escape($download['mask']) . "', remaining = '" . (int)($download['remaining'] * $pop['quantity']) . "'");
}$this->load->model('catalog/product');$all_options = $this->model_catalog_product->getProductOptions($pop['product_id']);if (isset($pop['option'])) {foreach ($pop['option'] as $pfo => $order_option) {$values = array();
$value = '';foreach ($all_options as $this_option) {if ($this_option['product_option_id'] == $pfo) {$name = $this_option['name'];$type = $this_option['type'];if (isset($this_option['product_option_value']) && !empty($this_option['product_option_value'])) {foreach ($this_option['product_option_value'] as $this_option_value) {if ($type != 'checkbox' && ($this_option_value['product_option_value_id'] == $order_option)) {
$value = $this_option_value['name'];} elseif ($type == 'checkbox' && in_array($this_option_value['product_option_value_id'], $order_option)) {$values[] = array(
'value' => $this_option_value['name'],'product_option_value_id' => $this_option_value['product_option_value_id']);}}} else {$value = $order_option;$order_option = '0';
}if ((count($values) < 1) && (empty($value))) {continue 2;}break;}}if ($type != 'checkbox') {$this->db->query("INSERT INTO " . DB_PREFIX . "order_option SET order_id = '" . (int)$iio . "', order_product_id = '" . (int)$pop_id . "', product_option_id = '" . (int)$pfo . "', product_option_value_id = '" . (int)$order_option . "', name = '" . $this->db->escape($name) . "', `value` = '" . $this->db->escape($value) . "', `type` = '" . $this->db->escape($type) . "'");
} else {foreach ($values as $option_value) {$this->db->query("INSERT INTO " . DB_PREFIX . "order_option SET order_id = '" . (int)$iio . "', order_product_id = '" . (int)$pop_id . "', product_option_id = '" . (int)$pfo . "', product_option_value_id = '" . (int)$option_value['product_option_value_id'] . "', name = '" . $this->db->escape($name) . "', `value` = '" . $this->db->escape($option_value['value']) . "', `type` = '" . $this->db->escape($type) . "'");
}
}
}}}}} else {
$data['order_product'] = array();}$total = 0;if (isset($data['order_total'])) {foreach ($data['order_total'] as $order_total) {	$this->db->query("INSERT INTO " . DB_PREFIX . "order_total SET order_id = '" . (int)$iio . "', code = '" . $this->db->escape($order_total['code']) . "', title = '" . $this->db->escape($order_total['title']) . "', text = '" . $this->db->escape($order_total['text']) . "', `value` = '" . (float)$order_total['value'] . "', sort_order = '" . (int)$order_total['sort_order'] . "'");
if ($order_total['code'] != 'discount') {
$total += $order_total['value'];}
if ($order_total['code'] == 'total') {
$total_set = (float)$order_total['value'];}
}

if (isset($total_set)) {$total = $total_set;}$this->db->query("UPDATE `" . DB_PREFIX . "order` SET total = '" . (float)$total . "' WHERE order_id = '" . (int)$iio . "'");} else {
$data['order_total'] = array();}
}
}
private function addToStock ($product_id = '', $quantity = '', $product_option_values = '') {if ($this->user->hasPermission('modify', 'sale/orderpro')) {
$this->db->query("UPDATE `" . DB_PREFIX . "product` SET quantity = (quantity + " . (int)$quantity . ") WHERE product_id = '" . (int)$product_id . "' AND subtract = '1'");
foreach ($product_option_values as $option) {$this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET quantity = (quantity + " . (int)$quantity . ") WHERE product_option_value_id = '" . (int)$option . "' AND subtract = '1'");
}
}
}
private function substractFromStock ($product_id = '', $quantity = '', $product_option_values = '') {
if ($this->user->hasPermission('modify', 'sale/orderpro')) {
$this->db->query("UPDATE `" . DB_PREFIX . "product` SET quantity = (quantity - " . (int)$quantity . ") WHERE product_id = '" . (int)$product_id . "' AND subtract = '1'");
foreach ($product_option_values as $option) {$this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET quantity = (quantity - " . (int)$quantity . ") WHERE product_option_value_id = '" . (int)$option . "' AND subtract = '1'");
}}}public function deleteOrder($iio) {if ($this->checkLicensee()) {$order_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order` WHERE order_status_id > '0' AND order_id = '" . (int)$iio . "'");if ($order_query->num_rows) {$product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$iio . "'");foreach($product_query->rows as $product) {
$this->db->query("UPDATE `" . DB_PREFIX . "product` SET quantity = (quantity + " . (int)$product['quantity'] . ") WHERE product_id = '" . (int)$product['product_id'] . "' AND subtract = '1'");
$option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$iio . "' AND order_product_id = '" . (int)$product['order_product_id'] . "'");
foreach ($option_query->rows as $option) {$this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET quantity = (quantity + " . (int)$product['quantity'] . ") WHERE product_option_value_id = '" . (int)$option['product_option_value_id'] . "' AND subtract = '1'");
}
}}$this->db->query("DELETE FROM `" . DB_PREFIX . "order` WHERE order_id = '" . (int)$iio . "'");$this->db->query("DELETE FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$iio . "'");$this->db->query("DELETE FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$iio . "'");
$this->db->query("DELETE FROM " . DB_PREFIX . "order_download WHERE order_id = '" . (int)$iio . "'");$this->db->query("DELETE FROM " . DB_PREFIX . "order_voucher WHERE order_id = '" . (int)$iio . "'");
$this->db->query("DELETE FROM " . DB_PREFIX . "order_total WHERE order_id = '" . (int)$iio . "'");$this->db->query("DELETE FROM " . DB_PREFIX . "order_history WHERE order_id = '" . (int)$iio . "'");
$this->db->query("DELETE FROM " . DB_PREFIX . "order_fraud WHERE order_id = '" . (int)$iio . "'");$this->db->query("DELETE FROM " . DB_PREFIX . "customer_transaction WHERE order_id = '" . (int)$iio . "'");
$this->db->query("DELETE FROM " . DB_PREFIX . "customer_reward WHERE order_id = '" . (int)$iio . "'");$this->db->query("DELETE FROM " . DB_PREFIX . "affiliate_transaction WHERE order_id = '" . (int)$iio . "'");
}}public function getOrder($iio) {$order_query = $this->db->query("SELECT *, (SELECT CONCAT(c.firstname, ' ', c.lastname) FROM " . DB_PREFIX . "customer c WHERE c.customer_id = o.customer_id) AS customer FROM `" . DB_PREFIX . "order` o WHERE o.order_id = '" . (int)$iio . "'");
if ($order_query->num_rows) {$reward = 0;

$pop_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$iio . "'");foreach ($pop_query->rows as $product) {
$reward += $product['reward'];}			$country_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "country` WHERE country_id = '" . (int)$order_query->row['payment_country_id'] . "'");
if ($country_query->num_rows) {
$payment_iso_code_2 = $country_query->row['iso_code_2'];$payment_iso_code_3 = $country_query->row['iso_code_3'];
} else {$payment_iso_code_2 = '';
$payment_iso_code_3 = '';
}
$zone_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "zone` WHERE zone_id = '" . (int)$order_query->row['payment_zone_id'] . "'");if ($zone_query->num_rows) {
$payment_zone_code = $zone_query->row['code'];
} else {
$payment_zone_code = '';
}

$country_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "country` WHERE country_id = '" . (int)$order_query->row['shipping_country_id'] . "'");
if ($country_query->num_rows) {$shipping_iso_code_2 = $country_query->row['iso_code_2'];$shipping_iso_code_3 = $country_query->row['iso_code_3'];} else {
$shipping_iso_code_2 = '';$shipping_iso_code_3 = '';}$zone_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "zone` WHERE zone_id = '" . (int)$order_query->row['shipping_zone_id'] . "'");
if ($zone_query->num_rows) {$shipping_zone_code = $zone_query->row['code'];} else {$shipping_zone_code = '';
}

if ($order_query->row['affiliate_id']) {
$affiliate_id = $order_query->row['affiliate_id'];} else {$affiliate_id = 0;}$this->load->model('sale/affiliate');$affiliate_info = $this->model_sale_affiliate->getAffiliate($affiliate_id);

if ($affiliate_info) {$affiliate_firstname = $affiliate_info['firstname'];$affiliate_lastname = $affiliate_info['lastname'];
} else {$affiliate_firstname = '';$affiliate_lastname = '';				
}
$this->load->model('localisation/language');

$language_info = $this->model_localisation_language->getLanguage($order_query->row['language_id']);

if ($language_info) {
$language_code = $language_info['code'];$language_filename = $language_info['filename'];$language_directory = $language_info['directory'];} else {$language_code = '';
$language_filename = '';$language_directory = '';}

return array(
'order_id'  => $order_query->row['order_id'],'invoice_no'  => $order_query->row['invoice_no'],'invoice_prefix'   => $order_query->row['invoice_prefix'],'store_id'  => $order_query->row['store_id'],'store_name'  => $order_query->row['store_name'],
'store_url' => $order_query->row['store_url'],'customer_id' => $order_query->row['customer_id'],'customer'  => $order_query->row['customer'],'customer_group_id'  => $order_query->row['customer_group_id'],'firstname' => $order_query->row['firstname'],
'lastname'  => $order_query->row['lastname'],'telephone' => $order_query->row['telephone'],'fax'  => $order_query->row['fax'],'email'     => $order_query->row['email'],'payment_firstname'  => $order_query->row['payment_firstname'],'payment_lastname' => $order_query->row['payment_lastname'],'payment_company'  => $order_query->row['payment_company'],'payment_company_id' => $order_query->row['payment_company_id'],
'payment_tax_id'   => $order_query->row['payment_tax_id'],'payment_address_1'  => $order_query->row['payment_address_1'],'payment_address_2'  => $order_query->row['payment_address_2'],'payment_postcode' => $order_query->row['payment_postcode'],
'payment_city'     => $order_query->row['payment_city'],'payment_zone_id'  => $order_query->row['payment_zone_id'],'payment_zone'     => $order_query->row['payment_zone'],'payment_zone_code' => $payment_zone_code,'payment_country_id' => $order_query->row['payment_country_id'],'payment_country'  => $order_query->row['payment_country'],'payment_iso_code_2' => $payment_iso_code_2,'payment_iso_code_3' => $payment_iso_code_3,
'payment_address_format'  => $order_query->row['payment_address_format'],'payment_method'   => $order_query->row['payment_method'],'payment_code'     => $order_query->row['payment_code'],'shipping_firstname' => $order_query->row['shipping_firstname'],
'shipping_lastname'  => $order_query->row['shipping_lastname'],'shipping_company' => $order_query->row['shipping_company'],'shipping_address_1' => $order_query->row['shipping_address_1'],'shipping_address_2' => $order_query->row['shipping_address_2'],
'shipping_postcode'  => $order_query->row['shipping_postcode'],'shipping_city'    => $order_query->row['shipping_city'],'shipping_zone_id' => $order_query->row['shipping_zone_id'],'shipping_zone'    => $order_query->row['shipping_zone'],'shipping_zone_code' => $shipping_zone_code,'shipping_country_id'     => $order_query->row['shipping_country_id'],
'shipping_country' => $order_query->row['shipping_country'],'shipping_iso_code_2'     => $shipping_iso_code_2,'shipping_iso_code_3'     => $shipping_iso_code_3,'shipping_address_format' => $order_query->row['shipping_address_format'],'shipping_method'  => $order_query->row['shipping_method'],'shipping_code'    => $order_query->row['shipping_code'],
'comment'   => $order_query->row['comment'],'total'     => $order_query->row['total'],'reward'    => $reward,'order_status_id'  => $order_query->row['order_status_id'],'affiliate_id'     => $order_query->row['affiliate_id'],'affiliate_firstname'     => $affiliate_firstname,'affiliate_lastname' => $affiliate_lastname,'commission'  => $order_query->row['commission'],
'language_id' => $order_query->row['language_id'],'language_code'    => $language_code,'language_filename'  => $language_filename,'language_directory' => $language_directory,'currency_id' => $order_query->row['currency_id'],'currency_code'    => $order_query->row['currency_code'],'currency_value'   => $order_query->row['currency_value'],
'ip' => $order_query->row['ip'],'forwarded_ip'     => $order_query->row['forwarded_ip'], 'user_agent'  => $order_query->row['user_agent'],	'accept_language'  => $order_query->row['accept_language'],					
'date_added'  => $order_query->row['date_added'],'date_modified'    => $order_query->row['date_modified']);
} else {
return false;
}
}

public function getOrders($data = array()) {
$sql = "SELECT *, CONCAT(o.firstname, ' ', o.lastname) AS customer, (SELECT os.name FROM " . DB_PREFIX . "order_status os WHERE os.order_status_id = o.order_status_id AND os.language_id = '" . (int)$this->config->get('config_language_id') . "') AS status FROM `" . DB_PREFIX . "order` o";
if (isset($data['filter_order_status_id']) && !is_null($data['filter_order_status_id'])) {$sql .= " WHERE o.order_status_id = '" . (int)$data['filter_order_status_id'] . "'";} else {$sql .= " WHERE o.order_status_id > '0'";
}
if (!empty($data['filter_order_id'])) {$sql .= " AND o.order_id = '" . (int)$data['filter_order_id'] . "'";}if (!empty($data['filter_customer'])) {$sql .= " AND CONCAT(o.firstname, ' ', o.lastname) LIKE '%" . $this->db->escape($data['filter_customer']) . "%'";}if (!empty($data['filter_date_added'])) {$sql .= " AND DATE(o.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";}

if (!empty($data['filter_date_modified'])) {$sql .= " AND DATE(o.date_modified) = DATE('" . $this->db->escape($data['filter_date_modified']) . "')";
}

if (!empty($data['filter_total'])) {$sql .= " AND o.total = '" . (float)$data['filter_total'] . "'";
}
$sort_data = array(
'o.order_id','customer','status',
'o.date_added','o.date_modified','o.total'
);
if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
$sql .= " ORDER BY " . $data['sort'];} else {$sql .= " ORDER BY o.order_id";
}
if (isset($data['order']) && ($data['order'] == 'DESC')) {$sql .= " DESC";
} else {
$sql .= " ASC";
}
if (isset($data['start']) || isset($data['limit'])) {if ($data['start'] < 0) {
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

public function getOrderProducts($iio) {$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$iio . "'");
return $query->rows;}public function getOrderOption($iio, $order_option_id) {$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$iio . "' AND order_option_id = '" . (int)$order_option_id . "'");
return $query->row;
}

public function getOrderOptions($iio, $pop_id) {$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$iio . "' AND order_product_id = '" . (int)$pop_id . "'");
return $query->rows;}public function getOrderDownloads($iio, $pop_id) {$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_download WHERE order_id = '" . (int)$iio . "' AND order_product_id = '" . (int)$pop_id . "'");
return $query->rows;
}
public function getOrderTotals($iio) {$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_total WHERE order_id = '" . (int)$iio . "' ORDER BY sort_order");
return $query->rows;
}
public function getTotalOrders($data = array()) {$sql = "SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order`";if (isset($data['filter_order_status_id']) && !is_null($data['filter_order_status_id'])) {$sql .= " WHERE order_status_id = '" . (int)$data['filter_order_status_id'] . "'";} else {
$sql .= " WHERE order_status_id > '0'";
}if (!empty($data['filter_order_id'])) {$sql .= " AND order_id = '" . (int)$data['filter_order_id'] . "'";}if (!empty($data['filter_customer'])) {$sql .= " AND CONCAT(firstname, ' ', lastname) LIKE '%" . $this->db->escape($data['filter_customer']) . "%'";
}if (!empty($data['filter_date_added'])) {$sql .= " AND DATE(date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";}if (!empty($data['filter_date_modified'])) {$sql .= " AND DATE(o.date_modified) = DATE('" . $this->db->escape($data['filter_date_modified']) . "')";
}

if (!empty($data['filter_total'])) {
$sql .= " AND total = '" . (float)$data['filter_total'] . "'";
}
$query = $this->db->query($sql);
return $query->row['total'];
}
public function getTotalOrdersByStoreId($store_id) {
$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE store_id = '" . (int)$store_id . "'");
return $query->row['total'];
}
public function getTotalOrdersByOrderStatusId($order_status_id) {
$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE order_status_id = '" . (int)$order_status_id . "' AND order_status_id > '0'");
return $query->row['total'];
}
public function getTotalOrdersByLanguageId($language_id) {
$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE language_id = '" . (int)$language_id . "' AND order_status_id > '0'");
return $query->row['total'];
}
public function getTotalOrdersByCurrencyId($currency_id) {
$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE currency_id = '" . (int)$currency_id . "' AND order_status_id > '0'");
return $query->row['total'];}public function getTotalSales() {$complete_status = $this->config->get('config_complete_status_id');$query = $this->db->query("SELECT SUM(ot.value) AS total FROM `" . DB_PREFIX . "order` o LEFT JOIN `" . DB_PREFIX . "order_total` ot ON (o.order_id = ot.order_id) WHERE o.order_status_id = '" . (int)$complete_status . "' AND ot.code = 'sub_total'");
return $query->row['total'];
}
public function getTotalSalesByYear($year) {$complete_status = $this->config->get('config_complete_status_id');$query = $this->db->query("SELECT SUM(ot.value) AS total FROM `" . DB_PREFIX . "order` o LEFT JOIN `" . DB_PREFIX . "order_total` ot ON (o.order_id = ot.order_id) WHERE o.order_status_id = '" . (int)$complete_status . "' AND YEAR(o.date_added) = '" . (int)$year . "' AND ot.code = 'sub_total'");
return $query->row['total'];
}
public function createInvoiceNo($iio) {$io = $this->getOrder($iio);if ($io && !$io['invoice_no']) {
$query = $this->db->query("SELECT MAX(invoice_no) AS invoice_no FROM `" . DB_PREFIX . "order` WHERE invoice_prefix = '" . $this->db->escape($io['invoice_prefix']) . "'");if ($query->row['invoice_no']) {
$invoice_no = $query->row['invoice_no'] + 1;
} else {$invoice_no = 1;
}

$this->db->query("UPDATE `" . DB_PREFIX . "order` SET invoice_no = '" . (int)$invoice_no . "', invoice_prefix = '" . $this->db->escape($io['invoice_prefix']) . "' WHERE order_id = '" . (int)$iio . "'");
return $io['invoice_prefix'] . $invoice_no;}
}

public function addOrderHistory($iio, $data) {if ($this->checkLicensee()) {$this->db->query("UPDATE `" . DB_PREFIX . "order` SET order_status_id = '" . (int)$data['order_status_id'] . "', date_modified = NOW() WHERE order_id = '" . (int)$iio . "'");
$this->db->query("INSERT INTO " . DB_PREFIX . "order_history SET order_id = '" . (int)$iio . "', order_status_id = '" . (int)$data['order_status_id'] . "', notify = '" . (isset($data['notify']) ? (int)$data['notify'] : 0) . "', comment = '" . $this->db->escape(strip_tags($data['comment'])) . "', date_added = NOW()");
$io = $this->getOrder($iio);if ($this->config->get('config_complete_status_id') == $data['order_status_id']) {$this->load->model('sale/voucher');
$results = $this->getOrderVouchers($iio);foreach ($results as $result) {
$this->model_sale_voucher->sendVoucher($result['voucher_id']);
}
}
if ($io && $data['notify']) {$language = new Language($io['language_directory']);$language->load($io['language_filename']);$language->load('mail/order');$subject = sprintf($language->get('text_subject'), $io['store_name'], $iio);$message  = $language->get('text_order') . ' ' . $iio . "\n";
$message .= $language->get('text_date_added') . ' ' . date($language->get('date_format_short'), strtotime($io['date_added'])) . "\n\n";$order_status_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_status WHERE order_status_id = '" . (int)$data['order_status_id'] . "' AND language_id = '" . (int)$io['language_id'] . "'");

if ($order_status_query->num_rows) {
$message .= $language->get('text_order_status') . "\n";$message .= $order_status_query->row['name'] . "\n\n";}

if ($io['customer_id']) {
$message .= $language->get('text_link') . "\n";
$message .= html_entity_decode($io['store_url'] . 'index.php?route=account/order/info&order_id=' . $iio, ENT_QUOTES, 'UTF-8') . "\n\n";
}

if ($data['comment']) {
$message .= $language->get('text_comment') . "\n\n";$message .= strip_tags(html_entity_decode($data['comment'], ENT_QUOTES, 'UTF-8')) . "\n\n";
}$message .= $language->get('text_footer');$mail = new Mail();$mail->protocol = $this->config->get('config_mail_protocol');$mail->parameter = $this->config->get('config_mail_parameter');$mail->hostname = $this->config->get('config_smtp_host');
$mail->username = $this->config->get('config_smtp_username');$mail->password = $this->config->get('config_smtp_password');$mail->port = $this->config->get('config_smtp_port');$mail->timeout = $this->config->get('config_smtp_timeout');$mail->setTo($io['email']);
$mail->setFrom($this->config->get('config_email'));$mail->setSender($io['store_name']);$mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
$mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));$mail->send();}}}public function getOrderHistories($iio, $start = 0, $limit = 0) {
if ($iio > 0) {if ($start < 0) {$start = 0;}if ($limit < 1) {$limit = 10;}$query = $this->db->query("SELECT oh.date_added, os.name AS status, oh.comment, oh.notify FROM " . DB_PREFIX . "order_history oh LEFT JOIN " . DB_PREFIX . "order_status os ON oh.order_status_id = os.order_status_id WHERE oh.order_id = '" . (int)$iio . "' AND os.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY oh.date_added DESC LIMIT " . (int)$start . "," . (int)$limit);
return $query->rows;} else {return array();}}public function getTotalOrderHistories($iio) {$total = 0;if ($iio > 0) {$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "order_history WHERE order_id = '" . (int)$iio . "'");
return $query->row['total'];} else {return $total;}}public function getTotalOrderHistoriesByOrderStatusId($order_status_id) {
$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "order_history WHERE order_status_id = '" . (int)$order_status_id . "'");
return $query->row['total'];}	
public function couponAutocomplete($data = array()) {
if ($data) {$sql = "SELECT * FROM " . DB_PREFIX . "coupon WHERE status = '1'";if (!empty($data['filter_name']) && !empty($data['filter_nomer'])) {$sql .= " AND (LCASE(name) LIKE '%" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%'";
$sql .= " OR LCASE(code) LIKE '" . $this->db->escape(utf8_strtolower($data['filter_nomer'])) . "%')";
}$sql .= " ORDER BY `name`";$data['start'] = 0;$data['limit'] = 20;
$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];

$query = $this->db->query($sql);return $query->rows;} else {return array();}}public function getCouponByOrderId($iio = '0') {$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "coupon_history WHERE order_id = '" . (int)$iio . "' LIMIT 1");
return $query->row;}public function getCodeCouponById($coupon_id) {$query = $this->db->query("SELECT `code` FROM " . DB_PREFIX . "coupon WHERE coupon_id = '" . (int)$coupon_id . "'");
if ($query->num_rows) {return $query->row['code'];} else {return false;}
}

public function voucherAutocomplete($data = array()) {if ($data) {$sql = "SELECT * FROM " . DB_PREFIX . "voucher WHERE status = '1'";
if (!empty($data['filter_name']) && !empty($data['filter_nomer'])) {$sql .= " AND (LCASE(message) LIKE '%" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%'";
$sql .= " OR LCASE(code) LIKE '" . $this->db->escape(utf8_strtolower($data['filter_nomer'])) . "%')";
}
$sql .= " ORDER BY `code`";$data['start'] = 0;$data['limit'] = 20;$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];$query = $this->db->query($sql);return $query->rows;
} else {return array();}}public function getVoucherByOrderId($iio = '0') {$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "voucher_history WHERE order_id = '" . (int)$iio . "' LIMIT 1");
return $query->row;}public function getCodeVoucherById($voucher_id) {$query = $this->db->query("SELECT `code` FROM " . DB_PREFIX . "voucher WHERE voucher_id = '" . (int)$voucher_id . "'");
if ($query->num_rows) {return $query->row['code'];} else {return false;}}public function getOrderVouchers($iio) {$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_voucher WHERE order_id = '" . (int)$iio . "'");
return $query->rows;}public function getOrderVoucherByVoucherId($voucher_id) {$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order_voucher` WHERE voucher_id = '" . (int)$voucher_id . "'");return $query->row;}public function setCustomerPassword($length = 8){$pr = "";$possible = "2345678";$maxlength = strlen($possible);if ($length > $maxlength) {$length = $maxlength;}$i = 0; for ($i = 0; $i < $length; $i++) {$char = substr($possible, mt_rand(0, $maxlength-1), 1);if (!strstr($pr, $char)) {$pr .= $char;
}}
return $pr;
}
public function getVirtualCustomer($gicd) {$query = $this->db->query("SELECT customer_id FROM `" . DB_PREFIX . "customer` WHERE LCASE(email) LIKE '%mambasu.ru' AND customer_group_id = '" . (int)$gicd . "' LIMIT 1");
if ($query->num_rows) {return $query->row['customer_id'];} else {return false;}}public function addVirtualCustomer($gicd, $customer_group_name = '') {$vcustomer = $this->getVirtualCustomer($gicd);if ($vcustomer) {
$vcustomer_id = $vcustomer;} else {$pr = $this->setCustomerPassword();$email = 'opro' . $gicd . '@mambasu.ru';if ($customer_group_name == '') {$customer_group_name = 'Vcustomer' . $gicd;}$this->db->query("INSERT INTO `" . DB_PREFIX . "customer` SET `firstname` = 'OrderPro', `lastname` = '" . $this->db->escape($customer_group_name) . "', `email` = '" . $this->db->escape($email) . "', `newsletter` = '0', `customer_group_id` = '" . (int)$gicd . "', `salt` = '" . $this->db->escape($salt = substr(md5(uniqid(rand(), true)), 0, 9)) . "', `password` = '" . $this->db->escape(sha1($salt . sha1($salt . sha1($pr)))) . "', `status` = '1', `approved` = '1', `date_added` = NOW()");
$vcustomer_id = $this->db->getLastId();}return $vcustomer_id;}public function setGroup($group = '', $icd = '') {if ($icd && $group) {$this->db->query("UPDATE " . DB_PREFIX . "customer SET customer_group_id = '" . (int)$group . "' WHERE customer_id = '" . (int)$icd . "'");
}}public function getTransactionsByOrderid($icd, $iio = 0) {$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer_transaction WHERE customer_id = '" . (int)$icd . "' AND order_id = '" . (int)$iio . "' ORDER BY date_added DESC");
return $query->rows;}public function updateReward($icd, $description = '', $points = '', $iio = 0, $history = '0') {if ($this->checkLicensee()) {$customer_info = $this->getCustomer($icd);if ($customer_info) {$this->db->query("INSERT INTO " . DB_PREFIX . "customer_reward SET customer_id = '" . (int)$icd . "', order_id = '" . (int)$iio . "', points = '" . (int)$points . "', description = '" . $this->db->escape($description) . "', date_added = NOW()");
$this->language->load('mail/customer');$this->language->load('sale/orderpro');if ($iio) {$io = $this->getOrder($iio);if ($io) {$store_name = $io['store_name'];
} else {$store_name = $this->config->get('config_name');}	} else {$store_name = $this->config->get('config_name');}if ($history == '0') {$message  = sprintf($this->language->get('text_reward_received'), $points) . "\n\n";} elseif ($history <= $points) {$points -= $history;
$message = sprintf($this->language->get('text_reward_received'), $points) . "\n\n";} elseif ($history > $points) {$points = $history - $points;$message  = sprintf($this->language->get('text_reward_revoked'), $points) . "\n\n";
}$new_total = $this->getRewardTotal($icd);$message .= sprintf($this->language->get('text_reward_total'), $new_total);$mail = new Mail();$mail->protocol = $this->config->get('config_mail_protocol');$mail->parameter = $this->config->get('config_mail_parameter');$mail->hostname = $this->config->get('config_smtp_host');$mail->username = $this->config->get('config_smtp_username');
$mail->password = $this->config->get('config_smtp_password');$mail->port = $this->config->get('config_smtp_port');
$mail->timeout = $this->config->get('config_smtp_timeout');$mail->setTo($customer_info['email']);$mail->setFrom($this->config->get('config_email'));$mail->setSender($store_name);$mail->setSubject(sprintf($this->language->get('text_reward_subject'), $store_name));
$mail->setText($message);$mail->send();return $this->language->get('success_reward_updated');
}
}}
public function getCustomer($icd) {$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int)$icd . "'");
return $query->row;}public function getRewardTotal($icd) {$query = $this->db->query("SELECT SUM(points) AS total FROM " . DB_PREFIX . "customer_reward WHERE customer_id = '" . (int)$icd . "'");
return $query->row['total'];}public function getUsedRewardsByOrderId($iio) {$query = $this->db->query("SELECT SUM(points) AS total FROM " . DB_PREFIX . "customer_reward WHERE order_id = '" . (int)$iio . "' AND points < '0'");
return $query->row['total'];}public function getReceivedRewardsByOrderId($iio) {$query = $this->db->query("SELECT SUM(points) AS total FROM " . DB_PREFIX . "customer_reward WHERE order_id = '" . (int)$iio . "' AND points > '0'");
return $query->row['total'];}public function deleteOrderReward($iio) {if ($this->checkLicensee()) {$this->db->query("DELETE FROM " . DB_PREFIX . "customer_reward WHERE order_id = '" . (int)$iio . "' AND points > '0'");
}
}
public function getProductImage($product_id) {$query = $this->db->query("SELECT `image` FROM `" . DB_PREFIX . "product` WHERE `product_id` = '" . (int)$product_id . "'");
return $query->row;}
public function checkTables() {$query = $this->db->query("DESCRIBE " . DB_PREFIX . "order_product");foreach ($query->rows as $result) {$fields[] = $result['Field'];}if (!in_array('sku', $fields)) {$this->db->query("ALTER TABLE `" . DB_PREFIX . "order_product` ADD `sku` VARCHAR(64) NOT NULL AFTER `model`");
}if (!in_array('upc', $fields)) {$this->db->query("ALTER TABLE `" . DB_PREFIX . "order_product` ADD `upc` VARCHAR(64) NOT NULL AFTER `sku`");}if (!in_array('ean', $fields)) {$this->db->query("ALTER TABLE `" . DB_PREFIX . "order_product` ADD `ean` VARCHAR(64) NOT NULL AFTER `upc`");}if (!in_array('jan', $fields)) {$this->db->query("ALTER TABLE `" . DB_PREFIX . "order_product` ADD `jan` VARCHAR(64) NOT NULL AFTER `ean`");
}if (!in_array('isbn', $fields)) {$this->db->query("ALTER TABLE `" . DB_PREFIX . "order_product` ADD `isbn` VARCHAR(64) NOT NULL AFTER `jan`");}if (!in_array('mpn', $fields)) {$this->db->query("ALTER TABLE `" . DB_PREFIX . "order_product` ADD `mpn` VARCHAR(64) NOT NULL AFTER `isbn`");}if (!in_array('location', $fields)) {$this->db->query("ALTER TABLE `" . DB_PREFIX . "order_product` ADD `location` VARCHAR(128) NOT NULL AFTER `mpn`");
}if (!in_array('discount_type', $fields)) {$this->db->query("ALTER TABLE `" . DB_PREFIX . "order_product` ADD `discount_type` VARCHAR(1) NOT NULL AFTER `price`");
}
if (!in_array('discount_amount', $fields)) {$this->db->query("ALTER TABLE `" . DB_PREFIX . "order_product` ADD `discount_amount` DECIMAL(15,4) NOT NULL DEFAULT '0.0000' AFTER `price`");
}}public function checkLicensee() {return true;}
}
?>