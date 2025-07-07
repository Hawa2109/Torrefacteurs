<?php
require_once '../inc/config.inc.php';

$message = "";

// vérification des champs du formulaire et modification d' un événement
if (!empty($_POST)) {
    $verification = true;

    foreach ($_POST as $key => $value) {
        if (empty(trim($value))) {
            $verification = false;
        }
    }

    if ($verification === false) {
        $message = error("Veuillez renseigner tous les champs", "danger");
    } else {
        // On va vérifier si les champs sont valides
        if (!isset($_POST['titre']) || strlen(trim($_POST['titre'])) < 2 || strlen(trim($_POST['titre'])) > 50) {
            $message .= error("Le champ titre n'est pas valide", "danger");
        }

        if (!isset($_POST['description']) ||  strlen(trim($_POST['description'])) < 50) {
            $message .= error("Le champ description n'est pas valide", "danger");
        }

        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $fileInfo = pathinfo($_FILES['image']['name']);
            $extension = strtolower($fileInfo['extension']);
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

            if (in_array($extension, $allowedExtensions)) {
                $image = uniqid() . '.' . $extension;
                move_uploaded_file($_FILES['image']['tmp_name'], "../assets/img/$image");
            } else {
                $message .= error("Le fichier doit être une image valide (jpg, jpeg, png, gif).", "danger");
            }
        }elseif (isset($event['image'])){
            $image = $event['image'];
        }

        if (empty($message)) {
            $titre = htmlspecialchars($_POST['titre'], ENT_QUOTES, 'UTF-8');
            $description = htmlspecialchars($_POST['description'], ENT_QUOTES, 'UTF-8');
            $date = htmlspecialchars($_POST['date'], ENT_QUOTES, 'UTF-8');
            $lieu = htmlspecialchars($_POST['lieu'], ENT_QUOTES, 'UTF-8');
            $prix = htmlspecialchars($_POST['prix'], ENT_QUOTES, 'UTF-8');
            $nombre_places = htmlspecialchars($_POST['nombre_places'], ENT_QUOTES, 'UTF-8');

            // On va vérifier si l'événement existe déjà
            $event = getEventByName($titre);
            if ($event) {
                $message .= error("L'événement existe déjà", "danger");
            } else {
                // Je sauvegarde l'événement dans la base de données
                if (isset($_GET['action']) && $_GET['action'] == 'update' && isset($_GET['id_event'])) {
                    $id_event = htmlspecialchars($_GET['id_event']);
                    updateEvent($titre, $description, $date, $lieu, $image, $prix, $nombre_places, $id_event);
                    header('location:evenements.php');
                } else {
                    // Je sauvegarde l'événement dans la base de données
                    addEvent($titre, $description, $date, $lieu, $image, $prix, $nombre_places);
                    $message .= error("L'événement a été créé avec succès.", "success");
                    echo '<meta http-equiv="refresh" content="3;url=evenements_list.php">';
                }
            }
            

            
        }
    }
}



require_once '../inc/header.inc.php';
?> 
<!-- Bannière d'administration avec design moderne -->
<section class="admin-header text-white py-5 mt-5 position-relative">
    <div class="floating-elements"></div>
    <div class="container content">
        <div class="text-center">
            <div class="welcome-icon mb-3">
                <i class="bi bi-calendar-event" style="font-size: 3rem; color: #d7bda6;"></i>
            </div>
            <h2 class="mb-3">Bienvenue <?= $_SESSION['client']['pseudo'] ?></h2>
            <p class="lead mb-0">
                <i class="bi bi-gear-fill me-2" style="color: #d7bda6;"></i>

                Création d'événements
                <i class="bi bi-gear-fill me-2" style="color: #d7bda6;"></i>
                
            </p>
        </div>
    </div>
</section>

<!-- la page de création d'événements -->
<section class="container mt-5 mb-5">
    <h2 class="text-center mt-5 mb-4 text-black">Créer un événement sur torréfacteurs</h2>
    <div class="container mb-5">
    <div class="admin-card p-4">
        <h2 class="page-title text-center mb-4 text-black">
            <?= isset($_GET['action']) && $_GET['action'] == 'update' ? 'Modifier un événement' : 'Créer un événement' ?>
        </h2>
        <form action="" method="POST" class="w-75 mx-auto" enctype="multipart/form-data">
            <?php echo $message; ?>
            <div class="mb-3">
                <label for="titre" class="form-label fw-bold">Titre de l'événement</label>
                <input type="text" name="titre" id="titre" class="form-control" value="<?= $event['titre'] ?? '' ?>">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label fw-bold">Description de l'événement</label>
                <textarea name="description" id="description" rows="5" class="form-control"><?= $event['description'] ?? '' ?></textarea>
            </div>
            <div class="mb-3">
                <label for="date" class="form-label fw-bold">Date de l'événement</label>
                <input type="date" name="date" id="date" class="form-control" value="<?= $event['date'] ?? '' ?>">
            </div>
            <div class="mb-3">
                <label for="lieu" class="form-label fw-bold">Lieu de l'événement</label>
                <input type="text" name="lieu" id="lieu" class="form-control" value="<?= $event['lieu'] ?? '' ?>">
            </div>
            <div class="mb-3">
                <label for="image" class="form-label fw-bold">Ajouter une image</label>
                <input type="file" name="image" id="image" class="form-control">
                <?php if (isset($event['image']) && !empty($event['image'])): ?>
                    <img src="../assets/img/<?= $event['image'] ?>" alt="Image de l'événement" class="img-thumbnail mt-2" width="100">
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="prix" class="form-label fw-bold">Prix de l'événement</label>
                <div class="input-group">
                    <input type="text" name="prix" id="prix" class="form-control" value="<?= $event['prix'] ?? '' ?>">
                    <span class="input-group-text">£</span>
                </div>
            </div>
            <div class="mb-3">
                <label for="nombre_places" class="form-label fw-bold">Nombre de places disponibles</label>
                <input type="number" name="nombre_places" id="nombre_places" class="form-control" value="<?= $event['nombre_places'] ?? '' ?>">
            </div>
            <div class="d-flex justify-content-center">
                <button type="submit" class="article-btn btn btn-danger">
                    <?= isset($_GET['action']) && $_GET['action'] == 'update' ? 'Modifier l\'événement' : 'Créer l\'événement' ?>
                </button>
            </div>
        </form>
    </div>
</div>
</section>



<?php
require_once '../inc/footer.inc.php';
?>