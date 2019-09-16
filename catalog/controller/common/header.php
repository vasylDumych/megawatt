<?php

class ControllerCommonHeader extends Controller {
	protected function index() {
		$this->data['title'] = $this->document->getTitle();

		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$server = $this->config->get('config_ssl');
		} else {
			$server = $this->config->get('config_url');
		}

		if (isset($this->session->data['error']) && !empty($this->session->data['error'])) {
			$this->data['error'] = $this->session->data['error'];
			unset($this->session->data['error']);
		} else {
			$this->data['error'] = '';
		}

		$this->data['base'] = $server;
		$this->data['description'] = $this->document->getDescription();
		$this->data['keywords'] = $this->document->getKeywords();
		$this->data['links'] = $this->document->getLinks();
		$this->data['styles'] = $this->document->getStyles();
		$this->data['scripts'] = $this->document->getScripts();
		$this->data['lang'] = $this->language->get('code');
		$this->data['direction'] = $this->language->get('direction');
		$this->data['google_analytics'] = html_entity_decode($this->config->get('config_google_analytics'), ENT_QUOTES, 'UTF-8');
		$this->data['name'] = $this->config->get('config_name');

		if ($this->config->get('config_icon') && file_exists(DIR_IMAGE . $this->config->get('config_icon'))) {
			$this->data['icon'] = $server . 'image/' . $this->config->get('config_icon');
		} else {
			$this->data['icon'] = '';
		}

		if ($this->config->get('config_logo') && file_exists(DIR_IMAGE . $this->config->get('config_logo'))) {
			$this->data['logo'] = $server . 'image/' . $this->config->get('config_logo');
		} else {
			$this->data['logo'] = '';
		}

		$this->language->load('common/header');

		$this->data['text_home'] = $this->language->get('text_home');
		$this->data['text_wishlist'] = sprintf($this->language->get('text_wishlist'), (isset($this->session->data['wishlist']) ? count($this->session->data['wishlist']) : 0));
		$this->data['text_shopping_cart'] = $this->language->get('text_shopping_cart');
		$this->data['text_search'] = $this->language->get('text_search');
		$this->data['text_welcome'] = sprintf($this->language->get('text_welcome'), $this->url->link('account/login', '', 'SSL'), $this->url->link('account/register', '', 'SSL'));
		$this->data['text_logged'] = sprintf($this->language->get('text_logged'), $this->url->link('account/account', '', 'SSL'), $this->customer->getFirstName(), $this->url->link('account/logout', '', 'SSL'));
		$this->data['text_account'] = $this->language->get('text_account');
		$this->data['text_checkout'] = $this->language->get('text_checkout');

		$this->data['home'] = $this->url->link('common/home');
        $this->data['compare'] = $this->url->link('product/compare', '', 'SSL');
		$this->data['wishlist'] = $this->url->link('account/wishlist', '', 'SSL');
		$this->data['logged'] = $this->customer->isLogged();
		$this->data['account'] = $this->url->link('account/account', '', 'SSL');
		$this->data['shopping_cart'] = $this->url->link('checkout/cart');
		$this->data['checkout'] = $this->url->link('checkout/checkout', '', 'SSL');

		// Daniel's robot detector
		$status = true;

		if (isset($this->request->server['HTTP_USER_AGENT'])) {
			$robots = explode("\n", trim($this->config->get('config_robots')));

			foreach ($robots as $robot) {
				if ($robot && strpos($this->request->server['HTTP_USER_AGENT'], trim($robot)) !== false) {
					$status = false;
					break;
				}
			}
		}



		// A dirty hack to try to set a cookie for the multi-store feature
		$this->load->model('setting/store');

		$this->data['stores'] = array();

		if ($this->config->get('config_shared') && $status) {
			$this->data['stores'][] = $server . 'catalog/view/javascript/crossdomain.php?session_id=' . $this->session->getId();

			$stores = $this->model_setting_store->getStores();

			foreach ($stores as $store) {
				$this->data['stores'][] = $store['url'] . 'catalog/view/javascript/crossdomain.php?session_id=' . $this->session->getId();
			}
		}

