<?php echo $header; ?><?php if( ! empty( $mfilter_json ) ) { echo '<div id="mfilter-json" style="display:none">' . base64_encode( $mfilter_json ) . '</div>'; } ?><div class="container">
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
<?php echo $content_top; ?><div id="mfilter-content-container">
      
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>




  <h1><?php echo $heading_title; ?></h1>
  <label class="control-label"><?php echo $text_critea; ?></label>
  <div class="row">
  <div class="col-sm-5">
  <?php if ($search) { ?>
      <input type="text" name="search" id="filter_name" value="<?php echo $search; ?>"  class="form-control"/>
      <?php } else { ?>
      <input type="text" name="search" id="filter_name" value="<?php echo $search; ?>" class="form-control" onclick="this.value = '';" onkeydown="this.style.color = '000000'" style="color: #999;" />
      <?php } ?>
  </div>
  <div class="col-sm-3">
  <select name="category_id" class="form-control">
        <option value="0"><?php echo $text_category; ?></option>
        <?php foreach ($categories as $category_1) { ?>
        <?php if ($category_1['category_id'] == $category_id) { ?>
        <option value="<?php echo $category_1['category_id']; ?>" selected="selected"><?php echo $category_1['name']; ?></option>
        <?php } else { ?>
        <option value="<?php echo $category_1['category_id']; ?>"><?php echo $category_1['name']; ?></option>
        <?php } ?>
        <?php foreach ($category_1['children'] as $category_2) { ?>
        <?php if ($category_2['category_id'] == $category_id) { ?>
        <option value="<?php echo $category_2['category_id']; ?>" selected="selected">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_2['name']; ?></option>
        <?php } else { ?>
        <option value="<?php echo $category_2['category_id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_2['name']; ?></option>
        <?php } ?>
        <?php foreach ($category_2['children'] as $category_3) { ?>
        <?php if ($category_3['category_id'] == $category_id) { ?>
        <option value="<?php echo $category_3['category_id']; ?>" selected="selected">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_3['name']; ?></option>
        <?php } else { ?>
        <option value="<?php echo $category_3['category_id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_3['name']; ?></option>
        <?php } ?>
        <?php } ?>
        <?php } ?>
        <?php } ?>
      </select>
  </div>
  <div class="col-sm-4">
  <?php if ($sub_category) { ?>
      <input type="checkbox" name="sub_category" value="1" id="sub_category" checked="checked" />
      <?php } else { ?>
      <input type="checkbox" name="sub_category" value="1" id="sub_category" />
      <?php } ?>
      <label for="sub_category"><?php echo $text_sub_category; ?></label>
  </div>
