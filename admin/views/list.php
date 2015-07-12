<?

echo "<table class=\"table table-striped\">";
echo "<thead><tr> ";

foreach ($header as $key=>$colum) {
  echo "<td>";
  echo($key);
  echo "</td>";

}
    echo "</tr></thead>";

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

    echo("<a href=\"".$colum.$row[$list[$keyID]]."\"/>".$key." </a>");

  }
      echo "</td>";
  echo "</tr>";
}

echo("</table>");







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
