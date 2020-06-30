<?php

include("bdd/connexionBDD.php");

$req = $db->query("SELECT * FROM categories ORDER BY id");
$req = $req->fetchAll();

?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/index.css">
     <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Mon Forum</title>
  </head>
  <body>

    <div class="container">
    <h1>Mon forum</h1>
    <h2>La liste des catégories</h2>

    <div class="col-sm-0 col-md-0 col-lg-0"></div>
    <div class="col-sm-12 col-md-12 col-lg-12">

    <a href="creer_topic.php" class="btn btn-primary btn-lg active" role="button" aria-pressed="true" style="float: left; margin-bottom:10px;">Créer mon topic</a>

  <div class="table-responsive" style="margin-top: 10px;">
    <table class="table table-striped">
      <tr>
        <th>ID</th>
        <th>Titre</th>
      </tr>

      <!-- On parcours les données de $req (qui récupère toutes les catégories), et on affiche l'id et le titre de chaque catégorie existante -->
      <?php
        foreach($req as $r){
      ?>
        <tr>
          <td><?= $r['id'] ?></td>
          <td><a href="topic.php?id=<?= $r['id'] ?>"><?= $r['titre'] ?></td></a>
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
