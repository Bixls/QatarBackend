<?php

function getStartPage($getArray,$per_page){
  if(empty($getArray['page'])||$getArray['page']=='0')
  {
return 0;
  }else{
  $start=($getArray['page']-1)*$per_page;
}
  return $start;
}


 ?>
