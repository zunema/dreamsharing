<?php

require_once(ROOT_PATH."Controllers/Controller.php");

$signup = new DreamsharingController();
$params = $signup->signup_control();

$post = $_POST;

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
    integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" href="/css/style.css">
  <title>新規登録</title>
</head>

<body>
  <?php include('header.php');?>

  <div class="container pt-5 pb-4">

    <div class="row">
      <div class="col-12 text-center">
      <h4>新規登録フォーム</h4>
      </div>
    </div>

    <form action="signup.php" method="POST" enctype="multipart/form-data">

      <div class="row">
        <div class="col-7 offset-3 mt-4">
          <table>
            <tr>
              <th><label>プロフィール画像：</label></th>
              <td><input type="hidden" name="MAX_FILE_SIZE" value="1048576" /><input name="image" id="selectImage" type="file" accept="image/*" />
              <script>
              var elm = document.getElementById("selectImage");
              elm.onchange = function(evt){
                var selectFiles = evt.target.files;
                if(selectFiles.length != 0) {
                  var fr = new FileReader();
                  fr.readAsDataURL(selectFiles[0]);
                  fr.onload = function(evt) {
                    document.getElementById('boxImage').innerHTML = '<img src="' + fr.result + '" alt="" style="min-width:250px;min-height:250px;max-width:250px;max-height:250px;border:1px solid #666;">'; //readAsDataURLで得た結果を、srcに入れたimg要素を生成して挿入
                  }
                }
              }
              </script>
              </td>
            </tr>
          </table>
        </div>
      </div>

      <div class="row">
        <div class="col-2 offset-4 mt-3" id='boxImage'></div>
      </div>

      <div class="row mt-2">
        <div class="col-9 offset-3 mt-3">
          <table>
            <tr>
              <th><label>名前　　　　　　：</label></th><td><input type="text" name="name" id="name" class="form-control" placeholder="名前" value="<?php if(isset($post['name'])){echo htmlspecialchars($post['name']);}?>"></td>
            </tr>
          </table>
          <?php if(isset($params["err"]["name"]) && $params["err"]["name"] === "blank"): ?>
            <p class="err" style="color:red">名前を入力して下さい。</p>
          <?php endif;?>
        </div>
      </div>

      <div class="row">
        <div class="col-9 offset-3 mt-3">
          <table>
            <tr>
              <th><label>メールアドレス　：</label></th><td><input type="email" name="email" id="email" class="form-control" placeholder="◯◯@◯◯.◯◯" value="<?php if(isset($post['email'])){echo htmlspecialchars($post['email']);}?>"></td>
            </tr>
          </table>
          <?php if(isset($params["err"]["email"]) && $params["err"]["email"] === "blank"): ?>
            <p class="err" style="color:red">メールアドレスを入力して下さい。</p>
          <?php endif;?>
        </div>
      </div>

      <div class="row">
        <div class="col-9 offset-3 mt-3">
          <table>
            <tr>
              <th><label>誕生日　　　　　：</label></th><td><input type="date" name="birthday" id="birthday" class="form-control" value="<?php if(isset($post['birthday'])){echo htmlspecialchars($post['birthday']);}?>"></td>
            </tr>
          </table>
          <?php if(isset($params["err"]["birthday"]) && $params["err"]["birthday"] === "blank"): ?>
            <p class="err" style="color:red">誕生日を入力して下さい。</p>
          <?php endif;?>
        </div>
      </div>

      <div class="row">
        <div class="col-9 offset-3 mt-3">
          <table>
            <tr>
              <th><label>パスワード　　　：</label></th><td><input type="password" name="password" id="password" class="form-control mb-2" placeholder="＊＊＊＊＊＊＊＊"></td>
            </tr>
          </table>
          <?php if(isset($params["err"]["password"]) && $params["err"]["password"] === "no_pass"): ?>
            <p class="err" style="color:red">パスワードは英数字8文字以上100文字以下で入力してください。</p>
          <?php endif;?>
        </div>
      </div>

      <div class="row">
        <div class="col-9 offset-3 mt-3">
          <table>
            <tr>
              <th><label>パスワード確認　：</label></th><td><input type="password" name="password_conf" id="password" class="form-control mb-2" placeholder="＊＊＊＊＊＊＊＊"></td>
            </tr>
          </table>
          <?php if(isset($params["err"]["password_conf"]) && $params["err"]["password_conf"] === "no_pass_conf"): ?>
            <p class="err" style="color:red">確認用パスワードが異なっています。</p>
          <?php endif;?>
        </div>
      </div>

      <div class="row text-center">
        <div class="col-12 signup-submit">
          <button type="submit" name="confirm" class="btn btn-outline-info">新規登録</button>

        </div>
      </div>
    </form>

    <div class="row">
      <div class="col-12 signup-submit text-center">
        <a href="./login.php" class="col-12">登録済みの方はこちら</a>
      </div>
    </div>

  </div>
  <?php include('footer.php');?>

</body>

</html>