<?php
Class User
 {

public static function CommentArea () {

    $commentarea =isset($_SESSION['user'])? ' <p> Enter your comment, ' . $_SESSION['user'] .  '</p>
    <form action="" method="POST">
    <input type="text" name="naslov" class="naslov" placeholder= "Your title">
    <textarea name="tekst" rows="5" placeholder="Comment here..."> </textarea>
    <br>
    <button type="submit" name="comment" value= "hey"> Post </button> <br><br></form>
      <br>':"";

      return $commentarea;
  }


public static function Comment($vest_id) {
    $conn= Conn::getInstance();
    $sth =$conn->conncetion->prepare('INSERT INTO komentari (naslov, text, avtor, vest) VALUES (:naslov, :text, :avtor, :vest)');
    $nas = $_POST["naslov"];
    $tekst= $_POST["tekst"];
    $user= $_SESSION['id'];
    $vest= $vest_id;

    $sth->execute(array(
      ':naslov'=>$nas,
      ':text'=>$tekst,
      ':avtor'=>$user,
      ':vest'=>$vest,
  ));
  header("Refresh:0");
   exit();

 }

public static function delete($com_id) {
  $conn= Conn::getInstance();
  $sth =$conn->conncetion->prepare('delete from komentari WHERE id = :id;');
  $sth->execute(array(
    ':id'=>$com_id));
  header("Location: index.php?comment=deleted");
   exit();

}

public static function deleteNews($com_id) {
  $conn= Conn::getInstance();
  $sth =$conn->conncetion->prepare('delete from vesti WHERE id = :id;');
  $sth->execute(array(
    ':id'=>$com_id));
  header("Location: admin_area.php?comment=deleted");
   exit();

}

public static function NewsArea () {

    $commentarea =isset($_SESSION['user'])? ' <p> Post a new blog article, ' . $_SESSION['user'] .  '</p>
    <form action="" method="POST">
    <input type="text" name="naslov" class="naslov" placeholder= "Your title">
    <textarea name="tekst" rows="5" placeholder="Comment here..."> </textarea>
    <br>

':"";

      return $commentarea;
  }

  public static function PostNews() {
      $conn= Conn::getInstance();
      $sth =$conn->conncetion->prepare('INSERT INTO vesti (naslov, text, avtor, kategorija) VALUES (:naslov, :text, :avtor, :kategorija)');
      $nas = $_POST["naslov"];
      $tekst= $_POST["tekst"];
      $user= $_SESSION['id'];
      $kategorija= $_POST["kat"];;

      $sth->execute(array(
        ':naslov'=>$nas,
        ':text'=>$tekst,
        ':avtor'=>$user,
        ':kategorija'=>$kategorija,
    ));
    header("Location: admin_area.php?article=posted");
     exit();

   }



}
