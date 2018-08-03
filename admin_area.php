<?php include_once("resources/header.php");

if (isset($_POST['comment'])) {
        User::comment($id);

  }



?>

<div id="field">
<?php  if (isset($_GET['article'])) {
             echo "<p>New blog post has been saved!</br><br>";

            }
?>
<a href="add_news.php"
   ><button id="btn_al" type="add" name="Add"> Add news</button> </a> <br>
   <br>

<?php
$vesti = new Vesti;
$vesti->adminNews();




?>

</div>


<?php  include "footer.html"; ?>
