<?php
Class Vesti {
  public $id;
  public $naslov;
  public $text;
  public $datum;
  public $kategorija;
  public $avtor;


  public function fetchNews () {
        $conn= Conn::getInstance();
        $vesti =$conn->conncetion->query('SELECT vesti.avtor, vesti.id, vesti.naslov, vesti.text, vesti.date, vesti.kategorija,
          kategorija.kategorija, kategorija.id, user.id,user.username FROM vezbaIT.vesti
          JOIN user ON vesti.avtor=user.id
          JOIN kategorija ON vesti.kategorija=kategorija.id;');
        $comment= $this->FetchComments();

        foreach($vesti as $red) {

              echo "<h2> <a href=index.php?vest=".trim($red["1"]).'>' .  $red["naslov"] . "</a></h2>" . "<p>". $red["text"] . "</p>" . "<p><i> Published on: " .$red["date"] . " by " .$red["username"].  "</i> in category: " .
              "<a href=index.php?id=". $red["5"] . ">".
               $red["kategorija"]. "</a></p>"  ;
          foreach($comment as $comments) {
                  if ($red[1]== $comments["vest"]) {
                   echo "<h3>" . $comments["naslov"] . "</h3>" . "<p>". $comments["text"] . "</p>" . "<p><i> Published on: " .$comments["date"] . " by " .$comments["username"]. "</i></p> ";

                   if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
                     echo '<a href="delete.php?id=' .
                       $comments["4"] .
                      '">Delete </a> <br>';

                  } else  if (isset($_SESSION['id']) && $comments["id"]== $_SESSION['id']) {
                     echo '<br><a href="delete.php?id=' .
                       $comments["4"] .
                      '" >Delete </a> <br>';
                   }
                 }
              }

              Vesti::SetComments($red["1"]);

             }


            }


  public function fetchNewsById ($id) {
                $conn= Conn::getInstance();
                $vesti =$conn->conncetion->prepare('SELECT vesti.avtor, vesti.id, vesti.naslov, vesti.text, vesti.date, vesti.kategorija,
                  kategorija.kategorija, kategorija.id, user.id,user.username FROM vezbaIT.vesti
                  JOIN user ON vesti.avtor=user.id
                  JOIN kategorija ON vesti.kategorija=kategorija.id
                  where vesti.id = ?
                  ;');
                  $vesti->execute([$id]);

                  $comment= $this->FetchComments();

                  foreach($vesti as $red) {
                      echo "<h2> <a href=index.php?vest=".trim($red["1"]).'>' .  $red["naslov"] . "</a></h2>" . "<p>". $red["text"] . "</p>" . "<p><i> Published on: " .$red["date"] . " by " .$red["username"].  "</i> in category: " .
                      "<a href=index.php?id=". $red["5"] . ">".
                       $red["kategorija"]. "</a></p>"   ;
                       foreach($comment as $comments) {
                          if ($red[1]== $comments["vest"]) {
                           echo "<h3>" . $comments["naslov"] . "</h3>" . "<p>". $comments["text"] . "</p>" . "<p><i> Published on: " .$comments["date"] . " by " .$comments["username"]. "</i></p> ";

                           if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
                             echo '<a href="delete.php?id=' .
                               $comments["4"] .
                              '" method="GET">Delete </a> <br>';
                              } else  if (isset($_SESSION['id']) && $comments["id"]== $_SESSION['id']) {
                                 echo '<br><a href="delete.php?id=' .
                                   $comments["4"] .
                                  '" method="GET">Delete </a> <br>';
                               }
                         }
                       }
                        Vesti::SetComments($red["1"]);

                     }

                    }


  public function fetchMenu () {
        $conn= Conn::getInstance();
          $sth =$conn->conncetion->query('SELECT id, kategorija FROM vezbaIT.kategorija;');
          foreach($sth as $red)
            echo '<li><a href=index.php?id='. urlencode($red["id"]) . '>'.  $red["kategorija"] . '</a></li>';
          }

  public function pagenav ($id) {
            $conn= Conn::getInstance();
            $sth =$conn->conncetion->prepare('SELECT vesti.id, vesti.naslov, vesti.text, vesti.date, vesti.kategorija
            FROM vesti WHERE kategorija =?');

            $sth->execute([$id]);

            $res= $sth->fetchAll(PDO::FETCH_CLASS, 'Vesti');
            $comment= $this->FetchComments();
            $name=User::commentArea();
           foreach($res as $red) {
                echo  "<h2> <a href=index.php?vest=".trim($red->id).'>'. $red->naslov . "</a></h2><p>". $red->text . "</p><i><p>Published on: " . $red->date . " </i><br><br><b>Disscusion: </b></p> ";
                foreach($comment as $comments) {

                        if ($red->id== $comments["vest"]) {
                         echo "<h3>" . $comments["naslov"] . "</h3>" . "<p>". $comments["text"] . "</p>" . "<p><i> Published on: " .$comments["date"] . " by " .$comments["username"]. "</i> </p> ";
                          if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
                            echo '<a href="delete.php?id=' .
                              $comments["4"] .
                             '" method="GET">Delete </a> <br>';

                         } else if (isset($_SESSION['id']) && $comments["id"]== $_SESSION['id']) {
                           echo '<a href="delete.php?id=' .
                             $comments["4"] .
                            '" method="GET">Delete </a> <br>';
                         }
                       }

                    }
                     Vesti::SetComments($red->id);
              }

}

  public function FetchComments() {
          $conn= Conn::getInstance();
          $alldata =$conn->conncetion->prepare('SELECT vesti.id, komentari.naslov, komentari.text, komentari.date, komentari.id, komentari.vest, komentari.avtor, user.id, user.username
          FROM vesti
          JOIN komentari ON vesti.id = komentari.vest
          JOIN user WHERE komentari.avtor = user.id;');
          $alldata->execute();
          $result = $alldata->fetchAll();
          return $result;


    }



  public function adminNews () {

      $conn= Conn::getInstance();
      $vesti =$conn->conncetion->query('SELECT vesti.avtor, vesti.id, vesti.naslov, vesti.text, vesti.date, vesti.kategorija,
        kategorija.kategorija, kategorija.id, user.id,user.username FROM vezbaIT.vesti
        JOIN user ON vesti.avtor=user.id
        JOIN kategorija ON vesti.kategorija=kategorija.id
        ;');

        echo "<table>  <thead> <tr> <th>Title</th>  <th>Published on: </th>  <th>Author: </th> <th> Category</th></tr> </thead> <tbody>";
        foreach($vesti as $red) {

            echo "<tr>";
            echo "<td> <a href=index.php?vest=".trim($red["1"]).'>' .  $red["naslov"] . "</a></td>"  . "<td><i> " .
            $red["date"] . " <td> " .$red["username"].  "</i> </td> <td> " .
            "<a href=index.php?id=". $red["5"] . ">".
             $red["kategorija"]. "</a></td> <td><a href='deleteNews.php?id=" .
               $red["1"] .
              "'>Delete </a> <br></td>"  ;

    }
      echo '</tbody></table>';

  }

public static function getCategory ()
{
  $conn= Conn::getInstance();
  $vesti =$conn->conncetion->query('SELECT
    kategorija.kategorija, kategorija.id FROM kategorija
    ;');
    echo "<select name= 'kat'>";
    foreach($vesti as $red) {

      echo "<option value =' " . $red["id"]  ."' >" . $red ["kategorija"] ."</option> ";



    }
      echo "</select> <br> <br><button type='submit' name='news'value= 'hey'> Post News </button></form>";
}

private static function SetComments($id) {
  if (isset($_SESSION['id'])) {
  echo '<br><a href="comment.php?id=' .
   $id .
   '">Comment </a> <br>';
    } else  {
   echo "<a href='signup.php' >Sign up </a>if you want to leave a comment...";

    }

  }
}
