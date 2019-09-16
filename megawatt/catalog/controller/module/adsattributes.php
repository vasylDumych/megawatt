<?php
class ControllerModuleAdsattributes extends Controller {
	protected function index($module) {
            
 	$this->data['scripts'] = $this->document->addScript("catalog/view/javascript/jquery/autocomplete/jquery.autocomplete.js");          
        $this->data['styles'] = $this->document->addStyle("catalog/view/javascript/jquery/autocomplete/jquery.autocomplete.css");
                        
            
		$this->language->load('module/adsattributes');

		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = '';
		}

		if (isset($this->request->get['filter_tag'])) {
			$filter_tag = $this->request->get['filter_tag'];
		} else {
			$filter_tag = '';
		}

		if (isset($this->request->get['filter_category_id'])) {
			$filter_category_id = $this->request->get['filter_category_id'];
		} else {
			$filter_category_id = 0;
		}

		if (isset($this->request->get['filter_sub_category'])) {
			$filter_sub_category = $this->request->get['filter_sub_category'];
		} else {
			$filter_sub_category = '';
		}

		if (isset($this->request->get['filter_manufacturer_id'])) {
			$filter_manufacturer_id = $this->request->get['filter_manufacturer_id'];
		} else {
			$filter_manufacturer_id = '';
		}

		if (isset($this->request->get['filter_pricemin'])) {
			$filter_pricemin = $this->request->get['filter_pricemin'];
		} else {
			$filter_pricemin = '';
		}

		if (isset($this->request->get['filter_pricemax'])) {
			$filter_pricemax = $this->request->get['filter_pricemax'];
		} else {
			$filter_pricemax = '';
		}

		if (isset($this->request->get['filter_description'])) {
			$filter_description = $this->request->get['filter_description'];
		} else {
			$filter_description = '';
		}

		if (isset($this->request->get['filter_groups'])) {
			$filter_groups = $this->request->get['filter_groups'];
		} else {
			$filter_groups = '';
		}

		if (isset($this->request->get['filter_attribute'])) {
			$filter_attribute = $this->request->get['filter_attribute'];
		} else {
			$filter_attribute = '';
		}
                
            $filter_name = '';
            $filter_tag = '';
            $filter_category_id = 0;
            $filter_sub_category = '';
            $filter_manufacturer_id = '';
            $filter_pricemin = '';
            $filter_pricemax = '';
            $filter_description = '';
            $filter_groups = '';
            $filter_attribute = '';
            
            $this->data['heading_title'] = $this->language->get('heading_title');

            $this->data['text_critea'] = $this->language->get('text_critea');
            $this->data['text_search'] = $this->language->get('text_search');
            $this->data['text_keyword'] = $this->language->get('text_keyword');
            $this->data['text_category'] = $this->language->get('text_category');
            $this->data['text_empty'] = $this->language->get('text_empty');
            $this->data['text_sort'] = $this->language->get('text_sort');
            $this->data['text_price'] = $this->language->get('text_price');
            $this->data['text_pricemin'] = $this->language->get('text_pricemin');
            $this->data['text_pricemax'] = $this->language->get('text_pricemax');
            $this->data['text_manufacturer'] = $this->language->get('text_manufacturer');
            $this->data['text_sub_category'] = $this->language->get('text_sub_category');
            $this->data['text_groups_attribute'] = $this->language->get('text_groups_attribute');
            $this->data['text_attribute'] = $this->language->get('text_attribute');

            $this->data['entry_search'] = $this->language->get('entry_search');
            $this->data['entry_description'] = $this->language->get('entry_description');
            $this->data['entry_model'] = $this->language->get('entry_model');
            $this->data['entry_category'] = $this->language->get('entry_category');
            $this->data['entry_manufacture'] = $this->language->get('entry_manufacture');
            $this->data['entry_groups_attribute'] = $this->language->get('entry_groups_attribute');
            $this->data['entry_attribute'] = $this->language->get('entry_attribute');
            $this->data['entry_attribute_value'] = $this->language->get('entry_attribute_value');

