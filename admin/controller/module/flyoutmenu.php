<?php
class ControllerModuleFlyoutmenu extends Controller {
	private $error = array(); 
	
	public function index() {   
		$this->language->load('module/flyoutmenu');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
		$this->load->model('catalog/category');
		$this->load->model('catalog/information');
		$this->load->model('localisation/language');
		$this->load->model('tool/image');
        $this->load->model('setting/store');
		
		if (isset($this->request->get['menu_id']) && (int)$this->request->get['menu_id']) {
			$preffix = 'menu'.(int)$this->request->get['menu_id'].'_';
			$this->data['current_menu'] = (int)$this->request->get['menu_id'];
		} else {
			$preffix = '';	
			$this->data['current_menu'] = 0;
		}
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if (!$preffix) {
				$this->model_setting_setting->editSetting('flyoutmenu', $this->request->post);	
			} else {
				$this->model_setting_setting->editSetting($preffix.'flyoutmenu', $this->request->post);	
			}
			
            $this->cache->delete('flyoutmenu');
					
			$this->session->data['success'] = $this->language->get('text_success');
			if (!$preffix) {		
				$this->redirect($this->url->link('module/flyoutmenu', 'token=' . $this->session->data['token'], 'SSL'));
			} else {
				$this->redirect($this->url->link('module/flyoutmenu', 'token=' . $this->session->data['token'] . '&menu_id=' . $this->data['current_menu'], 'SSL'));
			}
		}
		
		$this->data['preffix'] = $preffix;
		
		$this->data['active_language'] = $this->config->get('config_language_id');
		
		$this->data['flyoutmenu_menus'] = array();
		
		if (!$preffix) {
			$this->data['delete_url'] = false;
		} else {
			$this->data['delete_url'] = $this->url->link('module/flyoutmenu/delete', 'token=' . $this->session->data['token'] . '&menu_id=' . $this->data['current_menu'], 'SSL');
		}
		
