<?php


class form{

public $action;
public $title;
public $ElementsArray= array();
public function addElement($id,$value,$type,$lable){
$myElement=new element($id,$value,$type,$lable);
array_push($this->ElementsArray,$myElement);
//print_r($this->ElementsArray);
}
public function RenderForm(){
  $output="";
  foreach ($this->ElementsArray as $element) {
  $output.=$element->echoElement();
  }
return $output;
}

}
class element{

public $id;
public $value;
public $type;
public $lable;
function __construct($id,$value,$type,$lable){
  $this->id=$id;
  $this->type=$type;
  $this->value=$value;
  $this->lable=$lable;
}
public function echoElement(){
$output="";
$output.='<div class="form-group">
    <label for="'.$this->id.'"> '.$this->lable.' </label>
    <input type="'.$this->type.'" class="form-control" id="'.  $this->id.'"
    value="'.  $this->value .'" >
  </div>';
return   $output;
}

}


?>
