<?php
require_once(ROOT_PATH .'Models/Db.php');

class Like extends Db {

  public function __construct($dbh = null) {
    parent::__construct($dbh);
  }

  /**
   * likesテーブルからいいね件数を取得
   * @param integer $id
   * @return Array $result 全いいねデータ
   */
  public function likeCount($id) {
    $sql = "SELECT count(post_id) FROM likes WHERE post_id = :id";
    $sth = $this->dbh->prepare($sql);
    $sth->bindValue(':id', $id, PDO::PARAM_INT);
    $sth->execute();
    $result = $sth->fetch();
    return $result;
  }

  // 非同期いいね
  //ユーザーIDと投稿IDを元にいいね値の重複チェック
  public function check_like($user_id,$post_id) {
    $sql = "SELECT * FROM likes WHERE user_id = :user_id AND post_id = :post_id";
    $stmt = $this->dbh->prepare($sql);
    $stmt->execute(array(':user_id' => $user_id , ':post_id' => $post_id));
    $favorite = $stmt->fetch();
    return $favorite;
  }

  /**
   * likesテーブルからいいねを削除
   * @param integer $user_id, $post_id
   * @return Bool $result 削除完了
   */
  public function delete_by_user_and_post($user_id,$post_id) {
    $this->dbh->beginTransaction();
    try{
      $sql = "DELETE FROM likes WHERE user_id = :user_id AND post_id = :post_id";
      $sth = $this->dbh->prepare($sql);
      $sth->bindValue(':user_id', (int)$user_id, PDO::PARAM_INT);
      $sth->bindValue(':post_id', (int)$post_id, PDO::PARAM_INT);
      $sth->execute();
      $this->dbh->commit();
    } catch (PDOException $e) {
      $this->dbh->rollback();
      return $result;
    }
  }

  /**
   * likesテーブルにいいねを挿入
   * @param integer $user_id,$post_id
   * @return Bool $result 挿入完了
   */
  public function insert($user_id,$post_id) {
    $this->dbh->beginTransaction();
    try {
      $sql = "INSERT INTO likes (user_id, post_id) VALUES (:user_id, :post_id)";
      $sth = $this->dbh->prepare($sql);
      $sth->bindValue(':user_id', (int)$user_id, PDO::PARAM_INT);
      $sth->bindValue(':post_id', (int)$post_id, PDO::PARAM_INT);
      $result = $sth->execute();
      $this->dbh->commit();
    } catch (PDOException $e) {
      $this->dbh->rollback();
      return $result;
    }
  }

  /**
   * likesテーブルから特定ユーザーがいいねした一覧を取得
   * @param integer $id
   * @return Array $result いいねした記事
   */
  public function good_index($id) {
    $sql = "SELECT l.id, l.user_id, l.post_id, p.emotion_id, p.title, p.body, p.date, u.name, u.image, e.emotion
            FROM likes l
            JOIN users u ON l.user_id = u.id
            JOIN posts p ON l.post_id = p.id
            JOIN emotions e ON p.emotion_id = e.id
            WHERE l.user_id = :id";
    $sth = $this->dbh->prepare($sql);
    $sth->bindValue(':id', (int)$id, PDO::PARAM_INT);
    $sth->execute();
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

}
?>