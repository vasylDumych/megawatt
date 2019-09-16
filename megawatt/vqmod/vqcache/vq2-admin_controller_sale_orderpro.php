<?php 
class ControllerSaleOrderpro extends Controller {
	private $error = array();

  	public function index() {
		$this->language->load('sale/orderpro');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/orderpro');
		
		if (isset($this->request->get['cancel']) && !empty($this->request->get['cancel']) && $this->user->hasPermission('modify', 'sale/orderpro')) {
			$this->load->model('sale/customer');
			$this->model_sale_customer->deleteReward($this->request->get['cancel']);
			$this->db->query("DELETE FROM " . DB_PREFIX . "affiliate_transaction WHERE order_id = '" . (int)$this->request->get['cancel'] . "'");
			$this->db->query("DELETE FROM " . DB_PREFIX . "coupon_history WHERE order_id = '" . (int)$this->request->get['cancel'] . "'");
			$this->db->query("DELETE FROM " . DB_PREFIX . "voucher_history WHERE order_id = '" . (int)$this->request->get['cancel'] . "'");
			$this->db->query("DELETE FROM " . DB_PREFIX . "order_history WHERE order_id = '" . (int)$this->request->get['cancel'] . "'");
			$this->redirect($this->url->link('sale/order', 'token=' . $this->session->data['token'], 'SSL'));//список заказов
		}

    	//$this->getList();
  	}
	
