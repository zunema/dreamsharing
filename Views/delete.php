<?php

require_once(ROOT_PATH."Controllers/Controller.php");

if(!isset($_SERVER["HTTP_REFERER"])) {
  header("location:login.php");
}
if(!empty($_SESSION["login_user"]) === false) {
  header("location:login.php");
}

$postDelete = new DreamsharingController();
$postDelete->post_delete();


?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/style.css">
    <title>投稿削除</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  </head>
  <body>
    <?php include('login_header.php');?>
    <div class="container">

      <div class="row delete-item text-center">
        <h4>投稿の削除完了です。</h4>
        <div class="col-12 mt-4">
          <a href="index.php">投稿一覧へ</a>
        </div>
      </div>

    </div>
    <?php include('footer.php');?>
  </body>
</html>