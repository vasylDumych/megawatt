<?php

class ControllerModuleMarketshop extends Controller {
    
    private $error = array(); 
    
    public function index() {   
	
        //Load the language file for this module
        $language = $this->load->language('module/marketshop');
        $this->data = array_merge($this->data, $language);

        //Set the title from the language file $_['heading_title'] string
        $this->document->setTitle($this->language->get('heading_title'));
        
        //Load the settings model. You can also add any other models you want to load here.
        $this->load->model('setting/setting');
        
        $this->load->model('tool/image');  
        
        //Save the settings if the user has submitted the admin form (ie if someone has pressed save).
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('marketshop', $this->request->post);    

                
                    
            $this->session->data['success'] = $this->language->get('text_success');
        
                        
            $this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
        }
        
            $this->data['text_image_manager'] = 'Image manager';
                    $this->data['token'] = $this->session->data['token'];       
        
        $text_strings = array(
                'heading_title',
                'text_enabled',
                'text_disabled',
                'text_content_top',
                'text_content_bottom',
                'text_column_left',
                'text_column_right',
                'entry_status',
                'entry_sort_order',
                'button_save',
                'button_cancel',
				
        );
        
        foreach ($text_strings as $text) {
            $this->data[$text] = $this->language->get($text);
        }
        

        // store config data
        
