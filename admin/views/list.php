<?

echo "<table class=\"table table-striped\">";
echo "<thead><tr> ";

foreach ($header as $key=>$colum) {
  echo "<td>";
  echo($key);
  echo "</td>";

}
    echo "</tr></thead>";

if(!empty($input)){
foreach ($input as $row) {
  echo "<tr>";
  foreach ($list as $key=>$colum) {
      echo "<td>";

      if($key!="Picture"){
    echo($row[$colum]);
  }else{

    echo("<img height='80px' class=\"img-responsive thumbnail\" src=\"../image.php?id=".$row[$colum]."&t=150x150\">");

  }

      echo "</td>";
  }
    echo "<td>";
  foreach ($customeFileds as $key=>$colum) {

    echo("<a class=\"link\" id=".$colum.$row[$list[$keyID]]." href=\"#\"/>".$key." </a>");

  }
      echo "</td>";
  echo "</tr>";
}
}else{
}

echo("</table>");


?>
<script type="text/javascript">
function getFunctionName(i){
  switch(i) {
  <?php
    foreach ($customeFileds as $key=>$colum) {

      echo("case '$colum':\n");
      echo("return '$key' ;\n");
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
          c:"members"
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
