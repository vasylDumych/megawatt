<?
function jr_redirect($url) {
	// JR на врыве
	$redirects = file_get_contents($_SERVER['DOCUMENT_ROOT']."/inweb/redirect.txt");

	$links = explode("\n", $redirects);

	$url = 'https://'.$_SERVER['HTTP_HOST'].trim($url);

	foreach($links as $link) {
		$link0 = explode(" ", $link);

		@$link1 = trim($link0[0]);
		@$link2 = trim($link0[1]);

		if ($link1 == $url) {
			header("HTTP/1.1 301 Moved Permanently");
			header("Location: $link2");
			die();
		}
	}
}

function parce_seo_macros($tdz) {
	$h1 = '';
	$desk = '';
	$title = '';
	preg_match('/Title:(.*)[\n|\r]/Usi', $tdz, $title); $title = trim($title[1]);
	preg_match('/Description:(.*)[\n|\r]/Usi', $tdz, $desk); $desk = trim($desk[1]);
	preg_match('/h1:(.*)[\n|\r]/Usi', $tdz, $hone);
	//print_r($hone);
	if (isset($hone[1]))
	{
		//$h1 = var_export($hone,true);
		$h1 = $hone[1];
	}

	preg_match('/Keywords:(.*)[\n|\r]/Usi', $tdz, $keys); $keys = trim($keys[1]);
	//preg_match('/Seotext:(.*)$/Usi', $tdz, $seotext); $seotext = trim($seotext[1]);

	//return array('title' => $title, 'description' => $desk, 'keywords' => $keys, 'h1' => $h1/*, 'seotext' => $seotext*/);
	//return array('h1' => $h1, 'description' =>  $desk, 'title' => $title);
	return array('title' => $title, 'description' => $desk, 'keywords' => $keys, 'h1' => $h1);

}

function get_seo_tds() {
	$return = array();
	$tdz = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/seo_inweb/tdz.txt');
	$tdz = str_replace("\r", '', $tdz);
	$sections = explode("https://$_SERVER[HTTP_HOST]", $tdz);

	foreach($sections as $section) {
		$lines = explode("\n", $section);
		$url = trim($lines[0]);
		
		unset($lines[0]);
		if($url == $_SERVER['REQUEST_URI']) {
			$tdz = implode("\n", $lines);
			$return = parce_seo_macros($tdz);
			return $return;
		}
	}

}
