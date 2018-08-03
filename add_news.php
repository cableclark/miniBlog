<?php include_once("resources/header.php");
?>

<div id="field">

<?php

if (isset($_POST['news'])) {
       User::PostNews();
      print_r ($_POST);
      }


$user= new User;

echo $user->newsArea();

Vesti::getCategory();


?>


<?php  include "footer.html"; ?>
