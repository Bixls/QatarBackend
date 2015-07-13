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

function messege($type,$title,$content){

?>
<div style="position:fixed;width:100%">
<div class="container">
<div class="col-md-6"></div>

<div class="col-md-6">

<?php
echo("<div class=\"alert $type fade in\">");
echo  " <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>";
echo "<strong>$title</strong>$content";
echo"</div>";
?>
</div>
</div>
</div>
<?php
}

function SendAdminMessege($type,$title,$content){


}

 ?>
