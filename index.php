<?php 
require_once('inc/config.inc.php');

$message = "";
// Pour afficher les articles liés à une catégorie

// pour récupérer les catégories
$categories = allCategories(); 

require_once('inc/header.inc.php'); 
?>
<section class="hero bg-dark text-white text-center py-5 mt-5">
  <div class="div-titre container mt-4">
    <h1 class="index-titre">Bienvenue sur Torréfacteurs <br> Découvrez le meilleur café en France</h1>
    <p class="index-fisrtPara mt-3">Un site dédié à ceux qui veulent aller plus loin que le café en capsule.</p>
    <div class="index-btns gap-4 d-flex justify-content-center">
        <a href="apropos.php" class="index-btn btn btn-danger mt-5 px-3 px-md-4">En savoir plus</a>
        <!-- Si l'utilisateur n'est pas connecté, afficher le bouton d'inscription -->
        <?php if (!isset($_SESSION['client'])): ?>
            <a href="inscription.php" class="index-btn btn btn-primary mt-5 px-3 px-md-4">Rejoignez-nous !</a>
        <?php else: ?>
            <a href="profile.php" class="index-btn btn btn-primary mt-5 px-3 px-md-4">Mon profil</a>
        <?php endif; ?>
    </div>
  </div>
</section>

<form action="recherche.php" method="GET" class="d-flex mt-5 mx-auto" style="width: min(90%, 500px);" role="search">
    <input class="form-control me-2" type="search" name="cle" placeholder="Rechercher un article..." aria-label="Search">
    <button class="Profil-btn btn btn-outline-success px-3" type="submit">Rechercher</button>
</form>

<section class="articles container my-5">
  <div class="container mt-5 mb-5">
    <h2 class="text-center mb-4 text-black">Nos derniers articles</h2>
    <div class="row">
      <?php
            $articles = lastValidatedArticles(); // Récupère les 6 derniers articles validés
      foreach ($articles as $article) {
        $favCount = getFavoriteCount($article['id_article']);
          ?>
          <div class="col-lg-4 col-md-6 col-sm-12 mb-4 d-flex">
            <div class="article-card article card flex-fill">
                  <img src="<?= CHEMIN_SITE ?>assets/img/<?= $article['photo'] ?>" class="card-img-top" alt="<?= $article['titre'] ?>">
                  <div class="article_carte card-body d-flex flex-column justify-content-between">
                      <h5 class="card-title text-center"><?= $article['titre'] ?></h5>
                      <p class="card-text"><?= substr($article['contenu'], 0, 100) ?>...</p>
                        <p class="card-text text-muted"><strong> Publié le  :</strong> <?= date('d/m/Y', strtotime($article['date_publication'])) ?></p>
                        <p class="card-text text-muted"><strong>Par :</strong> <?= $article['pseudo'] ?></p>
                        <div class="Boutons d-flex justify-content-between align-items-center mt-2">
                          <a href="article.php?id=<?= $article['id_article'] ?>" class="article-btn btn btn-primary">Voir plus</a>
                           <?php if (isset($_SESSION['client'])): ?>
                                <a href="#" class="btn btn-brown me-2 fav-btn fs-5" data-id="<?= $article['id_article'] ?>">
                                    <i class="bi bi-suit-heart<?= isFavorite($_SESSION['client']['id_user'], $article['id_article']) ? '-fill heart favori' : ' heart' ?>"></i>
                                    <span class="fav-count"><?= $article['nb_favoris'] ?? 0 ?></span>
                                </a>
                            <?php endif; ?>
                        </div>
                  </div>
              </div>
            </div>
          <?php
      }
      ?>
    </div>
    <div class="text-center py-3">
      <a href="blog.php" class="index-btn btn btn-primary fw-bold fs-4">Tous les articles</a>
    </div>
  </div>
</section>

<section class="col-sections container my-5 text-center">
  <h3 class="text-center titre">Pourquoi Terréfacteurs ?</h3>
  <div class="row mt-4">
    <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
      <img src="assets/img/Torre-Locaux.JPG" class="div-image img-fluid" alt="image d'illustration">
      <h5 class="titre mt-3">Torréfacteurs locaux</h5>
      <p>Des artisans passionnés, partout en France.</p>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
      <img src="assets/img/coffee-4.jpg" class="div-image img-fluid" alt="image d'illustration">
      <h5 class="titre mt-3">Traçabilité</h5>
      <p>Des cafés sourcés éthiquement.</p>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
      <img src="assets/img/coffee-5.jpg" class="div-image img-fluid" alt="image d'illustration">
      <h5 class="titre mt-3">Communauté</h5>
      <p>Partagez vos coups de cœur et vos avis.</p>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
      <img src="assets/img/coffee-com-1.jpg" class="div-image img-fluid" alt="image d'illustration">
      <h5 class="titre mt-3">Découverte</h5>
      <p>Des profils aromatiques uniques à explorer.</p>
    </div>
  </div>
</section>

<?php 
require_once('inc/footer.inc.php'); 
?>