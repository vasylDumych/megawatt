<div id="carsite">
  <ul id="carousel<?php echo $module; ?>" class="carousel-site">
    <?php foreach ($banners as $banner) { ?>
    <li><a href="<?php echo $banner['link']; ?>"><img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" title="<?php echo $banner['title']; ?>" /></a></li>
    <?php } ?>
  </ul>
</div>

<script type="text/javascript"><!--
$(document).ready(function() {
	$('#carousel<?php echo $module; ?>').owlCarousel({
		itemsCustom : [[320, 1],[600, 2],[768, 3],[992, 4],[1199, 4]],											   
		lazyLoad : true,
		navigation : true,
		dots : false,
		controls:false,
		navigationText: false,
		scrollPerPage : true
    }); 
});
//--></script>
<style>
#carsite ul{
	list-style: none;	
}
#carsite{

	width: 85%!important;
	margin: 0 auto!important;
}
#carsite img{
	width: 85%!important;
	height:auto!important;
	margin: 0 auto!important;
}
#carsite .owl-prev{
	left: -30px!important;
    top: 36%;
}
#carsite .owl-next{
    top: 36%;
	right: -30px!important;
}
</style>