<?php include_once("resources/header.php");

if (isset($_POST['delete'])) {
        $id=htmlspecialchars($_GET['id']);
        User::deleteNews($id);

  }


?>


<div id="field">

<p>Do you realy want to delete this article? </p>
<form action="" method="POST">
<button type="submit" name="delete" value= "hey"> Post </button> <br></form>
</post>


</div>
