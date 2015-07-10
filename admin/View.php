<!DOCTYPE html>
<html lang="en">
<head>
 <title><?php   echo $title  ?></title>
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
 <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">

<?php

require_once("../configuration.php");
require('db.php');
$db = new db(DB_DATABASE, DB_USER, DB_PASSWORD, DB_HOST); // $host is optional and defaults to 'localhost'
$show_page=1;

  mysql_query("set names 'utf8'");                    // figure out the total pages in the database

                      $total_results =  $db->select($table,$where,$limit=false,$order=false,$where_mode="AND",$print_query=false,$What="*",$innerJoin)->count();
                      $total_pages = ceil($total_results / $per_page);

                      // check if the 'page' variable is set in the URL (ex: view-paginated.php?page=1)
                      if (isset($_GET['page']) && is_numeric($_GET['page']))
                      {
                        $show_page = $_GET['page'];

                        // make sure the $show_page value is valid
                        if ($show_page > 0 && $show_page <= $total_pages)
                        {
                          $start = ($show_page -1) * $per_page;
                          $end = $start + $per_page;
                        }
                        else
                        {
                          // error - show first set of results
                          $start = 0;
                          $end = $per_page;
                        }
                      }
                      else
                      {
                        // if page isn't set, show first set of results
                        $start = 0;
                        $end = $per_page;
                      }

                      // display pagination
$db->select($table,$where,$limit=$start.",".$per_page,$order=false,$where_mode="AND",$print_query=false,$What="*",$innerJoin);



echo "<table class=\"table table-striped\">";
echo "<thead><tr> ";
foreach ($list as $key=>$colum) {
  echo "<td>";
  echo($key);
  echo "</td>";
}
foreach ($customeFileds as $key=>$colum) {
  echo "<td>";
  echo($key);
  echo "</td>";

}
    echo "</tr></thead>";

foreach ($db->result_array() as $row) {
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
  foreach ($customeFileds as $key=>$colum) {
      echo "<td>";
    echo("<a href=\"".$colum.$row[$list['id']]."\"/>".$key."</a>");
      echo "</td>";
  }
  echo "</tr>";
}







?>




</table>

<?php
        	echo "<ul class=\"pagination\"> ";
        	for ($i = 1; $i <= $total_pages; $i++)
        	{
        		echo " <li class=\"".($show_page==$i?'active':'')."\"><a  href='?page=$i'>$i</a></li> ";
        	}
        	echo "</ul>";
 ?>

</div>
</body>
</html>
