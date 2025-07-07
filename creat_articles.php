<?php
// session_start();
require_once 'inc/config.inc.php';




$message = "";
$photo = ""; // valeur par défaut
$article = [];


// Chargement de l'article en cas de modification
if (isset($_GET['id'])) {
    $id_article = (int)$_GET['id'];
    // Retourne un tableau de tableaux
    $articleData = getArticleById($id_article); 
    // On prend le premier résultat
    $article = $articleData ? $articleData[0] : []; 

    if (!$article) {
        $message .= error("Article introuvable.", "danger");
    } elseif ($_SESSION['client']['role'] != "ROLE_ADMIN" && $_SESSION['client']['id_user'] != $article['id_user']) {
        $message .= error("Vous n'êtes pas autorisé à modifier cet article.", "danger");
    }

    // header('Location: blog.php');
    
}


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
        if (!isset($_POST['titre']) || strlen(trim($_POST['titre'])) < 2 || strlen(trim($_POST['titre'])) > 100) {
            $message .= error("Le champ titre n'est pas valide", "danger");
        }


        if (!isset($_POST['contenu'])  || strlen(trim($_POST['contenu'])) <50) {
            $message .= error("Le champ contenu n'est pas valide", "danger");
        }


        // Gestion de l'image
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
            $fileInfo = pathinfo($_FILES['photo']['name']);
            $extension = strtolower($fileInfo['extension']);
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];


            if (in_array($extension, $allowedExtensions)) {
                $photo = uniqid() . '.' . $extension;
                move_uploaded_file($_FILES['photo']['tmp_name'], "assets/img/$photo");
            } else {
                $message .= error("Le fichier doit être une image valide (jpg, jpeg, png, gif).", "danger");
            }
        } elseif (isset($article['photo'])) {
            $photo = $article['photo']; // conserver l'image existante si non remplacée
        } else {
            $message .= error("Une image est obligatoire pour créer un article.", "danger");
        }


        if (empty($message)) {
            $titre = htmlspecialchars($_POST['titre'], ENT_QUOTES, 'UTF-8');
            $contenu = htmlspecialchars($_POST['contenu'], ENT_QUOTES, 'UTF-8');
            $category_id = (int)$_POST['id_categorie'];

            


            if (!isset($_SESSION['client']['id_user'])) {
                $message .= error("Vous devez être connecté pour effectuer cette action.", "danger");
            } else {
                $id_user = (int)$_SESSION['client']['id_user'];


                if (isset($article['id_article'])) {
                    updateArticle($article['id_article'], $titre, $contenu, $photo, $category_id);
                    $message .= error("L'article a été modifié avec succès.", "success");
                    echo '<meta http-equiv="refresh" content="3;url=blog.php">';
                } else {
                    // Vérifier si l'article existe déjà
                    if (checkArticle($titre, $category_id)) {
                        $message .= error("l'article existe déjà", "danger");
                    }else {
                        addArticle($titre, $contenu, $photo, $id_user, $category_id);
                        $message .= error("L'article a été créé avec succès.", "success");
                        // Envoi d'un mail de notification
                        $to = "hawa.kone@colombbus.org"; // Remplace par ton adresse mail
                        $subject = "Nouvel article créé sur Torréfacteurs";
                        $body = "Un nouvel article vient d'être créé :\n\nTitre : $titre\nCatégorie ID : $category_id\nAuteur ID : $id_user";
                        $headers = "From: noreply@cafenautes.fr\r\n";
                        mail($to, $subject, $body, $headers);


                        echo '<meta http-equiv="refresh" content="3;url=index.php">';
                    }

                    


                }
            }
        }
    }
}


require_once 'inc/header.inc.php';
?>


<div class="row w-75 mx-auto mt-5 mb-5">
    <h1 class="text-center mt-5"><?= isset($article['id_article']) ? 'Modifier l\'article' : 'Créer un article' ?></h1>
    <div class="col-md-6 mb-4 text-center mt-5">
        <p class="text-muted mt-3">Partagez votre passion pour le café avec le monde !</p>
        <img src="assets/img/coffee-3.jpg" alt="Image inspirante" class="img-fluid rounded shadow-lg">
    </div>


    <div class="col-md-6 mb-4">
        <!-- Condition pour afficher le formulaire uniquement s'il est autorisé -->
         
            <?= $message; ?>
       
        <?php
            if (empty($article) || ($_SESSION['client']['role'] === 'ROLE_ADMIN' || $_SESSION['client']['id_user'] == $article['id_user'])): 
         ?>

            <form action="" method="POST" enctype="multipart/form-data" class="container mt-5 mb-5">
            


                <div class="mb-3">
                    <label for="titre" class="form-label">Titre</label>
                    <input type="text" id="titre" name="titre" class="form-control" value="<?= isset($article['titre']) ? htmlspecialchars($article['titre']) : '' ?>">
                </div>


                <div class="mb-3">
                    <label for="contenu" class="form-label">Contenu</label>
                    <textarea id="contenu" name="contenu" class="form-control" rows="5"><?= isset($article['contenu']) ? htmlspecialchars($article['contenu']) : '' ?></textarea>
                </div>


                <div class="form-group">
                    <label for="id_categorie" class="fw-bold">Catégorie</label>
                    <select name="id_categorie" id="id_categorie" class="form-control" required>
                        <option value="">-- Sélectionnez une catégorie --</option>
                        <?php
                            $categories = allCategories(); // Fonction pour récupérer toutes les catégories
                                foreach ($categories as $category) {
                                $selected = (isset($article['category_id']) && $article['category_id'] == $category['id_categorie']) ? 'selected' : '';
                            ?>
                              <option value='<?=$category['id_categorie']?>' $selected><?=$category['name']?></option>
                            <?php
                                }
                            ?>
                    </select>
                </div>


                <div class="mb-3">
                    <label for="photo" class="form-label">Ajouter une image</label>
                    <input type="file" id="photo" name="photo" class="form-control">
                    <?php if (isset($article['photo'])): ?>
                        <img src="assets/img/<?= $article['photo'] ?>" alt="Image de l'article" class="img-thumbnail mt-2" width="100">
                    <?php endif; ?>
                </div>


                <div class="d-flex justify-content-between">
                    <button type="submit" class="article-btn btn btn-danger">
                        <?= isset($article['id_article']) ? 'Modifier l\'article' : 'Ajouter un article' ?>
                    </button>
                </div>
            </form>
        <?php 
            endif; 
        ?>
    </div>
</div>


<?php require_once 'inc/footer.inc.php'; ?>
