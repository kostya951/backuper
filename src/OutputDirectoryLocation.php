<?php


namespace kostya\backuper;


class OutputDirectoryLocation extends InputDirectoryLocation
{
    /**
     * @var array  связанные конечные точки
     * с которыми будет синхронизироваться эта точка
     */
    private $_connected_input_locations = [];

    public function __construct($name, $path)
    {
        parent::__construct($name, $path);
    }

    /**
     * @return array список связанных входных точек
     */
    public function getConnectedInputLocations(){
        return $this->_connected_input_locations;
    }

    /**
     * @param InputDirectoryLocation $location конечная точка
     */
    public function addConnectedInputLocation(InputDirectoryLocation $location){
        $this->_connected_input_locations[$location->getName()]=$location;
    }

    /**
     * @param $locations array конечные точки
     */
    public function setConnectedInputLocation($locations){
        $this->_connected_input_locations=$locations;
    }

}