<?php if ($products){ ?>
<div class="box" style="margin: 25px 0 0 0;">
    <div class="box-heading similarproducts"><?php echo $heading_title; ?></div>
    <div class="box-content2">
        <div class="box-product">
			<div id="owl-demo3" class="owl-carousel owl-theme">
				<?php foreach ($products as $product) { ?>
				<div class="slideitem">
					<?php if ($product['thumb']) { ?>
					<div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" /></a></div>
					<?php } ?>
					<div class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
					<?php if ($product['price']) { ?>
						<div class="priceblock">        
								<div class="btncart"><a onclick="addToCart('<?php echo $product['product_id']; ?>');" class="button"><span><?php echo $button_cart; ?></span></a></div>
								<div class="priceitem">		
									<?php if ($product['price']) { ?>
									<div class="price">
									  <?php if (!$product['special']) { ?>
									  <?php echo $product['price']; ?>
									  <?php } else { ?>
										<span class="price-old"><?php echo $product['price']; ?></span><br><span class="price-new"><?php echo $product['special']; ?></span>
									  <?php } ?>
									</div>
									<?php } ?>
								</div>
						</div>	
					<?php } ?>
					
				</div>
				<?php } ?>
			</div>
        </div>
    </div>
</div>
<?php } ?>
<script>
$(document).ready(function() {
 
  $("#owl-demo3").owlCarousel({
		itemsCustom : [[320, 1],[600, 2],[768, 3],[992, 3],[1199, 3]],											   
		lazyLoad : true,
		navigation : true,
		navigationText: false,
		scrollPerPage : true
  });
 
});
</script>
<style>
#owl-demo3 .owl-pagination{
	display: none!important;
}
#owl-demo3 .price-old{
	color: red;
text-decoration: line-through;
}
#owl-demo3 .name{
	height: 50px;
    text-transform: uppercase;
}
.priceblock{
	display: table;
}
.btncart{
    display: table-cell;
    vertical-align: middle;
}
.priceitem{
    display: table-cell;
    vertical-align: middle;
    padding-left: 10px;
}
.similarproducts{
	color: #34aa37!important;
	font-size: 20px;
}
.box-content2{
    background: #fafafa!important;
}
#owl-demo3 .slideitem{
	background: #fff;
    margin: 10px;
    padding: 15px;
    border-bottom: 2px solid #e0e0e0;
}
.btncart input{
    background: url(/image/data/vkorzinu.png) #34aa37 90% 40% no-repeat;
	width: 150px;
}
.btncart input:hover{
    background: url(/image/data/vkorzinu.png) #34aa37 90% 40% no-repeat;
	width: 150px;
}
.slideitem .image{
	text-align: center;
    padding-bottom: 10px;
}
</style>