<?php



require_once("includes/Events.php");

$m = new stdClass();
//
$m->Eventid = 7;

$e =new Events;

if($e->approveEventByID($m)){
echo "sucess"  ;
}





 ?>
