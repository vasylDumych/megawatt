 <div id="cartpopup" class="well">
    <h4><i class="icon_success_27x27"></i><span id="text-added"></span> <?php echo $text_in_cart; ?></h4>
	<span class="cart-header">Корзина  покупок</span> <span class="cart-total"></span>
    <div class="cart"></div>
   <?php 
   $isRu = strpos($_SERVER['REQUEST_URI'], '/ru') === 0 ? '/ru' : '';
   $checkout_url = "location='$isRu/shopping-cart/'"; ?>
   <button class="btn btn-default" style="float: left" onclick="<?php echo $checkout_url ?>"><?php echo $text_view_cart_n_checkout; ?></button>&nbsp;
   <button class="btn btn-default" style="float: right" onclick="$('#cartpopup').popup('hide')"><?php echo $text_continue_shopping; ?></button>
  </div>

<script type="text/javascript">
//<![CDATA[

function declination(s) {
	var words = ['<?php echo $text_product_5; ?>', '<?php echo $text_product_1; ?>', '<?php echo $text_product_2; ?>'];
	var index = s % 100;
	if (index >=11 && index <= 14) { 
		index = 0; 
	} else { 
		index = (index %= 10) < 5 ? (index > 2 ? 2 : index): 0; 
	}
	return(words[index]);
}
$(document).ready(function () {
    $('#cartpopup').popup();
});
//]]> 
</script>