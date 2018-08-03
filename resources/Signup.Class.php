<?php

Class Signup {

  private $firstname;
  private $lastname;
  private $username;
  private $password;
  public $email;


  public function __construct($firstname, $lastname, $username, $password, $email) {
            $this->firstname = $firstname;
            $this->lastname = $lastname;
            $this->username = $username;
            $this->password = $password;
            $this->email = $email;


  }
//провери дали користи валидни каратери
  private function ValidChars () {
         if (!preg_match("/^[a-zA-Z]*$/", $this->firstname)||!preg_match("/^[a-zA-Z]*$/", $this->lastname)) {
          header("Location: signup.php?error=invalid");
            exit();
          }
            else {
                $this->ValidMail();
              }
            }

  //Провери дали се празни
 public function CheckEmpty() {
      if(empty( $this->firstname)||empty($this->lastname)|| empty($this->username)||empty($this->password) ||empty($this->email)) {
      header('Location: signup.php?error=empty');
      exit();
    } else {

        $this->ValidChars();
      }
    }

        //проверува дали мејот е валиден
    private function Validmail () {
                if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
                  header("Location: signup.php?error=email");
                    exit();
                  } else {
                  $this->isItTaken();
                  }
                }
    private function isItTaken() {
                $conn= Conn::getInstance();
                $sth =$conn->conncetion->prepare('SELECT username
                FROM user WHERE username=:username' );

                $sth->bindParam(':username', $this->username);

                $sth->execute();

                if ($sth->rowCount()>0) {
                      header("Location: signup.php?error=user_taken");
                        exit();

                      } else {

                        $this->insert();
                      }
                    }
      private function insert ( ) {
                //пасвордот се хашира

              $conn= Conn::getInstance();
              //$sth =$conn->conncetion->prepare('INSERT INTO user (first_name, last_name, email, username, password) VALUES (:first, :last, :email, :username, :password)');
              $sth =$conn->conncetion->prepare('INSERT INTO user (first_name, last_name, username, password, email) VALUES (:first, :last, :username, :password, :email)');

              $first = $this->firstname;
              $last= $this->lastname;
              $username= $this->username;
              $email= $this->email;
              $password= md5($this->password);


              $sth->execute(array(
                ':first'=>$first,
                ':last'=>$last,
                ':username'=>$username,
                ':password'=>$password,
                ':email'=>$email
              ));

              header("Location: index.php?message=done");
              exit();
              }

      public static function DisplayErrors ($getparam) {
          switch ($getparam) {
              case "empty":
                  echo "<p>All fields are required</p>";
                  break;
              case "invalid":
                  echo "<p> Your firstname and lastname should contain only letters. </p>";
                  break;
              case "email":
                  echo "<p> You must use a valid email address </p>";
                  break;
              case "user_taken":
                  echo "<p> The username is already in use </p>";
                  break;
              default:
                  echo "<p> You have now signed up. Please login</p>";
                  break;
                }




      }

  }
