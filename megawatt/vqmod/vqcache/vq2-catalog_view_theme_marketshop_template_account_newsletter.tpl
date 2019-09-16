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
        <?php if(($content_top_2_3) || ($content_top_1_3)) {?>
<div class="row">		
<div id="content-top-first">
<?php echo $content_top_2_3; ?>
<?php echo $content_top_1_3; ?>
</div>
</div>

<?php } ?>
<?php echo $content_top; ?>
      
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>




  <h1><?php echo $heading_title; ?></h1>
  <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
    <div class="content">
      <table class="form">
        <tr>
          <td><?php echo $entry_newsletter; ?></td>
          <td><?php if ($newsletter) { ?>
          <label class="radio-inline">
            <input type="radio" name="newsletter" value="1" checked="checked" />
            <?php echo $text_yes; ?></label>
            <label class="radio-inline">
            <input type="radio" name="newsletter" value="0" />
            <?php echo $text_no; ?></label>
            <?php } else { ?>
            <label class="radio-inline">
            <input type="radio" name="newsletter" value="1" />
            <?php echo $text_yes; ?></label>
            <label class="radio-inline">
            <input type="radio" name="newsletter" value="0" checked="checked" />
            <?php echo $text_no; ?></label>
            <?php } ?></td>
        </tr>
      </table>
    </div>
    <div class="buttons">
      <div class="left"><a href="<?php echo $back; ?>" class="button"><?php echo $button_back; ?></a></div>
      <div class="right"><input type="submit" value="<?php echo $button_continue; ?>" class="button" /></div>
    </div>
  </form>
  <?php echo $content_bottom; ?></div>
<?php echo $column_right; ?>
  </div></div>
<?php echo $footer; ?>