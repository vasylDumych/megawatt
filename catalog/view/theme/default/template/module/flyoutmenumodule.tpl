<?php if ($mitems) { ?>
<?php  ($direction == 'rtl') ? $dir_class = ' fly_rtl' : $dir_class = ''; ?>
<div class="<?php echo $skin; ?> superbig flyoutmenu sho <?php echo $i_class . $pos_class . $col_class . $dir_class; ?>">
	<a class="mobile-trigger"><?php echo $categ_text; ?></a>
	<ul>
		<li class="menu-title"><span class="tll"><?php echo $categ_text; ?></span></li>
		<?php foreach ($mitems as $mitem) { ?>
			<li class="tlli<?php if ($mitem['children'] || ($mitem['chtml'] && $mitem['chtml'] == 1)) { ?> mkids<?php } ?><?php if ($mitem['cssid'] == 'login_drop') { ?> mkids lad<?php } ?><?php if ($mitem['tlstyle']) { ?> <?php echo $mitem['tlstyle']; ?><?php } ?>">
			  <?php if ($mitem['children'] || $mitem['cssid'] == 'login_drop' || ($mitem['chtml'] && $mitem['chtml'] == 1)) { ?>
				<a class="superdropper"><span>+</span><span>-</span></a>
			  <?php } ?>
				<a class="tll" <?php if ($mitem['tlcolor']) { ?>style="color: <?php echo $mitem['tlcolor']; ?>;" <?php } ?><?php if (($mitem['children'] || ($mitem['chtml'] && $mitem['chtml'] == 1)) && $linkoftopitem != 'topitem') { ?><?php } else { ?> <?php if ($mitem['href']) { ?>href="<?php echo $mitem['href']; ?>"<?php } ?> <?php } ?>><?php echo ($mitem['item_topimg']) ? '<img src="'.$mitem['item_topimg'].'" alt="'.$mitem['name'].'" /><br />' : '' ; ?><?php echo $mitem['name']; ?></a>
				
				<?php if ($mitem['children'] && ($mitem['view'] == 'f0' || $mitem['view'] == 'f1')) { ?>
					<div class="bigdiv withflyout"<?php if ($mitem['dwidth']) { ?> style="width: <?php echo $mitem['dwidth']; ?>px;"<?php } ?>>
						<?php if ($dropdowntitle) { ?>
							<div class="headingoftopitem">
								<?php if ($mitem['href'] && $linkoftopitem == 'heading') { ?>
									<h2><a href="<?php echo $mitem['href']; ?>"><?php echo $mitem['name']; ?></a></h2>
								<?php } else { ?>
									<h2><?php echo $mitem['name']; ?></h2>
								<?php } ?>
							</div>
						<?php } ?>
						<?php foreach ($mitem['children'] as $mildren) { ?>
							<div class="withchildfo<?php if ($mildren['gchildren']) { ?> hasflyout<?php } ?>">
							  <?php if ($mildren['gchildren']) { ?><a class="superdropper"><span>+</span><span>-</span></a><?php } ?>
								<a class="theparent" href="<?php echo $mildren['href']; ?>"><?php echo $mildren['name']; ?></a>
								<?php if ($mildren['gchildren']) { ?>
									<div class="flyouttoright">
										<div class="inflyouttoright" <?php echo ($flyout_width ? 'style="width: '.$flyout_width.'px"' : ''); ?>>
											<?php if ($mitem['view'] == 'f0') { ?>
												<?php foreach ($mildren['gchildren'] as $gmildren) { ?>
													<div class="withchild" <?php if ($mitem['iwidth']) { ?> style="width: <?php echo $mitem['iwidth']; ?>px;"<?php } ?>>
														<a class="theparent" href="<?php echo $gmildren['href']; ?>"><?php echo $gmildren['name']; ?></a>
														<?php if (isset($gmildren['ggchildren'])) { ?>
															<?php if ($gmildren['ggchildren']) { ?>
																<span class="mainexpand"></span>
																<ul class="child-level">
																	<?php foreach ($gmildren['ggchildren'] as $ggmildren) { ?>
																		<li><a href="<?php echo $ggmildren['href']; ?>"><?php echo $ggmildren['name']; ?></a></li>
																	<?php } ?>
																</ul>
															<?php } ?>
														<?php } ?>
													</div>
												<?php } ?>
											<?php } else { ?>
												<?php foreach ($mildren['gchildren'] as $gmildren) { ?>
													<div class="withimage" <?php if ($mitem['iwidth']) { ?> style="width: <?php echo $mitem['iwidth']; ?>px;"<?php } ?>>
														<div class="image">
															<a href="<?php echo $gmildren['href']; ?>">
																<img src="<?php echo $gmildren['thumb']; ?>" alt="<?php echo $gmildren['name']; ?>" title="<?php echo $gmildren['name']; ?>" />
															</a>
														</div>
														<div class="name">
															<a href="<?php echo $gmildren['href']; ?>"><?php echo $gmildren['name']; ?></a>
															<?php if (isset($gmildren['ggchildren'])) { ?>
																<?php if ($gmildren['ggchildren']) { ?>
																	<span class="mainexpand"></span>
																	<ul class="child-level">
																		<?php foreach ($gmildren['ggchildren'] as $ggmildren) { ?>
																			<li><a href="<?php echo $ggmildren['href']; ?>"> <?php echo $ggmildren['name']; ?></a></li>
																		<?php } ?>
																	</ul>
																<?php } ?>
															<?php } ?>
														</div>
													</div>
												<?php } ?>
											<?php } ?>
										</div>
									</div>
								<?php } ?>
							</div>
						<?php } ?>
						<?php if ($mitem['href'] && $linkoftopitem == 'bottom') { ?>
							<div class="linkoftopitem">
								<a href="<?php echo $mitem['href']; ?>"><?php echo $viewalltext; ?> <?php echo $mitem['name']; ?></a>
							</div>
						<?php } ?>
					</div>
				<?php } ?>
				<?php if (($mitem['children'] || ($mitem['chtml'] && $mitem['chtml'] == 1)) && ($mitem['view'] != 'f0' && $mitem['view'] != 'f1') || $mitem['cssid'] == 'login_drop')  { ?>
					<div class="bigdiv<?php if ($mitem['cssid'] == 'login_drop' && !$mitem['dwidth']) { ?> withflyout andlogin<?php } ?>"<?php if ($mitem['dwidth']) { ?> data-width="<?php echo $mitem['dwidth']; ?>" style="width: <?php echo $mitem['dwidth']; ?>px;"<?php } ?>>
						<?php if ($dropdowntitle) { ?>
							<div class="headingoftopitem">
								<?php if ($mitem['href'] && $linkoftopitem == 'heading') { ?>
									<h2><a href="<?php echo $mitem['href']; ?>"><?php echo $mitem['name']; ?></a></h2>
								<?php } else { ?>
									<h2><?php echo $mitem['name']; ?></h2>
								<?php } ?>
							</div>
						<?php } ?>
					
						<?php if ($mitem['add'] || ($mitem['chtml'] && $mitem['chtml'] == 2)) { ?>
							<div class="menu-add" <?php if ($bspace_width) { ?>style="width: <?php echo $bspace_width; ?>px;"<?php } ?>>
								<?php if ($mitem['chtml'] && $mitem['chtml'] == 2) { ?>
									<?php echo $mitem['cchtml']; ?>
								<?php } else { ?>
									<a <?php if ($mitem['addurl']) { ?>href="<?php echo $mitem['addurl']; ?>"<?php } ?>><img src="image/<?php echo $mitem['add']; ?>" alt="<?php echo $mitem['name']; ?>" /></a>
								<?php } ?>
							</div>
						<?php } ?>
						<?php if ($mitem['fbrands']) { ?>
							<div class="dropbrands">
								<span><?php echo $brands_text; ?></span>
								<ul>
									<?php foreach ($mitem['fbrands'] as $dropbrand) { ?>
										<li><a href="<?php echo $dropbrand['href']; ?>"><?php echo $dropbrand['name']; ?></a></li>
									<?php } ?>
								</ul>
							</div>
						<?php } ?>
						<?php  ($direction == 'rtl' || $col_class == ' ontheright') ? $smlmarg = 'left' : $smlmarg = 'right'; ?>
						<div class="flyoutmenu-left" <?php if ($mitem['add'] || ($mitem['chtml'] && $mitem['chtml'] == 2)) { ?><?php if ($mitem['fbrands']) { ?><?php if ($bspace_width) { $slmarg = $bspace_width + 180; ?>style="margin-<?php echo $smlmarg ?>: <?php echo $slmarg ?>px"<?php } else { ?>style="margin-<?php echo $smlmarg ?>: 380px"<?php } ?><?php } else { ?><?php if ($bspace_width) {  $slmarg = $bspace_width + 10; ?>style="margin-<?php echo $smlmarg ?>: <?php echo $slmarg ?>px"<?php } else { ?>style="margin-<?php echo $smlmarg ?>: 220px"<?php } ?><?php } ?><?php } elseif ($mitem['fbrands'] && !($mitem['add'] || ($mitem['chtml'] && $mitem['chtml'] == 2))) { ?>style="margin-<?php echo $smlmarg ?>: 170px"<?php } ?>>
							<?php if ($mitem['chtml'] && $mitem['chtml'] == 1) { ?><?php echo $mitem['cchtml']; ?><?php } ?>
	  
							<?php if ($mitem['chtml'] && $mitem['chtml'] == 3) { ?><div style="display: block;"><?php echo $mitem['cchtml']; ?></div><?php } ?>
							
							<?php if ($mitem['cssid'] == 'login_drop') { ?>
								<?php if ($logged) { ?>
									<div class="withchild"<?php if ($mitem['iwidth']) { ?> style="width: <?php echo $mitem['iwidth']; ?>px;"<?php } ?>><a class="theparent" href="<?php echo $edit; ?>"><?php echo $text_edit; ?></a></div>
									<div class="withchild"<?php if ($mitem['iwidth']) { ?> style="width: <?php echo $mitem['iwidth']; ?>px;"<?php } ?>><a class="theparent"  href="<?php echo $password; ?>"><?php echo $text_password; ?></a></div>
									<div class="withchild"<?php if ($mitem['iwidth']) { ?> style="width: <?php echo $mitem['iwidth']; ?>px;"<?php } ?>><a class="theparent"  href="<?php echo $address; ?>"><?php echo $text_address; ?></a></div>
									<div class="withchild"<?php if ($mitem['iwidth']) { ?> style="width: <?php echo $mitem['iwidth']; ?>px;"<?php } ?>><a class="theparent"  href="<?php echo $wishlist; ?>"><?php echo $text_wishlist; ?></a></div>
									<div class="withchild"<?php if ($mitem['iwidth']) { ?> style="width: <?php echo $mitem['iwidth']; ?>px;"<?php } ?>><a class="theparent"  href="<?php echo $order; ?>"><?php echo $text_order; ?></a></div>
									<div class="withchild"<?php if ($mitem['iwidth']) { ?> style="width: <?php echo $mitem['iwidth']; ?>px;"<?php } ?>><a class="theparent"  href="<?php echo $download; ?>"><?php echo $text_download; ?></a></div>
									<div class="withchild"<?php if ($mitem['iwidth']) { ?> style="width: <?php echo $mitem['iwidth']; ?>px;"<?php } ?>><a class="theparent"  href="<?php echo $return; ?>"><?php echo $text_return; ?></a></div>
									<div class="withchild"<?php if ($mitem['iwidth']) { ?> style="width: <?php echo $mitem['iwidth']; ?>px;"<?php } ?>><a class="theparent"  href="<?php echo $transaction; ?>"><?php echo $text_transaction; ?></a></div>
									<div class="withchild"<?php if ($mitem['iwidth']) { ?> style="width: <?php echo $mitem['iwidth']; ?>px;"<?php } ?>><a class="theparent"  href="<?php echo $newsletter; ?>"><?php echo $text_newsletter; ?></a></div>
									<div class="withchild"<?php if ($mitem['iwidth']) { ?> style="width: <?php echo $mitem['iwidth']; ?>px;"<?php } ?>><a class="theparent"  href="<?php echo $recurring; ?>"><?php echo $text_recurring; ?></a></div>
									<div class="withchild"<?php if ($mitem['iwidth']) { ?> style="width: <?php echo $mitem['iwidth']; ?>px;"<?php } ?>><a class="theparent"  href="<?php echo $logout; ?>"><?php echo $text_logout; ?></a></div>
								<?php } else { ?>
										<form action="<?php echo $actiond; ?>" method="post" enctype="multipart/form-data" id="sm-login">
												<div class="addingaspace" style="clear: none;"></div>
												<?php echo $entry_email; ?><br />
												<input type="text" name="email" value="" />
												<br />
												<?php echo $entry_password; ?><br />
												<input type="password" name="password" value="" />
												<br />
												<a href="<?php echo $forgottend; ?>"><?php echo $text_forgotten; ?></a><br />
												<a href="<?php echo $registerd; ?>"><?php echo $text_register; ?></a><br />
												<div class="linkoftopitem">
													<a onclick="$('#sm-login').submit();"><?php echo $button_login; ?></a>
							                    </div>
										</form>
								<?php } ?>
							<?php } ?>
	  
							<?php if ((!$mitem['chtml'] || $mitem['chtml'] == 2 || $mitem['chtml'] == 3) && $mitem['cssid'] != 'login_drop') { ?>
								<?php if (!$mitem['view']) { ?>
									<?php foreach ($mitem['children'] as $mildren) { ?>
										<div class="withchild<?php if ($mildren['gchildren']) { ?> haskids<?php } ?>"<?php if ($mitem['iwidth']) { ?> style="width: <?php echo $mitem['iwidth']; ?>px;"<?php } ?>>
											<a class="theparent" href="<?php echo $mildren['href']; ?>"><?php echo $mildren['name']; ?></a>
											<?php if ($mildren['gchildren']) { ?>
												<span class="mainexpand"></span>
												<ul class="child-level">
													<?php foreach ($mildren['gchildren'] as $gmildren) { ?>
														<li><a href="<?php echo $gmildren['href']; ?>"><?php echo $gmildren['name']; ?></a></li>
													<?php } ?>
												</ul>
											<?php } ?>
										</div>
									<?php } ?>
								<?php } elseif ($mitem['view'] == '1') { ?>
									<?php foreach ($mitem['children'] as $mildren) { ?>
										<div class="withimage"<?php if ($mitem['iwidth']) { ?> style="width: <?php echo $mitem['iwidth']; ?>px;"<?php } ?>>
											<div class="image">
												<a href="<?php echo $mildren['href']; ?>"><img src="<?php echo $mildren['thumb']; ?>" alt="<?php echo $mildren['name']; ?>" title="<?php echo $mildren['name']; ?>" /></a>
											</div>
											<div class="name">
												<?php if ($mildren['gchildren']) { ?><span class="mainexpand"></span><?php } ?>
												<a class="nname" href="<?php echo $mildren['href']; ?>"><?php echo $mildren['name']; ?></a>
												<?php if ($mildren['gchildren']) { ?>
													<ul class="child-level">
														<?php foreach ($mildren['gchildren'] as $gmildren) { ?>
															<li><a href="<?php echo $gmildren['href']; ?>"> <?php echo $gmildren['name']; ?></a></li>
														<?php } ?>
													</ul>
												<?php } ?>
											</div>
											<?php if (isset($mildren['price'])) { ?>
												<?php if ($mildren['price']) { ?>
													<div class="dropprice">
														<?php if (!$mildren['special']) { ?>
															<?php echo $mildren['price']; ?>
														<?php } else { ?>
															<span><?php echo $mildren['price']; ?></span> <?php echo $mildren['special']; ?>
														<?php } ?>
													</div>
												<?php } ?>
											<?php } ?>
										</div>
									<?php } ?>
								<?php } ?>
							<?php } ?>
						</div>
						<?php if ($mitem['add'] || ($mitem['chtml'] && $mitem['chtml'] == 2)) { ?>
							<div class="menu-add-mobil" <?php if ($mitem['chtml'] && $mitem['chtml'] == 2) { ?>style="text-align:left;"<?php } ?>>
								<?php if ($mitem['chtml'] && $mitem['chtml'] == 2) { ?>
									<?php echo $mitem['cchtml']; ?>
								<?php } else { ?>
									<a <?php if ($mitem['addurl']) { ?>href="<?php echo $mitem['addurl']; ?>"<?php } ?>><img src="image/<?php echo $mitem['add']; ?>" alt="<?php echo $mitem['name']; ?>" /></a>
								<?php } ?>
							</div>
						<?php } ?>
						<?php if ($mitem['fbrands']) { ?>
							<div class="dropbrands dropbrands-mobil">
								<span><?php echo $brands_text; ?></span>
								<ul>
									<?php foreach ($mitem['fbrands'] as $dropbrand) { ?>
										<li><a href="<?php echo $dropbrand['href']; ?>"><?php echo $dropbrand['name']; ?></a></li>
									<?php } ?>
								</ul>
							</div>
						<?php } ?>
						<?php if ($mitem['href'] && $linkoftopitem == 'bottom' && $mitem['cssid'] != 'login_drop') { ?>
							<div class="linkoftopitem">
								<a href="<?php echo $mitem['href']; ?>"><?php echo $viewalltext; ?> <?php echo $mitem['name']; ?></a>
							</div>
						<?php } elseif ($mitem['cssid'] != 'login_drop') { ?>
							<div class="addingaspace"></div>
						<?php } ?>
					</div>
				<?php } ?>
			</li>
		<?php } ?>
	</ul>
</div>
<script type="text/javascript"> 
$(document).ready(function(){ 
<?php if ($usehoverintent) { ?>
	   
		<?php if ($dropdowneffect == 'drop') { ?>
		var setari = {
		over: function() { 
		  if ($('.<?php echo $i_class; ?>.flyoutmenu').hasClass('superbig')) {
			$(this).find('.bigdiv').addClass('ef-slide-right'); 
		  }
		}, 
		out: function() { 
		  if ($('.<?php echo $i_class; ?>.flyoutmenu').hasClass('superbig')) {
			$(this).find('.bigdiv').removeClass('ef-slide-right'); 
		  }
		},
		timeout: 150
		};
		var setariflyout = {   
		over: function() { 
		  if ($('.<?php echo $i_class; ?>.flyoutmenu').hasClass('superbig')) {
			$(this).find('.flyouttoright').addClass('ef-slide-right');
		  }
			}, 
		out: function() { 
		  if ($('.<?php echo $i_class; ?>.flyoutmenu').hasClass('superbig')) {
			$(this).find('.flyouttoright').removeClass('ef-slide-right');
		  }
		},
		timeout: 200
		};
		<?php } elseif($dropdowneffect == 'show') { ?>
		var setari = {
		over: function() { 
		  if ($('.<?php echo $i_class; ?>.flyoutmenu').hasClass('superbig')) {
			$(this).find('.bigdiv').show(); 
		  }
		}, 
		out: function() { 
		  if ($('.<?php echo $i_class; ?>.flyoutmenu').hasClass('superbig')) {
			$(this).find('.bigdiv').hide(); 
		  }
		 },
		timeout: 150
		};
		var setariflyout = {   
		over: function() { 
		  if ($('.<?php echo $i_class; ?>.flyoutmenu').hasClass('superbig')) {
			$(this).find('.flyouttoright').show();
		  }
			}, 
		out: function() { 
		  if ($('.<?php echo $i_class; ?>.flyoutmenu').hasClass('superbig')) {
			$(this).find('.flyouttoright').hide();
		  }
		},
		timeout: 200
		};
		<?php } else { ?>
		var setari = {
		over: function() { 
		  if ($('.<?php echo $i_class; ?>.flyoutmenu').hasClass('superbig')) {
			$(this).find('.bigdiv').addClass('ef-fade-in'); 
		  }
		}, 
		out: function() { 
		  if ($('.<?php echo $i_class; ?>.flyoutmenu').hasClass('superbig')) {
			$(this).find('.bigdiv').removeClass('ef-fade-in');
		  }
		},
		timeout: 150
		};
		var setariflyout = {   
		over: function() { 
		  if ($('.<?php echo $i_class; ?>.flyoutmenu').hasClass('superbig')) {
			$(this).find('.flyouttoright').addClass('ef-fade-in');
		  }
			}, 
		out: function() { 
		  if ($('.<?php echo $i_class; ?>.flyoutmenu').hasClass('superbig')) {
			$(this).find('.flyouttoright').removeClass('ef-fade-in');
		  }
		},
		timeout: 200
		};
		<?php } ?>
		
	$(".<?php echo $i_class; ?>.flyoutmenu ul li.tlli").hoverIntent(setari);
	$(".<?php echo $i_class; ?>.flyoutmenu ul li div.bigdiv.withflyout > .withchildfo").hoverIntent(setariflyout);
<?php } else { ?>
	$(".<?php echo $i_class; ?>.flyoutmenu ul li.tlli").on({
		mouseenter: function(){
		  if ($('.<?php echo $i_class; ?>.flyoutmenu').hasClass('superbig')) {
		   <?php if ($dropdowneffect == 'drop') { ?>
			$(this).find('.bigdiv').addClass('ef-slide-right');
		   <?php } elseif($dropdowneffect == 'show') { ?>
		    $(this).find('.bigdiv').show();
		   <?php } else { ?>
		    $(this).find('.bigdiv').addClass('ef-fade-in');
		   <?php } ?>
		  }
		},
		mouseleave: function(){
		  if ($('.<?php echo $i_class; ?>.flyoutmenu').hasClass('superbig')) {
		   <?php if ($dropdowneffect == 'drop') { ?>
			$(this).find('.bigdiv').removeClass('ef-slide-right');
		   <?php } elseif($dropdowneffect == 'show') { ?>
		    $(this).find('.bigdiv').hide();
		   <?php } else { ?>
		    $(this).find('.bigdiv').removeClass('ef-fade-in');
		   <?php } ?>
		  }
		}
	});
	$(".<?php echo $i_class; ?>.flyoutmenu ul li div.bigdiv.withflyout > .withchildfo").on({
		mouseenter: function(){
		  if ($('.<?php echo $i_class; ?>.flyoutmenu').hasClass('superbig')) {
			<?php if ($dropdowneffect == 'drop') { ?>
				$(this).find('.flyouttoright').addClass('ef-slide-right');
		    <?php } elseif($dropdowneffect == 'show') { ?>
				$(this).find('.flyouttoright').show();
		    <?php } else { ?>
				$(this).find('.flyouttoright').addClass('ef-fade-in');
		   <?php } ?>
		  }
		},
		mouseleave: function(){
		  if ($('.<?php echo $i_class; ?>.flyoutmenu').hasClass('superbig')) {
			<?php if ($dropdowneffect == 'drop') { ?>
				$(this).find('.flyouttoright').removeClass('ef-slide-right');
		    <?php } elseif($dropdowneffect == 'show') { ?>
				$(this).find('.flyouttoright').hide();
		    <?php } else { ?>
				$(this).find('.flyouttoright').removeClass('ef-fade-in');
		    <?php } ?>
		  }
		}
	});
<?php } ?>
});
</script>
<?php } ?>