</div>
<p>
    <?php if ($description) { ?>
    <input type="checkbox" name="description" value="1" id="description" checked="checked" />
    <?php } else { ?>
    <input type="checkbox" name="description" value="1" id="description" />
    <?php } ?>
    <label for="description"><?php echo $entry_description; ?></label>
  </p>
  <div class="buttons">
    <div class="right"><input type="button" value="<?php echo $button_search; ?>" id="button-search" class="button" /></div>
  </div>
  <h2><?php echo $text_search; ?></h2>
  <?php if ($products) { ?>
  <div class="product-filter">
    <div class="display"><b><?php echo $text_display; ?></b> <?php echo $text_list; ?> <b>/</b> <a onclick="display('grid');"><?php echo $text_grid; ?></a></div>
    <div class="limit"><?php echo $text_limit; ?>
      <select onchange="location = this.value;">
        <?php foreach ($limits as $limits) { ?>
        <?php if ($limits['value'] == $limit) { ?>
        <option value="<?php echo $limits['href']; ?>" selected="selected"><?php echo $limits['text']; ?></option>
        <?php } else { ?>
        <option value="<?php echo $limits['href']; ?>"><?php echo $limits['text']; ?></option>
        <?php } ?>
        <?php } ?>
      </select>
    </div>
    <div class="sort"><?php echo $text_sort; ?>
      <select onchange="location = this.value;">
        <?php foreach ($sorts as $sorts) { ?>
        <?php if ($sorts['value'] == $sort . '-' . $order) { ?>
        <option value="<?php echo $sorts['href']; ?>" selected="selected"><?php echo $sorts['text']; ?></option>
        <?php } else { ?>
        <option value="<?php echo $sorts['href']; ?>"><?php echo $sorts['text']; ?></option>
        <?php } ?>
        <?php } ?>
      </select>
    </div><div class="product-compare"><a href="<?php echo $compare; ?>" id="compare-total"><?php echo $text_compare; ?></a></div>
  </div>
  <?php if($this->config->get('marketshop_search_product_per_row')== 'pr3') { ?>
  <?php if ($column_left && $column_right) { ?>
  <?php $class_grid = 'col-lg-4 col-md-6 col-sm-4 col-xs-12'; ?>
  <?php } elseif ($column_left || $column_right) { ?>
  <?php $class_grid = 'col-lg-4 col-md-4 col-sm-4 col-xs-12'; ?>
  <?php } else { ?>
  <?php $class_grid = 'col-lg-4 col-md-4 col-sm-4 col-xs-12'; ?>
  <?php } ?>
  <?php } elseif ($this->config->get('marketshop_search_product_per_row')== 'pr4') {?>
  <?php if ($column_left && $column_right) { ?>
  <?php $class_grid = 'col-lg-3 col-md-3 col-sm-3 col-xs-12'; ?>
  <?php } elseif ($column_left || $column_right) { ?>
  <?php $class_grid = 'col-lg-3 col-md-3 col-sm-3 col-xs-12'; ?>
  <?php } else { ?>
  <?php $class_grid = 'col-lg-3 col-md-3 col-sm-3 col-xs-12'; ?>
  <?php } ?>
  <?php } elseif ($this->config->get('marketshop_search_product_per_row')== 'pr5') {?>
  <?php if ($column_left && $column_right) { ?>
  <?php $class_grid = 'col-lg-5ths col-md-5ths col-sm-3 col-xs-12'; ?>
  <?php } elseif ($column_left || $column_right) { ?>
  <?php $class_grid = 'col-lg-5ths col-md-5ths col-sm-3 col-xs-12'; ?>
  <?php } else { ?>
  <?php $class_grid = 'col-lg-5ths col-md-5ths col-sm-3 col-xs-12'; ?>
  <?php } ?>
  <?php } elseif ($this->config->get('marketshop_search_product_per_row')== 'pr6') {?>
  <?php if ($column_left && $column_right) { ?>
  <?php $class_grid = 'col-lg-2 col-md-2 col-sm-3 col-xs-12'; ?>
  <?php } elseif ($column_left || $column_right) { ?>
  <?php $class_grid = 'col-lg-2 col-md-2 col-sm-3 col-xs-12'; ?>
  <?php } else { ?>
  <?php $class_grid = 'col-lg-2 col-md-2 col-sm-3 col-xs-12'; ?>
  <?php } ?>
  <?php } ?>
  <div class="product-list row">
    <?php foreach ($products as $product) { ?>
    <div>
      <?php if ($product['thumb']) { ?>
      <div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" title="<?php echo $product['name']; ?>" alt="<?php echo $product['name']; ?>" /></a></div>
      <?php } ?>
      <div class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
      <div class="description"><?php echo $product['description']; ?></div>
      <?php if ($product['price']) { ?>
      <div class="price">
        <?php if (!$product['special']) { ?>
        <?php echo $product['price']; ?>
        <?php } else { ?>
        <span class="price-old"><?php echo $product['price']; ?></span> <span class="price-new"><?php echo $product['special']; ?></span>
        <?php if($this->config->get('marketshop_percentage_discount_badge')== 1) { ?><span class="saving">-<?php echo $product['saving']; ?>%</span><?php } ?>
        <?php } ?>
        <?php if ($product['tax']) { ?>
        <br />
        <span class="price-tax"><?php echo $text_tax; ?> <?php echo $product['tax']; ?></span>
        <?php } ?>
      </div>
      <?php } ?>
      <div class="rating"><img src="catalog/view/theme/marketshop/image/stars-<?php echo $product['rating'] ? $product['rating'] : 0; ?>.png" alt="<?php echo $product['reviews']; ?>" /></div>
      <div class="cart"><input type="button" value="<?php echo $button_cart; ?>" onclick="addToCart('<?php echo $product['product_id']; ?>');" class="button" /></div>
      <div class="wishlist"><a title="Add To WishList" onclick="addToWishList('<?php echo $product['product_id']; ?>');"><?php echo $button_wishlist; ?></a></div>
      <div class="compare"><a title="Add To Compare" onclick="addToCompare('<?php echo $product['product_id']; ?>');"><?php echo $button_compare; ?></a></div>
    </div>
    <?php } ?>
  </div>
  <div class="pagination"><?php echo $pagination; ?></div>
  <?php } else { ?>
  <div class="content"><?php echo $text_empty; ?></div>
  <?php }?>
  </div><?php echo $content_bottom; ?></div>
