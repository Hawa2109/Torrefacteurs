<?php
require_once('inc/config.inc.php');

$message = "";
// Pour supprimer un événement
if (isset($_GET['action']) && $_GET['action'] == "delete" && isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int)$_GET['id']; // Convertir en entier pour éviter les erreurs
    // Suppression de l'événement
    deleteEvent($id);
    $message .= error("L'événement a été supprimé avec succès", "success");
    header('location:evenements.php');
} elseif (isset($_GET['action']) && $_GET['action'] == "delete") {
    $message .= error("Identifiant de l'événement manquant ou invalide", "danger");
}

// Pour réserver un événement via un lien
if (isset($_GET['action']) && $_GET['action'] === 'book' && isset($_GET['id'])) {
    $event_id = (int)$_GET['id'];

    // Vérifiez si l'utilisateur est connecté
    if (!isset($_SESSION['client'])) {
        $message = "Vous devez être connecté pour réserver.";
    } else {
        $user_id = $_SESSION['client']['id_user'];

        // Vérifiez si les données POST existent
        $nom = $_POST['nom'] ?? null;
        $email = $_POST['email'] ?? null;

        if ($nom && $email) {
            // Ajoutez la réservation
            addReservation($user_id, $event_id, $nom, $email);
            $message = "Réservation effectuée avec succès.";
        } else {
            $message = "Veuillez remplir tous les champs.";
        }
    }
}

// Validation du formulaire de réservation d'événement
if (!empty($_POST)) {
    // On vérifie si un champs est vide 

    $verification = true;
    foreach ($_POST as $key => $value) {

        if (empty(trim($value))) {

            $verification = false;
        }      
    }  if ($verification === false) {

        $message = error("Veuillez renseigner tout les champs", "danger");
    }else {
        // On va vérifier si les champs sont valides
        if (!isset($_POST['nom']) || strlen(trim($_POST['nom'])) < 2 || strlen(trim($_POST['nom'])) > 50) {
            $message .= error("Le champ nom n'est pas valide", "danger");
        }

        if (!isset($_POST['email']) || strlen(trim($_POST['email'])) < 5 || strlen(trim($_POST['email'])) > 100 || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $message .= error("Le champ email n'est pas valide", "danger");
        }

        if (!isset($_POST['evenement']) || empty(trim($_POST['evenement']))) {
            $message .= error("Veuillez sélectionner un événement", "danger");
        }else {
            // Insérer la réservation
            $user_id = $_SESSION['client']['id_user']; // ID de l'utilisateur connecté
            $event_id = (int)$_POST['evenement']; // ID de l'événement sélectionné
            addReservation($user_id, $event_id, $_POST['nom'], $_POST['email']);
            $message = error("Votre réservation a été enregistrée avec succès", "success");
        }
    }
} 




require_once('inc/header.inc.php');
?>

<!-- On va mettre une bannière -->
<section class="hero bg-dark text-white text-center py-5 mt-5">
  <div class="div-titre container mt-4">
    <h1 class="index-titre">Les événements à découvrir</h1>
    <p class="index-fisrtPara mt-3">Un site dédié à ceux qui veulent aller plus loin que le café en capsule.</p>
    <div class="index-btns gap-4 d-flex justify-content-center">
        <a href="#reservation-section" class="index-btn btn btn-primary mt-5">Réservez un événement !</a>
    </div>
  </div>
</section>
<!-- on va afficher nos événements ici -->
<div class="section-event container mt-5 mb-5">
    <h2 class="text-center mb-4 text-black">Voici nos événements</h2>
    <div class="row">
        <?php
        // On va afficher les événements ici
        $events = allEvents();
        foreach ($events as $event) {
            ?>
            <div class="col-md-4 mb-4">
                <div class="event-card card">
                    <img src="<?= CHEMIN_SITE ?>assets/img/<?= $event['image'] ?>" class="card-img-top" alt="<?= $event['titre'] ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= $event['titre'] ?></h5>
                        <p class="card-text"><?= substr($event['description'], 0, 100) ?>...</p>
                        
                        
                        <!-- Condition pour afficher ces bouton uniquement si l'utilisateur est connecter et qu'il est admin -->
                        <div class="d-flex flex-wrap justify-content-between mt-3">
                                <a href="events_details.php?id=<?= $event['id_event'] ?>" class="article-btn event-btn btn btn-primary mb-2">Voir les détails</a>

                                <?php if (isset($_SESSION['client']) && $_SESSION['client']['role'] == "ROLE_ADMIN"): ?>
                                    <a href="evenements.php?action=delete&id=<?= $event['id_event'] ?>" class="event-btn btn btn-danger mb-2" onclick="return(confirm('Êtes-vous sûr de vouloir supprimer ?'))">Supprimer</a>
                                <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
       
</div>

<!-- pour réserver un événement -->
<section class="container mt-5 mb-5" id="reservation-section">
    <h2 class="text-center mt-5 mb-4 text-black">Réserver un événement</h2>
    <form action="#" method="POST" class="container mt-5 mb-5">
        <?= $message; ?>
        <div class="mb-3">
            <label for="nom" class="form-label fw-bold">Nom</label>
            <input type="text" id="nom" name="nom" class="form-control">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label fw-bold">Email</label>
            <input type="email" id="email" name="email" class="form-control">
        </div>
        <div class="mb-3">
            <label for="evenement" class="form-label fw-bold">Événement</label>
            <select id="evenement" name="evenement" class="form-control">
                <option value="">Sélectionnez un événement</option>
                <?php
                // On va afficher les événements ici
                $events = allEvents();
                foreach ($events as $event) {
                    echo "<option value='{$event['id_event']}'>{$event['titre']}</option>";
                }
                ?>
            </select>
        </div>
        <div class="text-center">
            <button type="submit" class="article-btn btn btn-danger">Réserver</button>
        </div>
    </form>
</section>


<?php
require_once('inc/footer.inc.php');
?>