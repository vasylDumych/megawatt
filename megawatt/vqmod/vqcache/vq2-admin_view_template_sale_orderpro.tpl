<?php echo $header; ?>
<div id="content">
	<div class="breadcrumb">
	<?php foreach ($breadcrumbs as $breadcrumb) { ?>
		<?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
	<?php } ?>
	</div>
	<?php if ($error_warning) { ?><div class="warning"><?php echo $error_warning; ?></div><?php } ?>
	<?php if ($status_del_warning) { ?><div class="warning"><?php echo $error_del_product; ?></div><?php } ?>
	<?php if ($status_off_warning) { ?><div class="attention"><?php echo $error_off_product; ?></div><?php } ?>
	<div class="box">
	<div class="heading">
		<h1><img src="view/image/order.png" alt="" /><?php echo $order_number; ?></h1>
		<div class="buttons">
			<?php if ($order_id) { ?>
				<a onclick="window.open('<?php echo $invoice; ?>&order_id=<?php echo $order_id; ?>');" class="btn btn-primary"><span><?php echo $button_invoce; ?></span></a>
				<a onclick="clone_order();" class="btn btn-primary"><span><?php echo $button_clone; ?></span></a>
				<span style="display:inline-block;margin:0 20px;">|</span>
			<?php } ?>
			
			

			<a onclick="apply();" class="btn btn-success"><span>Применить</span></a>
			<script language="javascript">
				function apply(){
				$('#form').append('<input type="hidden" id="apply" name="apply" value="1"  />');
				$('#form').submit();
				}
			</script>
			
			<a onclick="$('#form').submit();" class="btn btn-success"><span><?php echo $button_save; ?></span></a>
			
			<a onclick="javascript:location.href='<?php echo $cancel; ?>&cancel=<?php echo $temp_order_id; ?>';" class="btn btn-danger"><span><?php echo $button_cancel; ?></span></a>
		</div>
	</div>
	<div class="content">
		<div class="htabs">
			<a href="#tab-order"><?php echo $tab_order; ?></a>
			<a href="#tab-history"><?php echo $tab_order_history; ?></a>
			<a href="#tab-total"><?php echo $tab_total; ?></a>
			<a href="#tab-setting" style="float:right;"><?php echo $tab_setting; ?></a>
		</div>
		<div id="notifications"></div>
		<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form" class="order-form-all">
			<div id="tab-order" class="htabs-content">
			<table class="form">
				<tr>
					<td style="padding:0;">
						<div class="tuhalf leftorder" style="width:100%">
							<div class="width13">
								<div class="paramdata">
								<?php if ($customer_id) { ?>
									<a style="float:left;" class="btn btn-default"><span><?php echo $text_account_exist; ?></span></a>
								<?php } else { ?>
									<a id="button-registered" class="btn btn-primary"><span><?php echo $button_create_account; ?></span></a>
									<img src="view/image/blue-help20.png" class="cluetip-img" alt="" title="<?php echo $help_registered_head; ?>" rel="#help_registered" />
								<?php } ?>
								</div>
							</div>
							<div class="width13">
								<div class="paramname" style="padding-left:10px;"><?php echo $text_store; ?></div>
								<div class="paramdata"><select name="store_id">
									  <option value="0"><?php echo $text_default; ?></option>
									  <?php foreach ($stores as $store) { ?>
									  <?php if ($store['store_id'] == $store_id) { ?>
									  <option value="<?php echo $store['store_id']; ?>" selected="selected"><?php echo $store['name']; ?></option>
									  <?php } else { ?>
									  <option value="<?php echo $store['store_id']; ?>"><?php echo $store['name']; ?></option>
									  <?php } ?>
									  <?php } ?>
									</select>
								</div>
							</div>
							<div class="width13">
								<?php if ($currencies) { ?>
								<div class="paramname"><?php echo $text_currency; ?></div>
								<div class="paramdata"><select name="currency_code">
								  <?php foreach ($currencies as $currency) { ?>
								  <?php if ($currency_code == $currency['code']) { ?>
									  <option value="<?php echo $currency['code']; ?>" selected="selected"><?php echo $currency['title']; ?></option>
									  <?php } else { ?>
									  <option value="<?php echo $currency['code']; ?>"><?php echo $currency['title']; ?></option>
								  <?php } ?>
								  <?php } ?>
									</select>
								</div>
								<?php } ?>
							</div>
							<div class="width13">
								<?php if ($languages) { ?>
								<div class="paramname"><?php echo $text_language; ?></div>
								<div class="paramdata"><select name="language">
								  <?php foreach ($languages as $language) { ?>
								  <?php if ($admin_language == $language['code']) { ?>
									  <option value="<?php echo $language['code']; ?>" selected="selected"><?php echo $language['name']; ?></option>
									  <?php } else { ?>
									  <option value="<?php echo $language['code']; ?>"><?php echo $language['name']; ?></option>
								  <?php } ?>
								  <?php } ?>
									</select>
								</div>
								<?php } ?>
							</div>
							<div class="width27" style="text-align:right;padding-right:20px;">
								<div class="paramname" style="padding-left:10px;"><?php echo $text_status; ?></div>
								<div class="paramdata"><select name="order_status_id" id="order_status_id">
									<?php foreach ($order_statuses as $order_status) { ?>
									  <?php if ($order_status['order_status_id'] == $order_status_id) { ?>
									  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
									  <?php } else { ?>
									  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
									  <?php } ?>
									<?php } ?>
									</select><img src="view/image/red-help18.png" class="cluetip-img" alt="" title="<?php echo $help_order_status_head; ?>" rel="#help_order_status" />
								</div>
							</div>
						</div>
	
						<div class="half leftorder">
							<div class="width101">
								<div class="width100 width99">
									<div class="width66">
										<div class="paramname paramrazdel"><?php echo $text_customer; ?></div>
									</div>
									<div class="width33">
									</div>
								</div>
								<div class="width100">
									<div class="width60">
										<div class="paramname"><?php echo $entry_customer; ?><span class="help" style="display:inline-block;margin-left:5px;"><?php echo $help_autocomplite; ?></span></div>
										<div class="paramdata"><input type="text" name="customer" value="<?php echo $customer; ?>" />
											<input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>" />
											<input type="hidden" name="virtual_customer_id" value="<?php echo $virtual_customer_id; ?>" />
											<input type="hidden" name="customer_group_id" value="<?php echo $customer_group_id; ?>" />
											<input type="hidden" name="invoice_no" value="<?php echo $invoice_no; ?>" />
											<input type="hidden" name="date_added" value="<?php echo $date_added; ?>" />
											<input type="hidden" name="ip" value="<?php echo $ip; ?>" />
											<input type="hidden" name="clone" id="clone" value="<?php echo $clone; ?>" />
											<input type="hidden" name="order_id" value="<?php echo $order_id; ?>" />
											<input type="hidden" name="temp_order_id" value="<?php echo $temp_order_id; ?>" />
										</div>
									</div>
									<div class="width40">
									</div>
								</div>
			
								<div class="width100">
									<div class="width60">
									  <div class="paramname"><?php echo $entry_firstname; ?></div>
									  <div class="paramdata"><input type="text" name="firstname" value="<?php echo $firstname; ?>" />
										<?php if ($error_firstname) { ?><span class="error"><?php echo $error_firstname; ?></span><?php } ?>
									  </div>
									</div>
									
									<div class="width40">
									  <div class="paramname"><?php echo $entry_lastname; ?></div>
									  <div class="paramdata"><input type="text" name="lastname" value="<?php echo $lastname; ?>" /></div>
									</div>
								</div>
		
								<div class="width100">
									<div class="width33">
										<div class="paramname"><?php echo $entry_email; ?></div>
										<div class="paramdata"><input type="text" name="email" value="<?php echo $email; ?>" />
											<?php if ($error_email) { ?><span class="error"><?php echo $error_email; ?></span><?php } ?>
										</div>
									</div>
									
									<div class="width33">
										<div class="paramname"><?php echo $entry_telephone; ?></div>
										<div class="paramdata"><input type="text" name="telephone" value="<?php echo $telephone; ?>" /></div>

						</div>
									<div class="width60" style="width: 300px;border: 1px solid grey;margin-left: 10px;">
										<div class="paramname">ТТН</div>
										<div class="paramdata"><input type="text" name="ttn" id="sms_customer" value="<?php echo $ttn; ?>" /></div>
										<br>
										<a id="button-sms" class="button">Отправить смс c ТТН-кой</a>
									</div>
									<div class="width60" style="width: 540px;border: 1px solid grey;margin-left: 10px;">
										<div class="paramname">Шаблоны СМС</div>
										<div class="paramdata" style="float: left;"><input style="width: 410px;" type="text" name="sms_customer2" id="sms_customer2" value="" /></div>
										<a id="button-sms2" class="button">Отправить смс</a>
										<br>
										<a style="border-radius: 5px 5px 5px 5px;border: 0px;color: #FFF;display: inline-block;padding: 3px 3px 3px 3px;background: grey; cursor: pointer;text-decoration: none;margin: 3px;" type="submit" onclick="document.getElementById('sms_customer2').value+='<?php echo $shablon1; ?>'; return false;" /><?php echo $nameshablon1; ?></a>
										
										<a style="border-radius: 5px 5px 5px 5px;border: 0px;color: #FFF;display: inline-block;padding: 3px 3px 3px 3px;background: grey; cursor: pointer;text-decoration: none;margin: 3px;" type="submit" onclick="document.getElementById('sms_customer2').value+='<?php echo $shablon2; ?>'; return false;" /><?php echo $nameshablon2; ?></a>
										
										<a style="border-radius: 5px 5px 5px 5px;border: 0px;color: #FFF;display: inline-block;padding: 3px 3px 3px 3px;background: grey; cursor: pointer;text-decoration: none;margin: 3px;" type="submit" onclick="document.getElementById('sms_customer2').value+='<?php echo $shablon3; ?>'; return false;" /><?php echo $nameshablon3; ?></a>
										
										<a style="border-radius: 5px 5px 5px 5px;border: 0px;color: #FFF;display: inline-block;padding: 3px 3px 3px 3px;background: grey; cursor: pointer;text-decoration: none;margin: 3px;" type="submit" onclick="document.getElementById('sms_customer2').value+='<?php echo $shablon4; ?>'; return false;" /><?php echo $nameshablon4; ?></a>
										
										<a style="border-radius: 5px 5px 5px 5px;border: 0px;color: #FFF;display: inline-block;padding: 3px 3px 3px 3px;background: grey; cursor: pointer;text-decoration: none;margin: 3px;" type="submit" onclick="document.getElementById('sms_customer2').value+='<?php echo $shablon5; ?>'; return false;" /><?php echo $nameshablon5; ?></a>
						
					
									</div>
								
								</div>
		
								<div class="width100"<?php if (!$company_id_display) { ?> style="display:none;"<?php } ?>>
									<div class="width33">
									  <div class="paramname"><?php echo $entry_company; ?></div>
									  <div class="paramdata"><input type="text" name="payment_company" value="<?php echo $payment_company; ?>" /></div>
									</div>
									
									<div class="width33">
									  <div class="paramname"><?php echo $entry_company_id; ?></div>
									  <div class="paramdata"><input type="text" name="payment_company_id" value="<?php echo $payment_company_id; ?>" /></div>
									</div>
									
									<div class="width33"<?php if (!$tax_id_display) { ?> style="display:none;"<?php } ?>>
									  <div class="paramname"><?php echo $entry_tax_id; ?></div>
									  <div class="paramdata"><input type="text" name="payment_tax_id" value="<?php echo $payment_tax_id; ?>" /></div>
									</div>
								</div>
								
								<div class="width100">
									<div class="width99">
									  <div class="paramname"><?php echo $entry_comment_customer; ?></div>
									  <div class="paramdata"><textarea name="comment" style="width:96%;height:50px;resize:vertical;"><?php echo $comment; ?></textarea></div>
									</div>
								</div>
							</div>
	
						</div>
	
						<div class="half rightorder" style="">
							
							<div class="width103">
							<div class="width100 width99">
								<div class="width66">
									<div class="paramname paramrazdel"><?php echo $text_shipping; ?></div>
								</div>
								<div class="width33">
								</div>
							</div>

							<div class="width100">
								
								
								
								
								
								
								<div class="width60">
								  	<div class="paramdata">
									  <?php foreach ($addresses as $address) { ?>
									  	<?php if ($address['address_1']) { ?>
									  		<div class="paramname"><?php echo $entry_address; ?></div>
									  		<option value="<?php echo $address['address_id']; ?>"><?php echo $address['address_1']; ?></option>
									  		
									  <?php } ?>
									  <?php break; } ?>
									</div>
								</div>
								
								
				<table class="list form payment_shipping" id="payment_shipping">
					<tbody>
					<tr>
						<td class="left" style="border-right:0;text-align:center;">
						  <div class="paramname"><?php echo $entry_payment; ?></div>
						  <div class="paramdata">
							  <select class="payment" name="payment_method">
								<?php foreach ($payment_methods as $key => $payment) { ?>
									<?php if ($key == $payment_method) { ?>
										<option value="<?php echo $key; ?>" selected="selected"><?php echo $payment['title']; ?></option>
									  <?php } else { ?>
										<option value="<?php echo $key; ?>"><?php echo $payment['title']; ?></option>
									  <?php } ?>
							   <?php } ?>
							  </select>
							  <?php if ($error_payment_method) { ?><span class="error"><?php echo $error_payment_method; ?></span><?php } ?>
						  </div>
						</td>
						
						<td class="left" style="text-align:center;">
						  <div class="paramname"><?php echo $entry_shipping; ?></div>
						  <div class="paramdata">
							  <select class="shipping" name="shipping_method">
								<?php foreach ($shipping_methods as $key => $shipping) { ?>
									<?php if ($key == $shipping_method) { ?>
										<option value="<?php echo $key; ?>" selected="selected"><?php echo $shipping['title']; ?></option>
									  <?php } else { ?>
										<option value="<?php echo $key; ?>"><?php echo $shipping['title']; ?></option>
									  <?php } ?>
							   <?php } ?>
							  </select>
							  <?php if ($error_shipping_method) { ?><span class="error"><?php echo $error_shipping_method; ?></span><?php } ?>
						  </div>
						</td>
					</tr>
					</tbody>
					</table>								
								
								
								
								<div class="width40" style="display:none;height:45px;">
								</div>
							</div>
							
							<div class="width100">
								<div class="width60">
								  <div class="paramname"><?php echo $entry_firstname; ?></div>
								  <div class="paramdata"><input type="text" name="shipping_firstname" value="<?php echo $shipping_firstname; ?>" />
									<?php if ($error_shipping_firstname) { ?><span class="error"><?php echo $error_shipping_firstname; ?></span><?php } ?>
								  </div>
								</div>
								
								<div class="width40">
								  <div class="paramname"><?php echo $entry_lastname; ?></div>
								  <div class="paramdata"><input type="text" name="shipping_lastname" value="<?php echo $shipping_lastname; ?>" /></div>
								</div>
							</div>
							
							<div class="width100">
								<div class="width60">
								  <div class="paramname"><?php echo $entry_country; ?></div>
								  <div class="paramdata"><select name="shipping_country_id" style="width:90%;">
									  <option value=""><?php echo $text_select; ?></option>
									  <?php foreach ($countries as $country) { ?>
									  <?php if ($country['country_id'] == $shipping_country_id) { ?>
									  <option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
									  <?php } else { ?>
									  <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
									  <?php } ?>
									  <?php } ?>
									</select>
								  </div>
								</div>
								
								<div class="width40">
								  <div class="paramname"><?php echo $entry_zone; ?></div>
								  <div class="paramdata"><select name="shipping_zone_id" style="width:90%;"></select>
								  </div>
								</div>

							</div>

							<div class="width100">
								<div class="width60">
									
									
									
									<?php if ($shipping_city) { ?>
										<div class="paramname"><?php echo $entry_city; ?></div>
										<div class="paramdata"><input type="text" name="shipping_city" value="<?php echo $shipping_city; ?>" /></div>
								  	<?php } ?>
								
								
								
								</div>
								
							</div>
							</div>

						</div>
					</td>
				</tr>
			</table>
			</div>

			<div id="tab-payment" style="display:none;">
				<table class="form order-payment">
					<tbody>
						<tr>
						  <td><input type="text" name="payment_firstname" value="<?php echo $payment_firstname; ?>" /></td>
						  <td><input type="text" name="payment_lastname" value="<?php echo $payment_lastname; ?>" /></td>
						  <td><input type="text" name="payment_address_1" value="<?php echo $payment_address_1; ?>" /></td>
						  <td><input type="text" name="payment_address_2" value="<?php echo $payment_address_2; ?>" /></td>
						  <td><input type="text" name="payment_city" value="<?php echo $payment_city; ?>" /></td>
						  <td><input type="text" name="payment_postcode" value="<?php echo $payment_postcode; ?>" /></td>
						  <td><input type="text" name="payment_country_id" value="<?php echo $payment_country_id; ?>" /></td>
						  <td><input type="text" name="payment_zone_id" value="<?php echo $payment_zone_id; ?>" /></td>
						  <td><input type="text" name="shipping_company" value="<?php echo $shipping_company; ?>" /></td>
						</tr>
					</tbody>
				</table>
			</div>

			<div id="tab-history" class="htabs-content">
				<div class="mode-history">
					<table class="form order-history">
					  <tr>
					    <td class="status-history">
							<div class="paramname"><?php echo $entry_order_status; ?></div>
							<div class="paramdata"><select id="horder_status_id">
								<?php foreach ($order_statuses as $order_statuses) { ?>
								<?php if ($order_statuses['order_status_id'] == $order_status_id) { ?>
								<option value="<?php echo $order_statuses['order_status_id']; ?>" selected="selected"><?php echo $order_statuses['name']; ?></option>
								<?php } else { ?>
								<option value="<?php echo $order_statuses['order_status_id']; ?>"><?php echo $order_statuses['name']; ?></option>
								<?php } ?>
								<?php } ?>
							  </select></div>
						</td>
						<td class="status-notify">
							<div class="paramname"><?php echo $entry_notify; ?><input type="checkbox" name="notify" value="1" /></div>
						</td>
						<td class="status-comment">
							<div class="paramname"><?php echo $entry_comment; ?></div>
							<div class="paramdata"><textarea name="admin_comment" rows="4" style="width:99%;box-sizing:border-box;resize:vertical;"></textarea></div>
						</td>
						<td class="status-add">
							<a id="button-history" class="btn btn-primary"><?php echo $button_add_history; ?></a>
						</td>
					  </tr>
					</table>
				</div>
				<div id="history"></div>
			</div>

			<div id="tab-total" class="htabs-content">
				<?php 
				$coupon_colspan = 16;
				if (($customer_id) && ($reward_status)) {$hide_reward = '';} else {$hide_reward = ' style="display:none;"';}
				if ($show_model) {$hide_model = '';} else {$hide_model = ' style="display:none;"';$coupon_colspan -= 1;}
				if ($show_sku) {$hide_sku = '';} else {$hide_sku = ' style="display:none;"';$coupon_colspan -= 1;}
				if ($show_upc) {$hide_upc = '';} else {$hide_upc = ' style="display:none;"';$coupon_colspan -= 1;}
				if ($show_ean) {$hide_ean = '';} else {$hide_ean = ' style="display:none;"';$coupon_colspan -= 1;}
				if ($show_jan) {$hide_jan = '';} else {$hide_jan = ' style="display:none;"';$coupon_colspan -= 1;}
				if ($show_isbn) {$hide_isbn = '';} else {$hide_isbn = ' style="display:none;"';$coupon_colspan -= 1;}
				if ($show_mpn) {$hide_mpn = '';} else {$hide_mpn = ' style="display:none;"';$coupon_colspan -= 1;}
				if ($show_location) {$hide_location = '';} else {$hide_location = ' style="display:none;"';$coupon_colspan -= 1;}
				if ($show_pid) {$hide_pid = '';} else {$hide_pid = ' style="display:none;"';$coupon_colspan -= 1;}
				if ($show_image) {$hide_image = '';} else {$hide_image = ' style="display:none;"';$coupon_colspan -= 1;}
				?>
				<table id="product" class="list order-products">
					<thead>
						  <tr>
						    <td class="center column-pid"<?php echo $hide_pid; ?>><?php echo $column_pid; ?></td>
							<td class="center column-image"<?php echo $hide_image; ?>><?php echo $column_image; ?></td>
							<td class="center column-product"><?php echo $column_product; ?><span class="help"><?php echo $help_autocomplite; ?></span></td>
							<td class="center column-model"<?php echo $hide_model; ?>><?php echo $column_model; ?><span class="help"><?php echo $help_autocomplite; ?></span></td>
							<td class="center column-sku"<?php echo $hide_sku; ?>><?php echo $column_sku; ?><span class="help"><?php echo $help_autocomplite; ?></span></td>
							<td class="center column-upc"<?php echo $hide_upc; ?>><?php echo $column_upc; ?><span class="help"><?php echo $help_autocomplite; ?></span></td>
							<td class="center column-ean"<?php echo $hide_ean; ?>><?php echo $column_ean; ?><span class="help"><?php echo $help_autocomplite; ?></span></td>
							<td class="center column-jan"<?php echo $hide_jan; ?>><?php echo $column_jan; ?><span class="help"><?php echo $help_autocomplite; ?></span></td>
							<td class="center column-isbn"<?php echo $hide_isbn; ?>><?php echo $column_isbn; ?><span class="help"><?php echo $help_autocomplite; ?></span></td>
							<td class="center column-mpn"<?php echo $hide_mpn; ?>><?php echo $column_mpn; ?><span class="help"><?php echo $help_autocomplite; ?></span></td>
							<td class="center column-location"<?php echo $hide_location; ?>><?php echo $column_location; ?><span class="help"><?php echo $help_autocomplite; ?></span></td>
							<td class="center column-quantity"><?php echo $column_quantity; ?><span class="help"><?php echo $help_qty; ?></span></td>
							<td class="center column-realquantity"><?php echo $column_realquantity; ?><span class="help"><?php echo $help_stock; ?></span></td>
							<td class="center column-price"><?php echo $column_price; ?><img src="view/image/delete16.png" id="empty-prices" class="cluetip-img" alt="" title="<?php echo $help_empty_prices_head; ?>" rel="#help_empty_prices" /><span class="help"><?php echo $help_price; ?></span></td>
							<td class="center column-now_price"><?php echo $column_now_price; ?><span class="help"><?php echo $help_now_price; ?></span></td>
							<td class="center column-total"><?php echo $column_total; ?></td>
							<td class="center column-discount"><?php echo $column_discount; ?><img src="view/image/delete16.png" id="empty-discounts" class="cluetip-img" alt="" title="<?php echo $help_empty_discount_head; ?>" rel="#help_empty_discount" /></td>
							<td class="center column-reward"<?php echo $hide_reward; ?>><span class="blong"><?php echo $column_reward; ?></span><span class="bshort"><?php echo $column_reward_short; ?></span></td>
							<td class="center column-action"></td>
						  </tr>
					</thead>
					
					<?php $product_row = 0; ?>
						<input type="hidden" name="order_products" value='<?php echo urlencode(json_encode($order_products)); ?>' />
					<?php foreach ($order_products as $order_product) { ?>
						<tbody id="product-row<?php echo $product_row; ?>">
						<?php if ($order_product['status'] == '0') {$name_class = ' item-off';} elseif ($order_product['status'] == '3') {$name_class = ' item-del';} else {$name_class = '';} ?>
						  <tr class="product-line<?php echo $name_class; ?>">
							<td class="center"<?php echo $hide_pid; ?>><input type="text" name="order_product[<?php echo $product_row; ?>][product_id]" value="<?php echo $order_product['product_id']; ?>" class="input-pid" style="width:98%;" readonly="readonly" /></td>
							<td class="center"<?php echo $hide_image; ?>>
								<div class="product-image" id="image_<?php echo $product_row; ?>">
									<a href="<?php echo $order_product['href']; ?>" target="_blank"><img src="<?php echo $order_product['image']; ?>" alt="<?php echo $order_product['name']; ?>" /></a>
									<?php if ($order_product['popap']) { ?><span id="popap_<?php echo $product_row; ?>" class="product-popap" data-popap="<?php echo $order_product['popap']; ?>"></span><?php } ?>
								</div>
							</td>
							<td class="center">
							  <input type="text" name="order_product[<?php echo $product_row; ?>][name]" value="<?php echo $order_product['name']; ?>" class="input-name" style="width:98%;" />
							  <input type="hidden" name="order_product[<?php echo $product_row; ?>][order_product_id]" value="<?php echo $order_product['order_product_id']; ?>" />
							  <input type="hidden" name="order_product[<?php echo $product_row; ?>][tax]" value="<?php echo $order_product['tax']; ?>" />
							  <input type="hidden" name="order_product[<?php echo $product_row; ?>][status]" value="<?php echo $order_product['status']; ?>" />
							  <div id="product_options<?php echo $product_row; ?>">
							  <?php if ($order_product['option']) { ?>
								  <div class="poptions">
								  <?php foreach ($order_product['option'] as $option) { ?>
								  <?php if ($option['type'] == 'select' || $option['type'] == 'radio' || $option['type'] == 'image') { ?>
								  <div class="option">
									  <?php if ($option['required']) { ?>
										<span class="required">*</span>
									  <?php } ?>
									  <?php echo $option['name']; ?><br />
									  <select name="order_product[<?php echo $product_row; ?>][option][<?php echo $option['product_option_id']; ?>]">
										  <?php if (!$option['required']) { ?>
										  <option value=""><?php echo $text_select; ?></option>
										  <?php } ?>
										<?php foreach ($option['option_value'] as $option_value) { ?>
											<?php if (in_array($option_value['product_option_value_id'], $order_product['order_option'])) { ?>
												<option value="<?php echo $option_value['product_option_value_id']; ?>" selected="selected"><?php echo $option_value['name']; ?>
												<?php if ($option_value['price']) { ?>
												(<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
												<?php } ?>
												</option>
											<?php } else {?>
												<option value="<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
												<?php if ($option_value['price']) { ?>
												(<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
												<?php } ?>
												</option>
											<?php } ?>
										<?php } ?>
									  </select>
								  </div>
								  <br />
								  <?php } ?>
								  <?php if ($option['type'] == 'checkbox') { ?>
								  <div>
								  <?php if ($option['required']) { ?><span class="required">*</span><?php } ?>
								  <?php echo $option['name']; ?><br />
								  <?php foreach ($option['option_value'] as $option_value) { ?>
								  <?php if (in_array($option_value['product_option_value_id'], $order_product['order_option'])) { ?>
									<input checked="checked" type="checkbox" name="order_product[<?php echo $product_row; ?>][option][<?php echo $option['product_option_id']; ?>][]" value="<?php echo $option_value['product_option_value_id']; ?>" id="option-value-<?php echo $product_row; ?>-<?php echo $option_value['product_option_value_id']; ?>" />
								  <?php } else { ?>
									<input type="checkbox" name="order_product[<?php echo $product_row; ?>][option][<?php echo $option['product_option_id']; ?>][]" value="<?php echo $option_value['product_option_value_id']; ?>" id="option-value-<?php echo $product_row; ?>-<?php echo $option_value['product_option_value_id']; ?>" />
								  <?php } ?>
								  <label for="option-value-<?php echo $product_row; ?>-<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
									<?php if ($option_value['price']) { ?>
									(<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
									<?php } ?>
								  </label><br />
								  <?php } ?>
								  </div>
								  <br />
								  <?php } ?>
								  <?php if ($option['type'] == 'text') { ?>
								  <div>
								  <?php if ($option['required']) { ?><span class="required">*</span><?php } ?>
								  <?php echo $option['name']; ?><br />
								  <input type="text" name="order_product[<?php echo $product_row; ?>][option][<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" />
								  </div>
								  <br />
								  <?php } ?>
								  <?php if ($option['type'] == 'textarea') { ?>
								  <div>
								  <?php if ($option['required']) { ?><span class="required">*</span><?php } ?>
								  <?php echo $option['name']; ?><br />
								  <textarea name="order_product[<?php echo $product_row; ?>][option][<?php echo $option['product_option_id']; ?>]" cols="40" rows="5"><?php echo $option['option_value']; ?></textarea>
								  </div>
								  <br />
								  <?php } ?>
								  <?php if ($option['type'] == 'file') { ?>
								  <div>
								  <?php if ($option['required']) { ?><span class="required">*</span><?php } ?>
								  <?php echo $option['name']; ?><br />
								  <a id="file-link-<?php echo $option['product_option_id']; ?>-<?php echo $product_row; ?>" class="file-link" href="<?php echo $option['href']; ?>"><?php echo $option['option_value']; ?></a>
								  <a id="button-option-<?php echo $option['product_option_id']; ?>-<?php echo $product_row; ?>" class="btn btn-primary"><?php echo $button_upload; ?></a>
								  <input type="hidden" name="order_product[<?php echo $product_row; ?>][option][<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" />
								  <script type="text/javascript"><!--
									new AjaxUpload($("#button-option-<?php echo $option['product_option_id']; ?>-<?php echo $product_row; ?>"), {
										action: 'index.php?route=sale/orderpro/upload&token=<?php echo $token; ?>',
										name: 'file',
										autoSubmit: true,
										responseType: 'json',
										onSubmit: function(file, extension) {$('#button-option-<?php echo $option['product_option_id']; ?>-<?php echo $product_row; ?>').after('<img src="view/image/loading.gif" class="loading" />');},
										onComplete: function(file, json) {
											$('.success, .error, .warning').remove();
											if (json['success']) {
												$('#notifications').html('<div class="success">' + json['success'] + '<img src="view/image/close16.png" alt="" class="close" /></div>');
												setTimeout ("$('.success').fadeOut('slow', function() {$(this).remove();});", 3000);
												$('#file-link-<?php echo $option['product_option_id']; ?>-<?php echo $product_row; ?>').empty().append(json['filename']);
												$('input[name=\'order_product[<?php echo $product_row; ?>][option][<?php echo $option['product_option_id']; ?>]\']').attr('value', json['file']);
											}
											if (json.error) {$('#notifications').html('<div class="warning">' + json['error'] + '<img src="view/image/close16.png" alt="" class="close" /></div>');}
											$('.loading').remove();	
										}
									});
								  //--></script>
								  </div>
								  <br />
								  <?php } ?>
								  <?php if ($option['type'] == 'date') { ?>
								  <div>
								  <?php if ($option['required']) { ?><span class="required">*</span><?php } ?>
								  <?php echo $option['name']; ?><br />
								  <input type="text" name="order_product[<?php echo $product_row; ?>][option][<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" class="date" />
								  </div>
								  <br />
								  <?php } ?>
								  <?php if ($option['type'] == 'datetime') { ?>
								  <div>
								  <?php if ($option['required']) { ?><span class="required">*</span><?php } ?>
								  <?php echo $option['name']; ?><br />
								  <input type="text" name="order_product[<?php echo $product_row; ?>][option][<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" class="datetime" />
								  </div>
								  <br />
								  <?php } ?>
								  <?php if ($option['type'] == 'time') { ?>
								  <div>
								  <?php if ($option['required']) { ?><span class="required">*</span><?php } ?>
								  <?php echo $option['name']; ?><br />
								  <input type="text" name="order_product[<?php echo $product_row; ?>][option][<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" class="time" />
								  </div>
								  <br />
								  <?php } ?>
								  <?php } ?>
								  </div>
							  <?php } ?>
							  </div>
							</td>
							<td class="center"<?php echo $hide_model; ?>><input type="text" name="order_product[<?php echo $product_row; ?>][model]" value="<?php echo $order_product['model']; ?>" class="input-model" style="width:98%;" /></td>
							<td class="center"<?php echo $hide_sku; ?>><input type="text" name="order_product[<?php echo $product_row; ?>][sku]" value="<?php echo $order_product['sku']; ?>" class="input-sku" style="width:98%;" /></td>
							<td class="center"<?php echo $hide_upc; ?>><input type="text" name="order_product[<?php echo $product_row; ?>][upc]" value="<?php echo $order_product['upc']; ?>" class="input-upc" style="width:98%;" /></td>
							<td class="center"<?php echo $hide_ean; ?>><input type="text" name="order_product[<?php echo $product_row; ?>][ean]" value="<?php echo $order_product['ean']; ?>" class="input-ean" style="width:98%;" /></td>
							<td class="center"<?php echo $hide_jan; ?>><input type="text" name="order_product[<?php echo $product_row; ?>][jan]" value="<?php echo $order_product['jan']; ?>" class="input-jan" style="width:98%;" /></td>
							<td class="center"<?php echo $hide_isbn; ?>><input type="text" name="order_product[<?php echo $product_row; ?>][isbn]" value="<?php echo $order_product['isbn']; ?>" class="input-isbn" style="width:98%;" /></td>
							<td class="center"<?php echo $hide_mpn; ?>><input type="text" name="order_product[<?php echo $product_row; ?>][mpn]" value="<?php echo $order_product['mpn']; ?>" class="input-mpn" style="width:98%;" /></td>
							<td class="center"<?php echo $hide_location; ?>><input type="text" name="order_product[<?php echo $product_row; ?>][location]" value="<?php echo $order_product['location']; ?>" class="input-location" style="width:98%;" /></td>
							<td class="center"><input type="text" name="order_product[<?php echo $product_row; ?>][quantity]" value="<?php echo $order_product['quantity']; ?>" size="3" class="input-quantity" style="text-align:right;" /></td>
							<td class="center"><span id="realquantity_<?php echo $product_row; ?>"><?php echo $order_product['realquantity']; ?></span></td>
							<td class="price<?php echo $product_row; ?> right product-price">
								<input type="text" name="order_product[<?php echo $product_row; ?>][price]" id="price_<?php echo $product_row; ?>" value="<?php echo $order_product['price']; ?>" class="input-price" />
								<img src="view/image/close14.png" class="price-empty cluetip-img" alt="" />
							</td>
							<td class="right now_price">
								<span id="now_price_<?php echo $product_row; ?>"><?php echo $order_product['now_price']; ?></span>
								<span id="now_special_<?php echo $product_row; ?>" style="color:red;"><?php echo $order_product['now_special']; ?></span>
								<span id="now_discount_<?php echo $product_row; ?>" style="color:blue;"><?php echo $order_product['now_discount_qty']; ?>/<?php echo $order_product['now_discount']; ?></span>
							</td>
							<td class="right total<?php echo $product_row; ?> product-total"><input type="text" name="order_product[<?php echo $product_row; ?>][total]" id="total_<?php echo $product_row; ?>" value="<?php echo $order_product['total']; ?>" style="text-align:right;width:99%;" class="onlyread" readonly /></td>
							<td class="right product-discount" nowrap>
								<input type="text" name="order_product[<?php echo $product_row; ?>][discount_amount]" value="<?php echo $order_product['discount_amount']; ?>" class="input-amount" <?php if($order_product['discount_amount'] > 0) { ?>style="border: 1px solid #38AD38;" <?php } ?>/>
								<select name="order_product[<?php echo $product_row; ?>][discount_type]">
									<?php if ($order_product['discount_type'] == 'S') { ?>
										<option value="S" selected="selected">S</option>
										<option value="P">%</option>
									<?php } else { ?>
										<option value="P" selected="selected">%</option>
										<option value="S">S</option>
									<?php } ?>
								</select><img src="view/image/close14.png" class="amount-empty cluetip-img" alt="" />
							</td>
							<td class="right reward<?php echo $product_row; ?> product-reward"<?php echo $hide_reward; ?>><input type="text" name="order_product[<?php echo $product_row; ?>][reward]" value="<?php echo $order_product['reward']; ?>" style="text-align:right;width:99%;" class="onlyread" readonly /></td>
							<td class="premove center"><a onclick="$('#product-row<?php echo $product_row; ?>').remove();" class="button-remove"></a></td>
						  </tr>
						</tbody>
						<?php $product_row++; ?>
						<?php } ?>
						<tfoot>
						  <tr>
							<?php if ($coupon_status || $voucher_status) { ?>
								<td colspan="<?php echo $coupon_colspan; ?>">
								<?php if ($coupon_status) { ?>
									<div id="coupon">
										<div class="title-order-coupon"><?php echo $entry_coupon; ?><span class="help"><?php echo $help_autocomplite; ?></span></div>
										<input type="text" name="coupon_id" value="<?php echo $coupon; ?>" />
										<img src="view/image/blue-help18.png" class="cluetip-img" alt="" title="<?php echo $help_coupon_head; ?>" rel="#help_coupon" />
										<img src="view/image/red-help18.png" class="cluetip-img" alt="" rel="#help_coupon_use" />
									</div>
								<?php } ?>
								<?php if ($voucher_status) { ?>
									<div id="voucher">
										<div class="title-order-voucher"><?php echo $entry_voucher; ?><span class="help"><?php echo $help_autocomplite; ?></span></div>
										<input type="text" name="voucher_id" value="<?php echo $voucher; ?>" />
										<img src="view/image/blue-help18.png" class="cluetip-img" alt="" title="<?php echo $help_voucher_head; ?>" rel="#help_voucher" />
										<img src="view/image/red-help18.png" class="cluetip-img" alt="" rel="#help_voucher_use" />
									</div>
								<?php } ?>
								</td>
							<?php } else { ?>
								<td colspan="<?php echo $coupon_colspan; ?>"></td>
							<?php } ?>
							<?php if ($customer_id && $reward_status) { ?>
								<td colspan="3" class="right">
							<?php } else { ?>
								<td colspan="2" class="right">
							<?php } ?>
								<a onclick="addProduct();" class="btn btn-primary"><span><?php echo $button_add_product; ?></span></a></td>
						  </tr>
						</tfoot>
				</table>
				
					<?php if ($customer_id && $reward_status) { ?>
						<table class="list form" id="order-reward">
							<tbody>
								<tr>
								  <td>
									<div class="left reward-title"><?php echo $entry_reward_total; ?></div>
									<div class="left reward-data" id="reward-total"><span class="rtotal"><?php echo $reward_total; ?></span>/<span class="ptotal"><?php echo $reward_possibly; ?></span></div>
								  </td>
								  <td>
									<div class="left reward-title"><?php echo $entry_reward_recived; ?></div>
									<div class="left reward-data" id="reward-recived"><span><?php echo $reward_recived; ?></span> <img src="view/image/delete.png" alt="" title="<?php echo $help_reward_removed_head; ?>" id="reward-remove" class="cluetip-img" rel="#help_reward_removed" /></div>
								  </td>
								  <td>
									<div class="left reward-title"><?php echo $entry_reward; ?></div>
									<div class="left reward-data"><input type="text" name="reward_cart" value="<?php echo $reward_cart; ?>" /> <img src="view/image/add.png" alt="" title="<?php echo $help_reward_add_head; ?>" id="reward-add" class="cluetip-img" rel="#help_reward_add" /></div>
								  </td>
								  <td>
									<div class="left reward-title"><?php echo $entry_reward_use; ?></div>
									<div class="left reward-data" id="rewards-available"><input type="text" name="reward_use" value="<?php echo $reward_use; ?>" style="vertical-align:middle;"/><span class="reward-use"></span><img src="view/image/red-help18.png" class="cluetip-img" alt="" rel="#help_reward_use" /></div>
								  </td>
								</tr>
							</tbody>
						</table>
					<?php } ?>

					<?php if ($order_id && $affiliate) { ?>
						<table class="list form" id="order-affiliate">
							<tbody>
								<tr>
									<td>
										<div class="affiliate-block">
										  <div class="paramname"><?php echo $entry_affiliate; ?><span class="help"><?php echo $help_autocomplite; ?></span></div>
										  <div class="paramdata" id="commission">
											<input type="text" name="affiliate" value="<?php echo $affiliate; ?>" />
											  <img src="view/image/add.png" alt="" title="<?php echo $help_commission_add_head; ?>" id="commission_add" class="cluetip-img"<?php if ($commission_total) { ?> style="display:none;"<?php } ?> rel="#help_commission_add" />
											  <img src="view/image/delete.png" alt="" title="<?php echo $help_commission_remove_head; ?>" id="commission_remove" class="cluetip-img"<?php if (!$commission_total) { ?> style="display:none;"<?php } ?> rel="#help_commission_remove" />
											  <span style="margin-left:5px;font-weight:bold;"><?php echo $commission_order; ?></span>
											<input type="hidden" name="affiliate_id" value="<?php echo $affiliate_id; ?>" />
											<input type="hidden" name="commission" value="<?php echo $commission; ?>" />
										  </div>
										</div>
									</td>
								</tr>
							</tbody>
						</table>
					<?php } ?>
					
						
					<table class="list order-total" id="total">
						<thead>
						  <tr>
							<td class="center"><?php echo $column_desc; ?></td>
							<td class="center"><?php echo $column_cost; ?></td>
							<td class="center"><?php echo $column_total; ?></td>
							<td class="center"><?php echo $column_nocalc; ?>
								<img src="view/image/blue-help18.png" class="cluetip-img" alt="" title="<?php echo $help_nocalc_head; ?>" rel="#help_nocalc" style="width:14px;vertical-align:bottom;" />
							</td>
							<td class="center"><?php echo $column_sort; ?></td>
							<td></td>
						  </tr>
						</thead>
						<?php $total_row = 0; ?>
						<?php foreach ($order_totals as $order_total) { ?>
						<tbody id="total-row<?php echo $total_row; ?>">
						<?php if (count($tax_class_id = explode(',', $order_total['code'])) > 1) { $correct = true; $order_total['code'] = 'correct'; echo '<input type="hidden" value="' . $tax_class_id[1] . '" name="order_total[' . $total_row . '][tax_class_id]">'; } ?>

						<?php if ($order_total['code'] == 'discount') {$discount_status = true;} ?>
						  <tr>
							<td class="center total-title">
							  <input type="hidden" name="order_total[<?php echo $total_row; ?>][order_total_id]" value="<?php echo $order_total['order_total_id']; ?>" />
							  <input type="hidden" name="order_total[<?php echo $total_row; ?>][code]" value="<?php echo $order_total['code']; ?>" />
							  <input type="text" style="width: 98%;" name="order_total[<?php echo $total_row; ?>][title]" value="<?php echo $order_total['title']; ?>" />
							</td>
							<td class="right total-value">
								<input type="hidden" name="order_total[<?php echo $total_row; ?>][text]" value="<?php echo $order_total['text']; ?>" />
								<?php if ($order_total['code'] == 'sub_total' || $order_total['code'] == 'total') { ?>
									<input type="hidden" name="order_total[<?php echo $total_row; ?>][value]" value="<?php echo $order_total['value']; ?>" />
								<?php } else { ?>
									<input type="text" name="order_total[<?php echo $total_row; ?>][value]" value="<?php echo number_format($order_total['value'], 2, '.', ''); ?>" />
								<?php } ?>
							</td>
							<td class="right total-text"><?php echo $order_total['text']; ?>
							</td>
							<td class="center total-nocalc">
								<?php if ($order_total['code'] == 'shipping') { ?>
									<input class="no_calc" type="checkbox" name="<?php echo $order_total['code']; ?>" value="0" checked="checked"/>
								<?php } else { ?>
									<input class="no_calc" type="checkbox" name="<?php echo $order_total['code']; ?>" value="0" />
								<?php } ?>
							</td>
							<td class="center total-sort">
								<?php if (($order_total['code'] == 'correct') || ($order_total['code'] == 'discount')) { ?>
									<input type="hidden" name="order_total[<?php echo $total_row; ?>][sort_order]" value="<?php echo $order_total['sort_order']; ?>" />
								<?php } else { ?>
									<input style="width:30px;text-align:center;" type="text" name="order_total[<?php echo $total_row; ?>][sort_order]" value="<?php echo $order_total['sort_order']; ?>" />
								<?php } ?>
							</td>
							<td class="right total-delete"><a onclick="$('#total-row<?php echo $total_row; ?>').remove();<?php if ($order_total['code'] == 'discount' || $order_total['code'] == 'correct') { echo '$(\'.' . $order_total['code'] . ' .tbutton\').css(\'display\',\'block\');'; } ?>" class="btn btn-danger"><span><?php echo $button_remove; ?></span></a>
							</td>
						  </tr>
						</tbody>
						<?php $total_row++; ?>
						<?php } ?>
						<tfoot>
						  <tr><td class="left message" colspan="6">&nbsp;</td></tr>
						  <tr class="actions-buttons">
								<td class="right"></td>
								<td class="correct right" colspan="2"><div class="tbutton"<?php if (isset($correct)) { ?> style="display:none"<?php } ?>>
									<a onclick="addCorrect();" class="btn btn-primary"><span><?php echo $button_correct; ?></span></a>
									<img src="view/image/blue-help20.png" class="cluetip-img" alt="" title="<?php echo $help_correct_head; ?>" rel="#help_correct" /></div>
								</td>
								<td class="discount right" colspan="2"><div class="tbutton"<?php if (isset($discount_status)) { ?> style="display:none"<?php } ?>>
									<a onclick="addDiscount();" class="btn btn-primary"><span><?php echo $button_discount; ?></span></a>
									<img src="view/image/blue-help20.png" class="cluetip-img" alt="" title="<?php echo $help_discount_head; ?>" rel="#help_discount" /></div>
								</td>
								<td class="right"><div class="tbutton">
									<?php if (!$status_del_warning) { ?>
										<a id="recalc-button" onclick="recalculate();" class="btn btn-success"><span><?php echo $button_recalculate; ?></span></a>
										<img src="view/image/green-help20.png" class="cluetip-img" alt="" title="<?php echo $help_recalculate_head; ?>" rel="#help_recalculate" />
									<?php } else { ?>
										<a id="recalc-button" class="btn btn-default"><span><?php echo $button_recalculate; ?></span></a>
										<img src="view/image/red-help18.png" class="cluetip-img" alt="" title="<?php echo $help_recalculate_head; ?>" rel="#help_recalculate_bad" />
									<?php } ?>
									</div>
								</td>
						  </tr>
						</tfoot>
					</table>
			</div>
      </form>
    
			<div id="tab-setting" class="htabs-content">
				<table class="form" id="order-setting">
					<tbody>
						<tr>
						  <td colspan="2"><span class="version"><?php echo $orderpro_version; ?></span><a id="save-setting" class="btn btn-primary"><?php echo $button_save_setting; ?></a></td>
						</tr>
						<tr>
						  <td><?php echo $entry_license; ?></td>
						  <td><input type="text" class="input-license" name="orderpro_license" value="<?php echo $orderpro_license; ?>" /></td>
						</tr>
						<tr>
						  <td><?php echo $entry_show_pid; ?></td>
						  <td><?php if ($orderpro_show_pid) { ?>
							<input type="checkbox" name="orderpro_show_pid" value="1" checked="checked" />
							<?php } else { ?>
							<input type="checkbox" name="orderpro_show_pid" value="1" />
							<?php } ?></td>
						</tr>
						<tr>
						  <td><?php echo $entry_show_image; ?></td>
						  <td><?php if ($orderpro_show_image) { ?>
							<input type="checkbox" name="orderpro_show_image" value="1" checked="checked" />
							<?php } else { ?>
							<input type="checkbox" name="orderpro_show_image" value="1" />
							<?php } ?></td>
						</tr>
						<tr>
						  <td><?php echo $entry_show_model; ?></td>
						  <td><?php if ($orderpro_show_model) { ?>
							<input type="checkbox" name="orderpro_show_model" value="1" checked="checked" />
							<?php } else { ?>
							<input type="checkbox" name="orderpro_show_model" value="1" />
							<?php } ?></td>
						</tr>
						<tr>
						  <td><?php echo $entry_show_sku; ?></td>
						  <td><?php if ($orderpro_show_sku) { ?>
							<input type="checkbox" name="orderpro_show_sku" value="1" checked="checked" />
							<?php } else { ?>
							<input type="checkbox" name="orderpro_show_sku" value="1" />
							<?php } ?></td>
						</tr>
						<tr>
						  <td><?php echo $entry_show_upc; ?></td>
						  <td><?php if ($orderpro_show_upc) { ?>
							<input type="checkbox" name="orderpro_show_upc" value="1" checked="checked" />
							<?php } else { ?>
							<input type="checkbox" name="orderpro_show_upc" value="1" />
							<?php } ?></td>
						</tr>
						<tr>
						  <td><?php echo $entry_show_ean; ?></td>
						  <td><?php if ($orderpro_show_ean) { ?>
							<input type="checkbox" name="orderpro_show_ean" value="1" checked="checked" />
							<?php } else { ?>
							<input type="checkbox" name="orderpro_show_ean" value="1" />
							<?php } ?></td>
						</tr>
						<tr>
						  <td><?php echo $entry_show_jan; ?></td>
						  <td><?php if ($orderpro_show_jan) { ?>
							<input type="checkbox" name="orderpro_show_jan" value="1" checked="checked" />
							<?php } else { ?>
							<input type="checkbox" name="orderpro_show_jan" value="1" />
							<?php } ?></td>
						</tr>
						<tr>
						  <td><?php echo $entry_show_isbn; ?></td>
						  <td><?php if ($orderpro_show_isbn) { ?>
							<input type="checkbox" name="orderpro_show_isbn" value="1" checked="checked" />
							<?php } else { ?>
							<input type="checkbox" name="orderpro_show_isbn" value="1" />
							<?php } ?></td>
						</tr>
						<tr>
						  <td><?php echo $entry_show_mpn; ?></td>
						  <td><?php if ($orderpro_show_mpn) { ?>
							<input type="checkbox" name="orderpro_show_mpn" value="1" checked="checked" />
							<?php } else { ?>
							<input type="checkbox" name="orderpro_show_mpn" value="1" />
							<?php } ?></td>
						</tr>
						<tr>
						  <td><?php echo $entry_show_location; ?></td>
						  <td><?php if ($orderpro_show_location) { ?>
							<input type="checkbox" name="orderpro_show_location" value="1" checked="checked" />
							<?php } else { ?>
							<input type="checkbox" name="orderpro_show_location" value="1" />
							<?php } ?></td>
						</tr>
						<tr>
						  <td><?php echo $entry_invoice_type; ?></td>
						  <td><?php if ($orderpro_invoice_type) { ?>
							<input type="checkbox" name="orderpro_invoice_type" value="1" checked="checked" />
							<?php } else { ?>
							<input type="checkbox" name="orderpro_invoice_type" value="1" />
							<?php } ?></td>
						</tr>
						<tr>
						  <td><?php echo $entry_virtual_customer; ?><img src="view/image/blue-help18.png" class="cluetip-img" alt="" rel="#help_virtual_customer" style="margin-left:5px;vertical-align:bottom;" /></td>
						  <td><?php if ($orderpro_virtual_customer) { ?>
							<input type="checkbox" name="orderpro_virtual_customer" value="1" checked="checked" />
							<?php } else { ?>
							<input type="checkbox" name="orderpro_virtual_customer" value="1" />
							<?php } ?></td>
						</tr>
					</tbody>
				</table>
			</div>
	</div>
  </div>
</div>
<div id="help_registered" style="display:none;"><?php echo $help_registered; ?></div>
<div id="help_order_status" style="display:none;"><?php echo $help_order_status; ?></div>
<div id="help_empty_prices" style="display:none;"><?php echo $help_empty_prices; ?></div>
<div id="help_empty_discount" style="display:none;"><?php echo $help_empty_discount; ?></div>
<div id="help_nocalc" style="display:none;"><?php echo $help_nocalc; ?></div>
<div id="help_coupon" style="display:none;"><?php echo $help_coupon; ?></div>
<div id="help_coupon_use" style="display:none;"><?php echo $help_coupon_use; ?></div>
<div id="help_voucher" style="display:none;"><?php echo $help_voucher; ?></div>
<div id="help_voucher_use" style="display:none;"><?php echo $help_voucher_use; ?></div>
<div id="help_reward_use" style="display:none;"><?php echo $help_reward_use; ?></div>
<div id="help_reward_removed" style="display:none;"><?php echo $help_reward_removed; ?></div>
<div id="help_reward_add" style="display:none;"><?php echo $help_reward_add; ?></div>
<div id="help_discount" style="display:none;"><?php echo $help_discount; ?></div>
<div id="help_correct" style="display:none;"><?php echo $help_correct; ?></div>
<div id="help_recalculate" style="display:none;"><?php echo $help_recalculate; ?></div>
<div id="help_recalculate_bad" style="display:none;"><?php echo $help_recalculate_bad; ?></div>
<div id="help_commission_add" style="display:none;"><?php echo $help_commission_add; ?></div>
<div id="help_commission_remove" style="display:none;"><?php echo $help_commission_remove; ?></div>
<div id="help_virtual_customer" style="display:none;"><?php echo $help_virtual_customer; ?></div>
<?php if ($show_model || $show_sku || $show_upc || $show_ean || $show_jan || $show_isbn || $show_mpn || $show_location || $show_image) { ?>
<style>@media (max-width:1199px) {td.column-product{width:400px;}}</style>
<?php } ?>
<div id="shoverlay"><img src="view/image/load-line.gif" alt="" /></div>
<script type="text/javascript"><!--
$('.product-popap').live('click', function() {
	var imgsrc = $(this).attr('data-popap');
	$.colorbox({
		maxWidth: "85%",
		maxHeight: "85%",
		href: imgsrc
	});
});


$('#button-sms').click(function(e) {
	$.ajax({
		url: 'index.php?route=sale/order/sms&token=<?php echo $token; ?>&order_id=<?php echo $_GET["order_id"]; ?>',
		type: 'post',
		dataType: 'html',
		data: 'telephone=<?php echo $telephone; ?>&text=' + encodeURIComponent($('input[id=\'sms_customer\']').val()),
		success: function(html) {			
			alert('SMS успешно отправлено!');
		}
	});
});
$('#button-sms2').click(function(e) {
	$.ajax({
		url: 'index.php?route=sale/order/sms&token=<?php echo $token; ?>&order_id=<?php echo $_GET["order_id"]; ?>',
		type: 'post',
		dataType: 'html',
		data: 'telephone=<?php echo $telephone; ?>&text=' + encodeURIComponent($('input[id=\'sms_customer2\']').val()),
		success: function(html) {			
			alert('SMS успешно отправлено!');
		}
	});
});
						
					
$('input[name=\'firstname\']').blur(function() {
	var firstname = $('input[name=\'firstname\']').val();
	var shipping_firstname = $('input[name=\'shipping_firstname\']').val();
	$('input[name=\'payment_firstname\']').val(firstname);
	if(shipping_firstname.length < 1) {
	   $('input[name=\'shipping_firstname\']').val(firstname);
	}
});
$('input[name=\'lastname\']').blur(function() {
	var lastname = $('input[name=\'lastname\']').val();
	var shipping_lastname = $('input[name=\'shipping_lastname\']').val();
	$('input[name=\'payment_lastname\']').val(lastname);
	if(shipping_lastname.length < 1) {
	   $('input[name=\'shipping_lastname\']').val(lastname);
	}
});
$('input[name=\'payment_company\']').blur(function() {
	var payment_company = $('input[name=\'payment_company\']').val();
	$('input[name=\'shipping_company\']').val(payment_company);
});
$('input[name=\'shipping_address_1\']').blur(function() {
	var shipping_address_1 = $('input[name=\'shipping_address_1\']').val();
	$('input[name=\'payment_address_1\']').val(shipping_address_1);
});
$('input[name=\'shipping_address_2\']').blur(function() {
	var shipping_address_2 = $('input[name=\'shipping_address_2\']').val();
	$('input[name=\'payment_address_2\']').val(shipping_address_2);
});
$('input[name=\'shipping_city\']').blur(function() {
	var shipping_city = $('input[name=\'shipping_city\']').val();
	$('input[name=\'payment_city\']').val(shipping_city);
});
$('input[name=\'shipping_postcode\']').blur(function() {
	var shipping_postcode = $('input[name=\'shipping_postcode\']').val();
	$('input[name=\'payment_postcode\']').val(shipping_postcode);
});

$('#button-registered').bind('click', function() {
	$.ajax({
		url: 'index.php?route=sale/orderpro/createCustomer&token=<?php echo $token; ?>',
		type: 'post',
		data: $('#tab-payment :input, #tab-order :input'),
		dataType: 'json',
		success: function(json) {
			$('#notifications').html('');
			var html = '';
			if (json['error_warning']) {
					html += '';
					$.each(json['error_warning'], function(key, item) {
						html += '<div class="warning">' + item + '<img src="view/image/close16.png" alt="" class="close" /></div>';
					});
					$('#notifications').html(html);
			}
			if (json['success']) {
					html += '<div class="success">' + json['success'] + '<img src="view/image/close16.png" alt="" class="close" /></div>';
					$('#notifications').html(html);
					$('#button-registered').removeClass('btn-primary').addClass('btn-default').removeAttr('id');
					$('input[name=\'customer_id\']').attr('value', json['customer_id']);
					setTimeout ("$('.success').fadeOut('slow', function() {$(this).remove();});", 4000);
			}
		}
	});
});

var shipping_zone_id = '<?php echo $shipping_zone_id; ?>';

$('select[name=\'shipping_country_id\']').bind('change', function() {
	$('input[name=\'payment_country_id\']').val(this.value);
	$.ajax({
		url: 'index.php?route=sale/orderpro/country&token=<?php echo $token; ?>&country_id=' + this.value,
		dataType: 'json',
		beforeSend: function() {
			$('select[name=\'shipping_country_id\']').after('<span class="wait">&nbsp;<img src="view/image/loading.gif" alt="" /></span>');
		},
		complete: function() {
			$('.wait').remove();
		},			
		success: function(json) {
			if (json['postcode_required'] == '1') {
			}
			
			html = '<option value=""><?php echo $text_select; ?></option>';
			
			if (json != '' && json['zone'] != '') {
				for (i = 0; i < json['zone'].length; i++) {
        			html += '<option value="' + json['zone'][i]['zone_id'] + '"';
	    			
					if (json['zone'][i]['zone_id'] == shipping_zone_id) {
	      				html += ' selected="selected"';
	    			}
	
	    			html += '>' + json['zone'][i]['name'] + '</option>';
				}
			} else {
				html += '<option value="0" selected="selected"><?php echo $text_none; ?></option>';
			}
			
			$('select[name=\'shipping_zone_id\']').html(html);

		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('select[name=\'shipping_country_id\']').trigger('change');

$('select[name=\'shipping_zone_id\']').bind('change', function() {
	$('input[name=\'payment_zone_id\']').val(this.value);
});

$('select[name=\'shipping_zone_id\']').trigger('change');

$('select[name=\'shipping_address\']').bind('change', function() {
	$.ajax({
		url: 'index.php?route=sale/customer/address&token=<?php echo $token; ?>&address_id=' + this.value,
		dataType: 'json',
		success: function(json) {
			if (json != '') {	
				$('input[name=\'shipping_firstname\']').attr('value', json['firstname']);
				$('input[name=\'shipping_lastname\']').attr('value', json['lastname']);
				$('input[name=\'shipping_company\']').attr('value', json['company']);
				$('input[name=\'shipping_address_1\']').attr('value', json['address_1']);
				$('input[name=\'shipping_address_2\']').attr('value', json['address_2']);
				$('input[name=\'shipping_city\']').attr('value', json['city']);
				$('input[name=\'shipping_postcode\']').attr('value', json['postcode']);
				$('select[name=\'shipping_country_id\']').attr('value', json['country_id']);
				
				shipping_zone_id = json['zone_id'];
				
				$('select[name=\'shipping_country_id\']').trigger('change');

				$('input[name=\'payment_firstname\']').attr('value', json['firstname']);
				$('input[name=\'payment_lastname\']').attr('value', json['lastname']);
				$('input[name=\'payment_company\']').attr('value', json['company']);
				$('input[name=\'payment_company_id\']').attr('value', json['company_id']);
				$('input[name=\'payment_tax_id\']').attr('value', json['tax_id']);
				$('input[name=\'payment_address_1\']').attr('value', json['address_1']);
				$('input[name=\'payment_address_2\']').attr('value', json['address_2']);
				$('input[name=\'payment_city\']').attr('value', json['city']);
				$('input[name=\'payment_postcode\']').attr('value', json['postcode']);
				$('input[name=\'payment_country_id\']').attr('value', json['country_id']);
				$('input[name=\'payment_zone_id\']').attr('value', json['zone_id']);
			}
		}
	});	
});
//--></script> 
<script type="text/javascript"><!--
$.widget('custom.catcomplete', $.ui.autocomplete, {
	_renderMenu: function(ul, items) {
		var self = this, currentCategory = '';
		$.each(items, function(index, item) {
			if (item.category != currentCategory) {
				ul.append('<li class="ui-autocomplete-category">' + item.category + '</li>');
				currentCategory = item.category;
			}
			self._renderItem(ul, item);
		});
	}
});

$('input[name=\'coupon_id\']').autocomplete({
	delay: 500,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=sale/orderpro/couponAutocomplete&token=<?php echo $token; ?>&filter_name=' + encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item.name,
						value: item.code
					}
				}));
			}
		});
		
	}, 
	select: function(event, ui) {
		$(this).val(ui.item.value);
		return false;
	}
});

