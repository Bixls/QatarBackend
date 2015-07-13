<?php


class form{
public $action;
public $title;
public $ElementsArray= array();

function __construct($action,$title){
  $this->action=$action;
  $this->title=$title;
}

public function addElement($id,$value,$type,$lable){
$myElement=new element($id,$value,$type,$lable);
array_push($this->ElementsArray,$myElement);
//print_r($this->ElementsArray);
}
public function addImage($id,$type,$lable){
$myElement=new image($id,$type,$lable);
array_push($this->ElementsArray,$myElement);
//print_r($this->ElementsArray);
}
public function RenderForm(){
  $output="<form id=\"mForm\"  method=\"post\" enctype=\"multipart/form-data\">";
  foreach ($this->ElementsArray as $element) {
  $output.=$element->echoElement();
  }
  $output.="<button type=\"submit\" id=\"Sbutton\" class=\"btn btn-default\">Submit</button>";
  $output.='
  <h4 id="loading"></h4>
  <div id="msg"></div>
  </form>
  ';
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
$output.='<div class="form-group">';
if($this->type!="hidden"){ $output.='<label for="'.$this->id.'"> '.$this->lable.' </label>';}
$output.='<input type="'.$this->type.'" class="form-control" id="'.  $this->id.'" name="'.  $this->id.'"
    value="'.  $this->value .'" >
  </div>';
return   $output;
}

}


class image{

private $type;
private $lable;
private $id;
  function __construct($id,$type,$lable){
    $this->id=$id;
    $this->type=$type;
    $this->lable=$lable;
  }

  public function echoElement(){
    $output="";
    $output.='<div class="form-group">';
    $output.='<label for="'.$this->id.'"> '.$this->lable.' </label>';
    $output.='
    <input type="file" name="fileToUpload" class="form-control "accept="image/*"  id="file" required />
    <input type="hidden" name="type" id="type" value='.$this->type.' required />
    </div>';
    return $output;

  }
}

?>
