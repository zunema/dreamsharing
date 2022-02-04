<?php

require_once(ROOT_PATH."Controllers/Controller.php");

$DreamsharingController = new DreamsharingController();
$params = $DreamsharingController->pass_update();

$params = $_SESSION["user_mail_birthday"];

?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <title>パスワード再設定完了</title>
  </head>
  <body>
    <?php include('header.php');?>
    <div class="container pass-comp-top">
      <div class="row">
        <div class="col-mb-3 offset-md-5 logout-a">
          <h4>パスワード再設定完了！</h4>
        </div>
      </div>
      <div class="row pass-comp-bottom">
        <div class="col-mb-3 mt-4 offset-md-5 logout-a">
          <a href="login.php" class="col-12">ログインページへ</a>
        </div>
      </div>
    </div>
    <?php include('footer.php');?>
  </body>
</html>