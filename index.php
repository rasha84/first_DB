<?php

    $hostname='localhost';
    $username='root';
    $password='stagiaire';
    $dbname = 'csv';

    try
    {
        $conn = new PDO('mysql:host='.$hostname.';dbname='.$dbname.';charset=utf8', $username, $password);
    }
    catch(Exception $e)
    {
            die('Erreur : '.$e->getMessage());
    }


    //1) Afficher tous les gens dont le nom est palmer
    echo '<h3> Afficher les gens dont le noms est palmer</h3>';
    $reponse1 = $conn->query('SELECT * FROM users WHERE last_name = "palmer"');
    while ($donnees = $reponse1->fetch())
    {
        echo $donnees['first_name'].'_'.$donnees['last_name'].'<br>';
    }
    $reponse1->closeCursor();
    echo '<br>';


    //2) Afficher toutes les femmes
    echo '<h3> Afficher toutes les femmes </h3>';
    $reponse2 = $conn->query('SELECT first_name , last_name, gender FROM users WHERE gender = "female"');
    while ($donnees = $reponse2->fetch())
    {
        echo $donnees['first_name'] .'_'. $donnees['last_name'].'_'.$donnees['gender'].'<br>';
    }
    $reponse2->closeCursor();
    echo '<br>';


    //3) Tous les états dont la lettre commence par N
    echo '<h3> Afficher tous les états dont la lettre commence par N </h3>';
    $reponse3 = $conn->query('SELECT * FROM users WHERE country_code LIKE "N%"');
    while ($donnees = $reponse3->fetch())
    {
        echo $donnees['first_name'] .'_'. $donnees['last_name'].'_'.$donnees['country_code'].'<br>';
    }
    $reponse3->closeCursor();
    echo '<br>';


    //4) Tous les emails qui contiennent google
    echo '<h3> Afficher tous les emails qui contiennent google</h3>'; 
    $reponse4 = $conn->query('SELECT first_name, last_name, email FROM users WHERE email LIKE "%google%"');
    while($donnees = $reponse4->fetch())
    {
        echo $donnees['first_name'].' '.$donnees['last_name'].' '.$donnees['email'].'<br>';
    }

    $reponse4->closeCursor();
    echo '<br>';


    //5) Répartition par Etat et le nombre d’enregistrement par état (croissant)
    echo '<h3> Repartition par Etat et le nombre d\'enregistrement par état</h3>';
    $reponse5 = $conn->query('SELECT DISTINCT country_code, COUNT(*) AS Number FROM users GROUP BY country_code ORDER By COUNT(*) ASC');
    while($donnees = $reponse5->fetch())
    {
        echo $donnees['country_code'].' '.$donnees['Number'].'<br>'; 
    }


    //6) Insérer un utilisateur, lui mettre à jour son adresse mail puis supprimer l’utilisateur.
    echo '<h3> Insérer un utilisateur, lui mettre à jour son addresse mail puis supprimer l\'utilisateur </h3>';
    $f_name = 'rasha';
    $l_name = 'salman';
    $e_mail = 'rasha.slman84@gmail.com';
    $id = 1001;
    $sql = "INSERT INTO users (id,first_name, last_name, email, gender) VALUES (1001,'rasha','salman','rasha.slman84@gmail.com','female')";
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    // suprimer un utilisateur
    $sql1 = "DELETE FROM users WHERE id = 1001";
    if ($conn->query($sql1) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
    echo '<br>';

    //7) Nombre de femme et d’homme
    echo '<h3> Nombre de femme et d\'homme</h3>';
    $howManyWomen_query = $conn->query("SELECT COUNT(id) AS NumberOfWomen FROM users WHERE gender = 'female'");
    $howManyWomen = $howManyWomen_query->fetch();
    echo 'Number Of Women is '.$howManyWomen[0];
    echo '<br>';

    $howManyMen_query = $conn->query("SELECT COUNT(id) AS NumberOfMen FROM users WHERE gender = 'male'");
    $howManyMen = $howManyMen_query->fetch();
    echo 'Number Of Men is '.$howManyMen[0];
    echo '<br>';


    //8) Afficher Age de chaque personne, puis la moyenne d’âge des femmes et des hommes
    echo '<h3>Afficher l\'age de chaque personne</h3>';
    $now = time();
    $birth_array = $conn->query("SELECT first_name, last_name, birth_date FROM users");
    while($donnees = $birth_array->fetch())
    {
        $dob = strtotime($donnees['birth_date']);
        $difference = $now - $dob;
        $age = floor($difference / 31556926);
        echo $donnees['first_name'].' '.$donnees['last_name'].' '.$age.'<br>';
    }
    $birth_array->closeCursor();
    echo '<br>';




    //9) Créer deux nouvelles tables, une qui contient l’ensemble des membres de l’ACS, l’autre qui contient les département avec numéros et nom écrit.
        //Afficher le nom de chaque apprenant avec son département de résidence.




    //10) Afficher le résultat du 9) dans une page php (utiliser PDO pour la connexion)

?> 