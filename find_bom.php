<? /*

Этот скрипт ищет файлы, сохраненные с BOM.
Использование: 
1. залить на сервер в корневую директорию сайта
2. в адресной строке броузера набрать http://ваш.сайт/find_bom.php
Проверяются директории catalog, system, admin (все рекурсивно) и корневая (без рекурсии).
Если нужно проверить другие, добавьте и их по аналогии
*/

check_dir('.', 0);
check_dir('./catalog', 1);
check_dir('./system', 1);
check_dir('./admin', 1);

function check_dir($path, $recurs) {
	
	if ($dir = @opendir($path)) {
		
		while($file = readdir($dir)) {
		
			if ($file == '.' or $file == '..') { 
				continue;
			}

			$file = $path . '/' . $file;

			if (is_dir($file) && $recurs)  {
				check_dir($file, 1);
			}

			if (is_file($file) && strstr($file,'.php')) { 
				
				$f = fopen($file,'r');
				$t = fread($f, 3);
				
				if ($t == "\xEF\xBB\xBF") {
				 	echo "$file<br>\n";
				}
				
				fclose ($f);
			}
		} 
		
		closedir($dir);
 	}
}