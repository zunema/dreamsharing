<?php

require_once(ROOT_PATH."Controllers/Controller.php");
$DreamsharingController = new DreamsharingController();
$params = $DreamsharingController->pass_update_control();

if(!isset($_SERVER["HTTP_REFERER"])) {
  header("location:pass.php");
}

$post = $_POST;
$userDate = $_SESSION["user_mail_birthday"];

?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/style.css">
    <title>パスワード更新</title>
  </head>
  <body>
    <?php include('header.php');?>
    <div class="container">
      <div class="row pass-up-top">
        <div class="col-md-4 offset-md-4 login">
          <h4 class="mb-3 text-center">パスワードの更新</h4>
          <form action="pass_update.php" method="POST">
            <input type="hidden" name="id" value="<?= htmlspecialchars($userDate["id"] ?? ""); ?>"><br>

            <label class="mt-1" for="password">パスワード：</label>
            <?php if(isset($params["err"]["password"]) && $params["err"]["password"] === "no_pass"): ?>
            <p class="err" style="color:red">パスワードは英数字8文字以上100文字以下で入力してください。</p>
            <?php endif;?>
            <input type="password" name="password" id="password" class="form-control mb-4" placeholder="＊＊＊＊＊＊＊＊">

            <label class="mt-1" for="password_conf">パスワード確認：</label>
            <?php if(isset($params["err"]["password_conf"]) && $params["err"]["password_conf"] === "no_pass_conf"): ?>
            <p class="err" style="color:red">確認用パスワードが異なっています。</p>
            <?php endif;?>
            <input type="password" name="password_conf" id="password" class="form-control mb-4" placeholder="＊＊＊＊＊＊＊＊">
            <div class="text-center">
              <button type="submit" name="pass-reset" class="btn btn-outline-info">送信</button>
            </div>
          </form>
          <div class="mb-3 mt-4 text-center">
            <a href="login.php" class="col-12">ログインページへ</a>
          </div>
          <div class="mb-3 pass-up-bottom text-center">
            <a href="signup.php" class="col-12">新規登録はこちら</a>
          </div>
        </div>
      </div>
    </div>
    <?php include('footer.php');?>
  </body>
</html>