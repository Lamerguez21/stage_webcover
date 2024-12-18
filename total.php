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
            <h3>Total des heures travaillées par mois</h3>
            <br>
            <form action="total.php" method="post">
                <div class="champ">
                    <?php $Work = new Work;
                    $aff = $Work->afficheListeProfil();
                    echo $aff; ?>
                </div>
                <div class="champ">
                    <label for="">Sélectionner un mois</label>
                    <input type="month" name="mois" required>
                </div>
                <button type="submit">Afficher</button>
            </form>
            <br>
            <table>
                <?php
                if (isset($_POST['idUser']) && $_POST['mois']) { ?>

                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Mois</th>
                        <th>Total heure</th>
                        <th>Total centième</th>
                    </tr>

                    <?php
                    $Work = new Work();
                    $data = $Work->totalByMois($_POST['idUser'], $_POST['mois']);
                    if ($data) :
                        foreach ($data as $cool) : ?>

                            <tr>
                                <td><?= $cool->nom; ?></td>
                                <td><?= $cool->prenom; ?></td>
                                <td><?= $cool->mois; ?></td>
                                <td><?php echo $Work->convertitDecimalHeure($cool->total_cent_mois) ?></td>
                                <td><?= $cool->total_cent_mois; ?></td>
                            </tr>

                <?php endforeach;
                    endif;
                } ?>

            </table>
        </section>
    </main>
</body>

</html>