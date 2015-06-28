<?php
//***************** member Functions *****************/
function Register($inputs,$key)
{
include("members.php");
$newMember=new member;
$newMember->CreateNew( $inputs[0]);
}

function signIn($inputs,$key)
{
include("members.php");
$newMember=new member;
$newMember->signIn($inputs[0]);
}

function Verify($inputs,$key)
{
include("members.php");
$newMember=new member;
$newMember->Verify($inputs[0],$key);
}
//***************** member Functions *****************/
function getGroupList($inputs,$key)
{
  include("Group.php");
  $groups=new Groups;
  $groups->getGroupList($inputs[0]);
}

?>