<?php echo $column_right; ?>
  </div></div>
<script type="text/javascript"><!--
$('#content input[name=\'search\']').keydown(function(e) {
	if (e.keyCode == 13) {
		$('#button-search').trigger('click');
	}
});

$('select[name=\'category_id\']').bind('change', function() {
	if (this.value == '0') {
		$('input[name=\'sub_category\']').attr('disabled', 'disabled');
		$('input[name=\'sub_category\']').removeAttr('checked');
	} else {
		$('input[name=\'sub_category\']').removeAttr('disabled');
	}
});

$('select[name=\'category_id\']').trigger('change');

$('#button-search').bind('click', function() {
	url = 'index.php?route=product/search';
	
	var search = $('#content input[name=\'search\']').attr('value');
	
	if (search) {
		url += '&search=' + encodeURIComponent(search);
	}

	var category_id = $('#content select[name=\'category_id\']').attr('value');
	
	if (category_id > 0) {
		url += '&category_id=' + encodeURIComponent(category_id);
	}
	
	var sub_category = $('#content input[name=\'sub_category\']:checked').attr('value');
	
	if (sub_category) {
		url += '&sub_category=true';
	}
		
	var filter_description = $('#content input[name=\'description\']:checked').attr('value');
	
	if (filter_description) {
		url += '&description=true';
	}

	location = url;
});