$('input[name=\'voucher_id\']').autocomplete({
	delay: 500,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=sale/orderpro/voucherAutocomplete&token=<?php echo $token; ?>&filter_name=' + encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item.name,
						value: item.code
					}
				}));
			}
		});
		
	}, 
	select: function(event, ui) {
		$(this).val(ui.item.value);
		return false;
	}
});

$('input[name=\'customer\']').catcomplete({
	delay: 500,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=sale/customer/autocomplete&token=<?php echo $token; ?>&filter_name=' + encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						category: item['customer_group'],
						label: item['name'],
						value: item['customer_id'],
						customer_group_id: item['customer_group_id'],
						firstname: item['firstname'],
						lastname: item['lastname'],
						email: item['email'],
						telephone: item['telephone'],
						fax: item['fax'],
						virtual_customer_id: item['virtual_customer_id'],
						address: item['address']
					}
				}));
			}
		});
	}, 
	select: function(event, ui) {
		$('input[name=\'customer\']').attr('value', ui.item['label']);
		$('input[name=\'customer_id\']').attr('value', ui.item['value']);
		$('input[name=\'firstname\']').attr('value', ui.item['firstname']);
		$('input[name=\'lastname\']').attr('value', ui.item['lastname']);
		$('input[name=\'email\']').attr('value', ui.item['email']);
		$('input[name=\'telephone\']').attr('value', ui.item['telephone']);
		$('input[name=\'fax\']').attr('value', ui.item['fax']);
		$('input[name=\'virtual_customer_id\']').attr('value', ui.item['virtual_customer_id']);
		html = '<option value="0"><?php echo $text_none; ?></option>'; 
			
		for (i in  ui.item['address']) {
			html += '<option value="' + ui.item['address'][i]['address_id'] + '">' + ui.item['address'][i]['firstname'] + ' ' + ui.item['address'][i]['lastname'] + ', ' + ui.item['address'][i]['zone'] + ', ' + ui.item['address'][i]['city'] + ', ' + ui.item['address'][i]['address_1'] + '</option>';
		}
		
		$('select[name=\'shipping_address\']').html(html);
		
		$('input[name=\'customer_group_id\']').attr('value', ui.item['customer_group_id']);
		controlReward();

		return false; 
	},
	focus: function(event, ui) {
      	return false;
   	}
});

