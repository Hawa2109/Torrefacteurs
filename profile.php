<?php
require_once 'inc/config.inc.php';

if (!isset($_SESSION['client'])) {
    header("location:connexion.php");
}

require_once 'inc/header.inc.php';

$favorites = getFavoriteArticlesByUser($_SESSION['client']['id_user']);

// Gestion du bouton "Voir tout"
$voirTout = isset($_GET['voir_tout']) && $_GET['voir_tout'] == 1;
if ($voirTout) {
    $articles = getArticleByUser($_SESSION['client']['id_user']);
} else {
    $articles = getLastThreeArticlesByUser($_SESSION['client']['id_user'], 3);
}

// Gestion du bouton "Voir toutes mes réservations"
$voirToutReservations = isset($_GET['voir_tout_resa']) && $_GET['voir_tout_resa'] == 1;
if ($voirToutReservations) {
    $reservations = getReservationByUser($_SESSION['client']['id_user']);
} else {
    $reservations = getLastThreeReservationsByUser($_SESSION['client']['id_user'], 3);
}

// Gestion du bouton "Voir tous mes favoris"
$voirToutFavoris = isset($_GET['voir_tout_fav']) && $_GET['voir_tout_fav'] == 1;
if ($voirToutFavoris) {
    $favorites = getFavoriteArticlesByUser($_SESSION['client']['id_user']);
} else {
    $favorites = getLastThreeFavoritesByUser($_SESSION['client']['id_user'], 3);
}
?>

<!-- Hero Section -->
<section class="hero-section text-white text-center">
    <div class="div-titre container mt-5">
        <h1 class="display-4 fw-bold">Bienvenue, <?= $_SESSION['client']['pseudo'] ?> 
            <?php if ($_SESSION['client']['role'] == "ROLE_ADMIN"): ?>
                    <i class="bi bi-award-fill text-warning fs-1" title="Administrateur"></i>
            <?php endif; ?>
        </h1>
        <p class="lead">Votre espace personnel</p>
        <a href="blog.php" class="btn btn-light px-4 py-2 mt-3">Découvrir nos publications</a>
    </div>
</section>

<!-- Profile Section -->
<div class="container">
    <div class="row">
        <div class="col-lg-10 col-md-12 mx-auto">
            <div class="profile-card">
                <div class="row">
                    <div class="col-md-4 text-center profile-header">
                        <img src="<?= CHEMIN_SITE ?>assets/img/<?= $_SESSION['client']['civility'] == 'f' ? 'Icone_f.png' : 'Icone_h.jpg' ;?>" alt="Avatar" class="profile-avatar mb-3">
                        <h3 class="fw-bold"><?= strtoupper($_SESSION['client']['pseudo']) ?></h3>
                        <span class="badge bg-secondary"><?= $_SESSION['client']['role'] ?></span>
                    </div>
                    <div class="col-md-8 profile-info">
                        <h4 class="section-title">Informations personnelles</h4>
                        <p><strong>Nom :</strong> <span class="text-muted"><?= $_SESSION['client']['lastName'] ?></span></p>
                        <p><strong>Prénom :</strong> <span class="text-muted"><?= $_SESSION['client']['firstName'] ?></span></p>
                        <p><strong>Email :</strong> <span class="text-muted"><?= $_SESSION['client']['email'] ?></span></p>
                        <div class="mt-4">
                            <a href="<?= CHEMIN_SITE ?>blog.php" class="profile-info-btn border border-0 btn btn-primary">Retour au blog</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Articles Section -->
<div class="container my-5">
      <div class="row">
            <div class="col-lg-6 col-md-12 mx-auto">
                  <div class="content-section">
                        <h2 class="section-title">Mes articles</h2>
                        <div class="table-responsive">
                              <table class="table table-hover">
                                    <thead>
                                    <tr>
                                          <th>Titre</th>
                                          <th>Photo</th>
                                          <th>Contenu</th>
                                          <th>Date</th>
                                          <th class="text-center">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    if (empty($articles)) {
                                          echo '<tr><td colspan="5" class="text-center">Vous n\'avez pas encore publié d\'articles.</td></tr>';
                                    } else {
                                          foreach ($articles as $article) {
                                    ?>
                                    <tr>
                                          <td class="fw-medium"><?= $article['titre'] ?></td>
                                          <td><img src="<?= CHEMIN_SITE ?>assets/img/<?= $article['photo'] ?>" alt="<?= $article['titre'] ?>" class="table-img"></td>
                                          <td class="article-content"><?= substr($article['contenu'], 0, 10) ?>...</td>
                                          <td><?= date('d/m/Y', strtotime($article['date_publication'])) ?></td>
                                          <td class="text-center">
                                                <a href="article.php?action=update&id=<?= $article['id_article'] ?>" class="action-btn edit-btn me-2" title="Modifier"><i class="bi bi-pen-fill"></i></a>
                                                <a href="article.php?action=delete&id=<?= $article['id_article'] ?>" class="action-btn delete-btn" title="Supprimer" onclick="return(confirm('Êtes-vous sûr de vouloir supprimer cet article ?'))"><i class="bi bi-trash3-fill"></i></a>
                                          </td>
                                    </tr>
                                    <?php
                                          }
                                    }
                                    ?>
                                    </tbody>
                              </table>
                        </div>
                        <?php if (!$voirTout && !empty($articles)) : ?>
                              <div class="text-center mt-3">
                                    <a href="profile.php?voir_tout=1" class="Profil-btn btn btn-outline-secondary">
                                          Voir tous mes articles
                                    </a>
                              </div>
                        <?php endif; ?>
                        <?php if ($voirTout && !empty($articles)) : ?>
                              <div class="text-center mt-3">
                                    <a href="profile.php" class="Profil-btn btn btn-outline-secondary">
                                          Voir moins d'articles
                                    </a>
                              </div>
                        <?php endif; ?>
                        <div class="text-center mt-3">
                              <a href="creat_articles.php" class="Profil-btn btn btn-outline-primary"><i class="bi bi-plus-circle me-2"></i>Ajouter un article</a>
                        </div>
                  </div>
            </div>
            <div class="col-lg-6 col-md-12 mx-auto">
                  <div class="content-section">
                        <h2 class="section-title">Mes commentaires</h2>
                        <div class="table-responsive">
                              <table class="table table-hover">
                                    <thead>
                                    <tr>
                                          <th>Article</th>
                                          <th>Date</th>
                                    <th class="text-center">voir</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $comments = getArticlesCommentedByUser($_SESSION['client']['id_user']);
                                    if (empty($comments)) {
                                          echo '<tr><td colspan="2" class="text-center">Vous n\'avez pas encore commenté d\'articles.</td></tr>';
                                    } else {
                                          foreach ($comments as $comment) {
                                    ?>
                                    <tr>
                                          <td><?= $comment['titre'] ?></td>
                                          <td><?= date('d/m/Y', strtotime($comment['date_commentaire'])) ?></td>
                                            <td class="text-center">
                                                <a href="article.php?id=<?= $comment['id_article'] ?>" class="btn btn-success btn-sm" title="Voir l'article"><i class="bi bi-eye"></i></a>
                                            </td>
                                    </tr>
                                    <?php
                                          }
                                    }
                                    ?>
                                    </tbody>
                              </table>
                        </div>
                  </div>
            </div>
      </div>
