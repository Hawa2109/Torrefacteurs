<?php
require_once 'inc/config.inc.php';
header('Content-Type: application/json');

if (!isset($_SESSION['client'])) {
    echo json_encode(['success' => false, 'message' => 'Non connecté']);
    exit;
}

$user = $_SESSION['client']['id_user'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $article = isset($_POST['id_article']) ? intval($_POST['id_article']) : null;

    if ($_POST['action'] === 'add' && $article) {
        if (isFavorite($user, $article)) {
            echo json_encode(['success' => false, 'message' => 'Déjà en favori']);
            exit;
        }
        addFavorite($user, $article);
        // Compte les favoris pour cet article
        $cnx = connexionBdd();
        $stmt = $cnx->prepare("SELECT COUNT(*) FROM favorites WHERE article = :article");
        $stmt->execute([':article' => $article]);
        $count = $stmt->fetchColumn();
        echo json_encode(['success' => true, 'count' => $count]);
        exit;
    }

    if ($_POST['action'] === 'remove' && $article) {
        if (!isFavorite($user, $article)) {
            echo json_encode(['success' => false, 'message' => 'Pas en favori']);
            exit;
        }
        removeFavorite($user, $article);
        // Compte les favoris pour cet article
        $cnx = connexionBdd();
        $stmt = $cnx->prepare("SELECT COUNT(*) FROM favorites WHERE article = :article");
        $stmt->execute([':article' => $article]);
        $count = $stmt->fetchColumn();
        echo json_encode(['success' => true, 'count' => $count]);
        exit;
    }
}

echo json_encode(['success' => false, 'message' => 'Requête invalide']);
exit;
?>
<?php
?>
<?php
require_once 'inc/footer.inc.php';
?>