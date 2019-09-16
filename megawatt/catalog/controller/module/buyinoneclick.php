<?php
class ControllerModuleBuyinoneclick extends Controller {

	protected function index() {
		if ($this->config->get('buyinoneclick_status')) {
			$this->language->load('module/buyinoneclick');
			
			$this->document->addScript('catalog/view/javascript/jquery/colorbox/jquery.colorbox-min.js');
			$this->document->addStyle('catalog/view/javascript/jquery/colorbox/colorbox.css');
			$this->document->addScript('catalog/view/javascript/jquery/jquery.maskedinput.min.js');
			$this->document->addScript('catalog/view/javascript/buyinoneclick.js');

			$this->data['heading_title'] = $this->language->get('heading_title');
			$this->data['outstock'] = $this->language->get('outstock');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/buyinoneclick.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/module/buyinoneclick.tpl';
			} else {
				$this->template = 'default/template/module/buyinoneclick.tpl';
			}

			$this->render();
		}
	}

	public function getForm() {
		$this->load->model('catalog/product');

		$this->language->load('module/buyinoneclick');

		$this->data['heading_title'] = $this->language->get('heading_title');
			$this->data['outstock'] = $this->language->get('outstock');
		$this->data['text_wait'] = $this->language->get('text_wait');

		$this->data['entry_contact'] = $this->language->get('entry_contact');
		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_price'] = $this->language->get('entry_price');
		$this->data['entry_qty'] = $this->language->get('entry_qty');
		$this->data['entry_total'] = $this->language->get('entry_total');

		$this->data['button_send'] = $this->language->get('button_send');

		if ($this->config->get('buyinoneclick_phone_mask_status')) {
			$this->data['phone_mask'] = $this->config->get('buyinoneclick_phone_mask');
		} else {
			$this->data['phone_mask'] = '';
		}

		$this->data['phone_text'] = $this->config->get('buyinoneclick_phone_text');

		$this->data['stock_status'] = 1;
		$this->data['customer_firstname'] = '';
		$product_info = $this->model_catalog_product->getProduct($this->request->get['product_id']);
		$this->data['product_img'] = $product_info['image'];
		$this->data['product_name'] = $product_info['name'];
		$this->data['product_price'] = (float) $this->currency->format((float)$product_info['special'] ? $product_info['special'] : $product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax'));
		$this->data['this_tax'] = $this->currency->getSymbolRight();
		
		if (!$this->config->get('config_stock_checkout') || $this->config->get('config_stock_warning')) {

			if (!$product_info['quantity'] || ($product_info['quantity'] < 0)) {
				$this->data['error_warning'] = $this->language->get('error_stock');

				if (!$this->config->get('config_stock_checkout')) {
					$this->data['stock_status'] = 0;
				}
			}
		}

		if ($this->customer->isLogged()) {
			
			$this->load->model('account/customer');

			$customer = $this->model_account_customer->getCustomer($this->customer->getId());
			
			$this->data['customer_firstname'] = $customer['firstname'];
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/buyinoneclick_form.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/buyinoneclick_form.tpl';
		} else {
			$this->template = 'default/template/module/buyinoneclick_form.tpl';
		}

		$this->response->setOutput($this->render());
	}

	public function write($settings = array()) {
		$this->language->load('module/buyinoneclick');

		$this->load->model('catalog/buyinoneclick');
		$this->load->model('setting/setting');

		$json = array();

		if ($settings) {
			$contact = $settings['contact'];
			$name = $settings['name'];
			$product_id = $settings['product_id'];
			$quantity = $settings['quantity'];
		} elseif ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$contact = $this->request->post['contact'];
			$name = $this->request->post['name'];
			$product_id = $this->request->post['product_id'];
			$quantity = $this->request->post['quantity'];
		} else {
			$product_id = 0;
		}

		if ($product_id) {
			if ((utf8_strlen($contact) < 3) || (utf8_strlen($contact) > 50)) {
				if ($this->config->get('buyinoneclick_phone_mask_status')) {
					$json['error']['contact'] = $this->language->get('error_mask');
				} else {
					$json['error']['contact'] = $this->language->get('error_contact');
				}
			}

			if (!isset($json['error'])) {
				if ($this->config->get('buyinoneclick_phone_text')) {
					$contact = $this->config->get('buyinoneclick_phone_text') . $contact;
				}

				$this->load->model('catalog/product');

				$product_info = $this->model_catalog_product->getProduct($product_id);

				$price = isset($product_info['special']) ? $product_info['special'] : $product_info['price'];
				$total = $this->currency->format($price*$quantity);
				
				$data = array(
					'contact' => $contact,
					'name' => $name,
					'product_id' => $product_id,
					'product_name' => $product_info['name'],
					'price' => $price,
					'total' => $total,
					'currency_id' => $this->currency->getId(),
					'currency_code' => $this->currency->getCode(),
					'currency_value' => 1,
					'quantity' => $quantity
				);

				$order_id = $this->model_catalog_buyinoneclick->addOrder($data);

				if ($this->config->get('buyinoneclick_email_status')) {
					$email_subject = sprintf($this->language->get('text_subject'), $this->language->get('heading_title'), $this->config->get('config_name'), $order_id);
					$email_text = sprintf($this->language->get('text_order'), $order_id) . "\n\n";
					$email_text .= sprintf($this->language->get('text_name'), html_entity_decode($name), ENT_QUOTES, 'UTF-8') . "\n";
					$email_text .= sprintf($this->language->get('text_contact'), html_entity_decode($contact), ENT_QUOTES, 'UTF-8') . "\n";
					$email_text .= sprintf($this->language->get('text_ip'), $this->request->server['REMOTE_ADDR'], ENT_QUOTES, 'UTF-8') . "\n\n";
					$email_text .= sprintf($this->language->get('text_product'), html_entity_decode($product_info['name']), ENT_QUOTES, 'UTF-8') . "\n";
					$email_text .= sprintf($this->language->get('text_date_order'), date('d.m.Y H:i'), ENT_QUOTES, 'UTF-8') . "\n\n";
					$email_text .= sprintf($this->language->get('text_price'), $total, ENT_QUOTES, 'UTF-8');

					$mail = new Mail();
					$mail->protocol = $this->config->get('config_mail_protocol');
					$mail->parameter = $this->config->get('config_mail_parameter');
					$mail->hostname = $this->config->get('config_smtp_host');
					$mail->username = $this->config->get('config_smtp_username');
					$mail->password = $this->config->get('config_smtp_password');
					$mail->port = $this->config->get('config_smtp_port');
					$mail->timeout = $this->config->get('config_smtp_timeout');
					$mail->setTo($this->config->get('config_email'));
					$mail->setFrom($this->config->get('config_email'));
					$mail->setSender($this->config->get('config_name'));
					$mail->setSubject($email_subject);
					$mail->setText($email_text);
					$mail->send();
				}

				$json['success'] = $this->language->get('text_success');
			}
		}

		$this->response->setOutput(json_encode($json));
	}

}

?>
