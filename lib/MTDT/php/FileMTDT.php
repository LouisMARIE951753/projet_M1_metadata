<?php

include_once("AbstractMTDT.php");

class FileMTDT extends AbstractMTDT{

	public function __construct($filePath = null){

		$this->fileName = basename($filePath);
		$this->filePath = $filePath;
		parent::ackConfigUser();
	}

	public function getJSONMetadata(){

		return parent::getJSONMetadata();

	}

	public function setJSONMetadata($data_json){

		parent::setJSONMetadata($data_json);
		
	}

	public function getIniArray()
	{
		return $this->ini_array;
	}

	public function getJointArray()
	{
		return $this->joint_array;
	}

	public function getAcceptedArray()
	{
		return $this->accepted_array;
	}

	# DISPLAY 

	public function displayMetadata($json)
	{
		return parent::displayMetadata($json);
	}

	public function displayMetadataCheck($json)
	{
		return parent::displayMetadataCheck($json);
	}

}


?>