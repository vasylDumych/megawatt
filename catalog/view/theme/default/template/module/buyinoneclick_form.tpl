<div class="buyinoneclick">
	<h1 class="buyinoneclick-title"><?php echo $heading_title; ?></h1>
	<?php if($stock_status) { ?>
			<div align="center">
				<div class="buyinoneclick-product">
					<?php if ($product_img) { ?>
					<img src="image/<?php echo $product_img; ?>" class="buyinoneclick-img" />
					<?php } else { ?>
					<img src="image/no_image.jpg" style="width:30%;float:left;" alt="" title="" />
					<?php } ?>
					<h4><?php echo $product_name; ?></h4>
					<div class="clearfix"></div>
					
					<div class="buyinoneclick-plabel"><?php echo $entry_price; ?></div><span class="price_gs"><?php echo $product_price; ?></span><div class="currency"><?php echo $this_tax; ?></div><br><br>
					<div class="buyinoneclick-plabel"><?php echo $entry_qty; ?></div><input type="text" name="quantity_gs" class="quantity_gs" value="1" onChange="ChangeQty();" /><br><br>
					<div class="buyinoneclick-plabel"><?php echo $entry_total; ?></div><span class="total_gs"><?php echo $product_price; ?></span><div class="currency"><?php echo $this_tax; ?></div>
				</div>
				<div class="buyinoneclick-form">
					<div class="buyinoneclick-label"><?php echo $entry_name; ?></div>
					<input type="text" name="buyinoneclick_name" value="<?php echo $customer_firstname; ?>" /><br><br>
					<div class="buyinoneclick-label"><?php echo $entry_contact; ?></div>
					<?php if($phone_text) { ?>
					<span><?php echo $phone_text; ?></span>
					<?php } ?>
					<input type="text" name="buyinoneclick_contact" value="" data-phone-mask="<?php echo $phone_mask; ?>" palceholder="" /><br><br>
					<br class="contact_error" />
					<?php if(isset($error_warning)) { ?>
					<div class="warning"><?php echo $error_warning; ?></div>
					<?php } ?>
				</div>
			</div>
			<br />
			<div class="buttons">
				<div class="right"><a class= "button buyinoneclick-send" data-wait="<?php echo $text_wait; ?>"><?php echo $button_send; ?></a></div>
			</div>
	<?php } else { ?>
		<?php echo $outstock; ?>
	<?php } ?>
</div>

<script>
function ChangeQty(){
	price = $(".price_gs").html();
	qty = $(".quantity_gs").val();
	total = parseFloat(price)*parseFloat(qty);
	$(".total_gs").html(Math.floor(total*100)/100);
}
</script>