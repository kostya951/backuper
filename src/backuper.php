<?php
define('WINDOW_SIZE',5000);
define('TEST_MODE',false);

require_once('../vendor/autoload.php');
use kostya\backuper\InputDirectoryLocation;
use kostya\backuper\OutputDirectoryLocation;
use kostya\backuper\Synchronizer;
use kostya\configuration\PhpArrayConfiguration;
use kostya\configuration\ConfigurationException;

$configuration = new PhpArrayConfiguration();
try {
    echo 'Читаю конфигурацию'.PHP_EOL;
    $configuration->read();
}catch (ConfigurationException $exception){
    echo $exception;
    exit();
}

Logger::configure($configuration->get('logger'));
$log = Logger::getLogger('default');

$input_directory_locations = [];
$output_directory_locations = [];

$locations =  $configuration->get('locations');
$inputs = $locations['input'];

$log->info('Создаю входные конечные точки');
foreach ($inputs as $name=>$path){
    $input_directory_locations[$name] = new InputDirectoryLocation($name,$path);
}

$outputs = $locations['output'];

$log->info('Создаю выходные конечные точки');
foreach ($outputs as $name=>$value){
    $path = $value['path'];
    $sync = $value['sync'];
    $output_directory_locations[$name]=new OutputDirectoryLocation($name,$path);
    foreach ($sync as $input_location_name){
        if(isset($input_directory_locations[$input_location_name])) {
            $output_directory_locations[$name]->addConnectedInputLocation($input_directory_locations[$input_location_name]);
        }else{
            echo 'Связанная с выходной конечной точкой '.$input_location_name.' входная конечная точка '.$input_location_name.' не найдена!'.PHP_EOL;
        }
    }
}

$sync = new Synchronizer();
$log->info('Синхронизирую');
$sync->syncAll($output_directory_locations);

