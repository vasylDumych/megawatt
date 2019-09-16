<?php
class ControllerDesignCoinSlider extends Controller {
	private $error = array();
 
	public function index() {
		$this->load->language('design/coin_slider');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('design/coin_slider');
		
		$this->getList();
	}

	public function insert() {
		$this->load->language('design/coin_slider');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('design/coin_slider');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

			$this->model_design_coin_slider->addSlider($this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');

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
			
			if (isset($this->request->post['back_to_module'])) {
				$this->redirect($this->url->link('module/coin_slider', 'token=' . $this->session->data['token'], 'SSL'));	
			} else {
				$this->redirect($this->url->link('design/coin_slider', 'token=' . $this->session->data['token'] . $url, 'SSL'));
			}
		}

		$this->getForm();
	}

    private function rrmdir($dir) {
        foreach(glob($dir . '/*') as $file) {
            if(is_dir($file))
                $this->rrmdir($file);
            else
                unlink($file);
        }
        rmdir($dir);
    }
    
	public function update() {
		$this->load->language('design/coin_slider');
        
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('design/coin_slider');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_design_coin_slider->editSlider($this->request->get['coin_slider_id'], $this->request->post);

            if (is_dir(DIR_IMAGE . 'cache/data/')) {
                $this->rrmdir(DIR_IMAGE . 'cache/data/');
            }

			$this->session->data['success'] = $this->language->get('text_success');

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
					
			$this->redirect($this->url->link('design/coin_slider', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}
 
	public function delete() {
		$this->load->language('design/coin_slider');
 
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('design/coin_slider');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $slider_id) {
				$this->model_design_coin_slider->deleteSlider($slider_id);
			}
			
			$this->session->data['success'] = $this->language->get('text_success');

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

			$this->redirect($this->url->link('design/coin_slider', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	private function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'name';
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
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('design/coin_slider', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['insert'] = $this->url->link('design/coin_slider/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('design/coin_slider/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['back_to_coinslider'] = $this->url->link('module/coin_slider', 'token=' . $this->session->data['token'] . $url, 'SSL');
		 
		$this->data['sliders'] = array();

		$data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);
		
		$coin_slider_total = $this->model_design_coin_slider->getTotalSliders();
		
		$results = $this->model_design_coin_slider->getSliders($data);
		
		$this->data['sliders'] = array();
		foreach ($results as $result) {
			$action = array();

			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('design/coin_slider/update', 'token=' . $this->session->data['token'] . '&coin_slider_id=' . $result['coin_slider_id'] . $url, 'SSL')
			);

			$this->data['sliders'][] = array(
				'coin_slider_id' => $result['coin_slider_id'],
				'name'      => $result['name'],	
				'status'    => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),				
				'selected'  => isset($this->request->post['selected']) && in_array($result['coin_slider_id'], $this->request->post['selected']),				
				'action'    => $action,
			);
		}


		$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['text_no_results'] = $this->language->get('text_no_results');
		
		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_status'] = $this->language->get('column_status');
		$this->data['column_action'] = $this->language->get('column_action');	

		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_delete'] = $this->language->get('button_delete');
		$this->data['button_back_to_coinslider'] = $this->language->get('button_back_to_coinslider');
 
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

		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		
		$this->data['sort_name'] = $this->url->link('design/coin_slider', 'token=' . $this->session->data['token'] . '&sort=name' . $url, 'SSL');
		$this->data['sort_status'] = $this->url->link('design/coin_slider', 'token=' . $this->session->data['token'] . '&sort=status' . $url, 'SSL');
		
		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $coin_slider_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('design/coin_slider', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();
		
		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'design/coin_slider_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}

	private function getForm() {
		$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_default'] = $this->language->get('text_default');
		$this->data['text_image_manager'] = $this->language->get('text_image_manager');
 		$this->data['text_browse'] = $this->language->get('text_browse');
		$this->data['text_clear'] = $this->language->get('text_clear');	

		$this->data['entry_spw'] = $this->language->get('entry_spw');
		$this->data['entry_sph'] = $this->language->get('entry_sph');
		$this->data['entry_delay'] = $this->language->get('entry_delay');
		$this->data['entry_sdelay'] = $this->language->get('entry_sdelay');
		$this->data['entry_opacity'] = $this->language->get('entry_opacity');
		$this->data['entry_titleSpeed'] = $this->language->get('entry_titleSpeed');
		$this->data['entry_effect'] = $this->language->get('entry_effect');
		$this->data['entry_navigation'] = $this->language->get('entry_navigation');
		$this->data['entry_links'] = $this->language->get('entry_links');
		$this->data['entry_hoverPause'] = $this->language->get('entry_hoverPause');
		$this->data['entry_note'] = $this->language->get('entry_note');
		$this->data['entry_true'] = $this->language->get('entry_true');
		$this->data['entry_false'] = $this->language->get('entry_false');

		//More Options
		$this->data['entry_more_options'] = $this->language->get('entry_more_options');
		$this->data['entry_more_link'] = $this->language->get('entry_more_link');
		$this->data['entry_more_width_title'] = $this->language->get('entry_more_width_title');
		$this->data['entry_more_width_subtitle'] = $this->language->get('entry_more_width_subtitle');
		$this->data['entry_more_padding_top'] = $this->language->get('entry_more_padding_top');
		$this->data['entry_more_padding_left'] = $this->language->get('entry_more_padding_left');
		$this->data['entry_more_distance'] = $this->language->get('entry_more_distance');
		$this->data['entry_more_color'] = $this->language->get('entry_more_color');
		$this->data['entry_more_background_color'] = $this->language->get('entry_more_background_color');
		$this->data['entry_show_buttons_prev_next'] = $this->language->get('entry_show_buttons_prev_next');
		$this->data['entry_show_buttons_bottom'] = $this->language->get('entry_show_buttons_bottom');
				
		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_title'] = $this->language->get('entry_title');
		$this->data['entry_subtitle'] = $this->language->get('entry_subtitle');
		$this->data['entry_link'] = $this->language->get('entry_link');
		$this->data['entry_image'] = $this->language->get('entry_image');		
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order']   = $this->language->get('entry_sort_order');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_add_slider'] = $this->language->get('button_add_slider');
		$this->data['button_remove'] = $this->language->get('button_remove');

		//Error message
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

 		if (isset($this->error['name'])) {
			$this->data['error_name'] = $this->error['name'];
		} else {
			$this->data['error_name'] = '';
		}

		//URL						
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

		if (isset($this->request->get['back_to_module'])) {
			$this->data['back_to_module'] = 1;
		}

		//Breadcrumbs
  		$this->data['breadcrumbs'] = array();
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('design/coin_slider', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
							
		if (!isset($this->request->get['coin_slider_id'])) { 
			$this->data['action'] = $this->url->link('design/coin_slider/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('design/coin_slider/update', 'token=' . $this->session->data['token'] . '&coin_slider_id=' . $this->request->get['coin_slider_id'] . $url, 'SSL');
		}
		
		$this->data['cancel'] = $this->url->link('design/coin_slider', 'token=' . $this->session->data['token'] . $url, 'SSL');
		
		if (isset($this->request->get['coin_slider_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$slider_info = $this->model_design_coin_slider->getSlider($this->request->get['coin_slider_id']);
		}

		$this->data['token'] = $this->session->data['token'];

		if (isset($this->request->post['name'])) {
			$this->data['name'] = $this->request->post['name'];
		} elseif (!empty($slider_info)) {
			$this->data['name'] = $slider_info['name'];
		} else {
			$this->data['name'] = '';
		}
		
		if (isset($this->request->post['status'])) {
			$this->data['status'] = $this->request->post['status'];
		} elseif (!empty($slider_info)) {
			$this->data['status'] = $slider_info['status'];
		} else {
			$this->data['status'] = true;
		}

		if (isset($this->request->post['spw'])) {
			$this->data['spw'] = $this->request->post['spw'];
		} elseif (!empty($slider_info)) {
			$this->data['spw'] = $slider_info['spw'];
		} else {
			$this->data['spw'] = 7;
		}

		if (isset($this->request->post['sph'])) {
			$this->data['sph'] = $this->request->post['sph'];
		} elseif (!empty($slider_info)) {
			$this->data['sph'] = $slider_info['sph'];
		} else {
			$this->data['sph'] = 5;
		}

		if (isset($this->request->post['delay'])) {
			$this->data['delay'] = $this->request->post['delay'];
		} elseif (!empty($slider_info)) {
			$this->data['delay'] = $slider_info['delay'];
		} else {
			$this->data['delay'] = 3000;
		}

		if (isset($this->request->post['s_delay'])) {
			$this->data['s_delay'] = $this->request->post['s_delay'];
		} elseif (!empty($slider_info)) {
			$this->data['s_delay'] = $slider_info['s_delay'];
		} else {
			$this->data['s_delay'] = 30;
		}

		if (isset($this->request->post['opacity'])) {
			$this->data['opacity'] = $this->request->post['opacity'];
		} elseif (!empty($slider_info)) {
			$this->data['opacity'] = $slider_info['opacity'];
		} else {
			$this->data['opacity'] = 0.7;
		}

		if (isset($this->request->post['title_speed'])) {
			$this->data['title_speed'] = $this->request->post['title_speed'];
		} elseif (!empty($slider_info)) {
			$this->data['title_speed'] = $slider_info['title_speed'];
		} else {
			$this->data['title_speed'] = 500;
		}

		if (isset($this->request->post['effect'])) {
			$this->data['effect'] = $this->request->post['effect'];
		} elseif (!empty($slider_info)) {
			$this->data['effect'] = $slider_info['effect'];
		} else {
			$this->data['effect'] = '';
		}

		if (isset($this->request->post['navigation'])) {
			$this->data['navigation'] = $this->request->post['navigation'];
		} elseif (!empty($slider_info)) {
			$this->data['navigation'] = $slider_info['navigation'];
		} else {
			$this->data['navigation'] = '';
		}

		if (isset($this->request->post['links'])) {
			$this->data['links'] = $this->request->post['links'];
		} elseif (!empty($slider_info)) {
			$this->data['links'] = $slider_info['links'];
		} else {
			$this->data['links'] = '';
		}

		if (isset($this->request->post['hover_pause'])) {
			$this->data['hover_pause'] = $this->request->post['hover_pause'];
		} elseif (!empty($slider_info)) {
			$this->data['hover_pause'] = $slider_info['hover_pause'];
		} else {
			$this->data['hover_pause'] = '';
		}

		if (isset($this->request->post['link_new_tab'])) {
			$this->data['link_new_tab'] = $this->request->post['link_new_tab'];
		} elseif (!empty($slider_info)) {
			$this->data['link_new_tab'] = $slider_info['link_new_tab'];
		} else {
			$this->data['link_new_tab'] = '';
		}

		if (isset($this->request->post['width_title'])) {
			$this->data['width_title'] = $this->request->post['width_title'];
		} elseif (!empty($slider_info)) {
			$this->data['width_title'] = $slider_info['width_title'];
		} else {
			$this->data['width_title'] = '250';
		}

		if (isset($this->request->post['width_subtitle'])) {
			$this->data['width_subtitle'] = $this->request->post['width_subtitle'];
		} elseif (!empty($slider_info)) {
			$this->data['width_subtitle'] = $slider_info['width_subtitle'];
		} else {
			$this->data['width_subtitle'] = '250';
		}

		if (isset($this->request->post['padding_top'])) {
			$this->data['padding_top'] = $this->request->post['padding_top'];
		} elseif (!empty($slider_info)) {
			$this->data['padding_top'] = $slider_info['padding_top'];
		} else {
			$this->data['padding_top'] = '10';
		}

		if (isset($this->request->post['padding_left'])) {
			$this->data['padding_left'] = $this->request->post['padding_left'];
		} elseif (!empty($slider_info)) {
			$this->data['padding_left'] = $slider_info['padding_left'];
		} else {
			$this->data['padding_left'] = '10';
		}

		if (isset($this->request->post['distance'])) {
			$this->data['distance'] = $this->request->post['distance'];
		} elseif (!empty($slider_info)) {
			$this->data['distance'] = $slider_info['distance'];
		} else {
			$this->data['distance'] = '10';
		}

		if (isset($this->request->post['text_color'])) {
			$this->data['text_color'] = $this->request->post['text_color'];
		} elseif (!empty($slider_info)) {
			$this->data['text_color'] = $slider_info['text_color'];
		} else {
			$this->data['text_color'] = '000000';
		}

		if (isset($this->request->post['background_color'])) {
			$this->data['background_color'] = $this->request->post['background_color'];
		} elseif (!empty($slider_info)) {
			$this->data['background_color'] = $slider_info['background_color'];
		} else {
			$this->data['background_color'] = 'FFFFFF';
		}

		if (isset($this->request->post['show_buttons_prev_next'])) {
			$this->data['show_buttons_prev_next'] = $this->request->post['show_buttons_prev_next'];
		} elseif (!empty($slider_info)) {
			$this->data['show_buttons_prev_next'] = $slider_info['show_buttons_prev_next'];
		} else {
			$this->data['show_buttons_prev_next'] = 1;
		}

		if (isset($this->request->post['show_buttons_bottom'])) {
			$this->data['show_buttons_bottom'] = $this->request->post['show_buttons_bottom'];
		} elseif (!empty($slider_info)) {
			$this->data['show_buttons_bottom'] = $slider_info['show_buttons_bottom'];
		} else {
			$this->data['show_buttons_bottom'] = 1;
		}

		$this->load->model('localisation/language');
		
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		
		$this->load->model('tool/image');
	
		if (isset($this->request->post['coin_slider_image'])) {
			$slider_images = $this->request->post['coin_slider_image'];
		} elseif (isset($this->request->get['coin_slider_id'])) {
			$slider_images = $this->model_design_coin_slider->getSliderImages($this->request->get['coin_slider_id']);	
		} else {
			$slider_images = array();
		}

		$this->data['slider_images'] = array();

		foreach ($slider_images as $slider_image) {
			if ($slider_image['image'] && file_exists(DIR_IMAGE . $slider_image['image'])) {
				$image = $slider_image['image'];
			} else {
				$image = 'no_image.jpg';
			}			
			
			$this->data['slider_images'][] = array(
				'coin_slider_image_description' => $slider_image['coin_slider_image_description'],
				'link'                     => $slider_image['link'],
				'image'                    => $image,
				'thumb'                    => $this->model_tool_image->resize($image, 100, 100),
				'sort_order'			   => $slider_image['sort_order'],	
			);	
		} 
	
		$this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);		

		$this->template = 'design/coin_slider_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}

	private function validateForm() {

		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}
				
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	private function validateDelete() {

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}
?>
