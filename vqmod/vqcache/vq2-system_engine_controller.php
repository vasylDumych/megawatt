<?php
abstract class Controller {
	protected $registry;
	protected $id;
	protected $layout;
	protected $template;
	protected $children = array();
	protected $data = array();
	protected $output;


        
          ## VipSMS.net [BEGIN]
          protected function vipsms_net_init(){

            # Load language
            $this->load->language('module/vipsms_net');

            $this->registry->set('vipsms_net_logger', new Log('vipsms_net.log'));

            if ($this->config->get('vipsms_net_login') &&
              $this->config->get('vipsms_net_password') &&
              file_exists(DIR_SYSTEM . 'library/vipsms_net_gateway.php')){

              # Load VipSMS.net library
              require_once(\VQMod::modCheck(DIR_SYSTEM . 'library/vipsms_net_gateway.php'));

              $gateway = new VipSMSNetGateway(
                $this->config->get('vipsms_net_login'),
                $this->config->get('vipsms_net_password')
              );

              # Create registry object
              if (!$gateway->getErrors()){

                # Set sign
                $vipsms_net_sign = $this->config->get('vipsms_net_sign');
                $gateway->setSign($vipsms_net_sign);

                # Add to global registry
                $this->registry->set('vipsms_net_gateway', $gateway);
                return true;

              }else{

                # Notify administrator
                if ($this->config->has('vipsms_net_events_admin_gateway_connection_error')) {
                  $mail = new Mail();

                  $mail->protocol  = $this->config->get('config_mail_protocol');
                  $mail->parameter = $this->config->get('config_mail_parameter');
                  $mail->hostname  = $this->config->get('config_smtp_host');
                  $mail->username  = $this->config->get('config_smtp_username');
                  $mail->password  = $this->config->get('config_smtp_password');
                  $mail->port      = $this->config->get('config_smtp_port');
                  $mail->timeout   = $this->config->get('config_smtp_timeout');

                  $mail->setTo($this->config->get('config_email'));
                  $mail->setFrom($this->config->get('config_email'));
                  $mail->setSender($this->config->get('config_name'));
                  $mail->setSubject('VipSMS.net connection error');
                  $mail->setText(sprintf($this->language->get('vipsms_net_message_connection_error'),
                    date('d.m.Y H:i:s'),
                    $gateway->getErrors())
                  );
                  $mail->send();
                }

                return false;
              }
            }
          }
          ## VipSMS.net [END]
        
      
	public function __construct($registry) {
		$this->registry = $registry;
				
				if( ! empty( $this->request->get['mfp'] ) ) {
					preg_match( '/path\[([^]]*)\]/', $this->request->get['mfp'], $mf_matches );

					if( ! empty( $mf_matches[1] ) ) {
						$this->request->get['path'] = $mf_matches[1];

						if( isset( $this->request->get['category_id'] ) || ( isset( $this->request->get['route'] ) && in_array( $this->request->get['route'], array( 'product/search', 'product/special', 'product/manufacturer/info' ) ) ) ) {
							$mf_matches = explode( '_', $mf_matches[1] );
							$this->request->get['category_id'] = end( $mf_matches );
						}
					}
				
					unset( $mf_matches );
				}
			
	}

	public function __get($key) {
		return $this->registry->get($key);
	}

	public function __set($key, $value) {
		$this->registry->set($key, $value);
	}

	protected function forward($route, $args = array()) {
		return new Action($route, $args);
	}

	protected function redirect($url, $status = 302) {
		header('Status: ' . $status);
		header('Location: ' . str_replace(array('&amp;', "\n", "\r"), array('&', '', ''), $url));
		if (!defined('APS_UPGRADE')) exit();
	}


                private function _getCachedChild($id, $driver, $timeout) {

                    $module_caching_pro_drivers = $this->_prepareCacheDriver($driver);

                    switch ($driver) {

                        case 'disk':

                            $cache_path = DIR_CACHE . 'module_caching_pro' . DIRECTORY_SEPARATOR . $id;

                            if (file_exists($cache_path) && is_readable($cache_path)) {

                                $filectime = (int) filectime($cache_path);
                                $time      = (int) time();

                                if ($timeout < $time - $filectime) {

                                    if (!unlink($cache_path)) {
                                        trigger_error('Error: Could not remove Cache file!');
                                    }

                                    return false;
                                } else {

                                    return file_get_contents($cache_path);
                                }
                            }

                            return false;

                            break;

                        case 'memcache':

                            if (class_exists('Memcache')) {
                                $memcache = new Memcache();
                                if (
                                $memcache->connect(
                                    $module_caching_pro_drivers[$driver]['host'],
                                    $module_caching_pro_drivers[$driver]['port']
                                )
                                ) {
                                    return $memcache->get($module_caching_pro_drivers[$driver]['namespace'] . $id);
                                } else {

                                    trigger_error('Error: Could not connect to Memcache server!');

                                    return false;
                                }
                            }

                            trigger_error('Error: Memcache Class does not exist!');

                            return false;

                            break;

                        case 'memcached':

                            if (class_exists('Memcached')) {
                                $memcached = new Memcached();
                                if (
                                $memcached->addServer(
                                    $module_caching_pro_drivers[$driver]['host'],
                                    $module_caching_pro_drivers[$driver]['port']
                                )
                                ) {
                                    return $memcached->get($module_caching_pro_drivers[$driver]['namespace'] . $id);
                                } else {

                                    trigger_error('Error: Could not connect to Memcached server!');

                                    return false;
                                }
                            }

                            trigger_error('Error: Memcached Class does not exist!');

                            return false;

                            break;

                        default:

                            trigger_error('Error: Unknown cache driver!');

                            return false;
                    }
                }

