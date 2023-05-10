<?php

abstract class AbstractMTDT{

	// ATTRIBUTES 

	protected $fileName;
	protected $filePath;
	protected $ini_array;
	protected $joint_array;
	protected $reversed_joint_array;
	protected $accepted_array;
	protected $exiftoolsPath = "lib/MTDT/Image-ExifTool-12.52/exiftool.pl";
	protected $tmpPath = "lib/MTDT/tmp/";

	// FUNCTIONS 

	protected function getJSONMetadata(){ // permet de récupéré les métadonnées d'un fichier en format JSON via exiftools

		$cmd = $this->exiftoolsPath . " -json -g1 " . $this->filePath; // on crée la ligne de commande qui nous permettra d'utiliser exiftools

		exec($cmd,$jsonMTDT); // on récupère le retour de l'execution de la commande

		return implode($jsonMTDT);
	}

	protected function setJSONMetadata($data_json){

		$workedOnFile = $this->tmpPath . $this->fileName;

		var_dump($workedOnFile);
		var_dump($this->fileName);

		copy($this->filePath, $workedOnFile);

		var_dump(glob("*"));

		var_dump(glob("lib/MTDT/tmp/*"));

		$cmd = $this->exiftoolsPath . " -overwrite_original " ;

		foreach ($data_json as $key => $value) {

			$cmd .=$this->MTDTManagement($key,$value);			

		}

		$cmd .= $workedOnFile;

		var_dump($cmd);

		echo($cmd);

		var_dump(glob("lib/MTDT/tmp/*"));

		exec($cmd,$result,$val);

		var_dump($result);
		var_dump($val);

		$cmd = $this->exiftoolsPath . " -overwrite_original " ;

		$cmd .= "-tagsFromFile " . $workedOnFile . " " . $this->filePath;

		var_dump($cmd);

		exec($cmd,$result,$val);

		var_dump($result);
		var_dump($val);

		unlink($workedOnFile);


	}

	private function MTDTManagement($key,$value,$parent = "-",$p = 0){

		$cmd = "";

		if(!is_array($value)){

			$cmd = $parent . $key . "=\"" . $value . "\" ";  

		} else {

			$parentNext = $parent . $key . ":" ;

			foreach ($value as $keyOfValue => $val) {
				
				$cmd .= $this->MTDTManagement($keyOfValue,$val,$parentNext,$p+1);

			}
		}

		return $cmd;
	}

	private function getArrayFromIniArray($var, $makeTuple = false)
	{
		$tmp_array = array();
		if(isset($this->ini_array[$var])){
			$array = $this->ini_array[$var];
			foreach ( $array as $k => $val) { 
				if ($makeTuple){
					$tmp_array[$k] = $val;
				} else {
					array_push($tmp_array,$val);
				}
			}
			return $tmp_array;
		}
		return null;
	}

	protected function ackConfigUser(){
		$this->ini_array = parse_ini_file("lib/MTDT/mtdt_user.ini",false);
		$this->joint_array = $this->getArrayFromIniArray("joint",true);
		$this->reversed_joint_array = array();
		foreach ($this->joint_array as $k => $v){
			$this->reversed_joint_array[$v]= $k;
		}
		$this->accepted_array = $this->getArrayFromIniArray("accepted");
	}

	# CHECK

	protected function displayMetadataCheck($json)
	{
		$count = 0;
		$content = "";
		$incoherent_tags_content ="";
		$alreadySeen = [];

		foreach ($json as $tag => $tagValue) {	
			if(is_array($tagValue)){
				foreach($tagValue as $tV => $p){
					if (!is_array($p)){
						$fullTag = $tag . ":" . $tV;
						if ((in_array($fullTag,array_keys($this->joint_array)) or in_array($fullTag,array_keys($this->reversed_joint_array))) and (!in_array($fullTag,$alreadySeen))){
							$proper_array =  (isset($this->joint_array[$fullTag])?$this->joint_array:$this->reversed_joint_array);
		
							$tagAndProperty = $this->extractTagAndProperty($proper_array[$fullTag]);
							$tag2 = $tagAndProperty[0];
							$property2 = $tagAndProperty[1];
		
							if(strcmp($json[$tag][$tV],$json[$tag2][$property2]) !== 0){
								$count += 1;
								$incoherent_tags_content .= "<p> Incohérence " . $count;
								$incoherent_tags_content .= " :  [" . $tag . ":" . $tV . "]";
								$incoherent_tags_content .= " et ";
								$incoherent_tags_content .= " [" . $tag2 . ":" . $property2 . "]. </p>";
							}

							array_push($alreadySeen,$proper_array[$fullTag]);
							array_push($alreadySeen,$fullTag);
						}
					}
				}
			}
		}

		$content .= "<p> nombre d'incohérence :";
		$content .= $count;
		$content .= "</p>";

		$content .= $incoherent_tags_content;

		return $content;
	}

	private function extractTagAndProperty($fullTag)
	{
		$array = explode(":",$fullTag);
		return $array;
	}



	# DISPLAY

	protected function displayMetadata($json)
	{
		$content = "";
		foreach ($json as $tag => $tagValue) {
			if ( in_array($tag,$this->accepted_array)){
			  $content .= "<p>" . $tag  . " =>  </p>";
	  
			  foreach ($tagValue as $tV => $p) {
				$content .= "<p>" . $tV . " => "; 
				$content .= $this->convertVal($p);
				$content .= " </p>";
			  }
			}
		}

		return $content;
	}

	private function convertVal($val){
		if(is_array($val)){
			$content = "";
			foreach ($val as $key => $value) {
				$content .= "<p> - " . $this->convertVal($value) . "</p>";
			}
			return $content;
		} else {
		  return $val;
		}
	}


}

?>