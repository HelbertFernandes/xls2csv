<?php

use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Csv;

require 'vendor/autoload.php';

$filename = @$argv[1];
if($filename=='') die("{$argv[0]} <filename>\n");
if(!is_file($filename)) die("File not found: {$filename}\n");
print "Load..: $filename\n";

$dir = dirname($filename);
$pre = explode('.', basename($filename))[0];

$reader = new Xlsx();
$xls = $reader->load($filename);
$sheets = $xls->getSheetNames();

$csv = new Csv($xls);
$csv->setOutputEncoding('UTF8');
$csv->setDelimiter(';');
$csv->setEnclosure('"');

foreach ($sheets as $sheetIndex => $sheetName) {
	$csv->setSheetIndex($sheetIndex);
	$file="$dir/{$pre}_{$sheetName}.csv";
	print "Create: $file\n";
	$csv->save($file);
}