  	public function edit() {
		$this->language->load('sale/orderpro');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/orderpro');

		if (!$this->config->get('orderpro_license')) {
			$this->model_sale_orderpro->checkTables();
		}

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			if (isset($this->request->post['shipping_method'])) {
				$this->request->post['shipping_method'] = html_entity_decode($this->request->post['shipping_method'], ENT_QUOTES, 'UTF-8');
			}
			if (isset($this->request->post['order_total'])) {
	      		foreach ($this->request->post['order_total'] as $i=>$order_total) {
					$this->request->post['order_total'][$i]['title'] = html_entity_decode($order_total['title'], ENT_QUOTES, 'UTF-8');
					$this->request->post['order_total'][$i]['text'] = html_entity_decode($order_total['text'], ENT_QUOTES, 'UTF-8');
				}
			}
			
			$post_data = $this->request->post;
			
			if ($post_data['payment_country_id'] == '') {
				$post_data['payment_country_id'] = $this->config->get('config_country_id');
			}
			
			if (!isset($post_data['payment_zone_id']) || $post_data['payment_zone_id'] == '') {
				$post_data['payment_zone_id'] = $this->config->get('config_zone_id');
			}
			
			if ($post_data['shipping_country_id'] == '') {
				$post_data['shipping_country_id'] = $this->config->get('config_country_id');
			}
			
			if (!isset($post_data['shipping_zone_id']) || $post_data['shipping_zone_id'] == '') {
				$post_data['shipping_zone_id'] = $this->config->get('config_zone_id');
			}
			
			$this->request->post = $post_data;

			$this->model_sale_orderpro->editOrder($this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');
		  
			$url = '';
			
			if (isset($this->request->get['filter_order_id'])) {
				$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
			}
			
			if (isset($this->request->get['filter_customer'])) {
				$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_order_status_id'])) {
				$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
			}
			
			if (isset($this->request->get['filter_total'])) {
				$url .= '&filter_total=' . $this->request->get['filter_total'];
			}

			if (isset($this->request->get['filter_date_added'])) {
				$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
			}
			
			if (isset($this->request->get['filter_date_modified'])) {
				$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			//$this->redirect($this->url->link('sale/orderpro', 'token=' . $this->session->data['token'] . $url, 'SSL'));


			if(isset($this->request->post['apply']) and $this->request->post['apply'])
			$this->redirect($this->url->link('sale/orderpro/edit', 'token=' . $this->session->data['token'] . '&order_id=' . $this->request->get['order_id'] . $url, 'SSL'));
			else
			$this->redirect($this->url->link('sale/order', 'token=' . $this->session->data['token'] . $url, 'SSL'));


			$this->redirect($this->url->link('sale/order', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getNormalForm();
  	}

  	public function delete() {
		$this->language->load('sale/orderpro');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/orderpro');

    	if (isset($this->request->post['selected']) && ($this->validateDelete())) {
			foreach ($this->request->post['selected'] as $order_id) {
				$this->model_sale_orderpro->deleteOrder($order_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_order_id'])) {
				$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
			}
			
			if (isset($this->request->get['filter_customer'])) {
				$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_order_status_id'])) {
				$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
			}
			
			if (isset($this->request->get['filter_total'])) {
				$url .= '&filter_total=' . $this->request->get['filter_total'];
			}

			if (isset($this->request->get['filter_date_added'])) {
				$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
			}
			
			if (isset($this->request->get['filter_date_modified'])) {
				$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			//$this->redirect($this->url->link('sale/orderpro', 'token=' . $this->session->data['token'] . $url, 'SSL'));
			$this->redirect($this->url->link('sale/order', 'token=' . $this->session->data['token'] . $url, 'SSL'));
    	}

    	//$this->getList();
  	}


	public function sms() {
		$this->data['error'] = '';
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			if (!$this->user->hasPermission('modify', 'sale/order')) { 
				$this->data['error'] = $this->language->get('error_permission');
			}
			if (!$this->data['error']) { 
			header ('Content-type: text/html; charset=utf-8'); 
			
			$login  = 's-energia';
			$passwd = 'tdes123';
			
			$client = new SoapClient ('http://vipsms.net/api/soap.html');
			$res = $client->auth($login, $passwd);						 
			$sessid = $res->message;			 			
		    $abs_phone = $_POST['telephone'];
			$abs_phone = str_replace("-","",$abs_phone);
			$abs_phone = str_replace("(","",$abs_phone);
			$abs_phone = str_replace(")","",$abs_phone);
			$abs_phone = str_replace("+","",$abs_phone);
			$abs_phone = str_replace(" ","",$abs_phone);
			$nn3 = substr($abs_phone,strlen($abs_phone)-2,2);
			$abs_phone = substr($abs_phone,0,strlen($abs_phone)-2);
			$nn2 = substr($abs_phone,strlen($abs_phone)-2,2);
			$abs_phone = substr($abs_phone,0,strlen($abs_phone)-2);
			$nn1 = substr($abs_phone,strlen($abs_phone)-3,3);
			$abs_phone = substr($abs_phone,0,strlen($abs_phone)-3);
			$operator = substr($abs_phone,strlen($abs_phone)-3,3);
			$abs_phone = substr($abs_phone,0,strlen($abs_phone)-3);
			$number="(".$operator.") ".$nn1."-".$nn2."-".$nn3;
			if (strlen($abs_phone)>1)
			{
				$number="+".$abs_phone." ".$number;
			}
			else
			{
				$number="+38 ".$number;
			}
			
			$res = $client->sendSmsOne($sessid, $number, $login, $_POST['text']);
			$this->load->model('sale/order');
			$this->model_sale_order->saveSms($this->request->get['order_id'], $_POST['text']);
			}
		}
		
	}
						
					
  	protected function getList() {
		if (isset($this->request->get['filter_order_id'])) {
			$filter_order_id = $this->request->get['filter_order_id'];
		} else {
			$filter_order_id = null;
		}

		if (isset($this->request->get['filter_customer'])) {
			$filter_customer = $this->request->get['filter_customer'];
		} else {
			$filter_customer = null;
		}

		if (isset($this->request->get['filter_order_status_id'])) {
			$filter_order_status_id = $this->request->get['filter_order_status_id'];
		} else {
			$filter_order_status_id = null;
		}
		
		if (isset($this->request->get['filter_total'])) {
			$filter_total = $this->request->get['filter_total'];
		} else {
			$filter_total = null;
		}
		
		if (isset($this->request->get['filter_date_added'])) {
			$filter_date_added = $this->request->get['filter_date_added'];
		} else {
			$filter_date_added = null;
		}
		
		if (isset($this->request->get['filter_date_modified'])) {
			$filter_date_modified = $this->request->get['filter_date_modified'];
		} else {
			$filter_date_modified = null;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'o.order_id';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
		}
		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['filter_order_id'])) {
			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
		}
		
		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_order_status_id'])) {
			$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
		}
		
		if (isset($this->request->get['filter_total'])) {
			$url .= '&filter_total=' . $this->request->get['filter_total'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}
		
		if (isset($this->request->get['filter_date_modified'])) {
			$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		if (!$this->config->get('orderpro_license')) {
			$this->model_sale_orderpro->checkTables();
		}
		
		$this->language->load('sale/orderpro');

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('sale/orderpro', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);

		if ($this->config->get('orderpro_invoice_type')) {
			$this->data['invoice'] = $this->url->link('sale/orderpro/invoice', 'token=' . $this->session->data['token'], 'SSL');
		} else {
			$this->data['invoice'] = $this->url->link('sale/order/invoice', 'token=' . $this->session->data['token'], 'SSL');
		}
		
		$this->data['create'] = $this->url->link('sale/orderpro/edit', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['delete'] = $this->url->link('sale/orderpro/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$this->data['orders'] = array();

		$data = array(
			'filter_order_id'        => $filter_order_id,
			'filter_customer'	     => $filter_customer,
			'filter_order_status_id' => $filter_order_status_id,
			'filter_total'           => $filter_total,
			'filter_date_added'      => $filter_date_added,
			'filter_date_modified'   => $filter_date_modified,
			'sort'                   => $sort,
			'order'                  => $order,
			'start'                  => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit'                  => $this->config->get('config_admin_limit')
		);

		$order_total = $this->model_sale_orderpro->getTotalOrders($data);

		$results = $this->model_sale_orderpro->getOrders($data);

    	foreach ($results as $result) {
			$action = array();
			
			$action[] = array(
				'text' => $this->language->get('text_view'),
				'href' => $this->url->link('sale/order/info', 'token=' . $this->session->data['token'] . '&order_id=' . $result['order_id'] . $url, 'SSL')
			);
			
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('sale/orderpro/edit', 'token=' . $this->session->data['token'] . '&order_id=' . $result['order_id'] . $url, 'SSL')
			);
			
			$this->data['orders'][] = array(
				'order_id'      => $result['order_id'],
				'customer'      => $result['customer'],
				'status'        => $result['status'],
				'total'         => $this->currency->format($result['total'], $result['currency_code'], $result['currency_value']),
				'date_added'    => date('j.m.Y G:i', strtotime($result['date_added'])),
				'date_modified' => date('j.m.Y G:i', strtotime($result['date_modified'])),
				'selected'      => isset($this->request->post['selected']) && in_array($result['order_id'], $this->request->post['selected']),
				'action'        => $action
			);
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_missing'] = $this->language->get('text_missing');

		$this->data['column_order_id'] = $this->language->get('column_order_id');
    	$this->data['column_customer'] = $this->language->get('column_customer');
		$this->data['column_status'] = $this->language->get('column_status');
		$this->data['column_total'] = $this->language->get('column_total');
		$this->data['column_date_added'] = $this->language->get('column_date_added');
		$this->data['column_date_modified'] = $this->language->get('column_date_modified');
		$this->data['column_action'] = $this->language->get('column_action');

		$this->data['button_create'] = $this->language->get('button_create');
		$this->data['button_invoice'] = $this->language->get('button_invoice');
		$this->data['button_delete'] = $this->language->get('button_delete');
		$this->data['button_filter'] = $this->language->get('button_filter');

		$this->data['token'] = $this->session->data['token'];
		
		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		$url = '';

		if (isset($this->request->get['filter_order_id'])) {
			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
		}
		
		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_order_status_id'])) {
			$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
		}
		
		if (isset($this->request->get['filter_total'])) {
			$url .= '&filter_total=' . $this->request->get['filter_total'];
		}
					
		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}
		
		if (isset($this->request->get['filter_date_modified'])) {
			$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$this->data['sort_order'] = $this->url->link('sale/orderpro', 'token=' . $this->session->data['token'] . '&sort=o.order_id' . $url, 'SSL');
		$this->data['sort_customer'] = $this->url->link('sale/orderpro', 'token=' . $this->session->data['token'] . '&sort=customer' . $url, 'SSL');
		$this->data['sort_status'] = $this->url->link('sale/orderpro', 'token=' . $this->session->data['token'] . '&sort=status' . $url, 'SSL');
		$this->data['sort_total'] = $this->url->link('sale/orderpro', 'token=' . $this->session->data['token'] . '&sort=o.total' . $url, 'SSL');
		$this->data['sort_date_added'] = $this->url->link('sale/orderpro', 'token=' . $this->session->data['token'] . '&sort=o.date_added' . $url, 'SSL');
		$this->data['sort_date_modified'] = $this->url->link('sale/orderpro', 'token=' . $this->session->data['token'] . '&sort=o.date_modified' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['filter_order_id'])) {
			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
		}
		
		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_order_status_id'])) {
			$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
		}
		
		if (isset($this->request->get['filter_total'])) {
			$url .= '&filter_total=' . $this->request->get['filter_total'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}
		
		if (isset($this->request->get['filter_date_modified'])) {
			$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $order_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('sale/orderpro', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['filter_order_id'] = $filter_order_id;
		$this->data['filter_customer'] = $filter_customer;
		$this->data['filter_order_status_id'] = $filter_order_status_id;
		$this->data['filter_total'] = $filter_total;
		$this->data['filter_date_added'] = $filter_date_added;
		$this->data['filter_date_modified'] = $filter_date_modified;

		$this->load->model('localisation/order_status');

    	$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;
		
		$this->document->addStyle('view/stylesheet/orderpro.css');

		$this->template = 'sale/orderpro_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
		
		$this->response->setOutput($this->render());
  	}
	
	protected function getNormalForm() {
		$this->language->load('sale/orderpro');

		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['orderpro_version'] = 'v0.7.3.2';

		$this->data['text_default'] = $this->language->get('text_default');
		$this->data['text_select'] = $this->language->get('text_select');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		$this->data['text_none'] = $this->language->get('text_none');
		$this->data['text_wait'] = $this->language->get('text_wait');
		$this->data['text_commission_add'] = $this->language->get('text_commission_add');
		$this->data['text_commission_remove'] = $this->language->get('text_commission_remove');
		$this->data['text_discount'] = $this->language->get('text_discount');
		$this->data['text_account_exist'] = $this->language->get('text_account_exist');
		$this->data['text_newsletter'] = $this->language->get('text_newsletter');
		$this->data['text_store'] = $this->language->get('text_store');
		$this->data['text_currency'] = $this->language->get('text_currency');
		$this->data['text_language'] = $this->language->get('text_language');
		$this->data['text_status'] = $this->language->get('text_status');
		$this->data['text_customer'] = $this->language->get('text_customer');
		$this->data['text_shipping'] = $this->language->get('text_shipping');

		$this->data['column_pid'] = $this->language->get('column_pid');
		$this->data['column_image'] = $this->language->get('column_image');
		$this->data['column_product'] = $this->language->get('column_product');
		$this->data['column_model'] = $this->language->get('column_model');
		$this->data['column_sku'] = $this->language->get('column_sku');
		$this->data['column_jan'] = $this->language->get('column_jan');
		$this->data['column_ean'] = $this->language->get('column_ean');
		$this->data['column_mpn'] = $this->language->get('column_mpn');
		$this->data['column_upc'] = $this->language->get('column_upc');
		$this->data['column_isbn'] = $this->language->get('column_isbn');
		$this->data['column_location'] = $this->language->get('column_location');
		$this->data['column_quantity'] = $this->language->get('column_quantity');
		$this->data['column_realquantity'] = $this->language->get('column_realquantity');
		$this->data['column_price'] = $this->language->get('column_price');
		$this->data['column_now_price'] = $this->language->get('column_now_price');
		$this->data['column_total'] = $this->language->get('column_total');
		$this->data['column_discount'] = $this->language->get('column_discount');
		$this->data['column_reward'] = $this->language->get('column_reward');
		$this->data['column_reward_short'] = $this->language->get('column_reward_short');
		$this->data['column_desc'] = $this->language->get('column_desc');
		$this->data['column_cost'] = $this->language->get('column_cost');
		$this->data['column_nocalc'] = $this->language->get('column_nocalc');
		$this->data['column_sort'] = $this->language->get('column_sort');
		
		$this->data['entry_store'] = $this->language->get('entry_store');
		$this->data['entry_customer'] = $this->language->get('entry_customer');
		$this->data['entry_address'] = $this->language->get('entry_address');
		$this->data['entry_firstname'] = $this->language->get('entry_firstname');
		$this->data['entry_lastname'] = $this->language->get('entry_lastname');
		$this->data['entry_email'] = $this->language->get('entry_email');
		$this->data['entry_telephone'] = $this->language->get('entry_telephone');
		$this->data['entry_fax'] = $this->language->get('entry_fax');
		$this->data['entry_postcode'] = $this->language->get('entry_postcode');
		$this->data['entry_country'] = $this->language->get('entry_country');
		$this->data['entry_zone'] = $this->language->get('entry_zone');
		$this->data['entry_zone_code'] = $this->language->get('entry_zone_code');
		$this->data['entry_city'] = $this->language->get('entry_city');
		$this->data['entry_address_1'] = $this->language->get('entry_address_1');
		$this->data['entry_address_2'] = $this->language->get('entry_address_2');
		$this->data['entry_company'] = $this->language->get('entry_company');
		$this->data['entry_company_id'] = $this->language->get('entry_company_id');
		$this->data['entry_tax_id'] = $this->language->get('entry_tax_id');
		$this->data['entry_affiliate'] = $this->language->get('entry_affiliate');
		$this->data['entry_order_status'] = $this->language->get('entry_order_status');
		$this->data['entry_comment'] = $this->language->get('entry_comment');
		$this->data['entry_comment_customer'] = $this->language->get('entry_comment_customer');
		$this->data['entry_shipping'] = $this->language->get('entry_shipping');
		$this->data['entry_payment'] = $this->language->get('entry_payment');
		$this->data['entry_coupon'] = $this->language->get('entry_coupon');
		$this->data['entry_voucher'] = $this->language->get('entry_voucher');
		$this->data['entry_discount'] = $this->language->get('entry_discount');
		$this->data['entry_correct'] = $this->language->get('entry_correct');
		$this->data['entry_tax'] = $this->language->get('entry_tax');
		$this->data['entry_reward'] = $this->language->get('entry_reward');
		$this->data['entry_reward_use'] = $this->language->get('entry_reward_use');
		$this->data['entry_reward_recived'] = $this->language->get('entry_reward_recived');
		$this->data['entry_reward_total'] = $this->language->get('entry_reward_total');
		$this->data['entry_reward_max'] = $this->language->get('entry_reward_max');
		$this->data['entry_notify'] = $this->language->get('entry_notify');
		$this->data['entry_license'] = $this->language->get('entry_license');
		$this->data['entry_show_pid'] = $this->language->get('entry_show_pid');
		$this->data['entry_show_image'] = $this->language->get('entry_show_image');
		$this->data['entry_show_model'] = $this->language->get('entry_show_model');
		$this->data['entry_show_sku'] = $this->language->get('entry_show_sku');
		$this->data['entry_show_ean'] = $this->language->get('entry_show_ean');
		$this->data['entry_show_jan'] = $this->language->get('entry_show_jan');
		$this->data['entry_show_location'] = $this->language->get('entry_show_location');
		$this->data['entry_show_mpn'] = $this->language->get('entry_show_mpn');
		$this->data['entry_show_upc'] = $this->language->get('entry_show_upc');
		$this->data['entry_show_isbn'] = $this->language->get('entry_show_isbn');
		$this->data['entry_invoice_type'] = $this->language->get('entry_invoice_type');
		$this->data['entry_virtual_customer'] = $this->language->get('entry_virtual_customer');

		$this->data['button_upload'] = $this->language->get('button_upload');
		$this->data['button_invoce'] = $this->language->get('button_invoce');
		$this->data['button_clone'] = $this->language->get('button_clone');
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_add_product'] = $this->language->get('button_add_product');
		$this->data['button_remove'] = $this->language->get('button_remove');
		$this->data['button_create_account'] = $this->language->get('button_create_account');
		$this->data['button_discount'] = $this->language->get('button_discount');
		$this->data['button_correct'] = $this->language->get('button_correct');
		$this->data['button_add_history'] = $this->language->get('button_add_history');
		$this->data['button_recalculate'] = $this->language->get('button_recalculate');
		$this->data['button_save_setting'] = $this->language->get('button_save_setting');
		
		$this->data['help_registered'] = $this->language->get('help_registered');
		$this->data['help_registered_head'] = $this->language->get('help_registered_head');
		$this->data['help_order_status_head'] = $this->language->get('help_order_status_head');
		$this->data['help_order_status'] = $this->language->get('help_order_status');
		$this->data['help_empty_prices_head'] = $this->language->get('help_empty_prices_head');
		$this->data['help_empty_prices'] = $this->language->get('help_empty_prices');
		$this->data['help_empty_discount_head'] = $this->language->get('help_empty_discount_head');
		$this->data['help_empty_discount'] = $this->language->get('help_empty_discount');
		$this->data['help_autocomplite'] = $this->language->get('help_autocomplite');
		$this->data['help_price'] = $this->language->get('help_price');
		$this->data['help_now_price'] = $this->language->get('help_now_price');
		$this->data['help_qty'] = $this->language->get('help_qty');
		$this->data['help_stock'] = $this->language->get('help_stock');
		$this->data['help_product_discount'] = $this->language->get('help_product_discount');
		$this->data['help_nocalc_head'] = $this->language->get('help_nocalc_head');
		$this->data['help_nocalc'] = $this->language->get('help_nocalc');
		$this->data['help_coupon_head'] = $this->language->get('help_coupon_head');
		$this->data['help_coupon'] = $this->language->get('help_coupon');
		$this->data['help_coupon_use'] = $this->language->get('help_coupon_use');
		$this->data['help_voucher_head'] = $this->language->get('help_voucher_head');
		$this->data['help_voucher'] = $this->language->get('help_voucher');
		$this->data['help_voucher_use'] = $this->language->get('help_voucher_use');
		$this->data['help_discount_head'] = $this->language->get('help_discount_head');
		$this->data['help_discount'] = $this->language->get('help_discount');
		$this->data['help_correct_head'] = $this->language->get('help_correct_head');
		$this->data['help_correct'] = $this->language->get('help_correct');
		$this->data['help_recalculate_head'] = $this->language->get('help_recalculate_head');
		$this->data['help_recalculate'] = $this->language->get('help_recalculate');
		$this->data['help_recalculate_bad'] = $this->language->get('help_recalculate_bad');
		$this->data['help_reward_removed_head'] = $this->language->get('help_reward_removed_head');
		$this->data['help_reward_removed'] = $this->language->get('help_reward_removed');
		$this->data['help_reward_add_head'] = $this->language->get('help_reward_add_head');
		$this->data['help_reward_add'] = $this->language->get('help_reward_add');
		$this->data['help_reward_use_head'] = $this->language->get('help_reward_use_head');
		$this->data['help_reward_use'] = $this->language->get('help_reward_use');
		$this->data['help_commission_add_head'] = $this->language->get('help_commission_add_head');
		$this->data['help_commission_add'] = $this->language->get('help_commission_add');
		$this->data['help_commission_remove_head'] = $this->language->get('help_commission_remove_head');
		$this->data['help_commission_remove'] = $this->language->get('help_commission_remove');
		$this->data['help_virtual_customer'] = $this->language->get('help_virtual_customer');
		
		$this->data['tab_order'] = $this->language->get('tab_order');
		$this->data['tab_order_history'] = $this->language->get('tab_order_history');
		$this->data['tab_product'] = $this->language->get('tab_product');
		$this->data['tab_payment'] = $this->language->get('tab_payment');
		$this->data['tab_shipping'] = $this->language->get('tab_shipping');
		$this->data['tab_total'] = $this->language->get('tab_total');
		$this->data['tab_setting'] = $this->language->get('tab_setting');
		
		/* Шаблоны смс начало */
		$this->data['nameshablon1'] = $this->config->get('vipsms_net_nameshablon1');
		$this->data['shablon1'] = $this->config->get('vipsms_net_shablon1');
		
		$this->data['nameshablon2'] = $this->config->get('vipsms_net_nameshablon2');
		$this->data['shablon2'] = $this->config->get('vipsms_net_shablon2');
		
		$this->data['nameshablon3'] = $this->config->get('vipsms_net_nameshablon3');
		$this->data['shablon3'] = $this->config->get('vipsms_net_shablon3');
		
		$this->data['nameshablon4'] = $this->config->get('vipsms_net_nameshablon4');
		$this->data['shablon4'] = $this->config->get('vipsms_net_shablon4');
		
		$this->data['nameshablon5'] = $this->config->get('vipsms_net_nameshablon5');
		$this->data['shablon5'] = $this->config->get('vipsms_net_shablon5');
		/* Шаблоны смс конец */
		
		$this->data['success_order_history'] = $this->language->get('success_order_history');

		$this->data['token'] = $this->session->data['token'];

		if (isset($this->error['warning'])) {
				$this->data['error_warning'] = $this->error['warning'];
		} else {
				$this->data['error_warning'] = '';
		}

		if (isset($this->error['firstname'])) {
				$this->data['error_firstname'] = $this->error['firstname'];
		} else {
				$this->data['error_firstname'] = '';
		}

		if (isset($this->error['email'])) {
				$this->data['error_email'] = $this->error['email'];
		} else {
				$this->data['error_email'] = '';
		}

		if (isset($this->error['shipping_firstname'])) {
				$this->data['error_shipping_firstname'] = $this->error['shipping_firstname'];
		} else {
				$this->data['error_shipping_firstname'] = '';
		}

		if (isset($this->error['payment_method'])) {
				$this->data['error_payment_method'] = $this->error['payment_method'];
		} else {
				$this->data['error_payment_method'] = '';
		}
		
		if (isset($this->error['shipping_method'])) {
				$this->data['error_shipping_method'] = $this->error['shipping_method'];
		} else {
				$this->data['error_shipping_method'] = '';
		}

		$url = '';

		if (isset($this->request->get['filter_order_id'])) {
				$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
		}

		if (isset($this->request->get['filter_customer'])) {
				$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_order_status_id'])) {
				$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
		}

		if (isset($this->request->get['filter_total'])) {
				$url .= '&filter_total=' . $this->request->get['filter_total'];
		}

		if (isset($this->request->get['filter_date_added'])) {
				$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if (isset($this->request->get['filter_date_modified'])) {
				$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
		}

		if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_home'),
				'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
				'separator' => false
		);

		/*$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('heading_title'),
				'href'      => $this->url->link('sale/orderpro', 'token=' . $this->session->data['token'], 'SSL'),
				'separator' => ' :: '
		);*/
		
		$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('heading_title'),
				'href'      => $this->url->link('sale/order', 'token=' . $this->session->data['token'], 'SSL'),
				'separator' => ' :: '
		);

		if (!isset($this->request->get['order_id'])) {
			$this->data['action'] = $this->url->link('sale/orderpro/edit', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('sale/orderpro/edit', 'token=' . $this->session->data['token'] . '&order_id=' . $this->request->get['order_id'] . $url, 'SSL');
		}

		$this->data['cancel'] = $this->url->link('sale/orderpro', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$this->data['clone'] = '';

		if (isset($this->request->get['order_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$order_info = $this->model_sale_orderpro->getOrder($this->request->get['order_id']);
			$this->data['order_id'] = $this->request->get['order_id'];
		} elseif (!isset($this->request->get['order_id'])) {
			$this->data['order_id'] = '';
		} else {
			$this->data['order_id'] = $this->request->get['order_id'];
		}
		
		$this->data['temp_order_id'] = mt_rand(777777, 999999);

		if (isset($this->request->post['store_id'])) {
			$this->data['store_id'] = $this->request->post['store_id'];
		} elseif (isset($order_info)) {
			$this->data['store_id'] = $order_info['store_id'];
		} else {
			$this->data['store_id'] = '0';
		}
		
		if (isset($this->request->post['orderpro_license'])) {
			$this->data['orderpro_license'] = $this->request->post['orderpro_license'];
		} else {
			$this->data['orderpro_license'] = $this->config->get('orderpro_license');
		}
		
		
		if (isset($this->request->post['orderpro_show_pid'])) {
			$this->data['orderpro_show_pid'] = $this->request->post['orderpro_show_pid'];
		} else {
			$this->data['orderpro_show_pid'] = $this->config->get('orderpro_show_pid');
		}
		
		if (isset($this->request->post['orderpro_show_image'])) {
			$this->data['orderpro_show_image'] = $this->request->post['orderpro_show_image'];
		} else {
			$this->data['orderpro_show_image'] = $this->config->get('orderpro_show_image');
		}
		
		if (isset($this->request->post['orderpro_show_model'])) {
			$this->data['orderpro_show_model'] = $this->request->post['orderpro_show_model'];
		} else {
			$this->data['orderpro_show_model'] = $this->config->get('orderpro_show_model');
		}
		
		if (isset($this->request->post['orderpro_show_sku'])) {
			$this->data['orderpro_show_sku'] = $this->request->post['orderpro_show_sku'];
		} else {
			$this->data['orderpro_show_sku'] = $this->config->get('orderpro_show_sku');
		}
		
		if (isset($this->request->post['orderpro_show_mpn'])) {
			$this->data['orderpro_show_mpn'] = $this->request->post['orderpro_show_mpn'];
		} else {
			$this->data['orderpro_show_mpn'] = $this->config->get('orderpro_show_mpn');
		}
		
		if (isset($this->request->post['orderpro_show_upc'])) {
			$this->data['orderpro_show_upc'] = $this->request->post['orderpro_show_upc'];
		} else {
			$this->data['orderpro_show_upc'] = $this->config->get('orderpro_show_upc');
		}
		
		if (isset($this->request->post['orderpro_show_isbn'])) {
			$this->data['orderpro_show_isbn'] = $this->request->post['orderpro_show_isbn'];
		} else {
			$this->data['orderpro_show_isbn'] = $this->config->get('orderpro_show_isbn');
		}
		
		if (isset($this->request->post['orderpro_show_ean'])) {
			$this->data['orderpro_show_ean'] = $this->request->post['orderpro_show_ean'];
		} else {
			$this->data['orderpro_show_ean'] = $this->config->get('orderpro_show_ean');
		}
		
		if (isset($this->request->post['orderpro_show_jan'])) {
			$this->data['orderpro_show_jan'] = $this->request->post['orderpro_show_jan'];
		} else {
			$this->data['orderpro_show_jan'] = $this->config->get('orderpro_show_jan');
		}
		
		if (isset($this->request->post['orderpro_show_location'])) {
			$this->data['orderpro_show_location'] = $this->request->post['orderpro_show_location'];
		} else {
			$this->data['orderpro_show_location'] = $this->config->get('orderpro_show_location');
		}
		
		if (isset($this->request->post['orderpro_invoice_type'])) {
			$this->data['orderpro_invoice_type'] = $this->request->post['orderpro_invoice_type'];
		} else {
			$this->data['orderpro_invoice_type'] = $this->config->get('orderpro_invoice_type');
		}
		
		if ($this->data['orderpro_invoice_type']) {
			$this->data['invoice'] = $this->url->link('sale/orderpro/invoice', 'token=' . $this->session->data['token'], 'SSL');
		} else {
			$this->data['invoice'] = $this->url->link('sale/order/invoice', 'token=' . $this->session->data['token'], 'SSL');
		}
		
		$this->data['show_pid'] = $this->data['orderpro_show_pid'];
		$this->data['show_image'] = $this->data['orderpro_show_image'];
		$this->data['show_model'] = $this->data['orderpro_show_model'];
		$this->data['show_sku'] = $this->data['orderpro_show_sku'];
		$this->data['show_ean'] = $this->data['orderpro_show_ean'];
		$this->data['show_jan'] = $this->data['orderpro_show_jan'];
		$this->data['show_location'] = $this->data['orderpro_show_location'];
		$this->data['show_mpn'] = $this->data['orderpro_show_mpn'];
		$this->data['show_upc'] = $this->data['orderpro_show_upc'];
		$this->data['show_isbn'] = $this->data['orderpro_show_isbn'];
		
		if (isset($this->request->post['orderpro_virtual_customer'])) {
			$this->data['orderpro_virtual_customer'] = $this->request->post['orderpro_virtual_customer'];
		} else {
			$this->data['orderpro_virtual_customer'] = $this->config->get('orderpro_virtual_customer');
		}

		$this->load->model('localisation/language');

		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		
		if (isset($order_info)) {
			foreach ($this->data['languages'] as $language) {
				if ($language['language_id'] == $order_info['language_id']) {
					$this->data['admin_language'] = $language['code'];
				}
			}
		} else {
			$this->data['admin_language'] = $this->config->get('config_admin_language');
		}

		$this->load->model('setting/store');

		$this->data['stores'] = $this->model_setting_store->getStores();
		
		if ($this->config->get('config_use_ssl')) {
			$this->data['store_url'] = HTTPS_CATALOG;
		} else {
			$this->data['store_url'] = HTTP_CATALOG;
		}

		if (isset($this->request->post['customer_id'])) {
			$this->data['customer_id'] = $this->request->post['customer_id'];
		} elseif (isset($order_info)) {
			$this->data['customer_id'] = $order_info['customer_id'];
		} else {
			$this->data['customer_id'] = '';
		}

		$this->data['reward_status'] = $this->config->get('reward_status');
		
		$this->load->model('sale/customer');

		if (!empty($this->data['customer_id'])) {
			$customer_info = $this->model_sale_customer->getCustomer($this->data['customer_id']);
			
			if (isset($customer_info['customer_group_id'])) {
				$this->data['customer_group_id'] = $customer_info['customer_group_id'];
				$customer_group_id = $customer_info['customer_group_id'];
			} else {
				$this->data['customer_group_id'] = $this->config->get('config_customer_group_id');
				$customer_group_id = $this->config->get('config_customer_group_id');
			}

			if (isset($this->request->post['reward_use'])) {
				$this->data['reward_use'] = $this->request->post['reward_use'];
			} elseif (isset($order_info)) {
				$reward_use = $this->model_sale_orderpro->getUsedRewardsByOrderId($this->data['order_id']);
				$this->data['reward_use'] = $reward_use * -1;
			} else {
				$this->data['reward_use'] = '0';
			}

			$reward_total = $this->model_sale_customer->getRewardTotal($this->data['customer_id']);
			
			if ($reward_total) {
				$this->data['reward_total'] = $reward_total;
			} else {
				$this->data['reward_total'] = '0';
			}

			if (isset($this->request->post['reward_cart'])) {
				$this->data['reward_cart'] = $this->request->post['reward_cart'];
			} elseif (isset($order_info['reward'])) {
				$this->data['reward_cart'] = $order_info['reward'];
			} else {
				$this->data['reward_cart'] = '0';
			}

			if (isset($this->request->post['reward_recived'])) {
				$this->data['reward_recived'] = $this->request->post['reward_recived'];
			} elseif (isset($order_info)) {
				$reward_recived = $this->model_sale_orderpro->getReceivedRewardsByOrderId($this->data['order_id']);
				if ($reward_recived) {
					$this->data['reward_recived'] = $reward_recived;
				} else {
					$this->data['reward_recived'] = '0';
				}
			} else {
				$this->data['reward_recived'] = '0';
			}
			
			$this->data['reward_possibly'] = $this->data['reward_total'] - $this->data['reward_recived'];
			
			if ($this->config->get('orderpro_virtual_customer')) {
				
				$virtual_customer_id = $this->model_sale_orderpro->getVirtualCustomer($customer_group_id);
				
				if (isset($this->request->post['virtual_customer_id'])) {
					$this->data['virtual_customer_id'] = $this->request->post['virtual_customer_id'];
				} elseif ($virtual_customer_id) {
					$this->data['virtual_customer_id'] = $virtual_customer_id;
				} else {
					$this->data['virtual_customer_id'] = $this->model_sale_orderpro->addVirtualCustomer($customer_group_id);
				}

			} else {
				$this->data['virtual_customer_id'] = '';
			}
			
		} else {
			
			$this->data['customer_group_id'] = $this->config->get('config_customer_group_id');
			$customer_group_id = $this->config->get('config_customer_group_id');
			$this->data['virtual_customer_id'] = '';

			$this->data['reward_use'] = '0';
			$this->data['reward_total'] = '0';
			$this->data['reward_possibly'] = '0';
			$this->data['reward'] = '0';
			$this->data['reward_recived'] = '0';
		}

		$this->data['entry_code'] = $this->language->get('entry_code');

		if (isset($this->request->post['customer'])) {
			$this->data['customer'] = $this->request->post['customer'];
		} elseif (isset($order_info)) {
			$this->data['customer'] = $order_info['customer'];
		} else {
			$this->data['customer'] = '';
		}

		$this->load->model('sale/customer_group');

		$customer_group_info = $this->model_sale_customer_group->getCustomerGroup($customer_group_id);
		
		if ($customer_group_info['company_id_display'] == '1') {
			$this->data['company_id_display'] = true;
		} else {
			$this->data['company_id_display'] = false;
		}
		
		if ($customer_group_info['company_id_required'] == '1') {
			$this->data['company_id_required'] = true;
		} else {
			$this->data['company_id_required'] = false;
		}
		
		if ($customer_group_info['tax_id_display'] == '1') {
			$this->data['tax_id_display'] = true;
		} else {
			$this->data['tax_id_display'] = false;
		}
		
		if ($customer_group_info['tax_id_required'] == '1') {
			$this->data['tax_id_required'] = true;
		} else {
			$this->data['tax_id_required'] = false;
		}

		if (isset($this->request->post['firstname'])) {
			$this->data['firstname'] = $this->request->post['firstname'];
		} elseif (isset($order_info)) { 
			$this->data['firstname'] = $order_info['firstname'];
		} else {
			$this->data['firstname'] = '';
		}

		if (isset($this->request->post['lastname'])) {
			$this->data['lastname'] = $this->request->post['lastname'];
		} elseif (isset($order_info)) { 
			$this->data['lastname'] = $order_info['lastname'];
		} else {
			$this->data['lastname'] = '';
		}

		if (isset($this->request->post['email'])) {
			$this->data['email'] = $this->request->post['email'];
		} elseif (isset($order_info)) {
			$this->data['email'] = $order_info['email'];
		} else {
			$this->data['email'] = '';
		}

		if (isset($this->request->post['telephone'])) {
			$this->data['telephone'] = $this->request->post['telephone'];
		} elseif (isset($order_info)) { 
			$this->data['telephone'] = $order_info['telephone'];
		} else {
			$this->data['telephone'] = '';
		}

		if (isset($this->request->post['fax'])) {
			$this->data['fax'] = $this->request->post['fax'];
		} elseif (isset($order_info)) { 
			$this->data['fax'] = $order_info['fax'];
		} else {
			$this->data['fax'] = '';
		}


		if (isset($this->request->post['ttn'])) {
			$this->data['ttn'] = $this->request->post['ttn'];
		} elseif (isset($order_info)) { 
			$this->data['ttn'] = $order_info['ttn'];
		} else {
			$this->data['ttn'] = '';
		}

						
					
		if (isset($this->request->post['customer_id'])) {
			$this->data['addresses'] = $this->model_sale_customer->getAddresses($this->request->post['customer_id']);
		} elseif (isset($order_info)) {
			$this->data['addresses'] = $this->model_sale_customer->getAddresses($order_info['customer_id']);
		} else {
			$this->data['addresses'] = array();
		}

		if (isset($this->request->post['invoice_no'])) {
			$this->data['invoice_no'] = $this->request->post['invoice_no'];
		} elseif (isset($order_info['invoice_no'])) {
			$this->data['invoice_no'] = $order_info['invoice_no'];
		} else {
			$invoice_prefix = $this->config->get('config_invoice_prefix');
			
			$query = $this->db->query("SELECT MAX(invoice_no) AS invoice_no FROM `" . DB_PREFIX . "order` WHERE invoice_prefix = '" . $this->db->escape($invoice_prefix) . "'");

			if ($query->row['invoice_no']) {
				$this->data['invoice_no'] = (int)$query->row['invoice_no'] + 1;
			} else {
				$this->data['invoice_no'] = 1;
			}
		}

		if (isset($this->request->post['shipping_firstname'])) {
			$this->data['shipping_firstname'] = $this->request->post['shipping_firstname'];
		} elseif (isset($order_info)) {
			$this->data['shipping_firstname'] = $order_info['shipping_firstname'];
		} else {
			$this->data['shipping_firstname'] = '';
		}

		if (isset($this->request->post['shipping_lastname'])) {
			$this->data['shipping_lastname'] = $this->request->post['shipping_lastname'];
		} elseif (isset($order_info)) {
			$this->data['shipping_lastname'] = $order_info['shipping_lastname'];
		} else {
			$this->data['shipping_lastname'] = '';
		}

		if (isset($this->request->post['shipping_company'])) {
			$this->data['shipping_company'] = $this->request->post['shipping_company'];
		} elseif (isset($order_info)) {
			$this->data['shipping_company'] = $order_info['shipping_company'];
		} else {
			$this->data['shipping_company'] = '';
		}
		
		if (isset($this->request->post['shipping_address_1'])) {
			$this->data['shipping_address_1'] = $this->request->post['shipping_address_1'];
		} elseif (isset($order_info)) { 
			$this->data['shipping_address_1'] = $order_info['shipping_address_1'];
		} else {
			$this->data['shipping_address_1'] = '';
		}

		if (isset($this->request->post['shipping_address_2'])) {
			$this->data['shipping_address_2'] = $this->request->post['shipping_address_2'];
		} elseif (isset($order_info)) { 
			$this->data['shipping_address_2'] = $order_info['shipping_address_2'];
		} else {
			$this->data['shipping_address_2'] = '';
		}

		if (isset($this->request->post['shipping_city'])) {
			$this->data['shipping_city'] = $this->request->post['shipping_city'];
		} elseif (isset($order_info)) { 
			$this->data['shipping_city'] = $order_info['shipping_city'];
		} else {
			$this->data['shipping_city'] = '';
		}

		if (isset($this->request->post['shipping_postcode'])) {
			$this->data['shipping_postcode'] = $this->request->post['shipping_postcode'];
		} elseif (isset($order_info)) { 
			$this->data['shipping_postcode'] = $order_info['shipping_postcode'];
		} else {
			$this->data['shipping_postcode'] = '';
		}

		if (isset($this->request->post['shipping_country_id'])) {
			$this->data['shipping_country_id'] = $this->request->post['shipping_country_id'];
		} elseif (isset($order_info)) { 
			$this->data['shipping_country_id'] = $order_info['shipping_country_id'];
		} else {
			$this->data['shipping_country_id'] = '';
		}		

		if (isset($this->request->post['shipping_zone_id'])) {
			$this->data['shipping_zone_id'] = $this->request->post['shipping_zone_id'];
		} elseif (isset($order_info)) { 
			$this->data['shipping_zone_id'] = $order_info['shipping_zone_id'];
		} else {
			$this->data['shipping_zone_id'] = '';
		}	

		if (isset($this->request->post['shipping_method'])) {
			$this->data['shipping_method'] = $this->request->post['shipping_method'];
		} elseif (isset($order_info['shipping_code']) && !empty($order_info['shipping_code'])) {
			$shipping_parts = explode('.', $order_info['shipping_code']);
			$this->data['shipping_method'] = $shipping_parts[0];
		} else {
			$this->data['shipping_method'] = '';
		}

		$this->data['shipping_methods'] = array();
		
		$this->load->model('setting/extension');
		$shipping_methods = $this->model_setting_extension->getInstalled('shipping');
		
		foreach ($shipping_methods as $method) {
			if ($this->config->get($method . '_status')) {
				$this->data['shipping_methods'][$method] = $this->config->get($method);
				$this->language->load('shipping/' . $method);
				$this->data['shipping_methods'][$method]['title'] = $this->language->get('heading_title');
			} elseif ($method == $this->data['shipping_method']) {
				$this->data['shipping_methods'][$method] = $this->config->get($method);
				$this->language->load('shipping/' . $method);
				$this->data['shipping_methods'][$method]['title'] = $this->language->get('heading_title');
			}
		}

		if (isset($this->request->post['payment_firstname'])) {
			$this->data['payment_firstname'] = $this->request->post['payment_firstname'];
		} elseif (isset($order_info)) {
			$this->data['payment_firstname'] = $order_info['payment_firstname'];
		} else {
			$this->data['payment_firstname'] = '';
		}

		if (isset($this->request->post['payment_lastname'])) {
			$this->data['payment_lastname'] = $this->request->post['payment_lastname'];
		} elseif (isset($order_info)) {
			$this->data['payment_lastname'] = $order_info['payment_lastname'];
		} else {
			$this->data['payment_lastname'] = '';
		}

		if (isset($this->request->post['payment_company'])) {
			$this->data['payment_company'] = $this->request->post['payment_company'];
		} elseif (!empty($order_info['payment_company'])) {
			$this->data['payment_company'] = $order_info['payment_company'];
		} else {
			$this->data['payment_company'] = '';
		}

		if (isset($this->request->post['payment_company_id'])) {
			$this->data['payment_company_id'] = $this->request->post['payment_company_id'];
		} elseif (!empty($order_info)) {
			$this->data['payment_company_id'] = $order_info['payment_company_id'];
		} else {
			$this->data['payment_company_id'] = '';
		}

		if (isset($this->request->post['payment_tax_id'])) {
			$this->data['payment_tax_id'] = $this->request->post['payment_tax_id'];
		} elseif (!empty($order_info)) {
			$this->data['payment_tax_id'] = $order_info['payment_tax_id'];
		} else {
			$this->data['payment_tax_id'] = '';
		}

		if (isset($this->request->post['payment_address_1'])) {
			$this->data['payment_address_1'] = $this->request->post['payment_address_1'];
		} elseif (isset($order_info)) {
			$this->data['payment_address_1'] = $order_info['payment_address_1'];
		} else {
			$this->data['payment_address_1'] = '';
		}

		if (isset($this->request->post['payment_address_2'])) {
			$this->data['payment_address_2'] = $this->request->post['payment_address_2'];
		} elseif (isset($order_info)) {
			$this->data['payment_address_2'] = $order_info['payment_address_2'];
		} else {
			$this->data['payment_address_2'] = '';
		}

		if (isset($this->request->post['payment_city'])) {
			$this->data['payment_city'] = $this->request->post['payment_city'];
		} elseif (isset($order_info)) {
			$this->data['payment_city'] = $order_info['payment_city'];
		} else {
			$this->data['payment_city'] = '';
		}

		if (isset($this->request->post['payment_postcode'])) {
			$this->data['payment_postcode'] = $this->request->post['payment_postcode'];
		} elseif (isset($order_info)) {
			$this->data['payment_postcode'] = $order_info['payment_postcode'];
		} else {
			$this->data['payment_postcode'] = '';
		}

		if (isset($this->request->post['payment_country_id'])) {
			$this->data['payment_country_id'] = $this->request->post['payment_country_id'];
		} elseif (isset($order_info)) {
			$this->data['payment_country_id'] = $order_info['payment_country_id'];
		} else {
			$this->data['payment_country_id'] = '';
		}

		if (isset($this->request->post['payment_zone_id'])) {
			$this->data['payment_zone_id'] = $this->request->post['payment_zone_id'];
		} elseif (isset($order_info)) {
			$this->data['payment_zone_id'] = $order_info['payment_zone_id'];
		} else {
			$this->data['payment_zone_id'] = '';
		}

		$country_data = $this->cache->get('country.status');

		if (!$country_data) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "country WHERE status = '1' ORDER BY name ASC");
			$country_data = $query->rows;
			$this->cache->set('country.status', $country_data);
		}

		$this->data['countries'] = $country_data;															

		if (isset($this->request->post['payment_method'])) {
			$this->data['payment_method'] = $this->request->post['payment_method'];
		} elseif (isset($order_info['payment_code']) && !empty($order_info['payment_code'])) {
			$this->data['payment_method'] = $order_info['payment_code'];
		} else {
			$this->data['payment_method'] = '';
		}

		$this->data['payment_methods'] = array();
		$payment_methods = array();
		$payment_methods = $this->model_setting_extension->getInstalled('payment');

		foreach ($payment_methods as $method) {
			if ($this->config->get($method . '_status')) {
				$this->data['payment_methods'][$method] = $this->config->get($method);
				$this->language->load('payment/' . $method);
				$this->data['payment_methods'][$method]['title'] = $this->language->get('heading_title');
			} elseif ($method == $this->data['payment_method']) {
				$this->data['payment_methods'][$method] = $this->config->get($method);
				$this->language->load('payment/' . $method);
				$this->data['payment_methods'][$method]['title'] = $this->language->get('heading_title');
			}
		}

		if (isset($this->request->post['affiliate_id'])) {
			$this->data['affiliate_id'] = $this->request->post['affiliate_id'];
		} elseif (isset($order_info['affiliate_id'])) { 
			$this->data['affiliate_id'] = $order_info['affiliate_id'];
		} else {
			$this->data['affiliate_id'] = '';
		}

		$this->load->model('sale/affiliate');
		
		if (isset($this->request->post['affiliate'])) {
			$this->data['affiliate'] = $this->request->post['affiliate'];
		} elseif (!empty($order_info['affiliate_id']) && !empty($order_info['commission'])) {
			$affiliate_info = $this->model_sale_affiliate->getAffiliate($order_info['affiliate_id']);
			$this->data['affiliate'] = $affiliate_info['firstname'] . ' ' . $affiliate_info['lastname'];
		} else {
			$this->data['affiliate'] = '';
		}

		if (isset($this->request->post['commission'])) {
			$this->data['commission'] = $this->request->post['commission'];
		} elseif (isset($order_info['commission'])) { 
			$this->data['commission'] = $order_info['commission'];
		} else {
			$this->data['commission'] = '0';
		}

		if (isset($this->request->post['order_status_id'])) {
			$this->data['order_status_id'] = $this->request->post['order_status_id'];
		} elseif (isset($order_info)) { 
			$this->data['order_status_id'] = $order_info['order_status_id'];
		} else {
			$this->data['order_status_id'] = '';
		}

		$this->load->model('localisation/order_status');

		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (isset($this->request->post['comment'])) {
			$this->data['comment'] = $this->request->post['comment'];
		} elseif (isset($order_info)) { 
			$this->data['comment'] = $order_info['comment'];
		} else {
			$this->data['comment'] = '';
		}
		
		if (isset($this->request->post['date_added'])) {
			$this->data['date_added'] = $this->request->post['date_added'];
			$this->data['order_number'] = sprintf($this->language->get('text_order_number'), $this->data['order_id'], date('j.m.Y G:i', strtotime($this->request->post['date_added'])));
		} elseif (isset($order_info['date_added'])) {
			$this->data['date_added'] = $order_info['date_added'];
			$this->data['order_number'] = sprintf($this->language->get('text_order_number'), $this->data['order_id'], date('j.m.Y G:i', strtotime($order_info['date_added'])));
		} else {
			$this->data['date_added'] = '';
			$this->data['order_number'] = $this->data['order_id'];
		}
		
		if (isset($this->request->post['ip'])) {
			$this->data['ip'] = $this->request->post['ip'];
		} elseif (isset($order_info['ip'])) {
			$this->data['ip'] = $order_info['ip'];
		} else {
			$this->data['ip'] = '';
		}

		$this->load->model('localisation/currency');
		$this->data['currencies'] = $this->model_localisation_currency->getCurrencies();

		if (isset($this->request->post['currency_code'])) {
			$this->data['currency_code'] = $this->request->post['currency_code'];
			$currency_info = $this->model_localisation_currency->getCurrencyByCode($this->data['currency_code']);
			$currency_code = $currency_info['code'];
			$currency_value = $currency_info['value'];
		} elseif (isset($order_info['currency_code'])) {
			$this->data['currency_code'] = $order_info['currency_code'];
			$currency_info = $this->model_localisation_currency->getCurrencyByCode($order_info['currency_code']);
			$currency_code = $currency_info['code'];
			$currency_value = $currency_info['value'];
		} else {
			$this->data['currency_code'] = $this->config->get('config_currency');
		}

		if (isset($this->request->get['order_id']) && isset($currency_code)) {
			$this->data['commission_order'] = $this->currency->format($this->data['commission'], $currency_code, $currency_value);
			$this->data['commission_total'] = $this->model_sale_affiliate->getTotalTransactionsByOrderId($this->request->get['order_id']);
		} else {
			$this->data['commission_order'] = '';
			$this->data['commission_total'] = '';
		}

		$this->load->model('catalog/product');
		$this->load->model('tool/image');

		$this->data['order_products'] = array();
		
		if (isset($this->request->post['order_product'])) {
			$order_products = $this->request->post['order_product'];
		} elseif (isset($order_info)) {
			$order_products = $this->model_sale_orderpro->getOrderProducts($this->request->get['order_id']);			
		} else {
			$order_products = array();
		}
		
		$status_off_warning = false;
		$status_del_warning = false;
		$this->data['status_off_warning'] = false;
		$this->data['status_del_warning'] = false;

		foreach ($order_products as $order_product) {
			
			if ($this->request->server['REQUEST_METHOD'] == 'POST') {
				if (isset($order_product['option'])) {
					$order_options = $order_product['option'];
				} else {
					$order_options = array();
				}
			} else {
				$order_options = $this->model_sale_orderpro->getOrderOptions($this->request->get['order_id'], $order_product['order_product_id']);
			}

			$option_data = array();
			$order_option = array();
			
			$product_options = $this->model_catalog_product->getProductOptions($order_product['product_id']);	

			if ($product_options) {
				foreach ($product_options as $product_option) {
					if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {
							$option_value_data = array();

							foreach ($product_option['product_option_value'] as $product_option_value) {
								if (isset($order_product['option'][$product_option_value['option_value_id']]) && !in_array($order_product['option'][$product_option_value['option_value_id']], $order_option)) {
									$order_option[] = $order_product['option'][$product_option_value['option_value_id']];
								} else {
									foreach ($order_options as $order_option_data) {
										if (!in_array($order_option_data['product_option_value_id'], $order_option)) {
											$order_option[] = $order_option_data['product_option_value_id'];
										}
									}
								}
								
								if ((float)$product_option_value['price']) {
									$oprice = $this->currency->format($product_option_value['price'], $this->config->get('config_currency'));
								} else {
									$oprice = false;
								}

								$option_value_data[] = array(
										'product_option_value_id' => $product_option_value['product_option_value_id'],
										'option_value_id'         => $product_option_value['option_value_id'],
										'name'                    => $product_option_value['name'],
										'price'                   => $oprice,
										'price_prefix'            => $product_option_value['price_prefix']
								);
							}

							$option_data[] = array(
									'product_option_id' => $product_option['product_option_id'],
									'option_id'         => $product_option['option_id'],
									'name'              => $product_option['name'],
									'type'              => $product_option['type'],
									'option_value'      => $option_value_data,
									'required'          => $product_option['required']
							);

					} elseif ($product_option['type'] == 'text' || $product_option['type'] == 'textarea' || $product_option['type'] == 'time' || $product_option['type'] == 'date' || $product_option['type'] == 'datetime') {
							
							$option_value = '';
							
							foreach ($order_options as $order_option_data) {
								if ($order_option_data['product_option_id'] == $product_option['product_option_id']) {
									$option_value = $order_option_data['value'];
								}
							}
								
							$option_data[] = array(
									'product_option_id' => $product_option['product_option_id'],
									'option_id'         => $product_option['option_id'],
									'name'              => $product_option['name'],
									'type'              => $product_option['type'],
									'option_value'      => $option_value,
									'required'          => $product_option['required']
							);

					} elseif ($product_option['type'] == 'file') {
							
							$option_value = '';
							$option_href = '';
							
							foreach ($order_options as $order_option_data) {
								if ($order_option_data['product_option_id'] == $product_option['product_option_id']) {
									$option_value = utf8_substr($order_option_data['value'], 0, utf8_strrpos($order_option_data['value'], '.'));
									$option_href = $this->url->link('sale/orderpro/download', 'token=' . $this->session->data['token'] . '&order_id=' . $this->request->get['order_id'] . '&order_option_id=' . $order_option_data['order_option_id'], 'SSL');
								}
							}
								
							$option_data[] = array(
									'product_option_id' => $product_option['product_option_id'],
									'option_id'         => $product_option['option_id'],
									'name'              => $product_option['name'],
									'type'              => $product_option['type'],
									'option_value'      => $option_value,
									'required'          => $product_option['required'],
									'href'              => $option_href
							);
					}
				}
			}
			
			$realquantity = 0;
			$now_price = 0;
			$now_special = 0;
			$now_points = 0;
			$now_status = 3;
			$now_image = '';
			$now_popap = false;
			$now_href = '';

			$product_info = $this->model_catalog_product->getProduct($order_product['product_id'], $customer_group_id);
			
			if ($product_info) {
				$realquantity = $product_info['quantity'];
				$now_price = number_format($product_info['price'], 2, '.', '');
				$now_special = number_format($product_info['special'], 2, '.', '');
				$now_points = $product_info['points'];
				$now_status = $product_info['status'];
				$now_href = str_replace(HTTPS_SERVER, HTTPS_CATALOG, $this->url->link('product/product', 'product_id=' . $product_info['product_id']));

				if ($product_info['image'] && file_exists(DIR_IMAGE . $product_info['image'])) {
					$now_image = $this->model_tool_image->resize($product_info['image'], 45, 45);
					$now_popap = HTTPS_CATALOG . 'image/' . $product_info['image'];
				} else {
					$now_image = $this->model_tool_image->resize('no_image.jpg', 45, 45);
				}
			}
			
			if ($now_status == 0) {
				$status_off_warning = true;
			}
			
			if ($now_status == 3) {
				$status_del_warning = true;
			}
			
			$now_discount = 0;
			$now_discount_qty = 0;
			
			$product_discounts = $this->model_catalog_product->getOrderProductDiscounts($order_product['product_id'], $customer_group_id);
			
			if ($product_discounts) {
				foreach ($product_discounts as $product_discount) {
					$now_discount = number_format($product_discount['price'], 2, '.', '');
					$now_discount_qty = $product_discount['quantity'];
				}
			}
			
			if (isset($order_product['discount_amount']) && ($order_product['discount_amount'] > 0)) {
				$discount_amount = number_format($order_product['discount_amount'], 0, '.', '');
			} else {
				$discount_amount = 0;
			}
			
			$this->data['order_products'][] = array(
					'order_product_id' => (int)$order_product['order_product_id'],
					'product_id'       => (int)$order_product['product_id'],
					'name'             => $order_product['name'],
					'model'            => $order_product['model'],
					'sku'              => $order_product['sku'],
					'upc'              => $order_product['upc'],
					'ean'              => $order_product['ean'],
					'jan'              => $order_product['jan'],
					'isbn'             => $order_product['isbn'],
					'mpn'              => $order_product['mpn'],
					'location'         => $order_product['location'],
					'option'           => $option_data,
					'order_option'     => $order_option,
					'quantity'         => (int)$order_product['quantity'],
					'realquantity'     => $realquantity,
					'price'            => number_format($order_product['price'], 2, '.', ''),
					'now_price'        => $now_price,
					'now_special'      => $now_special,
					'now_discount'     => $now_discount,
					'now_discount_qty' => $now_discount_qty,
					'now_points'       => $now_points,
					'discount_amount'  => $discount_amount,
					'discount_type'    => $order_product['discount_type'],
					'total'            => number_format($order_product['total'], 2, '.', ''),
					'tax'              => number_format($order_product['tax'], 2, '.', ''),
					'reward'           => $order_product['reward'],
					'href'             => $now_href,
					'image'            => $now_image,
					'popap'            => $now_popap,
					'status'           => $now_status
			);
		}
		
		if ($this->data['order_products']) {
			foreach ($this->data['order_products'] as $key => $row) {
				$volume[$key]  = $row['name'];
				$edition[$key]  = $row['price'];
			}
			
			array_multisort($volume, SORT_ASC, $edition, SORT_ASC, $this->data['order_products']);
		}
		
		if ($status_off_warning) {
			$this->data['error_off_product'] = $this->language->get('error_off_product');
			$this->data['status_off_warning'] = true;
		}
		
		if ($status_del_warning) {
			$this->data['error_del_product'] = $this->language->get('error_del_product');
			$this->data['status_del_warning'] = true;
		}

		if ($this->data['order_id'] != '') {
			$order_coupon = $this->model_sale_orderpro->getCouponByOrderId($this->data['order_id']);
			if ($order_coupon) {
				$coupon_id = $order_coupon['coupon_id'];
			} else {
				$coupon_id = false;
			}
			
			$order_voucher = $this->model_sale_orderpro->getVoucherByOrderId($this->data['order_id']);
			if ($order_voucher) {
				$voucher_id = $order_voucher['voucher_id'];
			} else {
				$voucher_id = false;
			}
		} else {
			$coupon_id = false;
			$voucher_id = false;
		}
		
		$this->data['coupon_status'] = $this->config->get('coupon_status');
		
		if (isset($this->request->post['coupon_id'])) {
			$this->data['coupon'] = $this->request->post['coupon_id'];
		} elseif ($coupon_id) {
			$coupon_code = $this->model_sale_orderpro->getCodeCouponById($coupon_id);

			if ($coupon_code) {
				$this->data['coupon'] = $coupon_code;
			} else {
				$this->data['coupon'] = '';
			}
		} else {
			$this->data['coupon'] = '';
		}
		
		$this->data['voucher_status'] = $this->config->get('voucher_status');
		
		if (isset($this->request->post['voucher_id'])) {
			$this->data['voucher'] = $this->request->post['voucher_id'];
		} elseif ($voucher_id) {
			$voucher_code = $this->model_sale_orderpro->getCodeVoucherById($voucher_id);

			if ($voucher_code) {
				$this->data['voucher'] = $voucher_code;
			} else {
				$this->data['voucher'] = '';
			}
		} else {
			$this->data['voucher'] = '';
		}
		
		if (isset($this->request->post['order_total'])) {
			$this->data['order_totals'] = $this->request->post['order_total'];
		} elseif (isset($order_info)) {
			$this->data['order_totals'] = $this->model_sale_orderpro->getOrderTotals($this->request->get['order_id']);
		} else {
			$this->data['order_totals'] = array();
		}

		$this->load->model('localisation/tax_class');
		$this->data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();
		
		$this->document->addStyle('view/stylesheet/orderpro.css');
		$this->document->addStyle('view/javascript/cluetip/jquery.cluetip.css');
		$this->document->addStyle('view/javascript/jquery/colorbox/colorbox.css');

		$this->document->addScript('view/javascript/jquery/ajaxupload.js');
		$this->document->addScript('view/javascript/cluetip/jquery.cluetip.min.js');
		$this->document->addScript('view/javascript/jquery/colorbox/jquery.colorbox-min.js');

		$this->template = 'sale/orderpro.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);

		$this->response->setOutput($this->render());
	}
	
	public function saveSetting() {
		$json = array();

		$this->load->model('setting/setting');
		$this->language->load('sale/orderpro');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->user->hasPermission('modify', 'sale/orderpro')) {
			
			if (isset($this->request->post['orderpro_virtual_customer'])) {
				$this->load->model('sale/orderpro');
				$this->load->model('sale/customer_group');
			
				$customer_groups = $this->model_sale_customer_group->getCustomerGroups();
				
				foreach ($customer_groups as $customer_group) {
					$this->model_sale_orderpro->addVirtualCustomer($customer_group['customer_group_id'], $customer_group['name']);
				}
			}
			
			$this->model_setting_setting->deleteSetting('norder');
			$this->model_setting_setting->editSetting('orderpro', $this->request->post);

			$json['success'] = $this->language->get('success_save_setting');

		} else {
			$json['error'] = $this->language->get('error_permission');
		}
		
		$this->response->setOutput(json_encode($json));
	}

  	protected function validateForm() {
    	if (!$this->user->hasPermission('modify', 'sale/orderpro')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}

    	if ((utf8_strlen($this->request->post['firstname']) < 1) || (utf8_strlen($this->request->post['firstname']) > 32)) {
      		$this->error['firstname'] = $this->language->get('error_firstname');
    	}
		
		if (!$this->request->post['payment_method'] || $this->request->post['payment_method'] == '') {
			$this->error['payment_method'] = $this->language->get('error_payment');
		}

		if ((utf8_strlen($this->request->post['shipping_firstname']) < 1) || (utf8_strlen($this->request->post['shipping_firstname']) > 32)) {
			$this->error['shipping_firstname'] = $this->language->get('error_firstname');
		}
			
		if (!$this->request->post['shipping_method']) {
			$this->error['shipping_method'] = $this->language->get('error_shipping');
		}
		
		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}
		
		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		}
  	}
	
   	protected function validateDelete() {
    	if (!$this->user->hasPermission('modify', 'sale/orderpro')) {
			$this->error['warning'] = $this->language->get('error_permission');
    	}

		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		}
  	}
	
	protected function validateEmail($email) {
		$pattern = '/^[^@]+@.*.[a-z]{2,15}$/i';
		if (preg_match($pattern, $email)) {
				return true;
		} else {
				return false;
		}
	}
	
  	protected function validateNewCustomer() {
    	if (!$this->user->hasPermission('modify', 'sale/customer')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}

    	if ((utf8_strlen($this->request->post['firstname']) < 1) || (utf8_strlen($this->request->post['firstname']) > 32)) {
      		$this->error['firstname'] = $this->language->get('error_firstname');
    	}

		if (!$this->validateEmail($this->request->post['email'])) {
      		$this->error['email'] = $this->language->get('error_email');
    	}
		
		$customer_info = $this->model_sale_customer->getCustomerByEmail($this->request->post['email']);
		
		if (!isset($this->request->get['customer_id'])) {
			if ($customer_info) {
				$this->error['warning'] = $this->language->get('error_exists');
			}
		} else {
			if ($customer_info && ($this->request->get['customer_id'] != $customer_info['customer_id'])) {
				$this->error['warning'] = $this->language->get('error_exists');
			}
		}

		if (isset($this->request->post['address'])) {
			foreach ($this->request->post['address'] as $key => $value) {
				if ((utf8_strlen($value['firstname']) < 1) || (utf8_strlen($value['firstname']) > 32)) {
					$this->error['address_firstname'][$key] = $this->language->get('error_firstname');
				}
			}
		}
		
		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}
		
		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		}
  	}
	
	public function country() {
		$json = array();
		
		$this->load->model('localisation/country');

    	$country_info = $this->model_localisation_country->getCountry($this->request->get['country_id']);
		
		if ($country_info) {
			$this->load->model('localisation/zone');

			$json = array(
				'country_id'        => $country_info['country_id'],
				'name'              => $country_info['name'],
				'iso_code_2'        => $country_info['iso_code_2'],
				'iso_code_3'        => $country_info['iso_code_3'],
				'address_format'    => $country_info['address_format'],
				'postcode_required' => $country_info['postcode_required'],
				'zone'              => $this->model_localisation_zone->getZonesByCountryId($this->request->get['country_id']),
				'status'            => $country_info['status']		
			);
		}
		
		$this->response->setOutput(json_encode($json));
	}
	
	public function couponAutocomplete() {
		$json = array();

		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
			$filter_nomer = $this->request->get['filter_name'];

			$data = array(
					'filter_name'  => $filter_name,
					'filter_nomer' => $filter_nomer
			);

			$this->load->model('sale/orderpro');

			$results = $this->model_sale_orderpro->couponAutocomplete($data);

			foreach ($results as $result) {
					$json[] = array(
							'name'      => html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8') . ' (' . $result['code'] . ')',
							'code'      => $result['code']
					);	
			}
		}

		$this->response->setOutput(json_encode($json));
	}
	
