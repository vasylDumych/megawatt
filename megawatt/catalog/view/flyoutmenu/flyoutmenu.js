/* This part of code is by Flo from shopencart.com */
(function($) {

 function superflyoutalign() {
  var total_width = $('body').outerWidth(false);
  var flyoutmenu_width = $('.flyoutmenu').outerWidth(false);
  if (total_width > 767 || typeof runnedonce == 'undefined' || $('.flyoutmenu').hasClass('superbig')) {
	runnedonce = true;
	$('.flyoutmenu').removeClass('respsmall');
	$('.flyoutmenu').addClass('superbig');
	if (total_width < 768) {
		$('.flyoutmenu').removeClass('superbig');
		$('.flyoutmenu').addClass('respsmall');
	}
	$('.flyoutmenu.ontheleft ul > li > a + div').each(function(index, element) {	
		if (!$(this).hasClass('withflyout')) {
			if($(this).data("width")) {
				$(this).css('width', $(this).data("width")+'px');
			} else {
				$(this).css('width', '1200px');
			}
		}
		var flyoutoffset = $('.flyoutmenu.ontheleft').offset();
        var aprox_max_width = total_width - (flyoutoffset.left * 2 + flyoutmenu_width);
		if (($(this).outerWidth(false)) > (aprox_max_width)) {
			$(this).css('width', Math.round(aprox_max_width) + 'px');
		}
		$(this).find('.inflyouttoright').css('width', '800px');
		var z = aprox_max_width - 200;
		if($(this).find('.inflyouttoright').outerWidth(false) > z ) {
		  $(this).find('.inflyouttoright').css('width', z + 'px');
		}
	});
	$('.flyoutmenu.ontheright ul > li > a + div').each(function(index, element) {	
		if (!$(this).hasClass('withflyout')) {
			if($(this).data("width")) {
				$(this).css('width', $(this).data("width")+'px');
			} else {
				$(this).css('width', '1200px');
			}
		}
		var flyoutoffset = $('.flyoutmenu.ontheright').offset();
		var right_offset = total_width - (flyoutoffset.left + $('.flyoutmenu.ontheright').outerWidth(false));
        var aprox_max_width = total_width - (right_offset * 2 + flyoutmenu_width);
		if (($(this).outerWidth(false)) > (aprox_max_width)) {
			$(this).css('width', Math.round(aprox_max_width) + 'px');
		}
		$(this).find('.inflyouttoright').css('width', '800px');
		var z = aprox_max_width - 200;
		if($(this).find('.inflyouttoright').outerWidth(false) > z ) {
		  $(this).find('.inflyouttoright').css('width', z + 'px');
		}
	});
  }
 }
 var timpderesize;
 $(window).resize(function() {
    clearTimeout(timpderesize);
    timpderesize = setTimeout(superflyoutalign, 500);
 });
 if (window.addEventListener) {	
	window.addEventListener("orientationchange", superflyoutalign, false);
 }
 
$(document).ready(function() {
    superflyoutalign();
	setTimeout(function(){ superflyoutalign(); }, 800);
	setTimeout(function(){ superflyoutalign(); }, 1600);
	$( '.flyoutmenu > ul > li.mkids' ).doubleTapToGo();
	$( '.flyoutmenu ul li div.bigdiv.withflyout > .withchildfo.hasflyout' ).doubleTapToGo();
    
	$('.flyoutmenu a.superdropper').bind('click', function(event) {
		event.preventDefault;
        $(this).parent().toggleClass('exped');
	});
	$('.flyoutmenu a.mobile-trigger').bind('click', function(event) {
		event.preventDefault;
		$(this).next('ul').toggleClass('exped');
	});
});
})(jQuery);
/*  The below code by:
	By Osvaldas Valutis, www.osvaldas.info
	Available for use under the MIT License
*/
;(function( $, window, document, undefined )
{
	$.fn.doubleTapToGo = function( params )
	{
		if( !( 'ontouchstart' in window ) &&
			!navigator.msMaxTouchPoints &&
			!navigator.userAgent.toLowerCase().match( /windows phone os 7/i ) ) return false;

		this.each( function()
		{
			var curItem = false;

			$( this ).on( 'click', function( e )
			{
				var item = $( this );
				if( item[ 0 ] != curItem[ 0 ] )
				{
					e.preventDefault();
					curItem = item;
				}
			});

			$( document ).on( 'click touchstart MSPointerDown', function( e )
			{
				var resetItem = true,
					parents	  = $( e.target ).parents();

				for( var i = 0; i < parents.length; i++ )
					if( parents[ i ] == curItem[ 0 ] )
						resetItem = false;

				if( resetItem )
					curItem = false;
			});
		});
		return this;
	};
})( jQuery, window, document );