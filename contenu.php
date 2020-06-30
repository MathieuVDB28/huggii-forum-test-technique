<?php

  include("bdd/connexionBDD.php");

  // on récupère la valeur de l'id de la catégorie et du topic
  // htmlentities convertit tous les caractères éligibles en entités HTML ?
  // trim pour supprimer les éventuels espaces en début et fin de chaîne ?
  // intval car on réciupère un entier ?
  if(isset($_GET['categorie'])) $getid_forum = intval(trim(htmlentities($_GET['categorie'])));
  if(isset($_GET['topic'])) $getid_topic = intval(trim(htmlentities($_GET['topic'])));

  // On prépare la requête pour récupérer les différents topics ordonnés par date de création que l'on met sous le format J/M/A (avec l'heure affichée)
  $req = $db->prepare("SELECT *, DATE_FORMAT(date_creation, 'Le %d/%m/%Y à %H\h%i') as date_c FROM topic WHERE id = ? AND id_forum = ? ORDER BY date_creation DESC"); 
  $req->execute(array($getid_topic, $getid_forum)); // on execute la requête en passant l'id de la catégorie et du topic, pour eviter les erreurs
  $res = $req->fetch(); // on récupère tous les topics

  // On prépare la requête pour récupérer les messages liés au topic ordonnés par date de création ue l'on met sous le format J/M/A (avec l'heure affichée)
  $req_mess = $db->prepare("SELECT *, DATE_FORMAT(date_creation, 'Le %d/%m/%Y à %H\h%i') as date_c FROM topic_commentaire WHERE id_topic = ? ORDER BY date_creation DESC");
  $req_mess->execute(array($getid_topic)); // on execute la requête en passant du topic, pour eviter les erreurs
  $res_mess = $req_mess->fetchAll(); // on récupère tous les messages

  if(!empty($_POST)){
    extract($_POST);
    $valid = true;

    if (isset($_POST['add_msg'])){
      $message  = (String) htmlentities(trim($message)); // On récupère le contenu du message

        if(empty($message)){ // On vérifie si le message est vide
          $valid = false;
          $er_msg = "Il faut un commentaire"; 
        }

        if($valid){
          $date_creation = date('Y-m-d H:i:s'); // On récupère la date

          // On prépare la requête pour insérer le messages liés au topic 
          $insert = $db->prepare("INSERT INTO topic_commentaire (id_topic, texte, date_creation) VALUES 
                (?, ?, ?)");
            
            $insert->execute(array($getid_topic, $message, $date_creation)); // on execute la requête en passant du l'id du message ,le contenu et la date pour eviter les erreurs
          header('Location: contenu.php?categorie=' . $getid_forum .'&topic=' . $getid_topic); // On redirige ensuite sur la page du topic où le message a été créé
          exit;
        }
    }
  }  

?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/index.css">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Le contenu</title>
  </head>
  <body>

    <div class="container">

    <div class="col-sm-0 col-md-0 col-lg-0"></div>
    <div class="col-sm-12 col-md-12 col-lg-12">

    <h1 style="text-align: center">Sujet : <td><?= $res['titre'] ?></td></h1>

      <div style="background: white; box-shadow: 0 5px 15px rgba(0, 0, 0, .15); padding: 5px 10px; border-radius: 20px;">
        <h3>Contenu</h3>
          <div style="border-top: 2px solid #eee; padding: 10px 0;"><?= $res['contenu'] ?></div>
          <div style="color: #CCC; text-align: right">
          <?= $res['date_c'] ?>
          </div>
      </div>

      <div style="background: white; box-shadow: 0 5px 15px rgba(0, 0, 0, .15); padding: 5px 10px; border-radius: 20px; margin-top: 10px;">
        <h3>Ecrire mon message</h3>

        <?php
                // S'il y a une erreur sur le message alors on affiche le message d'erreur
                if (isset($er_msg)){
                ?>
                    <div><?= $er_msg ?></div>
                <?php   
                }
            ?>

        <form method="post">
        <div class="form-group">
        <textarea class="form-control" name="message" rows="3"></textarea>
        </div>
        <button class="btn btn-primary" type="submit" name="add_msg">Envoyer</button>
        </form>
      </div>

      <div style="background: white; box-shadow: 0 5px 15px rgba(0, 0, 0, .15); padding: 5px 10px; border-radius: 20px; margin-top: 10px;">
        <h3>Messages</h3>

      <div class="table-responsive">
      <table class="table table-striped">
          <tr>
            <th>Réponse</th>
            <th>Date</th>
          </tr>

          <!-- On parcours les données de $res_mess (qui récupère tous les messages du topic), et on affiche le contenu et la date de chaque message existant -->
          <?php
            foreach($res_mess as $rc){
          ?>
            <tr>
              <td><?= $rc['texte'] ?></td>
              <td><?= $rc['date_c'] ?></td>
            </tr>
          <?php
          }
          ?>
        </table>
        </div>
      </div>
            <a href="topic.php?id=<?=$getid_forum?>" class="btn btn-primary btn-lg active" role="button" aria-pressed="true" style="float: left; margin-bottom:10px;">Retour à la liste des topics</a>
</div>

 </body>
</html>