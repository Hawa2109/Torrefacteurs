<?php
require_once('inc/config.inc.php');


// session_start();
if (isset($_SESSION['client'])) { // si une session existe avec un identiafaint user je me redérige vers la page de profile

    header("location:profile.php");
}
$message = "";

// On va vérifier le formulaire
// debug($_POST);
if (!empty($_POST)) {
    // On vérifie si un champs est vide 

    $verification = true;
    foreach ($_POST as $key => $value) {

        if (empty(trim($value))) {

            $verification = false;
        }
    }

    if ($verification === false) {

        $message = error("Veuillez renseigner tout les champs", "danger");
    } else{
        // On va vérifier si les champs sont valides
        
        if (!isset($_POST['lastName']) || strlen(trim($_POST['lastName'])) < 2 || strlen(trim($_POST['lastName'])) > 50) {

            $message .= error("Le champ nom n'est pas valide", "danger");
        }

        if (!isset($_POST['firstName']) || strlen(trim($_POST['firstName'])) > 50) {


            $message .= error("Le champ prénom n'est pas valide", "danger");
        }

        if (!isset($_POST['pseudo']) ||  strlen(trim($_POST['pseudo'])) < 3 || strlen(trim($_POST['pseudo'])) > 50) {

            $message .= error("Le champ pseudo n'est pas valide", "danger");
        }


        if (!isset($_POST['email']) ||  strlen(trim($_POST['email'])) < 5 || strlen(trim($_POST['email'])) > 100 || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {

            $message .= error("Le champ email n'est pas valide", "danger");
        }

        $regexMdp = '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';

        if (!isset($_POST['mdp']) || !preg_match($regexMdp, $_POST['mdp'])) {

            $message .= error("Le mot de passe n'est pas valide", "danger");
        }

        if (!isset($_POST['confirmMdp']) || $_POST['mdp'] !== $_POST['confirmMdp']) {

            $message .= error("La confirmation et le mot de passe doivent être identiques", "danger");
        }

        if (!isset($_POST['civility']) || !in_array($_POST['civility'], ['f', 'h'])) {

            $message .= error("La civilité n'est pas valide", "danger");
        }

        $year1 = ((int) date('Y')) - 13; // 2012
        $year2 = ((int) date('Y')) - 90; // 1935

        $birthdayYear = explode('-', $_POST['birthday']);
        // var_dump((int) $birthdayYear[0]);

        if (!isset($_POST['birthday']) ||  (int)$birthdayYear[0] > $year1  ||  (int)$birthdayYear[0] < $year2) {
            // 1989 > 2012         &&            1989 < 1935
            $message .= error("La date de naissance n'est pas valide", "danger");
        }
        if (!isset($_POST['address']) || strlen(trim($_POST['address'])) < 5 ||  strlen(trim($_POST['address'])) > 50) {

            $message .= error("L'adresse n'est pas valide", "danger");
        }

        if (!isset($_POST['zip']) || !preg_match('/^[0-9]{5}$/', $_POST['zip'])) {

            $message .= error("Le code postal n'est pas valide", "danger");
        }


        if (!isset($_POST['country']) ||  strlen(trim($_POST['country'])) < 5 || strlen(trim($_POST['country'])) > 50 || preg_match('/[0-9]/', $_POST['country'])) {

            $message .= error("Le champ pays n'est pas valide", "danger");
        }
        if (empty($message)) {
            // Je récupère les données du formulaire en les stockant dans des variables

            $lastName = trim($_POST['lastName']);
            $firstName = trim($_POST['firstName']);
            $pseudo = trim($_POST['pseudo']);
            $email = trim($_POST['email']);
            $mdp = trim($_POST['mdp']);
            $civility = trim($_POST['civility']);
            $birthday = trim($_POST['birthday']);
            $address = trim($_POST['address']);
            $zip = trim($_POST['zip']);
            $country = trim($_POST['country']);

            // j'hache le mot de passe avec la fonction password_hash()
            $mdpHash = password_hash($mdp, PASSWORD_DEFAULT); 
            
            // Je vérifie si l'utilisateur existe déjà dans la BDD
            $checkEmail = checkEmailUser($email);
            $checkPseudo = checkPseudoUser($pseudo);
            $userExiste = checkUser($pseudo, $email);

            if ($checkEmail) { // si l'email existe dans la BDD

                $message = error("Ce mail n'est pas disponible", "danger");
            } elseif ($checkPseudo) { // si le pseudo existe dans la BDD

                $message = error("Ce pseudo n'est pas disponible", "danger");
            }
            if ($userExist) { // si l 'email et le pseudo correspondent au même utilisateur

                $message = error("Vous avez déjà un compte", "danger");
            } elseif (empty($message)) {

                addUser($lastName,  $firstName,  $pseudo,  $email, $mdpHash,  $civility, $birthday,  $address,  $zip, $country);
                $message = error("Vous êtes bien inscrit, vous pouvez vous connectez <a href='connexion.php' class='text-danger fw-bold'>ici</a>", 'success');
                        echo '<meta http-equiv="refresh" content="3;url=connexion.php">';

            }
        }


    }

}

require_once('inc/header.inc.php');

?>
<!-- Notre formulaire d'inscription -->
<section class="section-form container p-3 p-md-5 mt-5 shadow-lg" style="max-width: 700px;">
    <h2 class="text-center mb-4 p-3 mt-4">Créer un compte</h2>
    <form action="" method="post" class="p-0 p-md-3">
        <?php echo $message; ?>
        <div class="row mb-3">
            <div class="col-md-6 mb-4">
                <label for="lastName" class="form-label mb-2">Nom</label>
                <input type="text" class="form-control fs-5" id="lastName" name="lastName">
            </div>
            <div class="col-md-6 mb-4">
                <label for="firstName" class="form-label mb-2">Prenom</label>
                <input type="text" class="form-control fs-5" id="firstName" name="firstName">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6 mb-4">
                <label for="pseudo" class="form-label mb-2">Pseudo</label>
                <input type="text" class="form-control fs-5" id="pseudo" name="pseudo">
            </div>
            <div class="col-md-6 mb-4">
                <label for="email" class="form-label mb-2">Email</label>
                <input type="text" class="form-control fs-5" id="email" name="email" placeholder="exemple.email@exemple.com">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6 mb-4">
                <label for="mdp" class="form-label mb-2">Mot de passe</label>
                <input type="password" class="form-control fs-5" id="mdp" name="mdp" placeholder="Entrer votre mot de passe">
            </div>
            <div class="col-md-6 mb-4">
                <label for="confirmMdp" class="form-label mb-2">Confirmation mot de passe</label>
                <input type="password" class="form-control fs-5 mb-2" id="confirmMdp" name="confirmMdp" placeholder="Confirmer votre mot de passe ">
                <input type="checkbox" onclick="myFunction()"> <span class="text-black">Afficher/masquer le mot de passe</span>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6 mb-4">
                <label class="form-label mb-2">Civilité</label>
                <select class="form-select fs-5" name="civility">
                    <option value="h">Homme</option>
                    <option value="f">Femme</option>
                </select>
            </div>
            <div class="col-md-6 mb-4">
                <label for="birthday" class="form-label mb-2">Date de naissance</label>
                <input type="date" class="form-control fs-5" id="birthday" name="birthday">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12 mb-4">
                <label for="address" class="form-label mb-2">Adresse</label>
                <input type="text" class="form-control fs-5" id="address" name="address">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6 mb-4">
                <label for="zip" class="form-label mb-2">Code postale</label>
                <input type="text" class="form-control fs-5" id="zip" name="zip">
            </div>
            <div class="col-md-6 mb-4">
                <label for="country" class="form-label mb-2">Pays</label>
                <input type="text" class="form-control fs-5" id="country" name="country">
            </div>
        </div>
        <div class="inscription-btns row mt-4">
            <div class="col-12 d-grid">
                <button class="btn btn-danger btn-lg fs-5" type="submit">S'inscrire</button>
            </div>
            <p class="mt-4 text-center">Vous avez déjà un compte ? <a href="<?=CHEMIN_SITE?>connexion.php" class="text-danger">connectez-vous ici</a></p>
            <a href="https://www.economie.gouv.fr/politique-confidentialite" target="_blank" class="d-flex justify-content-center text-danger">Politique de confidentialités</a>
        </div>
    </form>
</section>


<?php
require_once('inc/footer.inc.php');
?>