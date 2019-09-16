<?php
################################################################################################
#  AJAX Search Module for Opencart 1.5.1 From HostJars http://opencart.hostjars.com 		   #
################################################################################################
class ControllerModuleAjaxSearch extends Controller {
	
	protected function index($setting) {
		$this->language->load('module/ajax_search');

      	$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['input'] = $this->searchName();
		
		//only used for callback function
		$this->data['ajax_search_num_suggestions'] = (isset($setting['ajax_search_num_suggestions'])) ? (int) $setting['ajax_search_num_suggestions'] : 10;
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/ajax_search.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/ajax_search.tpl';
		} else {
			$this->template = 'default/template/module/ajax_search.tpl';
		}

		$this->render();
	}
	
	public function callback() {
		$data['limit'] = (isset($this->request->get['limit'])) ? (int) $this->request->get['limit'] : 10;
		$data['start'] = 0;
		if (!empty($setting['ajax_search_description'])) {
			$data['filter_description'] = 1;
		}
		$data['filter_name'] = (isset($this->request->get['keyword'])) ? $this->request->get['keyword'] : null;
		$this->load->model('catalog/product');
		$this->load->model('tool/image');
		$results = $this->model_catalog_product->getProducts($data);
		$json = array();
		
		foreach ($results as $result) {
			if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
				$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
			} else {
				$price = sprintf("%.2f", $result['price']);
			}
			if ((float)$result['special']) {
				$price = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
			}
			$json['prods'][] = array(
				'label'	=> $result['name'],
				'id'	=> $result['product_id'],
				'url' 	=> $this->url->link('product/product', 'product_id=' . $result['product_id']),
				'price' => $price,
				'desc' 	=> mb_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, 50) . '..',
				'img' 	=> ($result['image']) ? $this->model_tool_image->resize($result['image'], 50, 50) : ''
			);
		}
		
		
		
		$json['prods']['length'] = count($results);
		$this->response->setOutput(json_encode($json));
	}

	public function searchName() {
		$this->load->model('catalog/category');
		if(method_exists($this->model_catalog_category, 'getCategoryFilters'))	{
			return 'search';
		}else{
			return 'filter_name';
		}
	}
}
?>