<?php
require_once "inc/config.inc.php";

$cnx = connexionBdd();

if (isset($_GET['cle']) && !empty(trim($_GET['cle']))) {
    $cle = htmlspecialchars($_GET['cle']);
    
    $stmt = $cnx->prepare("SELECT * FROM articles WHERE titre LIKE ? OR contenu LIKE ?");
    $stmt->execute(["%$cle%", "%$cle%"]);
    
    $resultats = $stmt->fetchAll();
} else {
    $resultats = [];
}

require_once "inc/header.inc.php";
?>


<!-- Hero Section -->
<div class="hero text-white text-center py-5 mt-4">
    <div class="container mt-5">
        <h1 class="recherche-title fade-in mt-4">
            Résultats pour : <span class="recherche">"<?= isset($cle) ? htmlspecialchars($cle) : '' ?>"</span>
        </h1>
        <p class="search-subtitle fade-in">Découvrez nos articles correspondant à votre recherche</p>
    </div>
</div>

<!-- Results Section -->
<div class="results-section">
    <div class="container mt-5 mb-5">
        <?php if (isset($cle) && !empty($cle)): ?>
            <div class="results-header fade-in">
                <div class="results-count">
                    <?= count($resultats) ?> résultat<?= count($resultats) > 1 ? 's' : '' ?> trouvé<?= count($resultats) > 1 ? 's' : '' ?>
                </div>
                <div class="results-description">
                    <?php if (count($resultats) > 0): ?>
                        Voici les articles qui correspondent le mieux à votre recherche.
                    <?php else: ?>
                        Aucun article ne correspond à votre recherche. Essayez avec d'autres mots-clés.
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if (count($resultats) > 0): ?>
            <div class="row g-4">
                <?php foreach ($resultats as $index => $article): ?>
                    <div class="col-12 col-sm-6 col-lg-4 fade-in" style="animation-delay: <?= $index * 0.1 ?>s;">
                        <div class="article-card">
                            <?php if (!empty($article['photo'])): ?>
                                <img src="<?= CHEMIN_SITE ?>assets/img/<?= htmlspecialchars($article['photo']) ?>"
                                     class="w-100 article-image"
                                     alt="<?= htmlspecialchars($article['titre']) ?>">
                            <?php else: ?>
                                <div class="w-100 article-image d-flex align-items-center justify-content-center" 
                                     style="background: linear-gradient(135deg,rgb(238, 227, 211),rgb(242, 233, 215));">
                                    <i class="fas fa-image" style="font-size: 3rem; color:rgb(233, 226, 202);"></i>
                                </div>
                            <?php endif; ?>
                            
                            <div class="card-body d-flex flex-column">
                                <h3 class="article-title text-center fw-bold">
                                    <a href="article.php?id=<?= $article['id_article'] ?>">
                                        <?= $article['titre'] ?>
                                    </a>
                                </h3>
                                
                                <p class="article-excerpt flex-grow-1">
                                    <?= substr(strip_tags($article['contenu']), 0, 120) ?>...
                                </p>
                                
                                <div class="article-meta">
                                    <span class="date-badge">
                                        <?= date('d/m/Y', strtotime($article['date_publication'])) ?>
                                    </span>
                                    <a href="article.php?id=<?= $article['id_article'] ?>" class="read-btn">
                                        Lire l'article
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <?php if (isset($cle) && !empty($cle)): ?>
                <div class="no-results fade-in">
                    <div class="no-results-icon">🔍</div>
                    <h2 class="no-results-title">Aucun résultat trouvé</h2>
                    <p class="no-results-text">
                        Nous n'avons trouvé aucun article correspondant à "<strong><?= htmlspecialchars($cle) ?></strong>".<br>
                        Essayez avec des mots-clés différents ou vérifiez l'orthographe.
                    </p>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>


<?php
require_once "inc/footer.inc.php";
?>