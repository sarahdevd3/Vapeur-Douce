<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet">
    <title>Document</title>
</head>
<header><img class="img"
     src="https://cdn.pixabay.com/photo/2020/04/23/14/06/dim-sum-5082653__340.jpg"><img class="img2"
     src="https://cdn.pixabay.com/photo/2020/04/23/14/06/dim-sum-5082653__340.jpg"> </header>
<body>
<?php
    
    
   
    $recherche = htmlspecialchars($_POST['recherche'], ENT_QUOTES);// sécurisation des lignes de caractères
    $recherche = urlencode($recherche);
    $recherche = strtolower($recherche);// tout en minuscules
    $recherche = ucwords($recherche); 
    

   
   $curl = curl_init();
   curl_setopt_array($curl, [ // paramétrage de la session curl
        CURLOPT_URL => "https://api.hmz.tf/?id=".$recherche, //récupère l'url 
        CURLOPT_RETURNTRANSFER => true, // retourne une chaine de caractère
        CURLOPT_TIMEOUT => 1, //durée d'attente avant réponse du serveur
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1, // force l'http/1.1
        ]);
     

    $data = curl_exec($curl);
    $data = json_decode($data, true);
    $nom = $data['message']['nom'];
    $cuisson = $data['message']['vapeur']['cuisson'];
    $trempage = $data['message']['vapeur']['trempage'];
    $niveaudeau = $data['message']['vapeur']['niveau d\'eau'];

    if ($data[status]===error){                                 // Condition pour afficher message d'erreur pour aliment absent
        echo "<div class='error'>",'Oups!</br>Nous n\'avons pas cet aliment en stock';"<div>";
    } 
    elseif( array_key_exists( "trempage",$data ['message']['vapeur'])) {
        echo "Le temps de cuisson de $nom  est de $cuisson le temps de trempage est de $trempage avec un niveau d'eau de $niveaudeau" ;
    }
    else echo "<div class='resultat'>",
    "Le temps de cuisson de $nom  est de $cuisson ";
    echo "</div>";

    curl_close($curl);

?>
</body>

<footer>
   </footer>
</html>



