<?php
require_once(ROOT_PATH."Controllers/Controller.php");

define("DELETE", 0);
define("INSERT", 1);

$status = "";

$user_id = $_POST["userId"];
$post_id = $_POST["postId"];

$DreamsharingController = new DreamsharingController();
$isLiked = $DreamsharingController->check_like_duplicate($user_id,$post_id);

if($isLiked){
  $DreamsharingController->delete_like($user_id,$post_id);
  $status = DELETE;
}else{
  $DreamsharingController->insert_like($user_id,$post_id);
  $status = INSERT;
}
echo json_encode($status);
