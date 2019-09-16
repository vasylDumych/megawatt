<?php echo $header; ?>
<?php echo $content_top; ?>

            <?php echo $column_left; ?>
            
            <div id="content" class="container">
                
                    <?php echo $column_right; ?>
                     <div class="breadcrumb">
                    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
                    <?php } ?>
                    </div>
                        <h1><?php echo $heading_title; ?></h1>
                        <div class="content">
                        <?php if (isset($news_info)) { ?>
                            <p><strong><?= $date ?></strong></p>
                        <?php if ($image) { ?>
                            <div class="image" style="float: left; margin-right: 10px;">
                                <a href="<?php echo $popup; ?>" title="<?php echo $heading_title; ?>" class="colorbox"
                                   rel="colorbox">
                                    <img src="<?php echo $thumb; ?>" title="<?php echo $heading_title; ?>"
                                         alt="<?php echo $heading_title; ?>"/>
                                </a>
                            </div>
                        <?php } ?>
                        <?php echo $description; ?>
                            <div class="buttons" style="clear: both">
                                <div class="right">
                                    <a onclick="location='<?php echo $news; ?>'"class="button"><span><?php echo $button_news; ?></span></a>
                                </div>
                            </div>
                            <script type="text/javascript"><!--
                                $(document).ready(function () {
                                    $('.colorbox').colorbox({
                                        overlayClose: true,
                                        opacity: 0.5,
                                        rel: "colorbox"
                                    });
                                });
                            //--></script>
                        <?php } ?>

                </div>
            </div>


<?php echo $content_bottom; ?>
<?php echo $footer; ?>