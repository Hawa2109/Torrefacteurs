<?php
require_once('inc/config.inc.php');

// session_start();
if (isset($_SESSION['client'])) { // si une session existe avec un identiafaint user je me redérige vers la page de profile
    
    header("location:profile.php");
}

$message = "";

if (!empty($_POST)) {

    // On vérifie si un champs est vide 

    $verification = true;
    foreach($_POST as $key=> $value) {
    
        if(empty(trim($value))) {

            $verification = false;
        }
    }

    if (!$verification) {  // $verif === false

        $message = error("Veuillez renseigner tout les champs", "danger");

    }else{


        $pseudo = $_POST['pseudo'];
        $email = $_POST['email'];
        $mdp = $_POST['mdp'];

        $user = checkUser($pseudo,$email); 
       
        if ($user) { 
            
           // debug($user['mdp']);// mdp récupérer de la BDD

            if (password_verify($mdp,$user['mdp'])) { 

                session_start();
                $_SESSION['client'] = $user;

                header("location:profile.php");
                
            }else {

                $message = error("Les identifiants sont incorrectes", "danger");
            }           
        }else {
            
            $message = error("Les identifiants sont incorrectes", "danger");
        }
    }
  

}

require_once('inc/header.inc.php');
?>

<!-- Formulaire de connexion -->
<section class="section-form container p-3 p-md-5 mt-5 shadow-lg" style="max-width: 500px;">
    <h2 class="text-center mb-4 p-3 mt-2">Connexion</h2>

    <?php echo($message); ?>

    <form action="" method="post" class="p-0 p-md-5">
        <div class="mb-3">
            <label for="pseudo" class="form-label mb-2">Pseudo</label>
            <input type="text" class="form-control fs-5" id="pseudo" name="pseudo">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label mb-2">Email</label>
            <input type="email" class="form-control fs-5" id="email" name="email" placeholder="exemple.email@exemple.com">
        </div>
        <div class="mb-3">
            <label for="mdp" class="form-label mb-2">Mot de passe</label>
            <input type="password" class="form-control fs-5 mb-2" id="mdp" name="mdp">
            <input type="checkbox" onclick="myFunction()"> <span class="text-black">Afficher/masquer le mot de passe</span>
        </div>
        <div class="connexion-btns text-center">
            <button class="w-100 btn btn-danger btn-lg fs-6" type="submit">Se connecter</button>
            <p class="mt-4 text-center">Vous n'avez pas encore de compte ? <a href="<?=CHEMIN_SITE?>inscription.php" class="text-danger">créer un compte ici</a></p>
        </div>
    </form>
</section>
 

<?php
require_once('inc/footer.inc.php');
?>