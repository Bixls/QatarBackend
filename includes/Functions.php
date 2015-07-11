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

//***************** commments Functions *****************/
function addComment($inputs)
{
  include("comments.php");
  $comments=new comments;
  $comments->addComment($inputs[0]);
}
function RemoveComment($inputs)
{
  include("comments.php");
  $comments=new comments;
  $comments->RemoveComment($inputs[0]);
}
function retriveComments($inputs)
{
  include("comments.php");
  $comments=new comments;
  $comments->retriveComments($inputs[0]);
}
//***************** Group Functions *****************/
function getGroupList($inputs)
{
  include("Group.php");
  $groups=new Groups;
  $groups->getGroupList($inputs[0]);
}
//***************** EventCategories *****************/
function getEventCategories($inputs)
{
  include("EventCategories.php");
  $eventCategories=new EventCategories;
  $eventCategories->getEventCategories($inputs[0]);
}
//*************** invitations ************************/
function getInvitationList($inputs)
{
  include("invitations.php");
  $invitationPackage=new invitationPackages;
  $invitationPackage->getInvitationList($inputs[0]);
}
//*************** Events ************************/

function getEventbyID($inputs)
{
  include("Events.php");
  $event=new Events;
  $event->getEventbyID($inputs[0]);
}
function CreateEvent($inputs)
{
  include("Events.php");
  $event=new Events;
  $event->CreateEvent($inputs[0]);
}
function getUserEventsList($inputs)
{
  include("Events.php");
  $event=new Events;
  $event->getUserEventsList($inputs[0]);
}
function getEvents($inputs)
{
  include("Events.php");
  $event=new Events;
  $event->getEvents($inputs[0]);
}
function getGroupEvents($inputs)
{
  include("Events.php");
  $event=new Events;
  $event->getGroupEvents($inputs[0]);
}
function editEvent($inputs)
{
  include("Events.php");
  $event=new Events;
  $event->editEvent($inputs[0]);
}
//********************8 event invitations and Attendees ***************/
function invite($inputs)
{
  include("invitationsLog.php");
  $invitationsLog=new invitationsLog;
  $invitationsLog->invite($inputs[0]);
}
function JoinEvent($inputs)
{
  include("invitationsLog.php");
  $invitationsLog=new invitationsLog;
  $invitationsLog->JoinEvent($inputs[0]);
}

function isInvited($inputs)
{
  include("invitationsLog.php");
  $invitationsLog=new invitationsLog;
  $invitationsLog->isInvited($inputs[0]);
}


function isJoind($inputs)
{
  include("invitationsLog.php");
  $invitationsLog=new invitationsLog;
  $invitationsLog->isJoind($inputs[0]);
}

function LeaveEvent($inputs)
{
  include("invitationsLog.php");
  $invitationsLog=new invitationsLog;
  $invitationsLog->LeaveEvent($inputs[0]);
}

function ViewEventAttendees($inputs)
{
  include("invitationsLog.php");
  $invitationsLog=new invitationsLog;
  $invitationsLog->ViewEventAttendees($inputs[0]);
}
//**************** news **********************/
function GetNewsList($inputs)
{
  include("News.php");
  $news=new News;
  $news->GetNewsList($inputs[0]);
}
function GetFullNews($inputs)
{
  include("News.php");
  $news=new News;
  $news->GetFullNews($inputs[0]);
}
//**************** Messages ***********************/
function sendMessege($inputs)
{
  include("Messages.php");
  $messege=new Messages;
  $messege->sendMessege($inputs[0]);
}
function RetriveInbox($inputs)
{
  include("Messages.php");
  $messege=new Messages;
  $messege->RetriveInbox($inputs[0]);
}
function ReadMessege($inputs)
{
  include("Messages.php");
  $messege=new Messages;
  $messege->ReadMessege($inputs[0]);
}
function deleteMessege($inputs)
{
  include("Messages.php");
  $messege=new Messages;
  $messege->deleteMessege($inputs[0]);
}
function unReadInbox($inputs)
{
  include("Messages.php");
  $messege=new Messages;
  $messege->unReadInbox($inputs[0]);
}
//************** Feedbacks *************************
function SendFeedback($inputs){
  include("Feedbacks.php");
  $feedback=new Feedbacks;
  $feedback->SendFeedback($inputs[0]);
}
//************** BlockList *************************
function SetBlockList($inputs){
  include("BlockList.php");
  $BlockList=new BlockList;
  $BlockList->SetBlockList($inputs[0]);
}
function GetUserBlockList($inputs){
  include("BlockList.php");
  $BlockList=new BlockList;
  $BlockList->GetUserBlockList($inputs[0]);
}
//*************** General functions ************************/
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
