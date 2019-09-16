<?php
class ControllerLocalisationCityUpdate extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('localisation/city_update');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('localisation/city_update');

		$this->getList();
	}
	
	protected function getList() {
		// Check database
		$this->model_localisation_city_update->checkDatabase();
		// Check database

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'zone';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

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
			'text'		=> $this->language->get('text_home'),
			'href'		=> $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator'	=> false
		);

		$this->data['breadcrumbs'][] = array(
			'text'		=> $this->language->get('heading_title'),
			'href'		=> $this->url->link('localisation/city_update', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator'	=> ' :: '
		);

		$this->data['back'] = $this->url->link('localisation/city', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['button_back'] = $this->language->get('button_back');
		$this->data['text_success'] = $this->language->get('text_success');

		$this->template = 'localisation/city_update_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}
}
?>