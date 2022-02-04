<?php

require_once(ROOT_PATH."Controllers/Controller.php");

$login = new DreamsharingController();
$params = $login->login_control();

?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/css/style.css">
    <title>ログイン画面</title>
  </head>
  <body>
    <?php include('header.php');?>
    <div class="container">
      <div class="row">
        <div class="col-4 offset-4 login-top">
          <h4 class="mb-3 text-center">ログイン</h4>
          <form action="login.php" method="POST">
            <?php if(isset($params["err"]["email"]) && $params["err"]["email"] === "no_email"): ?>
              <p class ="err" style="color:red">メールアドレスを正しく入力して下さい。</p>
            <?php endif;?>
            <?php if(isset($params["err"]["password"]) && $params["err"]["password"] === "no_password"): ?>
              <p class ="err" style="color:red">パスワードを正しく入力して下さい。</p>
            <?php endif;?>

            <label class="mt-4" for="email">メールアドレス：</label>
            <div class="col-mb-3">
              <input type="email" name="email" id="email" class="form-control mb-4 login-form" placeholder="◯◯@◯◯.◯◯">
            </div>
            <label class="mt-1" for="password">パスワード：</label>
            <div class="mb-3">
              <input type="password" name="password" id="password" class="form-control mb-4 login-form" placeholder="＊＊＊＊＊＊＊＊">
            </div>
            <div class="mt-3 mb-3 text-center">
              <button type="submit" name="login_user" class="btn btn-outline-info">ログイン</button>
            </div>
          </form>
          <div class="mb-3 text-center login-item">
            <a href="pass.php" class="col-12">パスワードを忘れた方</a>
          </div>
          <div class="mb-5 text-center">
            <a href="signup.php" class="col-12">新規登録はこちら</a>
          </div>
        </div>
      </div>
    </div>
    <?php include('footer.php');?>

  </body>
</html>