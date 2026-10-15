<?php

// al voor het starten van Laravel een aparte Blade-cache gebruiken voor de tests
$compiledPath = sys_get_temp_dir().'/jamin-blade-tests-'.getmypid();
if (! is_dir($compiledPath)) {
    mkdir($compiledPath, 0777, true);
}
putenv('VIEW_COMPILED_PATH='.$compiledPath);
$_ENV['VIEW_COMPILED_PATH'] = $compiledPath;
$_SERVER['VIEW_COMPILED_PATH'] = $compiledPath;

require dirname(__DIR__).'/vendor/autoload.php';
