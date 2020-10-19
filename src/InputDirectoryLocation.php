<?php


namespace kostya\backuper;


class InputDirectoryLocation
{
    /**
     * @var string имя
     */
    private $_name;

    /**
     * @var string путь
     */
    private $_path;

    /**
     * @var array список файл в точке
     */
    private $_file_list = [];

    public function __construct($name,$path)
    {
        $this->_path=$path;
        $this->_name=$name;
    }

    /**
     * @return string
     */
    public function getPath(){
        return $this->_path;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * Получить список файлов  в точке
     * @return array|bool
     */
    public function getFileList(){
        if(empty($this->_file_list)) {
            $files = scandir($this->_path);
            if($files) {
                foreach ($files as $file) {
                    if (is_dir($file)) {
                        continue;
                    }
                    $this->_file_list[] = $file;
                }
            }else{
                return 'false';
            }
        }
        return $this->_file_list;
    }
}