function display(view) {
	if (view == 'list') {
		$('#content .product-grid').attr('class', 'product-list row');
		$('#content .product-list > div').attr('class', 'col-xs-12');
		$("#content .product-list > .clearfix.visible-lg-block").remove();
		$('#content .product-list > div').each(function(index, element) {
			
			html = '<div class="left">';
			
			var image = $(element).find('.image').html();
			
			if (image != null) { 
				html += '<div class="image">' + image + '</div>';
			}
						
			html += '  <div class="name">' + $(element).find('.name').html() + '</div>';
			html += '  <div class="description">' + $(element).find('.description').html() + '</div>';
			
			var price = $(element).find('.price').html();
			
			if (price != null) {
				html += '<div class="price">' + price  + '</div>';
			}
			
			var rating = $(element).find('.rating').html();
			
			if (rating != null) {
				html += '<div class="rating">' + rating + '</div>';
			}
			
			html += '  <div class="cart">' + $(element).find('.cart').html() + '</div>';
			html += '  <div class="wishlist">' + $(element).find('.wishlist').html() + '</div>';
			html += '  <div class="compare">' + $(element).find('.compare').html() + '</div>';
				
			html += '</div>';
						
			$(element).html(html);
		});		
		
		$('.display').html('<b><?php echo $text_display; ?></b> <span class="grid1-icon"><?php echo $text_list; ?></span> <a title="<?php echo $text_grid; ?>" class="list-icon" onclick="display(\'grid\');"><?php echo $text_grid; ?></a>');
		
		$.totalStorage('display', 'list'); 
	} else {
			$('#content .product-list').attr('class', 'product-grid row');
			$('#content .product-grid > div').attr('class', '<?php if(isset($class_grid)) { ?><?php echo $class_grid; ?><?php } ?>');
			<?php if($this->config->get('marketshop_search_product_per_row')== 'pr3') { ?>
  <?php if ($column_left && $column_right) { ?>
$(document).ready(function(){
$screensize = $(window).width();
    if ($screensize > 1199) {
        $('#content .product-grid > div:nth-child(3n)').after('<span class="clearfix visible-lg-block"></span>');
    }
    if ($screensize < 1199 && $screensize > 991) {
        $('#content .product-grid > div:nth-child(2n)').after('<span class="clearfix visible-lg-block visible-md-block"></span>');
    }
	if ($screensize < 991) {
        $('#content .product-grid > div:nth-child(3n)').after('<span class="clearfix visible-lg-block visible-sm-block"></span>');
    }
$( window ).resize(function() {
    $screensize = $(window).width();
    if ($screensize > 1199) {
        $("#content .product-grid > .clearfix.visible-lg-block").remove();
        $('#content .product-grid > div:nth-child(3n)').after('<span class="clearfix visible-lg-block"></span>');
    } 
    if ($screensize < 1199 && $screensize > 991) {
        $("#content .product-grid > .clearfix.visible-lg-block").remove();
        $('#content .product-grid > div:nth-child(2n)').after('<span class="clearfix visible-lg-block visible-md-block"></span>');
    }
	if ($screensize < 991) {
        $("#content .product-grid > .clearfix.visible-lg-block").remove();
        $('#content .product-grid > div:nth-child(3n)').after('<span class="clearfix visible-lg-block visible-sm-block"></span>');
    }
	if ($screensize < 767) {
        $("#content .product-grid > .clearfix.visible-lg-block").remove();
    }
});});
  <?php } elseif ($column_left || $column_right) { ?>
$(document).ready(function(){
$screensize = $(window).width();
    if ($screensize > 1199) {
        $('#content .product-grid > div:nth-child(3n)').after('<span class="clearfix visible-lg-block"></span>');
    }
    if ($screensize < 1199 && $screensize > 991) {
        $('#content .product-grid > div:nth-child(3n)').after('<span class="clearfix visible-lg-block visible-md-block"></span>');
    }
	if ($screensize < 991) {
        $('#content .product-grid > div:nth-child(3n)').after('<span class="clearfix visible-lg-block visible-sm-block"></span>');
    }
$( window ).resize(function() {
    $screensize = $(window).width();
    if ($screensize > 1199) {
        $("#content .product-grid > .clearfix.visible-lg-block").remove();
        $('#content .product-grid > div:nth-child(3n)').after('<span class="clearfix visible-lg-block"></span>');
    } 
    if ($screensize < 1199 && $screensize > 991) {
        $("#content .product-grid > .clearfix.visible-lg-block").remove();
        $('#content .product-grid > div:nth-child(3n)').after('<span class="clearfix visible-lg-block visible-md-block"></span>');
    }
	if ($screensize < 991) {
        $("#content .product-grid > .clearfix.visible-lg-block").remove();
        $('#content .product-grid > div:nth-child(3n)').after('<span class="clearfix visible-lg-block visible-sm-block"></span>');
    }
	if ($screensize < 767) {
        $("#content .product-grid > .clearfix.visible-lg-block").remove();
    }
});});
  <?php } else { ?>
$(document).ready(function(){
$screensize = $(window).width();
    if ($screensize > 1199) {
        $('#content .product-grid > div:nth-child(3n)').after('<span class="clearfix visible-lg-block"></span>');
    }
    if ($screensize < 1199 && $screensize > 991) {
        $('#content .product-grid > div:nth-child(3n)').after('<span class="clearfix visible-lg-block visible-md-block"></span>');
    }
	if ($screensize < 991) {
        $('#content .product-grid > div:nth-child(3n)').after('<span class="clearfix visible-lg-block visible-sm-block"></span>');
    }
$( window ).resize(function() {
    $screensize = $(window).width();
    if ($screensize > 1199) {
        $("#content .product-grid > .clearfix.visible-lg-block").remove();
        $('#content .product-grid > div:nth-child(3n)').after('<span class="clearfix visible-lg-block"></span>');
    } 
    if ($screensize < 1199 && $screensize > 991) {
        $("#content .product-grid > .clearfix.visible-lg-block").remove();
        $('#content .product-grid > div:nth-child(3n)').after('<span class="clearfix visible-lg-block visible-md-block"></span>');
    }
	if ($screensize < 991) {
        $("#content .product-grid > .clearfix.visible-lg-block").remove();
        $('#content .product-grid > div:nth-child(3n)').after('<span class="clearfix visible-lg-block visible-sm-block"></span>');
    }
	if ($screensize < 767) {
        $("#content .product-grid > .clearfix.visible-lg-block").remove();
    }
});});
  <?php } ?>
  <?php } elseif ($this->config->get('marketshop_search_product_per_row')== 'pr4') {?>
$(document).ready(function(){
$screensize = $(window).width();
    if ($screensize > 1199) {
        $('#content .product-grid > div:nth-child(4n)').after('<span class="clearfix visible-lg-block"></span>');
    }
    if ($screensize < 1199 && $screensize > 991) {
        $('#content .product-grid > div:nth-child(4n)').after('<span class="clearfix visible-lg-block visible-md-block"></span>');
    }
	if ($screensize < 991) {
        $('#content .product-grid > div:nth-child(4n)').after('<span class="clearfix visible-lg-block visible-sm-block"></span>');
    }
$( window ).resize(function() {
    $screensize = $(window).width();
    if ($screensize > 1199) {
        $("#content .product-grid > .clearfix.visible-lg-block").remove();
        $('#content .product-grid > div:nth-child(4n)').after('<span class="clearfix visible-lg-block"></span>');
    } 
    if ($screensize < 1199 && $screensize > 991) {
        $("#content .product-grid > .clearfix.visible-lg-block").remove();
        $('#content .product-grid > div:nth-child(4n)').after('<span class="clearfix visible-lg-block visible-md-block"></span>');
    }
	if ($screensize < 991) {
        $("#content .product-grid > .clearfix.visible-lg-block").remove();
        $('#content .product-grid > div:nth-child(4n)').after('<span class="clearfix visible-lg-block visible-sm-block"></span>');
    }
	if ($screensize < 767) {
        $("#content .product-grid > .clearfix.visible-lg-block").remove();
    }
});});
  <?php } elseif ($this->config->get('marketshop_search_product_per_row')== 'pr5') {?>
$(document).ready(function(){
$screensize = $(window).width();
    if ($screensize > 1199) {
        $('#content .product-grid > div:nth-child(5n)').after('<span class="clearfix visible-lg-block"></span>');
    }
    if ($screensize < 1199 && $screensize > 991) {
        $('#content .product-grid > div:nth-child(5n)').after('<span class="clearfix visible-lg-block visible-md-block"></span>');
    }
	if ($screensize < 991) {
        $('#content .product-grid > div:nth-child(4n)').after('<span class="clearfix visible-lg-block visible-sm-block"></span>');
    }
$( window ).resize(function() {
    $screensize = $(window).width();
    if ($screensize > 1199) {
        $("#content .product-grid > .clearfix.visible-lg-block").remove();
        $('#content .product-grid > div:nth-child(5n)').after('<span class="clearfix visible-lg-block"></span>');
    } 
    if ($screensize < 1199 && $screensize > 991) {
        $("#content .product-grid > .clearfix.visible-lg-block").remove();
        $('#content .product-grid > div:nth-child(5n)').after('<span class="clearfix visible-lg-block visible-md-block"></span>');
    }
	if ($screensize < 991) {
        $("#content .product-grid > .clearfix.visible-lg-block").remove();
        $('#content .product-grid > div:nth-child(4n)').after('<span class="clearfix visible-lg-block visible-sm-block"></span>');
    }
	if ($screensize < 767) {
        $("#content .product-grid > .clearfix.visible-lg-block").remove();
    }
});});
  <?php } elseif ($this->config->get('marketshop_search_product_per_row')== 'pr6') {?>
$(document).ready(function(){
$screensize = $(window).width();
    if ($screensize > 1199) {
        $('#content .product-grid > div:nth-child(6n)').after('<span class="clearfix visible-lg-block"></span>');
    }
    if ($screensize < 1199 && $screensize > 991) {
        $('#content .product-grid > div:nth-child(6n)').after('<span class="clearfix visible-lg-block visible-md-block"></span>');
    }
	if ($screensize < 991) {
        $('#content .product-grid > div:nth-child(4n)').after('<span class="clearfix visible-lg-block visible-sm-block"></span>');
    }
$( window ).resize(function() {
    $screensize = $(window).width();
    if ($screensize > 1199) {
        $("#content .product-grid > .clearfix.visible-lg-block").remove();
        $('#content .product-grid > div:nth-child(6n)').after('<span class="clearfix visible-lg-block"></span>');
    } 
    if ($screensize < 1199 && $screensize > 991) {
        $("#content .product-grid > .clearfix.visible-lg-block").remove();
        $('#content .product-grid > div:nth-child(6n)').after('<span class="clearfix visible-lg-block visible-md-block"></span>');
    }
	if ($screensize < 991) {
        $("#content .product-grid > .clearfix.visible-lg-block").remove();
        $('#content .product-grid > div:nth-child(4n)').after('<span class="clearfix visible-lg-block visible-sm-block"></span>');
    }
	if ($screensize < 767) {
        $("#content .product-grid > .clearfix.visible-lg-block").remove();
    }
});});
  <?php } ?>
			$('#content .product-grid > div').each(function(index, element) {
			html = '';
			
			var image = $(element).find('.image').html();
			
			if (image != null) {
				html += '<div class="image">' + image + '</div>';
			}
			
			html += '<div class="name">' + $(element).find('.name').html() + '</div>';
			html += '<div class="description">' + $(element).find('.description').html() + '</div>';
			
			var price = $(element).find('.price').html();
			
			if (price != null) {
				html += '<div class="price">' + price  + '</div>';
			}
			
			var rating = $(element).find('.rating').html();
			
			if (rating != null) {
				html += '<div class="rating">' + rating + '</div>';
			}
			
			html += '<div class="cart">' + $(element).find('.cart').html() + '</div>';						
			
			html += '<div class="wishlist">' + $(element).find('.wishlist').html() + '</div>';
			html += '<div class="compare">' + $(element).find('.compare').html() + '</div>';
			
			$(element).html(html);
		});	
					
		$('.display').html('<b><?php echo $text_display; ?></b> <a title="<?php echo $text_list; ?>" class="grid-icon" onclick="display(\'list\');"><?php echo $text_list; ?></a><span class="list1-icon"><?php echo $text_grid; ?></span>');
		
		$.totalStorage('display', 'grid');
	}
}

view = $.totalStorage('display');

if (view) {
	display(view);
} else {
	display('grid');
}
//--></script> 
<?php echo $footer; ?>