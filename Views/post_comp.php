<?php

require_once(ROOT_PATH . "Controllers/Controller.php");

if (!isset($_SERVER["HTTP_REFERER"])) {
  header("location:login.php");
}
if (!isset($_SESSION["input"])) {
  header("location:index.php");
}
if(!empty($_SESSION["login_user"]) === false) {
  header("location:login.php");
}

$post = new DreamsharingController();
$post->post_insert_control($_SESSION["input"]);

unset($_SESSION["input"]);

$params = $_SESSION['login_user'];

?>


<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" href="/css/style.css">
  <title>投稿完了</title>
</head>

<body>
<?php include('login_header.php');?>
  <div class="container">

    <div class="row text-center post-comp">
      <div class="col-12">
        <h4>新規投稿しました。</h4><br>
        <a href="mypage.php?id=<?= $params["id"] ?>">マイページへ</a><br>
        <a href="index.php">投稿一覧へ</a>
      </div>
    </div>

  </div>
  <?php include('footer.php');?>

</body>

</html>