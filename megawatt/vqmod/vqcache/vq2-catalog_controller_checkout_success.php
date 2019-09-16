<?php

class ControllerCheckoutSuccess extends Controller { 

	public function index() { 	
		if (isset($this->session->data['order_id'])) {

        
            ## VipSMS.net [BEGIN]

            if ($this->vipsms_net_init()==true && $this->config->get('vipsms_net_events_admin_new_order')) {

              $message = $this->language->get('vipsms_net_message_admin_new_order');

              $phones = array($this->config->get('vipsms_net_admphone'));
              if (strlen($this->config->get('vipsms_net_admphone1'))) $phones[] = $this->config->get('vipsms_net_admphone1');

              $this->vipsms_net_logger->write('['.substr(__FILE__, strlen(DIR_SYSTEM)-1).'] Event: vipsms_net_events_admin_new_order. Dest phone:'
                .implode(', ', $phones)
                ." Message: ".$message
              );

              foreach($phones as $phone)
                $this->vipsms_net_gateway->sendSms($phone, $message);
            }
            if ($this->config->get('vipsms_net_events_customer_new_order')){
              $this->load->model('checkout/order');
              $last_order = $this->model_checkout_order->getOrder($this->session->data['order_id']);
	if ($_COOKIE["language"] == "ru") {
		$message = sprintf(
		$this->config->get('vipsms_net_textordersmsru'),
		$this->session->data['order_id']
		);
	} elseif ($_COOKIE["language"] == "ua-uk") {
		$message = sprintf(
		$this->config->get('vipsms_net_textordersmsua'),
		$this->session->data['order_id']
		);
	} else {
		$message = sprintf(
		$this->config->get('vipsms_net_textordersmsru'),
		$this->session->data['order_id']
		);
	}

              $this->vipsms_net_logger->write('['.substr(__FILE__, strlen(DIR_SYSTEM)-1).'] Event: vipsms_net_events_customer_new_order. Dest phone:'
                .$last_order['telephone']
                ." Message: ".$message
              );

              $this->vipsms_net_gateway->sendSms($last_order['telephone'], $message);
            }
            ## VipSMS.net [END]
        
      
			
			$this->session->data['last_order_id'] = $this->session->data['order_id'];

			$this->cart->clear();

			unset($this->session->data['shipping_method']);
			unset($this->session->data['shipping_methods']);
			unset($this->session->data['payment_method']);
			unset($this->session->data['payment_methods']);
			unset($this->session->data['guest']);
			unset($this->session->data['comment']);
			unset($this->session->data['order_id']);	
			unset($this->session->data['coupon']);
			unset($this->session->data['reward']);
			unset($this->session->data['voucher']);
			unset($this->session->data['vouchers']);
			unset($this->session->data['totals']);
		}	

		$this->language->load('checkout/success');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->data['breadcrumbs'] = array(); 

		$this->data['breadcrumbs'][] = array(
			'href'      => $this->url->link('common/home'),
			'text'      => $this->language->get('text_home'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'href'      => $this->url->link('checkout/cart'),
			'text'      => $this->language->get('text_basket'),
			'separator' => $this->language->get('text_separator')
		);

		$this->data['breadcrumbs'][] = array(
			'href'      => $this->url->link('checkout/checkout', '', 'SSL'),
			'text'      => $this->language->get('text_checkout'),
			'separator' => $this->language->get('text_separator')
		);	

		$this->data['breadcrumbs'][] = array(
			'href'      => $this->url->link('checkout/success'),
			'text'      => $this->language->get('text_success'),
			'separator' => $this->language->get('text_separator')
		);

		$this->data['heading_title'] = $this->language->get('heading_title');

		if ($this->customer->isLogged()) {
			$this->data['text_message'] = sprintf($this->language->get('text_customer'), $this->url->link('account/account', '', 'SSL'), $this->url->link('account/order', '', 'SSL'), $this->url->link('account/download', '', 'SSL'), $this->url->link('information/contact'));

		} else {
			$this->data['text_message'] = sprintf($this->language->get('text_guest'), $this->url->link('information/contact'));
		}

		$this->data['button_continue'] = $this->language->get('button_continue');

		$this->data['continue'] = $this->url->link('common/home');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/success.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/common/success.tpl';
		} else {
			$this->template = 'default/template/common/success.tpl';
		}

		$this->children = array(
			'common/column_left',
			'common/column_right',

        'common/content_top_1_3',
		'common/content_top_2_3',
		
      
			'common/content_top',
			'common/content_bottom',

        'common/content_top_1_3',
      

        'common/content_top_2_3',
      

        'common/content_top_full',
      
			'common/footer',
			'common/header'			
		);

		$this->response->setOutput($this->render());
	}
}

?>