$('input[name=\'affiliate\']').autocomplete({
	delay: 500,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=sale/affiliate/autocomplete&token=<?php echo $token; ?>&filter_name=' + encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item.name,
						value: item.affiliate_id
					}
				}));
			}
		});
	}, 
	select: function(event, ui) { 
		$('input[name=\'affiliate\']').attr('value', ui.item.label);
		$('input[name=\'affiliate_id\']').attr('value', ui.item.value);
			
		return false; 
	}
});
//--></script>
<script type="text/javascript"><!--
var product_row = <?php echo $product_row; ?>;

function addProduct(){
	html='<tbody id="product-row'+product_row+'">';
	html+=' <tr>';
	html+='  <td class="center"<?php echo $hide_pid; ?>><input type="text" name="order_product['+product_row+'][product_id]" value="" style="width:98%;" /></td>';
	html+='  <td class="center"<?php echo $hide_image; ?>><div class="product-image" id="image_'+product_row+'"></div></td>';
	html+='  <td class="center"><input type="text" name="order_product['+product_row+'][name]" value="" class="input-name" style="width:98%;" /><input type="hidden" name="order_product['+product_row+'][order_product_id]" value="" /><input type="hidden" name="order_product['+product_row+'][tax]" value="" /><input type="hidden" name="order_product['+product_row+'][status]" value="1" /><div id="product_options'+product_row+'"></div></td>';
	html+='  <td class="center"<?php echo $hide_model; ?>><input type="text" name="order_product['+product_row+'][model]" value="" class="input-model" style="width:98%;" /></td>';
	html+='  <td class="center"<?php echo $hide_sku; ?>><input type="text" name="order_product['+product_row+'][sku]" value="" class="input-sku" style="width:98%;" /></td>';
	html+='  <td class="center"<?php echo $hide_upc; ?>><input type="text" name="order_product['+product_row+'][upc]" value="" class="input-upc" style="width:98%;" /></td>';
	html+='  <td class="center"<?php echo $hide_ean; ?>><input type="text" name="order_product['+product_row+'][ean]" value="" class="input-ean" style="width:98%;" /></td>';
	html+='  <td class="center"<?php echo $hide_jan; ?>><input type="text" name="order_product['+product_row+'][jan]" value="" class="input-jan" style="width:98%;" /></td>';
	html+='  <td class="center"<?php echo $hide_isbn; ?>><input type="text" name="order_product['+product_row+'][isbn]" value="" class="input-isbn" style="width:98%;" /></td>';
	html+='  <td class="center"<?php echo $hide_mpn; ?>><input type="text" name="order_product['+product_row+'][mpn]" value="" class="input-mpn" style="width:98%;" /></td>';
	html+='  <td class="center"<?php echo $hide_location; ?>><input type="text" name="order_product['+product_row+'][location]" value="" class="input-location" style="width:98%;" /></td>';
	html+='  <td class="center"><input type="text" name="order_product['+product_row+'][quantity]" value="1" size="3" class="input-quantity" style="text-align:right;" /></td>';
	html+='  <td class="center"><span id="realquantity_'+product_row+'"></span></td>';
	html+='  <td class="right price'+product_row+' product-price"><input type="text" id="price_'+product_row+'" name="order_product['+product_row+'][price]" value="" class="input-price" /><img src="view/image/close14.png" class="price-empty cluetip-img" alt="" /></td>';
	html+='  <td class="right now_price"><span id="now_price_'+product_row+'"></span><span id="now_special_'+product_row+'" style="color:red;"></span><span id="now_discount_'+product_row+'" style="color:blue;"></span></td>';
	html+='  <td class="right total'+product_row+' product-total"><input type="text" id="total_'+product_row+'" name="order_product['+product_row+'][total]" value="" style="text-align:right;width:99%;" class="onlyread" readonly /></td>';
	html+='  <td class="right product-discount" nowrap><input type="text" name="order_product['+product_row+'][discount_amount]" value="" /> ';
	html+='   <select name="order_product['+product_row+'][discount_type]">';
	html+='    <option value="P" selected="selected">%</option>';
	html+='    <option value="S">S</option>';
	html+='   </select><img src="view/image/close14.png" class="amount-empty cluetip-img" alt="" /></td>';
	html+='  <td class="right reward'+product_row+' product-reward"<?php echo $hide_reward; ?>><input type="text" id="reward_'+product_row+'" name="order_product['+product_row+'][reward]" value="" style="text-align:right;width:99%;" class="onlyread" readonly /></td>';
	html+='  <td class="center premove"><a onclick="$(\'#product-row'+product_row+'\').remove();" class="button-remove"></a></td>';
	html+=' </tr>';
	html+='</tbody>';
	
	$("#product tfoot").before(html);
	
	product_autocomplete(product_row);
	product_row++;
}

