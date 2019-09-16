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
 

   <div id="page-about"><?php echo $content_bottom; ?>
   <div class="page-about-block-title"> <p><?php echo $cartitle; ?></p>
   <?php echo $carousel_about; ?>
   </div>
   </div></div></div>
<?php echo $footer; ?>




