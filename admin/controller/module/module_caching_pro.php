<?php

/**
 * LICENSE
 *
 * This source file is subject to the GNU General Public License, Version 3
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @category   OpenCart
 * @package    Module Caching PRO for OpenCart
 * @copyright  Copyright (c) 2016 Eugene Lifescale (eugene.lifescale@gmail.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License, Version 3
 */

class ControllerModuleModuleCachingPro extends Controller {

	private $error = array(); 
	
	public function index() {

		$this->load->model('setting/setting');
		$this->load->model('setting/extension');

		$this->data = $this->load->language('module/module_caching_pro');

		$this->document->setTitle($this->language->get('heading_title'));

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

			$this->model_setting_setting->editSetting('module_caching_pro', $this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = false;
		}

		if (isset($this->request->post['module_caching_pro_modules'])) {
			$this->data['module_caching_pro_modules'] = $this->request->post['module_caching_pro_modules'];
		} else if ($this->config->get('module_caching_pro_modules')) {
			$this->data['module_caching_pro_modules'] = $this->config->get('module_caching_pro_modules');
		} else {
			$this->data['module_caching_pro_modules'] = array();
		}

		if (isset($this->request->post['module_caching_pro_drivers'])) {
			$this->data['module_caching_pro_drivers'] = $this->request->post['module_caching_pro_drivers'];
		} else if ($this->config->get('module_caching_pro_drivers')) {
			$this->data['module_caching_pro_drivers'] = $this->config->get('module_caching_pro_drivers');
		} else {
			$this->data['module_caching_pro_drivers'] = array();
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
			'href'      => $this->url->link('module/module_caching_pro', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->link('module/module_caching_pro', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		
		// Get modules
		$this->data['installed_modules'] = array();
		foreach ($this->model_setting_extension->getInstalled('module') as $module) {

			if ($module != 'module_caching_pro') {
				$this->load->language('module/' . $module);
				$this->data['installed_modules'][sprintf('module/%s', $module)] = $this->language->get('heading_title');
			}

		}

		// Get cache drivers
		$this->data['cache_drivers'] = array(
			'disk'      => 1,
			'memcache'  => class_exists('Memcache') ? 1 : 0,
			'memcached' => class_exists('Memcached') ? 1 : 0,
		);
		
		// Render the template
		$this->template = 'module/module_caching_pro.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/module_caching_pro')) {
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