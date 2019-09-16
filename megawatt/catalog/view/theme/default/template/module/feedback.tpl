<style>
#webme_sidebar_feedback<?php echo $i?> input, #webme_sidebar_feedback<?php echo $i?> textarea {
	width: 145px;
	<?php if ($setting['module_style'] == 'simple') { ?>
	font-family: Arial;
	<?php } ?>
}
#webme_sidebar_feedback<?php echo $i?> .warning {
	position: absolute;
	left: 0px;
	width: 145px;
	top: 15%;
	z-index: 2;
	margin: 0 0 0 145px;
	box-shadow: 2px 2px 4px #901d1d;
	cursor: pointer;
}
#webme_sidebar_feedback<?php echo $i?> .entry_captcha {
	padding: 0px 0 6px;
	text-align: center;
}
#webme_sidebar_feedback<?php echo $i?>, #webme_sidebar_feedback<?php echo $i?> table, #webme_sidebar_feedback<?php echo $i?> table td {
	position: relative;
}
.wsf_captcha_image_div {
	width: 77px; float: left;
}
.wsf_captcha_image_div img {
	border: 1px solid #ccc;
	cursor: pointer;
}
#webme_sidebar_feedback<?php echo $i?> input#wsf_captcha<?php echo $i?> {
	width: 50px;
	float: left;
	margin: 0 0 0 10px;
	height: 14px;
}
.clearLine {
	clear: both;
	text-align: left;
	width: 100%;
	height: 0px;
	margin: 0;
	padding: 0;
}
#ajax_loading_form<?php echo $i?> {
	margin-left: 5px;
}
.cfblock{
	background: #f4f4f5;
    padding: 20px 20px 0 20px;
    text-align: center;
}
.cfblock .box-content{
	background: #f4f4f5;	
}
.cfblock input, .cfblock textarea{
	width:100%!important;
	margin: 5px 0;
    padding: 10px;
    border: 1px solid rgba(230, 227, 227, 0.76);
}
.cfblock input{
    height: 40px;
    padding: 0 0 0 10px;
    border: 1px solid rgba(230, 227, 227, 0.76);
}
.cfblock .box-heading{
    color: #6a6a6b!important;
	border-bottom: 0px;
}
.cfblock a.button{
	background: #6a6a6b!important;
    margin-top: 10px;
}
</style>
<div class="cfblock">
<div class="box">

	<div class="box-heading">
		<?php echo $heading_title; ?>
	</div>

	<div class="box-content">
	
		<div id="webme_sidebar_feedback<?php echo $i?>" class="middle">
			<div id="tmp_<?php echo $i?>"></div>
			<div id="wsf_enquiry_send_result<?php echo $i?>"></div>
		<div id="sidebar_feedback_div<?php echo $i?>">
		<form action="<?php echo str_replace('&', '&amp;', $action); ?>" method="post" enctype="multipart/form-data" id="sidebar_feedback<?php echo $i?>">
		<input type="hidden" id="form_id<?php echo $i?>" name="form_id" value="<?php echo $i; ?>" />
			<table width="100%">
			<? if (isset($setting['name'])) { ?>
			  <tr>
				<td>
					<?php if ($setting['module_style'] == 'classic') { ?>
						<input placeholder="<?php echo $entry_name; ?>" type="text" id="wsf_name<?php echo $i?>" name="wsf_name" value="<?php echo $name; ?>" />
					<?php } elseif ($setting['module_style'] == 'simple') { ?>
						<input type="text" id="wsf_name<?php echo $i?>" name="wsf_name" title="<?php echo $entry_name; ?>" value="<?php echo (empty($name) ? $entry_name : $name); ?>" />
					<?php } ?>
				  <span id="wsf_error_name<?php echo $i?>" class="warning" style="display:none;"></span>
				  </td>
			  </tr>
			<? } ?>
			<? if (isset($setting['phone'])) { ?>
			  <tr>
				<td>
					<?php if ($setting['module_style'] == 'classic') { ?>
						<input placeholder="<?php echo $entry_phone; ?>" type="text" id="wsf_phone<?php echo $i?>" name="wsf_phone" value="<?php echo $phone; ?>" />
					<?php } elseif ($setting['module_style'] == 'simple') { ?>
						<input type="text" id="wsf_phone<?php echo $i?>" name="wsf_phone" title="<?php echo $entry_phone; ?>" value="<?php echo (empty($phone) ? $entry_phone : $phone); ?>" />
					<?php } ?>
					<span id="wsf_error_phone<?php echo $i?>" class="warning" style="display:none;"></span>
				 </td>
			  </tr>
			<? } ?>
			<? if (isset($setting['email'])) { ?>
			  <tr>
				<td>
					<?php if ($setting['module_style'] == 'classic') { ?>
						<input placeholder="<?php echo $entry_email; ?>" type="text" id="wsf_email<?php echo $i?>" name="wsf_email" value="<?php echo $email; ?>" />
					<?php } elseif ($setting['module_style'] == 'simple') { ?>
						<input type="text" id="wsf_email<?php echo $i?>" name="wsf_email" title="<?php echo $entry_email; ?>" value="<?php echo (empty($email) ? $entry_email : $email); ?>" />
					<?php } ?>
					<span id="wsf_error_email<?php echo $i?>" class="warning" style="display:none;"></span>
				  </td>
			  </tr>
			<? } ?>
			<? if (isset($setting['text'])) { ?>
			  <tr>
				<td>
					<?php if ($setting['module_style'] == 'classic') { ?>
						<textarea placeholder="<?php echo $entry_enquiry; ?>" id="wsf_enquiry<?php echo $i?>" name="wsf_enquiry" rows="10"><?php echo $enquiry; ?></textarea>
					<?php } elseif ($setting['module_style'] == 'simple') { ?>
					<textarea id="wsf_enquiry<?php echo $i?>" title="<?php echo $entry_enquiry; ?>" name="wsf_enquiry" rows="10"><?php echo (empty($enquiry) ? $entry_enquiry : $enquiry); ?></textarea>
					<?php } ?>
				  <span id="wsf_error_enquiry<?php echo $i?>" class="warning" style="display:none;"></span>
				  </td>
			  </tr>
			<? } ?>
			<? if (isset($setting['captcha'])) { ?>
			  <tr>
				<td><div class="entry_captcha"><?php echo $entry_captcha; ?></div>
					<div class="wsf_captcha_image_div">
						<img id="wsf_captcha_image_img<?php echo $i?>" src="">
					</div>
					<input type="text" id="wsf_captcha<?php echo $i?>" name="wsf_captcha" value="<?php echo $captcha; ?>" autocomplete="off" />
					<div class="clearLine"></div>
					<span id="wsf_error_captcha<?php echo $i?>" class="warning" style="display:none;"></span>
					<a class="reload_captcha" id="reload_captcha<?php echo $i?>"><small><?php echo $reload_captcha; ?></small></a>
					<input type="hidden" id="wsf_captcha_id<?php echo $i?>" title="" name="wsf_captcha_id" value="<?php echo $captcha_id; ?>" />
				</td>
			  </tr>
			<? } ?>
			  <tr>
				<td align="center"><a class="button" id="feedback_submitter<?php echo $i?>"><span><?php echo $button_send_enquiry; ?></span></a></td>
			  </tr>
			</table>
		</form>
		</div>
		</div>
		<div class="bottom">&nbsp;</div>
	</div>
