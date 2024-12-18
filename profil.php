<?php
require('Work.php');
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="index.css? <?php echo time() ?>" rel="stylesheet">
    <title>Mon projet</title>
</head>

<body>
    <?php
    require('header.php');
    ?>

    <main>
        <section>
            <h3>Ajout d'un profil</h3>
            <br>
            <form action="profil.php" method="post">
                <div class="champ">
                    <label for="">Nom</label>
                    <input type="text" name="nom" required>
                </div>
                <div class="champ">
                    <label for="">Prénom</label>
                    <input type="text" name="prenom" required>
                </div>
                <div class="champ">
                    <label for="email">Email</label>
                    <input type="email" name="email" required>
                </div>
                <button type="submit">Ajouter</button>
            </form>

            <?php
            if (isset($_POST)) {
                if (!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['email'])) {
                    $Work = new Work();
                    $Work->nom = $_POST['nom'];
                    $Work->prenom = $_POST['prenom'];
                    $Work->email = $_POST['email'];
                    if (true === $Work->ajoutProfil()) {
                        echo '<br><span class="message">Profil ajouté</span>';
                    } else {
                        echo 'Problème';
                    }
                }
            }
            ?>
        </section>

        <section>
            <h3>Suppression de profil</h3>
            <br>
            <form action="profil.php" method="post">
                <?php $Work = new Work;
                $aff = $Work->afficheListeProfil();
                echo $aff; ?>
                <button type="submit">Supprimer</button>
            </form>


            <?php
            if (isset($_POST['idUser'])) {
                if (!empty($_POST['idUser']) && $_POST['idUser'] != "") {
                    $Work = new Work();
                    $Work->supprimerProfil($_POST['idUser']);
                    if (true === $Work->supprimerProfil($_POST['idUser'])) {
                        echo '<br><span class="message_supp">Profil supprimé</span>';
                    } else {
                        echo 'Problème';
                    }
                }
            }

            ?>
        </section>
    </main>
</body>

</html>