        $config_data = array(

        //Status
		'marketshop_status',
		'marketshop_skin',
		
		//Theme Color
		'marketshop_theme_color',
		
		//Body Background
        'marketshop_background_color',
		'marketshop_pattern_overlay',
        'marketshop_custom_image',
        'marketshop_image_preview',
        'marketshop_pattern_preview',
		'marketshop_custom_image_position',
		'marketshop_custom_image_attachment',
		'marketshop_custom_image_repeat',
		'marketshop_homepage_slideshow',
		
		//Button
        'marketshop_button_color',
        'marketshop_button_hover_color',
        'marketshop_button_text_color',
		
		//Footer
        'marketshop_footer_heading_text_color',
        'marketshop_sub_link_text_color',
        'marketshop_powerd_by_text_color',
		
		'marketshop_footer_bg_color',
		'marketshop_footer_titles_color',
		'marketshop_footer_text_color',
		'marketshop_footer_link_color',
		'marketshop_footer_link_hover_color',
		
		'marketshop_contact_icon',
		
		'marketshop_footer_second_bg_color',
		'marketshop_footer_second_text_color',
		'marketshop_footer_second_link_color',
		'marketshop_footer_second_link_hover_color',
		'marketshop_footer_second_separator_size',
		'marketshop_footer_second_separator_color',
		'marketshop_footer_second_separator_style',
		
		//Price
		'marketshop_price_color',
		'marketshop_old_price_color',
		'marketshop_new_price_color',
		'marketshop_tax_price_color',
		
		'marketshop_saving_percentage_bg_color',
		'marketshop_saving_percentage_text_color',
		
		//Buttons
		'marketshop_button_bg_color',
		'marketshop_button_bg_hover_color',
		'marketshop_button_text_color',
		'marketshop_button_text_hover_color',
		
		'marketshop_excl_button_bg_color',
		'marketshop_excl_button_bg_hover_color',
		'marketshop_excl_button_text_color',
		'marketshop_excl_button_text_hover_color',
		
		'marketshop_cart_button_bg_color',
		'marketshop_cart_button_bg_hover_color',
		'marketshop_cart_button_text_color',
		'marketshop_cart_button_text_hover_color',		
		
		'marketshop_body_text_color',
		'marketshop_heading_color',
		
		//Social Icon
		'marketshop_facebook_id',
        'marketshop_twitter_username',
        'marketshop_gplus_id',
		'marketshop_pint_id',
		'marketshop_rss',
		'marketshop_blogger',		
		'marketshop_myspace',
		'marketshop_linkedin',
		'marketshop_evernote',
		'marketshop_dopplr',
		'marketshop_ember',
		'marketshop_flickr',
		'marketshop_picasa_web',
		'marketshop_youtube',
		'marketshop_technorati',
		'marketshop_grooveshark',
		'marketshop_vimeo',
		'marketshop_sharethis',
		'marketshop_yahoobuzz',
		'marketshop_viddler',
		'marketshop_skype',
		'marketshop_google_googletalk',
		'marketshop_digg',
		'marketshop_reddit',
		'marketshop_delicious',
		'marketshop_stumbleupon',
		'marketshop_friendfeed',
		'marketshop_tumblr',
		'marketshop_yelp',
		'marketshop_posterous',
		'marketshop_bebo',
		'marketshop_virb',
		'marketshop_last_fm',
		'marketshop_pandora',
		'marketshop_mixx',
		'marketshop_newsvine',
		'marketshop_openid',
		'marketshop_readernaut',
		'marketshop_xing_me',
		'marketshop_instagram',
		'marketshop_spotify',
		'marketshop_forrst',
		'marketshop_viadeo',
		'marketshop_vk_com',

		//Fonts		
		'marketshop_title_font',
		'marketshop_title_font_weight',
		'marketshop_title_font_uppercase',
		'marketshop_title_font_size',
		
        'marketshop_body_font',
		'marketshop_main_menu_font',
		'marketshop_main_menu_font_weight',
		'marketshop_main_menu_font_uppercase',
		'marketshop_main_menu_font_size',
		
		'marketshop_top_bar_font',
		'marketshop_top_bar_font_weight',
		'marketshop_top_bar_font_size',
		'marketshop_top_bar_font_uppercase',
		
		'marketshop_secondary_titles_font',
		'marketshop_secondary_titles_font_weight',
		'marketshop_secondary_titles_font_uppercase',
		'marketshop_secondary_titles_font_size',
		
		'marketshop_footer_titles_font',
		'marketshop_footer_titles_font_weight',
		'marketshop_footer_titles_font_uppercase',
		'marketshop_footer_titles_font_size',
		
		
		//Socia Fun Box
		'marketshop_facebook_id_box',		
        'twitter_username',

		'marketshop_custom_column',
		'marketshop_widget_id',		
		'marketshop_powered',
		
		'marketshop_custom_column_footer_status',
		'marketshop_custom_column_footer',
		
		'marketshop_custom_block2_status',
		'marketshop_custom_block2_title',
		'marketshop_custom_block2_content',
		
		'marketshop_custom_block3_status',
		'marketshop_custom_block3_title',
		'marketshop_custom_block3_content',
		'marketshop_custom_block_bg_color',
		
		
		//Feature Box
		'marketshop_feature_box_per_row',
		'marketshop_feature_box_homepage_only',
		'marketshop_feature_box_show_header_footer',
		
		'marketshop_feature_box1_status',
		'marketshop_feature_box1_title',
		'marketshop_feature_box1_subtitle',
		
		'marketshop_feature_box2_status',
		'marketshop_feature_box2_title',
		'marketshop_feature_box2_subtitle',
		
		'marketshop_feature_box3_status',
		'marketshop_feature_box3_title',
		'marketshop_feature_box3_subtitle',
		
		'marketshop_feature_box4_status',
		'marketshop_feature_box4_title',
		'marketshop_feature_box4_subtitle',
		
		'marketshop_feature_box1_bg_color',
		'marketshop_feature_box2_bg_color',
		'marketshop_feature_box3_bg_color',
		'marketshop_feature_box4_bg_color',
		
		'marketshop_feature_box1_title_color',
		'marketshop_feature_box2_title_color',
		'marketshop_feature_box3_title_color',
		'marketshop_feature_box4_title_color',
		
		'marketshop_feature_box1_subtitle_color',
		'marketshop_feature_box2_subtitle_color',
		'marketshop_feature_box3_subtitle_color',
		'marketshop_feature_box4_subtitle_color',
		
		'marketshop_feature_box_title_font_size',
		'marketshop_feature_box_title_font_weight',
		'marketshop_feature_box_title_font_transform',
		
		'marketshop_feature_box_title_font_size',
		'marketshop_feature_box_title_font_weight',
		'marketshop_feature_box_title_font_transform',
		
		'marketshop_feature_box_subtitle_font_size',
		'marketshop_feature_box_subtitle_font_weight',
		'marketshop_feature_box_subtitle_font_transform',

		//Contact Details
		'marketshop_contact',
		'marketshop_address',
		'marketshop_mobile',
		'marketshop_email',
		
		'marketshop_contact_status',
		'marketshop_address_status',
		'marketshop_mobile_status',
		'marketshop_email_status',
		'marketshop_about_contact_details',
		'marketshop_about_details',
		
		//Payment Methods Image
		'marketshop_custom_payment_image_status',
		'marketshop_custom_payment_image_url',
		'marketshop_custom_payment_image',
		'marketshop_custom_payment_image_preview',
		'marketshop_paypal',
		'marketshop_paypal_url',
		'marketshop_american',
		'marketshop_american_url',
		'marketshop_2checkout',
		'marketshop_2checkout_url',
		'marketshop_discover',
		'marketshop_discover_url',
		'marketshop_maestro',
		'marketshop_maestro_url',
		'marketshop_mastercard',
		'marketshop_mastercard_url',
		'marketshop_visa',
		'marketshop_visa_url',
		'marketshop_sagepay',
		'marketshop_sagepay_url',
		'marketshop_moneybookers',
		'marketshop_moneybookers_url',
		'marketshop_cirrus',
		'marketshop_cirrus_url',
		'marketshop_delta',
		'marketshop_delta_url',
		'marketshop_direct',
		'marketshop_direct_url',
		'marketshop_google',
		'marketshop_google_url',
		'marketshop_solo',
		'marketshop_solo_url',
		'marketshop_switch',
		'marketshop_switch_url',
		'marketshop_western_union',
		'marketshop_western_union_url',
		'marketshop_ebay',
		'marketshop_ebay_url',
		
		//Custom CSS
        'marketshop_custom_css',
		
		'marketshop_top_bar_bg_color',
		'marketshop_top_bar_link_color',
		'marketshop_top_bar_link_separator_color',
		'marketshop_top_bar_link_separator_style',
		'marketshop_top_bar_sub_link_color',
		'marketshop_top_bar_sub_link_hover_color',
		'marketshop_top_contact_icon',
		'marketshop_top_bar_contact_status',
		'marketshop_top_bar_contact_status2',
		'marketshop_top_bar_contact_status3',
		'marketshop_top_bar_contact',
		'marketshop_top_bar2_contact',
		'marketshop_top_bar3_contact',
		'marketshop_top_bar_email_status',
		'marketshop_top_bar_email',
		
		'marketshop_header_bg_color',
		
		'marketshop_mini_cart_icon_color',
		'marketshop_mini_cart_link_color',
		'marketshop_mini_cart_active_link_color',
		
		'marketshop_search_bar_background_color',
		'marketshop_search_bar_border_color',
		'marketshop_search_bar_text_color',
		'marketshop_search_bar_border_hover_color',
		
		
		//Top Menu
        'marketshop_top_menu',
		
		'marketshop_menu_bg_color_status',
		'marketshop_menu_bg_color',
		'marketshop_menu_link_color',
		'marketshop_menu_link_hover_color',
		'marketshop_menu_link_hover_bg_color',
		
		'marketshop_home_page_link_background_color',
		'marketshop_home_page_link_background_color_hover',
		'marketshop_home_page_link_link_color',
		'marketshop_home_page_link_link_color_hover',
		'marketshop_home_page_link_icon_color',
		'marketshop_home_page_link_icon_color_hover',
				
		'marketshop_categories_section_background_color',
		'marketshop_categories_section_background_color_hover',
		'marketshop_categories_section_link_color',
		'marketshop_categories_section_link_color_hover',
		
		'marketshop_brands_section_background_color',
		'marketshop_brands_section_background_color_hover',
		'marketshop_brands_section_link_color',
		'marketshop_brands_section_link_color_hover',
		
		'marketshop_custom_link_section_background_color',
		'marketshop_custom_link_section_background_color_hover',
		'marketshop_custom_link_section_link_color',
		'marketshop_custom_link_section_link_color_hover',
		
		'marketshop_custom_block_section_background_color',
		'marketshop_custom_block_section_background_color_hover',
		'marketshop_custom_block_section_link_color',
		'marketshop_custom_block_section_link_color_hover',
		
		'marketshop_custom_block_section_background_color',
		'marketshop_custom_block_section_background_color_hover',
		'marketshop_custom_block_section_link_color',
		'marketshop_custom_block_section_link_color_hover',
		
		'marketshop_myaccount_section_background_color',
		'marketshop_myaccount_section_background_color_hover',
		'marketshop_myaccount_section_link_color',
		'marketshop_myaccount_section_link_color_hover',
		
		'marketshop_information_section_background_color',
		'marketshop_information_section_background_color_hover',
		'marketshop_information_section_link_color',
		'marketshop_information_section_link_color_hover',
		
		'marketshop_contact_section_background_color',
		'marketshop_contact_section_background_color_hover',
		'marketshop_contact_section_link_color',
		'marketshop_contact_section_link_color_hover',
		
		'marketshop_custom_link_right_background_color',
		'marketshop_custom_link_right_background_color_hover',
		'marketshop_custom_link_right_link_color',
		'marketshop_custom_link_right_link_color_hover',
		
		'marketshop_sub_menu_background_color',
		'marketshop_sub_menu_top_border_color',
		'marketshop_sub_menu_heading_text_color',
		'marketshop_sub_menu_heading_text_separator_color',
		'marketshop_sub_menu_heading_text_separator_style',
		'marketshop_sub_menu_link_hover_color',
		'marketshop_sub_menu_link_color',
		'marketshop_sub_menu_link_separator_color',
		'marketshop_sub_menu_link_separator_style',
		'marketshop_menu_link_separator_color',
		'marketshop_menu_link_separator_status',
		'marketshop_menu_link_separator_size',
		'marketshop_menu_link_separator_style',
		
		'marketshop_menu_link_border_top_color',
		'marketshop_menu_link_border_top_status',
		'marketshop_menu_link_border_top_size',
		'marketshop_menu_link_border_top_style',
		
		'marketshop_menu_link_border_bottom_color',
		'marketshop_menu_link_border_bottom_status',
		'marketshop_menu_link_border_bottom_size',
		'marketshop_menu_link_border_bottom_style',
		
		'marketshop_custom_link1_top',
		'marketshop_custom_link1_top_url',
		'marketshop_custom_link1_top_title',
		'marketshop_target_link1_top',
		
		'marketshop_custom_link2_top',
		'marketshop_custom_link2_top_url',
		'marketshop_custom_link2_top_title',
		'marketshop_target_link2_top',
		
		'marketshop_custom_link3_top',
		'marketshop_custom_link3_top_url',
		'marketshop_custom_link3_top_title',
		'marketshop_target_link3_top',
		
		
		'marketshop_custom_block_top',
		'marketshop_custom_block_top_status',
		'marketshop_custom_block_top_title',
		'marketshop_custom_block_top_content',
		
		'marketshop_custom_block2_top_status',
		'marketshop_custom_block2_top_title',
		'marketshop_custom_block2_top_content',
		
		'marketshop_wishlist_top_link',
		'marketshop_account_top_link',
		'marketshop_checkout_top_link',
		
		//Top Header
		'marketshop_header_style',
		'marketshop_header_margin',
		'marketshop_layout_style',
		'marketshop_main_menu_style',
		'marketshop_custom_link1',
		'marketshop_custom_link1_url',
		'marketshop_custom_link1_title',
		'marketshop_target_link1',
		
		'marketshop_custom_link2',
		'marketshop_custom_link2_url',
		'marketshop_custom_link2_title',
		'marketshop_target_link2',
		
		'marketshop_custom_link3',
		'marketshop_custom_link3_url',
		'marketshop_custom_link3_title',
		'marketshop_target_link3',
		
		'marketshop_custom_link4',
		'marketshop_custom_link4_url',
		'marketshop_custom_link4_title',
		'marketshop_target_link4',
		
		'marketshop_custom_link5',
		'marketshop_custom_link5_url',
		'marketshop_custom_link5_title',
		'marketshop_custom_block',
		'marketshop_custom_block_status',
		'marketshop_custom_block_title',
		'marketshop_custom_block_content',
		
		'marketshop_target_link5',
		
		'marketshop_main_menu_align',
		'marketshop_home_page_link',
		'marketshop_home_page_link_icon',
		'marketshop_my_account',
		'marketshop_information_page',
		'marketshop_contact_us',
		'marketshop_menu_brands',
		'marketshop_custom_link_right',
		'marketshop_custom_link_right_target',
		'marketshop_custom_link_right_url',
		'marketshop_custom_link_right_title',
				
		'marketshop_menu_brands_title',
		'marketshop_menu_categories_title',
		
		'marketshop_twitter_box_align',
		'marketshop_facebook_box_align',
		'marketshop_facebook_block_status',
		'marketshop_twitter_block_status',
		'marketshop_twitter_block_sort_order',
		'marketshop_facebook_block_sort_order',
		'marketshop_custom_side_block_sort_order',
		'marketshop_custom_column_status',
		'marketshop_custom_side_block_align',
		'marketshop_video_box_status',
		'marketshop_video_box_align',
		'marketshop_video_box_content',
		'marketshop_video_box_sort_order',
		
		'marketshop_back_to_top',
		'marketshop_mobile_menu_title',
		'marketshop_search_auto_complete',
		'marketshop_affiliate_status',
		'marketshop_language_currency_title',
		
		'marketshop_refine_categories',
		'marketshop_refine_categories_images',
		'marketshop_brands_display_style',
		
		'marketshop_general_links_color',
		'marketshop_general_links_hover_color',
		'marketshop_secondary_heading_color',
		'marketshop_secondary_heading_border_color',
		
		'marketshop_cloud_zoom',
		'marketshop_cloud_zoom_gallery',
		'marketshop_cloud_zoom_gallery_text',
		'marketshop_cloud_zoom_inner',
		'marketshop_share_plugin',
		'marketshop_share_plugin_style',
		'marketshop_percentage_discount_badge',
		
		'marketshop_category_product_per_row',
		'marketshop_manufacturer_product_per_row',
		'marketshop_special_product_per_row',
		'marketshop_search_product_per_row',
		
		'marketshop_featured_slider_product_per_row',
		'marketshop_bestsellers_slider_product_per_row',
		'marketshop_latest_slider_product_per_row',
		'marketshop_specials_slider_product_per_row',
		'marketshop_related_slider_product_per_row',
		'marketshop_product_tab_slider_product_per_row',
		'marketshop_lpbc_slider_product_per_row',
		'marketshop_latest_product_brand_per_row',
		
        );
        
