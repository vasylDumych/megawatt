<?php
class ControllerModuleProductTab extends Controller {
	
	protected function index($setting) { 

		static $module = 0;

		$this->language->load('module/product_tab');
		
      	$this->data['heading_title'] = $this->language->get('heading_title');
		
		//Harnish Design
		$this->data['button_wishlist'] = $this->language->get('button_wishlist');		
		$this->data['button_compare'] = $this->language->get('button_compare');

      	$this->data['tab_latest'] = $this->language->get('tab_latest');
      	$this->data['tab_featured'] = $this->language->get('tab_featured');
      	$this->data['tab_bestseller'] = $this->language->get('tab_bestseller');
      	$this->data['tab_special'] = $this->language->get('tab_special');

        $this->data['text_stock'] = $this->language->get('text_stock');
        $this->data['text_instock'] = $this->language->get('text_instock');
        $this->data['text_notinstock'] = $this->language->get('text_notinstock');

		
		$this->data['button_cart'] = $this->language->get('button_cart');
		
		if(isset($setting['featured_products_status']) && $setting['featured_products_status'] == 1){
			$this->data['featured_products_status'] = 1;
		}else{
			$this->data['featured_products_status'] = '';
		}
			
		if(isset($setting['latest_products_status']) && $setting['latest_products_status'] == 1){
			$this->data['latest_products_status'] = 1;
		}else{
			$this->data['latest_products_status'] = '';
		}
			
		if(isset($setting['bestseller_products_status']) && $setting['bestseller_products_status'] == 1){
			$this->data['bestseller_products_status'] = 1;
		}else{
			$this->data['bestseller_products_status'] = '';
		}
			
		if(isset($setting['special_products_status']) && $setting['special_products_status'] == 1){
			$this->data['special_products_status'] = 1;
		}else{
			$this->data['special_products_status'] = '';
		}
			
		$this->load->model('catalog/product');
		
		$this->load->model('tool/image');

		//Latest Products
		
		$this->data['latest_products'] = array();
		
		$latest_results = $this->model_catalog_product->getLatestProducts($setting['limit']);

		foreach ($latest_results as $result) {
            $special_percentages = false;
            $special_without_format = false;
			if ($result['image']) {
				$image = $this->model_tool_image->resize($result['image'], $setting['image_width'], $setting['image_height']);
			} else {
				$image = false;
			}

            if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
                $price_without_format = $this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax'));
                $price = $this->currency->format($price_without_format);
            } else {
                $price = false;
            }

            if ((float)$result['special']) {
                $special_without_format = $this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax'));
                $special = $this->currency->format($special_without_format);
            } else {
                $special = false;
            }

            if ($special_without_format &&
                $special_without_format < $price_without_format) {
                $special_percentages = round((100 - ($special_without_format*100/$price_without_format))*-1, 2).'%';
            }
			
			if ($this->config->get('config_review_status')) {
				$rating = $result['rating'];
			} else {
				$rating = false;
			}
			
			$this->data['latest_products'][] = array(
				'product_id' => $result['product_id'],
				'thumb'   	 => $image,
				'name'    	 => $result['name'],
				'price'   	 => $price,
				'special' 	 => $special,
                'special_percentages' => $special_percentages,
				'rating'     => $rating,
				'reviews'    => sprintf($this->language->get('text_reviews'), (int)$result['reviews']),
				'href'    	 => $this->url->link('product/product', 'product_id=' . $result['product_id']),
				// for saving percentage
				'saving' => $result['price'] == 0 ? 100 : round((($result['price'] - $result['special'])/$result['price'])*100, 0),
				//
                'quantity'    => $result['quantity'],
                'stock'       => $this->getStock($result),
			);
		}

		//Specials product

		$this->data['special_products'] = array();

			$special_data = array(
			'sort'  => 'pd.name',
			'order' => 'ASC',
			'start' => 0,
			'limit' => $setting['limit']
		);


		
		$special_results = $this->model_catalog_product->getProductSpecials($special_data);

		foreach ($special_results as $result) {
            $special_percentages = false;
            $special_without_format = false;
			if ($result['image']) {
				$image = $this->model_tool_image->resize($result['image'], $setting['image_width'], $setting['image_height']);
			} else {
				$image = false;
			}

            if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
                $price_without_format = $this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax'));
                $price = $this->currency->format($price_without_format);
            } else {
                $price = false;
            }

            if ((float)$result['special']) {
                $special_without_format = $this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax'));
                $special = $this->currency->format($special_without_format);
            } else {
                $special = false;
            }

            if ($special_without_format &&
                $special_without_format < $price_without_format) {
                $special_percentages = round((100 - ($special_without_format*100/$price_without_format))*-1, 2).'%';
            }
			
			if ($this->config->get('config_review_status')) {
				$rating = $result['rating'];
			} else {
				$rating = false;
			}
			
