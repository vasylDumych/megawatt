<?php  

class ControllerModuleCoinSlider extends Controller 
{
	protected function index($setting) 
	{
		static $module = 0;

		$this->language->load('module/coin_slider');
		$this->load->model('design/coin_slider');
		$this->load->model('tool/image');

		$this->document->addScript('catalog/view/javascript/jquery/coin_slider/coin-slider.min.js');
		$this->document->addStyle('catalog/view/javascript/jquery/coin_slider/coin-slider-styles.css');

		if (empty($setting)) {
			return;
		}

		if ($this->checkCategory($setting) === false) {
			return;
		}

        $slider_config = $this->model_design_coin_slider->getSliderConfig($setting['coin_slider_id']);

		$this->data['sliders'] = array();
		$results = $this->model_design_coin_slider->getSlider($setting['coin_slider_id']);
		foreach ($results as $result) {
			if (file_exists(DIR_IMAGE . $result['image'])) {
				$this->data['sliders'][] = array(
					'title' 	=> $result['title'],
					'subtitle' 	=> html_entity_decode($result['subtitle'], ENT_QUOTES, 'UTF-8'),
					'link'  	=> $result['link'],
					'image' 	=> $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height'], '', $slider_config[0]['background_color']),
					'width'		=> $setting['width'],
					'height'	=> $setting['height']
				);
			}
		}

		$this->data['slider_config'] = array();
		foreach ($slider_config as $result) {
			$effects = array('', 'swirl', 'rain', 'straight');

			$this->data['slider_config'] = array(
				'status' => $result['status'], 
				'spw' 	=> $result['spw'],
				'sph' 	=> $result['sph'],
				'delay' => $result['delay'],
				's_delay' => $result['s_delay'],
				'opacity' => $result['opacity'],
				'title_speed' => $result['title_speed'],
				'effect' => $effects[ $result['effect'] ],
				'navigation' => ($result['navigation'] == 0)? 'true' : 'false',
				'links' => ($result['links'] == 0)? 'true' : 'false',
				'hover_pause' => ($result['hover_pause'] == 0)? 'true' : 'false',
				'link_new_tab' => $result['link_new_tab'],
				'width_title'  => $result['width_title']. 'px',
				'width_subtitle'  => $result['width_subtitle']. 'px',
				'padding_top' => $result['padding_top']. 'px',
				'padding_left' => $result['padding_left']. 'px',
				'distance' => $result['distance']. 'px',
				'text_color' => $result['text_color'],
				'show_buttons_prev_next' => (int) $result['show_buttons_prev_next'],
				'show_buttons_bottom' => (int) $result['show_buttons_bottom'],
			);
		}

		$this->data['text_prev'] = $this->language->get('text_prev');
		$this->data['text_next'] = $this->language->get('text_next');

		$this->data['module'] = $module++;

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/coin_slider.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/coin_slider.tpl';
		} else {
			$this->template = 'default/template/module/coin_slider.tpl';
		}
		
		$this->render();
	}

	private function checkCategory($setting)
	{
		if (isset($this->request->get['path'])) {
			$parts = explode('_', (string)$this->request->get['path']);
		} else {
			$parts = array();
		}

		if (!empty($parts)) {
			if ($setting['category_id'] == 0) {
				return true;
			}

			if ($setting['category_id'] != end($parts)) {
				return false;
			}
		}

		return true;
	}
}
