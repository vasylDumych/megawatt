<?php echo $header ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
      <?php echo $breadcrumb['separator'] ?><a href="<?php echo $breadcrumb['href'] ?>"><?php echo $breadcrumb['text'] ?></a>
    <?php } ?>
  </div>
  <?php if ($err) { ?>
    <div class="warning"><?php echo $err; ?></div>
  <?php } ?>
  <?php if (isset($success) && $success) { ?>
  <div class="success"><?php echo $success; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#setting-form').submit();" class="button"><?php echo $button_save; ?></a><a href="<?php echo $url_cancel; ?>" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <div id="tabs" class="htabs">
        <a href="#tab-connection"><?php echo $vipsms_net_tab_connection?></a>
        <a href="#tab-events"><?php echo $vipsms_net_tab_events?></a>
        <a href="#tab-sendsms"><?php echo $vipsms_net_tab_sendsms?></a>
        <a href="#tab-about"><?php echo $vipsms_net_tab_about?></a>
      </div>
        <form action="<?php echo $url_action ?>" method="post" id="setting-form">
          <div id="tab-connection">
            <div class="tab-inner-form">
              <table>
                <tr valign="top">
                  <td width="40%">
                    <fieldset>
                    <legend><?php echo $vipsms_net_text_gate_settings?></legend>
                    <p>
                      <label>
                        <?php echo $vipsms_net_text_login ?> <span class="required">*</span><br />
                        <input type="text" name="vipsms_net_login" value="<?php echo (isset($frm_vipsms_net_login) ? $frm_vipsms_net_login : '') ?>" />
                      </label>
                    </p>
                    <p>
                      <label>
                        <?php echo $vipsms_net_text_password ?> <span class="required">*</span><br />
                        <input type="password" name="vipsms_net_password" value="<?php echo (isset($frm_vipsms_net_password) ? $frm_vipsms_net_password : '') ?>" />
                      </label>
                    </p>
                    <?php if (!$err){?>
                      <?php if (!empty($frm_vipsms_net_login) && !empty($frm_vipsms_net_password)){
                          echo $vipsms_net_text_connection_established;
                        }else{
                          echo $vipsms_net_text_connection_error;
                        }
                      ?>
                    <?php } ?>
                    </fieldset>
                  </td>
                  <td>
                    <div class="tab-inner-description">
                      <p>
                        <?php echo $vipsms_net_text_connection_tab_description ?>
                      </p>
                    </div>
                  </td>
                </tr>
              </table>
            </div>
          </div>
          <div id="tab-events">
            <table width="100%">
              <tr>
                <td width="50%" valign="top">
                  <p>
                    <label>
                      <?php echo $vipsms_net_text_sign ?> <span class="required">*</span><br />
                      <input type="text" maxlength="11" name="vipsms_net_sign" value="<?php echo (isset($frm_vipsms_net_sign) ? $frm_vipsms_net_sign : '') ?>" />
                    </label>
                  </p>
				  
				  <!-- Текст смс в админке начало -->
                  <p>
                    <label>
                      Текст смс при успешном заказе <span class="required">*</span><br />
                      <img src="view/image/flags/ru.png" alt="" /> <input type="text" style="width:400px;" name="vipsms_net_textordersmsru" value="<?php echo (isset($frm_vipsms_net_textordersmsru) ? $frm_vipsms_net_textordersmsru : '') ?>" />
					  <br>
                      <img src="view/image/flags/ua.png" alt="" /> <input type="text" style="width:400px;" name="vipsms_net_textordersmsua" value="<?php echo (isset($frm_vipsms_net_textordersmsua) ? $frm_vipsms_net_textordersmsua : '') ?>" />
                    </label>
					<br>
					<span style="font-size:12px; font-style:italic;color:red;">(<b>%s</b> - вставка номера заказа)</span>
                  </p>
				  <!-- Текст смс в админке конец -->
				  
				  <!-- Шаблон смс в админке начало -->
                  <p>
                    <label>
					  <table style="border: 1px solid grey; padding: 10px;">
						<tr>
							<td><img src="view/image/review.png" align="bottom" style="height: 18px;" /> <b>Шаблоны смс:</b></td>
						</tr>						<tr>
							<td>Имя шаблона:</td><td>Значение шаблона:</td>
						</tr>
						<tr>
							<td><input type="text" style="width:100px;" name="vipsms_net_nameshablon1" value="<?php echo (isset($frm_vipsms_net_nameshablon1) ? $frm_vipsms_net_nameshablon1 : '') ?>" /></td><td><input type="text" style="width:400px;" name="vipsms_net_shablon1" value="<?php echo (isset($frm_vipsms_net_shablon1) ? $frm_vipsms_net_shablon1 : '') ?>" /></td>
						</tr>
						<tr>
							<td><input type="text" style="width:100px;" name="vipsms_net_nameshablon2" value="<?php echo (isset($frm_vipsms_net_nameshablon2) ? $frm_vipsms_net_nameshablon2 : '') ?>" /></td><td><input type="text" style="width:400px;" name="vipsms_net_shablon2" value="<?php echo (isset($frm_vipsms_net_shablon2) ? $frm_vipsms_net_shablon2 : '') ?>" /></td>
						</tr>
						<tr>
							<td><input type="text" style="width:100px;" name="vipsms_net_nameshablon3" value="<?php echo (isset($frm_vipsms_net_nameshablon3) ? $frm_vipsms_net_nameshablon3 : '') ?>" /></td><td><input type="text" style="width:400px;" name="vipsms_net_shablon3" value="<?php echo (isset($frm_vipsms_net_shablon3) ? $frm_vipsms_net_shablon3 : '') ?>" /></td>
						</tr>
						<tr>
							<td><input type="text" style="width:100px;" name="vipsms_net_nameshablon4" value="<?php echo (isset($frm_vipsms_net_nameshablon4) ? $frm_vipsms_net_nameshablon4 : '') ?>" /></td><td><input type="text" style="width:400px;" name="vipsms_net_shablon4" value="<?php echo (isset($frm_vipsms_net_shablon4) ? $frm_vipsms_net_shablon4 : '') ?>" /></td>
						</tr>
						<tr>
							<td><input type="text" style="width:100px;" name="vipsms_net_nameshablon5" value="<?php echo (isset($frm_vipsms_net_nameshablon5) ? $frm_vipsms_net_nameshablon5 : '') ?>" /></td><td><input type="text" style="width:400px;" name="vipsms_net_shablon5" value="<?php echo (isset($frm_vipsms_net_shablon5) ? $frm_vipsms_net_shablon5 : '') ?>" /></td>
						</tr>
					  </table>
                    </label>
                  </p>
				  <!-- Шаблон смс в админке конец -->

                  <p>
                    <?php echo $vipsms_net_text_notify_sms_to_admin?>:
                  </p>
                  <p>
                    <label>
                      <input type="checkbox" name="vipsms_net_events_admin_new_customer" value="1" <?php echo (isset($frm_vipsms_net_events_admin_new_customer) ? 'checked="checked"' : false) ?> />
                      <?php echo $vipsms_net_events_admin_new_customer ?>
                    </label>
                  </p>
                  <p>
                    <label>
                      <input type="checkbox" name="vipsms_net_events_admin_new_order" value="1" <?php echo (isset($frm_vipsms_net_events_admin_new_order) ? 'checked="checked"' : false) ?> />
                      <?php echo $vipsms_net_events_admin_new_order ?>
                    </label>
                  </p>
                  <p>
                    <label>
                      <input type="checkbox" name="vipsms_net_events_admin_new_email" value="1" <?php echo (isset($frm_vipsms_net_events_admin_new_email) ? 'checked="checked"' : false) ?> />
                      <?php echo $vipsms_net_events_admin_new_email ?>
                    </label>
                  </p>
                  <p>
                    <label>
                      <input type="checkbox" name="vipsms_net_events_admin_gateway_connection_error" value="1" <?php echo (isset($frm_vipsms_net_events_admin_gateway_connection_error) ? 'checked="checked"' : false) ?> />
                      <?php echo $vipsms_net_events_admin_gateway_connection_error ?>
                    </label>
                  </p>
                </td>
                <td width="50%" valign="top">
                  <p>
                    <label>
                      <?php echo $vipsms_net_text_admphone ?> <span class="required">*</span><br />
                      <?php if (!isset($frm_vipsms_net_admphone1)) $frm_vipsms_net_admphone1='';?>
                      <input type="text" maxlength="15" name="vipsms_net_admphone" value="<?php echo (isset($frm_vipsms_net_admphone) ? $frm_vipsms_net_admphone : '') ?>" /><a onclick="javascript:void(0)" id="vipsms_plus_admphone">[<?php if (!strlen($frm_vipsms_net_admphone1)):?>+<?php else:?>-<?php endif?>]</a>
                    </label>
                    <input type="text" placeholder="еще один" maxlength="15" name="vipsms_net_admphone1" value="<?php echo (isset($frm_vipsms_net_admphone1) ? $frm_vipsms_net_admphone1 : '') ?>"<?php if (!strlen($frm_vipsms_net_admphone1)):?> style="display:none"<?php endif?> />
                  </p>
                  <p>
                    <?php echo $vipsms_net_text_notify_sms_to_customer ?>:
                  </p>
                  <p>
                    <label>
                      <input type="checkbox" name="vipsms_net_events_customer_new_order" value="1" <?php echo (isset($frm_vipsms_net_events_customer_new_order) ? 'checked="checked"' : false) ?> />
                      <?php echo $vipsms_net_events_customer_new_order ?>
                    </label>
                  </p>
                  <p>
                    <label>
                      <input type="checkbox" name="vipsms_net_events_customer_new_order_status" value="1" <?php echo (isset($frm_vipsms_net_events_customer_new_order_status) ? 'checked="checked"' : false) ?> />
                      <?php echo $vipsms_net_events_customer_new_order_status ?>
                    </label>
                  </p>
                  <p>
                    <label>
                      <input type="checkbox" name="vipsms_net_events_customer_new_register" value="1" <?php echo (isset($frm_vipsms_net_events_customer_new_register) ? 'checked="checked"' : false) ?> />
                      <?php echo $vipsms_net_events_customer_new_register ?>
                    </label>
                  </p>
                </td>
              </tr>
            </table>
          </div>
          <input type="hidden" name="setting_form" value="1" />
        </form>
        <form action="<?php echo $url_action ?>" method="post" id="sendsms_form">
        <div id="tab-sendsms">
                    <fieldset>
                    <legend><?php echo $vipsms_net_text_gate_settings?></legend>
                    <p>
                      <label>
                        <?php echo $vipsms_net_text_frmsms_phone?> <span class="required">*</span><br />
                        <input type="text" name="vipsms_net_frmsms_phone" value="<?php echo (isset($frm_vipsms_net_frmsms_phone) ? $frm_vipsms_net_frmsms_phone : '') ?>" />
                      </label>
                    </p>
                    <p>
                      <label>
                        <?php echo $vipsms_net_text_frmsms_message?> <span class="required">*</span><br />
                        <textarea rows="8" cols="60" name="vipsms_net_frmsms_message"><?php echo (isset($frm_vipsms_net_frmsms_message) ? $frm_vipsms_net_frmsms_message : '') ?></textarea>
                      </label>
                    </p>
                    <div class="buttons"><a onclick="$('#sendsms_form').submit();" class="button"><?php echo $vipsms_net_text_button_send_sms; ?></a></div>
                    </fieldset>

        </div>
          <input type="hidden" name="sendsms_form" value="1" />
        </form>
        <div id="tab-about">
          <?php echo sprintf($vipsms_net_text_about_tab_description, $heading_title, date('Y'), $module_version)?>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
/*<![CDATA[*/
$('#tabs a').tabs();
<?php if ($tab_sel){ echo "$('#tabs > a[href=#tab-sendsms]').click()\n"; }?>
/*]]>*/
$('#vipsms_plus_admphone').on('click', function(){
  $("input[name=vipsms_net_admphone1]").toggle();
});
</script>

<?php echo $footer ?>

<?# vi:ts=2:sw=2:ai:et:ft=php:enc=utf8
?>
