<?php

class ControllerInformationNews extends Controller
{
    public function index()
    {
        $this->document->addStyle('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/news.css');

        $this->language->load('information/news');

        $this->load->model('module/news');

        $this->load->model('setting/setting');

        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'href' => $this->url->link('common/home'),
            'text' => $this->language->get('text_home'),
            'separator' => false
        );

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        $settings = $this->model_setting_setting->getSetting('news');

        $limit = $settings['news_pagination_val'];

        $start = $page * $limit - $limit;

        $news_data = $this->model_module_news->getNews($start, $limit);

        $this->document->setTitle($this->language->get('heading_title'));

        $this->data['breadcrumbs'][] = array(
            'href' => $this->url->link('information/news'),
            'text' => $this->language->get('heading_title'),
            'separator' => $this->language->get('text_separator'));

        $this->data['heading_title'] = $this->language->get('heading_title');
        $this->data['text_more'] = $this->language->get('text_more');
        $this->data['text_posted'] = $this->language->get('text_posted');
        $this->data['text_no_results'] = $this->language->get('text_no_results');

        $this->load->model('tool/image');

        foreach ($news_data as $result) {

            if (!empty($result['image'])) {
                $thumb = $this->model_tool_image->resize($result['image'], $this->config->get('news_popup_width'), $this->config->get('news_popup_height'));
            } else {
                $thumb = false;
            }

            $this->data['news_data'][] = array(
                'id' => $result['news_id'],
                'title' => $result['title'],
                'description' => html_entity_decode($result['preview']),
                'href' => $this->url->link('information/news/info', 'news_id=' . $result['news_id']),
                'posted' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
                'thumb' => $thumb);
        }

        $this->data['button_continue'] = $this->language->get('button_continue');

        $this->data['continue'] = $this->url->link('common/home');

        $pagination = new Pagination();

        $pagination->total = $this->model_module_news->getTotalNews();
        $pagination->page = $page;
        $pagination->limit = $limit;
        $pagination->text = $this->language->get('text_pagination');
        $pagination->url = $this->url->link('information/news', '&page={page}');

        $this->data['pagination'] = $pagination->render();

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/news_list.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/information/news_list.tpl';
        } else {
            $this->template = 'default/template/information/news_list.tpl';
        }

        $this->children = array(
            'common/column_left',
            'common/column_right',

        'common/content_top_1_3',
		'common/content_top_2_3',
		
      
            'common/content_top',
            'common/content_bottom',

        'common/content_top_1_3',
      

        'common/content_top_2_3',
      

        'common/content_top_full',
      
            'common/footer',
            'common/header');

        $this->response->setOutput($this->render());

    }

    public function info()
    {
        $this->document->addStyle('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/news.css');

        $this->language->load('information/news');
        $this->load->model('module/news');
        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'href' => $this->url->link('common/home'),
            'text' => $this->language->get('text_home'),
            'separator' => false
        );

        if (isset($this->request->get['news_id'])) {
            $news_id = $this->request->get['news_id'];
        } else {
            $news_id = 0;
        }

        $news_info = $this->model_module_news->getNewsStory($news_id);

        if (!empty($news_info)) {

            $this->document->addStyle('catalog/view/javascript/jquery/colorbox/colorbox.css');
            $this->document->addScript('catalog/view/javascript/jquery/colorbox/jquery.colorbox-min.js');

            $this->data['breadcrumbs'][] = array(
                'href' => $this->url->link('information/news'),
                'text' => $this->language->get('heading_title'),
                'separator' => $this->language->get('text_separator')
            );

            $this->data['breadcrumbs'][] = array(
                'href' => $this->url->link('information/news', 'news_id=' . $this->request->get['news_id']),
                'text' => $news_info['title'],
                'separator' => $this->language->get('text_separator')
            );

            $this->document->setTitle($news_info['title']);
            $this->document->setDescription($news_info['meta_description']);
            $this->document->setKeywords($news_info['keyword']);
            $this->document->addLink($this->url->link('information/news/info', 'news_id=' . $this->request->get['news_id']), 'canonical');

            $this->data['news_info'] = $news_info;

            $this->data['heading_title'] = $news_info['title'];

            $this->data['description'] = html_entity_decode($news_info['description']);
            $this->data['date'] = date('d.m.Y', strtotime($news_info['date_added']));

            $this->data['viewed'] = sprintf($this->language->get('text_viewed'), $news_info['viewed']);

            $this->data['addthis'] = $this->config->get('news_newspage_addthis');

            $this->data['min_height'] = $this->config->get('news_thumb_height');

            $this->load->model('tool/image');

            if ($news_info['image']) {
                $this->data['image'] = true;
            } else {
                $this->data['image'] = false;
            }

            $this->data['thumb'] = $this->model_tool_image->resize($news_info['image'], $this->config->get('news_popup_width'), $this->config->get('news_popup_height'));
            $this->data['popup'] = HTTP_SERVER . 'image/' . $news_info['image'];

            $this->data['button_news'] = $this->language->get('button_news');
            $this->data['button_continue'] = $this->language->get('button_continue');

            $this->data['news'] = $this->url->link('information/news');
            $this->data['continue'] = $this->url->link('common/home');

            $this->model_module_news->updateViewed($this->request->get['news_id']);

            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/news.tpl')) {
                $this->template = $this->config->get('config_template') . '/template/information/news.tpl';
            } else {
                $this->template = 'default/template/information/news.tpl';
            }

            $this->children = array(
                'common/column_left',
                'common/column_right',

        'common/content_top_1_3',
		'common/content_top_2_3',
		
      
                'common/content_top',
                'common/content_bottom',

        'common/content_top_1_3',
      

        'common/content_top_2_3',
      

        'common/content_top_full',
      
                'common/footer',
                'common/header');

            $this->response->setOutput($this->render());

        } else {
            $this->redirect($this->url->link('error/not_found'));

        }


    }

}

?>
