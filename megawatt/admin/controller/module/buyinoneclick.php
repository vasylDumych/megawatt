<?php
class ControllerModuleBuyinoneclick extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('module/buyinoneclick');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('buyinoneclick', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_phone_mask'] = $this->language->get('text_phone_mask');

		$this->data['entry_email'] = $this->language->get('entry_email');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_phone_mask_status'] = $this->language->get('entry_phone_mask_status');
		$this->data['entry_phone_text'] = $this->language->get('entry_phone_text');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('module/buyinoneclick', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['action'] = $this->url->link('module/buyinoneclick', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['buyinoneclick_email_status'])) {
			$this->data['email_status'] = $this->request->post['buyinoneclick_email_status'];
		} else {
			$this->data['email_status'] = $this->config->get('buyinoneclick_email_status');
		}

		if (isset($this->request->post['buyinoneclick_status'])) {
			$this->data['module_status'] = $this->request->post['buyinoneclick_status'];
		} else {
			$this->data['module_status'] = $this->config->get('buyinoneclick_status');
		}

		if (isset($this->request->post['buyinoneclick_phone_mask_status'])) {
			$this->data['phone_mask_status'] = $this->request->post['buyinoneclick_phone_mask_status'];
		} else {
			$this->data['phone_mask_status'] = $this->config->get('buyinoneclick_phone_mask_status');
		}

		if (isset($this->request->post['buyinoneclick_phone_text'])) {
			$this->data['phone_text'] = $this->request->post['buyinoneclick_phone_text'];
		} else {
			$this->data['phone_text'] = $this->config->get('buyinoneclick_phone_text');
		}

		if (isset($this->request->post['buyinoneclick_phone_mask'])) {
			$this->data['phone_mask'] = $this->request->post['buyinoneclick_phone_mask'];
		} else {
			$this->data['phone_mask'] = $this->config->get('buyinoneclick_phone_mask');
		}

		if (isset($this->error['phone_text'])) {
			$this->data['error_phone_text'] = $this->error['phone_text'];
		} else {
			$this->data['error_phone_text'] = array();
		}

		if (isset($this->error['phone_mask'])) {
			$this->data['error_phone_mask'] = $this->error['phone_mask'];
		} else {
			$this->data['error_phone_mask'] = array();
		}

		$this->template = 'module/buyinoneclick.tpl';

		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/buyinoneclick')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ($this->request->post['buyinoneclick_phone_mask_status']) {
			if (isset($this->request->post['buyinoneclick_phone_mask']) && !preg_match('/^[9\+\(\)\s\-]{3,50}$/', $this->request->post['buyinoneclick_phone_mask'])) {
				$this->error['phone_mask'] = $this->language->get('error_phone_mask');
			}
		}

		if ((utf8_strlen($this->request->post['buyinoneclick_phone_text']) < 0) || (utf8_strlen($this->request->post['buyinoneclick_phone_text']) > 50)) {
			$this->error['phone_text'] = $this->language->get('error_phone_text');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	public function install() {
		$this->load->model('catalog/buyinoneclick');
		$this->load->model('setting/setting');

		$this->model_catalog_buyinoneclick->install();

		$data = array(
			'buyinoneclick_email_status' => 1,
			'buyinoneclick_status' => 1,
			'buyinoneclick_phone_mask_status' => 0,
			'buyinoneclick_phone_mask' => '+9 (999) 999-99-99'
		);

		$this->model_setting_setting->editSetting('buyinoneclick', $data);
	}

	public function uninstall() {
		$this->load->model('catalog/buyinoneclick');
		$this->load->model('setting/setting');

		$this->model_catalog_buyinoneclick->unistall();

		$this->model_setting_setting->deleteSetting('buyinoneclick');
	}

}

?>