<?php  
class ControllerCommonHome extends Controller {
	public function index() {
		$this->document->setTitle($this->config->get('config_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));

		if ($this->config->get('config_keywords')) {
			$this->document->setKeywords($this->config->get('config_keywords'));
		
		}
		if ($this->config->get('config_h1')) {
			$hhome = $this->config->get('config_h1');
		} else {
			$hhome = $this->config->get('config_title');
		}
		$this->data['heading_title'] = $hhome;
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/home.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/common/home.tpl';
		} else {
			$this->template = 'default/template/common/home.tpl';
		}
		
		$this->children = array(
			'common/column_left',
			'common/column_right',

        'common/content_top_1_3',
		'common/content_top_2_3',
		
      
			'common/content_top',
			'common/content_bottom',
			'common/footer',
			'common/header',
			'common/footer_new'
		);
										
		$this->response->setOutput($this->render());
	}
}
?>