                private function _setCachedChild($id, $data, $driver, $timeout) {

                    $module_caching_pro_drivers = $this->_prepareCacheDriver($driver);

                    switch ($driver) {

                        case 'disk':

                            $cache_directory = DIR_CACHE . 'module_caching_pro' . DIRECTORY_SEPARATOR;
                            $cache_path = DIR_CACHE . 'module_caching_pro' . DIRECTORY_SEPARATOR . $id;

                            if (!file_exists($cache_directory)) {
                                if (!mkdir($cache_directory)) {
                                    trigger_error('Error: Cache directory is not writable!');
                                }
                            }

                            $handle = fopen($cache_path, 'w');

                            fwrite($handle, $data);
                            fclose($handle);

                            break;

                        case 'memcache':

                            if (class_exists('Memcache')) {
                                $memcache = new Memcache();
                                if (
                                $memcache->connect(
                                    $module_caching_pro_drivers[$driver]['host'],
                                    $module_caching_pro_drivers[$driver]['port']
                                )
                                ) {
                                    $memcache->set($module_caching_pro_drivers[$driver]['namespace'] . $id, $data, false, $timeout);
                                }
                            } else {
                                trigger_error('Error: Memcache Class does not exist!');
                            }
                            break;

                        case 'memcached':

                            if (class_exists('Memcached')) {
                                $memcached = new Memcached();
                                if (
                                $memcached->addServer(
                                    $module_caching_pro_drivers[$driver]['host'],
                                    $module_caching_pro_drivers[$driver]['port']
                                )
                                ) {
                                    $memcached->get($module_caching_pro_drivers[$driver]['namespace'] . $id, $data, $timeout);
                                }
                            } else {
                                trigger_error('Error: Memcached Class does not exist!');
                            }
                            break;

                        default:
                            trigger_error('Error: Unknown cache driver!');
                    }
                }

                private function _prepareCacheDriver($driver) {

                    $module_caching_pro_drivers = $this->config->get('module_caching_pro_drivers');

                    if (!isset($module_caching_pro_drivers[$driver]['host'])) {

                        $module_caching_pro_drivers[$driver]['host'] = '';

                        trigger_error(sprintf('Error: %s host is required!', $driver));
                    }

                    if ($driver != 'disk' && !isset($module_caching_pro_drivers[$driver]['port'])) {

                        $module_caching_pro_drivers[$driver]['port'] = '';

                        trigger_error(sprintf('Error: %s port is required!', $driver));
                    }

                    if ($driver != 'disk' && !isset($module_caching_pro_drivers[$driver]['namespace'])) {

                        $module_caching_pro_drivers[$driver]['namespace'] = '';

                        trigger_error(sprintf('Error: %s namespace is required!', $driver));
                    }

                    return $module_caching_pro_drivers;
                }

            
	protected function getChild($child, $args = array()) {

                $cache = [];

                $module_caching_pro_modules = $this->config->get('module_caching_pro_modules');

                if ($module_caching_pro_modules) {

                    foreach ($module_caching_pro_modules as $module_caching_pro_module) {

                        if ($child == $module_caching_pro_module['route'] && $module_caching_pro_module['status']) {

                            $cache = array(
                                'id'      => md5($child . serialize(array_merge( $args,
                                        (isset($module_caching_pro_module['get']) ? $_GET : []),
                                        (isset($module_caching_pro_module['post']) ? $_POST : []),
                                        (isset($module_caching_pro_module['files']) ? $_FILES : []),
                                        (isset($module_caching_pro_module['cookie']) ? $_COOKIE : []),
                                        (isset($module_caching_pro_module['session']) ? $_SESSION : [])))
                                ),
                                'driver'  => $module_caching_pro_module['driver'],
                                'timeout' => $module_caching_pro_module['timeout'],
                            );

                            break;
                        }
                    }
                }

                if ($cache && $data = $this->_getCachedChild($cache['id'], $cache['driver'], $cache['timeout'])) {

                    return $data;

                }
            
		$action = new Action($child, $args);

		if (file_exists($action->getFile())) {
			require_once(\VQMod::modCheck($action->getFile()));

			$class = $action->getClass();

			$controller = new $class($this->registry);

			$controller->{$action->getMethod()}($action->getArgs());

                if ($cache) {
                    $this->_setCachedChild($cache['id'], $controller->output, $cache['driver'], $cache['timeout']);
                }
            

			return $controller->output;
		} else {
			trigger_error('Error: Could not load controller ' . $child . '!');
			exit();
		}
	}

	protected function hasAction($child, $args = array()) {
		$action = new Action($child, $args);

		if (file_exists($action->getFile())) {
			require_once(\VQMod::modCheck($action->getFile()));

			$class = $action->getClass();

			$controller = new $class($this->registry);

			if(method_exists($controller, $action->getMethod())){
				return true;
			}else{
				return false;
			}
		} else {
			return false;
		}
	}

	protected function render() {
		foreach ($this->children as $child) {
			
				if( ! isset( $this->data['mfp_'.basename($child)] ) ) {
					$this->data[basename($child)] = $this->getChild($child);
				}
			
		}

		if (file_exists(DIR_TEMPLATE . $this->template)) {
			extract($this->data);

			ob_start();

			require(\VQMod::modCheck(DIR_TEMPLATE . $this->template));

			$this->output = ob_get_contents();

			ob_end_clean();

			return $this->output;
		} else {
			trigger_error('Error: Could not load template ' . DIR_TEMPLATE . $this->template . '!');
			exit();
		}
	}
}
?>
