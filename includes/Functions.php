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
function changeAvatar($inputs)
{
  include("members.php");
  $newMember=new member;
  $newMember->changeAvatar($inputs[0]->id,$inputs[0]->src);
}
function editProfile($inputs)
{
  include("members.php");
  $newMember=new member;
  $newMember->editProfile($inputs[0]);
}
function getUserbyID($inputs)
{
  include("members.php");
  $newMember=new member;
  $newMember->getUserbyID($inputs[0]);
}
function getUsersbyGroup($inputs)
{
  include("members.php");
  $newMember=new member;
  $newMember->getUsersbyGroup($inputs[0]);
}
function searchUsers($inputs)
{
  include("members.php");
  $newMember=new member;
  $newMember->searchUsers($inputs[0]);
}
 function addInvPoints($inputs){
  include("members.php");
  $newMember=new member;
  $newMember->addInvPoints($inputs[0]);
}
function getUserInvNumber($inputs){
 include("members.php");
 $newMember=new member;
 $newMember->getUserInvNumber($inputs[0]);
}
//***************** member Functions *****************/
function getGroupList($inputs)
{
  include("Group.php");
  $groups=new Groups;
  $groups->getGroupList($inputs[0]);
}
//*************** invitations ************************/
function getInvitationList($inputs)
{
  include("invitations.php");
  $invitationPackage=new invitationPackages;
  $invitationPackage->getInvitationList($inputs[0]);
}



function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}



?>
