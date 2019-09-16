<div class="box">

		<p class="h3"><?php echo $heading_title; ?></p>

	<div class="box-content">
		<div class="subscribe<?php echo $module; ?>">
			<input placeholder="<?php echo $text_enter_email; ?>" type="text" name="subscribe_email<?php echo $module; ?>" value="" />
			<input type="button" value="<?php echo $button_subscribe; ?>" onclick="addSubscribe(<?php echo $module; ?>);" class="button2" />
		</div>
	</div>
</div>
