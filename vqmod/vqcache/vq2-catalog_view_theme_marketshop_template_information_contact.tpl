<?php echo $header; ?><div class="container">
<div class="row">
<?php echo $column_left; ?>
<?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-lg-6 col-md-6 col-sm-6 col-xs-12'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-lg-9 col-md-9 col-sm-9 col-xs-12'; ?>
    <?php } else { ?>
    <?php $class = 'col-lg-12 col-md-12 col-sm-12 col-xs-12'; ?>
    <?php } ?>

<div id="content" class="<?php echo $class; ?>">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>




  <h1 class="contact-title"><?php echo $heading_title; ?></h1>
 <div class="row">
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"><?php echo $footer_new; ?></div>
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"><?php echo $content_bottom; ?></div>
<?php echo $column_right; ?>
  </div></div>
 </div>
 
        <?php if(($content_top_2_3) || ($content_top_1_3)) {?>
<div class="row">		
<div id="content-top-first">
<?php echo $content_top_2_3; ?>
<?php echo $content_top_1_3; ?>
</div>
</div>

<?php } ?>
<?php echo $content_top; ?>
       
  
  </div>
<?php echo $footer; ?>

<style>
.contact-title{
	color: #34aa37!important;
    font-size: 32px!important;
}
.contact-form-title{
	font-size: 20px;
	color: #6a6a6b!important;
    padding-top: 15px;
}
#cont-info span{
    font-size: 15px!important;
    font-family: HelveticaNeueCyrRoman;
	color: #6a6a6b!important;
    line-height: 24px;
}
</style>
