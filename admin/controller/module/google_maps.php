<?php
class ControllerModuleGoogleMaps extends Controller
{
	private $error = array(); 
	
	public function index()
	{
		//--Loading current active language file
		$this->load->language('module/google_maps');

		//--Load Helper
		require_once(DIR_SYSTEM . 'helper/google_maps.php');

		//--Load and assign Info
		$this->data['gmaps_info']	= gmaps_make_doc();
		$this->data['gmaps_about']	= gmaps_make_doc('<p>', '</p>', '  - ', '<br />', str_repeat('&nbsp;', 4));

		//--Load and assign Donate button
		$this->data['gmaps_donate'] = gmaps_donate_button();


		$this->load->model('setting/setting');
		//--Check form post
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('google_maps', $this->request->post);		
					
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}


		//--Assign translation to $data array
		$this->data = array_merge($this->data, array(
			'heading_title'				=> $this->language->get('heading_title'),

			'text_about_title'			=> $this->language->get('text_about_title'),
			'text_content_top'			=> $this->language->get('text_content_top'),
			'text_content_bottom'		=> $this->language->get('text_content_bottom'),
			'text_column_left'			=> $this->language->get('text_column_left'),
			'text_column_right'			=> $this->language->get('text_column_right'),
			'text_yes'					=> $this->language->get('text_yes'),
			'text_no'					=> $this->language->get('text_no'),
			'text_enabled'				=> $this->language->get('text_enabled'),
			'text_disabled'				=> $this->language->get('text_disabled'),
			'text_caution'				=> $this->language->get('text_caution'),
			'text_select_all'			=> $this->language->get('text_select_all'),
			'text_unselect_all'			=> $this->language->get('text_select_all'),

			'entry_mapid'				=> $this->language->get('entry_mapid'),
			'entry_mapalias'			=> $this->language->get('entry_mapalias'),
			'entry_address'				=> $this->language->get('entry_address'),
			'entry_latlong'				=> $this->language->get('entry_latlong'),
			'entry_balloonwidth'		=> $this->language->get('entry_balloonwidth'),
			'entry_ballon_text'			=> $this->language->get('entry_ballon_text'),

			'entry_settigns'			=> $this->language->get('entry_settigns'),
			'entry_mts'					=> $this->language->get('entry_mts'),
			'entry_widthheight'			=> $this->language->get('entry_widthheight'),
			'entry_zoom'				=> $this->language->get('entry_zoom'),
			'entry_maptype'				=> $this->language->get('entry_maptype'),
			'entry_theme_box'			=> $this->language->get('entry_theme_box'),
			'entry_theme_show_box'		=> $this->language->get('entry_theme_show_box'),
			'entry_theme_box_title'		=> $this->language->get('entry_theme_box_title'),
			'entry_options'				=> $this->language->get('entry_options'),
			'entry_layout'				=> $this->language->get('entry_layout'),
			'entry_position'			=> $this->language->get('entry_position'),
			'entry_status'				=> $this->language->get('entry_status'),
			'entry_sort_order'			=> $this->language->get('entry_sort_order'),

			'confirm_mapid'				=> $this->language->get('confirm_mapid'),

			'button_save'				=> $this->language->get('button_save'),
			'button_cancel'				=> $this->language->get('button_cancel'),
			'button_add_module'			=> $this->language->get('button_add_module'),
			'button_remove'				=> $this->language->get('button_remove'),
			'button_addmap'				=> $this->language->get('button_addmap')
		), gmaps_info());

		//--Document Scripts and Styles
		$this->document->setTitle($this->data['heading_title']);
		$this->document->addStyle('view/javascript/jquery/jquery-te/jquery-te-1.4.0.css');
		$this->document->addScript('view/javascript/jquery/jquery-te/jquery-te-1.4.0.min.js');
		$this->document->addScript('view/javascript/jquery/cnplugins/jquery.predefinedinput-1.0.1.js');
		$this->document->addScript('http://maps.google.com/maps/api/js?sensor=false&libraries=places');
		$this->document->addScript('view/javascript/jquery/locationpicker/locationpicker.jquery.js');


		if (isset($this->error['warning'])) $this->data['error_warning'] = $this->error['warning'];
		else $this->data['error_warning'] = '';


		//--Breadcrumbs
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
			'href'      => $this->url->link('module/google_maps', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		//--

		$this->data['action'] = $this->url->link('module/google_maps', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		//--Modules
		$this->data['modules'] = array();
		if (isset($this->request->post['google_maps_module']))
		{
			$this->data['modules'] = $this->request->post['google_maps_module'];
		}
		elseif ($this->config->get('google_maps_module'))
		{
			$this->data['modules'] = $this->config->get('google_maps_module');
		}
		//--

		//--Upgrade mts to ids
		foreach ($this->data['modules'] as $key => $module) {
			if (isset($module['mts']) and strlen($module['mts']) > 0) {
				if (strpos($module['mts'], ',') !== false) {
					$this->data['modules'][$key]['ids'] = explode(',', $module['mts']);
				} else {
					$this->data['modules'][$key]['ids'] = array($module['mts']);
				}

			}
		}
		//--
		
		//--Maps
		$this->data['gmaps'] = array();
		if (isset($this->request->post['google_maps_module_map']))
		{
			$this->data['gmaps'] = $this->request->post['google_maps_module_map'];
		}
		elseif ($this->config->get('google_maps_module_map'))
		{
			$this->data['gmaps'] = $this->config->get('google_maps_module_map');
		} 		
		//--


		$this->load->model('design/layout');
		$this->data['layouts'] = $this->model_design_layout->getLayouts();
		$this->template = 'module/google_maps.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
		
		$this->load->model('localisation/language');
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		
		$this->data['token'] = $this->session->data['token'];
		
		$this->response->setOutput($this->render());
	}
	
	private function validate()
	{
		if (!$this->user->hasPermission('modify', 'module/google_maps'))
		{
			$this->error['warning'] = $this->language->get('error_permission');
		}


		if (isset($this->request->post['google_maps_module_map'])) {
			foreach ($this->request->post['google_maps_module_map'] as $key => $value) {
				if (!$value['mapalias']) {
					$this->error['warning'] = $this->language->get('error_mapid') . '<br />';
				}

				if (!$value['latlong']) {
					$this->error['warning'] = $this->language->get('error_latlong') . '<br />';
				}
			}
		}

		if (isset($this->request->post['google_maps_module'])) {
			foreach ($this->request->post['google_maps_module'] as $key => $value) {
				if (!isset($value['ids'])) {
					$this->error['warning'] = $this->language->get('error_ids') . '<br />';
				}

				if (!$value['width']) {
					$this->error['warning'] = $this->language->get('error_width') . '<br />';
				}

				if (!$value['height']) {
					$this->error['warning'] = $this->language->get('error_height') . '<br />';
				}

			}
		}
		
		return !$this->error;
	}
}
