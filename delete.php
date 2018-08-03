<?php include_once("resources/header.php");

if (isset($_POST['comment'])) {
        $id=htmlspecialchars($_GET['id']);
        User::delete($id);

  }


?>


<div id="field">

<p>Do you realy want to delete this comment? </p>
<form action="" method="POST">
<button type="submit" name="comment" value= "hey"> Post </button> <br></form>
</post>


</div>

<?php  include "footer.html"; ?>
