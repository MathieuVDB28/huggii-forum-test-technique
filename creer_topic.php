<?php

  include("bdd/connexionBDD.php");

  // On test d'abord si le contenu du topic est vide
  if(!empty($_POST)){
    extract($_POST);
    $valid = true;

    if (isset($_POST['creer-topic'])){
        $titre  = htmlentities(trim($titre)); // On récupère le titre
        $contenu = htmlentities(trim($contenu)); // on récupère le contenu
        $categorie = (int) htmlentities(trim($categorie)); // on récupère la categorie

        //  Vérification du titre
        if(empty($titre)){
            $valid = false;
            $er_titre = ("Il faut un titre à votre topic");
        }       

        //  Vérification du contenu
        if(empty($contenu)){
            $valid = false;
            $er_contenu = ("Il faut un contenu à votre topic");
        }       

        // Vérification de la categorie
        if(empty($categorie)){
            $valid = false;
            $er_categorie = "Il faut sélectionner une catégorie";

        }else{
            $verif_cat = $db->prepare("SELECT id, titre FROM forum WHERE id = ?"); // On prépare la requête pour récupérer les id des catégories
            $verif_cat->execute(array($categorie)); // on execute la requête en passant l'id de la catégorie pour eviter les erreurs

            $verif_cat_res = $verif_cat->fetch(); // on récupère les id

            // On vérifie si la catégorie existe
            if (!isset($verif_cat_res['id'])){
                $verif_cat_res = false;
                $er_categorie= "Cette categorie n'existe pas";
            }
        }

        if($valid){

            $date_creation = date('Y-m-d H:i:s'); // On récupère la date 

            // On prépare la requête pour insérer notre topic 
            $insert = $db->prepare("INSERT INTO topic (id_forum, titre, contenu, date_creation) VALUES 
                (?, ?, ?, ?)");
            
            // on execute la requête en passant l'id, le titre, le contenu et la date de création du topic pour eviter les erreurs
            $insert->execute(array($categorie, $titre, $contenu, $date_creation)); 
            header('Location: topic.php?id=' . $categorie); // On redirige ensuite sur la page du topic créé
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
    <title>Créer mon topic</title>
  </head>
  <body>

    <div class="container">

    <div>Créer mon topic</div>
        <form method="post">
            <?php
                // S'il y a une erreur sur la catégorie alors on affiche le message d'erreur
                if (isset($er_categorie)){
                ?>
                    <div><?= $er_categorie ?></div>
                <?php   
                }
            ?>
            <div class="input-group mb-3">
                <select name="categorie" class="custom-select" id="inputGroupSelect01">
                <!-- On récupère les catégories existantes et on les affiche dans un bouton select -->
                <option selected>Sélectionnez votre catégorie</option>
                    <?php
                        $req_cat = $db->query("SELECT * FROM categories");
                        $req_cat = $req_cat->fetchAll();

                        foreach($req_cat as $rc){
                            ?>
                                <option value="<?= $rc['id'] ?>"><?= $rc['titre'] ?></option>
                            <?php
                        }
                    ?>
                </select>
            </div>   
            <?php
                if (isset($er_titre)){ // On affiche les eventuelles erreurs
                ?>
                    <div><?= $er_titre ?></div>
                <?php   
                }
            ?>
            <input class="form-control" type="text" placeholder="Votre titre" name="titre" value="<?php if(isset($titre)){ echo $titre; }?>" required> <!-- Input pour le titre du topic -->  
            <?php
                if (isset($er_contenu)){ // On affiche les eventuelles erreurs
                ?>
                    <div><?= $er_contenu ?></div>
                <?php   
                }
            ?>
            <!-- Textarea pour le contenu du topic --> 
            <textarea class="form-control" id="exampleFormControlTextarea1" placeholder="Décrivez votre topic" name="contenu"<?php if(isset($contenu)){ echo $contenu; }?> rows="3" required></textarea>
            <button class="btn btn-primary" type="submit" name="creer-topic">Envoyer</button>
        </form>
        <a href="index.php" class="btn btn-primary btn-lg active" role="button" aria-pressed="true" style="float: left; margin-bottom:10px;">Retour à l'accueil</a>
   </div>

</body>
</html>