			$this->data['special_products'][] = array(
				'product_id' => $result['product_id'],
				'thumb'   	 => $image,
				'name'    	 => $result['name'],
				'price'   	 => $price,
				'special' 	 => $special,
                'special_percentages' => $special_percentages,
				'rating'     => $rating,
				'reviews'    => sprintf($this->language->get('text_reviews'), (int)$result['reviews']),
				'href'    	 => $this->url->link('product/product', 'product_id=' . $result['product_id']),
				// for saving percentage
				'saving' => $result['price'] == 0 ? 100 : round((($result['price'] - $result['special'])/$result['price'])*100, 0),
				//
                'quantity'    => $result['quantity'],
                'stock'       => $this->getStock($result),

			);
		}

		//BestSeller
		$this->data['bestseller_products'] = array();

		$bestseller_results = $this->model_catalog_product->getBestSellerProducts($setting['limit']);
		
		foreach ($bestseller_results as $result) {
            $special_percentages = false;
            $special_without_format = false;
			if ($result['image']) {
				$image = $this->model_tool_image->resize($result['image'], $setting['image_width'], $setting['image_height']);
			} else {
				$image = false;
			}

            if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
                $price_without_format = $this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax'));
                $price = $this->currency->format($price_without_format);
            } else {
                $price = false;
            }

            if ((float)$result['special']) {
                $special_without_format = $this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax'));
                $special = $this->currency->format($special_without_format);
            } else {
                $special = false;
            }

            if ($special_without_format &&
                $special_without_format < $price_without_format) {
                $special_percentages = round((100 - ($special_without_format*100/$price_without_format))*-1, 2).'%';
            }
			
			if ($this->config->get('config_review_status')) {
				$rating = $result['rating'];
			} else {
				$rating = false;
			}

			$this->data['bestseller_products'][] = array(
				'product_id' => $result['product_id'],
				'thumb'   	 => $image,
				'name'    	 => $result['name'],
				'price'   	 => $price,
				'special' 	 => $special,
                'special_percentages' => $special_percentages,
				'rating'     => $rating,
				'reviews'    => sprintf($this->language->get('text_reviews'), (int)$result['reviews']),
				'href'    	 => $this->url->link('product/product', 'product_id=' . $result['product_id']),
				// for saving percentage
				'saving' => $result['price'] == 0 ? 100 : round((($result['price'] - $result['special'])/$result['price'])*100, 0),
				//
                'quantity'    => $result['quantity'],
                'stock'       => $this->getStock($result),
			);
		}


		//Featured
		$this->data['featured_products'] = array();

		$products = explode(',', $this->config->get('featured_product'));		

		if (empty($setting['limit'])) {
			$setting['limit'] = 5;
		}
		
		$products = array_slice($products, 0, (int)$setting['limit']);
		
		foreach ($products as $product_id) {
			$product_info = $this->model_catalog_product->getProduct($product_id);
			
			if ($product_info) {
                $special_percentages = false;
                $special_without_format = false;
				if ($product_info['image']) {
					$image = $this->model_tool_image->resize($product_info['image'], $setting['image_width'], $setting['image_height']);
				} else {
					$image = false;
				}

                if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
                    $price_without_format = $this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax'));
                    $price = $this->currency->format($price_without_format);
                } else {
                    $price = false;
                }

                if ((float)$result['special']) {
                    $special_without_format = $this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax'));
                    $special = $this->currency->format($special_without_format);
                } else {
                    $special = false;
                }

                if ($special_without_format &&
                    $special_without_format < $price_without_format) {
                    $special_percentages = round((100 - ($special_without_format*100/$price_without_format))*-1, 2).'%';
                }
				
				if ($this->config->get('config_review_status')) {
					$rating = $product_info['rating'];
				} else {
					$rating = false;
				}
					
				$this->data['featured_products'][] = array(
					'product_id' => $product_info['product_id'],
					'thumb'   	 => $image,
					'name'    	 => $product_info['name'],
					'price'   	 => $price,
					'special' 	 => $special,
                    'special_percentages' => $special_percentages,
					'rating'     => $rating,
					'reviews'    => sprintf($this->language->get('text_reviews'), (int)$product_info['reviews']),
					'href'    	 => $this->url->link('product/product', 'product_id=' . $product_info['product_id']),
                    // for saving percentage
                    'saving' => $product_info['price'] == 0 ? 100 : round((($product_info['price'] - $product_info['special'])/$product_info['price'])*100, 0),
                    //
                    'quantity'    => $result['quantity'],
                    'stock'       => $this->getStock($result),
				);
			}
		}

		$this->data['module'] = $module++;

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/product_tab.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/product_tab.tpl';
		} else {
			$this->template = 'default/template/module/product_tab.tpl';
		}

		$this->render();
	}

    protected function getStock($product) {
        $stock = $this->language->get('text_instock');
        if ($product['quantity'] <= 0) {
            $stock = $product['stock_status'];
        } elseif ($this->config->get('config_stock_display')) {
            $stock = $product['quantity'];
        } else {
            $stock = $this->language->get('text_instock');
        }

        return $stock;
    }
}
?>