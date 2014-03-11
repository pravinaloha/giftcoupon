<?php

$fileInName = 'xxxxx.xml';
$fileOutName = 'yyyyy.xml';
$cmd = 'nice -n 19 cat ' .$fileInName . ' | nice -n 19 php -r \'if (($fh = fopen("php://stdin", "r")) !== false) { while (($line = fgets($fh, 4096))) { $line=trim($line);  echo str_ireplace("author", "XXXXXXX", $line) . "\n"; }}\' > ' .$fileOutName . ' ';
shell_exec($cmd);


/*$fileInName = 'xxxxx.xml';
$fileOutName = 'yyyyy.xml';
$cmd = 'nice -n 19 cat ' .$fileInName . ' | nice -n 19 php -r \'if (($fh = fopen("php://stdin", "r")) !== false) { while (($line = fgets($fh, 4096))) { $line=trim($line);  echo str_ireplace("author", "XXXXXXX", $line) . "\n"; }}\' > ' .$fileOutName . ' ';
shell_exec($cmd);*/

?>