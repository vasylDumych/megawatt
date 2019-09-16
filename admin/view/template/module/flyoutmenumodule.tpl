<?php echo $header; ?>
<link rel="stylesheet" type="text/css" href="view/cpicker/flyoutmenu.css" />
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  
<?php if ($success) { ?>
  <div class="success"><?php echo $success; ?></div>
  <?php } ?>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?> &nbsp;&nbsp;&nbsp;&nbsp; <a href="<?php echo $url_tomenu; ?>"><?php echo $text_tomenu; ?></a></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
		<?php foreach ($flyoutmenu_menus as $menu) { ?>
		  <input type="hidden" name="flyoutmenumodule_added_menus[]" value="<?php echo $menu['id']; ?>" />
		<?php } ?>
	    <table id="module" class="list">
          <thead>
            <tr>
			  <td class="left"><?php echo $entry_menu; ?></td>
			  <td class="left"><?php echo $entry_theme; ?></td>
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
			<td class="left">
				<select name="flyoutmenumodule_module[<?php echo $module_row; ?>][menu]">
					<?php if (!$module['menu']) { ?>
							<option value="0" selected="selected"><?php echo $text_default_menu; ?></option>
					<?php } else { ?>
							<option value="0"><?php echo $text_default_menu; ?></option>
					<?php } ?>
					<?php foreach ($flyoutmenu_menus as $menu) { ?>
						<?php if ($menu['id'] == $module['menu']) { ?>
							<option value="<?php echo $menu['id']; ?>" selected="selected"><?php echo $menu['name']; ?></option>
						<?php } else { ?>
							<option value="<?php echo $menu['id']; ?>"><?php echo $menu['name']; ?></option>
						<?php } ?>
					<?php } ?>
				</select>
			</td>
			<td class="left"><select name="flyoutmenumodule_module[<?php echo $module_row; ?>][theme]">
                  <?php if ($module['theme'] == 'default') { ?>
                  <option value="default" selected="selected">Default</option>
                  <?php } else { ?>
                  <option value="default">Default</option>
                  <?php } ?>
				  <?php if ($module['theme'] == 'fly_theme_1') { ?>
                  <option value="fly_theme_1" selected="selected">Theme 1</option>
                  <?php } else { ?>
                  <option value="fly_theme_1">Theme 1</option>
                  <?php } ?>
				  <?php if ($module['theme'] == 'fly_theme_2') { ?>
                  <option value="fly_theme_2" selected="selected">Theme 2</option>
                  <?php } else { ?>
                  <option value="fly_theme_2">Theme 2</option>
                  <?php } ?>
				  <?php if ($module['theme'] == 'fly_theme_3') { ?>
                  <option value="fly_theme_3" selected="selected">Theme 3</option>
                  <?php } else { ?>
                  <option value="fly_theme_3">Theme 3</option>
                  <?php } ?>
				  <?php if ($module['theme'] == 'fly_theme_4') { ?>
                  <option value="fly_theme_4" selected="selected">Theme 4</option>
                  <?php } else { ?>
                  <option value="fly_theme_4">Theme 4</option>
                  <?php } ?>
				  <?php if ($module['theme'] == 'fly_theme_5') { ?>
                  <option value="fly_theme_5" selected="selected">Theme 5</option>
                  <?php } else { ?>
                  <option value="fly_theme_5">Theme 5</option>
                  <?php } ?>
                </select></td>
              <td class="left"><select name="flyoutmenumodule_module[<?php echo $module_row; ?>][layout_id]">
                  <?php foreach ($layouts as $layout) { ?>
                  <?php if ($layout['layout_id'] == $module['layout_id']) { ?>
                  <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select></td>
              <td class="left"><select name="flyoutmenumodule_module[<?php echo $module_row; ?>][position]">
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
              <td class="left"><select name="flyoutmenumodule_module[<?php echo $module_row; ?>][status]">
                  <?php if ($module['status']) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select></td>
              <td class="right"><input type="text" name="flyoutmenumodule_module[<?php echo $module_row; ?>][sort_order]" value="<?php echo $module['sort_order']; ?>" size="3" /></td>
              <td class="left"><a onclick="$('#module-row<?php echo $module_row; ?>').remove();" class="button"><?php echo $button_remove; ?></a></td>
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
	html += '    <td class="left"><select name="flyoutmenumodule_module[' + module_row + '][menu]"><option value="0"> <?php echo $text_default_menu; ?></option>';
	<?php foreach ($flyoutmenu_menus as $menu) { ?>
	html += '		<option value="<?php echo $menu['id']; ?>"><?php echo addslashes($menu['name']); ?></option>';				
	<?php } ?>
	html += '    </select></td>';
	html += '    <td class="left"><select name="flyoutmenumodule_module[' + module_row + '][theme]">';
	html += '      <option value="default">Default</option>';
	html += '      <option value="fly_theme_1">Theme 1</option>';
	html += '      <option value="fly_theme_2">Theme 2</option>';
	html += '      <option value="fly_theme_3">Theme 3</option>';
	html += '      <option value="fly_theme_4">Theme 4</option>';
	html += '      <option value="fly_theme_5">Theme 5</option>';
	html += '    </select></td>';
	html += '    <td class="left"><select name="flyoutmenumodule_module[' + module_row + '][layout_id]">';
	<?php foreach ($layouts as $layout) { ?>
	html += '      <option value="<?php echo $layout['layout_id']; ?>"><?php echo addslashes($layout['name']); ?></option>';
	<?php } ?>
	html += '    </select></td>';
	html += '    <td class="left"><select name="flyoutmenumodule_module[' + module_row + '][position]">';
	html += '      <option value="column_left"><?php echo $text_column_left; ?></option>';
	html += '      <option value="column_right"><?php echo $text_column_right; ?></option>';
	html += '    </select></td>';
	html += '    <td class="left"><select name="flyoutmenumodule_module[' + module_row + '][status]">';
    html += '      <option value="1" selected="selected"><?php echo $text_enabled; ?></option>';
    html += '      <option value="0"><?php echo $text_disabled; ?></option>';
    html += '    </select></td>';
	html += '    <td class="right"><input type="text" name="flyoutmenumodule_module[' + module_row + '][sort_order]" value="" size="3" /></td>';
	html += '    <td class="left"><a onclick="$(\'#module-row' + module_row + '\').remove();" class="button"><?php echo $button_remove; ?></a></td>';
	html += '  </tr>';
	html += '</tbody>';
	
	$('#module tfoot').before(html);
	
	module_row++;
}
//--></script> 
<?php echo $footer; ?>