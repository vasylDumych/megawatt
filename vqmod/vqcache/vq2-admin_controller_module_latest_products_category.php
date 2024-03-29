<?php
class ControllerModuleLatestproductscategory extends Controller {
	private $error = array(); 
	
	public function index() {   
		$this->language->load('module/latest_products_category');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
		$this->load->model('catalog/category');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->model_setting_setting->editSetting('latest_products_category', $this->request->post);		
					
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}
				
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_content_top'] = $this->language->get('text_content_top');
		$this->data['text_content_bottom'] = $this->language->get('text_content_bottom');		
		$this->data['text_column_left'] = $this->language->get('text_column_left');
		$this->data['text_column_right'] = $this->language->get('text_column_right');
		
		$this->data['entry_limit'] = $this->language->get('entry_limit');
		$this->data['entry_image'] = $this->language->get('entry_image');
		$this->data['entry_category'] = $this->language->get('entry_category');
		$this->data['entry_layout'] = $this->language->get('entry_layout');
		$this->data['entry_position'] = $this->language->get('entry_position');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_normal'] = $this->language->get('entry_normal');
		$this->data['entry_carousel'] = $this->language->get('entry_carousel');
		$this->data['entry_subcats'] = $this->language->get('entry_subcats');
		$this->data['entry_snone'] = $this->language->get('entry_snone');
		$this->data['entry_filtering'] = $this->language->get('entry_filtering');
		$this->data['entry_ctabs'] = $this->language->get('entry_ctabs');
		$this->data['entry_pmin'] = $this->language->get('entry_pmin');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_add_module'] = $this->language->get('button_add_module');
		$this->data['button_remove'] = $this->language->get('button_remove');
		
		
		
		$results = $this->model_catalog_category->getCategories(0);

		foreach ($results as $result) {
							
			$this->data['categories'][] = array(
				'category_id' => $result['category_id'],
				'name'        => $result['name']
			);
		}
		
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
        if (isset($this->error['image'])) {
			$this->data['error_image'] = $this->error['image'];
		} else {
			$this->data['error_image'] = array();
		}
  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/latest_products_category', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->link('module/latest_products_category', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['modules'] = array();
		
		if (isset($this->request->post['latest_products_category_module'])) {
			$this->data['modules'] = $this->request->post['latest_products_category_module'];
		} elseif ($this->config->get('latest_products_category_module')) { 
			$this->data['modules'] = $this->config->get('latest_products_category_module');
		}
		
		
		$this->load->model('design/layout');
		
		$this->data['layouts'] = $this->model_design_layout->getLayouts();

 $this->data['layouts'][] = array('layout_id'=>0, 'name' => 'all' ); 
				
		$this->template = 'module/latest_products_category.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render());
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/latest_products_category')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if (isset($this->request->post['latest_products_category_module'])) {
			foreach ($this->request->post['latest_products_category_module'] as $key => $value) {
				if (!$value['image_width'] || !$value['image_height']) {
					$this->error['image'][$key] = $this->language->get('error_image');
				}
			}
		}	
		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}	
	}
}
?>