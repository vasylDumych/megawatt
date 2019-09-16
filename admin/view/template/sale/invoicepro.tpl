<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="<?php echo $direction; ?>" lang="<?php echo $language; ?>" xml:lang="<?php echo $language; ?>">
<head>
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<link rel="stylesheet" type="text/css" href="view/stylesheet/invoicepro.css" />
<style media="print" type="text/css">.noprint {display: none;}</style>
</head>
<body>
<span class="noprint">
	<a class="print-button" href="javascript:window.print(); void 0;" title="Распечатать счет">Печать</a>
</span>
<?php 
$voucher_colspan = 11;
$total_colspan = 13;
if ($show_pid) {$hide_pid = '';} else {$hide_pid = ' class="hidden noprint"';$voucher_colspan -= 1;$total_colspan -= 1;}
if ($show_image) {$hide_image = '';} else {$hide_image = ' class="hidden noprint"';$voucher_colspan -= 1;$total_colspan -= 1;}
if ($show_model) {$hide_model = '';} else {$hide_model = ' class="hidden noprint"';$voucher_colspan -= 1;$total_colspan -= 1;}
if ($show_sku) {$hide_sku = '';} else {$hide_sku = ' class="hidden noprint"';$voucher_colspan -= 1;$total_colspan -= 1;}
if ($show_upc) {$hide_upc = '';} else {$hide_upc = ' class="hidden noprint"';$voucher_colspan -= 1;$total_colspan -= 1;}
if ($show_ean) {$hide_ean = '';} else {$hide_ean = ' class="hidden noprint"';$voucher_colspan -= 1;$total_colspan -= 1;}
if ($show_jan) {$hide_jan = '';} else {$hide_jan = ' class="hidden noprint"';$voucher_colspan -= 1;$total_colspan -= 1;}
if ($show_isbn) {$hide_isbn = '';} else {$hide_isbn = ' class="hidden noprint"';$voucher_colspan -= 1;$total_colspan -= 1;}
if ($show_mpn) {$hide_mpn = '';} else {$hide_mpn = ' class="hidden noprint"';$voucher_colspan -= 1;$total_colspan -= 1;}
if ($show_location) {$hide_location = '';} else {$hide_location = ' class="hidden noprint"';$voucher_colspan -= 1;$total_colspan -= 1;}
?>
<?php foreach ($orders as $order) { ?>
<div style="page-break-after:always;width:990px;margin:auto;padding:30px;box-sizing:border-box;border:1px solid #ddd;box-shadow:0px 1px 5px rgba(85, 85, 85, 0.5);">
	<h1><?php echo $text_invoice; ?><?php if ($order['invoice_no']) { ?><?php echo $order['invoice_no']; ?><?php } ?></h1>
	<table class="store">
		<tr>
			<td valign="middle" width="50%">
				<img src="<?php echo $logo; ?>" alt="" />
			</td>
			<td valign="middle" width="50%" style="padding-left:30px;">
				<b><?php echo $order['store_name']; ?></b><br />
				<b><?php echo $text_address; ?></b><?php echo $order['store_address']; ?><br />
				<b><?php echo $text_telephone; ?></b><?php echo $order['store_telephone']; ?><br />
				<?php if ($order['store_fax']) { ?>
					<b><?php echo $text_fax; ?></b><?php echo $order['store_fax']; ?><br />
				<?php } ?>
				<b><?php echo $text_email; ?></b><?php echo $order['store_email']; ?><br />
				<b><?php echo $text_url; ?></b><?php echo $order['store_url']; ?>
			</td>
		</tr>
	</table>
	
	<table class="address">
		<tr class="heading">
			<td align="center" width="24%"><b><?php echo $text_order; ?></b></td>
			<td align="center" width="38%"><b><?php echo $text_to; ?></b></td>
			<td align="center" width="38%"><b><?php echo $text_ship_to; ?></b></td>
		</tr>
		<tr>
			<td valign="top">
				<b><?php echo $text_order_id; ?></b><?php echo $order['order_id']; ?>			
				<br /><b><?php echo $text_date_added; ?></b><?php echo $order['date_added']; ?>
			</td>
			<td valign="top">
				<?php echo $order['payment_address']; ?><br/>
				<?php echo $order['email']; ?><br/>
				<?php echo $order['telephone']; ?><br/>
				<?php if ($order['company']) { ?>
				<br/>
				<?php echo $text_company; ?> <?php echo $order['company']; ?>
				<?php } ?>
				<?php if ($order['payment_company_id']) { ?>
				<br/>
				<?php echo $text_company_id; ?> <?php echo $order['payment_company_id']; ?>
				<?php } ?>
				<?php if ($order['payment_tax_id']) { ?>
				<br/>
				<?php echo $text_tax_id; ?> <?php echo $order['payment_tax_id']; ?>
				<?php } ?>
			</td>
			<td valign="top">
				<?php echo $order['shipping_address']; ?>
			</td>
		</tr>
		<tr>
			<td class="method"><b><?php echo $text_payment_method; ?></b></td><td colspan="2"><?php echo $order['payment_method']; ?></td>
		</tr>
		<?php if ($order['shipping_method']) { ?>
		<tr>
			<td class="method"><b><?php echo $text_shipping_method; ?></b></td><td colspan="2"><?php echo $order['shipping_method']; ?></td>
		</tr>
		<?php } ?>
	</table>
	
	<?php if ($order['comment']) { ?>
	<table class="comment">
		<tr>
			<td class="method" width="24%"><b><?php echo $text_comment_customer; ?></b></td><td><?php echo $order['comment']; ?></td>
		</tr>
	</table>
	<?php } ?>
	
	<table class="product">
		<tr class="heading">
			<td align="center" style="width:45px;"<?php echo $hide_pid; ?>><b><?php echo $column_pid; ?></b></td>
			<td align="center" style="width:65px;"<?php echo $hide_image; ?>><b><?php echo $column_image; ?></b></td>
			<td align="center"><b><?php echo $column_product; ?></b></td>
			<td align="center" style="width:120px;"<?php echo $hide_model; ?>><b><?php echo $column_model; ?></b></td>
			<td align="center" style="width:120px;"<?php echo $hide_sku; ?>><b><?php echo $column_sku; ?></b></td>
			<td align="center" style="width:100px;"<?php echo $hide_upc; ?>><b><?php echo $column_upc; ?></b></td>
			<td align="center" style="width:100px;"<?php echo $hide_ean; ?>><b><?php echo $column_ean; ?></b></td>
			<td align="center" style="width:100px;"<?php echo $hide_jan; ?>><b><?php echo $column_jan; ?></b></td>
			<td align="center" style="width:100px;"<?php echo $hide_isbn; ?>><b><?php echo $column_isbn; ?></b></td>
			<td align="center" style="width:100px;"<?php echo $hide_mpn; ?>><b><?php echo $column_mpn; ?></b></td>
			<td align="center" style="width:100px;"<?php echo $hide_location; ?>><b><?php echo $column_location; ?></b></td>
			<td align="center" style="width:55px;"><b><?php echo $column_quantity; ?></b></td>
			<td align="center" style="width:90px;"><b><?php echo $column_price; ?></b></td>
			<td align="center" style="width:100px;"><b><?php echo $column_total; ?></b></td>
		</tr>
		<?php foreach ($order['product'] as $product) { ?>
			<tr>
				<td align="center" <?php echo $hide_pid; ?>><?php echo $product['product_id']; ?></td>
				<td align="center" <?php echo $hide_image; ?>><img src="<?php echo $product['img']; ?>" alt="" /></td>
				<td><?php echo $product['name']; ?>
					<?php foreach ($product['option'] as $option) { ?>
						<br />&nbsp;<small> - <?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>
					<?php } ?></td>
				<td <?php echo $hide_model; ?>><?php echo $product['model']; ?></td>
				<td <?php echo $hide_sku; ?>><?php echo $product['sku']; ?></td>
				<td <?php echo $hide_upc; ?>><?php echo $product['upc']; ?></td>
				<td <?php echo $hide_ean; ?>><?php echo $product['ean']; ?></td>
				<td <?php echo $hide_jan; ?>><?php echo $product['jan']; ?></td>
				<td <?php echo $hide_isbn; ?>><?php echo $product['isbn']; ?></td>
				<td <?php echo $hide_mpn; ?>><?php echo $product['mpn']; ?></td>
				<td <?php echo $hide_location; ?>><?php echo $product['location']; ?></td>
				<td align="center"><?php echo $product['quantity']; ?></td>
				<td align="right"><?php echo $product['price']; ?></td>
				<td align="right"><?php echo $product['total']; ?></td>
			</tr>
		<?php } ?>
		<?php foreach ($order['voucher'] as $voucher) { ?>
			<tr>
				<td align="left" colspan="<?php echo $voucher_colspan; ?>"><?php echo $voucher['description']; ?></td>
				<td align="right">1</td>
				<td align="right"><?php echo $voucher['amount']; ?></td>
				<td align="right"><?php echo $voucher['amount']; ?></td>
			</tr>
		<?php } ?>
		<?php foreach ($order['total'] as $total) { ?>
			<tr>
				<td align="right" colspan="<?php echo $total_colspan; ?>"><b><?php echo $total['title']; ?>:</b></td>
				<td align="right"><?php echo $total['text']; ?></td>
			</tr>
		<?php } ?>
	</table>

</div>
<?php } ?>
</body>
</html>