<?php
session_start();

spl_autoload_register(function ($className) {
require $className . ".Class.php";

}

);

// require 'Conn.Class.php';
// require 'Login.Class.php';
// require 'User.Class.php';
// require 'Vesti.Class.php';
// require 'Signup.Class.php';

if (isset($_POST['logout'])) {
          unset($_SESSION["user"]);
          unset($_SESSION["id"]);
          unset($_SESSION["admin"]);
          header ("Location: index.php");
      }

?>

<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Form </title>
  <link href="https://fonts.googleapis.com/css?family=Noto+Serif|Raleway" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
      <nav>
        <div id="container" class="clearfix">
          <ul>
            <li> <a  href="index.php" > Home </a> <li>
              <?php
              $news= new Vesti;
              $news->fetchMenu();

              ?>
          </ul>

          <div class="login">
            <?php


            if (isset($_SESSION['user'])) {
                echo ' <form action="" method="POST">
                      <button type="submit" name="logout"> Logout</button>
                  </form>';
                  if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
                    echo '<a href="admin_area.php"
                     ><button type="Admin" name="Admin"> Admin</button> </a>';
                   }
            }  else {
              echo '<form action="" method="POST">
                    <input type="text" name="username" placeholder="Your e-mail">
                    <input type="password" name="password" placeholder="Password">
                    <button type="submit" name="submit"> Login</button>
                    </form>   <a href="signup.php"> <button name="signup"> Sign up </button> </a>
                    ';


                    if (isset($_POST['submit'])) {
                            $username = trim( $_POST['username']);
                            $password = trim($_POST['password']);
                            $login = new Login($username, $password);
                            $login->login();
                          }

            }?>
            <div>
        </div>
      </nav>
