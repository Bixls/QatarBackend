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


  echo "<tr>";


  foreach ($row as $key=>$value) {
      echo "<td>";
  $myTable->RenderElement($key,$value);
    echo "</td>";

  }
    echo "<td>";
  foreach (  $myFunctions->functionsArray as $colum) {

      echo("<a class=\"link\" id=".($colum->short).$row[$keyid]." href=\"#\"/>".$colum->title." </a>");

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
function getFunctionName(i){
  switch(i) {
  <?php
    foreach ( $myFunctions->functionsArray as $colum) {

      echo("case '$colum->short':\n");
      echo("return '$colum->fn' ;\n");
      echo("break;\n");
    }
  ?>
  }
}

$(document).ready(function(){
    $(".link").click(function(event){
        $.post("direct.php",
        {
          i:event.target.id.substring(1),
          fn: getFunctionName(event.target.id.substring(0, 1)),
          c:"<?php echo $table ?>"
        },
        function(data,status){
          $('#messeges').html(data);
        });
    });
});
</script>



<?php





//////////////////////////////////////////////////////// Pagging //////////////////////////////////////////
        	echo "<ul class=\"pagination\"> ";
          if(empty($getArray['page'])||$getArray['page']=='1')
          {
              $getArray['page']=2;
        if(!empty($input)){	echo " <li><a  href='?".http_build_query($getArray)."'>next</a></li> ";}
          }else{
          $getArray['page']--;
        echo " <li><a  href='?".http_build_query($getArray)."'>prev</a></li> ";
          $getArray['page']+=2;
        if(!empty($input)){		echo " <li><a  href='?".http_build_query($getArray)."'>next</a></li> ";}
        }
        	echo "</ul>";
 ?>
