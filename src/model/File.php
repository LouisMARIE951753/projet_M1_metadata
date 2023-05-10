<?php

class File{

    private $filename;

    public function __construct($filename){

        $this->filename = $filename;

    }

    public function getFilename(){
        return $filename;
    }
}