        foreach ($config_data as $conf) {
            if (isset($this->request->post[$conf])) {
                $this->data[$conf] = $this->request->post[$conf];
            } else {
                $this->data[$conf] = $this->config->get($conf);
            }
        }
    
        //This creates an error message. The error['warning'] variable is set by the call to function validate() in this controller (below)
        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }
        
        //SET UP BREADCRUMB TRAIL. YOU WILL NOT NEED TO MODIFY THIS UNLESS YOU CHANGE YOUR MODULE NAME.
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
            'href'      => $this->url->link('module/marketshop', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );
        
        $this->data['action'] = $this->url->link('module/marketshop', 'token=' . $this->session->data['token'], 'SSL');
        
        $this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

    
        //This code handles the situation where you have multiple instances of this module, for different layouts.
        if (isset($this->request->post['marketshop_module'])) {
            $modules = explode(',', $this->request->post['marketshop_module']);
        } elseif ($this->config->get('marketshop_module') != '') {
            $modules = explode(',', $this->config->get('marketshop_module'));
        } else {
            $modules = array();
        }           
                
        $this->load->model('design/layout');
        
        $this->data['layouts'] = $this->model_design_layout->getLayouts();
                
        foreach ($modules as $module) {
            if (isset($this->request->post['marketshop_' . $module . '_layout_id'])) {
                $this->data['marketshop_' . $module . '_layout_id'] = $this->request->post['marketshop_' . $module . '_layout_id'];
            } else {
                $this->data['marketshop_' . $module . '_layout_id'] = $this->config->get('marketshop_' . $module . '_layout_id');
            }   
            
            if (isset($this->request->post['marketshop_' . $module . '_position'])) {
                $this->data['marketshop_' . $module . '_position'] = $this->request->post['marketshop_' . $module . '_position'];
            } else {
                $this->data['marketshop_' . $module . '_position'] = $this->config->get('marketshop_' . $module . '_position');
            }   
            
            if (isset($this->request->post['marketshop_' . $module . '_status'])) {
                $this->data['marketshop_' . $module . '_status'] = $this->request->post['marketshop_' . $module . '_status'];
            } else {
                $this->data['marketshop_' . $module . '_status'] = $this->config->get('marketshop_' . $module . '_status');
            }   
                        
            if (isset($this->request->post['marketshop_' . $module . '_sort_order'])) {
                $this->data['marketshop_' . $module . '_sort_order'] = $this->request->post['marketshop_' . $module . '_sort_order'];
            } else {
                $this->data['marketshop_' . $module . '_sort_order'] = $this->config->get('marketshop_' . $module . '_sort_order');
            }               
        }
        
		$this->load->model('localisation/language');
		
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		
        
        $this->data['modules'] = $modules;
        
        if (isset($this->request->post['marketshop_module'])) {
            $this->data['marketshop_module'] = $this->request->post['marketshop_module'];
        } else {
            $this->data['marketshop_module'] = $this->config->get('marketshop_module');
        }

        //Choose which template file will be used to display this request.
        $this->template = 'module/marketshop.tpl';
        $this->children = array(
            'common/header',
            'common/footer',
        );

        if (isset($this->data['marketshop_custom_image']) && $this->data['marketshop_custom_image'] != "" && file_exists(DIR_IMAGE . $this->data['marketshop_custom_image'])) {
            $this->data['marketshop_image_preview'] = $this->model_tool_image->resize($this->data['marketshop_custom_image'], 100, 100);
        } else {
            $this->data['marketshop_image_preview'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
        }
		
		if (isset($this->data['marketshop_custom_payment_image']) && $this->data['marketshop_custom_payment_image'] != "" && file_exists(DIR_IMAGE . $this->data['marketshop_custom_payment_image'])) {
            $this->data['marketshop_custom_payment_image_preview'] = $this->model_tool_image->resize($this->data['marketshop_custom_payment_image'], 100, 100);
        } else {
            $this->data['marketshop_custom_payment_image_preview'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
        }

        $this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);

        //Send the output.
        $this->response->setOutput($this->render());
    }
    
    /*
     * 
     * This function is called to ensure that the settings chosen by the admin user are allowed/valid.
     * You can add checks in here of your own.
     * 
     */
    
    private function validate() {
        if (!$this->user->hasPermission('modify', 'module/marketshop')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
        
        if (!$this->error) {
            return TRUE;
        } else {
            return FALSE;
        }   
    }


}
?>