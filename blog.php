<?php
require_once 'inc/config.inc.php';
$message = "";
$voirPlus = isset($_GET['voirplus']) && $_GET['voirplus'] == 1;
// Pour récupérer les articles par catégorie
if (isset($_GET['id'])) {
    // NE TOUCHE PAS à cette partie, tu gardes l'affichage par catégorie
    $id = $_GET['id'];
    $articles = getArticlesByCategory($id);
} else {
    // Ici tu utilises la nouvelle fonction
    if ($voirPlus) {
        // tous les articles validés
        $articles = getValidatedArticles(); 
    } else {
        // seulement les 25 derniers
        $articles = getLast25ValidatedArticles(); 
    }
}

require_once 'inc/header.inc.php';
?>

<!-- Section d'introduction -->
<section class="mt-5">
    <div class="hero bg-dark text-white text-center py-5 mt-5">
        <div class="div-titre container mt-4">
            <h1 class="blog-titre">Bienvenue sur le blog</h1>
            <p class="blog-para mt-3">Un site dédié à ceux qui veulent aller plus loin que le café en capsule.</p>
            <div class="blog-btns gap-4 d-flex justify-content-center mt-4">
                <a href="<?= CHEMIN_SITE ?>creat_articles.php" class="blog-btn btn btn-danger mt-3">Créer un article</a>
                <a href="evenements.php" class="blog-btn btn btn-outline-light mt-3">En savoir plus</a>
            </div>
        </div>
    </div>
</section>

  <form action="recherche.php" method="GET" class="d-flex mt-5 mx-auto" style="width: min(90%, 500px);" role="search">
    <input class="form-control me-2" type="search" name="cle" placeholder="Rechercher un article..." aria-label="Search">
    <button class="Profil-btn btn btn-outline-success px-3" type="submit">Rechercher</button>
</form>


<!-- Section des articles -->
<div class="container mt-5 mb-3">
      <!-- Pour afficher la liste des categories -->
    <div class="text-center mt-3">
        <h2 class="text-black">Nos catégories</h2>
        <div class="d-flex justify-content-center flex-wrap gap-4 mt-4 mb-4">
            <?php
            $categories = allCategories();
            foreach ($categories as $category) {
            ?>
                <a href="<?= CHEMIN_SITE ?>blog.php?id=<?= $category['id_categorie'] ?>" class="categories-btn btn btn-outline-danger fw-bold fs-5"><?= htmlspecialchars($category['name']) ?></a>
            <?php
            }
            ?>
        </div>
    </div>
      


    <h2 class="text-center mb-4 text-black">Nos articles</h2>
    <div class="row">
        <?php
        // On va afficher les articles validés ici
        // $articles = getValidatedArticles(); // Récupère uniquement les articles validés
        foreach ($articles as $article) {
            $favCount = getFavoriteCount($article['id_article']);
        ?>
            <div class="col-md-4 mb-4">
                <div class="article-card article card shadow-sm">
                    <img src="<?= CHEMIN_SITE ?>assets/img/<?= $article['photo'] ?>" class="card-img-top" alt="<?= htmlspecialchars($article['titre']) ?>" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title text-center fw-bold"><?= htmlspecialchars($article['titre']) ?></h5>
                        <p class="card-text text-muted"><?= substr(htmlspecialchars($article['contenu']), 0, 100) ?>...</p>
                        <p class="card-text text-muted"><strong> Publié le  :</strong> <?= date('d/m/Y', strtotime($article['date_publication'])) ?></p>
                        <p class="card-text text-muted"><strong>Auteur :</strong> <?= $article['pseudo'] ?></p>
                        <div class="d-flex justify-content-between align-items-center mt-3">
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
    <?php if (!isset($_GET['id'])): ?>
    <?php if (!$voirPlus): ?>
        <div class="text-center mt-4">
            <a href="blog.php?voirplus=1" class="blog-btn-custum btn btn-outline-primary btn-lg">
                Voir plus d'articles
            </a>
        </div>
    <?php else: ?>
        <div class="text-center mt-4">
            <a href="blog.php" class="blog-btn-custum btn btn-outline-secondary btn-lg">
                Voir moins d'articles
            </a>
        </div>
    <?php endif; ?>
<?php endif; ?>
</div>

<?php
require_once 'inc/footer.inc.php';
?>