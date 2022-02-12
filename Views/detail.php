<?php

require_once(ROOT_PATH."Controllers/Controller.php");
require_once(ROOT_PATH .'/database.php');
require_once(ROOT_PATH .'Models/Db.php');
require_once(ROOT_PATH."Models/Dream.php");

if(!isset($_SERVER["HTTP_REFERER"])) {
  header("location:login.php");
}
if(!empty($_SESSION["login_user"]) === false) {
  header("location:login.php");
}

$postDate = new DreamsharingController();
$params = $postDate->post_date();

$userDate = $params["postDate"]["user_id"];

if ($params["postDate"] === false) {
  header("location:delete.php?id=$userDate");
}

$user_id = $_SESSION["login_user"]["id"];
$post_id = $params["postDate"]["id"];

$isLiked = $postDate->check_like_duplicate($user_id,$post_id);
$image = $params['postDate']['image'];

?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/style.css">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <title>夢の詳細</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script type="text/javascript" src='/js/good.js'></script>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP&display=swap" rel="stylesheet">
  </head>
  <body>
    <?php include('login_header.php');?>
    <div class="container">

      <div class="row pt-5 detail-title">
        <div class="col-1"></div>
        <div class="col-2 text-center">
          <label>タイトル：</label>
        </div>
        <div class="col-6">『 
          <?=htmlspecialchars($params["postDate"]["title"],ENT_QUOTES,"UTF-8");?> 』の詳細
        </div>
        <div class="col-3">
          <?php if($params["postDate"]["user_id"] === $_SESSION["login_user"]["id"]): ?>
            <a href="dream_edit.php?id=<?=$params["postDate"]["id"] ?>" class="btn btn-outline-info">編集</a>
          <?php endif; ?>
          <?php if($params["postDate"]["user_id"] === $_SESSION["login_user"]["id"]): ?>
            <a href="delete.php?id=<?=$params["postDate"]["id"] ?>" class="btn btn-outline-danger" onclick="return confirm('本当に削除しますか？')">削除</a>
          <?php elseif($_SESSION["login_user"]["role"] === "0" ): ?>
            <a href="delete.php?id=<?=$params["postDate"]["id"] ?>" class="btn btn-outline-danger" onclick="return confirm('本当に削除しますか？')">削除</a>
          <?php endif; ?>
        </div>
      </div>

      <div class="row align-items-center derail-form-top">
        <div class="col-1"></div>
        <div class="col-md-1">
          <?php if(file_exists("./img/$image")): ?>
            <img src="/img/<?= $image ?>" class="detail_img">
          <?php else: ?>
            <img src="/img/noimage.png" class="detail_img">
          <?php endif; ?>
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-2 detail-item text-center">
          <label>ユーザ名：</label>
           <p></p>
          <label>感　　情：</label>
        </div>
        <div class="col-md-3 detail-item">
          <a href="mypage.php?id=<?=$params["postDate"]["user_id"] ?>"><?=htmlspecialchars($params["postDate"]["name"],ENT_QUOTES,"UTF-8");?></a>
           <p></p>
          <?=htmlspecialchars($params["postDate"]["emotion"],ENT_QUOTES,"UTF-8");?>
        </div>
        <div class="col-4 detail-item">
          <label></label>
          <p></p>
          <label>見た日：<?=htmlspecialchars($params["postDate"]["date"],ENT_QUOTES,"UTF-8");?></label>
        </div>
      </div>

      <div class="row">
        <div class="col-3"></div>
        <div class="col-md-2 detail-item text-center">
          <label>内　容　：</label>
        </div>
        <div class="col-md-7">
          『　<?=htmlspecialchars($params["postDate"]["body"],ENT_QUOTES,"UTF-8");?>　』
        </div>
      </div>

      <div class="row pt-3 detail-item detail-bottom text-center">
        <div class="col-3"></div>
        <div class="col-2 like" data-user_id="<?=$user_id?>" data-post_id="<?=$post_id?>">
          <?php if ($isLiked): ?>
            <label>いいね！<i class="fas fa-heart" id="likeItem" style="color: red"></i></label>
          <?php else: ?>
            <label>いいね！<i class="far fa-heart" id="likeItem"></i></label>
          <?php endif; ?>
        </div>
      </div>

    </div>
    <?php include('footer.php');?>
  </body>
</html>