</div>

<!-- Reservations Section -->
<div class="container my-5">
      <div class="row">
        <div class="col-lg-5 col-md-12 mx-auto">
            <div class="content-section">
                <h2 class="section-title">Mes réservations</h2>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Email</th>
                                <th>Date</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $reservations = getReservationByUser($_SESSION['client']['id_user']);
                            if (empty($reservations)) {
                                echo '<tr><td colspan="4" class="text-center">Vous n\'avez pas encore effectué de réservation.</td></tr>';
                            } else {
                                foreach ($reservations as $reservation) {
                            ?>
                            <tr>
                                <td><?= $reservation['nom'] ?></td>
                                <td><?= $reservation['email'] ?></td>
                                <td><?= date('d/m/Y', strtotime($reservation['date_reservation'])) ?></td>
                                <td class="text-center">
                                    <a href="evenements.php?action=delete&id=<?= $reservation['id_reservation'] ?>" class="action-btn delete-btn" title="Supprimer" onclick="return(confirm('Êtes-vous sûr de vouloir supprimer cette réservation ?'))"><i class="bi bi-trash3-fill"></i></a>
                                </td>
                            </tr>
                            <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                  <?php if (!$voirToutReservations && !empty($reservations)) : ?>
                        <div class="text-center mt-3">
                              <a href="profile.php?voir_tout_resa=1" class="Profil-btn btn btn-outline-secondary">
                                    Voir toutes mes réservations
                              </a>
                        </div>
                        <?php endif; ?>
                        <?php if ($voirToutReservations && !empty($reservations)) : ?>
                        <div class="text-center mt-3">
                              <a href="profile.php" class="Profil-btn btn btn-outline-secondary">
                                    Voir moins de réservations
                              </a>
                        </div>
                  <?php endif; ?>
                <div class="text-center mt-3">
                    <a href="evenements.php" class="Profil-btn btn btn-outline-primary"><i class="bi bi-calendar-plus me-2"></i>Réserver un événement</a>
                </div>
            </div>
        </div>
        <div class="col-lg-7 col-md-12 mx-auto">
            <div class="content-section">
                <h2 class="section-title">Mes favoris</h2>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Titre</th>
                                <th>Photo</th>
                                <th>Date</th>
                                <th class="text-center">Voir</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (empty($favorites)) {
                                echo '<tr><td colspan="4" class="text-center">Aucun article en favori.</td></tr>';
                            } else {
                                foreach ($favorites as $fav) {
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($fav['titre']) ?></td>
                                <td><img src="<?= CHEMIN_SITE ?>assets/img/<?= htmlspecialchars($fav['photo']) ?>" alt="<?= htmlspecialchars($fav['titre']) ?>" class="table-img" style="width:60px"></td>
                                <td><?= date('d/m/Y', strtotime($fav['date_publication'])) ?></td>
                                <td class="text-center">
                                    <a href="article.php?id=<?= $fav['id_article'] ?>" class="btn btn-success btn-sm" title="Voir l'article"><i class="bi bi-eye"></i></a>
                                </td>
                            </tr>
                            <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                               <?php if (!$voirToutFavoris && !empty($favorites)) : ?>
                  <div class="text-center mt-3">
                        <a href="profile.php?voir_tout_fav=1" class="Profil-btn btn btn-outline-secondary">
                              Voir tous mes favoris
                        </a>
                  </div>
                  <?php endif; ?>
                  <?php if ($voirToutFavoris && !empty($favorites)) : ?>
                  <div class="text-center mt-3">
                        <a href="profile.php" class="Profil-btn btn btn-outline-secondary">
                              Voir moins de favoris
                        </a>
                  </div>
                  <?php endif; ?>
                </div>
       
            </div>
        </div>
    </div>
</div>



<?php
require_once "inc/footer.inc.php";
?>