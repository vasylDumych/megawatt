<?php

class ControllerModuleVipSmsNet extends Controller{
  private $_gate;
  private $_err;
  private $_log;

  public function index(){
    $this->_init();

    $this->data['tab_sel'] = null;
    if ($this->request->server['REQUEST_METHOD'] != 'POST'){
      $this->_view();
      return;
    }

    if ($this->_validate()){
      if (isset($this->request->post['setting_form'])){
        $this->model_setting_setting->editSetting('vipsms_net', $this->request->post);
        $this->session->data['success'] = $this->language->get('vipsms_net_saved_success');
        $this->_log->write('['.substr(__FILE__, strlen(DIR_SYSTEM)-1).'] Save settings form form success');
        $this->redirect($this->url->link('extension/module',
          'token='.$this->session->data['token']
        ));

      }else if(isset($this->request->post['sendsms_form'])){
        if (!$this->_gate){
          $this->_err = $this->language->get('vipsms_net_error_auth_info');
        }else{
          $this->_gate->setSign($this->config->get('vipsms_net_sign'));
          $this->_gate->sendSms($this->request->post['vipsms_net_frmsms_phone'],
            $this->request->post['vipsms_net_frmsms_message'] 
          );

          $errs = '';
          if ($errs=$this->_gate->getErrors()){
            $this->_err = $errs;
          }else{
            $this->session->data['success'] = $this->language->get('vipsms_net_smssend_success');
            $this->_log->write('['.substr(__FILE__, strlen(DIR_SYSTEM)-1).'] Send sms from form success');
            $this->redirect($this->url->link('module/vipsms_net', 'token='.$this->session->data['token'], 'SSL'));
          }
        }
      }
    }

    $this->_view();
  }


  private function _breadcrumbs(){
    $breadcrumbs[] = array(
       'text'      => $this->language->get('text_home'),
       'href'      => $this->url->link('common/home', 'token='.$this->session->data['token'], 'SSL'),
       'separator' => false
    );
    $breadcrumbs[] = array(
       'text'      => $this->language->get('text_module'),
       'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
       'separator' => ' :: '
    );
    $breadcrumbs[] = array(
       'text'      => $this->language->get('heading_title'),
       'href'      => $this->url->link('module/vipsms_net', 'token=' . $this->session->data['token'], 'SSL'),
       'separator' => ' :: '
    );

    return $breadcrumbs;
  }

  private function _init(){
    require_once(DIR_SYSTEM.'library/vipsms_net_gateway.php');

    $this->load->model('setting/setting');

    $this->load->model('localisation/language');

    $this->_log = new Log('vipsms_net.log');

    foreach($this->load->language('module/vipsms_net') as $key => $val){
      $this->data[$key] = $val;
    }

    $settings = $this->model_setting_setting->getSetting('vipsms_net');

    foreach($settings as $key => $val){
      $this->data['frm_'.$key] = $val;
    }

    if (array_key_exists('vipsms_net_admphone', $settings) && !$settings['vipsms_net_admphone']){
      $this->data['frm_vipsms_net_admphone'] = $this->config->get('config_telephone');
    }

    if (!empty($settings)){
      $this->_gate = new VipSMSNetGateway(
        $this->data['frm_vipsms_net_login'],
        $this->data['frm_vipsms_net_password']
      );
    }

  }

  protected function _view(){
    $this->document->setTitle($this->language->get('page_head_title'));

    # Set variables for view file
    $this->data['module_version'] = VipSMSNetGateway::VERSION;
    $this->data['err']            = $this->_err;
    $this->data['breadcrumbs']    = $this->_breadcrumbs();

    $this->data['languages']      = $this->model_localisation_language->getLanguages();

    $this->data['url_action']     = $this->url->link('module/vipsms_net', 'token=' . $this->session->data['token'], 'SSL');
    $this->data['url_cancel']     = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
    
    # Save a new form values from request
    foreach ($this->request->post as $key => $value) {
      $this->data['frm_' . $key] = $value;
    }

    if (isset($this->session->data['success'])){
      $this->data['success'] = $this->session->data['success'];
      unset($this->session->data['success']);
    }

    # Template rendering
    $this->children = array('common/header', 'common/footer');
    $this->template = 'module/vipsms_net.tpl';
    $this->response->setOutput($this->render());

  }

  private function _validate(){

    if (isset($this->request->post['setting_form'])){

      if (!$this->user->hasPermission('modify', 'module/vipsms_net')) {
        $this->_err = $this->language->get('vipsms_net_error_permission');
        return false;
      }

      if (empty($this->request->post['vipsms_net_login'])) {
        $this->_err = $this->language->get('vipsms_net_error_login_field');
        return false;
      }

      if (empty($this->request->post['vipsms_net_password'])) {
        $this->_err = $this->language->get('vipsms_net_error_password_field');
        return false;
      }

      if (empty($this->request->post['vipsms_net_sign'])){
        $this->_err = $this->language->get('vipsms_net_error_sign_field');
        return false;
      }else if (strlen($this->request->post['vipsms_net_sign'])>11){
        $this->_err = $this->language->get('vipsms_net_error_sign_to_large');
        return false;
      }

      if (empty($this->request->post['vipsms_net_admphone'])) {
        $this->_err = $this->language->get('vipsms_net_error_admphone_field');
        return false;
      }
      
      $phtools = new PhoneTools();
      $phtools->identNum($this->request->post['vipsms_net_admphone']);
      if ($phtools->getErrorMessage()){
        $this->_err = $this->language->get("vipsms_net_text_admphone").': '.$phtools->getErrorMessage();
        return false;
      }

      if (strlen(trim($this->request->post['vipsms_net_admphone1']))){
        $phtools->identNum($this->request->post['vipsms_net_admphone1']);
        if ($phtools->getErrorMessage()){
          $this->_err = $this->_err = $this->language->get("vipsms_net_text_admphone").'(+): '.$phtools->getErrorMessage();
          return false;
        }
      }


      try{
        // Test connection
        $gateway = new VipSMSNetGateway(
          $this->request->post['vipsms_net_login'],
          $this->request->post['vipsms_net_password']
        );

        if (!$gateway->testConnection()){
          $this->_err = 'Connection test failed';
          $this->_err .= '<br/>SOAP errors:<br/>'.$gateway->getErrors('<br/>');
          return false;
        }
      }catch(Exception $ax){
        return false;
      }

    }else if (isset($this->request->post['sendsms_form'])){
      $this->data['tab_sel'] = 'tab_sendsms';
      if (empty($this->request->post['vipsms_net_frmsms_message'])) {
        $this->_err = $this->language->get('vipsms_net_error_empty_frmsms_message');
        return false;
      }
    }

    return true;
  }

}

# vi:ts=2:sw=2:ai:et:ft=php:enc=utf8
