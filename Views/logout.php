<?php
require_once(ROOT_PATH."Controllers/Controller.php");

$logout = new DreamsharingController();
$logout->logout();

?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/style.css">
    <title>ログアウト</title>
  </head>
  <body>
    <?php include('header.php');?>
    <div class="container">
      <div class="row logout-item">
        <div class="col-mb-5 offset-md-5 logout-a">
          <h4>ログアウト完了</h4>
        </div>
      </div>
      <div class="row height-bottom">
        <div class="col-mb-3 mt-4 offset-md-5 logout-a">
          <a href="top.php">トップページへ</a>
        </div>
      </div>
    </div>
    <?php include('footer.php');?>
  </body>
</html>