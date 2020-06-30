<?php

  include("bdd/connexionBDD.php");

  // on récupère la valeur de la query id
  // htmlentities convertit tous les caractères éligibles en entités HTML ?
  // trim pour supprimer les éventuels espaces en début et fin de chaîne ?
  // intval car on réciupère un entier ?
  $getid = intval(trim(htmlentities($_GET['id'])));

  // On prépare la requête pour récupérer les différents topics ordonnés par date de création que l'on met sous le format J/M/A (avec l'heure affichée)
  $req = $db->prepare("SELECT *, DATE_FORMAT(date_creation, 'Le %d/%m/%Y à %H\h%i') as date_c FROM topic WHERE id_forum = ? ORDER BY date_creation DESC"); 
  $req->execute(array($getid)); // on execute la requête en passant l'id de la catégorie
  $res = $req->fetchAll(); // on récupère  tous les topics

?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/index.css">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Les topics</title>
  </head>
  <body>

    <div class="container">

    <h1>La liste des sujets</h1>

    <div class="col-sm-0 col-md-0 col-lg-0"></div>
    <div class="col-sm-12 col-md-12 col-lg-12">

  <div class="table-responsive">
    <table class="table table-striped">
      <tr>
        <th>Titre</th>
        <th>Date de création</th>
      </tr>

      <!-- On parcours les données de $res (qui récupère tous les topics), et on affiche le titre et la date de chaque topic existant -->
      <?php
        foreach($res as $r){
      ?>
        <tr>
          <td><a href="contenu.php?categorie=<?= $getid?>&topic=<?=$r['id']?>"><?= $r['titre'] ?></a></td>
          <td><?= $r['date_c'] ?></td>
        </tr>
      <?php
      }
      ?>
    </table>
  </div>
</div>
</div>

  </body>
</html>