function product_autocomplete(product_row) {
	$('input[name=\'order_product[' + product_row + '][product_id]\'], input[name=\'order_product[' + product_row + '][name]\'], input[name=\'order_product[' + product_row + '][model]\'], input[name=\'order_product[' + product_row + '][sku]\'], input[name=\'order_product[' + product_row + '][upc]\'], input[name=\'order_product[' + 
	product_row + '][ean]\'], input[name=\'order_product[' + product_row + '][jan]\'], input[name=\'order_product[' + product_row + '][isbn]\'], input[name=\'order_product[' + product_row + '][mpn]\'], input[name=\'order_product[' + product_row + '][location]\']').autocomplete({
		delay: 500,
		source: function(request, response) {
			var requested = $(this.element).attr('class');
			$.ajax({
				url: 'index.php?route=sale/orderpro/productAutocomplete&token=<?php echo $token; ?>',
				dataType: 'json',
                data: {
					filter_pid: $('input[name=\'order_product[' + product_row + '][product_id]\']').val(),
                    filter_name: $('input[name=\'order_product[' + product_row + '][name]\']').val(),
                    filter_model: $('input[name=\'order_product[' + product_row + '][model]\']').val(),
					filter_sku: $('input[name=\'order_product[' + product_row + '][sku]\']').val(),
					filter_upc: $('input[name=\'order_product[' + product_row + '][upc]\']').val(),
					filter_ean: $('input[name=\'order_product[' + product_row + '][ean]\']').val(),
					filter_jan: $('input[name=\'order_product[' + product_row + '][jan]\']').val(),
					filter_isbn: $('input[name=\'order_product[' + product_row + '][isbn]\']').val(),
					filter_mpn: $('input[name=\'order_product[' + product_row + '][mpn]\']').val(),
					filter_location: $('input[name=\'order_product[' + product_row + '][location]\']').val(),
					customer_group_id: $('input[name=\'customer_group_id\']').val()
                },
				success: function(data) {
					response($.map(data, function(item) {
						if(requested == 'input-model'){
                            var requested_label = item.model;
                        } else if(requested == 'input-sku') {
                            var requested_label = item.sku;
						} else {
                            var requested_label = item.name;
                        }
						return {
							label: requested_label,
                            name: item.name,
							value: item.product_id,
							image: item.image,
							popap: item.popap,
							href: item.href,
							model: item.model,
							sku: item.sku,
							upc: item.upc,
							ean: item.ean,
							jan: item.jan,
							isbn: item.isbn,
							mpn: item.mpn,
							location: item.location,
							price: item.price,
							quantity: item.quantity,
							reward: item.reward,
							special: item.special,
							discount: item.discount,
							discount_qty: item.discount_qty,
                            option: item.option
						}
					}));
				}
			});
		},
        
		complete: function() {
			controlReward();
		},
		
		select: function(event, ui) {
			$('input[name=\'order_product[' + product_row + '][product_id]\']').attr('value', ui.item.value);
			$('input[name=\'order_product[' + product_row + '][name]\']').attr('value', ui.item.name);
			$('input[name=\'order_product[' + product_row + '][model]\']').attr('value', ui.item.model);
			$('input[name=\'order_product[' + product_row + '][sku]\']').attr('value', ui.item.sku);
			$('input[name=\'order_product[' + product_row + '][upc]\']').attr('value', ui.item.upc);
			$('input[name=\'order_product[' + product_row + '][ean]\']').attr('value', ui.item.ean);
			$('input[name=\'order_product[' + product_row + '][jan]\']').attr('value', ui.item.jan);
			$('input[name=\'order_product[' + product_row + '][isbn]\']').attr('value', ui.item.isbn);
			$('input[name=\'order_product[' + product_row + '][mpn]\']').attr('value', ui.item.mpn);
			$('input[name=\'order_product[' + product_row + '][location]\']').attr('value', ui.item.location);
			$('input[name=\'order_product[' + product_row + '][price]\']').attr('value', parseFloat(ui.item.price).toFixed(2));
			$('#now_price_' + product_row).html(parseFloat(ui.item.price).toFixed(2));
			$('#now_special_' + product_row).html(parseFloat(ui.item.special).toFixed(2));
			$('#now_discount_' + product_row).html(ui.item.discount_qty + '/' + parseFloat(ui.item.discount).toFixed(2));
			$('#realquantity_' + product_row).html(ui.item.quantity);
			$('#image_' + product_row).html('<a href="'+ ui.item.href +'" target="_blank"><img src="'+ ui.item.image +'" alt="'+ ui.item.name +'"></a>');
			if (ui.item.popap) {
				$('#image_' + product_row).append('<span id="popap_'+ product_row +'"></span>');
				$('#popap_' + product_row).addClass('product-popap').attr('data-popap', ui.item.popap);
			}
            $('input[name=\'order_product[' + product_row + '][reward]\']').attr('value', ui.item.reward);

            if (ui.item['option'] != '') {
				html = '<div class="poptions">';
	
				for (i = 0; i < ui.item['option'].length; i++) {
					option = ui.item['option'][i];
					
					if (option['type'] == 'select' || option['type'] == 'radio' || option['type'] == 'image') {
						html += '<div class="option">';
						
						if (option['required'] == '1') {
							html += '<span class="required">*</span>';
						}
					
						html += option['name'] + '<br />';
						html += '<select name="order_product[' + product_row + '][option][' + option['product_option_id'] + ']">';
					
                        if (option['required'] == '0') {
							html += '<option value=""><?php echo $text_select; ?></option>';
						}

						for (j = 0; j < option['option_value'].length; j++) {
							option_value = option['option_value'][j];
							
							html += '<option value="' + option_value['product_option_value_id'] + '">' + option_value['name'];
							
							if (option_value['price']) {
								html += ' (' + option_value['price_prefix'] + option_value['price'] + ')';
							}
							
							html += '</option>';
						}
							
						html += '</select>';
						html += '</div>';
						html += '<br />';
					}

                    if (option['type'] == 'checkbox') {
						html += '<div>';
						
						if (option['required'] == '1') {
							html += '<span class="required">*</span>';
						}
						
						html += option['name'] + '<br />';
						
						for (j = 0; j < option['option_value'].length; j++) {
							option_value = option['option_value'][j];
							
							html += '<input type="checkbox" name="order_product[' + product_row + '][option][' + option['product_option_id'] + '][]" value="' + option_value['product_option_value_id'] + '" id="option-value-' + product_row + '-' + option_value['product_option_value_id'] + '" />';
							html += '<label for="option-value-' + product_row + '-' + option_value['product_option_value_id'] + '">' + option_value['name'];
							
							if (option_value['price']) {
								html += ' (' + option_value['price_prefix'] + option_value['price'] + ')';
							}
							
							html += '</label>';
							html += '<br />';
						}
						
						html += '</div>';
						html += '<br />';
					}

                    if (option['type'] == 'text') {
						html += '<div>';
						
						if (option['required'] == '1') {
							html += '<span class="required">*</span>';
						}
						
						html += option['name'] + '<br />';
						html += '<input type="text" name="order_product[' + product_row + '][option][' + option['product_option_id'] + ']" value="' + option['option_value'] + '" />';
						html += '</div>';
						html += '<br />';
					}
					
					if (option['type'] == 'textarea') {
						html += '<div>';
						
						if (option['required'] == '1') {
							html += '<span class="required">*</span>';
						}
						
						html += option['name'] + '<br />';
						html += '<textarea name="order_product[' + product_row + '][option][' + option['product_option_id'] + ']" cols="40" rows="5">' + option['option_value'] + '</textarea>';
						html += '</div>';
						html += '<br />';
					}
					
					if (option['type'] == 'file') {
						html += '<div>';
						
						if (option['required'] == '1') {
							html += '<span class="required">*</span> ';
						}
						
						html += option['name'] + '<br />';
						
						html += '<a id="file-link-' + option['product_option_id'] + '-' + product_row + '" class="file-link" style="display:none;"></a>';
						html += '<a id="button-option-' + option['product_option_id'] + '-' + product_row + '" class="btn btn-primary"><?php echo $button_upload; ?></a>';
						html += '<input type="hidden" name="order_product[' + product_row + '][option][' + option['product_option_id'] + ']" value="' + option['option_value'] + '" />';
						html += '</div>';
						html += '<br />';
					}

					if (option['type'] == 'date') {
						html += '<div>';
						
						if (option['required'] == '1') {
							html += '<span class="required">*</span>';
						}
						
						html += option['name'] + '<br />';
						html += '<input type="text" name="order_product[' + product_row + '][option][' + option['product_option_id'] + ']" value="' + option['option_value'] + '" class="date" />';
						html += '</div>';
						html += '<br />';
					}
					
					if (option['type'] == 'datetime') {
						html += '<div>';
						
						if (option['required'] == '1') {
							html += '<span class="required">*</span>';
						}
						
						html += option['name'] + '<br />';
						html += '<input type="text" name="order_product[' + product_row + '][option][' + option['product_option_id'] + ']" value="' + option['option_value'] + '" class="datetime" />';
						html += '</div>';
						html += '<br />';						
					}
					
					if (option['type'] == 'time') {
						html += '<div>';
						
						if (option['required'] == '1') {
							html += '<span class="required">*</span>';
						}
						
						html += option['name'] + '<br />';
						html += '<input type="text" name="order_product[' + product_row + '][option][' + option['product_option_id'] + ']" value="' + option['option_value'] + '" class="time" />';
						html += '</div>';
						html += '<br />';						
					}
				}
				
				html += '</div>';
				
				$('#product_options' + product_row).empty().append(html);

				for (i = 0; i < ui.item['option'].length; i++) {
					option = ui.item['option'][i];

					if (option['type'] == 'file') {
						var upbtn = $('#button-option-' + option['product_option_id'] + '-' + product_row);
						var uplnk = $('#file-link-' + option['product_option_id'] + '-' + product_row);
						var upipt = $('input[name=\'order_product[' + product_row + '][option][' + option['product_option_id'] + ']\']');
						
						new AjaxUpload('#button-option-' + option['product_option_id'] + '-' + product_row, {
							action: 'index.php?route=sale/orderpro/upload&token=<?php echo $token; ?>',
							name: 'file',
							autoSubmit: true,
							responseType: 'json',
							onSubmit: function(file, extension) {
								upbtn.after('<img src="view/image/loading.gif" class="loading" />');
							},
							onComplete: function(file, json) {
								$('.success, .error, .warning').remove();
								
								if (json['success']) {
									$('#notifications').html('<div class="success">' + json['success'] + '<img src="view/image/close16.png" alt="" class="close" /></div>');
									setTimeout ("$('.success').fadeOut('slow', function() {$(this).remove();});", 3000);
									uplnk.empty().append(json['filename']).show('fast');
									upipt.attr('value', json['file']);
								}
								
								if (json.error) {
									$('#notifications').html('<div class="warning">' + json['error'] + '<img src="view/image/close16.png" alt="" class="close" /></div>');
								}
								$('.loading').remove();
							}
						});
					}

				}
				
			} else {
				$('#product_options' + product_row).empty();
			}

			return false;
		}
	});
}

