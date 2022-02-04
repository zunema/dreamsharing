<?php

require_once(ROOT_PATH . "Controllers/Controller.php");

if (!isset($_SERVER["HTTP_REFERER"])) {
  header("location:login.php");
}
$withdrawal = new DreamsharingController();
$withdrawal->withdrawal();

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
    integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" href="/css/style.css">
  <title>退会</title>
</head>

<body>
  <?php include('header.php');?>

  <div class="container">

    <div class="row withdrawal text-center">
      <div class="col-12">
        <h4>退会しました。</h4>
        <p>ご利用頂きありがとうございました。</p>
        <a href="top.php" class="col-12">トップページへ</a>
      </div>

    </div>

  </div>
  <?php include('footer.php');?>

</body>

</html>