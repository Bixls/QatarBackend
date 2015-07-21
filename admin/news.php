<?php

class news{


  public function CreateNew($input){

    $header="Create News";
    include("views/form.php");
    $form=new form("index.php","title");
    $form->addElement('Subject',"","text","News Subject");
    $form->addImage('Image',"group","News image");


    global $db;
    $What="*";
    $innerJoin = "";
    $db->select('groups',"",$limit=false,$order=false,$where_mode="AND",$print_query=false,$What,$innerJoin);

    $result=$db->result_array();
   $groups = array("-1"=>"الرئيسية");
    foreach ($result as $key) {
      //array_push($group,$key["Gname"]);
      $groups[$key["Gid"]]=$key["Gname"];
    }
    $form->addElement('GroupID',$groups,"select","Group");
    $allowComments = array('1' =>"Yes",'0' =>"No"  );
    $form->addElement('AllowComments',$allowComments,"select","Allow comment");
      $form->addElement('Description',"","textarea","News description");
    $form->addElement('i',"0","hidden","");
    $form->addElement('fn',"insert","hidden","");
    $form->addElement('c',"news","hidden","");
    $body=$form->RenderForm();
  //  $body="fields that will create the new group is here";
    include("views/single.php");
  }

  public function insert($id)
  {
    ob_start();
    $NoResponse="NoResponse";
    include(ROOTPATH."/upload.php");
    ob_end_clean();
  if($respond['success']=="true"){

  global $db;
  $db->insert("News", $what = array('GroupID' =>  $_POST['GroupID'],
  'Subject' =>  $_POST['Subject'],
  'AllowComments' =>  $_POST['AllowComments'],
  'Description' =>  $_POST['Description'],
  'Image' => $respond['id']));
  include("functions/generalFunctions.php");
    if(!$db->error){
    messege("alert-success","Sucess","news has been created successfully");
    }else{
    messege("alert-danger","Falied ",implode(" ",$db->errorMessege()));
    }

  }
  }

  public function ViewNewsList(){


    $Page_Title="All news";
    $where=array('1' => 1 );
    $myFunctions =new TableView;
    $myFunctions->addF("View","View","v");
    $myFunctions->addF("Edit","Edit","e");

    global $db;


    $myTable =new TableView;
    $myTable->addE("NewsID","NewsID","`NewsID`");
    $myTable->addE("Subject","Subject","`Subject`");
    $myTable->addE("Description","Description","`Description`");
    $myTable->addElement("Image","Image","`Image`","<img class=\"img-responsive thumbnail\" src='../image.php?id=","&t=150x150' />");
    $keyid="NewsID";
    global  $per_page;


    $what=$myTable->returnArray();
    $table="News";
    $innerJoin="";
    $getArray=$_GET;
    require ("functions/generalFunctions.php");
    $start=getStartPage($getArray,$per_page);
    $db->select($table,$where,$limit=$start.",".$per_page,$order=false,$where_mode="AND",$print_query=false,$what,$innerJoin);
    $input=$db->result_array();
    include("views/list.php");
  }



}

?>