            $this->data['button_search'] = $this->language->get('button_search');


            $this->load->model('catalog/adsattributes');

		$this->data['categories'] = array();
		$this->data['categories'] = $this->getCategoriesSelect(0);
           
                
            $this->data['manufacturers'] = array();
            $results = $this->model_catalog_adsattributes->getManufacturers();

            foreach ($results as $result) {
                    $this->data['manufacturers'][] = array(
                            'manufacturer_id' => $result['manufacturer_id'],
                            'name'            => $result['name'],
                            'countproduct'        => $result['countproduct']
                    );
            }

             $this->data['groupsattribute'] = array();
            $results = $this->model_catalog_adsattributes->getGroupsAttribute();
       
            foreach ($results as $result) {
                    $this->data['groupsattribute'][] = array(
                            'attribute_group_id' => $result['attribute_group_id'],
                            'countproduct'            => $result['countproduct'],
                            'name'        => $result['name']
                    );
            }

             $this->data['attributes'] = array();
            $results = $this->model_catalog_adsattributes->getAttributes();
       
            foreach ($results as $result) {
                    $this->data['attributes'][] = array(
                            'attribute_id' => $result['attribute_id'],
                            'countproduct'            => $result['countproduct'],
                            'name'        => $result['name']
                    );
            }
 
