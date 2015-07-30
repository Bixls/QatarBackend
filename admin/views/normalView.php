<?php


class NormalView{
public $action;
public $title;
public $ElementsArray= array();


public function addElement($value,$type,$lable){
$myElement=new element($value,$type,$lable);
array_push($this->ElementsArray,$myElement);
//print_r($this->ElementsArray);
}
public function addImage($id,$type,$lable){
$myElement=new image($id,$type,$lable);
array_push($this->ElementsArray,$myElement);
//print_r($this->ElementsArray);
}
public function RenderForm(){
  $output="";
  foreach ($this->ElementsArray as $element) {
  $output.=$element->echoElement();
  }
  $output.='
  <h4 id="loading"></h4>
  <div id="msg"></div>
  ';
return $output;
}

}
class element{
public $id;
public $value;
public $type;
public $lable;
function __construct($value,$type,$lable){
  $this->type=$type;
  $this->value=$value;
  $this->lable=$lable;
}
public function echoElement(){

$output="";
$output.='<p>';
$output.='<b> '.$this->lable.' </b>';
$output.=''.  $this->value .'</p>';
return   $output;
}

}


?>
