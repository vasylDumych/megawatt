<?php echo $header; ?>
<div id="content">
    <div class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
        <?php } ?>
    </div>
    <?php if (isset($error_warning)) { ?>
    <div class="warning"><?php echo $error_warning; ?></div>
    <?php } ?><?php if (isset($success)) { ?>
<div class="success"><?php echo $success; ?></div>
<?php } ?>
    <style type="text/css">
        .form button {
        margin:6px 0;
        }
        button {
        border: none;
        cursor: pointer;
        text-decoration: none;
        color: white;
        display: inline-block;
        padding: 5px 15px 5px 15px;
        background: #003A88;
        -webkit-border-radius: 10px 10px 10px 10px;
        -moz-border-radius: 10px 10px 10px 10px;
        -khtml-border-radius: 10px 10px 10px 10px;
        border-radius: 10px 10px 10px 10px;
        }
        .template-info {
        font-size:10px;
        color:#999;
        font-style:italic;
        }
    </style>
    <div class="box">
        <div class="heading">
            <h1><img src="view/image/module.png" alt=""/> <?php echo $heading_title; ?></h1>

            <div class="buttons">
                <a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $back; ?></span></a>
            </div>
        </div>
        <div class="content">
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
                <table class="form">
                    <tr>
                        <td><?php echo $source_language;?></td>
                        <td>
                            <select name="source_language_code" id="source_language_code">
                                <?php foreach ($languages as $language) {
                                echo '<option value="' . $language['code'] . '"' . ($language['code']==$source_language_code?' selected="selected"':'') . '>' . $language['name'] . '</option>';
                                }?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $categories;?></td>
                        <td>
                            <label for="categories_template"><?php echo $template;?> </label><input type="text" id="categories_template" name="categories_template" value="<?php echo $categories_template;?>" size="80">

                            <div class="template-info"><?php echo $available_category_tags;?></div>
                                <button type="submit" name="categories" value="categories"><?php echo $generate;?></button>
                            <br/><?php echo $warning_clear;?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $products;?></td>
                        <td>
                            <label for="products_template"><?php echo $template;?> </label><input type="text" id="products_template" name="products_template" value="<?php echo $products_template;?>" size="80"><br/>

                            <div class="template-info"><?php echo $available_product_tags;?></div>
                                <button type="submit" name="products" value="products"><?php echo $generate;?></button>
                            <br/><?php echo $warning_clear;?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $manufacturers;?></td>
                        <td>
                            <label for="manufacturers_template"><?php echo $template;?> </label><input type="text" id="manufacturers_template" name="manufacturers_template" value="<?php echo $manufacturers_template;?>" size="80"><br/>

                            <div class="template-info"><?php echo $available_manufacturer_tags;?></div>
                            <button type="submit" name="manufacturers" value="manufacturers"><?php echo $generate;?></button>
                            <br/><?php echo $warning_clear;?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $meta_keywords;?></td>
                        <td>
                            <label for="meta_template"><?php echo $template;?> </label><input type="text" id="meta_template" name="meta_template" value="<?php echo $meta_template;?>" size="80"><br/>

                            <div class="template-info"><?php echo $available_meta_tags;?></div>
                            
                            <button type="submit" name="meta_keywords" value="meta_keywords"><?php echo $generate;?></button>
                            <br/><?php echo $warning_clear;?>
                        </td>
                    </tr>
					 <tr>
                        <td><?php echo $meta_description;?></td>
                        <td>
                            <label for="description_template"><?php echo $template;?> </label><input type="text" id="description_template" name="description_template" value="<?php echo $description_template;?>" size="80"><br/>

                             <div class="template-info"><?php echo $available_description_tags;?></div>
                            <button type="submit" name="meta_description" value="meta_description"><?php echo $generate;?></button>
                            <br/><?php echo $warning_clear;?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $tags;?></td>
                        <td>
                            <label for="tags_template"><?php echo $template;?> </label><input type="text" id="tags_template" name="tags_template" value="<?php echo $tags_template;?>" size="80"><br/>

                            <div class="template-info"><?php echo $available_tags_tags;?></div>
                            <button type="submit" name="tags" value="tags"><?php echo $generate;?></button>
                            <br/><?php echo $warning_clear_tags;?>
                        </td>
                    </tr>
					<tr>
                        <td>Статьи</td>
                        <td>
                            <button type="submit" name="states" value="states"><?php echo $generate;?></button>    <br> Сохраняет текущие ссылки, и создает только новые!	                  
                        </td>
                    </tr>
					<tr>
                        <td>Картинки</td>
                        <td>
						Исправляет ссылки картинки с русскими символами делая транслит из них и пробелы заменяя на "_". Для: Яндекс маркет, sitemap.<br>
						
						<br>
						<input name="Сimage" type="checkbox" <?  if (isset($this->request->post['Сimage'])) echo "checked='checked'";	?> value="1" />Сгенерировать для всех картинок новые ссылки<br>  (если не ставить то исправит только у тех у которых не русские именя,символы и тд. остальных не тронет) <br> <br>
						<input name="СimageDel" type="checkbox" <?  if (isset($this->request->post['СimageDel'])) echo "checked='checked'";	?> value="1" /> Можно ли удалять картинки из БД, если они не существуют (путь куда ссылаются) или не корректны совсем типо "-.jpg"? <br><br>
						<input name="СimageCopy" type="checkbox" <?  if (isset($this->request->post['СimageCopy'])) echo "checked='checked'";	?> value="1" /> Использовать копирование вместо перемещения. <br>В 2 раза больше места потратить, при том что вероятнее всего вы будете лишь новыми ссылками пользоваться, а старые будут тупо валяться, пока не удалите вручную. Но зато даже внешние ссылки от картинок сохраняться если эти картинки где то использовались на сайте. Самый безопасный способ без повреждения сайту, если место позволяет. Но лучше всего без, а если где то накроеться ссылка на сайте, заново ее проложите.<br> Если не поставить галочку то если вы где то эти картинки использовали кроме товаров то вам придеться их потом там изменить вручную на новые<br><br>
                            <button type="submit" name="image" value="image"><?php echo $generate;?></button>    
                        </td>
                    </tr>
					<tr>
                        <td>Родные ссылки</td>
                        <td>
						Сгенерируем все родные ссылки типо "регистрация","бренды","карты сайта" и тд.<br>
						Шаблон: ('заменим ссылку route=что то','на это'), <br>
						Например: ( 'information/contact', 'contact'),<br>
						<textarea name="textSql"><?
						if (isset($this->request->post['textSql'])) echo $this->request->post['textSql']; // если неписал ничего то
						else {
						?>('product/manufacturer', 'brands'),
 ( 'information/contact', 'contact'),
 ('account/return/insert', 'returns'),
 ( 'information/sitemap', 'sitemap'),
 ('account/voucher', 'podarok'),
 ('affiliate/account', 'partners'),
 ('product/special', 'special'),
 ('account/account', 'account'),
 ('account/order', 'zakaz'),
 ( 'account/wishlist', 'wishlist'),
 ( 'account/newsletter', 'newsletter')<? }?>
						</textarea><br>
                            <button type="submit" name="rodn" value="rodn"><?php echo $generate;?></button> <br>
Сохраняет текущие ссылки, и создает только новые!							
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>
