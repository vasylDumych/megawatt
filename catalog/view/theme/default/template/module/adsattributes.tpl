<div class="box" id="box_search">
  <div class="box-heading"><?php echo $heading_title; ?></div>
  <div class="box-content">
      <table border="0">
         <tr>
          <td colspan="4"><?php echo $entry_search; ?></td>
         </tr>
          <tr>
          <td colspan="4"><?php if ($filter_name) { ?>
      <input style="width: 145px;" type="text" id="filter_name" name="filter_name" value="<?php echo $filter_name; ?>" />
      <?php } else { ?>
      <input style="width: 145px;" type="text" id="filter_name" name="filter_name" value="<?php echo $filter_name; ?>" onclick="this.value = '';" onkeydown="this.style.color = '000000'" style="color: #999;" />
      <?php } ?></td>
        </tr>

          <tr>
          <td colspan="4"><?php echo $entry_category; ?></td>
          </tr>
          <tr>
          <td colspan="4">
           <select style="width: 155px;" name="filter_category_id" id="filter_category_id">
              <option value="0"><?php echo $text_category; ?></option>
              <?php foreach ($categories as $category) { ?>
              <?php if ($category['category_id'] == $filter_category_id) { ?>
              <option value="<?php echo $category['category_id']; ?>" selected="selected"><?php echo $category['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select>
          </td>
        </tr>
          <tr>
          <td colspan="4">
              <?php if ($filter_sub_category) { ?>
              <input type="checkbox" name="filter_sub_category" value="1" id="filter_sub_category" checked="checked" />
              <?php } else { ?>
              <input type="checkbox" name="filter_sub_category" value="1" id="filter_sub_category" />
              <?php } ?>
              <label for="filter_sub_category"><?php echo $text_sub_category; ?></label>
        </tr>
          <tr>


        <tr>
          <td colspan="4"><?php echo $entry_manufacture; ?></td>
        </tr>
        <tr>
          <td colspan="4">
          <select style="width: 155px;" name="filter_manufacturer_id" id="filter_manufacturer_id">
              <option value=""><?php echo $text_manufacturer; ?></option>
          <?php foreach ($manufacturers as $manufacturer) { ?>
              <?php if ($manufacturer['manufacturer_id'] == $filter_manufacturer_id) { ?>
              <option value="<?php echo $manufacturer['manufacturer_id']; ?>" selected="selected"><?php echo $manufacturer['name'] . ' (' .$manufacturer['countproduct'] . ')'; ?></option>
              <?php } else { ?>
              <option value="<?php echo $manufacturer['manufacturer_id']; ?>"><?php echo $manufacturer['name'] . ' (' .$manufacturer['countproduct'] . ')'; ?></option>

          <?php } ?>
          <?php } ?>
           </select>
          </td>
        </tr>

        <tr>
            <td colspan="4" style="padding-top: 8px;"><?php echo $entry_groups_attribute; ?></td>
        </tr>
        <tr>
          <td colspan="4">
              <select name="filter_groups" style="width: 155px;" id="filter_groups">
              <option value=""><?php echo $text_groups_attribute; ?></option>
          <?php foreach ($groupsattribute as $group) { ?>
              <?php if ($group['attribute_group_id'] == $filter_groups) { ?>
              <option value="<?php echo $group['attribute_group_id']; ?>" selected="selected"><?php echo $group['name'] . ' (' . $group['countproduct'] . ')'; ?></option>
              <?php } else { ?>
              <option value="<?php echo $group['attribute_group_id']; ?>"><?php echo $group['name'] . ' (' . $group['countproduct'] . ')'; ?></option>

          <?php } ?>
          <?php } ?>
           </select>
          </td>
        </tr>
        <tr>
          <td colspan="4"><?php echo $entry_attribute; ?></td>
        </tr>
         <tr>
          <td colspan="4">
           <select name="filter_attribute" style="width: 155px;" id="filter_attribute">
              <option value=""><?php echo $text_attribute; ?></option>
          <?php foreach ($attributes as $attribute) { ?>
              <?php if ($attribute['attribute_id'] == $filter_attribute) { ?>
              <option value="<?php echo $attribute['attribute_id']; ?>" selected="selected"><?php echo $attribute['name'] . ' (' . $attribute['countproduct'] . ')'; ?></option>
              <?php } else { ?>
              <option value="<?php echo $attribute['attribute_id']; ?>"><?php echo $attribute['name'] . ' (' . $attribute['countproduct'] . ')'; ?></option>

          <?php } ?>
          <?php } ?>
           </select> 
          </td>
        </tr>

        <tr>
          <td colspan="4"><?php echo $text_price; ?></td>
        </tr>
        <tr>
          <td align="right"><?php echo $text_pricemin; ?>&nbsp;</td>
          <td><input type="text" size="4" value="<?php echo $filter_pricemin; ?>" id="filter_pricemin" /></td>
    
          <td align="right"><?php echo $text_pricemax; ?>&nbsp;</td>
          <td><input type="text" size="4" value="<?php echo $filter_pricemax; ?>" id="filter_pricemax" /></td>
        </tr>

        <tr>
          <td colspan="4">
                <?php if ($filter_description) { ?>
                    <input type="checkbox" name="filter_description" value="1" id="filter_description" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="filter_description" value="0" id="filter_description" />
                    <?php } ?>
                    <label for="description"><?php echo $entry_description; ?></label>
          </td>
        </tr>
	<tr>
          <td colspan="4"></td>
        </tr>

        <tr>
            <td align="right" colspan="4">
              <a onclick="contentAdsattributes();" class="button"><span><?php echo $button_search; ?></span></a>

              </td>
        </tr>

      </table>
    </div>
  
<script type="text/javascript">
	$(document).ready(function(){
	  $(".box-content #filter_name").autocomplete("index.php?route=module/adsattributes/autocomplete", {
	    delay:10,
	    minChars:1
	  });
	});
</script> 


<script type="text/javascript"><!--
 $('#box_search input').keydown(function(e) {
	if (e.keyCode == 13) {
		contentAdsattributes();
	}
  });

  function contentAdsattributes() {
	url = 'index.php?route=product/adsattributes';

	var filter_name = $('#box_search #filter_name').attr('value');

	if (filter_name) {
		url += '&filter_name=' + encodeURIComponent(filter_name);
	}

	var filter_category_id = $('#box_search #filter_category_id').attr('value');

	if (filter_category_id) {
		url += '&filter_category_id=' + encodeURIComponent(filter_category_id);
	}

	var filter_sub_category = $('#box_search input[name=\'filter_sub_category\']:checked').attr('value');
  
	if (filter_sub_category) {
		url += '&filter_sub_category=true';
	}

	if ($('#box_search #filter_description').attr('checked')) {
		url += '&filter_description=1';
	}

	if ($('#box_search #model').attr('checked')) {
		url += '&model=1';
	}

       var filter_manufacturer_id = $('#box_search #filter_manufacturer_id').attr('value');

	if (filter_manufacturer_id) {
		url += '&filter_manufacturer_id=' + encodeURIComponent(filter_manufacturer_id);
	}

      var filter_pricemin = $('#box_search #filter_pricemin').attr('value');

	if (filter_pricemin) {
		url += '&filter_pricemin=' + encodeURIComponent(filter_pricemin);
	}

       var filter_pricemax = $('#box_search #filter_pricemax').attr('value');

	if (filter_pricemax) {
		url += '&filter_pricemax=' + encodeURIComponent(filter_pricemax);
	}

       var filter_groups = $('#box_search #filter_groups').attr('value');

	if (filter_groups) {
		url += '&filter_groups=' + encodeURIComponent(filter_groups);
	}

       var filter_attribute = $('#box_search #filter_attribute').attr('value');

	if (filter_attribute) {
		url += '&filter_attribute=' + encodeURIComponent(filter_attribute);
	}

	location = url;
}
//--></script>

<script language="javascript" type="text/javascript">
     $(document).ready(function () {
        
           $('#box_search select[name=filter_category_id]').change(function(){
                  $('#box_search select[name=\'filter_manufacturer_id\']').html("<option value=\"\"><?php echo $text_manufacturer; ?></option>")
                  $('#box_search select[name=\'filter_groups\']').html("<option value=\"\"><?php echo $text_groups_attribute; ?></option>")
                  $('#box_search select[name=\'filter_attribute\']').html("<option value=\"\"><?php echo $text_attribute; ?></option>")
                        if($('#box_search #filter_sub_category').attr('checked')=='checked') 
                              sub_category = true 
                          else 
                              sub_category=''
                   $('#box_search select[name=\'filter_manufacturer_id\']').load('index.php?route=module/adsattributes/manufacturer&filter_category_id=' + $(this).val()+ '&filter_sub_category=' + sub_category);
                   $('#box_search select[name=\'filter_groups\']').load('index.php?route=module/adsattributes/groups&filter_category_id=' + $(this).val() + '&filter_sub_category=' + sub_category);
                   $('#box_search select[name=\'filter_attribute\']').load('index.php?route=module/adsattributes/attributes&filter_category_id=' + $(this).val() + '&filter_sub_category=' + sub_category);
                 
             });
             
         $('#box_search input[name=filter_sub_category]').change(function(){
               $('#box_search select[name=\'filter_manufacturer_id\']').html("<option value=\"\"><?php echo $text_manufacturer; ?></option>")
                  $('#box_search select[name=\'filter_groups\']').html("<option value=\"\"><?php echo $text_groups_attribute; ?></option>")
                  $('#box_search select[name=\'filter_attribute\']').html("<option value=\"\"><?php echo $text_attribute; ?></option>")
                  if($('#box_search #filter_sub_category').attr('checked')=='checked') 
                      sub_category=true 
                  else 
                      sub_category=''
                   $('#box_search select[name=\'filter_manufacturer_id\']').load('index.php?route=module/adsattributes/manufacturer&filter_category_id=' + $('#box_search #filter_category_id').attr('value')+ '&filter_sub_category=' + sub_category);
                   $('#box_search select[name=\'filter_groups\']').load('index.php?route=module/adsattributes/groups&filter_category_id=' + $('#box_search #filter_category_id').attr('value')+ '&filter_sub_category=' + sub_category);
                   $('#box_search select[name=\'filter_attribute\']').load('index.php?route=module/adsattributes/attributes&filter_category_id=' + $('#box_search #filter_category_id').attr('value')+ '&filter_sub_category=' + sub_category);
            });

               
      
           $('select[name=\'filter_manufacturer_id\']').change(function(){
                  $('select[name=\'filter_groups\']').html("<option value=\"\"><?php echo $text_groups_attribute; ?></option>")
                  $('select[name=\'filter_attribute\']').html("<option value=\"\"><?php echo $text_attribute; ?></option>")
                         if($('#box_search #filter_sub_category').attr('checked')=='checked') 
                              sub_category = true 
                          else 
                              sub_category=''                 
                   $('select[name=\'filter_groups\']').load('index.php?route=module/adsattributes/groups&filter_category_id=' + $('#box_search #filter_category_id').attr('value')+ '&filter_sub_category=' + sub_category + '&filter_manufacturer_id=' + $(this).val());
                   $('select[name=\'filter_attribute\']').load('index.php?route=module/adsattributes/attributes&filter_category_id=' + $('#box_search #filter_category_id').attr('value')+ '&filter_sub_category=' + sub_category + '&filter_manufacturer_id=' + $(this).val());
                });        
              
           $('select[name=filter_groups]').change(function(){
                  $('select[name=\'filter_attribute\']').html("<option value=\"\"><?php echo $text_attribute; ?></option>")
                          if($('#box_search #filter_sub_category').attr('checked')=='checked') 
                              sub_category = true 
                          else 
                              sub_category=''                  
                   $('select[name=\'filter_attribute\']').load('index.php?route=module/adsattributes/attributes&filter_category_id=' + $('#box_search #filter_category_id').attr('value')+ '&filter_sub_category=' + sub_category + '&filter_manufacturer_id=' + $('#box_search #filter_manufacturer_id').attr('value') + '&filter_groups='+ $(this).val());
                });

     });
</script>
<div style='display: none;'><a href="http://cmsassistant.net/" title='шаблоны opencart'>шаблоны opencart</a></div>
</div>