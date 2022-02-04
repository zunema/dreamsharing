<?php
require_once(ROOT_PATH .'/database.php');
require_once(ROOT_PATH .'Models/Db.php');

class User extends Db {

  public function __construct($dbh = null) {
    parent::__construct($dbh);
  }

  // 新規登録
  /**
   * ユーザーを登録する
   * @param array $userDate
   * @return bool $result
   */
  public function signup_insert($userData) {
    $result = false;
    $sql = 'INSERT INTO users (name, email, birthday, password, image) VALUES (:name, :email, :birthday, :password, :image)';
    $sth = $this->dbh->prepare($sql);
    $pass_hash = password_hash($userData['password'], PASSWORD_DEFAULT);

    $sth->bindParam(':name', $userData['name'], PDO::PARAM_STR);
    $sth->bindParam(':email', $userData['email'], PDO::PARAM_STR);
    $sth->bindParam(':birthday', $userData['birthday'], PDO::PARAM_STR);
    $sth->bindParam(':password', $pass_hash, PDO::PARAM_STR);
    $sth->bindParam(':image', $userData['image'], PDO::PARAM_STR);

    try {
        $result = $sth->execute();
        return $result;
    } catch (PDOException $e) {
        return $result;
    }
  }

  // ログイン
  /**
   * emailからユーザーを取得
   * @param string $email
   * @return array|bool $user|false
   */
  public function login_get($email)
  {
    $sql = ' SELECT * FROM users WHERE email = :email ';
    $sth = $this->dbh->prepare($sql);
    $sth->bindParam(':email', $email, PDO::PARAM_STR);
    try {
        $sth->execute();
        $user = $sth->fetch();
        return $user;
    } catch (\Exception $e) {
        return false;
    }
  }

  /**
   * usersテーブルからすべてデータを取得
   * @param integer $user
   * @return Array $result 全ユーザデータ
   */
  public function userAll($id)
  {
    $sql = ' SELECT * FROM users WHERE id = :id ';
    $sth = $this->dbh->prepare($sql);
    $sth->bindValue(':id', (int)$id, PDO::PARAM_INT);
    $sth->execute();
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

  //ユーザID取得
  /**
   * usersテーブルからデータを取得
   * @param integer $user
   * @return Array $result ユーザデータ
   */
  public function userId($id) {

    $sql = ' SELECT u.id, u.name, u.email, u.image, u.role FROM users u WHERE id = :id ';
    $sth = $this->dbh->prepare($sql);
    $sth->bindValue(':id', (int)$id, PDO::PARAM_INT);
    $sth->execute();
    $result = $sth->fetch(PDO::FETCH_ASSOC);
    return $result;
  }

  // ユーザー情報アップデート
  public function update($userData)
  {
    $sql = 'UPDATE users SET name = :name, email = :email, image = :image WHERE id = :id';
    $sth = $this->dbh->prepare($sql);
    $sth->bindValue(':name', $userData['name'], PDO::PARAM_STR);
    $sth->bindValue(':email', $userData['email'], PDO::PARAM_STR);
    $sth->bindValue(':image', $userData['image'], PDO::PARAM_STR);
    $sth->bindValue(':id', $userData['id'], PDO::PARAM_INT);
    try {
        $result = $sth->execute();
        return $result;
    } catch (PDOException $e) {
        return $result;
    }
  }

  /**
   * ユーザの退会処理
   * @param integer $id
  */
  public function withdrawal($id)
  {
    $sql = "DELETE FROM users WHERE id = :id";
    try{
      $sth = $this->dbh->prepare($sql);
      $sth->bindValue(':id', (int)$id, PDO::PARAM_INT);
      $sth->execute();
    } catch (PDOException $e) {
      return $result;
    }
  }

  /**
   * パスワードリセット
   * @param integer $id
  */
  public function mail_birthday_get($email,$birthday)
  {
    $sql = "SELECT id, email, birthday
            FROM users
            WHERE email = :email AND birthday = :birthday";
    try{
      $sth = $this->dbh->prepare($sql);
      $sth->bindValue(':email', $email, PDO::PARAM_STR);
      $sth->bindValue(':birthday', $birthday, PDO::PARAM_STR);
      $sth->execute();
      $result = $sth->fetch(PDO::FETCH_ASSOC);
      return $result;
    } catch (PDOException $e) {
      return $result;
    }
  }

  // パスワードアップデート
  public function pass_update($pass)
  {
    $sql = 'UPDATE users SET password = :password WHERE id = :id';
    $sth = $this->dbh->prepare($sql);
    $pass_hash = password_hash($pass['password'], PASSWORD_DEFAULT);

    $sth->bindValue(':password', $pass_hash, PDO::PARAM_STR);
    $sth->bindValue(':id', $pass['id'], PDO::PARAM_INT);
    try {
        $result = $sth->execute();
        return $result;
    } catch (PDOException $e) {
        return $result;
    }
  }
}
?>