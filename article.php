<?php
require_once 'inc/config.inc.php';

$message = "";
$comments = [];

// Suppression d'un article
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    // Vérifie que l'utilisateur est admin ou auteur de l'article
    $articleToDelete = showArticleById((int)$_GET['id']);
    if ($articleToDelete && isset($_SESSION['client']) && 
        ($_SESSION['client']['role'] === "ROLE_ADMIN" || $_SESSION['client']['id_user'] === $articleToDelete['id_user'])) {
        deleteArticle((int)$_GET['id']);
        header('Location: blog.php?msg=suppression');
        exit;
    } else {
        $message .= error("Suppression non autorisée.", "danger");
    }
}

// Vérifiez si l'ID de l'article est défini et valide
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int)$_GET['id'];
    $article = showArticleById($id);

    if (!$article) {
        $message .= error("Article introuvable.", "danger");
    } else {
        // Récupérer les commentaires pour l'article
        $comments = getCommentsByArticle($id);

        // AJOUTE CETTE LIGNE :
        $article['nb_favoris'] = getFavoriteCount($article['id_article']);
    }
} else {
    $message .= error("Identifiant de l'article manquant ou invalide.", "danger");
}

// Validation du formulaire de commentaire
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'])) {
    $comment = htmlspecialchars(trim($_POST['comment']));

    if (!isset($_SESSION['client'])) {
        $message .= error("Vous devez être connecté pour commenter cet article.", "danger");
    } elseif (strlen($comment) < 25) {
        $message .= error("Le commentaire doit contenir au moins 25 caractères.", "danger");
    }  elseif (checkCommentExist($id, $_SESSION['client']['id_user'], $comment)) {
        $message .= error("Vous avez déjà ajouté ce commentaire.", "danger");
    } 
    else {
        // Enregistrement du commentaire
        addComment($id, $_SESSION['client']['id_user'], $comment);
        $message .= error("Votre commentaire a été ajouté avec succès.", "success");
        // Optionnel : rediriger vers la même page pour éviter le double envoi du formulaire
        header("Location: article.php?id=$id");

        // Rafraîchir les commentaires après l'ajout
        $comments = getCommentsByArticle($id);
    }
}

require_once 'inc/header.inc.php';
?>

<!-- Affichage de l'article -->
<div class="container mt-5 mb-5">
    <h1 class="text-center mt-4">Article</h1>
    <div class="row mt-5">
        <?php if (!empty($article)): ?>
            <div class="col-md-6">
                <img src="<?= CHEMIN_SITE ?>assets/img/<?= htmlspecialchars($article['photo']) ?>" class="single-art-img card-img-top" alt="<?= htmlspecialchars($article['titre']) ?>">
            </div>
            <div class="col-md-6">
                <h5 class="mb-4 text-center fw-bold fs-4"><?=htmlspecialchars($article['titre']) ?></h5>
                <p class="card-text"><?= htmlspecialchars($article['contenu']) ?></p>
                <p class="card-text"><strong>Publié le :</strong><small class="text-muted"> <?= date('d/m/Y', strtotime($article['date_publication'])) ?></small></p>
                <p class="card-text"><strong>Par :</strong><small class="text-muted"> <?= htmlspecialchars($article['pseudo']) ?></small></p>
                <div class="row">
                    <div class="mt-4">
                        <div class="d-flex align-items-center justify-content-around">
                            <a href="<?= CHEMIN_SITE ?>blog.php" class="article-btn btn btn-primary fs-5">Retour</a>
                            <?php if (isset($_SESSION['client'])): ?>
                                <a href="#" class="btn btn-brown me-2 fav-btn fs-5" data-id="<?= $article['id_article'] ?>">
                                    <i class="bi bi-suit-heart<?= isFavorite($_SESSION['client']['id_user'], $article['id_article']) ? '-fill heart favori' : ' heart' ?>"></i>
                                    <span class="fav-count"><?= $article['nb_favoris'] ?? 0 ?></span>
                                </a>
                            <?php endif; ?>
                        </div>
                        <?php if (isset($_SESSION['client']) && ($_SESSION['client']['role'] === "ROLE_ADMIN" || $_SESSION['client']['id_user'] === $article['id_user'])): ?>
                            <a href="<?= CHEMIN_SITE ?>creat_articles.php?action=update&id=<?= $article['id_article'] ?>" class="Update-btn btn btn-warning mt-2 fs-5">Modifier</a>
                            <a href="<?= CHEMIN_SITE ?>article.php?action=delete&id=<?= $article['id_article'] ?>" class="btn btn-danger mt-2 fs-5" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?')">Supprimer</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-danger">Article introuvable</div>
        <?php endif; ?>
    </div>
</div>

<!-- Section des commentaires avec Scrollspy -->
<div class="container mt-5">
    <div class="row">
        <!-- Formulaire de commentaire -->
        <div class="col-md-6">
            <?php if (isset($_SESSION['client'])): ?>
                <form action="article.php?id=<?= $id ?>" method="POST" class="mt-4">
                    <h3 class="text-center">Laissez un commentaire</h3>
                    <?= $message; ?>
                    <div class="mb-3">
                        <label for="comment" class="form-label fw-bold">Votre commentaire</label>
                        <textarea id="comment" name="comment" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="mess-btn btn btn-primary">Envoyer</button>
                    </div>
                </form>
            <?php else: ?>
                <p class="text-muted">Vous devez être connecté pour commenter cet article.</p>
            <?php endif; ?>
        </div>

        <!-- Liste des commentaires avec Scrollspy -->
        <div class=" col-md-6">
            <h3 class="text-center">Commentaires</h3>
            <div id="comment-list" class="scrollspy-example" data-bs-spy="scroll" data-bs-target="#comment-nav" data-bs-offset="0" tabindex="0" style="height: 300px; overflow-y: auto; border: none; padding: 10px;">
                <?php if (!empty($comments)): ?>
                    <?php foreach ($comments as $index => $comment): ?>
                        <div id="comment-<?= $index ?>" class="commts mb-3 p-3 border rounded shadow-sm">
                            <p><strong><?= htmlspecialchars($comment['pseudo']) ?></strong> <small class="text-muted">(<?= date('d/m/Y', strtotime($comment['date_publication'])) ?>)</small></p>
                            <p><?= $comment['comment'] ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted">Aucun commentaire pour cet article.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php
require_once 'inc/footer.inc.php';
?>
