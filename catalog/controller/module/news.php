<?php
//-----------------------------------------------------
// News Module for Opencart v1.5.5   							
// Modified by villagedefrance                          			
// contact@villagedefrance.net                         			
//-----------------------------------------------------

class ControllerModuleNews extends Controller {

	protected function index($setting) {
		static $module = 0;
	
		$this->language->load('module/news');
	
      	$this->data['heading_title'] = $this->language->get('heading_title');
	
		$this->data['customtitle'] = $this->config->get('news_customtitle' . $this->config->get('config_language_id'));

		$this->data['header'] = $this->config->get('news_header');

		if (!$this->data['customtitle']) { $this->data['customtitle'] = $this->data['heading_title']; } 

		$this->data['icon'] = $this->config->get('news_icon');

		$this->data['box'] = $this->config->get('news_box');

		$this->document->addStyle('catalog/view/theme/'.$this->config->get('config_template').'/stylesheet/news.css');
	
		$this->load->model('module/news');
	
		$this->data['text_more'] = $this->language->get('text_more');

		$this->data['text_posted'] = $this->language->get('text_posted');
	
		$this->data['show_headline'] = $this->config->get('news_headline_module');
	
		$this->data['news_count'] = $this->model_module_news->getTotalNews();
		
		$this->data['news_limit'] = $setting['limit'];
	
		if ($this->data['news_count'] > $this->data['news_limit']) { $this->data['showbutton'] = true; } else { $this->data['showbutton'] = false; }
	
		$this->data['buttonlist'] = $this->language->get('buttonlist');
	
		$this->data['newslist'] = $this->url->link('information/news');
		
		$this->data['numchars'] = $setting['numchars'];
		
		if (isset($this->data['numchars'])) { $chars = $this->data['numchars']; } else { $chars = 100; }
		
		$this->data['news'] = array();
	
		$results = $this->model_module_news->getNewsShorts($setting['limit']);

        $this->load->model('tool/image');
	
		foreach ($results as $result) {
            if (!empty($result['image'])) {
                $thumb = $this->model_tool_image->resize($result['image'], $this->config->get('news_thumb_width'), $this->config->get('news_thumb_height'));
            } else {
                $thumb = false;
            }

			$this->data['news'][] = array(
				'title'        		=> $result['name'],
				'description'  	=> utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $chars).'...',
				'preview'  	=> utf8_substr(strip_tags(html_entity_decode($result['preview'], ENT_QUOTES, 'UTF-8')), 0, $chars).'...',
				'href'         		=> $this->url->link('information/news/info', 'news_id=' . $result['news_id']),
				'posted'   		=> date($this->language->get('date_format_short'), strtotime($result['date_added'])),
                'thumb'         => $thumb
			);
		}

        $this->data['news_limit'] = $this->config->get('news_module_limit');
	
		$this->data['module'] = $module++; 
	
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/' . 'news.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/' . 'news.tpl';
		} else {
			$this->template = 'default/template/module/' . 'news.tpl';
		}
	
		$this->render();
	}
}
?>
