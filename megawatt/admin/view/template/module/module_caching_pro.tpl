<?php

/**
 * LICENSE
 *
 * This source file is subject to the GNU General Public License, Version 3
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @category   OpenCart
 * @package    Module Caching PRO for OpenCart
 * @copyright  Copyright (c) 2016 Eugene Lifescale (eugene.lifescale@gmail.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License, Version 3
 */

 ?>

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
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
          <a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a>
          <a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a>
      </div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
          <?php foreach ($cache_drivers as $driver => $status) { ?>
              <?php if ($status && $driver != 'disk') { ?>
                  <h4><?php echo ucfirst($driver); ?> <?php echo $text_connection; ?></h4>
                  <hr />
                  <table class="form">
                      <tr>
                          <td class="left">
                              <?php echo $entry_port; ?>
                          </td>
                          <td class="left">
                              <input type="text"
                                     name="module_caching_pro_drivers[<?php echo $driver; ?>][port]"
                                     value="<?php echo (isset($module_caching_pro_drivers[$driver]['port']) ? $module_caching_pro_drivers[$driver]['port'] : false); ?>" />
                          </td>
                      </tr>
                      <tr>
                          <td class="left">
                              <?php echo $entry_host; ?>
                          </td>
                          <td class="left">
                              <input type="text"
                                     name="module_caching_pro_drivers[<?php echo $driver; ?>][host]"
                                     value="<?php echo (isset($module_caching_pro_drivers[$driver]['host']) ? $module_caching_pro_drivers[$driver]['host'] : false); ?>" />
                          </td>
                      </tr>
                      <tr>
                          <td class="left">
                              <?php echo $entry_namespace; ?>
                          </td>
                          <td class="left">
                              <input type="text"
                                     name="module_caching_pro_drivers[<?php echo $driver; ?>][namespace]"
                                     value="<?php echo (isset($module_caching_pro_drivers[$driver]['namespace']) ? $module_caching_pro_drivers[$driver]['namespace'] : false); ?>" />
                          </td>
                      </tr>
                  </table>
              <?php } ?>
          <?php } ?>
        <table id="module" class="list">
          <thead>
            <tr>
              <td class="left"><?php echo $entry_module; ?></td>
              <td class="left"><?php echo $entry_storage; ?></td>
              <td class="left"><?php echo $entry_timeout; ?></td>
              <td class="center"><?php echo $entry_get; ?></td>
              <td class="center"><?php echo $entry_post; ?></td>
              <td class="center"><?php echo $entry_files; ?></td>
              <td class="center"><?php echo $entry_cookie; ?></td>
              <td class="center"><?php echo $entry_session; ?></td>
              <td class="left"><?php echo $entry_status; ?></td>
              <td class="left"><?php echo $entry_action; ?></td>
            </tr>
          </thead>
          <?php $module_row = 0; ?>
          <?php foreach ($module_caching_pro_modules as $module) { ?>
          <tbody id="module-row<?php echo $module_row; ?>">
            <tr>
              <td class="left">
                  <select name="module_caching_pro_modules[<?php echo $module_row; ?>][route]">
                    <?php foreach ($installed_modules as $route => $name) { ?>
                        <?php if ($route == $module['route']) { ?>
                            <option value="<?php echo $route; ?>" selected="selected"><?php echo $name; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $route; ?>"><?php echo $name; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
              <td class="left">
                  <select name="module_caching_pro_modules[<?php echo $module_row; ?>][driver]">
                    <?php foreach ($cache_drivers as $driver => $status) { ?>
                        <?php if ($status) { ?>
                            <?php if ($driver == $module['driver']) { ?>
                                <option value="<?php echo $driver; ?>" selected="selected"><?php echo ucfirst($driver); ?></option>
                            <?php } else { ?>
                                <option value="<?php echo $driver; ?>"><?php echo ucfirst($driver); ?></option>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                </select>
              </td>
              <td class="left"><input type="text" name="module_caching_pro_modules[<?php echo $module_row; ?>][timeout]" value="<?php echo $module['timeout']; ?>" /></td>
              <td class="center">
                  <input type="checkbox"
                         name="module_caching_pro_modules[<?php echo $module_row; ?>][get]"
                         value="1" <?php echo (isset($module['get']) ? 'checked="checked"' : false); ?> />
              </td>
              <td class="center">
                  <input type="checkbox"
                         name="module_caching_pro_modules[<?php echo $module_row; ?>][post]"
                         value="1" <?php echo (isset($module['post']) ? 'checked="checked"' : false); ?> />
              </td>
              <td class="center">
                  <input type="checkbox"
                         name="module_caching_pro_modules[<?php echo $module_row; ?>][files]"
                         value="1" <?php echo (isset($module['files']) ? 'checked="checked"' : false); ?> />
              </td>
              <td class="center">
                  <input type="checkbox"
                         name="module_caching_pro_modules[<?php echo $module_row; ?>][cookie]"
                         value="1" <?php echo (isset($module['cookie']) ? 'checked="checked"' : false); ?> />
              </td>
              <td class="center">
                  <input type="checkbox"
                         name="module_caching_pro_modules[<?php echo $module_row; ?>][session]"
                         value="1" <?php echo (isset($module['session']) ? 'checked="checked"' : false); ?> />
              </td>
              <td class="left">
                  <select name="module_caching_pro_modules[<?php echo $module_row; ?>][status]">
                    <?php if ($module['status']) { ?>
                        <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                        <option value="0"><?php echo $text_disabled; ?></option>
                    <?php } else { ?>
                        <option value="1"><?php echo $text_enabled; ?></option>
                        <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                    <?php } ?>
                  </select>
              </td>
              <td class="left"><a onclick="$('#module-row<?php echo $module_row; ?>').remove();" class="button"><?php echo $button_remove; ?></a></td>
            </tr>
          </tbody>
          <?php $module_row++; ?>
          <?php } ?>
          <tfoot>
            <tr>
              <td colspan="9"></td>
              <td class="left"><a onclick="addModule();" class="button"><?php echo $button_add_module; ?></a></td>
            </tr>
          </tfoot>
        </table>
      </form>
        <div style="text-align:center;font-size:12px">
            <p><strong><?php echo $heading_title; ?> <?php echo $text_version; ?></strong></p>
            <p><?php echo $text_license; ?></p>
        </div>
    </div>
  </div>
</div>

<script type="text/javascript"><!--
var module_row = <?php echo $module_row; ?>;

function addModule() {
	html  = '<tbody id="module-row' + module_row + '">';
	html += '  <tr>';
	html += '    <td class="left"><select name="module_caching_pro_modules[' + module_row + '][route]">';
	<?php foreach ($installed_modules as $route => $name) { ?>
	html += '      <option value="<?php echo $route; ?>"><?php echo addslashes($name); ?></option>';
	<?php } ?>
	html += '    <td class="left"><select name="module_caching_pro_modules[' + module_row + '][driver]">';
	<?php foreach ($cache_drivers as $driver => $status) { ?>
    <?php if ($status) { ?>
	html += '      <option value="<?php echo $driver; ?>"><?php echo ucfirst($driver); ?></option>';
	<?php } ?>
    <?php } ?>
	html += '    </select></td>';
	html += '    <td class="left"><input type="text" name="module_caching_pro_modules[' + module_row + '][timeout]" value="3600" /></td>';
	html += '    <td class="center"><input type="checkbox" name="module_caching_pro_modules[' + module_row + '][get]" value="1" checked="checked" /></td>';
	html += '    <td class="center"><input type="checkbox" name="module_caching_pro_modules[' + module_row + '][post]" value="1" checked="checked" /></td>';
	html += '    <td class="center"><input type="checkbox" name="module_caching_pro_modules[' + module_row + '][files]" value="1" checked="checked" /></td>';
	html += '    <td class="center"><input type="checkbox" name="module_caching_pro_modules[' + module_row + '][cookie]" value="1" /></td>';
	html += '    <td class="center"><input type="checkbox" name="module_caching_pro_modules[' + module_row + '][session]" value="1" /></td>';
    html += '    <td class="left"><select name="module_caching_pro_modules[' + module_row + '][status]">';
    html += '      <option value="1" selected="selected"><?php echo $text_enabled; ?></option>';
    html += '      <option value="0"><?php echo $text_disabled; ?></option>';
    html += '    </select></td>';
	html += '    <td><a onclick="$(\'#module-row' + module_row + '\').remove();" class="button"><?php echo $button_remove; ?></a></td>';
	html += '  </tr>';
	html += '</tbody>';
	
	$('#module tfoot').before(html);
	
	module_row++;
}
//--></script> 
<?php echo $footer; ?>