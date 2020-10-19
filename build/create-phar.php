<?php
$srcRoot = "../src/";
$buildRoot = "./";
$vendor="../vendor/";

$phar = new Phar($buildRoot . "backuper.phar",
    FilesystemIterator::CURRENT_AS_FILEINFO |     	FilesystemIterator::KEY_AS_FILENAME, "backuper.phar");
$phar['src/backuper.php'] = file_get_contents($srcRoot.'backuper.php');
$phar['src/InputDirectoryLocation.php'] = file_get_contents($srcRoot.'InputDirectoryLocation.php');
$phar['src/OutputDirectoryLocation.php'] = file_get_contents($srcRoot.'OutputDirectoryLocation.php');
$phar['src/Synchronizer.php'] = file_get_contents($srcRoot.'Synchronizer.php');
$phar->buildFromIterator(new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($vendor,RecursiveDirectoryIterator::SKIP_DOTS)),'D:\kostya\Desktop\Workbranch\TheBrainBackuper\\');
$phar->setStub($phar->createDefaultStub("backuper.php"));

copy($srcRoot."configuration.php", $buildRoot . "configuration.php");