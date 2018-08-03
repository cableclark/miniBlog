<?php include_once("resources/header.php");
?>

<div id="field">

<?php

if (isset($_GET['id'])) {
        $id=htmlspecialchars($_GET['id']);
        $news->pagenav($id);

      }

else if (isset($_GET['vest'])) {
            $id=htmlspecialchars($_GET['vest']);
             $news->fetchNewsById ($id) ;
            }
else {
$news->fetchNews();
}





?>



</div>
<?php  include "footer.html"; ?>
