<?php
require_once('inc/config.inc.php');



require_once 'inc/header.inc.php';
?>
<section class="mt-5">
    <div class="hero bg-dark text-white text-center py-5 mt-5">
        <div class="div-titre container mt-4">
            <h1 class="detail-titre">Explorez la richesse du café artisanal</h1>
            <p class="mt-3">Un site dédié à ceux qui veulent aller plus loin que le café en capsule.</p>
            <div class="gap-4 d-flex justify-content-center mt-4">
                <a href="<?= CHEMIN_SITE ?>creat_articles.php" class="detail-btn btn btn-danger mt-3">Créer un article</a>
                <a href="evenements.php" class="detail-btn btn btn-danger mt-3">En savoir plus</a>

            </div>
        </div>
    </div>
</section>
<!-- On affiche un evénement ici -->
<div class="container mt-5 mb-5">
    <h2 class="text-center mb-4 text-black">Bienvenue sur la page des événements</h2>
    <div class="row">
        <?php
        // On va afficher l'événement ici
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $event = showEventById($id);
            if ($event) {
                ?>
                <div class="col-md-6">
                    <img src="<?= CHEMIN_SITE ?>assets/img/<?= $event['image'] ?>" class="single-art-img card-img-top" alt="<?= $event['titre'] ?>">
                </div>
                <div class="col-md-6">
                    <h5 class="mb-4 text-center fs-3"><?= $event['titre'] ?></h5>
                    <p class="card-text"><?= $event['description'] ?></p>
                    <p class="card-text"><strong>Publié le :</strong><small class="text-muted"> <?= date('d/m/Y', strtotime($event['date_event'])) ?></small></p>
                    <p class="card-text"><strong>Prix :</strong><small class="text-muted"> <?= $event['prix'] ?> €</small></p>
                    <p class="card-text"><strong>Nombre de places :</strong><small class="text-muted"> <?= $event['nombre_places'] ?></small></p>
                    <div class="mt-4">
                        <a href="<?= CHEMIN_SITE ?>evenements.php" class="article-btn btn btn-primary">Retour</a>
                        <!-- On affiche le bouton réserver uniquement si l'utilisateur est connecté -->
                        <?php if (isset($_SESSION['client'])): ?>
                            <a href="<?= CHEMIN_SITE ?>evenements.php?action=book&id=<?= $event['id_event'] ?>" class="article-btn btn btn-primary">Réserver</a>
                          <!--  <a href="evenements.php" class="article-btn btn btn-primary">Réserver</a> -->
                        <?php endif; ?>
                        <!-- On affiche les bouton modifier et supprimer quanq on est connecté -->
                        <?php if (isset($_SESSION['client']) && $_SESSION['client']['role'] == "ROLE_ADMIN") { ?>
                            <a href="<?= CHEMIN_SITE ?>evenements.php?action=delete&id=<?= $event['id_event'] ?>" class="btn btn-danger" onclick="return(confirm('Êtes-vous sûr de vouloir supprimer cet événement ?'))">Supprimer</a>
                        <?php } ?>
                    </div>
                </div>  
                <?php
            } else {    
                echo "<div class='alert alert-danger'>Événement introuvable</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Aucun événement sélectionné</div>";
        }
        ?>
    </div>
</div>



<?php require_once 'inc/footer.inc.php'; ?>