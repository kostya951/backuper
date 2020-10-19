<?php


namespace kostya\backuper;


class Synchronizer
{
    private $log;

    public function __construct()
    {
        $this->log = \Logger::getLogger('default');
    }

    public function sync($outputLocation){
        $this->log->info('Синхронизирую '.$outputLocation->getName());
        $outputFileList = $outputLocation->getFileList();
        if($outputFileList=='false'){
            $this->log->info('Ошибка сканирования директории выходной конечной точки '.$outputFileList->getName());
            return;
        }
        $connectedInputLocations = $outputLocation->getConnectedInputLocations();
        $inputFileLists = [];
        foreach ($connectedInputLocations as $name=>$inputLocation){
            $inputFileList = $inputLocation->getFileList();
            if($inputFileList=='false'){
                $this->log->info('Ошибка сканирования директории входной конечной точки '.$name);
                continue;
            }
            $inputFileLists[$name] = $inputFileList;
        }

        $differences = [];
        foreach ($inputFileLists as $name=>$inputFileList){
            $difference = array_diff($outputFileList,$inputFileList);
            if(!empty($difference)){
                $this->log->info('Обнаружены различия с входной точкой '.$name);
                $this->log->info(print_r($difference));
                echo PHP_EOL;
                $differences[$name][]=$difference;
            }
        }

        foreach ($differences as $name=>$value){
            foreach ($value as $difference) {
                $inputLocation = $connectedInputLocations[$name];
                foreach ($difference as $file) {
                    $outputPath = $outputLocation->getPath() . "\\" . $file;
                    $inputPath = $inputLocation->getPath() . "\\" . $file;
                    $outputFileResource = fopen($outputPath,"r");
                    $inputFileResource = fopen($inputPath,"w");
                    $window = defined(WINDOW_SIZE)?WINDOW_SIZE:1024;
                    $size = 0;
                    while(!feof($outputFileResource)){
                        $content = fread($outputFileResource,$window);
                        fwrite($inputFileResource,$content);
                        $size+=$window;
                    }
                    fclose($outputFileResource);
                    fclose($inputFileResource);
                    $this->log->info('Перекопировано из '.$outputPath.' в '.$inputPath.' не менее '.$size.' байт!');
                }
            }
        }
    }

    public function syncAll($outputLocations){
        foreach ($outputLocations as $name=>$location){
            $this->sync($location);
        }
    }
}