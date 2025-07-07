<?php
require_once '../inc/config.inc.php';

$message = "";

// Pour valider ou refuser un article
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    if ($_GET['action'] === 'validate') {
        updateArticleStatus($id, 'validé');
        $message = "L'article a été validé avec succès.";
    } elseif ($_GET['action'] === 'reject') {
        updateArticleStatus($id, 'non validé');
        $message = "L'article a été refusé.";
    } elseif ($_GET['action'] === 'delete') {
        deleteArticle($id);
        $message = "L'article a été supprimé avec succès.";
    }
    
    // Redirection pour éviter la répétition de l'action
    header('Location: articles.php');
    exit;
}

require_once '../inc/header.inc.php';
?>


<!-- Bannière d'administration avec design moderne -->
<section class="admin-header text-white py-5 mt-5 position-relative">
    <div class="floating-elements"></div>
    <div class="container content">
        <div class="text-center">
            <div class="welcome-icon mb-3">
                <i class="bi bi-file-earmark-text" style="font-size: 3rem; color: #d7bda6;"></i>
            </div>
            <h2 class="mb-3">Bienvenue <?= $_SESSION['client']['pseudo'] ?></h2>
            <p class="lead mb-0">
                <i class="bi bi-gear-fill me-2" style="color: #d7bda6;"></i>
                Gestion des articles
                <i class="bi bi-gear-fill ms-2" style="color: #d7bda6;"></i>
            </p>
        </div>
    </div>
</section>

<!-- Statistiques des articles -->
<div class="container mt-5">
    <?php 
    $articles = getAllArticles();
    $totalArticles = count($articles);
    $validatedArticles = 0;
    $rejectedArticles = 0;
    $pendingArticles = 0;
    
    foreach($articles as $article) {
        if($article['status'] == 'validé') $validatedArticles++;
        elseif($article['status'] == 'non validé') $rejectedArticles++;
        else $pendingArticles++;
    }
    ?>
    
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="stats-card text-center">
                <i class="bi bi-file-earmark-text" style="font-size: 2rem; color: #6e7c59;"></i>
                <h4 class="mt-2 mb-1" style="color: #4e342e;"><?= $totalArticles ?></h4>
                <p class="text-muted mb-0">Articles totaux</p>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stats-card text-center">
                <i class="bi bi-check-circle-fill" style="font-size: 2rem; color: #6e7c59;"></i>
                <h4 class="mt-2 mb-1" style="color: #4e342e;"><?= $validatedArticles ?></h4>
                <p class="text-muted mb-0">Validés</p>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stats-card text-center">
                <i class="bi bi-x-circle-fill" style="font-size: 2rem; color: #d7bda6;"></i>
                <h4 class="mt-2 mb-1" style="color: #4e342e;"><?= $rejectedArticles ?></h4>
                <p class="text-muted mb-0">Refusés</p>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stats-card text-center">
                <i class="bi bi-clock-fill" style="font-size: 2rem; color: #4e342e;"></i>
                <h4 class="mt-2 mb-1" style="color: #4e342e;"><?= $pendingArticles ?></h4>
                <p class="text-muted mb-0">En attente</p>
            </div>
        </div>
    </div>
</div>

<!-- Liste des articles avec design moderne -->
<div class="container mb-5">
    <div class="admin-card p-4">
        <h1 class="page-title text-center mb-5">Gestion des Articles</h1>
        
        <div class="table-responsive">
            <table class="table custom-table mb-0">
                <thead>
                    <tr>
                        <th class="text-center">Image</th>
                        <th>Titre</th>
                        <th class="text-center">Statut</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($articles as $article) {
                        ?>
                        <tr>
                            <td class="text-center">
                                <div class="image-container">
                                    <img src="<?= CHEMIN_SITE ?>assets/img/<?= $article['photo'] ?>" 
                                         alt="<?= htmlspecialchars($article['titre']) ?>" 
                                         class="article-image"
                                         style="width: 120px; height: 80px;">
                                    <div class="image-overlay">
                                        <i class="bi bi-eye" style="font-size: 1.5rem;"></i>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="article-title">
                                    <?= htmlspecialchars($article['titre']) ?>
                                </div>
                            </td>
                            <td class="text-center">
                                <?php 
                                $statusClass = '';
                                $statusIcon = '';
                                switch($article['status']) {
                                    case 'validé':
                                        $statusClass = 'status-valide';
                                        $statusIcon = 'bi-check-circle-fill';
                                        break;
                                    case 'non validé':
                                        $statusClass = 'status-non-valide';
                                        $statusIcon = 'bi-x-circle-fill';
                                        break;
                                    default:
                                        $statusClass = 'status-en-attente';
                                        $statusIcon = 'bi-clock-fill';
                                }
                                ?>
                                <span class="status-badge <?= $statusClass ?>">
                                    <i class="<?= $statusIcon ?> me-1"></i>
                                    <?= htmlspecialchars($article['status']) ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center flex-wrap">
                                    <?php if ($article['status'] !== 'validé'): ?>
                                        <a href="articles.php?action=validate&id=<?= $article['id_article'] ?>" 
                                           onclick="return(confirm('✅ Êtes-vous sûr de vouloir valider cet article?'))" 
                                           class="action-btn btn-validate">
                                            <i class="bi bi-check-lg me-1"></i>
                                            Valider
                                        </a>
                                    <?php endif; ?>
                                    
                                    <?php if ($article['status'] !== 'non validé'): ?>
                                        <a href="articles.php?action=reject&id=<?= $article['id_article'] ?>" 
                                           onclick="return(confirm('⚠️ Êtes-vous sûr de vouloir refuser cet article ?'))" 
                                           class="action-btn btn-reject">
                                            <i class="bi bi-x-lg me-1"></i>
                                            Refuser
                                        </a>
                                    <?php endif; ?>
                                    
                                    <a href="articles.php?action=delete&id=<?= $article['id_article'] ?>" 
                                       class="action-btn btn-delete" 
                                       onclick="return confirm('🗑️ Êtes-vous sûr de vouloir supprimer cet article ?\n\nCette action est irréversible.')">
                                        <i class="bi bi-trash3-fill me-1"></i>
                                        Supprimer
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>



<?php
require_once '../inc/footer.inc.php';
?>