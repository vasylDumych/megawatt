<?php
class ControllerModuleFlyoutmenumodule extends Controller {
	private $error = array(); 
	
	public function index() {   
		$this->language->load('module/flyoutmenumodule');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
		$this->load->model('localisation/language');
			
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			
			$this->model_setting_setting->editSetting('flyoutmenumodule', $this->request->post);	
            
            $this->cache->delete('flyoutmenu');
					
			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->redirect($this->url->link('module/flyoutmenumodule', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		$this->data['flyoutmenu_menus'] = array();
		
		for ($i=2;$i<=40;$i++) {
			if ($this->config->get('menu'.$i.'_flyoutmenu_menu_id')) {
				$newname = $this->config->get('menu'.$i.'_flyoutmenu_language');
				if (isset($newname['mobilemenuname'][$this->config->get('config_language_id')]) && $newname['mobilemenuname'][$this->config->get('config_language_id')]) {
					$name= $newname['mobilemenuname'][$this->config->get('config_language_id')];
				} else {
					$name = 'Menu ' .$i;
				}
				$this->data['flyoutmenu_menus'][] =array(
					'id'   => $this->config->get('menu'.$i.'_flyoutmenu_menu_id'),
					'url'  => $this->url->link('module/flyoutmenu', 'token=' . $this->session->data['token'] . '&menu_id=' . $i, 'SSL'),
					'name' => $name
				);
			}
		}
		
		$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['text_tomenu'] = $this->language->get('text_tomenu');
		$this->data['text_default'] = $this->language->get('text_default');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_content_top'] = $this->language->get('text_content_top');
		$this->data['text_content_bottom'] = $this->language->get('text_content_bottom');		
		$this->data['text_column_left'] = $this->language->get('text_column_left');
		$this->data['text_column_right'] = $this->language->get('text_column_right');
		$this->data['text_no'] = $this->language->get('text_no');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_browse'] = $this->language->get('text_browse');
		$this->data['text_clear'] = $this->language->get('text_clear');
		$this->data['text_image_manager'] = $this->language->get('text_image_manager');
		$this->data['text_unselect_all'] = $this->language->get('text_unselect_all');
		$this->data['text_select_all'] = $this->language->get('text_select_all');
		$this->data['entry_layout'] = $this->language->get('entry_layout');
		$this->data['entry_add'] = $this->language->get('entry_add');
		$this->data['entry_position'] = $this->language->get('entry_position');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_add_module'] = $this->language->get('button_add_module');
		$this->data['button_remove'] = $this->language->get('button_remove');
		$this->data['text_default_menu'] = $this->language->get('text_default_menu');
		$this->data['entry_theme'] = $this->language->get('entry_theme');
		$this->data['entry_menu'] = $this->language->get('entry_menu');
		
		$this->data['url_tomenu'] = $this->url->link('module/flyoutmenu', 'token=' . $this->session->data['token'], 'SSL');
		
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
			'href'      => $this->url->link('module/flyoutmenumodule', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->link('module/flyoutmenumodule', 'token=' . $this->session->data['token'], 'SSL');
		
		
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['modules'] = array();
		
		if (isset($this->request->post['flyoutmenumodule_module'])) {
			$this->data['modules'] = $this->request->post['flyoutmenumodule_module'];
		} elseif ($this->config->get('flyoutmenumodule_module')) { 
			$this->data['modules'] = $this->config->get('flyoutmenumodule_module');
		}
				
		$this->load->model('design/layout');
		
		$this->data['layouts'] = $this->model_design_layout->getLayouts();

		$this->template = 'module/flyoutmenumodule.tpl';
		
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/flyoutmenumodule')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
?>