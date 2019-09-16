<?php
/*
 * Written by xtetis
 * http://xtetis.com/
 */
error_reporting(0);
ini_set('display_errors',1);
$search = 'rel="prev"'; 



function scan_dir($dirname) 
{ 


$file_extensions_include = array('.php','.js','.txt','.html','.ctp','.tpl','.xml');
$enable_extensions_include_filter = true;

$file_extensions_exclude = array('.png','.jpg','.bmp','.avi');
$enable_extensions_exclude_filter = true;


	GLOBAL $search, $replace, $log; 

	$dir = opendir($dirname); 

	while (($file = readdir($dir)) !== false) 
	{

		if($file != "." && $file != "..") 
		{ 

			if(is_file($dirname."/".$file)&&filesize($dirname."/".$file)<1000000) 
			{
				if ($enable_extensions_include_filter)
				{
					$search_in_file = false;
					foreach ($file_extensions_include as $extension)
					{
						if (strpos($file,$extension))
						{
							$search_in_file = true;
						}
					}
					
					if (!$search_in_file)
					{
						continue;
					}
				}


				if ($enable_extensions_exclude_filter)
				{
					$search_in_file = true;
					foreach ($file_extensions_exclude as $extension)
					{
						if (strpos($file,$extension))
						{
							$search_in_file = false;
						}
					}
					
					if (!$search_in_file)
					{
						continue;
					}
				}
				

				$content_original = file_get_contents($dirname."/".$file); 
				
				$content_replaced = $content_original;           
				

				if(strstr($content_original,$search)){
					$log[]=$dirname."/".$file;
				}else{
				
				}
			}
			if(is_dir($dirname."/".$file)) 
			{
				scan_dir($dirname."/".$file);
			}
		}
	}

    closedir($dir); 

}
?>

<?php
scan_dir($_SERVER['DOCUMENT_ROOT'] );
if($log){
	echo 'FInd <b>'.htmlspecialchars($search).'</b> in files<br />';
	
	$i = 0;
	
	foreach($log as $s){
		$i++;
		echo '# '.$i.' -> '.$s.'<br />';
	}
}else{
	echo 'Nothing found<br />';
}
?>
