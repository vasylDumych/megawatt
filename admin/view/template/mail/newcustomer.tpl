<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/1999/REC-html401-19991224/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo $title; ?></title>
<style type="text/css">
body {
	color: #000000;
	font-family: Arial, Helvetica, sans-serif;
}
body, a {
	font-size: 12px;
}
#container {
	width: 680px;
}
#logo {
	margin-bottom: 20px;
}
p {
	margin-top: 0px;
	margin-bottom: 20px;
}
a, a:visited, a b {
	color: #378DC1;
	text-decoration: underline;
	cursor: pointer;
}
a img {
	border: none;
}
</style>
</head>
<body>
<div id="container"><a href="<?php echo $store_url; ?>" title="<?php echo $store_name; ?>"><img id="logo" src="<?php echo $logo; ?>" alt="<?php echo $store_name; ?>" /></a>
	<p><?php echo $text_message; ?></p>
	<p><?php echo $text_create_account; ?></p>
</div>
</body>
</html>