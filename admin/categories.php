<?php
require_once '../inc/config.inc.php';

$message = "";
// Valeurs par défaut pour le formulaire
$category = ['name' => '', 'description' => '']; 

// Pré-remplir le formulaire en cas de modification
if (isset($_GET['action']) && $_GET['action'] == "update" && isset($_GET['id'])) {
    $idCategory = intval($_GET['id']);
    $category = getCategoryById($idCategory); // Fonction pour récupérer la catégorie par ID
    if (!$category) {
        $message = error("Catégorie introuvable", "danger");
        $category = ['name' => '', 'description' => '']; // Réinitialiser si la catégorie n'existe pas
    }
}

// Traitement du formulaire d'ajout ou de modification de catégorie
if (!empty($_POST)) {
    // Vérification des champs vides
    $verification = true;
    foreach ($_POST as $key => $value) {
        if (empty(trim($value))) {
            $verification = false;
        }
    }

    if ($verification === false) {
        $message = error("Veuillez renseigner tous les champs", "danger");
    } else {
        // Validation des champs
        $category_name = htmlspecialchars(trim($_POST['name']));
        $category_description = htmlspecialchars(trim($_POST['description']));

        if (strlen($category_name) < 3 || preg_match("/[0-9]/", $category_name)) {
            $message .= error("Le champ nom de la catégorie n'est pas valide", "danger");
        }
        if (strlen($category_description) < 20) {
            $message .= error("Le champ description de la catégorie n'est pas valide", "danger");
        }

        // Si aucune erreur, traitement de la catégorie
        if ($message == "") {
            $existingCategory = getCategoryByName($category_name);
            if ($existingCategory && (!isset($_GET['id']) || $existingCategory['id_categorie'] != $_GET['id'])) {
                $message .= error("La catégorie existe déjà", "danger");
            } else {
                if (isset($_GET['action']) && $_GET['action'] == "update" && isset($_GET['id'])) {
                    // Modification de la catégorie
                    $id = isset($_POST['id']) ? (int)$_POST['id'] : (int)$_GET['id'];
                    updateCategory($category_name, $category_description, $id);
                    $message .= error("La catégorie a été modifiée avec succès", "success");
                    header("Location: categories.php");
                } else {
                    // Ajout d'une nouvelle catégorie
                    addCategory($category_name, $category_description);
                    $message .= error("La catégorie a été ajoutée avec succès", "success");
                }
            }
        }
    }
}

// Suppression d'une catégorie
if (isset($_GET['action']) && $_GET['action'] == "delete" && isset($_GET['id'])) {
    $idCategory = intval($_GET['id']);
    deleteCategory($idCategory);
    $message .= error("La catégorie a été supprimée avec succès", "success");
    header("Location: categories.php");
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
                <i class="bi bi-tags-fill" style="font-size: 3rem; color: #d7bda6;"></i>
            </div>
            <h2 class="mb-3">Bienvenue <?= $_SESSION['client']['pseudo'] ?></h2>
            <p class="lead mb-0">
                <i class="bi bi-gear-fill me-2" style="color: #d7bda6;"></i>

                Gestion des catégories
                <i class="bi bi-gear-fill me-2" style="color: #d7bda6;"></i>

            </p>
        </div>
    </div>
</section>

<!-- Page formulaire et affichage des catégories -->
<div class="container p-5 mt-5">
    <h1 class="text-center p-3 mt-3">Gestion des catégories</h1>
    <div class="row">
        <!-- Formulaire -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form method="POST" action="">
                        <?= $message ?>
                        <div class="form-group">
                            <label for="name" class="fw-bold">Nom de la catégorie</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($category['name'] ?? '') ?>" required>
                        </div>
                        <div class="form-group mt-3">
                            <label for="description" class="fw-bold">Description de la catégorie</label>
                            <textarea class="form-control" id="description" name="description" rows="3" required><?= htmlspecialchars($category['description'] ?? '') ?></textarea>
                        </div>
                        <button type="submit" class="cate-btn btn btn-primary mt-3">
                            <?= isset($_GET['action']) && $_GET['action'] == 'update' ? 'Modifier' : 'Ajouter ' ?>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Tableau des catégories -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <table class="table table-striped table-bordered text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>Nom</th>
                                <th>Description</th>
                                <th>Supprimer</th>
                                <th>Modifier</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $categories = allCategories();
                            foreach ($categories as $category) {
                            ?>
                                <tr>
                                    <td><?= htmlspecialchars($category['name']) ?></td>
                                    <td><?= htmlspecialchars(substr($category['description'], 0, 50)) ?>...</td>
                                    <td>
                                        <a href="categories.php?action=delete&id=<?= $category['id_categorie'] ?>" class="btn text-danger fs-4 btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?')"><i class="bi bi-trash3-fill"></i></a>
                                    </td>
                                    <td>
                                        <a href="categories.php?action=update&id=<?= $category['id_categorie'] ?>" class="btn fs-4 btn-sm"><i class="bi bi-pen-fill"></i></a>
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
    </div>
</div>

<div class="container mt-5">
    <?php
    $categories = allCategories();
    $totalCategories = count($categories);
    ?>
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="stats-card text-center">
                <i class="bi bi-tags-fill" style="font-size: 2rem; color: #6e7c59;"></i>
                <h4 class="mt-2 mb-1" style="color: #4e342e;"><?= $totalCategories ?></h4>
                <p class="text-muted mb-0">Catégories totales</p>
            </div>
        </div>
        <div class="col-md-4 mb-3">
         
            <div class="stats-card text-center">
                <i class="bi bi-plus-circle-fill" style="font-size: 2rem; color: #4e342e;"></i>
                <h4 class="mt-2 mb-1" style="color: #4e342e;">
                    <?= isset($_GET['action']) && $_GET['action'] == 'update' ? 'Modification' : 'Ajout' ?>
                </h4>
                <p class="text-muted mb-0">
                    <?= isset($_GET['action']) && $_GET['action'] == 'update' ? 'Mode modification' : 'Mode ajout' ?>
                </p>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="stats-card text-center">
                <i class="bi bi-shield-check" style="font-size: 2rem; color: #d7bda6;"></i>
                <h4 class="mt-2 mb-1" style="color: #4e342e;">Administration</h4>
                <p class="text-muted mb-0">Gestion des catégories</p>
            </div>
        </div>
    </div>
</div>

<?php
require_once "../inc/footer.inc.php";
?>