$('#product tbody').each(function(index, element) {
	product_autocomplete(index);
});
//--></script>
<script type="text/javascript"><!--
var old_order_status_id = '<?php echo $order_status_id; ?>';
var order_id = '<?php echo $order_id; ?>';

$('select[id=\'order_status_id\']').live('change', function() {
	var new_order_status_id = this.value;
	
	if (old_order_status_id != new_order_status_id) {
		$.ajax({
			url: 'index.php?route=sale/orderpro/history&token=<?php echo $token; ?>&order_id=<?php echo (empty($order_id)) ? $temp_order_id: $order_id; ?>',
			type: 'post',
			dataType: 'html',
			data: 'order_status_id=' + new_order_status_id + '&notify=0&comment=',
			beforeSend: function() {
				$('.success, .warning').remove();
			},
			complete: function() {
				$('.attention').remove();
			},
			success: function(html) {
				$('#history').html(html);
				$('textarea[name=\'admin_comment\']').val('');
				$('select[id=\'horder_status_id\']').val(new_order_status_id);
				$('#notifications').html('<div class="success"><?php echo $success_order_history; ?><img src="view/image/close16.png" alt="" class="close" /></div>');
				setTimeout ("$('.success').fadeOut('slow', function() {$(this).remove();});", 3000);
				old_order_status_id = new_order_status_id;
			}
		});
	}
});

