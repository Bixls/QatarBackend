<?php
//***************** member Functions *****************/
function Register($inputs)
{
include("members.php");
$newMember=new member;
$newMember->CreateNew( $inputs[0]);
}

function signIn($inputs)
{
include("members.php");
$newMember=new member;
$newMember->signIn($inputs[0]);
}

function Verify($inputs)
{
include("members.php");
$newMember=new member;
$newMember->Verify($inputs[0]);
}
//***************** member Functions *****************/
function getGroupList($inputs)
{
  include("Group.php");
  $groups=new Groups;
  $groups->getGroupList($inputs[0]);
}

?>