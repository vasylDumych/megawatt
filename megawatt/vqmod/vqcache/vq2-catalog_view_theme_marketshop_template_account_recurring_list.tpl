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
  <?php if ($profiles) { ?>

    <table class="list">
        <thead>
        <tr>
            <td class="left"><?php echo $column_profile_id; ?></td>
            <td class="left"><?php echo $column_created; ?></td>
            <td class="left"><?php echo $column_status; ?></td>
            <td class="left"><?php echo $column_product; ?></td>
            <td class="right"><?php echo $column_action; ?></td>
        </tr>
        </thead>
        <tbody>
        <?php if ($profiles) { ?>
        <?php foreach ($profiles as $profile) { ?>
        <tr>
            <td class="left">#<?php echo $profile['id']; ?></td>
            <td class="left"><?php echo $profile['created']; ?></td>
            <td class="left"><?php echo $status_types[$profile['status']]; ?></td>
            <td class="left"><?php echo $profile['name']; ?></td>
            <td class="right"><a href="<?php echo $profile['href']; ?>"><img src="catalog/view/theme/default/image/info.png" alt="<?php echo $button_view; ?>" title="<?php echo $button_view; ?>" /></a></td>
        </tr>
        <?php } ?>
        <?php } else { ?>
        <tr>
            <td class="center" colspan="5"><?php echo $text_empty; ?></td>
        </tr>
        <?php } ?>
        </tbody>
    </table>

  <div class="pagination"><?php echo $pagination; ?></div>
  <?php } else { ?>
  <div class="content"><?php echo $text_empty; ?></div>
  <?php } ?>
  <div class="buttons">
    <div class="right"><a href="<?php echo $continue; ?>" class="button"><?php echo $button_continue; ?></a></div>
  </div>
  <?php echo $content_bottom; ?></div>
<?php echo $column_right; ?>
  </div></div>
<?php echo $footer; ?>