		// Search
		if (isset($this->request->get['search'])) {
			$this->data['search'] = $this->request->get['search'];
		} else {
			$this->data['search'] = '';
		}

		// Menu
		$this->load->model('catalog/category');
		$this->load->model('catalog/product');
		$this->data['categories'] = array();

		$categories = $this->model_catalog_category->getCategories(0);

		foreach ($categories as $category) {
			if ($category['top']) {
				// Level 2
				$children_data = array();

				$children = $this->model_catalog_category->getCategories($category['category_id']);

				foreach ($children as $child) {
					$data = array(
						'filter_category_id'  => $child['category_id'],
						'filter_sub_category' => true
					);

					$product_total = $this->model_catalog_product->getTotalProducts($data);

					$children_data[] = array(
						'name'  => $child['name'] . ($this->config->get('config_product_count') ? ' (' . $product_total . ')' : ''),
						'href'  => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'])
					);

				}

				// Level 1
				$this->data['categories'][] = array(
					'name'     => $category['name'],
					'children' => $children_data,
					'column'   => $category['column'] ? $category['column'] : 1,
					'href'     => $this->url->link('product/category', 'path=' . $category['category_id'])
				);
			}
		}

		$this->children = array(
			'module/language',
			'module/currency',
			'module/cart',
			'common/header_baner',
			'common/footer_new',
			'common/carousel_about',
			'module/supermenu',
			'module/supermenu_settings',
			'module/pavmegamenu'
		);

        /**
         * Электронная торглвля
         */

        if ($this->request->get['route'] == 'checkout/success') {
            if (isset($this->session->data['last_order_id'])) {
                $data['checkout_success']  = true;
                $order_id = $this->session->data['last_order_id'];
                $this->load->model('account/order');
                $order_info = $this->model_account_order->getOrder($order_id);
                if ($order_info) {
                    $tax = 0;
                    $shipping = 0;
                    $order_totals = $this->model_account_order->getOrderTotals($order_id);
                    foreach ($order_totals as $order_total) {
                        if ($order_total['code'] == 'tax') {
                            $tax += $order_total['value'];
                        } elseif ($order_total['code'] == 'shipping') {
                            $shipping += $order_total['value'];
                        }
                    }
                    //запрос данных о заказе
                    $data['order'] = $order_info;
                    $data['order']['store_name'] = $this->config->get('config_name');
                    $data['order']['order_total'] = $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], false);
                    $data['order']['order_tax'] = $this->currency->format($tax, $order_info['currency_code'], $order_info['currency_value'], false);
                    $data['order']['order_shipping'] = $this->currency->format($shipping, $order_info['currency_code'], $order_info['currency_value'], false);
                    // запрос данных о товарах в заказе
                    $products = $this->model_account_order->getOrderProducts($order_id);
                    $this->load->model('catalog/product');
                    $this->load->model('catalog/category');
                    foreach ($products as $product) {
                        $sku = '';
                        $product_info = $this->model_catalog_product->getProduct($product['product_id']);
                        if ($product_info) {
                            $sku = $product_info['sku'];
                        }
                        $categories = array();
                        $product_categories = $this->model_catalog_product->getCategories($product['product_id']);
                        if ($product_categories) {
                            foreach ($product_categories as $product_category) {
                                $category_data = $this->model_catalog_category->getCategory($product_category['category_id']);

                                if ($category_data) {
                                    $categories[] = $category_data['name'];
                                }
                            }
                        }
                        $data['products'][] = array(
                            'order_id' => $order_id,
                            'product_id' => $product['product_id'],
                            'sku' => $sku,
                            'name' => $product['name'],
                            'category' => implode(',', $categories),
                            'quantity' => $product['quantity'],
                            'price' => $this->currency->format($product['price'] + ($this->config->get('config_tax') ? $product['tax'] : 0), $order_info['currency_code'], $order_info['currency_value'], false)
                        );
                    }
                }
            } else $data['checkout_success']  = false;
        } else $data['checkout_success']  = false;
        $this->data = array_merge($this->data, $data);

        /* -------------------- END Электронная торговля ------------------------------- */


		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/header.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/common/header.tpl';
		} else {
			$this->template = 'default/template/common/header.tpl';
		}

		$this->render();
	}
}

?>

