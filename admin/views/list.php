<?
$firstTime=true;
echo ("<div class=\"page-header\">
    <h1>$Page_Title</h1>
  </div>");
  if(isset($inlineMenu)){
?>
<div class="pageMenu">
  <?
echo $inlineMenu;
  ?>
</div>
<?
}
if(!empty($input)){
    echo "<table class=\"table table-striped\">";
foreach ($input as $row) {

if($firstTime){
  echo "<thead><tr> ";
  foreach ($row as $key=>$value) {
    echo "<td>";
    $myTable->RenderHeader($key);
    echo "</td>";
  }
  echo "</tr></thead>";
  $firstTime=false;
}


  echo '<tr class="RowItem" id="R'.$row[$keyid].'"  >';


  foreach ($row as $key=>$value) {
      echo '<td onclick="goTo(\''.(isset($viewVar)?$viewVar:"View").'\',\'v\','.$row[$keyid].',\''.$table.'\',\'\')"  >';
  $myTable->RenderElement($key,$value);
    echo "</td>";

  }
    echo "<td>";
  foreach (  $myFunctions->functionsArray as $colum) {

      echo('<button class="link btn btn-default"  onclick="goTo(\''.$colum->fn.'\',\''.$colum->short.'\','.$row[$keyid].',\''.$table.'\',\''.(isset($msg)?$msg:'').'\')"   />'.$colum->title.'</button>');

    }
      echo "</td>";
  echo "</tr>";
}

/*
echo("<a class=\"link\" id=".$colum.$row[$list[$keyID]]." href=\"#\"/>".$key." </a>");

 */


}
echo("</table>");


?>

<div style="text-align:center">
<?php

$numberOfPages=(int)ceil($numberOFPosts/$per_page);

if(empty($getArray['page']))
{
  $getArray['page']=1;
}
$currentPage=$getArray['page'];

	echo "<ul class=\"pagination\"> ";
if($currentPage!=1){
  $getArray['page']=$currentPage-1;
  echo " <li><a  href='?".http_build_query($getArray)."'>السابق</a></li> ";
}
$getArray['page']=1;
for($i=1;$i<=$numberOfPages;$i++){
  echo " <li ".($i==$currentPage?'class=\'active\'':'')." ><a href='?".http_build_query($getArray)."'>$i</a></li> ";
  $getArray['page']++;
}
if($currentPage!=$numberOfPages&&$numberOfPages!=0){
    $getArray['page']=$currentPage+1;
  echo " <li><a  href='?".http_build_query($getArray)."'>التالي</a></li> ";
}
  	echo "</ul>";

 ?>
</div>
