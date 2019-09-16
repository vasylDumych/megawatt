<?php  
class ControllerModuleGoogleMaps extends Controller
{
	protected function index($setting)
	{
		static $module_map = 0;
		
		$this->document->addScript('https://maps.googleapis.com/maps/api/js?key=AIzaSyD1XOiQNodYikP3TCaYpmPDKTrqLpOUSxw&callback=initMap');

		//--Load Helper
		require_once(DIR_SYSTEM . 'helper/google_maps.php');

		//--Load and assign Info
		$this->data['gmaps_info']		= gmaps_make_doc();


		$maps =  array();
		if (isset($this->request->post['google_maps_module_map']))
		{
			$maps = $this->request->post['google_maps_module_map'];
		}
		elseif ($this->config->get('google_maps_module_map'))
		{
			$maps = $this->config->get('google_maps_module_map');
		}

		$this->data['gmaps'] = array();
		$fistmaplatlong = false;
		foreach ($maps as $map)
		{
			if (isset($setting['ids'])) {
				$split_mts = $setting['ids'];
			} else {
				$split_mts = explode(',', $setting['mts']);
			}

			foreach ($split_mts as $smts)
			{

				if ($smts == $map['mapalias'])
				{
					if ($fistmaplatlong == false)
					{
						$this->data['gmap_flatlong'] = $map['latlong'];
						$fistmaplatlong = true;
					}
					$tmpmaptext = $map['maptext'][$this->config->get('config_language_id')];

					//@vkronlein bugfix 20/11/2013
					$tmpmaptext = preg_replace('/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/', '', $tmpmaptext);

					$tmponeline = $map['onelinetext'][$this->config->get('config_language_id')];

					//@vkronlein bugfix 20/11/2013
					$tmponeline = preg_replace('/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/', '', $tmponeline);

					$this->data['gmaps'][] = array(
						'balloonwidth'	=> $this->width_height($map['balloonwidth'], '200px'),
						'onelinetext'	=> html_entity_decode($tmponeline, ENT_QUOTES, 'UTF-8'),
						'latlong'		=> $map['latlong'],
						'maptext'		=> html_entity_decode($tmpmaptext, ENT_QUOTES, 'UTF-8')
					);				
				}
			}
		}

		$this->data['gmap_showbox'] = $setting['showbox'];
		$this->data['gmap_maptype'] = $setting['maptype'];
		$this->data['gmap_boxtitle'] = $setting['boxtitle'][$this->config->get('config_language_id')];
		$this->data['gmap_width'] = $this->width_height($setting['width'], '100%');
		$this->data['gmap_height'] = $this->width_height($setting['height'], '350px');
		$this->data['gmap_zoom'] = $setting['zoom'];

		// Check language marker
		if ( file_exists(DIR_IMAGE . 'google_maps/marker_' . $this->language->get('code') . '.png') )
		{
			$this->data['gmap_marker'] = 'image/google_maps/marker_' . $this->language->get('code') . '.png';
			$this->data['gmap_marker_image_size'] = '129, 42';
			$this->data['gmap_marker_point'] = '18, 42';
		}
		else if ( file_exists(DIR_IMAGE . 'google_maps/marker_global.png') )
		{
			$this->data['gmap_marker'] = 'image/google_maps/marker_global.png';
			$this->data['gmap_marker_image_size'] = '129, 42';
			$this->data['gmap_marker_point'] = '18, 42';
		}
		else
		{
			// Default marker from google
			$this->data['gmap_marker'] = 'http://maps.google.com/intl/en_us/mapfiles/ms/micons/red.png';
			$this->data['gmap_marker_image_size'] = '32, 32';
			$this->data['gmap_marker_point'] = '15, 32';
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/google_maps.tpl'))
		{
			$this->template = $this->config->get('config_template') . '/template/module/google_maps.tpl';
		}
		else
		{
			$this->template = 'default/template/module/google_maps.tpl';
		}


		$this->data['module_map'] = $module_map++;
		
		$this->render();
	}

	private function width_height($value, $ret = 'auto')
	{
		if ( is_numeric($value) ) $ret = $value . 'px';
		else if ( strpos(strtolower($value), 'px') !== false ) {
			$tmp = explode('px', $value);
			if ( is_numeric($tmp[0])  ) $ret = $tmp[0] . 'px';
		}
		else if ( strpos($value, '%') !== false ) {
			$tmp = explode('%', $value);
			if ( is_numeric($tmp[0])  ) $ret = $tmp[0] . '%';
		}
		else if ( strtolower($value) == 'auto' or strlen(trim($value)) == 0 ) $ret = 'auto';

		return $ret;
	}

	private function gmaps_info()
	{
		$gmaps_info = array(
			'gmaps_info_name'		=> 'Google Maps Module for OpenCart',
			'gmaps_info_author'		=> 'AkisC comvos.net',
			'gmaps_info_version'	=> '1.2.0.oc1.5',
			'gmaps_info_copyright'	=> 'Copyright (c) 2012 - 2015',
			'gmaps_info_license'	=> 'Free'
		);

		return $gmaps_info;
	}

	private function gmaps_info_comments()
	{
		$gi = $this->gmaps_info(); $b = PHP_EOL;
		return "<!--$b$b {$gi['gmaps_info_name']}$b$b @author	{$gi['gmaps_info_author']}$b @copyright	{$gi['gmaps_info_copyright']}, {$gi['gmaps_info_author']}$b @version	{$gi['gmaps_info_version']}$b @license	{$gi['gmaps_info_license']}$b$b//-->$b";
	}
}
