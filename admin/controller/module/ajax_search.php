<?php
################################################################################################
#  AJAX Search Module from CSV for Opencart 1.5.1.x from Hostjars opencart.hostjars.com    	   #
################################################################################################
class ControllerModuleAjaxSearch extends Controller {
	private $error = array(); 
	
	public function index() {
		 
		$this->load->language('module/ajax_search');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('ajax_search', $this->request->post);	
		
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$text_strings = array(
				'heading_title',
				'text_enabled',
				'text_disabled',
				'text_content_top',
				'text_content_bottom',
				'text_module',
				'text_success',
				'entry_layout',
				'entry_position',
				'entry_status',
				'entry_sort_order',
				'entry_max_terms',
				'entry_search_description',
				'button_save',
				'button_cancel',
				'button_add_module',
				'button_remove',
				'error_permission',
		);
		
		foreach ($text_strings as $text) {
			$this->data[$text] = $this->language->get($text);
		}
		
		//END LANGUAGE
		
		$config_data = array(
			'ajax_search_max_terms',
			'ajax_search_description',
		);
		
		foreach ($config_data as $conf) {
			$this->data[$conf] = (isset($this->request->post[$conf])) ? $this->request->post[$conf] : $this->config->get($conf);
		}

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
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
			'href'      => $this->url->link('module/ajax_search', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->link('module/ajax_search', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['modules'] = array();
		
		if (isset($this->request->post['ajax_search_module'])) {
			$this->data['modules'] = $this->request->post['ajax_search_module'];
		} elseif ($this->config->get('ajax_search_module')) { 
			$this->data['modules'] = $this->config->get('ajax_search_module');
		}	
		
		$this->load->model('design/layout');
		
		$this->data['layouts'] = $this->model_design_layout->getLayouts();

		$this->template = 'module/ajax_search.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
			

		//Send the output.
		$this->response->setOutput($this->render());
	}
	
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/ajax_search')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}	
	}


}
?>