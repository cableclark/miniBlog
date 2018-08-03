<?php include_once("resources/header.php");
$id=htmlspecialchars($_GET['id']);

if (isset($_POST['comment'])) {
        User::comment($id);

  }

?>

<div id="field">
<?php
$vesti = new Vesti;
$vesti->fetchNewsById($id);
$user= new User;

echo $user->CommentArea()
?>

</div>

<?php  include "footer.html"; ?>
