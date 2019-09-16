$(document).ready(function () {
	$('.buyinoneclick-send').live('click', function () {
		var wait = $(this).data('wait');
		$.ajax({
			url: 'index.php?route=module/buyinoneclick/write',
			type: 'post',
			dataType: 'json',
			data: 'contact='+encodeURIComponent($('input[name=\'buyinoneclick_contact\']').val())+'&product_id='+$('input[name=\'product_id\']').val()+'&quantity='+$('input[name=\'quantity_gs\']').val()+'&name='+encodeURIComponent($('input[name=\'buyinoneclick_name\']').val()),
			beforeSend: function () {
				$('.success, .attention').remove();
				$(this).attr('disabled', true);
				$('.buyinoneclick-title').after('<div class="attention"><img src="catalog/view/theme/default/image/loading.gif" alt="" />'+wait+'</div>');

				$.colorbox.resize();
			},
			complete: function () {
				$(this).attr('disabled', false);
				$('.attention').remove();

				$.colorbox.resize();
			},
			success: function (data) {
				if (data['error']) {
					$('.buyinoneclick .error').remove();

					if (data['error']['contact']) {
						$('.buyinoneclick .contact_error').after('<span class="error">'+data['error']['contact']+'</span>');
					}
				}

				if (data['success']) {
					$('.buyinoneclick').after(data['success']);
					$('.buyinoneclick').remove();
				}

				$.colorbox.resize();
			}
		});
	});
});

function addToBuyinoneclick(productId) {
	var productId = productId ? productId : $('input[name=\'product_id\']').val();
  $.colorbox({
		scrolling: false,
		overlayClose: true,
		opacity: 0.5,
		href: 'index.php?route=module/buyinoneclick/getForm',
		data: 'product_id='+productId,
		onComplete: function () {
			var phone_mask = $('input[name=\'buyinoneclick_contact\']').data('phoneMask');

			if (phone_mask) {
				$('input[name=\'buyinoneclick_contact\']').mask(phone_mask);
			}
		}
	});
}