<?php

class TableView{

  public $TableItems= array();
  public $functionsArray= array();
  public $key;
  public function addElement($head,$dbID,$DB_Name,$extraHtmlBefore,$extraHtmlAfter){
  $myElement=new TableItem($DB_Name,$head,$extraHtmlBefore,$extraHtmlAfter);
  $this->TableItems[$dbID]=$myElement;
  }

public function returnArray(){
  $what="";
  $last_key = end(array_keys($this->TableItems));
  foreach ($this->TableItems as $key => $value) {
    $what.=$value->DB_Name.($key!=$last_key?",":"");
  }
  return $what;
}
  public function addE($head,$dbID,$DB_Name){
  $myElement=new TableItem($DB_Name,$head,"","");
  $this->TableItems[$dbID]=$myElement;
  }


  public function addF($title,$fn,$short){
  $myElement=new functionItem($title,$fn,$short,"","");
  array_push($this->functionsArray,$myElement);
  }

  public function RenderElement($dbID,$value){
    if(array_key_exists($dbID,$this->TableItems)){
  echo($this->TableItems[$dbID]->renderMe($value));
  }
  }

  public function RenderHeader($dbID){
    if(array_key_exists($dbID,$this->TableItems)){
      echo($this->TableItems[$dbID]->head);
    }
  }

}

class TableItem{

public $DB_Name;
public $head;
public $extraHtmlBefore;
public $extraHtmlAfter;

function __construct($DB_Name,$head,$extraHtmlBefore,$extraHtmlAfter){
$this->DB_Name=$DB_Name;
$this->head=$head;
$this->extraHtmlBefore=$extraHtmlBefore;
$this->extraHtmlAfter=$extraHtmlAfter;
}

public function renderMe($value){
return $this->extraHtmlBefore.$value.$this->extraHtmlAfter;
}

}
class functionItem{
public $title;
public $fn;
public $short;
public $extraHtmlBefore;
public $extraHtmlAfter;

function __construct($title,$fn,$short,$extraHtmlBefore,$extraHtmlAfter){
$this->title=$title;
$this->short=$short;
$this->fn=$fn;
$this->extraHtmlBefore=$extraHtmlBefore;
$this->extraHtmlAfter=$extraHtmlAfter;
}


}












?>
