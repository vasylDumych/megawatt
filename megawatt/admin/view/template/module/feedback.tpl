<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <?php if (isset($success)) { ?>
  <div class="success"><?php echo $success; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
	
	<div id="tabs" class="htabs"><a href="#tab-modules"><?php echo $tab_modules; ?></a><a href="#tab-settings"><?php echo $tab_settings; ?></a></div>
	
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
	  <div id="tab-modules">
        <table id="module" class="list">
          <thead>
            <tr>
              <td class="left"><?php echo $entry_layout; ?></td>
              <td class="left"><?php echo $entry_position; ?></td>
              <td class="left"><?php echo $entry_status; ?></td>
			  <td class="left"><?php echo $entry_fields; ?></td>
			  <td class="left"><?php echo $entry_title; ?></td>
			  <td class="left"><?php echo $entry_style; ?></td>
			  <td class="left"><?php echo $required_entry_fields; ?></td>
              <td class="right"><?php echo $entry_sort_order; ?></td>
              <td></td>
            </tr>
          </thead>
          <?php $module_row = 0; ?>
          <?php foreach ($modules as $module) { ?>
		  
          <tbody id="module-row<?php echo $module_row; ?>">
            <tr>
              <td class="left">
			  <input type="hidden" value="<?php echo $module_row; ?>" name="feedback_module[<?php echo $module_row; ?>][id]" />
			  <select name="feedback_module[<?php echo $module_row; ?>][layout_id]">
                  <?php foreach ($layouts as $layout) { ?>
                  <?php if ($layout['layout_id'] == $module['layout_id']) { ?>
                  <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select></td>
              <td class="left"><select name="feedback_module[<?php echo $module_row; ?>][position]">
                  <?php if ($module['position'] == 'content_top') { ?>
                  <option value="content_top" selected="selected"><?php echo $text_content_top; ?></option>
                  <?php } else { ?>
                  <option value="content_top"><?php echo $text_content_top; ?></option>
                  <?php } ?>
                  <?php if ($module['position'] == 'content_bottom') { ?>
                  <option value="content_bottom" selected="selected"><?php echo $text_content_bottom; ?></option>
                  <?php } else { ?>
                  <option value="content_bottom"><?php echo $text_content_bottom; ?></option>
                  <?php } ?>
                  <?php if ($module['position'] == 'column_left') { ?>
                  <option value="column_left" selected="selected"><?php echo $text_column_left; ?></option>
                  <?php } else { ?>
                  <option value="column_left"><?php echo $text_column_left; ?></option>
                  <?php } ?>
                  <?php if ($module['position'] == 'column_right') { ?>
                  <option value="column_right" selected="selected"><?php echo $text_column_right; ?></option>
                  <?php } else { ?>
                  <option value="column_right"><?php echo $text_column_right; ?></option>
                  <?php } ?>
                </select></td>
              <td class="left"><select name="feedback_module[<?php echo $module_row; ?>][status]">
                  <?php if ($module['status']) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select></td>
				<td class="left">
					<table>
					<tr><td>
					<?php echo $txt_first_name; ?> <td><input type="checkbox" <?=(isset($module['name']) ? 'checked' : '')?> name="feedback_module[<?php echo $module_row; ?>][name]" value="on" />
					<tr><td>
					<?php echo $txt_email; ?> <td><input type="checkbox" <?=(isset($module['email']) ? 'checked' : '')?> name="feedback_module[<?php echo $module_row; ?>][email]" value="on" />
					<tr><td>
					<?php echo $txt_phone; ?> <td><input type="checkbox" <?=(isset($module['phone']) ? 'checked' : '')?> name="feedback_module[<?php echo $module_row; ?>][phone]" value="on" />
					<tr><td>
					<?php echo $txt_textarea; ?> <td><input type="checkbox" <?=(isset($module['text']) ? 'checked' : '')?> name="feedback_module[<?php echo $module_row; ?>][text]" value="on" />
					<tr><td>
					<?php echo $txt_captcha; ?> <td><input type="checkbox" <?=(isset($module['captcha']) ? 'checked' : '')?> name="feedback_module[<?php echo $module_row; ?>][captcha]" value="on" />
					</table>
				</td>
				<td class="left">
					<table>
					<tr><td>
					<?php echo $txt_first_name; ?> <td><input type="checkbox" <?=(isset($module['r']['name']) ? 'checked' : '')?> name="feedback_module[<?php echo $module_row; ?>][r][name]" value="on" />
					<tr><td>
					<?php echo $txt_email; ?> <td><input type="checkbox" <?=(isset($module['r']['email']) ? 'checked' : '')?> name="feedback_module[<?php echo $module_row; ?>][r][email]" value="on" />
					<tr><td>
					<?php echo $txt_phone; ?> <td><input type="checkbox" <?=(isset($module['r']['phone']) ? 'checked' : '')?> name="feedback_module[<?php echo $module_row; ?>][r][phone]" value="on" />
					<tr><td>
					<?php echo $txt_textarea; ?> <td><input type="checkbox" <?=(isset($module['r']['text']) ? 'checked' : '')?> name="feedback_module[<?php echo $module_row; ?>][r][text]" value="on" />
					<tr><td>
					<?php echo $txt_captcha; ?> <td><input type="checkbox" checked disabled name="feedback_module[<?php echo $module_row; ?>][r][captcha]" value="on" />
					</table>
				</td>
			  <td>
				<?php foreach ($languages as $language) { ?>
					<img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <input type="text" name="feedback_module[<?php echo $module_row; ?>][module_title][<?php echo $language['language_id']; ?>]" value="<?php echo $module['module_title'][$language['language_id']]; ?>" /><div class="clear"></div>
				<? } ?>
			  </td>
			  <td>
				<select name="feedback_module[<?php echo $module_row; ?>][module_style]">
				<?php foreach ($styles as $value => $title) {
						echo '<option value="'.$value.'"'.(($module['module_style'] == $value) ? ' selected ' : '').'>'.$title.'</option>';
					}
				?>
				</select>
			  </td>
              <td class="right"><input type="text" name="feedback_module[<?php echo $module_row; ?>][sort_order]" value="<?php echo $module['sort_order']; ?>" size="3" /></td>
              <td class="left"><a onclick="$('#module-row<?php echo $module_row; ?>').remove();" class="button"><?php echo $button_remove; ?></a></td>
            </tr>
          </tbody>
          <?php $module_row++; ?>
          <?php } ?>
          <tfoot>
            <tr>
              <td colspan="8"></td>
              <td class="left"><a onclick="addModule();" class="button"><?php echo $button_add_module; ?></a></td>
            </tr>
          </tfoot>
        </table>
		</div>
		<div id="tab-settings">
		 <table class="form">
			<tr>
				<td><?=$txt_settings_min_phone?>
				<span class="help"><?php echo $txt_default; ?>: 8</span>
				</td>
				<td><input type="text" name="feedback_settings[settings_min_phone]" value="<?php echo $settings['settings_min_phone']; ?>"></td>
			</tr>
			<tr>
				<td><?=$txt_settings_max_phone?>
				<span class="help"><?php echo $txt_default; ?>: 14</span>
				</td>
				<td><input type="text" name="feedback_settings[settings_max_phone]" value="<?php echo $settings['settings_max_phone']; ?>"></td>
			</tr>
			<tr>
				<td><?=$txt_settings_min_text?>
				<span class="help"><?php echo $txt_default; ?>: 10</span>
				</td>
				<td><input type="text" name="feedback_settings[settings_min_text]" value="<?php echo $settings['settings_min_text']; ?>"></td>
			</tr>
			<tr>
				<td><?=$txt_settings_max_text?>
				<span class="help"><?php echo $txt_default; ?>: 400</span>
				</td>
				<td><input type="text" name="feedback_settings[settings_max_text]" value="<?php echo $settings['settings_max_text']; ?>"></td>
			</tr>
			<tr>
				<td><?=$txt_settings_success?>
				<span class="help"><?php echo $txt_default; ?>: <?php echo $txt_default_text_message; ?></span>
				</td>
				<td>
				<?php foreach ($languages as $language) { ?>
				<img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?>:
				<div class="clear"></div>
				<textarea name="feedback_settings[settings_success][<?php echo $language['language_id']; ?>]" rows=4 style="width: 400px;"><?php echo $settings['settings_success'][$language['language_id']]; ?></textarea>
				<div class="clear"></div>
				<?php } ?>
				</td>
			</tr>
		 </table>
		</div>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
var module_row = <?php echo $module_row; ?>;

function addModule() {	
	html  = '<tbody id="module-row' + module_row + '">';
	html += '  <tr>';
	html += '    <td class="left">';
	html += '<input type="hidden" value="' + module_row + '" name="feedback_module[' + module_row + '][id]" />';
	html += '<select name="feedback_module[' + module_row + '][layout_id]">';
	<?php foreach ($layouts as $layout) { ?>
	html += '      <option value="<?php echo $layout['layout_id']; ?>"><?php echo addslashes($layout['name']); ?></option>';
	<?php } ?>
	html += '    </select></td>';
	html += '    <td class="left"><select name="feedback_module[' + module_row + '][position]">';
	html += '      <option value="content_top"><?php echo $text_content_top; ?></option>';
	html += '      <option value="content_bottom"><?php echo $text_content_bottom; ?></option>';
	html += '      <option value="column_left"><?php echo $text_column_left; ?></option>';
	html += '      <option value="column_right"><?php echo $text_column_right; ?></option>';
	html += '    </select></td>';
	html += '    <td class="left"><select name="feedback_module[' + module_row + '][status]">';
    html += '      <option value="1" selected="selected"><?php echo $text_enabled; ?></option>';
    html += '      <option value="0"><?php echo $text_disabled; ?></option>';
    html += '    </select></td>';
	html += '	<td class="left">'+
					'<table>'+
					'<tr><td>'+
					'<?php echo $txt_first_name; ?> <td><input type="checkbox" <?=(isset($module['name']) ? 'checked' : '')?> name="feedback_module[<?php echo $module_row; ?>][name]" value="on" />'+
					'<tr><td>'+
					'<?php echo $txt_email; ?> <td><input type="checkbox" <?=(isset($module['email']) ? 'checked' : '')?> name="feedback_module[<?php echo $module_row; ?>][email]" value="on" />'+
					'<tr><td>'+
					'<?php echo $txt_phone; ?> <td><input type="checkbox" <?=(isset($module['phone']) ? 'checked' : '')?> name="feedback_module[<?php echo $module_row; ?>][phone]" value="on" />'+
					'<tr><td>'+
					'<?php echo $txt_textarea; ?> <td><input type="checkbox" <?=(isset($module['text']) ? 'checked' : '')?> name="feedback_module[<?php echo $module_row; ?>][text]" value="on" />'+
					'<tr><td>'+
					'<?php echo $txt_captcha; ?> <td><input type="checkbox" <?=(isset($module['captcha']) ? 'checked' : '')?> name="feedback_module[<?php echo $module_row; ?>][captcha]" value="on" />'+
					'</table>'+
				'</td>';
	html += '<td class="left">'+
					'<table>'+
					'<tr><td>'+
					'<?php echo $txt_first_name; ?> <td><input type="checkbox" <?=(isset($module['r']['name']) ? 'checked' : '')?> name="feedback_module[<?php echo $module_row; ?>][r][name]" value="on" />'+
					'<tr><td>'+
					'<?php echo $txt_email; ?> <td><input type="checkbox" <?=(isset($module['r']['email']) ? 'checked' : '')?> name="feedback_module[<?php echo $module_row; ?>][r][email]" value="on" />'+
					'<tr><td>'+
					'<?php echo $txt_phone; ?> <td><input type="checkbox" <?=(isset($module['r']['phone']) ? 'checked' : '')?> name="feedback_module[<?php echo $module_row; ?>][r][phone]" value="on" />'+
					'<tr><td>'+
					'<?php echo $txt_textarea; ?> <td><input type="checkbox" <?=(isset($module['r']['text']) ? 'checked' : '')?> name="feedback_module[<?php echo $module_row; ?>][r][text]" value="on" />'+
					'<tr><td>'+
					'<?php echo $txt_captcha; ?> <td><input type="checkbox" checked disabled name="feedback_module[<?php echo $module_row; ?>][r][captcha]" value="on" />'+
					'</table>'+
				'</td>';
				
	html += '	<td>';
	<?php foreach ($languages as $language) { ?>
	html += '	<img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" />'+
			'	<input type="text" name="feedback_module['+ module_row +'][module_title][<?php echo $language['language_id']; ?>]" value="<?php echo $entry_feedback; ?>" /><div class="clear"></div>';
	<? } ?>
	html += '	</td>';
	html += '    <td class="left"><select name="feedback_module[' + module_row + '][module_style]">';
	<?php foreach ($styles as $value => $title) { ?>
	html += '      <option value="<?php echo $value; ?>"><?php echo $title; ?></option>';
	<?php } ?>
	html += '    </select></td>';
	html += '    <td class="right"><input type="text" name="feedback_module[' + module_row + '][sort_order]" value="" size="3" /></td>';
	html += '    <td class="left"><a onclick="$(\'#module-row' + module_row + '\').remove();" class="button"><?php echo $button_remove; ?></a></td>';
	html += '  </tr>';
	html += '</tbody>';
	
	$('#module tfoot').before(html);
	
	module_row++;
}

$('#tabs a').tabs();
//--></script> 
<?php echo $footer; ?>