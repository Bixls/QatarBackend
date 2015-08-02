<?
$firstTime=true;
echo ("<div class=\"page-header\">
    <h1>$Page_Title</h1>
  </div>");

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
      echo '<td onclick="goTo(\'View\',\'v\','.$row[$keyid].',\''.$table.'\',\'\')"  >';
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
<script type="text/javascript">

function goTo(fun,f,ids,cl,msg){
  var r=true;
  if(f=="d")
  {
    r = confirm(msg);
  }
  if(r){
    $.post("direct.php",
    {
      i:ids,
      fn: fun,
      c:cl
    },
    function(data,status){
      $('#loading').hide();
      $("#myModal").modal("hide");
      $('#messeges').html(data);
    });
  }
}

</script>

<div style="text-align:left">
<?php
//////////////////////////////////////////////////////// Pagging //////////////////////////////////////////
        	echo "<ul class=\"pagination\"> ";
          if(empty($getArray['page'])||$getArray['page']=='1')
          {
              $getArray['page']=2;
        if(!empty($input)){	echo " <li><a  href='?".http_build_query($getArray)."'>التالي</a></li> ";}
          }else{
          $getArray['page']--;
        echo " <li><a  href='?".http_build_query($getArray)."'>السابق</a></li> ";
          $getArray['page']+=2;
        if(!empty($input)){		echo " <li><a  href='?".http_build_query($getArray)."'>التالي</a></li> ";}
        }
        	echo "</ul>";
 ?>
</div>