</div>
</div>
<script type="text/javascript"><!--
$(document).ready(function() {
	<?php if ($setting['module_style'] == 'simple') { ?>
	$('#webme_sidebar_feedback<?php echo $i?> input, #webme_sidebar_feedback<?php echo $i?> textarea').focus(function() {
		if ($(this).val() == $(this).attr('title')) {
			$(this).val('');
		}
	});
	$('#webme_sidebar_feedback<?php echo $i?> input, #webme_sidebar_feedback<?php echo $i?> textarea').blur(function() {
		if ($(this).val() == '') {
			$(this).val($(this).attr('title'));
		}
	});
	<?php } ?>
	$('#webme_sidebar_feedback<?php echo $i?>').on('focus', 'input, textarea', function() {
		$(this).parent().find('.warning').delay(1000).fadeOut('slow');
	});
	
	$('#webme_sidebar_feedback<?php echo $i?>').on('click', '.warning', function() {
		$(this).fadeOut('slow');
	});
	
	jQuery.ajax({
		type: "GET",
		url: "<?php echo $captchaURLreload; ?>",
		data: {captcha_id: '<?php echo $captcha_id; ?>'},
		cache: false
	}).done(function( image ) {
		jQuery("#wsf_captcha_image_img<?php echo $i?>").attr('src', 'data:image/jpeg;base64,' + image);
	});
	
});

$('#wsf_captcha_image_img<?php echo $i?>').click(function(){
	var captcha_id = parseInt((Math.random() * 1000) + 1);
	jQuery('#wsf_captcha_id<?php echo $i?>').val(captcha_id);
	jQuery.ajax({
		type: "GET",
		url: "<?php echo $captchaURLreload; ?>",
		data: {captcha_id: captcha_id},
		cache: false
	}).done(function( image ) {
		jQuery("#wsf_captcha_image_img<?php echo $i?>").attr('src', 'data:image/jpeg;base64,' + image);
	});
});

$('#reload_captcha<?php echo $i?>').click(function(){
	var captcha_id = parseInt((Math.random() * 1000) + 1);
	jQuery('#wsf_captcha_id<?php echo $i?>').val(captcha_id);
	jQuery.ajax({
		type: "GET",
		url: "<?php echo $captchaURLreload; ?>",
		data: {captcha_id: captcha_id},
		cache: false
	}).done(function( image ) {
		jQuery("#wsf_captcha_image_img<?php echo $i?>").attr('src', 'data:image/jpeg;base64,' + image);
	});
});

$('#one_more_msg_href<?php echo $i?>').live('click', function(){
	$('#wsf_enquiry_send_result<?php echo $i?>').hide('fast', function() {; 
		$('#sidebar_feedback_div<?php echo $i?>').show('fast');
	});
});