/*$('select[id=\'order_status_id\']').trigger('change');*/

function recalculate() {
            var lang = $('select[name=\'language\']').val();
            $('.no_calc').each(function () {
				if (this.checked) {
					$(this).val('1');
				}
            });
			$('.success, .attention, .warning').remove();
			$("#shoverlay").show();
            $.ajax({
				url: 'https://s-energia.com.ua/index.php?route=checkout/recalculate&token=<?php echo $token; ?>&language=' + lang + '&order_id=<?php echo (empty($order_id)) ? $temp_order_id: $order_id; ?>',
				type: 'POST',
				dataType: 'html',
				data: $('#tab-order :input, #tab-payment :input, #product :checked, #product input:hidden, #product input:text, .option :input, .product-discount :input, #order-reward :input, #order-affiliate :input, #payment_shipping :input, #total :input'),
				complete: function() {
					$('#shoverlay').hide();
				},
				success: function(json) {
					$('.autocomplete div').remove();
					var obj = jQuery.parseJSON(json);
					
					if (!obj.error) {
						var row = 0;
						var html = $('#total thead').html();
						var tfoot = $('#total tfoot').html();
						var button_remove = '<?php echo $button_remove; ?>';
						html = '<thead>' + html + '</thead>';

						$.each(obj.order_total, function(key, value) {
								html += '<tbody id="total-row' + row + '">';
								html += '    <tr>';
								html += '        <td class="center total-title">';
								html += '            <input type="hidden" value="0" name="order_total[' + row + '][order_total_id]">';
								html += '            <input type="hidden" value="' + value.code + '" name="order_total[' + row + '][code]">';
								html += '            <input type="text" value="' + value.title + '" name="order_total[' + row + '][title]" style="width:98%">';
								html += '        </td>';
								html += '        <td class="right total-value">';
								html += '            <input type="hidden" value="' + value.text + '" name="order_total[' + row + '][text]">';
								if ((value.code == 'sub_total') || (value.code == 'total')) {
									html += '            <input type="hidden" value="' + parseFloat(value.value).toFixed(2) + '" name="order_total[' + row + '][value]">';
								} else {
									html += '            <input type="text" value="' + parseFloat(value.value).toFixed(2) + '" name="order_total[' + row + '][value]">';
								}
								html += '        </td>';
								html += '        <td class="right total-text">';
								html +=  value.text;
								html += '        </td>';
								html += '        <td class="center total-nocalc">';
								if (value.code == 'shipping') {
									html += '            <input class="no_calc" type="checkbox" name="' + value.code + '" value="0" checked="checked" />';
								} else {
									html += '            <input class="no_calc" type="checkbox" name="' + value.code + '" value="0" />';
								}
								html += '        </td>';
								html += '        <td class="center total-sort">';
								if (value.correct) { value.code = 'correct'; }
								if ((value.code == 'discount') || (value.code == 'correct')) {
									html += '            <input type="hidden" value="' + value.sort_order + '" name="order_total[' + row + '][sort_order]">';
								} else {
									html += '            <input type="text" style="width:30px; text-align:center;" value="' + value.sort_order + '" name="order_total[' + row + '][sort_order]">';
								}
								html += '        </td>';
								html += '        <td class="right total-delete">';
								if ((value.code == 'discount') || (value.code == 'correct')) {
									html += '            <a class="btn btn-danger" onclick="$(\'#total-row' + row + '\').remove();$(\'.' + value.code + ' .tbutton\').css(\'display\',\'block\');">' + button_remove + '</a>';
								} else {
									html += '            <a class="btn btn-danger" onclick="$(\'#total-row' + row + '\').remove();">' + button_remove + '</a>';
								}
								html += '        </td>';
								html += '    </tr>';
								html += '</tbody>';

								row++;
						});

						if (obj.commission) {
							$('input[name=\'commission\']').attr('value', obj.commission.value);
							$('#commission span').html(obj.commission.text);
						}

						html = html + '<tfoot>' + tfoot + '</tfoot>';
						$('#total').unbind().html(html);
						$('#total .cluetip-img').cluetip();

						$.each(obj.del_product_rows, function(key, prod_row) {
							$('#product-row' + prod_row).remove();
						});

						var reward_cart = 0;
						$.each(obj.order_product, function(prod_row, value) {
							if (value.discount) {
								var name_value = $('input[name=\'order_product[' + prod_row + '][name]\']');
								var name_explode = $(name_value).val().split(' |');
								$(name_value).attr('value', name_explode[0] + ' <?php echo $text_discount; ?> ' + value.discount);
							} else {
								$('input[name=\'order_product[' + prod_row + '][name]\']').attr('value', value.name);
							}
							$('input[name=\'order_product[' + prod_row + '][quantity]\']').attr('value', value.quantity);
							$('input[name=\'order_product[' + prod_row + '][tax]\']').attr('value', value.tax);
							$('input[name=\'order_product[' + prod_row + '][total]\']').attr('value', value.total);
							$('input[name=\'order_product[' + prod_row + '][price]\']').attr('value', value.price);
							$('input[name=\'order_product[' + prod_row + '][reward]\']').attr('value', value.reward);
							reward_cart += value.reward;
						});

						if (obj.warning_reward) {
							$('#rewards-available span').html(obj.warning_reward);
						}

						if ($('input[name=\'customer_id\']').val() != ''){
							$('input[name=\'reward_cart\']').attr('value', reward_cart);
						}
						
						if (obj.warning) {
							var html = '';
							$.each(obj.warning, function(key, value) {
								html += '<div class="attention">' + value + '<img src="view/image/close16.png" alt="" class="close" /></div>';
							});
							
							$('.message').append(html);
						}
						
						if ($('input[name=\'customer_id\']').val() != ''){
							controlReward();
						}
							
					} else {
						
						var html = '';
						$.each(obj.error, function(key, value) {
							html += '<div class="warning">' + value + '<img src="view/image/close16.png" alt="" class="close" /></div>';
						});
					
						$('.message').append(html);
					}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
	});
}

function controlReward() {
    var customer_id = $('input[name=\'customer_id\']').val();
    var customer_group_id = $('input[name=\'customer_group_id\']').val();
    $.ajax({
        url: '/index.php?route=checkout/recalculate/controlReward&token=<?php echo $token; ?>&order_id=<?php echo (empty($order_id)) ? $temp_order_id: $order_id; ?>&customer_id=' + encodeURIComponent(customer_id) + '&customer_group_id=' + encodeURIComponent(customer_group_id),
        type: 'POST',
        dataType: 'json',
        data: $('#product :checked, #product input:hidden, #product input:text, .option :input'),
        success: function(json) {
			if (json.error) {
				$('#notifications').html('<div class="warning">' + json.error + '<img src="view/image/close16.png" alt="" class="close" /></div>');

			} else {
				var reward_use = Number($('input[name=\'reward_use\']').val());

				if (reward_use <= json.reward_possibly) {
					$('#rewards-available span').html('<?php echo $entry_reward_max; ?>' + json.reward_possibly);
				} else {
					$('#rewards-available span').html('<span style="color:red;"><?php echo $entry_reward_max; ?>' + json.reward_possibly + '</span>');
					$('input[name=\'reward_use\']').val(json.reward_possibly);
				}
				
				$('#reward-total span.rtotal').html(json.reward_total);
				$('#reward-total span.ptotal').html(json.reward_possibly);
				$('input[name=\'reward_cart\']').attr('value', json.reward_cart);
			}
        }
  });
}

$('input[name=\'reward_use\']').blur(function () {
    controlReward();
});

$(document).ready(function() {
    controlReward();
});
//--></script>
<script type="text/javascript"><!--
function addTotal(type, title) {
	var row = 0;
	var html = $('#total thead').html();
	var tfoot = $('#total tfoot').html();
	var button_remove = '<?php echo $button_remove; ?>';
	html = '<thead>' + html + '</thead>';
	
	$('#total tbody').each(function(index) {
		html += '<tbody id="total-row' + row + '">';
		html += $(this).html();
		html += '</tbody>';
		row++;
	});

		html += '<tbody id="total-row' + row + '">';
		html += '    <tr>';
		html += '        <td class="center total-title">';
		html += '            <input type="hidden" value="' + type + '" name="order_total[' + row + '][code]">';
		html += '            <input type="text" value="' + title + '" name="order_total[' + row + '][title]" style="width:98%;">';
		html += '            <input type="hidden" name="' + type + '" value="1" />';
		html += '        </td>';
		html += '        <td class="right">';
		html += '            <input type="text" value="" name="order_total[' + row + '][value]">';
		html += '        </td>';
		html += '        <td class="right">';
		html += '            <input type="hidden" value="" name="order_total[' + row + '][text]">';
		html += '        </td>';
		if (type == 'correct') {
			html += '        <td class="center" colspan="2">';
			html += '         <?php echo $entry_tax; ?><select name="order_total[' + row + '][tax_class_id]" class="select-correct">';
			html += '          <option value="0"><?php echo $text_none; ?></option>';
				<?php foreach ($tax_classes as $tax_class) { ?>
					html += '      <option value="<?php echo $tax_class['tax_class_id']; ?>"><?php echo $tax_class['title']; ?></option>';
				<?php } ?>
			html += '         </select>';
			html += '        </td>';						
		} else {
			html += '        <td class="center">';
			html += '        </td>';
			html += '        <td class="center">';
			html += '            <input type="hidden" value="2" name="order_total[' + row + '][sort_order]">';
			html += '        </td>';
		}
		html += '        <td class="right">';
		html += '            <a class="btn btn-danger" onclick="$(\'#total-row' + row + '\').remove();$(\'.' + type + ' .tbutton\').css(\'display\',\'block\');"><span>' + button_remove + '</span></a>';
		html += '        </td>';
		html += '    </tr>';
		html += '</tbody>';
		
		html = html + '<tfoot>' + tfoot + '</tfoot>';
		$('#total').unbind().html(html);
		$('#total .cluetip-img').cluetip();
		
		$('.' + type + ' .tbutton').css('display','none');
}

function addDiscount() {
    addTotal('discount', '<?php echo $entry_discount; ?>');
}

function addCorrect() {
    addTotal('correct', '<?php echo $entry_correct; ?>');
}

function clone_order() {
    $('#clone').attr('value', '1');
	$('#form').submit();
}

<?php if ($customer_id && $reward_status) { ?>
$('#reward-add').bind('click', function() {
	$('.success, .warning').remove();
	$("#shoverlay").show();
	$.ajax({
		url: 'index.php?route=sale/orderpro/addOrderReward&token=<?php echo $token; ?>&order_id=<?php echo (empty($order_id)) ? $temp_order_id: $order_id; ?>',
		type: 'POST',
		dataType: 'json',
		data: $('#tab-order :input, #order-reward :input'),
		success: function(json) {
			$("#shoverlay").hide();
			if (json.error) {
				$('#notifications').html('<div class="warning">' + json.error + '<img src="view/image/close16.png" alt="" class="close" /></div>');
			}
			if (json.success) {
				$('#reward-recived span').html(json.reward_total);
				$('#notifications').html('<div class="success">' + json.success + '<img src="view/image/close16.png" alt="" class="close" /></div>');
				setTimeout ("$('.success').fadeOut('slow', function() {$(this).remove();});", 3000);
				controlReward();
			}
		}
	});
});

$('#reward-remove').bind('click', function() {
	$('.success, .warning').remove();
	$("#shoverlay").show();
	$.ajax({
		url: 'index.php?route=sale/orderpro/removeOrderReward&token=<?php echo $token; ?>&order_id=<?php echo (empty($order_id)) ? $temp_order_id: $order_id; ?>',
		dataType: 'json',
		success: function(json) {
			$("#shoverlay").hide();
			if (json.error) {
				$('#notifications').html('<div class="warning">' + json.error + '<img src="view/image/close16.png" alt="" class="close" /></div>');
			}
			if (json.success) {
                $('#reward-recived span').html('0');
				$('#notifications').html('<div class="success">' + json.success + '<img src="view/image/close16.png" alt="" class="close" /></div>');
				setTimeout ("$('.success').fadeOut('slow', function() {$(this).remove();});", 3000);
                controlReward();
			}
		}
	});
});
<?php } ?>
<?php if ($order_id) { ?>
$('#commission_add').bind('click', function() {
	$('.success, .warning').remove();
	$("#shoverlay").show();
	$.ajax({
		url: 'index.php?route=sale/orderpro/addCommission&token=<?php echo $token; ?>&order_id=<?php echo $order_id; ?>',
		dataType: 'json',
		success: function(json) {
			$("#shoverlay").hide();
			if (json.error) {
				$('#notifications').html('<div class="warning">' + json.error + '<img src="view/image/close16.png" alt="" class="close" /></div>');
			}
			if (json.success) {
				$('#notifications').html('<div class="success">' + json.success + '<img src="view/image/close16.png" alt="" class="close" /></div>');
				setTimeout ("$('.success').fadeOut('slow', function() {$(this).remove();});", 3000);
				$('#commission_add').fadeOut();
				$('#commission_remove').fadeIn();
				$('#commission .cluetip-img').cluetip();
			}
		}
	});
});

$('#commission_remove').bind('click', function() {
	$('.success, .warning').remove();
	$("#shoverlay").show();
	$.ajax({
		url: 'index.php?route=sale/orderpro/removeCommission&token=<?php echo $token; ?>&order_id=<?php echo $order_id; ?>',
		dataType: 'json',
		success: function(json) {
			$("#shoverlay").hide();
			if (json.error) {
				$('#notifications').html('<div class="warning">' + json.error + '<img src="view/image/close16.png" alt="" class="close" /></div>');
			}
			if (json.success) {
				$('#notifications').html('<div class="success">' + json.success + '<img src="view/image/close16.png" alt="" class="close" /></div>');
				setTimeout ("$('.success').fadeOut('slow', function() {$(this).remove();});", 3000);
				$('#commission_remove').fadeOut();
				$('#commission_add').fadeIn();
				$('#commission .cluetip-img').cluetip();
			}
		}
	});
});

$('#history').load('index.php?route=sale/orderpro/history&token=<?php echo $token; ?>&order_id=<?php echo $order_id; ?>');
<?php } ?>

$('#history .pagination a').live('click', function() {
	var way = $(this).attr('href');
	$('#history').load(way);
	return false;
});

$('#button-history').live('click', function() {
	var new_hstatus_order_id = $('select[id=\'horder_status_id\']').val();
	$.ajax({
		url: 'index.php?route=sale/orderpro/history&token=<?php echo $token; ?>&order_id=<?php echo (empty($order_id)) ? $temp_order_id: $order_id; ?>',
		type: 'post',
		dataType: 'html',
		data: 'order_status_id=' + encodeURIComponent($('select[id=\'horder_status_id\']').val()) + '&notify=' + encodeURIComponent($('input[name=\'notify\']').attr('checked') ? 1 : 0) + '&append=' + encodeURIComponent($('input[name=\'append\']').attr('checked') ? 1 : 0) + '&comment=' + encodeURIComponent($('textarea[name=\'admin_comment\']').val()),
		beforeSend: function() {
			$('.success, .warning').remove();
			$('#button-history').attr('disabled', true);
			$('#history').prepend('<div class="attention"><img src="view/image/loading.gif" alt="" /> <?php echo $text_wait; ?></div>');
		},
		complete: function() {
			$('#button-history').attr('disabled', false);
			$('.attention').remove();
		},
		success: function(html) {
			$('#history').html(html);
			$('textarea[name=\'admin_comment\']').val('');
			$('select[id=\'order_status_id\']').val(new_hstatus_order_id);
		}
	});
});

//--></script>
<script type="text/javascript" src="view/javascript/jquery/ui/jquery-ui-timepicker-addon.js"></script> 
<script type="text/javascript"><!--
$('#save-setting').bind('click', function() {
	$.ajax({
		url: 'index.php?route=sale/orderpro/saveSetting&token=<?php echo $token; ?>',
		type: 'post',
		data: $('#order-setting input:text, #order-setting input:checked'),
		dataType: 'json',
		beforeSend: function() {
			$('#save-setting').attr('disabled', true);
		},
		complete: function() {
			$('#save-setting').attr('disabled', false);
		},
		success: function(json) {
			$('.success, .warning, .error').remove();
			if (json['error']) {
					$('#notifications').html('<div class="warning">' + json['error'] + '<img src="view/image/close16.png" alt="" class="close" /></div>');
			}
			if (json['success']) {
					$('#notifications').html('<div class="success">' + json['success'] + '<img src="view/image/close16.png" alt="" class="close" /></div>');
					setTimeout ("$('.success').fadeOut('slow', function() {$(this).remove();});", 3000);
			}
		}
	});
});

$('#empty-prices').bind('click', function() {
    $('.product-price input').attr('value', '');
});

$('.price-empty').live('click', function() {
    $(this).parent().find('.input-price').attr('value', '');
});

$('#empty-discounts').bind('click', function() {
    $('.product-discount input').attr('value', '');
});

$('.amount-empty').live('click', function() {
    $(this).parent().find('.input-amount').attr('value', '');
});

$('.date').live('mouseenter', function() {
    $(this).click().datepicker({dateFormat: 'yy-mm-dd'});
});
$('.datetime').live('mouseenter', function() {
    $(this).click().datetimepicker({
		dateFormat: 'yy-mm-dd',
		timeFormat: 'h:m'
    });
});
$('.time').live('mouseenter', function() {
    $(this).click().timepicker({timeFormat: 'h:m'});
});

$('img.close').live('click', function() {
	$(this).parent().parent().find('.success, .attention, .warning').fadeOut('slow', function() {$(this).remove();});
});

$('.cluetip-img').cluetip();
$('.vtabs a').tabs();
$('.htabs a').tabs();
//--></script>
<?php echo $footer; ?>