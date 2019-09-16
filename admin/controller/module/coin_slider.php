<?php

class ControllerModuleCoinSlider extends Controller 
{
	private $error = array(); 
	
	/**
	 * Main action of module
	 *
	 * @return null
	 */
	public function index() 
	{
		$this->load->language('module/coin_slider');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('setting/setting');
						
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('coin_slider', $this->request->post);		
			$this->session->data['success'] = $this->language->get('text_success');
			$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}

		//Main variables
		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_content_top'] = $this->language->get('text_content_top');
		$this->data['text_content_bottom'] = $this->language->get('text_content_bottom');		
		$this->data['text_column_left'] = $this->language->get('text_column_left');
		$this->data['text_column_right'] = $this->language->get('text_column_right');
		$this->data['entry_slider'] = $this->language->get('entry_slider');
		$this->data['entry_dimension'] = $this->language->get('entry_dimension'); 
		$this->data['entry_layout'] = $this->language->get('entry_layout');
		$this->data['entry_position'] = $this->language->get('entry_position');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$this->data['text_image_manager'] = $this->language->get('text_image_manager');
 		$this->data['text_browse'] = $this->language->get('text_browse');
		$this->data['text_clear'] = $this->language->get('text_clear');	

		//Buttons
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_add_module'] = $this->language->get('button_add_module');
		$this->data['button_remove'] = $this->language->get('button_remove');
		$this->data['button_sliders'] = $this->language->get('button_sliders');
		$this->data['button_create'] = $this->language->get('button_create');
		$this->data['button_edit'] = $this->language->get('button_edit');

		//Messages
		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		//Breadcrumbs
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
			'href'      => $this->url->link('module/coin_slider', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

		//Action Form
		$this->data['action'] = $this->url->link('module/coin_slider', 'token=' . $this->session->data['token'], 'SSL');

		//Cancel Form
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		//Add / Edit Sliders
		$this->data['add_edit_sliders'] = $this->url->link('design/coin_slider', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['add_insert_sliders'] = $this->url->link('design/coin_slider/insert', 'token=' . $this->session->data['token']. '&back_to_module=1', 'SSL');
		$this->data['update_slider'] = $this->url->link('design/coin_slider/update', 'token=' . $this->session->data['token'], 'SSL');

		//Modules variable
		$this->data['modules'] = array();
		if (isset($this->request->post['coin_slider_module'])) {
			$this->data['modules'] = $this->request->post['coin_slider_module'];
		} elseif ($this->config->get('coin_slider_module')) { 
			$this->data['modules'] = $this->config->get('coin_slider_module');
		}

		//Layouts
		$this->load->model('design/layout');
		$this->data['layouts'] = $this->model_design_layout->getLayouts();

		//Images
		$this->load->model('tool/image');
		$this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);

		//Sliders
		$this->load->model('design/coin_slider');
		$this->data['sliders'] = $this->model_design_coin_slider->getSliders();

		//Categories
		$this->load->model('catalog/category');
		$this->data['categories'] = $this->model_catalog_category->getCategories(0);

		$this->template = 'module/coin_slider.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}

	/**
	 * Valide form before save
	 *
	 * @return (true|false)	
	 */
	private function validate() 
	{
		return true;
	}

	/**
	 * Delete module
	 *
	 * @return null
	 */
	public function uninstall()
	{
		$this->load->model('design/coin_slider');
		$this->model_design_coin_slider->uninstall();
	}

	/**
	 * Install module
	 *
	 * @return null
	 */
	public function install()
	{
		$this->load->model('design/coin_slider');
		$this->model_design_coin_slider->install();
	}
}
