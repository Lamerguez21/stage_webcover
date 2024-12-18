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
    <title>stage_webcover</title>
</head>

<body>

    <?php
    require('header.php');
    ?>

    <main>
        <section>
            <h3>Enregistrement des heures de travail</h3>
            <br>
            <form action="index.php" method="post">
                <div class="champ">
                    <?php $Work = new Work;
                    $aff = $Work->afficheListeProfil();
                    echo $aff; ?>
                </div>
                <div class="champ">
                    <label for="date">Date</label>
                    <input type="date" name="date" required>
                </div>
                <div class="champ">
                    <label for="">Heure de début</label>
                    <input type="time" name="heure_deb" required>
                </div>
                <div class="champ">
                    <label for="">Heure de fin</label>
                    <input type="time" name="heure_fin" required>
                </div>
                <div>
                    <button type="submit">Enregistrer</button>
                </div>
            </form>

            <?php
            if (isset($_POST)) {
                if (
                    !empty($_POST['idUser']) && !empty($_POST['date']) && !empty($_POST['heure_deb'])
                    && !empty($_POST['heure_fin'])
                ) {
                    $Work = new Work();
                    $Work->idUser = $_POST['idUser'];
                    $Work->date = $_POST['date'];
                    $Work->hStart = $_POST['heure_deb'];
                    $Work->hEnd = $_POST['heure_fin'];
                    if (true === $Work->save()) {
                        echo '<br><span class="message">Travail enregistré</span>';
                    } else {
                        echo 'Problème';
                    }
                }
            }
            ?>
        </section>

        <section>
            <h3>Affichage des heures de travail</h3>
            <br>
            <form action="/projet/" method="post">
                <div class="champ">
                    <label for="">Sélectionner un mois</label>
                    <input type="month" name="month" required>
                </div>
                <button type="submit">Afficher</button>
            </form>
            <br>

            <table>
                <?php
                if (isset($_POST['month'])) { ?>

                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Date</th>
                        <th>Heure de début</th>
                        <th>Heure de fin</th>
                        <th>Total heures</th>
                        <th>Total centième</th>
                    </tr>

                    <?php
                    $Work = new Work();
                    $data = $Work->showAllByMonth($_POST['month']);
                    if ($data) :
                        foreach ($data as $heure) : ?>

                            <tr>
                                <td><?= $heure->nom; ?></td>
                                <td><?= $heure->prenom; ?></td>
                                <td><?= $heure->date; ?></td>
                                <td><?= $heure->heure_deb; ?></td>
                                <td><?= $heure->heure_fin; ?></td>
                                <td><?= $heure->total; ?></td>
                                <td><?= $heure->total_cent; ?></td>
                            </tr>

                <?php endforeach;
                    endif;
                } ?>
            </table>
        </section>


        <section>
            <h3>Suppression d'un enregistrement</h3>
            <br>
            <form action="index.php" method="post">

                <div class="champ">
                    <?php $Work = new Work;
                    $aff = $Work->afficheListeProfil("idS");
                    echo $aff; ?>
                </div>
                <div class="champ">
                    <label for="date">Date</label>
                    <input type="date" name="dateS" required>
                </div>
                <div class="champ">
                    <label for="">Heure de début</label>
                    <input type="time" name="heure_debS" required>
                </div>
                <div class="champ">
                    <label for="">Heure de fin</label>
                    <input type="time" name="heure_finS" required>
                </div>
                <div class="champ">
                    <button type="submit">Supprimer</button>
                </div>

            </form>

            <?php
            if (isset($_POST)) {
                if (
                    !empty($_POST['idS']) && !empty($_POST['dateS']) && !empty($_POST['heure_debS'])
                    && !empty($_POST['heure_finS'])
                ) {
                    $Work = new Work();
                    $Work->supprimerEnregistrement($_POST['idS'], $_POST['dateS'], $_POST['heure_debS'], $_POST['heure_finS']);
                    if (true === $Work->supprimerEnregistrement($_POST['idS'], $_POST['dateS'], $_POST['heure_debS'], $_POST['heure_finS'])) {
                        echo '<br><span class="message_supp">Enregistrement supprimé</span>';
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