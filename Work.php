<?php
class Work
{
    private $dbh;
    public $idUser;
    public $date;
    public $hStart;
    public $hEnd;
    public $total;
    public $totalCent;
    public $nom;
    public $prenom;
    public $email;
    public $total_mois;
    public $total_cent_mois;
    public $mois;

    public function __construct()
    {
        try {
            $this->dbh = new PDO('mysql:host=localhost;dbname=gestion;charset=utf8', 'root', '');
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function save()
    {
        $totals = $this->getTotal($this->hStart, $this->hEnd);
        $this->total = $totals['total'];
        $this->totalCent = $totals['total_cent'];

        $sqlQuery = 'INSERT INTO travail (idUser, date, heure_deb, heure_fin, total, total_cent) 
        VALUES (:idUser, :date, :heure_deb, :heure_fin, :total, :total_cent)';

        $enregistrement = $this->dbh->prepare($sqlQuery);
        return $enregistrement->execute([
            'idUser' => $this->idUser,
            'date' => $this->date,
            'heure_deb' => $this->hStart,
            'heure_fin' => $this->hEnd,
            'total' => $this->total,
            'total_cent' => $this->totalCent
        ]);
    }

    public function showAllByMonth($month)
    {
        $sqlQuery = 'SELECT H.idUser, U.nom, U.prenom, date_format(H.date, "%d/%m/%Y") as date, date_format(H.heure_deb, "%H:%i") as heure_deb, date_format(H.heure_fin, "%H:%i") as heure_fin, H.total, H.total_cent 
        FROM travail AS H LEFT JOIN profil AS U USING (idUser)
        WHERE date_format(H.date, "%Y-%m") = :month 
        ORDER BY H.date';
        $enregistrement = $this->dbh->prepare($sqlQuery);
        $return = $enregistrement->execute(['month' => $month]);
        if ($return) {
            return $enregistrement->fetchAll(PDO::FETCH_OBJ);
        }
        return false;
    }

    // retourne la différence de temps entre deux heures différentes et sa valeur en centièmes
    public function getTotal($hDeb, $hFin)
    {
        list($h1, $m1) = explode(':', $hDeb);
        list($h2, $m2) = explode(':', $hFin);

        $total_min_deb = (int)$h1 * 60 + (int)$m1;
        $total_min_fin = (int)$h2 * 60 + (int)$m2;
        $dif = ($total_min_fin - $total_min_deb);

        $total_heure = intdiv($dif, 60);
        $total_min = $dif % 60;

        $total = strval($total_heure) . ':' . ($total_min < 10 ? '0' : '') . strval($total_min);
        $total_cent = number_format($total_heure + ($total_min / 60), 2);
        return ['total' => $total, 'total_cent' => $total_cent];
    }

    public function ajoutProfil()
    {
        $sqlQuery = 'INSERT INTO profil (nom, prenom, email) values (:nom, :prenom, :email)';
        $enregistrement = $this->dbh->prepare($sqlQuery);
        return $enregistrement->execute([
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'email' => $this->email
        ]);
    }

    public function afficherProfil()
    {
        $sqlQuery = 'SELECT P.idUser, P.nom, P.prenom
        from profil as P';
        $enregistrement = $this->dbh->prepare($sqlQuery);
        $return = $enregistrement->execute();
        if ($return) {
            return $enregistrement->fetchAll(PDO::FETCH_OBJ);
        }
        return false;
    }

    public function supprimerProfil($profil)
    {
        $sqlQuery = 'DELETE FROM profil as P
        where P.idUser = :supp';
        $enregistrement = $this->dbh->prepare($sqlQuery);
        return $enregistrement->execute(['supp' => $profil]);
    }

    // affiche la liste des profils et renomme ou pas le name du <select> de l'idUser
    //(pour éviter les doublons dans une même page)
    public function afficheListeProfil($name = "idUser")
    {
        $Work = new Work();
        $data = $Work->afficherProfil();
        $html = '<select name="' . $name . '" id="" required><option value="">--Sélectionner un nom--</option>';
        if ($data) {
            foreach ($data as $user) {
                $html .= '<option value="' . $user->idUser . '">' . $user->nom . ' ' . $user->prenom . '</option>';
            }
        }
        $html .= '</select>';
        return $html;
    }

    public function totalByMois($idUser, $month)
    {
        $sqlQuery = 'SELECT P.nom, P.prenom, date_format(T.date, "%M") as mois, SUM(T.total_cent) as total_cent_mois
        from travail as T natural join profil as P
        where idUser = :id and date_format(T.date, "%Y-%m")= :mois';
        $enregistrement = $this->dbh->prepare($sqlQuery);
        $return = $enregistrement->execute(['id' => $idUser, 'mois' => $month]);
        if ($return) {
            return $enregistrement->fetchAll(PDO::FETCH_OBJ);
        }
        return false;
    }

    // renvoie en heure une valeur décimale reçue en paramètre
    public function convertitDecimalHeure($val)
    {
        if (!strpos(strval($val), ".")) {
            return $val . ":00";
        } else {
            list($h1, $m1) = explode('.', $val);
            $m1 = "0." . $m1;
            $th = number_format((float)$m1 * 60, 0);
            return $h1 . ":" . ($th < 10 ? '0' : '') . $th;
        }
    }

    public function supprimerEnregistrement($idUser, $date, $heure_deb, $heure_fin)
    {
        $sqlQuery = 'DELETE FROM travail as T
        where T.idUser = :id and T.date = :date and T.heure_deb = :hd and T.heure_fin = :hf';
        $enregistrement = $this->dbh->prepare($sqlQuery);
        return $enregistrement->execute([
            'id' => $idUser,
            'date' => $date,
            'hd' => $heure_deb,
            'hf' => $heure_fin
        ]);
    }
}
