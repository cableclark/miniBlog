<?php

Class Login
{
  private $username;
  private $password;
  private $user;


  public function __construct ($username, $password) {
    $this->username= $username;
    $this->password= md5($password);
  }

  public function checkDB () {
      $conn= conn::getInstance();
      $sth =$conn->conncetion->prepare('SELECT username, password, admin, id
      FROM user WHERE username=:username AND password=:password');

      $sth->bindParam(':username', $this->username);
      $sth->bindParam(':password', $this->password);
      $sth->execute();

      if ($sth->rowCount()>0) {
        $this->user = $sth->fetch(PDO::FETCH_ASSOC);
        return true;}
        else{
        return false;
        }
      }


  public function login () {
        if ($this->checkDB()) {
          session_start();
         $_SESSION['user'] = $this->username;
         $_SESSION['id'] = $this->user["id"];
         $_SESSION['admin'] = $this->user['admin'];
        header('Location: index.php');
    } else {
      echo "<p>The username or password is incorrect</p>";
    }

  }


}
