<?php
require_once(ROOT_PATH."Controllers/Controller.php");
$signup = new DreamsharingController();
$signup->url_check();
if(!isset($_SERVER["HTTP_REFERER"])) {
  header("location:signup.php");
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
    integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" href="/css/style.css">
  <title>登録前確認</title>
</head>

<body>
  <?php include('header.php');?>
  <div class="container">

    <div class="row signup-conf-top">
      <div class="col-12 text-center">
      <h4>ユーザ登録確認</h4>
      </div>
    </div>

    <form action="register.php" method="POST">

      <div class="row signup-item-top signup-conf-item">
        <div class="col-6 offset-4 mt-3">
          <table>
            <tr>
              <th><label>　名　　　前　：</label></th><td class="signup-td"><?php echo htmlspecialchars($_SESSION["form"]["name"])?></td>
            </tr>
          </table>
        </div>
      </div>

      <div class="row signup-conf-item">
        <div class="col-6 offset-4 mt-2">
          <table>
            <tr>
              <th><label>メールアドレス：</label></th><td class="signup-td"><?php echo htmlspecialchars($_SESSION["form"]["email"])?></td>
            </tr>
          </table>
        </div>
      </div>

      <div class="row signup-conf-item">
        <div class="col-6 offset-4 mt-2">
          <table>
            <tr>
              <th><label>　誕　生　日　：</label></th><td class="signup-td"><?php echo htmlspecialchars($_SESSION["form"]["birthday"])?></td>
            </tr>
          </table>
        </div>
      </div>

      <div class="row signup-conf-bottom text-center">
        <div class="col-2 signup-submit">
          <input type="submit" name="register" class="btn btn-outline-info" value="新規登録">
        </div>
      </div>

    </form>

  </div>
  <?php include('footer.php');?>

</body>

</html>