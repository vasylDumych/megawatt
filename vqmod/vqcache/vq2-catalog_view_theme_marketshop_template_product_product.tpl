<?php echo $header; ?>
<div class="container"><!--Open main container-->
    <?php echo $column_left; ?><?php echo $column_right; ?>
    <div id="content" class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><?php echo $content_top; ?>
        <div class="breadcrumb">
            <?php foreach ($breadcrumbs as $breadcrumb) { ?>
            <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>" itemprop="url"><span itemprop="title"><?php echo $breadcrumb['text']; ?></span></a></span>
            <?php } ?>
        </div>
        <div itemtype="http://schema.org/Product" itemscope="itemscope">

            <meta itemprop="sku" content="<?php echo $model; ?>" />
            <?php if ($manufacturer) { ?>
            <meta itemprop="manufacturer" content="<?php echo $manufacturer; ?>" >
            <?php } ?>
            <div class="row product-info">
                <div class="col-sm-9">
                    <h1 class="product-title" itemprop="name"><?php echo $heading_title; ?></h1>
                    <?php $lang = (int)$this->config->get('config_language_id');?>
                    <div class="row">
                        <?php if($this->config->get('marketshop_cloud_zoom')== 1) { ?>
                        <div class="col-sm-4">
                            <script src="catalog/view/theme/marketshop/js/jquery.elevateZoom-3.0.8.min.js"></script>
                            <script src="catalog/view/javascript/jquery/swipebox/lib/ios-orientationchange-fix.js"></script>
                            <script src="catalog/view/javascript/jquery/swipebox/source/jquery.swipebox.min.js"></script>
                            <link rel="stylesheet" href="catalog/view/javascript/jquery/swipebox/source/swipebox.css">
                            <?php if ($thumb) { ?>
                            <div class="image"> <img itemprop="image" id="zoom_01" class="img-responsive" src="<?php echo $thumb; ?>" data-zoom-image="<?php echo $popup; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" />
                                <?php } ?>
                            </div>
                            <?php if($this->config->get('marketshop_cloud_zoom_gallery')== 1) {
                            $marketshop_cloud_zoom_gallery_text = $this->config->get('marketshop_cloud_zoom_gallery_text'); { ?>
                            <div class="center-block text-center "><span class="zoom-gallery"><?php echo $marketshop_cloud_zoom_gallery_text[$lang]; ?></span></div>
                            <?php } ?>
                            <?php } ?>

                            <?php if ($images) { ?>
                            <div class="image-additional" id="gallery_01">
                                <?php if ($thumb) { ?>
                                <a class="thumbnail" href="#" data-zoom-image="<?php echo $popup; ?>" data-image="<?php echo $thumb; ?>" title="<?php echo $heading_title; ?>"> <img src="<?php echo $thumb; ?>" title="<?php echo $heading_title; ?>" alt = "<?php echo $heading_title; ?>"/></a>
                                <?php } ?>
                                <?php foreach ($images as $image) { ?>
                                <a class="thumbnail" href="#" data-zoom-image="<?php echo $image['popup']; ?>" data-image="<?php echo $image['thumb']; ?>" title="<?php echo $heading_title; ?>"><img src="<?php echo $image['thumb']; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" /></a>
                                <?php } ?>
                            </div>
                            <?php } else { ?>
                            <div class="image-additional" id="gallery_01" style="display:none">
                                <?php if ($thumb) { ?>
                                <a style="display:none" href="#" data-zoom-image="<?php echo $popup; ?>" data-image="<?php echo $thumb; ?>" title="<?php echo $heading_title; ?>"> <img src="<?php echo $thumb; ?>" title="<?php echo $heading_title; ?>" alt = "<?php echo $heading_title; ?>"/></a>
                                <?php } ?>
                            </div>
                            <?php } ?>


                            <script>
                              $("#zoom_01").elevateZoom({
                                gallery:'gallery_01',
                                cursor: 'pointer',
                              <?php if ($direction == 'rtl') { ?>zoomWindowPosition: 11,<?php } ?>
                              <?php if($this->config->get('marketshop_cloud_zoom_inner')== 1) { ?>zoomType: "inner",<?php } ?>
                              galleryActiveClass: 'active',
                                imageCrossfade: true,
                                zoomWindowFadeIn: 500,
                                zoomWindowFadeOut: 500,
                                lensFadeIn: 500,
                                lensFadeOut: 500,
                                loadingIcon: 'catalog/view/theme/marketshop/image/progress.gif'});
                              <?php if($this->config->get('marketshop_cloud_zoom_gallery')== 1) { ?>
                                //////pass the images to swipebox
                                $("#zoom_01").bind("click", function(e) {
                                  var ez =   $('#zoom_01').data('elevateZoom');
                                  $.swipebox(ez.getGalleryList());
                                  return false;
                                });<?php } ?>
                            </script>
                        </div>
                        <?php } else { ?>
                        <div class="col-sm-4">
                            <?php if ($special_percentages) { ?>
                                <span class="special-percentages"><?php echo $special_percentages; ?></span>
                            <?php } ?>

                            <?php if ($thumb) { ?>
                                <div class="image"><a href="<?php echo $popup; ?>" title="<?php echo $heading_title; ?>" class="colorbox"><img itemprop="image" src="<?php echo $thumb; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" id="image" /></a></div>
                            <?php } else { ?>
                            <img src="image/no_image.jpg" style="width:100%;" alt="" title="" />
                            <?php } ?>
                            <?php if ($images) { ?>
                            <div class="image-additional">
                                <?php foreach ($images as $image) { ?>
                                <a href="<?php echo $image['popup']; ?>" title="<?php echo $heading_title; ?>" class="colorbox"><img src="<?php echo $image['thumb']; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" /></a>
                                <?php } ?>
                            </div>
                            <?php } ?>
                        </div>
                        <?php } ?>

                        <div class="col-sm-4">
                            <div class="description">
                                <?php if ($manufacturer) { ?>
                                <span><?php echo $text_manufacturer; ?></span> <a href="<?php echo $manufacturers; ?>"><?php echo $manufacturer; ?></a><br />
                                <?php } ?>
                                <?php if ($series) { ?>
                                <span><?php echo $text_series; ?></span> <a href="<?php echo $series['href']; ?>"><?php echo $series['name']; ?></a><br />
                                <?php } ?>
                                <span><?php echo $text_model; ?></span> <?php echo $model; ?><br />
                                <span><?php echo $text_code; ?></span><?php echo $product_id; ?><br />
                                <?php if ($reward) { ?>
                                <span><?php echo $text_reward; ?></span> <?php echo $reward; ?><br />
                                <?php } ?>
                                <!--<span><?php echo $text_stock; ?></span> <?php echo $stock; ?><br />-->
                                <?php if ($quantity <= 0) { ?>
                                <span class="ico icon-wh-empty-before"></span>
                                <?php } else { ?>
                                <span class="ico icon-wh-full-before"></span>
                                <?php } ?>
                                <?php echo $stock; ?>
                                <div>
                                    <span class="ico icon-truck-24-before"></span>
                                    <?php echo $text_send_24; ?>
                                </div>
                                <div class="rating"><?php echo $text_rating; ?> <img src="catalog/view/theme/marketshop/image/stars-<?php echo $rating ? $rating : 0; ?>.png" alt="<?php echo $rating; ?>" /></div>
                            </div>
                            <?php if ($options) { ?>
                            <div class="options">
                                <h2><?php echo $text_option; ?></h2>
                                <?php foreach ($options as $option) { ?>
                                <?php if ($option['type'] == 'select') { ?>
                                <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
                                    <?php if ($option['required']) { ?>
                                    <span class="required">*</span>
                                    <?php } ?>
                                    <b><?php echo $option['name']; ?>:</b><br />
                                    <select name="option[<?php echo $option['product_option_id']; ?>]" class="form-control">
                                        <option value=""><?php echo $text_select; ?></option>
                                        <?php foreach ($option['option_value'] as $option_value) { ?>
                                        <option value="<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
                                            <?php if ($option_value['price']) { ?>
                                            (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                                            <?php } ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <br />
                                <?php } ?>
                                <?php if ($option['type'] == 'radio') { ?>
                                <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
                                    <?php if ($option['required']) { ?>
                                    <span class="required">*</span>
                                    <?php } ?>
                                    <b><?php echo $option['name']; ?>:</b><br />
                                    <?php foreach ($option['option_value'] as $option_value) { ?>
                                    <input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" id="option-value-<?php echo $option_value['product_option_value_id']; ?>" />
                                    <label for="option-value-<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
                                        <?php if ($option_value['price']) { ?>
                                        (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                                        <?php } ?>
                                    </label>
                                    <br />
                                    <?php } ?>
                                </div>
                                <br />
                                <?php } ?>
                                <?php if ($option['type'] == 'checkbox') { ?>
                                <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
                                    <?php if ($option['required']) { ?>
                                    <span class="required">*</span>
                                    <?php } ?>
                                    <b><?php echo $option['name']; ?>:</b><br />
                                    <?php foreach ($option['option_value'] as $option_value) { ?>
                                    <input type="checkbox" name="option[<?php echo $option['product_option_id']; ?>][]" value="<?php echo $option_value['product_option_value_id']; ?>" id="option-value-<?php echo $option_value['product_option_value_id']; ?>" />
                                    <label for="option-value-<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
                                        <?php if ($option_value['price']) { ?>
                                        (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                                        <?php } ?>
                                    </label>
                                    <br />
                                    <?php } ?>
                                </div>
                                <br />
                                <?php } ?>
                                <?php if ($option['type'] == 'image') { ?>
                                <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
                                    <?php if ($option['required']) { ?>
                                    <span class="required">*</span>
                                    <?php } ?>
                                    <b><?php echo $option['name']; ?>:</b><br />
                                    <table class="option-image">
                                        <?php foreach ($option['option_value'] as $option_value) { ?>
                                        <tr>
                                            <td style="width: 1px;"><input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" id="option-value-<?php echo $option_value['product_option_value_id']; ?>" /></td>
                                            <td><label for="option-value-<?php echo $option_value['product_option_value_id']; ?>"><img src="<?php echo $option_value['image']; ?>" alt="<?php echo $option_value['name'] . ($option_value['price'] ? ' ' . $option_value['price_prefix'] . $option_value['price'] : ''); ?>" /></label></td>
                                            <td><label for="option-value-<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
                                                    <?php if ($option_value['price']) { ?>
                                                    (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                                                    <?php } ?>
                                                </label></td>
                                        </tr>
                                        <?php } ?>
                                    </table>
                                </div>
                                <br />
                                <?php } ?>
                                <?php if ($option['type'] == 'text') { ?>
                                <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
                                    <?php if ($option['required']) { ?>
                                    <span class="required">*</span>
                                    <?php } ?>
                                    <b><?php echo $option['name']; ?>:</b><br />
                                    <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" class="form-control" />
                                </div>
                                <br />
                                <?php } ?>
                                <?php if ($option['type'] == 'textarea') { ?>
                                <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
                                    <?php if ($option['required']) { ?>
                                    <span class="required">*</span>
                                    <?php } ?>
                                    <b><?php echo $option['name']; ?>:</b><br />
                                    <textarea class="form-control" name="option[<?php echo $option['product_option_id']; ?>]" cols="40" rows="5"><?php echo $option['option_value']; ?></textarea>
                                </div>
                                <br />
                                <?php } ?>
                                <?php if ($option['type'] == 'file') { ?>
                                <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
                                    <?php if ($option['required']) { ?>
                                    <span class="required">*</span>
                                    <?php } ?>
                                    <b><?php echo $option['name']; ?>:</b><br />
                                    <input type="button" value="<?php echo $button_upload; ?>" id="button-option-<?php echo $option['product_option_id']; ?>" class="button">
                                    <input type="hidden" name="option[<?php echo $option['product_option_id']; ?>]" value="" />
                                </div>
                                <br />
                                <?php } ?>
                                <?php if ($option['type'] == 'date') { ?>
                                <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
                                    <?php if ($option['required']) { ?>
                                    <span class="required">*</span>
                                    <?php } ?>
                                    <b><?php echo $option['name']; ?>:</b><br />
                                    <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" class="date form-control" />
                                </div>
                                <br />
                                <?php } ?>
                                <?php if ($option['type'] == 'datetime') { ?>
                                <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
                                    <?php if ($option['required']) { ?>
                                    <span class="required">*</span>
                                    <?php } ?>
                                    <b><?php echo $option['name']; ?>:</b><br />
                                    <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" class="datetime form-control" />
                                </div>
                                <br />
                                <?php } ?>
                                <?php if ($option['type'] == 'time') { ?>
                                <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
                                    <?php if ($option['required']) { ?>
                                    <span class="required">*</span>
                                    <?php } ?>
                                    <b><?php echo $option['name']; ?>:</b><br />
                                    <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" class="time form-control" />
                                </div>
                                <br />
                                <?php } ?>
                                <?php } ?>
                            </div>
                            <?php } ?>
                            <!--<table>
                              <tr>
                                  <td>
                                       <div class="qty2">-->
                            <!--<strong><?php echo $text_qty; ?></strong>-->
                            <!--<span><a class="qtyBtn mines" href="javascript:void(0);">-</a></span>
                            <input id="qty" type="text" class="form-control" name="quantity" size="2" value="<?php echo $minimum; ?>" />
                            <span><a class="qtyBtn plus" href="javascript:void(0);">+</a></span>

                            <input type="hidden" name="product_id" size="2" value="<?php echo $product_id; ?>" />
                          <div class="clear"></div>
               </div>
          </td>
          <td class="btn-cell"><input type="button" value="<?php echo $button_cart; ?>" id="button-cart" class="button" /></td>
          <td class="compare-cell"><a class="compare" onclick="addToCompare('<?php echo $product_id; ?>');"><img src="/image/data/compare.png" /></a></td>
          <td class="wishlist-cell"><a class="wishlist" onclick="addToWishList('<?php echo $product_id; ?>');"><img src="/image/data/wishlist.png" /></a></td>
      </tr>
      <tr>
          <td></td>
          <td class="buyoneclick-cell"><?php echo $buyinoneclick; ?></td>
          <td class="note-cell"><a title="<?php echo $podskazka; ?>" class="podskazka"><img style="width: 85%;" src="/image/data/que.png" /></a></td>
          <td></td>
      </tr>
    </table>


-->
                            <?php if ($minimum > 1) { ?>
                            <div class="minimum"><?php echo $text_minimum; ?></div>
                            <?php } ?>

                            <!--<?php if ($review_status) { ?>
                            <div class="review" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
                              <div><span itemprop="ratingValue" style="display:none;"><?php echo $rating; ?></span><img src="catalog/view/theme/marketshop/image/stars-<?php echo $rating; ?>.png" alt="<?php echo $reviews; ?>" />&nbsp;&nbsp;<a onclick="$('a[href=\'#tab-review\']').trigger('click');"><span itemprop="reviewCount"><?php echo $reviews; ?></span></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="$('a[href=\'#tab-review\']').trigger('click');"><?php echo $text_write; ?></a></div>
                            </div>
                            <?php } ?>-->
                            <?php if($this->config->get('marketshop_share_plugin')== 1) { ?>
                            <!-- AddThis Button BEGIN -->
                            <?php if($this->config->get('marketshop_share_plugin_style')== 1) { ?>
                            <div class="addthis_toolbox addthis_default_style"> <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a> <a class="addthis_button_tweet"></a> <a class="addthis_button_google_plusone" g:plusone:size="medium"></a> <a class="addthis_button_pinterest_pinit" pi:pinit:layout="horizontal" pi:pinit:url="http://www.addthis.com/features/pinterest" pi:pinit:media="http://www.addthis.com/cms-content/images/features/pinterest-lg.png"></a> <a class="addthis_counter addthis_pill_style"></a> </div>
                            <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-514863386b357649"></script>
                            <?php } ?>
                            <?php if($this->config->get('marketshop_share_plugin_style')== 2) { ?>
                            <div class="addthis_toolbox addthis_default_style addthis_32x32_style"> <a class="addthis_button_facebook"></a> <a class="addthis_button_twitter"></a> <a class="addthis_button_google_plusone_share"></a> <a class="addthis_button_pinterest_share"></a> <a class="addthis_button_compact"></a><a class="addthis_counter addthis_bubble_style"></a> </div>
                            <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-514863386b357649"></script>
                            <?php } ?>
                            <?php if($this->config->get('marketshop_share_plugin_style')== 3) { ?>
                            <div class="addthis_toolbox addthis_default_style addthis_16x16_style"> <a class="addthis_button_facebook"></a> <a class="addthis_button_twitter"></a> <a class="addthis_button_google_plusone_share"></a> <a class="addthis_button_pinterest_share"></a> <a class="addthis_button_compact"></a><a class="addthis_counter addthis_bubble_style"></a> </div>
                            <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-514863386b357649"></script>
                            <?php } ?>
                            <!-- AddThis Button END -->
                            <?php } ?>
                            <?php if ($tags) { ?>
                            <div class="tags"><b><?php echo $text_tags; ?></b>
                                <?php for ($i = 0; $i < count($tags); $i++) { ?>
                                <?php if ($i < (count($tags) - 1)) { ?>
                                <a href="<?php echo $tags[$i]['href']; ?>"><?php echo $tags[$i]['tag']; ?></a>,
                                <?php } else { ?>
                                <a href="<?php echo $tags[$i]['href']; ?>"><?php echo $tags[$i]['tag']; ?></a>
                                <?php } ?>
                                <?php } ?>
                            </div>
                            <?php } ?>
                        </div>
                        <div class="col-sm-4">
                            <div class="parentcontainer">

                                <div>

                                    <?php if ($price) { ?>
                                    <div class="price" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                                        <span style="display:none;"><link itemprop="availability" href="http://schema.org/InStock" /><?php echo $stock; ?></span>
                                        <?php if (!$special || $special_without_format > $price_without_format) { ?>
                                            <span class="price-old-js" itemprop="price"><?php echo $price; ?></span>
                                        <?php } else { ?>
                                            <span class="price-old price-old-js"><?php echo $price; ?></span><br/>
                                            <span class="price-new price-new-js" itemprop="price"><?php echo $special; ?></span>
                                        <?php } ?>
                                        <br />
                                        <?php if ($tax) { ?>
                                        <span class="price-tax"><?php echo $text_tax; ?> <?php echo $tax; ?></span><br />
                                        <?php } ?>
                                        <?php if ($points) { ?>
                                        <span class="reward"><small><?php echo $text_points; ?> <?php echo $points; ?></small></span><br />
                                        <?php } ?>
                                        <?php if ($discounts) { ?>
                                        <br />
                                        <div class="discount">
                                            <?php foreach ($discounts as $discount) { ?>
                                            <?php echo sprintf($text_discount, $discount['quantity'], $discount['price']); ?><br />
                                            <?php } ?>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <?php } ?>

                                    <div class="qty2 itemcontainer1">
                                        <div style="display: none;">
                                            <span id="price_without_format"><?php echo $price_without_format; ?></span>
                                            <span id="special_without_format"><?php echo $special_without_format; ?></span>
                                        </div>
                                        <!--<strong><?php echo $text_qty; ?></strong>-->
                                        <div><a class="qtyBtn mines" href="javascript:void(0);">-</a></div>
                                        <input id="qty" type="text" class="form-control" name="quantity" size="2" value="<?php echo $minimum; ?>" />
                                        <div><a class="qtyBtn plus" href="javascript:void(0);">+</a></div>
                                        <input type="hidden" name="product_id" size="2" value="<?php echo $product_id; ?>" />
                                        <div class="clear"></div>
                                    </div>
                                </div>

                                <div class="itemcontainer2">
                                    <div class="btn-cell">
                                        <input type="button" value="<?php echo $button_cart; ?>" id="button-cart" class="button btn1 btn-link-green" />
                                    </div>
                                    <div>
                                        <div class="buyoneclick-cell btn1 btn-link-green-border"><?php echo $buyinoneclick; ?></div>
                                    </div>
                                </div>

                                <div class="itemcontainer3">
                                    <div class="compare-cell podskazka" title="<?php echo $podskazka_compare; ?>">
                                        <a class="compare" onclick="addToCompare('<?php echo $product_id; ?>');"><img src="/image/data/compare.png" /></a>
                                    </div>
                                    <div class="wishlist-cell podskazka" title="<?php echo $podskazka_wishlist; ?>">
                                        <a class="wishlist detail-wishlist-link" onclick="addToWishList('<?php echo $product_id; ?>');">
                                            <span class="detail-wishlist-link novisited sprite-side"></span>
                                        </a>
                                    </div>
                                    <div class="note-cell"><a title="<?php echo $podskazka; ?>" class="podskazka"><img style="width: 80%;" src="/image/data/que.png" /></a></div

                                </div>
                            </div>
                             <div class="itemcontainer4" style="align-items: center; width: auto;">
                                    <a href="/information-payment/"><img src="/image/data/spritesheet2.png"/></a>
                                </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <?php if (($firstCategory[category_id] == 99) && isset($productExample['product_id'])) { ?>
                    <hr>
                    <div class="product-example">
                        <div class="item">
                            <div class="btncart"><a onclick="addToCart('<?php echo $productExample['product_id']; ?>');" class="button"><span><?php echo $button_cart_example; ?></span></a></div>
                        </div>
                        <div class="item img">
                            <?php if ($productExample['thumb']) { ?>
                            <div>
                                <img src="<?php echo $productExample['thumb']; ?>" alt="<?php echo $productExample['name']; ?>" />
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <div class="col-sm-3">
                <?php echo $additional_info; ?>
            </div>


            <!--download instructions-->
            <div class="product-info">
                <?php if($downloads){ ?>
                <br>

                <?php foreach($downloads as $download){ ?>

                <a href="<?php echo $download['href']; ?>" title=""><?php echo $download['name']; ?><?php echo " (". $download['size'] .")";?></a><br>

                <?php } ?>
                <?php } ?>
            </div>


            <div id="tabs" class="htabs"><a href="#tab-description"><?php echo $tab_description; ?></a>
                <?php if ($attribute_groups) { ?>
                <a href="#tab-attribute"><?php echo $tab_attribute; ?></a>
                <?php } ?>
                <?php if ($review_status) { ?>
                <a href="#tab-review"><?php echo $tab_review; ?></a>
                <?php } ?>
                <?php if ($products) { ?>
                <a href="#tab-related"><?php echo $tab_similar; ?></a>
                <?php } ?>
            </div>
            <div id="tab-description" class="tab-content" itemprop="description"><?php echo $description; ?></div>
            <?php if ($attribute_groups) { ?>
            <div id="tab-attribute" class="tab-content">
                <table class="attribute">
                    <?php foreach ($attribute_groups as $attribute_group) { ?>
                    <thead>
                    <tr>
                        <td colspan="2"><?php echo $attribute_group['name']; ?></td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($attribute_group['attribute'] as $attribute) { ?>
                    <tr>
                        <td><?php echo $attribute['name']; ?></td>
                        <td><?php echo $attribute['text']; ?></td>
                    </tr>
                    <?php } ?>
                    </tbody>
                    <?php } ?>
                </table>
            </div>
            <?php } ?>
            <?php if ($review_status) { ?>
            <div id="tab-review" class="tab-content">
                <div id="review"></div>
                <h2 id="review-title"><?php echo $text_write; ?></h2><br />
                <b><?php echo $entry_name; ?></b><br />
                <input type="text" name="name" value="" class="form-control" />
                <br />
                <b><?php echo $entry_review; ?></b>
                <textarea name="text" cols="40" rows="8" class="form-control"></textarea>
                <span style="font-size: 11px;"><?php echo $text_note; ?></span><br /><br />
                <b><?php echo $entry_rating; ?></b> <span><?php echo $entry_bad; ?></span>&nbsp;
                <input type="radio" name="rating" value="1" />
                &nbsp;
                <input type="radio" name="rating" value="2" />
                &nbsp;
                <input type="radio" name="rating" value="3" />
                &nbsp;
                <input type="radio" name="rating" value="4" />
                &nbsp;
                <input type="radio" name="rating" value="5" />
                &nbsp;<span><?php echo $entry_good; ?></span><br />
                <br />
                <b><?php echo $entry_captcha; ?></b><br />
                <input type="text" name="captcha" value="" class="form-control"/>
                <br />
                <img src="index.php?route=product/product/captcha" alt="" id="captcha" /><br />
                <br />
                <div class="buttons">
                    <div class="right"><a id="button-review" class="button"><?php echo $button_continue; ?></a></div>
                </div>
            </div>
            <?php } ?>
            <?php if ($products) { ?>
            <div id="tab-related" class="tab-content">









                <div class="box" style="margin: 25px 0 0 0;">
                    <!-- similar products-->
                    <?php if ($products_similar) { ?>
                    <div class="box-heading similarproducts kkkkkkkk"><?php echo $tab_similar; ?></div>
                    <?php } ?>
                    <div id="owl-demo2" class="owl-carousel owl-theme">

                        <?php foreach ($products_similar as $product) { ?>
                        <div class="slideitem">
                            <?php if ($product['thumb']) { ?>
                                <div class="image">
                                    <?php if ($product['special_percentages']) { ?>
                                    <span class="special-percentages"><?php echo $product['special_percentages']; ?></span>
                                    <?php } ?>
                                    <a href="<?php echo $product['href']; ?>">
                                        <img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" />
                                    </a>
                                </div>
                            <?php } ?>
                            <div class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
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
                        </div>
                        <?php } ?>


                    </div>
                </div>












            </div><?php } ?>
        </div>






        <script>
          $(document).ready(function() {

            $("#owl-demo2").owlCarousel({
              itemsCustom : [[320, 1],[600, 2],[768, 3],[992, 3],[1199, 3]],
              lazyLoad : true,
              navigation : true,
              navigationText: false,
              scrollPerPage : true
            });

          });
        </script>
        <style>
            #related_pro .name{
                height: 50px;
            }
            #related_pro .owl-pagination{
                display: none!important;
            }
            #owl-demo2 .owl-pagination{
                display: none!important;
            }
            #owl-demo2 .price-old{
                color: red;
                text-decoration: line-through;
            }
            #related_pro .price-old{
                color: red;
                text-decoration: line-through;
            }
            #owl-demo2 .name{
                height: 50px;
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
            #owl-demo2 .owl-item .slideitem{
                background: #fff;
                margin: 10px;
                padding: 15px;
                border-bottom: 2px solid #e0e0e0;
            }
            #related_pro .owl-item .slideitem{
                background: #fff;
                margin: 10px;
                padding: 15px;
                border-bottom: 2px solid #e0e0e0;
            }
            .btncart a{
                background: url(/image/data/vkorzinu.png) #34aa37 90% 40% no-repeat;
                width: 150px;
            }
            .btncart a:hover{
                background: url(/image/data/vkorzinu.png) #34aa37 90% 40% no-repeat;
                width: 150px;
            }
            .slideitem .image{
                text-align: center;
                padding-bottom: 10px;
            }
        </style>

        <?php if (count($products) > 0) { ?>
        <div class="box">
            <div class="box-heading similarproducts"><?php echo $tab_related; ?></div>
            <div class="box-content2">

                <div id="related_pro" class="owl-carousel">
                    <?php foreach ($products as $product) { ?>



                    <div class="slideitem">
                        <div class="product-item2">
                            <?php if ($product['thumb']) { ?>
                                <div class="image">
                                    <?php if ($product['special_percentages']) { ?>
                                        <span class="special-percentages"><?php echo $product['special_percentages']; ?></span>
                                    <?php } ?>
                                    <a href="<?php echo $product['href']; ?>">
                                        <img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" />
                                    </a>
                                </div>
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
                    </div>



                    <?php } ?>
                </div>

            </div></div>


        <script type="text/javascript">
          $(document).ready(function() {
            $(".owl-carousel#related_pro").owlCarousel({
              itemsCustom : [[320, 1],[600, 2],[768, 3],[992, <?php echo $this->config->get('marketshop_related_slider_product_per_row'); ?>],[1199, <?php echo $this->config->get('marketshop_related_slider_product_per_row'); ?>]],
            lazyLoad : true,
              navigation : true,
              navigationText: false,
              scrollPerPage : true
          });
          });
        </script>
        <?php } ?>


        <?php if (count($randomProducts) > 0) { ?>
        <div class="box">
            <div class="box-heading similarproducts"><?php echo $tab_random; ?></div>
            <div class="box-content2">

                <div id="random_pro" class="owl-carousel-random">
                    <?php foreach ($randomProducts as $product) { ?>

                    <div class="slideitem">
                        <div class="product-item2">
                            <?php if ($product['thumb']) { ?>
                                <div class="image">
                                    <?php if ($product['special_percentages']) { ?>
                                    <span class="special-percentages"><?php echo $product['special_percentages']; ?></span>
                                    <?php } ?>
                                    <a href="<?php echo $product['href']; ?>">
                                        <img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" />
                                    </a>
                                </div>
                            <?php } ?>
                            <div class="name" style="min-height: 70px; padding: 0 10px;"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
                            <div class="stock" style="margin-bottom: 15px;">
                                <?php if ($product['quantity'] <= 0) { ?>
                                <span class="ico icon-wh-empty-before"></span>
                                <?php } else { ?>
                                <span class="ico icon-wh-full-before"></span>
                                <?php } ?>
                                <?php echo $product['stock']; ?>
                            </div>
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
                    </div>



                    <?php } ?>
                </div>

            </div>
        </div>

        <script type="text/javascript">
          $(document).ready(function() {
            $(".owl-carousel-random#random_pro").owlCarousel({
              itemsCustom : [[320, 1],[600, 2],[768, 3],[992, <?php echo $this->config->get('marketshop_related_slider_product_per_row'); ?>],[1199, <?php echo $this->config->get('marketshop_related_slider_product_per_row'); ?>]],
            lazyLoad : true,
              navigation : true,
              navigationText: false,
              scrollPerPage : true
          });
          });
        </script>
        <?php } ?>


        <?php echo $content_bottom; ?></div>
</div><!--close main container-->
<script type="text/javascript"><!--
  $(document).ready(function() {
    $('.colorbox').colorbox({
      overlayClose: true,
      opacity: 0.5,
      rel: "colorbox"
    });
  });
  //--></script>
<script type="text/javascript"><!--
  $('#button-cart').bind('click', function() {
    $.ajax({
      url: 'index.php?route=checkout/cart/add',
      type: 'post',
      data: $('.product-info input[type=\'text\'], .product-info input[type=\'hidden\'], .product-info input[type=\'radio\']:checked, .product-info input[type=\'checkbox\']:checked, .product-info select, .product-info textarea'),
      dataType: 'json',
      success: function(json) {
        $('.success, .warning, .attention, information, .error').remove();

        if (json['error']) {
          if (json['error']['option']) {
            for (i in json['error']['option']) {
              $('#option-' + i).after('<span class="error">' + json['error']['option'][i] + '</span>');
            }
          }
        }

        if (json['success']) {
          $('#notification').html('<div class="success" style="display: none;">' + json['success'] + '<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');

          $('.success').fadeIn('slow');

          $('#cart-total').html(json['total']);

          $('html, body').animate({ scrollTop: 0 }, 'slow');
        }
      }
    });
  });
  //--></script>
<?php if ($options) { ?>
<script type="text/javascript" src="catalog/view/javascript/jquery/ajaxupload.js"></script>
<?php foreach ($options as $option) { ?>
<?php if ($option['type'] == 'file') { ?>
<script type="text/javascript"><!--
  new AjaxUpload('#button-option-<?php echo $option['product_option_id']; ?>', {
    action: 'index.php?route=product/product/upload',
    name: 'file',
    autoSubmit: true,
    responseType: 'json',
    onSubmit: function(file, extension) {
      $('#button-option-<?php echo $option['product_option_id']; ?>').after('<img src="catalog/view/theme/default/image/loading.gif" class="loading" style="padding-left: 5px;" />');
      $('#button-option-<?php echo $option['product_option_id']; ?>').attr('disabled', true);
    },
    onComplete: function(file, json) {
      $('#button-option-<?php echo $option['product_option_id']; ?>').attr('disabled', false);

      $('.error').remove();

      if (json['success']) {
        alert(json['success']);

        $('input[name=\'option[<?php echo $option['product_option_id']; ?>]\']').attr('value', json['file']);
      }

      if (json['error']) {
        $('#option-<?php echo $option['product_option_id']; ?>').after('<span class="error">' + json['error'] + '</span>');
      }

      $('.loading').remove();
    }
  });
  //--></script>
<?php } ?>
<?php } ?>
<?php } ?>
<script type="text/javascript"><!--
  $('#review .pagination a').live('click', function() {
    $('#review').fadeOut('slow');

    $('#review').load(this.href);

    $('#review').fadeIn('slow');

    return false;
  });

  $('#review').load('index.php?route=product/product/review&product_id=<?php echo $product_id; ?>');

  $('#button-review').bind('click', function() {
    $.ajax({
      url: 'index.php?route=product/product/write&product_id=<?php echo $product_id; ?>',
      type: 'post',
      dataType: 'json',
      data: 'name=' + encodeURIComponent($('input[name=\'name\']').val()) + '&text=' + encodeURIComponent($('textarea[name=\'text\']').val()) + '&rating=' + encodeURIComponent($('input[name=\'rating\']:checked').val() ? $('input[name=\'rating\']:checked').val() : '') + '&captcha=' + encodeURIComponent($('input[name=\'captcha\']').val()),
      beforeSend: function() {
        $('.success, .warning').remove();
        $('#button-review').attr('disabled', true);
        $('#review-title').after('<div class="attention"><img src="catalog/view/theme/default/image/loading.gif" alt="" /> <?php echo $text_wait; ?></div>');
      },
      complete: function() {
        $('#button-review').attr('disabled', false);
        $('.attention').remove();
      },
      success: function(data) {
        if (data['error']) {
          $('#review-title').after('<div class="warning">' + data['error'] + '</div>');
        }

        if (data['success']) {
          $('#review-title').after('<div class="success">' + data['success'] + '</div>');

          $('input[name=\'name\']').val('');
          $('textarea[name=\'text\']').val('');
          $('input[name=\'rating\']:checked').attr('checked', '');
          $('input[name=\'captcha\']').val('');
        }
      }
    });
  });
  //--></script>
<script type="text/javascript"><!--
  $('#tabs a').tabs();
  //--></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/ui/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript"><!--
  if ($.browser.msie && $.browser.version == 6) {
    $('.date, .datetime, .time').bgIframe();
  }

  $('.date').datepicker({dateFormat: 'yy-mm-dd'});
  $('.datetime').datetimepicker({
    dateFormat: 'yy-mm-dd',
    timeFormat: 'h:m'
  });
  $('.time').timepicker({timeFormat: 'h:m'});
  //--></script>
<?php echo $footer; ?>
