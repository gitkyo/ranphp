<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    



    
    <!-- l'attribut action me permet de définir l'url de redirection suite à la soumission du formulaire -->
    <!-- Methode Get pour passer les parametres dans l'url -->
    <!-- methode Post pour que ce soit transparent -->
    <p>Ceci est du HTML avec une logique en php : </p>
    <form action="" method="post">

        <label for="name">name</label> <br>
        <input id="name" type="text" name="prenom">

        <br>
        <br>
        <br>

        <label for="birthDate">Date de naissance 'Y-m-d'</label> <br>
        <input id="birthDate" type="text" name="birthDate">

        <br>
        <br>
        <input type="submit" value="envoyer">

    </form>


    <?php
        //ceci est du php interpréter par le serveur qui nous renvoi une réponse en html



        // exemple de définition de fonction pour calculer l'age en fonction de la date de naissance, elle est appelé plus loin dans le code
        function calculAge($birthDate) {
            $age = intval(date('Y-m-d')) - intval($birthDate);
            return $age;
        }



        //on se connect a mysql en local
        $db = new PDO('mysql:host=localhost;dbname=testphp;charset=utf8', 'root', '');

        // Si il existe des variable post avec les valeurs prénom et age alors
        if(isset($_POST['prenom']) && isset($_POST['birthDate'])){

            //on récupere les valeurs dans des variables
            $prenom = $_POST['prenom'];
            $birthDate = $_POST['birthDate'];

            //calcul de l'age, j'appele ma fonction calculAge que j'ai codé un peu plus haut
            $age = calculAge($birthDate);       
  

            // on écrit notre requette
            $req = $db->prepare('INSERT INTO users(prenom, age) VALUES(:prenom, :age)');
           

            //on execute la requette
            $req->execute(array(
                'prenom' => $prenom,
                'age' => $age
            ));
            
      
            //on affiche le résultat
            print("<p>coucou $prenom, tu as $age ans</p>");
         

        }

        // ici on affiche des données depuis le bdd

        //on ecrit notre requette pour calculer le nombre d'utilisateurs en bdd
        $req = $db->query('SELECT COUNT(DISTINCT id) FROM users');

        //on execute la requette et récupere le résultat
        $nbUsers = $req->fetch();

        //on affiche le résultat
        print('le nombre d utilisateur dans ma bdd : ' . $nbUsers[0]);

    ?>
   

    <script>
        //ceci est du javascript executé coté client
    
        var prenom = "pierre";         

        document.write("<p>coucou " + prenom + " ceci est écrit en JS</p>");

    </script>

</body>
</html>