$('#feedback_submitter<?php echo $i?>').click(function(){
	
	$("input, textarea").blur();
	
	<?php if ($setting['module_style'] == 'simple') { ?>

		if ($('#wsf_enquiry<?php echo $i?>').val() == '<?php echo $entry_enquiry; ?>') {
			$('#wsf_error_enquiry<?php echo $i?>').html('<?php echo $entry_error_enquiry; ?>');
			$('#wsf_error_enquiry<?php echo $i?>').show();
			var error = true;
		}
		if ($('#wsf_name<?php echo $i?>').val() == '<?php echo $entry_name; ?>') {
			$('#wsf_error_name<?php echo $i?>').html('<?php echo $entry_error_name; ?>');
			$('#wsf_error_name<?php echo $i?>').show();
			var error = true;
		}
		if ($('#wsf_phone<?php echo $i?>').val() == '<?php echo $entry_phone; ?>') {
			$('#wsf_error_phone<?php echo $i?>').html('<?php echo $entry_error_phone; ?>');
			$('#wsf_error_phone<?php echo $i?>').show();
			var error = true;
		}
		if ($('#wsf_email<?php echo $i?>').val() == '<?php echo $entry_email; ?>') {
			$('#wsf_error_email<?php echo $i?>').html('<?php echo $entry_error_email; ?>');
			$('#wsf_error_email<?php echo $i?>').show();
			var error = true;
		}
		if (error == true) {
			return false;
		}
	<?php } ?>
	
	$.ajax({
		type: 'post',
		url: '<?php echo $action; ?>',
		dataType: 'json',
		data: $('#sidebar_feedback<?php echo $i?>').serialize(),
		beforeSend: function() {
			$('#feedback_submitter<?php echo $i?>').after('<img src="<?php echo HTTP_SERVER; ?>/catalog/view/theme/default/image/loading.gif" id="ajax_loading_form<?php echo $i?>" />');
		},
		complete: function() {
			$('#ajax_loading_form<?php echo $i?>').remove();
		},
		success: function(data) {
		
			if (data.error) {
			
				if (!data.error_name) { $('#wsf_error_name<?php echo $i?>').hide(); }
				if (!data.error_phone) { $('#wsf_error_phone<?php echo $i?>').hide(); }
				if (!data.error_email) { $('#wsf_error_email<?php echo $i?>').hide(); }
				if (!data.error_enquiry) { $('#wsf_error_enquiry<?php echo $i?>').hide(); }
				if (!data.error_captcha) { $('#wsf_error_captcha<?php echo $i?>').hide(); }
				
				if (data.error_required) { 
					alert(data.error_required); 
				}
				if (data.error_name) {
					$('#wsf_error_name<?php echo $i?>').html(data.error_name);
					$('#wsf_error_name<?php echo $i?>').show();
				}
				if (data.error_phone) {
					$('#wsf_error_phone<?php echo $i?>').html(data.error_phone);
					$('#wsf_error_phone<?php echo $i?>').show();
				}
				if (data.error_email) {
					$('#wsf_error_email<?php echo $i?>').html(data.error_email);
					$('#wsf_error_email<?php echo $i?>').show();
				}
				if (data.error_enquiry) {
					$('#wsf_error_enquiry<?php echo $i?>').html(data.error_enquiry);
					$('#wsf_error_enquiry<?php echo $i?>').show();
				}
				if (data.error_captcha) {
					$('#wsf_error_captcha<?php echo $i?>').html(data.error_captcha);
					$('#wsf_error_captcha<?php echo $i?>').show();
				}
			}
			
			if (data.success) {
				$('#wsf_error_name<?php echo $i?>').hide();
				$('#wsf_error_phone<?php echo $i?>').hide();
				$('#wsf_error_email<?php echo $i?>').hide();
				$('#wsf_error_enquiry<?php echo $i?>').hide();
				$('#wsf_error_captcha<?php echo $i?>').hide();
				
				$('#wsf_name<?php echo $i?>').val('');
				$('#wsf_phone<?php echo $i?>').val('');
				$('#wsf_email<?php echo $i?>').val('');
				$('#wsf_enquiry<?php echo $i?>').val('');
				$('#wsf_captcha<?php echo $i?>').val('');
				
				$('#sidebar_feedback_div<?php echo $i?>').hide();
				
				$('#wsf_enquiry_send_result<?php echo $i?>').html('<div class="success">' + data.result + '</div>');
				$('#wsf_enquiry_send_result<?php echo $i?>').show();
				
			}
			
			var captcha_id = parseInt((Math.random() * 1000) + 1);
			jQuery('#wsf_captcha_id<?php echo $i?>').val(captcha_id);
			jQuery.ajax({
				type: "GET",
				url: "<?php echo $captchaURLreload; ?>",
				data: {captcha_id: captcha_id},
				cache: false
			}).done(function( image ) {
				jQuery("#wsf_captcha_image_img<?php echo $i?>").attr('src', 'data:image/jpeg;base64,' + image);
			});
	
		}
	});
});
//--></script>