	public function voucherAutocomplete() {
		$json = array();

		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
			$filter_nomer = $this->request->get['filter_name'];

			$data = array(
					'filter_name'  => $filter_name,
					'filter_nomer' => $filter_nomer
			);

			$this->load->model('sale/orderpro');

			$results = $this->model_sale_orderpro->voucherAutocomplete($data);

			foreach ($results as $result) {
					$json[] = array(
							'name'      => utf8_substr(html_entity_decode($result['message'], ENT_QUOTES, 'UTF-8'), 0, 25) . '...' . '(' . $result['code'] . ')',
							'code'      => $result['code']
					);	
			}
		}

		$this->response->setOutput(json_encode($json));
	}
	
	public function productAutocomplete() {
		$json = array();
		
		if (isset($this->request->get['filter_pid']) || isset($this->request->get['filter_name']) || isset($this->request->get['filter_model']) || isset($this->request->get['filter_sku']) || isset($this->request->get['filter_upc']) || isset($this->request->get['filter_ean']) || isset($this->request->get['filter_jan']) || isset($this->request->get['filter_isbn']) || isset($this->request->get['filter_mpn']) || isset($this->request->get['filter_location']) || isset($this->request->get['customer_group_id']) || isset($this->request->get['filter_category_id'])) {
			$this->load->model('catalog/product');
			$this->load->model('catalog/option');
			
			if (isset($this->request->get['filter_pid'])) {
				$filter_pid = $this->request->get['filter_pid'];
			} else {
				$filter_pid = '';
			}
			
			if (isset($this->request->get['filter_name'])) {
				$filter_name = $this->request->get['filter_name'];
			} else {
				$filter_name = '';
			}
			
			if (isset($this->request->get['filter_model'])) {
				$filter_model = $this->request->get['filter_model'];
			} else {
				$filter_model = '';
			}
			
			if (isset($this->request->get['filter_sku'])) {
				$filter_sku = $this->request->get['filter_sku'];
			} else {
				$filter_sku = '';
			}
			
			if (isset($this->request->get['filter_upc'])) {
				$filter_upc = $this->request->get['filter_upc'];
			} else {
				$filter_upc = '';
			}
			
			if (isset($this->request->get['filter_ean'])) {
				$filter_ean = $this->request->get['filter_ean'];
			} else {
				$filter_ean = '';
			}
			
			if (isset($this->request->get['filter_jan'])) {
				$filter_jan = $this->request->get['filter_jan'];
			} else {
				$filter_jan = '';
			}
			
			if (isset($this->request->get['filter_isbn'])) {
				$filter_isbn = $this->request->get['filter_isbn'];
			} else {
				$filter_isbn = '';
			}
			
			if (isset($this->request->get['filter_mpn'])) {
				$filter_mpn = $this->request->get['filter_mpn'];
			} else {
				$filter_mpn = '';
			}
			
			if (isset($this->request->get['filter_location'])) {
				$filter_location = $this->request->get['filter_location'];
			} else {
				$filter_location = '';
			}
			
			if (isset($this->request->get['customer_group_id'])) {
				$customer_group_id = $this->request->get['customer_group_id'];
			} else {
				$customer_group_id = $this->config->get('config_customer_group_id');
			}
			
			if (isset($this->request->get['limit'])) {
				$limit = $this->request->get['limit'];	
			} else {
				$limit = 20;	
			}

			$data = array(
				'filter_pid'   => $filter_pid,
				'filter_name'  => $filter_name,
				'filter_model' => $filter_model,
				'filter_sku'   => $filter_sku,
				'filter_upc'   => $filter_upc,
				'filter_ean'   => $filter_ean,
				'filter_jan'   => $filter_jan,
				'filter_isbn'  => $filter_isbn,
				'filter_mpn'   => $filter_mpn,
				'filter_location' => $filter_location,
				'filter_status'   => '1',
				'customer_group_id' => $customer_group_id,
				'start'        => 0,
				'limit'        => $limit
			);
			
			$results = $this->model_catalog_product->getCatalogProducts($data);
			
			foreach ($results as $result) {
				$option_data = array();
				
				$product_options = $this->model_catalog_product->getProductOptions($result['product_id']);	
				
				foreach ($product_options as $product_option) {
					$option_info = $this->model_catalog_option->getOption($product_option['option_id']);
					
					if ($option_info) {
						if ($option_info['type'] == 'select' || $option_info['type'] == 'radio' || $option_info['type'] == 'checkbox' || $option_info['type'] == 'image') {
							$option_value_data = array();
							
							foreach ($product_option['product_option_value'] as $product_option_value) {
								$option_value_info = $this->model_catalog_option->getOptionValue($product_option_value['option_value_id']);
						
								if ($option_value_info) {
									$option_value_data[] = array(
										'product_option_value_id' => $product_option_value['product_option_value_id'],
										'option_value_id'         => $product_option_value['option_value_id'],
										'name'                    => $option_value_info['name'],
										'price'                   => (float)$product_option_value['price'] ? $this->currency->format($product_option_value['price'], $this->config->get('config_currency')) : false,
										'price_prefix'            => $product_option_value['price_prefix']
									);
								}
							}

							$option_data[] = array(
								'product_option_id' => $product_option['product_option_id'],
								'option_id'         => $product_option['option_id'],
								'name'              => $option_info['name'],
								'type'              => $option_info['type'],
								'option_value'      => $option_value_data,
								'required'          => $product_option['required']
							);

						} else {
							$option_data[] = array(
								'product_option_id' => $product_option['product_option_id'],
								'option_id'         => $product_option['option_id'],
								'name'              => $option_info['name'],
								'type'              => $option_info['type'],
								'option_value'      => $product_option['option_value'],
								'required'          => $product_option['required']
							);				
						}
					}
				}

				$discount = 0;
				$discount_qty = 0;
				
				$product_discounts = $this->model_catalog_product->getOrderProductDiscounts($result['product_id'], $customer_group_id);
				
				if ($product_discounts) {
					foreach ($product_discounts as $product_discount) {
						$discount = $now_discount = number_format($product_discount['price'], 2, '.', '');
						$discount_qty = $product_discount['quantity'];
					}
				}
				
				$special = 0;
				$reward = 0;

				if ($result['special']) {
					$special = $result['special'];
				}
				if ($result['reward']) {
					$reward = $result['reward'];
				}
				
				$this->load->model('tool/image');
				
				if ($result['image'] && file_exists(DIR_IMAGE . $result['image'])) {
					$image = $this->model_tool_image->resize($result['image'], 45, 45);
					$popap = HTTPS_CATALOG . 'image/' . $result['image'];
				} else {
					$image = $this->model_tool_image->resize('no_image.jpg', 45, 45);
					$popap = false;
				}

				$json[] = array(
					'product_id' => $result['product_id'],
					'name'       => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),
					'model'      => strip_tags(html_entity_decode($result['model'], ENT_QUOTES, 'UTF-8')),
					'sku'        => strip_tags(html_entity_decode($result['sku'], ENT_QUOTES, 'UTF-8')),
					'upc'        => strip_tags(html_entity_decode($result['upc'], ENT_QUOTES, 'UTF-8')),
					'ean'        => strip_tags(html_entity_decode($result['ean'], ENT_QUOTES, 'UTF-8')),
					'jan'        => strip_tags(html_entity_decode($result['jan'], ENT_QUOTES, 'UTF-8')),
					'isbn'       => strip_tags(html_entity_decode($result['isbn'], ENT_QUOTES, 'UTF-8')),
					'mpn'        => strip_tags(html_entity_decode($result['mpn'], ENT_QUOTES, 'UTF-8')),
					'location'   => strip_tags(html_entity_decode($result['location'], ENT_QUOTES, 'UTF-8')),
					'quantity'   => $result['quantity'],
					'points'     => $result['points'],
					'reward'     => $reward,
					'special'    => $special,
					'discount'   => $discount,
					'discount_qty' => $discount_qty,
					'option'     => $option_data,
					'image'      => $image,
					'popap'      => $popap,
					'href'    	 => str_replace(HTTPS_SERVER, HTTPS_CATALOG, $this->url->link('product/product', 'product_id=' . $result['product_id'])),
					'price'      => $result['price']
				);	
			}
		}

		$this->response->setOutput(json_encode($json));
	}
	
	public function createCustomer() {
		$json = array();

		$this->language->load('sale/orderpro');

		$this->load->model('sale/orderpro');
		$this->load->model('sale/customer');

		$data = $this->request->post;

		$data['password'] = $this->model_sale_orderpro->setCustomerPassword();
		$data['confirm'] = $data['password'];
		$data['status'] = '1';
		$data['newsletter'] = '1';
		
		if (isset($data['payment_country_id']) && ($data['payment_country_id'] != '')) {
			$customer_country_id = $data['payment_country_id'];
		} else {
			$customer_country_id = $this->config->get('config_country_id');
		}
		
		if (isset($data['payment_zone_id']) && ($data['payment_zone_id'] != '')) {
			$customer_zone_id = $data['payment_zone_id'];
		} else {
			$customer_zone_id = $this->config->get('config_zone_id');
		}

		$data['address'][] = array(
				'firstname'   => $this->request->post['payment_firstname'],
				'lastname'    => $this->request->post['payment_lastname'],
				'company'     => $this->request->post['payment_company'],
				'company_id'  => $this->request->post['payment_company_id'],
				'tax_id'      => $this->request->post['payment_tax_id'],
				'address_1'   => $this->request->post['payment_address_1'],
				'address_2'   => $this->request->post['payment_address_2'],
				'city'        => $this->request->post['payment_city'],
				'postcode'    => $this->request->post['payment_postcode'],
				'country_id'  => $customer_country_id,
				'zone_id'     => $customer_zone_id,
				'default'     => '1'
		);

		$this->request->post = $data;

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateNewCustomer()) {

				$this->model_sale_customer->addCustomer($this->request->post);

				$new_customer = $this->model_sale_customer->getCustomerByEmail($this->request->post['email']);
				$customer_id = $new_customer['customer_id'];

				$this->db->query("UPDATE `" . DB_PREFIX . "customer` SET `approved` = '1' WHERE `customer_id` = '" . (int)$customer_id . "'");

				if (isset($this->request->post['order_id']) && ($this->request->post['order_id'] > 0)) {
					$order_id = $this->request->post['order_id'];
					$this->db->query("UPDATE `" . DB_PREFIX . "order` SET `customer_id` = '" . (int)$customer_id . "' WHERE `order_id` = '" . (int)$order_id . "'");
				}

				$this->load->model('setting/store');
				
				$store_info = $this->model_setting_store->getStore($data['store_id']);
				
				if ($store_info) {
					$data['store_name'] = $store_info['name'];
					$data['store_url'] = $store_info['url'];
				} else {
					$data['store_name'] = $this->config->get('config_name');
					$data['store_url'] = HTTP_CATALOG;
				}

				$this->load->model('localisation/language');
				
				$languages = $this->model_localisation_language->getLanguages();

				foreach ($languages as $language) {
					if ($language['code'] == $data['language']) {
						$file = DIR_LANGUAGE . $language['directory'] . '/sale/orderpro.php';
						require($file);
					}
				}

				$json['customer_id'] = $customer_id;
				$json['success'] = $_['success_add_account'];

				$subject = sprintf($_['text_subject_account'], $data['store_name']);

				$template = new Template();

				$template->data['logo'] = $this->config->get('config_url') . 'image/' . $this->config->get('config_logo');
				$template->data['store_name'] = $data['store_name'];
				$template->data['store_url'] = $data['store_url'];
				$template->data['text_message'] = $_['text_message_account'];
				$template->data['title'] = sprintf($_['text_subject_account'], $data['store_name']);
				
				if (isset($data['password'])) {
					$template->data['text_create_account'] = sprintf($_['text_create_account'], $data['email'], $data['password'], $data['store_url'] . 'index.php?route=account/login');
				} else {
					$template->data['text_create_account'] = '';
				}

				$html = $template->fetch('mail/newcustomer.tpl');

				$text = $_['text_message_account_text'] . "\n\n";

				$mail = new Mail(); 
				$mail->protocol = $this->config->get('config_mail_protocol');
				$mail->parameter = $this->config->get('config_mail_parameter');
				$mail->hostname = $this->config->get('config_smtp_host');
				$mail->username = $this->config->get('config_smtp_username');
				$mail->password = $this->config->get('config_smtp_password');
				$mail->port = $this->config->get('config_smtp_port');
				$mail->timeout = $this->config->get('config_smtp_timeout');			
				$mail->setTo($this->request->post['email']);
				$mail->setFrom($this->config->get('config_email'));
				$mail->setSender($data['store_name']);
				$mail->setSubject($subject);
				$mail->setHtml($html);
				$mail->setText(html_entity_decode($text, ENT_QUOTES, 'UTF-8'));
				$mail->send();

		} else {

				$json['error_warning'] = array();

				if (isset($this->error['warning'])) {
					$json['error_warning'][] = $this->error['warning'];
				}

				if (isset($this->error['firstname'])) {
					$json['error_warning'][] = $this->error['firstname'];
				}

				if (isset($this->error['email'])) {
					$json['error_warning'][] = $this->error['email'];
				}

				if (isset($this->error['address_firstname'])) {
					$json['error_warning'][] = $this->error['address_firstname'];
				}
		}

		$this->response->setOutput(json_encode($json));
	}
		
	public function removeOrderReward() {
		$this->language->load('sale/orderpro');
		
		$json = array();
    	
     	if ($this->user->hasPermission('modify', 'sale/orderpro')) {
			if (isset($this->request->get['order_id']) && !empty($this->request->get['order_id'])) {
				$this->load->model('sale/orderpro');
				
				$order_info = $this->model_sale_orderpro->getOrder($this->request->get['order_id']);

				if ($order_info && $order_info['customer_id']) {
					$this->model_sale_orderpro->deleteOrderReward($this->request->get['order_id']);
					
					$json['success'] = $this->language->get('success_reward_removed');
				} else {
					$json['error'] = $this->language->get('error_action');
				}
			}
		} else {
			$json['error'] = $this->language->get('error_permission');
		}
		
		$this->response->setOutput(json_encode($json));
  	}

	public function addOrderReward() {
		$this->language->load('sale/orderpro');

		$json = array();

		if (!$this->user->hasPermission('modify', 'sale/orderpro')) {
				$json['error'] = $this->language->get('error_permission'); 
		} elseif (isset($this->request->get['order_id'])) {
				if (!empty($this->request->post['customer_id'])) {
					$this->load->model('sale/orderpro');

					$reward_exist = $this->model_sale_orderpro->getReceivedRewardsByOrderId($this->request->get['order_id']);

					if (!$reward_exist) {
							$json['success'] = $this->model_sale_orderpro->updateReward($this->request->post['customer_id'], $this->language->get('text_order_id') . $this->request->get['order_id'], $this->request->post['reward_cart'], $this->request->get['order_id']);
					} else {
							$this->model_sale_orderpro->deleteOrderReward($this->request->get['order_id']);
							$json['success'] = $this->model_sale_orderpro->updateReward($this->request->post['customer_id'], $this->language->get('text_order_id') . $this->request->get['order_id'], $this->request->post['reward_cart'], $this->request->get['order_id'], $reward_exist);
					}
				} else {
					$json['error'] = $this->language->get('error_action');
				}

				$json['reward_total'] = $this->model_sale_orderpro->getReceivedRewardsByOrderId($this->request->get['order_id']);
		}

		$this->response->setOutput(json_encode($json));
	}

	public function addCommission() {
		$this->language->load('sale/orderpro');
		
		$json = array();
    	
     	if($this->user->hasPermission('modify', 'sale/orderpro')) {
			if (isset($this->request->get['order_id']) && !empty($this->request->get['order_id'])) {
				$this->load->model('sale/orderpro');
				
				$order_info = $this->model_sale_orderpro->getOrder($this->request->get['order_id']);
				
				if ($order_info && $order_info['affiliate_id']) {
					$this->load->model('sale/affiliate');
					
					$affiliate_total = $this->model_sale_affiliate->getTotalTransactionsByOrderId($this->request->get['order_id']);
					
					if (!$affiliate_total) {
						$this->model_sale_affiliate->addTransaction($order_info['affiliate_id'], $this->language->get('text_order_id') . $this->request->get['order_id'], $order_info['commission'], $this->request->get['order_id']);
						
						$json['success'] = $this->language->get('success_commission_added');
					} else {
						$json['error'] = $this->language->get('error_action'); 
					}
				} else {
					$json['error'] = $this->language->get('error_action');
				}
			}
		} else {
			$json['error'] = $this->language->get('error_permission');
		}
		
		$this->response->setOutput(json_encode($json));
  	}
	
	public function removeCommission() {
		$this->language->load('sale/orderpro');
		
		$json = array(); 
    	
     	if ($this->user->hasPermission('modify', 'sale/orderpro')) {
			if (isset($this->request->get['order_id']) && !empty($this->request->get['order_id'])) {
				$this->load->model('sale/orderpro');
				
				$order_info = $this->model_sale_orderpro->getOrder($this->request->get['order_id']);
				
				if ($order_info && $order_info['affiliate_id']) {
					$this->load->model('sale/affiliate');

					$this->model_sale_affiliate->deleteTransaction($this->request->get['order_id']);
					
					$json['success'] = $this->language->get('success_commission_removed');
				} else {
					$json['error'] = $this->language->get('error_action');
				}
			}
		} else {
      		$json['error'] = $this->language->get('error_permission');
		}

		$this->response->setOutput(json_encode($json));
  	}

	public function history() {
    	$this->language->load('sale/orderpro');
		
		$this->data['error'] = '';
		$this->data['success'] = '';
		
		$this->load->model('sale/orderpro');
	
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			if (!$this->user->hasPermission('modify', 'sale/orderpro')) { 
				$this->data['error'] = $this->language->get('error_permission');
			}
			
			if (!$this->data['error']) {
				$this->model_sale_orderpro->addOrderHistory($this->request->get['order_id'], $this->request->post);
				
				$this->data['success'] = $this->language->get('success_order_history');
			}
		}

		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['column_date_added'] = $this->language->get('column_date_added');
		$this->data['column_status'] = $this->language->get('column_status');
		$this->data['column_notify'] = $this->language->get('column_notify');
		$this->data['column_comment'] = $this->language->get('column_comment');

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		
		$limit = 10;
		
		$this->data['histories'] = array();
			
		$results = $this->model_sale_orderpro->getOrderHistories($this->request->get['order_id'], ($page - 1) * $limit, $limit);
      		
		foreach ($results as $result) {
        	$this->data['histories'][] = array(
				'notify'     => $result['notify'] ? $this->language->get('text_yes') : $this->language->get('text_no'),
				'status'     => $result['status'],
				'comment'    => nl2br($result['comment']),
				'date_added' => date('j.m.Y G:i', strtotime($result['date_added']))
        	);
      	}
		
		$history_total = $this->model_sale_orderpro->getTotalOrderHistories($this->request->get['order_id']);
			
		$pagination = new Pagination();
		$pagination->total = $history_total;
		$pagination->page = $page;
		$pagination->limit = $limit;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('sale/orderpro/history', 'token=' . $this->session->data['token'] . '&order_id=' . $this->request->get['order_id'] . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();
		
		$this->template = 'sale/historypro.tpl';
		
		$this->response->setOutput($this->render());
  	}
	
	public function download() {
		$this->load->model('sale/orderpro');
		
		if (isset($this->request->get['order_option_id'])) {
			$order_option_id = $this->request->get['order_option_id'];
		} else {
			$order_option_id = 0;
		}
		
		$option_info = $this->model_sale_orderpro->getOrderOption($this->request->get['order_id'], $order_option_id);
		
		if ($option_info && $option_info['type'] == 'file') {
			$file = DIR_DOWNLOAD . $option_info['value'];
			$mask = basename(utf8_substr($option_info['value'], 0, utf8_strrpos($option_info['value'], '.')));

			if (!headers_sent()) {
				if (file_exists($file)) {
					header('Content-Type: application/octet-stream');
					header('Content-Description: File Transfer');
					header('Content-Disposition: attachment; filename="' . ($mask ? $mask : basename($file)) . '"');
					header('Content-Transfer-Encoding: binary');
					header('Expires: 0');
					header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
					header('Pragma: public');
					header('Content-Length: ' . filesize($file));
					
					readfile($file, 'rb');
					exit;
				} else {
					exit('Ошибка: Не удалось найти файл: ' . $file . '!');
				}
			} else {
				exit('Error: Headers already sent out!');
			}

		} else {

			$this->language->load('error/not_found');

			$this->document->setTitle($this->language->get('heading_title'));

			$this->data['heading_title'] = $this->language->get('heading_title');
			$this->data['text_not_found'] = $this->language->get('text_not_found');

			$this->data['breadcrumbs'] = array();

			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_home'),
				'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
				'separator' => false
			);

			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('heading_title'),
				'href'      => $this->url->link('error/not_found', 'token=' . $this->session->data['token'], 'SSL'),
				'separator' => ' :: '
			);
		
			$this->template = 'error/not_found.tpl';

			$this->children = array(
				'common/header',
				'common/footer'
			);
		
			$this->response->setOutput($this->render());
		}	
	}

	public function upload() {
		$this->language->load('sale/orderpro');
		
		$json = array();
		
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			if (!empty($this->request->files['file']['name'])) {
				$filename = html_entity_decode($this->request->files['file']['name'], ENT_QUOTES, 'UTF-8');
				
				if ((utf8_strlen($filename) < 3) || (utf8_strlen($filename) > 128)) {
					$json['error'] = $this->language->get('error_filename');
				}	  	

				$allowed = array();
				
				$filetypes = explode("\n", $this->config->get('config_file_extension_allowed'));
				
				foreach ($filetypes as $filetype) {
					$allowed[] = trim($filetype);
				}
				
				if (!in_array(substr(strrchr($filename, '.'), 1), $allowed)) {
					$json['error'] = $this->language->get('error_filetype');
				}	

				$allowed = array();
				
				$filetypes = explode("\n", $this->config->get('config_file_mime_allowed'));
				
				foreach ($filetypes as $filetype) {
					$allowed[] = trim($filetype);
				}

				if (!in_array($this->request->files['file']['type'], $allowed)) {

					$json['error'] = $this->language->get('error_filetype');
				}

				if ($this->request->files['file']['error'] != UPLOAD_ERR_OK) {
					$json['error'] = $this->language->get('error_upload_' . $this->request->files['file']['error']);
				}
			} else {
				$json['error'] = $this->language->get('error_upload');
			}
		
			if (!isset($json['error'])) {
				if (is_uploaded_file($this->request->files['file']['tmp_name']) && file_exists($this->request->files['file']['tmp_name'])) {
					$file = basename($filename) . '.' . md5(mt_rand());
					
					$json['filename'] = $filename;
					$json['file'] = $file;
					
					move_uploaded_file($this->request->files['file']['tmp_name'], DIR_DOWNLOAD . $file);
				}

				$json['success'] = $this->language->get('success_upload_file');
			}	
		}
		
		$this->response->setOutput(json_encode($json));
	}

	public function createInvoiceNo() {
		$this->language->load('sale/orderpro');

		$json = array();
		
     	if (!$this->user->hasPermission('modify', 'sale/orderpro')) {
      		$json['error'] = $this->language->get('error_permission'); 
		} elseif (isset($this->request->get['order_id'])) {
			$this->load->model('sale/orderpro');
			
			$invoice_no = $this->model_sale_orderpro->createInvoiceNo($this->request->get['order_id']);
			
			if ($invoice_no) {
				$json['invoice_no'] = $invoice_no;
			} else {
				$json['error'] = $this->language->get('error_action');
			}
		}

		$this->response->setOutput(json_encode($json));
  	}

  	public function invoice() {
		$this->language->load('sale/orderpro');

		$this->data['title'] = $this->language->get('text_invoice_title');

		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$this->data['base'] = HTTPS_SERVER;
		} else {
			$this->data['base'] = HTTP_SERVER;
		}

		$this->data['direction'] = $this->language->get('direction');
		$this->data['language'] = $this->language->get('code');

		$this->data['text_invoice'] = $this->language->get('text_invoice');
		$this->data['text_order'] = $this->language->get('text_order');
		$this->data['text_order_id'] = $this->language->get('text_order_id');

		$this->data['text_date_added'] = $this->language->get('text_date_added');
		$this->data['text_email'] = $this->language->get('text_email');
		$this->data['text_telephone'] = $this->language->get('text_telephone');
		$this->data['text_fax'] = $this->language->get('text_fax');
		$this->data['text_url'] = $this->language->get('text_url');
		$this->data['text_to'] = $this->language->get('text_to');
		$this->data['text_ship_to'] = $this->language->get('text_ship_to');
		$this->data['text_address'] = $this->language->get('text_address');
		$this->data['text_company'] = $this->language->get('text_company');
		$this->data['text_company_id'] = $this->language->get('text_company_id');
		$this->data['text_tax_id'] = $this->language->get('text_tax_id');		
		$this->data['text_comment_customer'] = $this->language->get('text_comment_customer');
		$this->data['text_payment_method'] = $this->language->get('text_payment_method');
		$this->data['text_shipping_method'] = $this->language->get('text_shipping_method');

		$this->data['column_pid'] = $this->language->get('column_pid');
		$this->data['column_image'] = $this->language->get('column_image');
		$this->data['column_product'] = $this->language->get('column_product');
		$this->data['column_model'] = $this->language->get('column_model');
		$this->data['column_sku'] = $this->language->get('column_sku');
		$this->data['column_upc'] = $this->language->get('column_upc');
		$this->data['column_ean'] = $this->language->get('column_ean');
		$this->data['column_jan'] = $this->language->get('column_jan');
		$this->data['column_isbn'] = $this->language->get('column_isbn');
		$this->data['column_mpn'] = $this->language->get('column_mpn');
		$this->data['column_location'] = $this->language->get('column_location');
		$this->data['column_quantity'] = $this->language->get('column_quantity');
		$this->data['column_price'] = $this->language->get('column_price');
		$this->data['column_total'] = $this->language->get('column_total');
		$this->data['column_comment'] = $this->language->get('column_comment');
		
		$this->data['show_pid'] = $this->config->get('orderpro_show_pid');
		$this->data['show_image'] = $this->config->get('orderpro_show_image');
		$this->data['show_model'] = $this->config->get('orderpro_show_model');
		$this->data['show_sku'] = $this->config->get('orderpro_show_sku');
		$this->data['show_upc'] = $this->config->get('orderpro_show_upc');
		$this->data['show_ean'] = $this->config->get('orderpro_show_ean');
		$this->data['show_jan'] = $this->config->get('orderpro_show_jan');
		$this->data['show_isbn'] = $this->config->get('orderpro_show_isbn');
		$this->data['show_mpn'] = $this->config->get('orderpro_show_mpn');
		$this->data['show_location'] = $this->config->get('orderpro_show_location');

		$this->load->model('sale/orderpro');

		$this->load->model('setting/setting');

		$this->data['orders'] = array();

		$orders = array();

		if (isset($this->request->post['selected'])) {
			$orders = $this->request->post['selected'];
		} elseif (isset($this->request->get['order_id'])) {
			$orders[] = $this->request->get['order_id'];
		}

		foreach ($orders as $order_id) {
			$order_info = $this->model_sale_orderpro->getOrder($order_id);

			if ($order_info) {
				$store_info = $this->model_setting_setting->getSetting('config', $order_info['store_id']);
				
				if ($store_info) {
					$store_address = $store_info['config_address'];
					$store_email = $store_info['config_email'];
					$store_telephone = $store_info['config_telephone'];
					$store_fax = $store_info['config_fax'];
				} else {
					$store_address = $this->config->get('config_address');
					$store_email = $this->config->get('config_email');
					$store_telephone = $this->config->get('config_telephone');
					$store_fax = $this->config->get('config_fax');
				}
				
				if ($order_info['invoice_no']) {
					$invoice_no = $order_info['invoice_prefix'] . $order_info['invoice_no'];
				} else {
					$invoice_no = '';
				}
				
				if ($order_info['shipping_address_format']) {
					$format = $order_info['shipping_address_format'];
				} else {
					$format = '{postcode} {country}' . "\n" . '{zone}' . "\n" . '{city}' . "\n" . '{address_1} {address_2}';
				}

				$find = array(
					'{firstname}',
					'{lastname}',
					'{company}',
					'{address_1}',
					'{address_2}',
					'{city}',
					'{postcode}',
					'{zone}',
					'{zone_code}',
					'{country}'
				);

				$replace = array(
					'firstname' => $order_info['shipping_firstname'],
					'lastname'  => $order_info['shipping_lastname'],
					'company'   => $order_info['shipping_company'],
					'address_1' => $order_info['shipping_address_1'],
					'address_2' => $order_info['shipping_address_2'],
					'city'      => $order_info['shipping_city'],
					'postcode'  => $order_info['shipping_postcode'],
					'zone'      => $order_info['shipping_zone'],
					'zone_code' => $order_info['shipping_zone_code'],
					'country'   => $order_info['shipping_country']
				);

				$shipping_address = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

				if ($order_info['payment_address_format']) {
					$format = $order_info['payment_address_format'];
				} else {
					$format = '{firstname} {lastname}';
				}

				$find = array(
					'{firstname}',
					'{lastname}',
					'{company}',
					'{address_1}',
					'{address_2}',
					'{city}',
					'{postcode}',
					'{zone}',
					'{zone_code}',
					'{country}'
				);

				$replace = array(
					'firstname' => $order_info['payment_firstname'],
					'lastname'  => $order_info['payment_lastname'],
					'company'   => $order_info['payment_company'],
					'address_1' => $order_info['payment_address_1'],
					'address_2' => $order_info['payment_address_2'],
					'city'      => $order_info['payment_city'],
					'postcode'  => $order_info['payment_postcode'],
					'zone'      => $order_info['payment_zone'],
					'zone_code' => $order_info['payment_zone_code'],
					'country'   => $order_info['payment_country']
				);

				$payment_address = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

				$this->load->model('tool/image');
				
				$logo = $this->config->get('config_logo');
				
				if ($logo && file_exists(DIR_IMAGE . $logo)) {
					list($width_logo, $height_logo) = getimagesize(DIR_IMAGE . $logo);

					if (($width_logo > 420) || ($height_logo > 100)) {
						$this->data['logo'] = $this->model_tool_image->resize($logo, 420, 100);
					} else {
						$this->data['logo'] = HTTP_CATALOG . 'image/' . $logo;
					}
					
				} else {
					$this->data['logo'] = false;
				}
				
				$product_data = array();

				$products = $this->model_sale_orderpro->getOrderProducts($order_id);

				foreach ($products as $product) {
					$option_data = array();

					$options = $this->model_sale_orderpro->getOrderOptions($order_id, $product['order_product_id']);

					foreach ($options as $option) {
						if ($option['type'] != 'file') {
							$value = $option['value'];
						} else {
							$value = utf8_substr($option['value'], 0, utf8_strrpos($option['value'], '.'));
						}
						
						$option_data[] = array(
							'name'  => $option['name'],
							'value' => $value
						);								
					}
					
					$image = $this->model_sale_orderpro->getProductImage($product['product_id']);
					
					if ($image) {
						if ($image['image'] && file_exists(DIR_IMAGE . $image['image'])) {
							$img = $this->model_tool_image->resize($image['image'], 60, 60);
						} else {
							$img = $this->model_tool_image->resize('no_image.jpg', 60, 60);
						}
					} else {
						$img = $this->model_tool_image->resize('no_image.jpg', 60, 60);
					}

					$product_data[] = array(
						'product_id' => $product['product_id'],
						'img'      => $img,
						'name'     => $product['name'],
						'model'    => $product['model'],
						'sku'      => $product['sku'],
						'upc'      => $product['upc'],
						'ean'      => $product['ean'],
						'jan'      => $product['jan'],
						'isbn'     => $product['isbn'],
						'mpn'      => $product['mpn'],
						'location' => $product['location'],
						'option'   => $option_data,
						'quantity' => $product['quantity'],
						'oprice'   => $product['price'],
						'price'    => $this->currency->format($product['price'] + ($this->config->get('config_tax') ? $product['tax'] : 0), $order_info['currency_code'], $order_info['currency_value']),
						'total'    => $this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value'])
					);
				}
				
				if ($product_data) {
					foreach ($product_data as $key => $row) {
						$volume[$key]  = $row['name'];
						$edition[$key]  = $row['oprice'];
					}

					array_multisort($volume, SORT_ASC, $edition, SORT_ASC, $product_data);
				}
				
				$voucher_data = array();
				
				$vouchers = $this->model_sale_orderpro->getOrderVouchers($order_id);

				foreach ($vouchers as $voucher) {
					$voucher_data[] = array(
						'description' => $voucher['description'],
						'amount'      => $this->currency->format($voucher['amount'], $order_info['currency_code'], $order_info['currency_value'])			
					);
				}
					
				$total_data = $this->model_sale_orderpro->getOrderTotals($order_id);

				$this->data['orders'][] = array(
					'order_id'	         => $order_id,
					'invoice_no'         => $invoice_no,
					'date_added'         => date('j.m.Y G:i', strtotime($order_info['date_added'])),
					'store_name'         => $order_info['store_name'],
					'store_url'          => rtrim($order_info['store_url'], '/'),
					'store_address'      => nl2br($store_address),
					'store_email'        => $store_email,
					'store_telephone'    => $store_telephone,
					'store_fax'          => $store_fax,
					'email'              => $order_info['email'],
					'telephone'          => $order_info['telephone'],
					'shipping_address'   => $shipping_address,
					'shipping_method'    => $order_info['shipping_method'],
					'payment_address'    => $payment_address,
					'company'            => $order_info['payment_company'],
					'payment_company_id' => $order_info['payment_company_id'],
					'payment_tax_id'     => $order_info['payment_tax_id'],
					'payment_method'     => $order_info['payment_method'],
					'product'            => $product_data,
					'voucher'            => $voucher_data,
					'total'              => $total_data,
					'comment'            => nl2br($order_info['comment'])
				);
			}
		}

		$this->template = 'sale/invoicepro.tpl';

		$this->response->setOutput($this->render());
	}
	
	public function multisort($array, $index) {
		for($i = 0; $i < count($array); $i++) {
			$el_arr = $array[$i][$index];
			$new_arr[] = $el_arr; 
		} 
		asort($new_arr);
		
		$keys = array_keys($new_arr);
		
		for($key=0; $key<count($keys); $key++) {
			$result[] = $array[$keys[$key]];
		}
		return $result; 
    }
}
?>