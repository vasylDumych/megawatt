<?php
// v 0.3
class ControllerModuleFeedback extends Controller {
	private $error = array();
	
	public function install() {
	
		/* set default */
		$data['feedback_settings'] = array(
			'settings_min_phone' => '6',
			'settings_max_phone' => '12',
			'settings_min_text' => '10',
			'settings_max_text' => '400',
			'settings_success' => array()
		);
		$this->load->model('localisation/language');
		$languages = $this->model_localisation_language->getLanguages();
		foreach($languages as $language) {
			$data['feedback_settings']['settings_success'][$language['language_id']] = 'Thx! Your message was sent successfully!';
		}
		
		$this->load->model('setting/setting');
		$this->model_setting_setting->editSetting('feedback', $data);
		
	}
	public function uninstall() {
		$this->load->model('setting/setting');
		$this->model_setting_setting->deleteSetting('feedback');
	}
	public function index() {
	
		$this->load->language('module/feedback');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			
			$this->model_setting_setting->editSetting('feedback', $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');
			$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		
		}
		
		/*langs*/
		$this->load->model('localisation/language');
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		
		/*lang vars*/
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_left'] = $this->language->get('text_left');
		$this->data['text_right'] = $this->language->get('text_right');
		$this->data['text_content_top'] = $this->language->get('text_content_top');
		$this->data['text_content_bottom'] = $this->language->get('text_content_bottom');		
		$this->data['text_column_left'] = $this->language->get('text_column_left');
		$this->data['text_column_right'] = $this->language->get('text_column_right');
		$this->data['button_add_module'] = $this->language->get('button_add_module');
		$this->data['button_remove'] = $this->language->get('button_remove');
		$this->data['entry_layout'] = $this->language->get('entry_layout');
		$this->data['entry_position'] = $this->language->get('entry_position');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['entry_fields'] = $this->language->get('entry_fields');
		$this->data['required_entry_fields'] = $this->language->get('required_entry_fields');
		$this->data['txt_first_name'] = $this->language->get('txt_first_name');
		$this->data['txt_email'] = $this->language->get('txt_email');
		$this->data['txt_phone'] = $this->language->get('txt_phone');
		$this->data['txt_textarea'] = $this->language->get('txt_textarea');
		$this->data['txt_captcha'] = $this->language->get('txt_captcha');
		$this->data['tab_settings'] = $this->language->get('tab_settings');
		$this->data['tab_modules'] = $this->language->get('tab_modules');
		$this->data['txt_default'] = $this->language->get('txt_default');
		$this->data['txt_default_text_message'] = $this->language->get('txt_default_text_message');
		
		$this->data['txt_settings_min_phone'] = $this->language->get('txt_settings_min_phone');
		$this->data['txt_settings_max_phone'] = $this->language->get('txt_settings_max_phone');
		$this->data['txt_settings_min_text'] = $this->language->get('txt_settings_min_text');
		$this->data['txt_settings_max_text'] = $this->language->get('txt_settings_max_text');
		$this->data['txt_settings_success'] = $this->language->get('txt_settings_success');
		
		$this->data['entry_title'] = $this->language->get('entry_title'); // added in v. 0.5
		$this->data['entry_style'] = $this->language->get('entry_style'); // added in v. 0.5
		$this->data['entry_feedback'] = $this->language->get('entry_feedback'); // added in v. 0.5
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		
		$this->load->model('design/layout');
		$this->data['layouts'] = $this->model_design_layout->getLayouts();
		
		$this->data['styles'] = array(
			'classic' => $this->language->get('entry_classic_style'),
			'simple' => $this->language->get('entry_simple_style')
		);
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
			
       		'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
       		'text'      => $this->language->get('text_home'),
      		'separator' => FALSE
   		);

   		$this->data['breadcrumbs'][] = array(			
       		'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
       		'text'      => $this->language->get('text_module'),
      		'separator' => ' :: '
   		);
		
   		$this->data['breadcrumbs'][] = array(
       		'href'      => $this->url->link('module/feedback', 'token=' . $this->session->data['token'], 'SSL'),
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->link('module/feedback', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['modules'] = array();
		
		if (isset($this->request->post['feedback_module'])) {
			$this->data['modules'] = $this->request->post['feedback_module'];
		} elseif ($this->config->get('feedback_module')) { 
			$this->data['modules'] = $this->config->get('feedback_module');
		}
		if (isset($this->request->post['feedback_settings'])) {
			$this->data['settings'] = $this->request->post['feedback_settings'];
		} elseif ($this->config->get('feedback_settings')) { 
			$this->data['settings'] = $this->config->get('feedback_settings');
		}
		
		
		
		$this->template = 'module/feedback.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/feedback')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		foreach ($this->request->post['feedback_module'] as $module) {
			if (empty($module['name']) and empty($module['email']) and empty($module['phone']) and empty($module['text'])) {
				$this->error['warning'] = $this->language->get('error_fields');
			}
			if (!$this->error and empty($module['r']['name']) and empty($module['r']['email']) and empty($module['r']['phone']) and empty($module['r']['text'])) {
				$this->error['warning'] = $this->language->get('error_requested_fields');
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