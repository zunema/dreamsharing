<?php

require_once(ROOT_PATH."Controllers/Controller.php");

if(!isset($_SERVER["HTTP_REFERER"])) {
  header("location:signup.php");
}

$signup = new DreamsharingController();
$signup->url_check();
$signup->insert_control();

?>


<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/style.css">
    <title>ユーザ登録完了</title>
  </head>
  <body>
    <?php include('header.php');?>

    <div class="container">

      <div class="row register-item text-center">
        <div class="col-4 offset-4 mt-3">
          <h5>ユーザ登録完了しました。</h5> <br>
          <a href="./login.php">ログインページへ</a>
        </div>
      </div>

    </div>
    <?php include('footer.php');?>

  </body>
</html>