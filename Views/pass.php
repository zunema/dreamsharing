<?php

require_once(ROOT_PATH."Controllers/Controller.php");

$DreamsharingController = new DreamsharingController();
$params = $DreamsharingController->pass_control();

$post = $_POST;

?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/style.css">
    <title>パスワード再設定</title>
  </head>
  <body>
    <?php include('header.php');?>
    <div class="container">
      <div class="row pass-top">
        <div class="col-md-4 offset-md-4 login">

          <h4 class="mb-3 text-center">パスワードの再設定</h4>
          <form action="pass.php" method="POST">

            <?php if(isset($params["err"]["match"]) && $params["err"]["match"] === "no_match"): ?>
              <p class ="err" style="color:red">メールアドレスまたは誕生日が間違っています。</p>
            <?php endif;?>

            <label class="mt-1 mt-4" for="email">メールアドレス：</label>
            <div class="col-mb-3 offset-5 logout-a">
              <input type="email" name="email" id="email" class="form-control mb-4" placeholder="◯◯@◯◯.◯◯" value="<?php if(isset($post["email"])){echo htmlspecialchars($post["email"], ENT_QUOTES, 'UTF-8');} ?>">
              <?php if(isset($params["err"]["email"]) && $params["err"]["email"] === "no_email"): ?>
                <p class ="err" style="color:red">メールアドレスを入力して下さい。</p>
              <?php endif;?>
            </div>
            <label class="mt-1" for="birthday">誕生日：</label>
            <div class="mb-3">
              <input type="date" name="birthday" id="birthday" class="form-control mb-4" value="<?php if(isset($post["birthday"])){echo htmlspecialchars($post["birthday"], ENT_QUOTES, 'UTF-8');} ?>">
              <?php if(isset($params["err"]["birthday"]) && $params["err"]["birthday"] === "no_birthday"): ?>
                <p class ="err" style="color:red">誕生日を入力して下さい。</p>
              <?php endif;?>
            </div>
            <div class="mb-3 text-center">
              <button type="submit" name="pass-reset" class="btn btn-outline-info">送信</button>
            </div>
          </form>
          <div class="mb-3 mt-4 text-center">
            <a href="login.php">ログインページへ</a>
          </div>
          <div class="pass-bottom text-center">
            <a href="signup.php" class="col-12">新規登録はこちら</a>
          </div>
        </div>
      </div>

    </div>
    <?php include('footer.php');?>
  </body>
</html>