		$latest_menu = 1;
		
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
				$latest_menu = $i;
			}
		}
		$this->data['newmenu'] = $latest_menu + 1;
		
			
		$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['stores'] = $this->model_setting_store->getStores();
		$this->data['text_tomodule'] = $this->language->get('text_tomodule');
		$this->data['text_stores'] = $this->language->get('text_stores');
		$this->data['text_fbrands'] = $this->language->get('text_fbrands');
		$this->data['text_default'] = $this->language->get('text_default');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_content_top'] = $this->language->get('text_content_top');
		$this->data['text_content_bottom'] = $this->language->get('text_content_bottom');		
		$this->data['text_column_left'] = $this->language->get('text_column_left');
		$this->data['text_column_right'] = $this->language->get('text_column_right');
		$this->data['text_image'] = $this->language->get('text_image');
		$this->data['text_expando'] = $this->language->get('text_expando');
		$this->data['text_sorder'] = $this->language->get('text_sorder');
		$this->data['text_tlcolor'] = $this->language->get('text_tlcolor');
		$this->data['text_tlstyle'] = $this->language->get('text_tlstyle');
		$this->data['text_justadd'] = $this->language->get('text_justadd');
		$this->data['text_alldrop'] = $this->language->get('text_alldrop');
		$this->data['text_overdrop'] = $this->language->get('text_overdrop');
		$this->data['text_flyoutmenuisresponsive'] = $this->language->get('text_flyoutmenuisresponsive');
		$this->data['text_or'] = $this->language->get('text_or');
		$this->data['text_no'] = $this->language->get('text_no');
		$this->data['tab_items'] = $this->language->get('tab_items');
		$this->data['tab_mods'] = $this->language->get('tab_mods');
		$this->data['tab_settings'] = $this->language->get('tab_settings');
		$this->data['tab_html'] = $this->language->get('tab_html');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_browse'] = $this->language->get('text_browse');
		$this->data['text_clear'] = $this->language->get('text_clear');
		$this->data['text_image_manager'] = $this->language->get('text_image_manager');
		$this->data['text_unselect_all'] = $this->language->get('text_unselect_all');
		$this->data['text_select_all'] = $this->language->get('text_select_all');
		$this->data['entry_layout'] = $this->language->get('entry_layout');
		$this->data['entry_add'] = $this->language->get('entry_add');
		$this->data['text_slist'] = $this->language->get('text_slist');
		$this->data['text_sgrid'] = $this->language->get('text_sgrid');
		$this->data['text_sview'] = $this->language->get('text_sview');
		$this->data['text_dwidth'] = $this->language->get('text_dwidth');
		$this->data['text_iwidth'] = $this->language->get('text_iwidth');
		$this->data['text_chtml'] = $this->language->get('text_chtml');
		$this->data['text_cchtml'] = $this->language->get('text_cchtml');
		$this->data['text_whatproducts'] = $this->language->get('text_whatproducts');
		$this->data['text_productlatest'] = $this->language->get('text_productlatest');
		$this->data['text_productspecial'] = $this->language->get('text_productspecial');
		$this->data['text_productfeatured'] = $this->language->get('text_productfeatured');
		$this->data['text_productbestseller'] = $this->language->get('text_productbestseller');
		$this->data['text_productlimit'] = $this->language->get('text_productlimit');
		$this->data['entry_type'] = $this->language->get('entry_type');
		$this->data['entry_category'] = $this->language->get('entry_category');
		$this->data['entry_custom'] = $this->language->get('entry_custom');
		$this->data['entry_information'] = $this->language->get('entry_information');
		$this->data['entry_advanced'] = $this->language->get('entry_advanced');
		$this->data['custom_name'] = $this->language->get('custom_name');
		$this->data['custom_url'] = $this->language->get('custom_url');
		$this->data['type_cat'] = $this->language->get('type_cat');
		$this->data['type_mand'] = $this->language->get('type_mand');
		$this->data['type_infol'] = $this->language->get('type_infol');
		$this->data['type_products'] = $this->language->get('type_products');
		$this->data['type_catprods'] = $this->language->get('type_catprods');
		$this->data['type_infod'] = $this->language->get('type_infod');
		$this->data['entry_iset'] = $this->language->get('entry_iset');
		$this->data['type_custom'] = $this->language->get('type_custom');
		$this->data['type_more'] = $this->language->get('type_more');
		$this->data['type_more2'] = $this->language->get('type_more2');
		$this->data['type_login'] = $this->language->get('type_login');
		$this->data['entry_position'] = $this->language->get('entry_position');
		$this->data['entry_count'] = $this->language->get('entry_count');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_add_module'] = $this->language->get('button_add_module');
		$this->data['button_add_item'] = $this->language->get('button_add_item');
		$this->data['button_remove'] = $this->language->get('button_remove');
		$this->data['more_name'] = $this->language->get('more_name');
		$this->data['more2_name'] = $this->language->get('more2_name');
		$this->data['more_status'] = $this->language->get('more_status');
		$this->data['entry_image_size'] = $this->language->get('entry_image_size');
		$this->data['entry_show_description'] = $this->language->get('entry_show_description');
		$this->data['text_general'] = $this->language->get('text_general');
		$this->data['text_more_dropdown'] = $this->language->get('text_more_dropdown');
		$this->data['text_more2_dropdown'] = $this->language->get('text_more2_dropdown');
		$this->data['text_languagerelated'] = $this->language->get('text_languagerelated');
		$this->data['text_customization'] = $this->language->get('text_customization');
		$this->data['text_settings_isresponsive'] = $this->language->get('text_settings_isresponsive');
		$this->data['text_settings_dropdowntitle'] = $this->language->get('text_settings_dropdowntitle');
		$this->data['text_settings_topitemlink'] = $this->language->get('text_settings_topitemlink');
		$this->data['text_settings_flyoutwidth'] = $this->language->get('text_settings_flyoutwidth');
		$this->data['text_settings_bspacewidth'] = $this->language->get('text_settings_bspacewidth');
		$this->data['text_settings_mobilemenuname'] = $this->language->get('text_settings_mobilemenuname');
		$this->data['text_settings_infodname'] = $this->language->get('text_settings_infodname');
		$this->data['text_settings_brandsdname'] = $this->language->get('text_settings_brandsdname');
		$this->data['text_settings_latestpname'] = $this->language->get('text_settings_latestpname');
		$this->data['text_settings_specialpname'] = $this->language->get('text_settings_specialpname');
		$this->data['text_settings_featuredpname'] = $this->language->get('text_settings_featuredpname');
		$this->data['text_settings_bestpname'] = $this->language->get('text_settings_bestpname');
		$this->data['text_subcatdisplay'] = $this->language->get('text_subcatdisplay');
		$this->data['text_subcatdisplay_all'] = $this->language->get('text_subcatdisplay_all');
		$this->data['text_subcatdisplay_level1'] = $this->language->get('text_subcatdisplay_level1');
		$this->data['text_subcatdisplay_none'] = $this->language->get('text_subcatdisplay_none');
		$this->data['text_3dlevellimit'] = $this->language->get('text_3dlevellimit');
		$this->data['text_settings_viewallname'] = $this->language->get('text_settings_viewallname');
		$this->data['text_settings_viewmorename'] = $this->language->get('text_settings_viewmorename');
		$this->data['text_settings_dropeffect'] = $this->language->get('text_settings_dropeffect');
		$this->data['text_settings_hoverintent'] = $this->language->get('text_settings_hoverintent');
		$this->data['text_settings_tophomelink'] = $this->language->get('text_settings_tophomelink');
		$this->data['text_settings_menuskin'] = $this->language->get('text_settings_menuskin');
		$this->data['text_settings_flyoutcache'] = $this->language->get('text_settings_flyoutcache');
		$this->data['text_editting_menu'] = $this->language->get('text_editting_menu');
		$this->data['text_new_menu'] = $this->language->get('text_new_menu');
		$this->data['text_selectedit_menu'] = $this->language->get('text_selectedit_menu');
		$this->data['text_default_menu'] = $this->language->get('text_default_menu');
		$this->data['text_delete_menu'] = $this->language->get('text_delete_menu');
		$this->data['text_delete_confirm'] = $this->language->get('text_delete_confirm');
		$this->data['text_dflist'] = $this->language->get('text_dflist');
		$this->data['text_dfgrid'] = $this->language->get('text_dfgrid');
		$this->data['entry_theme'] = $this->language->get('entry_theme');
		$this->data['text_flyout_position'] = $this->language->get('text_flyout_position');
		$this->data['text_flyout_position_ul'] = $this->language->get('text_flyout_position_ul');
		$this->data['text_flyout_position_li'] = $this->language->get('text_flyout_position_li');
		
		$this->data['url_tomodule'] = $this->url->link('module/flyoutmenumodule', 'token=' . $this->session->data['token'], 'SSL');
		
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
			'href'      => $this->url->link('module/flyoutmenu', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		$this->data['default_url'] = $this->url->link('module/flyoutmenu', 'token=' . $this->session->data['token'], 'SSL');
		if (!$this->data['current_menu']) {
			$this->data['action'] = $this->url->link('module/flyoutmenu', 'token=' . $this->session->data['token'], 'SSL');
		} else {
			$this->data['action'] = $this->url->link('module/flyoutmenu', 'token=' . $this->session->data['token'] . '&menu_id=' . $this->data['current_menu'], 'SSL');
		}
		
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		$this->data['modules'] = array();
		$this->data['items'] = array();
		$this->data['categories'] = array();
		$this->data['informations'] = array();
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		
		
		$categ = $this->model_catalog_category->getCategories(0);

		foreach ($categ as $cate) {
							
			$this->data['categories'][] = array(
				'category_id' => $cate['category_id'],
				'name'        => $cate['name']
			);
		}
		
		$infos = $this->model_catalog_information->getInformations();
		
		foreach ($infos as $info) {
							
			$this->data['informations'][] = array(
				'information_id' => $info['information_id'],
				'name'           => $info['title']
			);
		}
		
		
		if (isset($this->request->post['flyoutmenu_module'])) {
			$this->data['modules'] = $this->request->post['flyoutmenu_module'];
		} elseif ($this->config->get('flyoutmenu_module')) { 
			$this->data['modules'] = $this->config->get('flyoutmenu_module');
		}
		if (isset($this->request->post[$preffix.'flyoutmenu_item'])) {
			$this->data['items'] = $this->request->post[$preffix.'flyoutmenu_item'];
		} elseif ($this->config->get($preffix.'flyoutmenu_item')) { 
			$this->data['items'] = $this->config->get($preffix.'flyoutmenu_item');
		} else {
			$this->data['items'] = array();
		}
		if (isset($this->request->post[$preffix.'flyoutmenu_settings'])) {
			$this->data['settings'] = $this->request->post[$preffix.'flyoutmenu_settings'];
		} elseif ($this->config->get($preffix.'flyoutmenu_settings')) { 
			$this->data['settings'] = $this->config->get($preffix.'flyoutmenu_settings');
		} else {
			$this->data['settings'] = array();
		}
		if (isset($this->request->post[$preffix.'flyoutmenu_settings_status'])) {
			$this->data['flyoutmenu_settings_status'] = $this->request->post[$preffix.'flyoutmenu_settings_status'];
		} elseif ($this->config->get($preffix.'flyoutmenu_settings_status')) { 
			$this->data['flyoutmenu_settings_status'] = $this->config->get($preffix.'flyoutmenu_settings_status');
		} else {
		    $this->data['flyoutmenu_settings_status'] = '';
		}
		if (isset($this->request->post[$preffix.'flyoutmenu_more'])) {
			$this->data['flyoutmenu_more'] = $this->request->post[$preffix.'flyoutmenu_more'];
		} elseif ($this->config->get($preffix.'flyoutmenu_more')) {
			$this->data['flyoutmenu_more'] = $this->config->get($preffix.'flyoutmenu_more');
		} else {
			$this->data['flyoutmenu_more'] = array();
		}
		if (isset($this->request->post[$preffix.'flyoutmenu_more2'])) {
			$this->data['flyoutmenu_more2'] = $this->request->post[$preffix.'flyoutmenu_more2'];
		} elseif ($this->config->get($preffix.'flyoutmenu_more2')) {
			$this->data['flyoutmenu_more2'] = $this->config->get($preffix.'flyoutmenu_more2');
		} else {
			$this->data['flyoutmenu_more2'] = array();
		}
		
        if (isset($this->request->post[$preffix.'flyoutmenu_options'])) {
            $fo = $this->request->post[$preffix.'flyoutmenu_options'];
        } elseif ($this->config->get($preffix.'flyoutmenu_options')) {
            $fo = $this->config->get($preffix.'flyoutmenu_options');
        } else {
            $fo = array();
        }
		if (isset($fo['dropdowntitle'])) {
			$this->data['flyoutmenu_dropdowntitle'] = $fo['dropdowntitle'];
		} else {
		    $this->data['flyoutmenu_dropdowntitle'] = 0;
		}
		if (isset($fo['positioning'])) {
			$this->data['flyoutmenu_positioning'] = $fo['positioning'];
		} else {
		    $this->data['flyoutmenu_positioning'] = 1;
		}
		if (isset($fo['topitemlink'])) {
			$this->data['flyoutmenu_topitemlink'] = $fo['topitemlink'];
		} else {
		    $this->data['flyoutmenu_topitemlink'] = 'topitem';
		}
		if (isset($fo['flyout_width'])) {
			$this->data['flyoutmenu_flyout_width'] = $fo['flyout_width'];
		} else {
		    $this->data['flyoutmenu_flyout_width'] = 800;
		}
		if (isset($fo['flyoutcache'])) {
			$this->data['flyoutmenu_flyoutcache'] = $fo['flyoutcache'];
		} else {
		    $this->data['flyoutmenu_flyoutcache'] = 0;
		}
		if (isset($fo['bannerspace_width'])) {
			$this->data['flyoutmenu_bannerspace_width'] = $fo['bannerspace_width'];
		} else {
		    $this->data['flyoutmenu_bannerspace_width'] = '';
		}
		if (isset($fo['3dlevellimit'])) {
			$this->data['flyoutmenu_3dlevellimit'] = $fo['3dlevellimit'];
		} else {
		    $this->data['flyoutmenu_3dlevellimit'] = '';
		}
		if (isset($fo['image_width'])) {
			$this->data['flyoutmenu_image_width'] = $fo['image_width'];
		} else {
		    $this->data['flyoutmenu_image_width'] = 120;
		}
		if (isset($fo['image_height'])) {
			$this->data['flyoutmenu_image_height'] = $fo['image_height'];
		} else {
		    $this->data['flyoutmenu_image_height'] = 120;
		}
		if (isset($fo['dropdowneffect'])) {
			$this->data['flyoutmenu_dropdowneffect'] = $fo['dropdowneffect'];
		} else {
		    $this->data['flyoutmenu_dropdowneffect'] = 'drop';
		}
		if (isset($fo['usehoverintent'])) {
			$this->data['flyoutmenu_usehoverintent'] = $fo['usehoverintent'];
		} else {
		    $this->data['flyoutmenu_usehoverintent'] = '';
		}
        
		
        if (isset($this->request->post[$preffix.'flyoutmenu_language'])) {
            $fl = $this->request->post[$preffix.'flyoutmenu_language'];
        } elseif ($this->config->get($preffix.'flyoutmenu_language')) {
            $fl = $this->config->get($preffix.'flyoutmenu_language');
        } else {
            $fl = array();
        }
		if (isset($fl['mobilemenuname'])) {
			$this->data['flyoutmenu_mobilemenuname'] = $fl['mobilemenuname'];
		} else {
		    $this->data['flyoutmenu_mobilemenuname'] = array();
		}
		if (isset($fl['more_title'])) {
			$this->data['flyoutmenu_more_title'] = $fl['more_title'];
		} else {
		    $this->data['flyoutmenu_more_title'] = array();
		}
		if (isset($fl['more2_title'])) {
			$this->data['flyoutmenu_more2_title'] = $fl['more2_title'];
		} else {
		    $this->data['flyoutmenu_more2_title'] = array();
		}
		if (isset($fl['infodname'])) {
			$this->data['flyoutmenu_infodname'] = $fl['infodname'];
		} else {
		    $this->data['flyoutmenu_infodname'] = array();
		}
		if (isset($fl['brandsdname'])) {
			$this->data['flyoutmenu_brandsdname'] = $fl['brandsdname'];
		} else {
		    $this->data['flyoutmenu_brandsdname'] = array();
		}
		if (isset($fl['latestpname'])) {
			$this->data['flyoutmenu_latestpname'] = $fl['latestpname'];
		} else {
		    $this->data['flyoutmenu_latestpname'] = array();
		}
		if (isset($fl['specialpname'])) {
			$this->data['flyoutmenu_specialpname'] = $fl['specialpname'];
		} else {
		    $this->data['flyoutmenu_specialpname'] = array();
		}
		if (isset($fl['featuredpname'])) {
			$this->data['flyoutmenu_featuredpname'] = $fl['featuredpname'];
		} else {
		    $this->data['flyoutmenu_featuredpname'] = array();
		}
		if (isset($fl['bestpname'])) {
			$this->data['flyoutmenu_bestpname'] = $fl['bestpname'];
		} else {
		    $this->data['flyoutmenu_bestpname'] = array();
		}
		if (isset($fl['viewallname'])) {
			$this->data['flyoutmenu_viewallname'] = $fl['viewallname'];
		} else {
		    $this->data['flyoutmenu_viewallname'] = array();
		}
		if (isset($fl['viewmorename'])) {
			$this->data['flyoutmenu_viewmorename'] = $fl['viewmorename'];
		} else {
		    $this->data['flyoutmenu_viewmorename'] = array();
		}
        
		if (isset($this->request->post[$preffix.'flyoutmenu_htmlarea1'])) {
			$this->data['flyoutmenu_htmlarea1'] = $this->request->post[$preffix.'flyoutmenu_htmlarea1'];
		} elseif ($this->config->get($preffix.'flyoutmenu_htmlarea1')) {
			$this->data['flyoutmenu_htmlarea1'] = $this->config->get($preffix.'flyoutmenu_htmlarea1');
		} else {
		    $this->data['flyoutmenu_htmlarea1'] = array();
		}
		if (isset($this->request->post[$preffix.'flyoutmenu_htmlarea2'])) {
			$this->data['flyoutmenu_htmlarea2'] = $this->request->post[$preffix.'flyoutmenu_htmlarea2'];
		} elseif ($this->config->get($preffix.'flyoutmenu_htmlarea2')) {
			$this->data['flyoutmenu_htmlarea2'] = $this->config->get($preffix.'flyoutmenu_htmlarea2');
		} else {
		    $this->data['flyoutmenu_htmlarea2'] = array();
		}
		if (isset($this->request->post[$preffix.'flyoutmenu_htmlarea3'])) {
			$this->data['flyoutmenu_htmlarea3'] = $this->request->post[$preffix.'flyoutmenu_htmlarea3'];
		} elseif ($this->config->get($preffix.'flyoutmenu_htmlarea3')) {
			$this->data['flyoutmenu_htmlarea3'] = $this->config->get($preffix.'flyoutmenu_htmlarea3');
		} else {
		    $this->data['flyoutmenu_htmlarea3'] = array();
		}
		if (isset($this->request->post[$preffix.'flyoutmenu_htmlarea4'])) {
			$this->data['flyoutmenu_htmlarea4'] = $this->request->post[$preffix.'flyoutmenu_htmlarea4'];
		} elseif ($this->config->get($preffix.'flyoutmenu_htmlarea4')) {
			$this->data['flyoutmenu_htmlarea4'] = $this->config->get($preffix.'flyoutmenu_htmlarea4');
		} else {
		    $this->data['flyoutmenu_htmlarea4'] = array();
		}
		if (isset($this->request->post[$preffix.'flyoutmenu_htmlarea5'])) {
			$this->data['flyoutmenu_htmlarea5'] = $this->request->post[$preffix.'flyoutmenu_htmlarea5'];
		} elseif ($this->config->get($preffix.'flyoutmenu_htmlarea5')) {
			$this->data['flyoutmenu_htmlarea5'] = $this->config->get($preffix.'flyoutmenu_htmlarea5');
		} else {
		    $this->data['flyoutmenu_htmlarea5'] = array();
		}
		if (isset($this->request->post[$preffix.'flyoutmenu_htmlarea6'])) {
			$this->data['flyoutmenu_htmlarea6'] = $this->request->post[$preffix.'flyoutmenu_htmlarea6'];
		} elseif ($this->config->get($preffix.'flyoutmenu_htmlarea6')) {
			$this->data['flyoutmenu_htmlarea6'] = $this->config->get($preffix.'flyoutmenu_htmlarea6');
		} else {
		    $this->data['flyoutmenu_htmlarea6'] = array();
		}
		if (isset($this->request->post[$preffix.'flyoutmenu_htmlarea7'])) {
			$this->data['flyoutmenu_htmlarea7'] = $this->request->post[$preffix.'flyoutmenu_htmlarea7'];
		} elseif ($this->config->get($preffix.'flyoutmenu_htmlarea7')) {
			$this->data['flyoutmenu_htmlarea7'] = $this->config->get($preffix.'flyoutmenu_htmlarea7');
		} else {
		    $this->data['flyoutmenu_htmlarea7'] = array();
		}
		if (isset($this->request->post[$preffix.'flyoutmenu_htmlarea8'])) {
			$this->data['flyoutmenu_htmlarea8'] = $this->request->post[$preffix.'flyoutmenu_htmlarea8'];
		} elseif ($this->config->get($preffix.'flyoutmenu_htmlarea8')) {
			$this->data['flyoutmenu_htmlarea8'] = $this->config->get($preffix.'flyoutmenu_htmlarea8');
		} else {
		    $this->data['flyoutmenu_htmlarea8'] = array();
		}
				
		$this->load->model('design/layout');
		
		$this->data['layouts'] = $this->model_design_layout->getLayouts();

		$this->template = 'module/flyoutmenu.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/flyoutmenu')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		return !$this->error;
	}
	
	public function delete() {
		if ($this->validate() && (int)$this->request->get['menu_id']) {
			$this->language->load('module/flyoutmenu');
			$this->load->model('setting/setting');
			$preffix = 'menu'.(int)$this->request->get['menu_id'].'_';	
			$this->model_setting_setting->deleteSetting($preffix.'flyoutmenu');
			$this->session->data['success'] = $this->language->get('text_success_delete');
			$this->redirect($this->url->link('module/flyoutmenu', 'token=' . $this->session->data['token'], 'SSL'));
		} else {
			$this->redirect($this->url->link('module/flyoutmenu', 'token=' . $this->session->data['token'], 'SSL'));
		}
	}
}
?>