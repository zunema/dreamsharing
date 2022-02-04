<?php

require_once(ROOT_PATH."Controllers/Controller.php");

?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/style.css">
    <title>トップページ</title>
  </head>
  <body>
    <?php include('header.php');?>

    <div class="container">

      <div class="row top-bottom">
        <div class="col-12 text-center top">
          <h4>dreamsharing</h4>
          <p>〜 みんなの夢を繋げよう 〜</p>
        </div>
        <div class="col-12 text-center top-item">
          <a href="login.php" class="col-12">ログインはこちら</a>
        </div>
        <div class="col-12 text-center top-item">
          <a href="signup.php" class="col-12">新規登録はこちら</a>
        </div>
      </div>

    </div>
    <?php include('footer.php');?>
  </body>
</html>