		$this->data['filter_name'] = $filter_name;
		$this->data['filter_category_id'] = $filter_category_id;
		$this->data['filter_sub_category'] = $filter_sub_category;
		$this->data['filter_manufacturer_id'] = $filter_manufacturer_id;
		$this->data['filter_pricemin'] = $filter_pricemin;
		$this->data['filter_pricemax'] = $filter_pricemax;
		$this->data['filter_description'] = $filter_description;
		$this->data['filter_groups'] = $filter_groups;
		$this->data['filter_attribute'] = $filter_attribute;



		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/adsattributes.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/adsattributes.tpl';
		} else {
			$this->template = 'default/template/module/adsattributes.tpl';
		}

		$this->render();
	}

         
 	private function getCategoriesSelect($parent_id, $level = 0) {
		$level++;               
		$data = array();
		$results = $this->model_catalog_adsattributes->getCategories($parent_id);
           
		foreach ($results as $result) {
                        $product = array(
				'filter_category_id'  => $result['category_id'],
				'filter_sub_category' => FALSE	
			);		
			$product_total = $this->model_catalog_adsattributes->getTotalProducts($product);
			$data[] = array(
				'category_id' => $result['category_id'],
				'name'        => str_repeat('&nbsp;&nbsp;', $level) . $result['name'] . ' ('.$product_total.')'
			);
			$children = $this->getCategoriesSelect($result['category_id'], $level);
			if ($children) {
			  $data = array_merge($data, $children);
			}
		}
		return $data;
	}   
    
    public function categories() {
        $this->language->load('module/adsattributes');
        $this->load->model('catalog/adsattributes');
	
		$this->data['categories'] = array();
		$categories = $this->getCategories(0);

        $output = '';
        $output .= '<option value="">' . $this->language->get('text_category') . '</option>';
        foreach ($categories as $category) { 
            $output .= '<option value="'.$category['category_id'].'">'. $category['name'].'</option>';
           }      
        
        $this->response->setOutput($output, $this->config->get('config_compression'));
    }

                
        
         
    public function manufacturer() {
        $this->language->load('module/adsattributes');
        $this->load->model('catalog/adsattributes');
      
         if(isset($_GET["filter_category_id"])) {
             $filter_category_id = $_GET["filter_category_id"];
         } else {
             $filter_category_id = 0;
         }
      
         if(isset($_GET["filter_sub_category"])) {
             $filter_sub_category = $_GET["filter_sub_category"];
         } else {
             $filter_sub_category = 0;
         }         
            
            $this->data['manufacturers'] = array();
            $results = $this->model_catalog_adsattributes->getManufacturers($filter_category_id, $filter_sub_category);
            
        $output = '';
        $output .= '<option value="">' . $this->language->get('text_manufacturer') . '</option>';

        foreach ($results as $result) {
            if (isset($this->request->get['filter_optionvalue']) AND $this->request->get['filter_optionvalue'] == $result['option_value_id']) {
                $output .= '<option selected value="' . $result['manufacturer_id'] . '">' . $result['name'] . ' (' . $result['countproduct'] . ')</option>';
            } else {
                $output .= '<option value="' . $result['manufacturer_id'] . '">' . $result['name'] . ' (' . $result['countproduct'] . ')</option>';
            }
        }
        $this->response->setOutput($output, $this->config->get('config_compression'));
    }       
         
     	public function groups() {
            $this->language->load('module/adsattributes');
            $this->load->model('catalog/adsattributes');
 
                 if(isset($_GET["filter_category_id"])) {
                     $filter_category_id = $_GET["filter_category_id"];
                 } else {
                     $filter_category_id = 0;
                 }

                 if(isset($_GET["filter_sub_category"])) {
                     $filter_sub_category = $_GET["filter_sub_category"];
                 } else {
                     $filter_sub_category = 0;
                 }                     

                 if(isset($_GET["filter_manufacturer_id"])) {
                     $filter_manufacturer_id = $_GET["filter_manufacturer_id"];
                 } else {
                     $filter_manufacturer_id = '';
                 }                     
                                
                $this->data['groupsattribute'] = array();
                $results = $this->model_catalog_adsattributes->getGroupsAttribute($filter_category_id, $filter_sub_category, $filter_manufacturer_id);
       
                $output = '<option value="">' . $this->language->get('text_groups_attribute')  . '</option>';

            	foreach ($results as $result) {
                           $output .= '<option value="' . $result['attribute_group_id'] . '">' . $result['name'] . ' (' . $result['countproduct'] .')</option>';
                }

		$this->response->setOutput($output, $this->config->get('config_compression'));
  	}

               
     	public function attributes() {
            $this->language->load('module/adsattributes');
		$this->load->model('catalog/adsattributes');
 
                 if(isset($_GET["filter_category_id"])) {
                     $filter_category_id = $_GET["filter_category_id"];
                 } else {
                     $filter_category_id = 0;
                 }

                 if(isset($_GET["filter_sub_category"])) {
                     $filter_sub_category = $_GET["filter_sub_category"];
                 } else {
                     $filter_sub_category = 0;
                 }                     

                 if(isset($_GET["filter_manufacturer_id"])) {
                     $filter_manufacturer_id = $_GET["filter_manufacturer_id"];
                 } else {
                     $filter_manufacturer_id = '';
                 }                     
                       
                 if(isset($_GET["filter_groups"])) {
                     $filter_groups = $_GET["filter_groups"];
                 } else {
                     $filter_groups = '';
                 }                     
                     
            $results = array();
            $results= $this->model_catalog_adsattributes->getAttributes($filter_category_id, $filter_sub_category, $filter_manufacturer_id, $filter_groups);

                $output = '<option value="">' . $this->language->get('text_attribute')  . '</option>';
            	foreach ($results as $result) {
                           $output .= '<option value="' . $result['attribute_id'] . '">' . $result['name'] . ' (' . $result['countproduct'] .')</option>';
                }

		$this->response->setOutput($output, $this->config->get('config_compression'));
  	}

        
        
    public function autocomplete() {
        $this->language->load('module/adsattributes');
        $this->load->model('catalog/adsattributes');
        $results = array();
        
            $results = $this->model_catalog_adsattributes->getAutocomplete($_GET['q']);

      header("Content-Type: text/html; charset=UTF-8");

        foreach ($results as $value) {       
               $txt=json_encode($value['name']);
                echo json_decode($txt)."\n"; 
        }
 
    }

}
?>
