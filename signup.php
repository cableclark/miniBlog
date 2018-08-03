<?php
include_once 'resources/header.php';

if(isset($_POST['signup']))
{
  $signup =New Signup($_POST['first'], $_POST['last'], $_POST['username'], $_POST['password'], $_POST['email']);
  session_start();
  $_SESSION['first'] =  $_POST['first'];
  $_SESSION['last'] =  $_POST['last'];
  $_SESSION['username'] =  $_POST['username'];
  $_SESSION['password'] = $_POST['password'];
  $_SESSION['email'] = $_POST['email'];

  $signup->CheckEmpty();
}


?>
<div id="formfield">
<section>

    <div class= "main-container">
        <h2> Signup</h2>
        <form action="" method="POST" id ="formsign">
            <input type="text" name="first" placeholder ="Firstname" value= "<?php if(isset($_SESSION['first']))
             { echo  $_SESSION['first']; } ?>"> <br>
            <input type="text" name="last" placeholder ="Lastname" value= "<?php if(isset($_SESSION['last']))
             { echo  $_SESSION['last']; } ?>"> <br>
            <input type="text" name="email" placeholder ="E-mail" value= "<?php if(isset($_SESSION['email']))
             { echo  $_SESSION['email']; } ?>"><br>
            <input type="text" name="username" placeholder ="Username"value= "<?php if(isset($_SESSION['username']))
             { echo  $_SESSION['username']; } ?>"><br>
            <input type="password" name="password" placeholder ="Password" value= "<?php if(isset($_SESSION['password']))
             { echo  $_SESSION['password']; } ?>"><br>
            <button type="submit" name= "signup"> Sign up </button>
        </form> <br>
      <?php
      if (isset($_GET["error"])) {
        Signup::DisplayErrors ($_GET["error"]);
      }
         ?>


  </div>
</section>

</div>

<?php  include "footer.html"; ?>
