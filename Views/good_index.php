<?php

require_once(ROOT_PATH."Controllers/Controller.php");

if(!isset($_SERVER["HTTP_REFERER"])) {
  header("location:login.php");
}
if(!empty($_SESSION["login_user"]) === false) {
  header("location:login.php");
}

$DreamsharingController = new DreamsharingController();
$params = $DreamsharingController->good_index();
$userDate = $DreamsharingController->user_date();

?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/style.css">
    <title>夢の詳細</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  </head>
  <body>
    <?php include('login_header.php');?>
    <div class="container">
      <div class="row text-center good-top mb-4">
        <h4><?= $userDate["userDate"]["name"] ?>さんのいいねした記事一覧</h4>
      </div>
      <div class="row good-content">
        <?php foreach($params["goodIndex"] as $goodIndex):?>
          <div class="col-3 good-item">
            <label>投稿者：<br>『 <a href="mypage.php?id=<?=$goodIndex["user_id"] ?>"><?=htmlspecialchars($goodIndex["name"],ENT_QUOTES,"UTF-8");?></a> 』</label><br>
            <label>タイトル：<br>『 <a href="detail.php?id=<?=$goodIndex["post_id"] ?>"><?=htmlspecialchars($goodIndex["title"],ENT_QUOTES,"UTF-8");?></a> 』</label><br>
          </div>
        <?php endforeach;?>
      </div>
    </div>
    <?php include('footer.php');?>
  </body>
</html>