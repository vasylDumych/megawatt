<?php echo $header; ?>
<div class="container">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
<?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content" class="col-lg-9 col-md-9 col-sm-9 col-xs-12">


<?php echo $content_top; ?>

  <h1 class="page-title"><?php echo $heading_title; ?></h1>
 

   <div id="page-certificates"><?php echo $content_bottom; ?>
   <div id="page-cert">
   <?php echo $carousel_about; ?>
   </div>
   </div></div></div>
<?php echo $footer; ?>

<link rel="stylesheet" type="text/css" href="catalog/view/javascript/jquery/colorbox/colorbox.css" media="screen" />
<script type="text/javascript" src="catalog/view/javascript/jquery/colorbox/jquery.colorbox-min.js"></script>


<script type="text/javascript">
 $('document').ready(function() {
	$("div#page-cert img").addClass('colbok2');
});
 </script>

<script type="text/javascript"><!--
$(document).ready(function() {
$('.colbok2').click(function() {
    $(this).colorbox({
        href: $(this).attr('src'),
        opacity: "0.50",
		maxWidth:'95%', 
		maxHeight:'95%'
    });
});
});
//--></script> 