<?php echo $header; ?>
<style>
.form tbody tr td, .form thead tr td {
	border-right: 0px;
}
</style>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
	  <h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>
	  <div class="buttons"><a href="<?php echo $add_edit_sliders; ?>" class="button"><?php echo $button_sliders; ?></a><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a></div>
	</div>
	<div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
		<table id="module" class="list">
          <thead>
            <tr>
			  <td class="left"><?php echo $entry_slider; ?></td>	
              <td class="left"><?php echo $entry_dimension; ?></td>
			  <td class="left"><?php echo $entry_layout; ?></td>	
              <td class="left"><?php echo $entry_position; ?></td>
              <td class="left"><?php echo $entry_status; ?></td>
              <td class="right"><?php echo $entry_sort_order; ?></td>
              <td></td>
            </tr>
          </thead>
		  <?php $module_row = 0; ?>
          <?php foreach ($modules as $module) { ?>	
		  <tbody id="module-row<?php echo $module_row; ?>">
		    <tr>
			  <td class="left"><select name="coin_slider_module[<?php echo $module_row; ?>][coin_slider_id]">
                  <?php foreach ($sliders as $slider) { ?>
                  <?php if ($module['coin_slider_id'] == $slider['coin_slider_id']) { ?>
                  <option value="<?php echo $slider['coin_slider_id']; ?>" selected="selected"><?php echo $slider['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $slider['coin_slider_id']; ?>"><?php echo $slider['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select>
			  </td>
			  <td class="left">
			    <input type="text" name="coin_slider_module[<?php echo $module_row; ?>][width]" value="<?php echo $module['width']; ?>" size="3" maxlength="4" />&times<input type="text" name="coin_slider_module[<?php echo $module_row; ?>][height]" value="<?php echo $module['height']; ?>" size="3" maxlength="4" />
			  </td>
			  <td class="left">
			    <select onchange="change_layout(this.value, <?php echo $module_row; ?>)" name="coin_slider_module[<?php echo $module_row; ?>][layout_id]">
                  <?php foreach ($layouts as $layout) { ?>
                  <?php if ($layout['layout_id'] == $module['layout_id']) { ?>
                  <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select>

				<?php if (isset($module['category_id'])) { ?>
				<select name="coin_slider_module[<?php echo $module_row; ?>][category_id]">
				  <option value="0"></option>
                  <?php foreach ($categories as $category) { ?>
                  <?php if ($category['category_id'] == $module['category_id']) { ?>
                  <option value="<?php echo $category['category_id']; ?>" selected="selected"><?php echo $category['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select>
                <?php } ?>

			  </td>
			  <td class="left">
			    <select name="coin_slider_module[<?php echo $module_row; ?>][position]">
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
                  <?php if ($module['position'] == 'header_baner') { ?>
                  <option value="header_baner" selected="selected">header_baner</option>
                  <?php } else { ?>
                  <option value="header_baner">header_baner</option>
                  <?php } ?>
                </select>
			  </td>
			  <td class="left">
			    <select name="coin_slider_module[<?php echo $module_row; ?>][status]">
                  <?php if ($module['status']) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select>
			  </td>
			  <td class="right"><input type="text" name="coin_slider_module[<?php echo $module_row; ?>][sort_order]" value="<?php echo $module['sort_order']; ?>" size="3" /></td>
              <td class="left">
				<a onclick="$('#module-row<?php echo $module_row; ?>').remove();" class="button"><?php echo $button_remove; ?></a>
				<a href="<?php echo $update_slider; ?>&coin_slider_id=<?php echo $module['coin_slider_id']; ?>" class="button"><?php echo $button_edit; ?></a>
			  </td>
			</tr>
		  </tbody>
		  <?php $module_row++; ?>
          <?php } ?>
		  <tfoot>
            <tr>
              <td colspan="6"></td>
              <td class="left"><a onclick="addModule();" class="button"><?php echo $button_add_module; ?></a></td>
            </tr>
          </tfoot>
		</table>
	  </form>
	</div>
  </div>	
</div>
<script type="text/javascript"><!--
var module_row = <?php echo $module_row; ?>;

function addModule() {	
	html  = '<tbody id="module-row' + module_row + '">';
	html += '  <tr>';
	html += '<td class="left">';
	<?php if (!empty($sliders)) { ?>
		html += '<select name="coin_slider_module[' + module_row + '][coin_slider_id]">';
	  	<?php foreach ($sliders as $slider) { ?>
		  	html += '<option value="<?php echo $slider['coin_slider_id']; ?>"><?php echo $slider['name']; ?></option>';
		<?php } ?>
		html += '</select>';
		html += '<br><a href="<?php echo $add_insert_sliders; ?>" class="button"><?php echo $button_create; ?></a>';
    <?php } else { ?>
		html += '<a href="<?php echo $add_insert_sliders; ?>" class="button"><?php echo $button_create; ?></a>';
    <?php  } ?>
    html += '</td>';
	html += '    <td class="left"><input type="text" name="coin_slider_module[' + module_row + '][width]" value="980" size="3" maxlength="4" />&times<input type="text" name="coin_slider_module[' + module_row + '][height]" value="280" size="3"  maxlength="4" /></td>';
	html += '    <td class="left"><select onchange="change_layout(this.value, ' + module_row + ')" name="coin_slider_module[' + module_row + '][layout_id]">';
	<?php foreach ($layouts as $layout) { ?>
	html += '      <option value="<?php echo $layout['layout_id']; ?>" <?php if ($layout['layout_id'] == 1) echo 'selected'; ?> ><?php echo addslashes($layout['name']); ?></option>';
	<?php } ?>
	html += '    </select></td>';
	html += '    <td class="left"><select name="coin_slider_module[' + module_row + '][position]">';
	html += '      <option value="content_top"><?php echo $text_content_top; ?></option>';
	html += '      <option value="content_bottom"><?php echo $text_content_bottom; ?></option>';
	html += '      <option value="column_left"><?php echo $text_column_left; ?></option>';
	html += '      <option value="column_right"><?php echo $text_column_right; ?></option>';
	html += '      <option value="header_baner">header_baner</option>';
	html += '    </select></td>';
	html += '    <td class="left"><select name="coin_slider_module[' + module_row + '][status]">';
    html += '      <option value="1" selected="selected"><?php echo $text_enabled; ?></option>';
    html += '      <option value="0"><?php echo $text_disabled; ?></option>';
    html += '    </select></td>';
	html += '    <td class="right"><input type="text" name="coin_slider_module[' + module_row + '][sort_order]" value="" size="3" /></td>';
	html += '    <td class="left">';
	html += '		<a onclick="$(\'#module-row' + module_row + '\').remove();" class="button"><?php echo $button_remove; ?></a>';
	html += '    </td>';
	html += '  </tr>';
	html += '</tbody>';
	
	$('#module tfoot').before(html);
	
	module_row++;
}

function change_layout(layout_id, row)
{
	var html_categories = '';
	if (layout_id == 3) {
		html_categories += '<select name="coin_slider_module[' + row + '][category_id]">';
			html_categories += '<option value="0"></option>';
		<?php foreach ($categories as $category) { ?>
			html_categories += '      <option value="<?php echo $category['category_id']; ?>" <?php if ($category['category_id'] == 1) echo 'selected'; ?> ><?php echo addslashes($category['name']); ?></option>';
		<?php } ?>
		html_categories += '</select>';
	
		$('select[name="coin_slider_module['+ row +'][layout_id]"]').after(html_categories);
	} else {
		$('select[name="coin_slider_module['+ row +'][category_id]"]').remove();
	}
}
//--></script> 
<?php echo $footer; ?>
