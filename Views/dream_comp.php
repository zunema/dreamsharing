<?php

require_once(ROOT_PATH."Controllers/Controller.php");

if(!isset($_SERVER["HTTP_REFERER"])) {
  header("location:login.php");
}
if(!empty($_SESSION["login_user"]) === false) {
  header("location:login.php");
}

$dreamUp = new DreamsharingController();
$dreamUp->dream_update();

$params = $_SESSION['form'];

?>


<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/style.css">
    <title>投稿編集完了</title>
  </head>
  <body>
  <?php include('login_header.php');?>
    <div class="container">

      <div class="row">
        <div class="col12 dream-comp text-center">
          <h4 mb-3>投稿編集完了しました。</h4>
        <a href="detail.php?id=<?=$params["id"] ?>" class="col-12">戻る</a>
      </div>
    </div>

    </div>
    <?php include('footer.php');?>

  </body>
</html>