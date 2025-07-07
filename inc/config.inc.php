<?php
session_start();
define("CHEMIN_SITE", "http://torrefacteurs.test/");

///// pour debuger
function debug($var){
      echo '<pre class="border border-dark bg-light text-info fw-bold w-50 p-5 mt-5">';
            var_dump($var);
      echo'</pre>';
}
///////////////////////////// Connexion à la BDD ////////////////

define("DBHOST", "localhost");

define("DBUSER", "root");

define("DBPASS", "");


define("DBNAME", "torrefacteurs");

function connexionBdd(): object
{

      $dsn = "mysql:host=" . DBHOST . ";dbname=" . DBNAME . ";charset=utf8";


      try { 
           
            $pdo = new PDO($dsn, DBUSER, DBPASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
           
      } catch (PDOException $e) {  

            die("Erreur : " . $e->getMessage()); 
      }
     

      return $pdo;
}
/////////////////////////////// Fonction error Pour les messages d'erreurs////////////////////////////////////////
function error(string $contenu, string $class) : string {
    return 
    "<div class=\"alert alert-$class alert-dismissible fade show text-center w-75 m-auto mb-5\" role=\"alert\">
              $contenu
           <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>

    </div>";
}
/////////////////////////// Condition pour la déconnexion de l'utilisateur /////////////////////////
if (isset($_GET['action']) && $_GET['action'] === 'deconnexion') {

    unset($_SESSION['client']); // on supprime l'indice 'client' de la session  pour se déconnecter / cette fonction détruit les élément du tableau $_SESSION['client']

    // session_destroy();// La fonction session_destroy détruit toutes les données de la session déjà établie. Cette fonction détruit la session sur le serveur 
    header('location:' . CHEMIN_SITE . 'index.php');
}
################################# Création des clés étrangères  ###########################

//  ALTER TABLE films ADD FOREIGN KEY category_id REFERENCES categories id_categorie

function foreignKey(string $tableFK, string $keyFK, string $tablePK, string $keyPK): void
{

    $cnx = connexionBdd();
    $sql = " ALTER TABLE $tableFK ADD FOREIGN KEY ($keyFK) REFERENCES $tablePK ($keyPK)";

    $request = $cnx->exec($sql);
}

////////////////////// creation de la table utilisateur /////////////////
function createTableUser()
{
    // On se connecte à la BDD
    $cnx = connexionBdd();
    // On prépare la requête de création de la table utilisateur
    $sql = "CREATE TABLE IF NOT EXISTS users (
        id_user INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        lastName VARCHAR(50) NOT NULL,
        firstName VARCHAR(50) NOT NULL,
        pseudo VARCHAR(50) NOT NULL UNIQUE,
        email VARCHAR(100) NOT NULL UNIQUE,
        mdp VARCHAR(255) NOT NULL,
        civility ENUM('h', 'f') NOT NULL,
        birthday DATE NOT NULL,
        address VARCHAR(255) NOT NULL,
        zip VARCHAR(5) NOT NULL,
        country VARCHAR(50) NOT NULL,
        role ENUM('ROLE_USER','ROLE_ADMIN') DEFAULT 'ROLE_USER' 
    )";
    $request = $cnx->exec($sql);
  
}
// createTableUser();

////////////////////// fonction pour ajouter un utilisateur /////////////////

function addUser(string $lastName, string $firstName, string $pseudo, string $email, string $mdp, string $civility, string $birthday, string $address, string $zip, string $country): void
{
    // Créer un tableau associatif avec les noms des colonnes de la table users comme clés
    $data = [
        'lastName'=> $lastName,
        'firstName'=>$firstName,
        'pseudo'=> $pseudo,
        'email'=>$email,
        'mdp'=> $mdp,
        'civility'=> $civility,
        'birthday'=>$birthday,
        'address'=>$address,
        'zip'=> $zip,
        'country'=>$country
    ];
    foreach ($data as $key => $value) {
        $data[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }

    $cnx = connexionBdd();

    $sql = "INSERT INTO users (lastName, firstName, pseudo, email, mdp, civility, birthday, address, zip, country) VALUES (:lastName, :firstName, :pseudo, :email, :mdp, :civility, :birthday, :address, :zip, :country)";
    $request = $cnx->prepare($sql);  // préparation de la requête
    $request->execute($data);
}
// Je vérifie si l' utilisateur existe déjà dans la BDD 
function checkEmailUser(string $email): mixed
{

    $cnx = connexionBdd();
    $sql = "SELECT email FROM users WHERE email = :email";
    $request = $cnx->prepare($sql);
    $request->execute(array(

        ':email' => $email
    ));
    $result = $request->fetch();

    return $result;
}

function checkPseudoUser(string $pseudo): mixed
{

    $cnx = connexionBdd();
    $sql = "SELECT pseudo FROM users WHERE pseudo = :pseudo";
    $request = $cnx->prepare($sql);
    $request->execute(array(

        ':pseudo' => $pseudo
    ));
    $result = $request->fetch();

    return $result;
}

function checkUser(string $pseudo, string $email): mixed
{

    $cnx = connexionBdd();
    $sql = "SELECT * FROM users WHERE pseudo = :pseudo AND email = :email";
    $request = $cnx->prepare($sql);
    $request->execute(array(

        ':pseudo' => $pseudo,
        ':email' => $email
    ));
    $result = $request->fetch();

    return $result;
}
// Fonction pour récupérer tout les utilisateurs
function allUsers(): mixed
{

    $cnx = connexionBdd();
    $sql = "SELECT * FROM users";
    $request = $cnx->query($sql);
    $result = $request->fetchAll(); 
    return $result;
}

function showUser(int $id): mixed
{

    $cnx = connexionBdd();
    $sql = "SELECT * FROM users WHERE id_user = :id";
    $request = $cnx->prepare($sql);
    $request->execute(array(
        ':id' => $id,

    ));
    $result = $request->fetch();

    return $result;
}
// Fonction pour modifier ou supprimer le rôle d'un utilisateur

function updateRole(string $role, int $id): void
{

    $cnx = connexionBdd();
    $sql = "UPDATE users SET role = :role WHERE id_user = :id";
    $request = $cnx->prepare($sql);
    $request->execute(array(
        ':role' => $role,
        ':id' => $id

    ));
}
// fonction pour supprimer un utilisateur
function deleteUser(int $id): void {
    $cnx = connexionBdd();

    // Supprimer les favoris de l'utilisateur
    $sql = "DELETE FROM favorites WHERE user = :id";
    $request = $cnx->prepare($sql);
    $request->execute([':id' => $id]);

    // Supprimer les réservations de l'utilisateur
    $sql = "DELETE FROM reservations WHERE user_id = :id";
    $request = $cnx->prepare($sql);
    $request->execute([':id' => $id]);

    // Supprimer les commentaires de l'utilisateur
    $sql = "DELETE FROM commentaires WHERE user_id = :id";
    $request = $cnx->prepare($sql);
    $request->execute([':id' => $id]);

    // Supprimer les articles de l'utilisateur (ceci supprimera aussi les favoris/commentaires liés si ON DELETE CASCADE est activé)
    $sql = "DELETE FROM articles WHERE id_user = :id";
    $request = $cnx->prepare($sql);
    $request->execute([':id' => $id]);

    // Enfin, supprimer l'utilisateur
    $sql = "DELETE FROM users WHERE id_user = :id";
    $request = $cnx->prepare($sql);
    $request->execute([':id' => $id]);
}

// Fonction pour la table catégories
function createTableCategories()
{
    // On se connecte à la BDD
    $cnx = connexionBdd();
    // On prépare la requête de création de la table catégories
    $sql = "CREATE TABLE IF NOT EXISTS categories (
        id_categorie INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(50) NOT NULL,
        description TEXT NOT NULL
    )";
    $request = $cnx->exec($sql);
}
// createTableCategories();
// Fonction pour ajouter une catégorie
function addCategory(string $name, string $description): void
{

    $cnx = connexionBdd();
    $sql = "INSERT INTO categories (name, description) VALUES (:name, :description)";
    $request = $cnx->prepare($sql);
    $request->execute(array(
        ':name' => $name,
        ':description' => $description
    ));
}
// Fonction pour récupérer toutes les catégories
function allCategories(): mixed
{

    $cnx = connexionBdd();
    $sql = "SELECT * FROM categories";
    $request = $cnx->query($sql);
    $result = $request->fetchAll(); 
    return $result;
}
// Fonction pour afficher une catégorie
function showCategory(int $id): mixed
{

    $cnx = connexionBdd();
    $sql = "SELECT * FROM categories WHERE id_categorie = :id";
    $request = $cnx->prepare($sql);
    $request->execute(array(
        ':id' => $id,

    ));
    $result = $request->fetch();

    return $result;
}
// Fonction pour afficher une catégorie par son nom
function getCategoryByName(string $name): mixed
{

    $cnx = connexionBdd();
    $sql = "SELECT * FROM categories WHERE name = :name";
    $request = $cnx->prepare($sql);
    $request->execute(array(
        ':name' => $name,

    ));
    $result = $request->fetch();

    return $result;
}
// Fonction pour afficher une catégorie par son id
function getCategoryById(int $id): mixed
{

    $cnx = connexionBdd();
    $sql = "SELECT * FROM categories WHERE id_categorie = :id";
    $request = $cnx->prepare($sql);
    $request->execute(array(
        ':id' => $id,

    ));
    $result = $request->fetch();

    return $result;
}



// Fonction pour modifier une catégorie
function updateCategory(string $name, string $description, int $id): void
{

    $cnx = connexionBdd();
    $sql = "UPDATE categories SET name = :name, description = :description WHERE id_categorie = :id";
    $request = $cnx->prepare($sql);
    $request->execute(array(
        ':name' => $name,
        ':description' => $description,
        ':id' => $id
    ));
}
// Fonction pour supprimer une catégorie
function deleteCategory(int $id): void
{

    $cnx = connexionBdd();
    $sql = "DELETE FROM categories WHERE id_categorie = :id";
    $request = $cnx->prepare($sql);
    $request->execute(array(

        ':id' => $id

    ));
}

// On va créer la table articles avec une clé étrangère sur la table users
function createTableArticles()
{
    // On se connecte à la BDD
    $cnx = connexionBdd();
    // On prépare la requête de création de la table articles
    $sql = "CREATE TABLE IF NOT EXISTS articles (
        id_article INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        titre VARCHAR(100) NOT NULL,
        contenu TEXT NOT NULL,
        photo VARCHAR(255) NOT NULL,
        date_publication DATETIME DEFAULT CURRENT_TIMESTAMP,
        id_user INT(11) NOT NULL,
        category_id INT(11) NOT NULL,
        FOREIGN KEY (id_user) REFERENCES users(id_user),
        FOREIGN KEY (category_id) REFERENCES categories(id_categorie)
    )";
    $request = $cnx->exec($sql);
}
// ALTER TABLE articles ADD status ENUM('encours', 'validé', 'non validé') DEFAULT 'encours';

// createTableArticles();

// Fonction pour ajouter un article 
function addArticle(string $titre, string $contenu, string $photo, int $id_user, int $category_id): void {
    $cnx = connexionBdd();
    $sql = "INSERT INTO articles (titre, contenu, photo, id_user, category_id, status) 
            VALUES (:titre, :contenu, :photo, :id_user, :category_id, 'encours')";
    $request = $cnx->prepare($sql);
    $request->execute([
        ':titre' => $titre,
        ':contenu' => $contenu,
        ':photo' => $photo,
        ':id_user' => $id_user,
        ':category_id' => $category_id
    ]);
    
}


// Fonction pour récupérer les articles validés
function getValidateArticles(): mixed
{

    $cnx = connexionBdd();
    $sql = "SELECT * FROM articles WHERE is_valid = 1 ORDER BY date_publication DESC";
    $request = $cnx->query($sql);
    $result = $request->fetchAll(); 
    return $result;
}
// Fonction pour récupérer tout les articles (admin)
function getAllArticles(): mixed
{

    $cnx = connexionBdd();
    $sql = "SELECT * FROM articles ORDER BY date_publication DESC";
    $request = $cnx->query($sql);
    $result = $request->fetchAll(); 
    return $result;
}
// Fonction pour valider un article
function validateArticle(int $id_article): void
{

    $cnx = connexionBdd();
    $sql = "UPDATE articles SET is_valid = 1 WHERE id_article = :id_article";
    $request = $cnx->prepare($sql);
    $request->execute(array(
        ':id_article' => $id_article

    ));
}
// Fonction afficher les articles validés
function getValidatedArticles(): mixed
{
    $cnx = connexionBdd();
    $sql = "SELECT a.*, u.pseudo,
        (SELECT COUNT(*) FROM favorites f WHERE f.article = a.id_article) AS nb_favoris
        FROM articles a
        JOIN users u ON a.id_user = u.id_user
        WHERE a.status = 'validé'
        ORDER BY a.date_publication DESC";
    $request = $cnx->query($sql);
    $result = $request->fetchAll();
    return $result;
}
// Fonction pour afficher les 25 derniers articles validés
function getLast25ValidatedArticles(): mixed
{
    $cnx = connexionBdd();
    $sql = "SELECT a.*, u.pseudo,
        (SELECT COUNT(*) FROM favorites f WHERE f.article = a.id_article) AS nb_favoris
        FROM articles a
        JOIN users u ON a.id_user = u.id_user
        WHERE a.status = 'validé'
        ORDER BY a.date_publication DESC
        LIMIT 25";
    $request = $cnx->query($sql);

    $result = $request->fetchAll();
    return $result;
}
// Fonction pour modifier le statut d'un article
function updateArticleStatus(int $id_article, string $status): void
{

    $cnx = connexionBdd();
    $sql = "UPDATE articles SET status = :status WHERE id_article = :id_article";
    $request = $cnx->prepare($sql);
    $request->execute(array(
        ':status' => $status,
        ':id_article' => $id_article

    ));
}

// Fonction pour afficher un article par son utilisateur
function getArticleByUser(int $id_user): mixed
{

    $cnx = connexionBdd();
    $sql = "SELECT * FROM articles WHERE id_user = :id_user";
    $request = $cnx->prepare($sql);
    $request->execute(array(
        ':id_user' => $id_user,

    ));
    $result = $request->fetchAll(); 

    return $result;
}

// Fonction pour vérifier si l'article existe déjà dans la BDD via le titre et l'category_id
function checkArticle(string $titre, int $category_id): mixed
{

    $cnx = connexionBdd();
    $sql = "SELECT titre FROM articles WHERE titre = :titre AND category_id = :category_id";
    $request = $cnx->prepare($sql);
    $request->execute(array(

        ':titre' => $titre,
        ':category_id' => $category_id
    ));
    $result = $request->fetch();

    return $result ; 
}


// Fonction pour afficher un article avec le pseudo de l'utilisateur (requête de jointure)
function showArticleById(int $id): array {
    $cnx = connexionBdd();
    $sql = "SELECT a.*, u.pseudo 
            FROM articles a
            JOIN users u ON a.id_user = u.id_user
            WHERE a.id_article = :id";
    $request = $cnx->prepare($sql);
    $request->execute([':id' => $id]);
    return $request->fetch(); // Retourne un tableau associatif d'une seule ligne
}



// Fonction pour afficher les 6 derniers articles validés
function lastValidatedArticles(): array {
    $cnx = connexionBdd();
    $sql = "SELECT a.*, u.pseudo,
        (SELECT COUNT(*) FROM favorites f WHERE f.article = a.id_article) AS nb_favoris
        FROM articles a
        JOIN users u ON a.id_user = u.id_user
        WHERE a.status = 'validé'
        ORDER BY a.date_publication DESC
        LIMIT 6";
    $stmt = $cnx->query($sql);
    return $stmt->fetchAll();
}

// Fonction pour supprimer un article
function deleteArticle(int $id): void {
    $cnx = connexionBdd();
    $sql = "DELETE FROM articles WHERE id_article = :id";
    $request = $cnx->prepare($sql);

    // Vérifiez si l'utilisateur est autorisé
    $article = showArticleById($id);
    if ($_SESSION['client']['role'] == "ROLE_ADMIN" || $_SESSION['client']['id_user'] == $article['id_user']) {
        $request->execute([':id' => $id]);
    } else {
        throw new Exception("Vous n'êtes pas autorisé à supprimer cet article.");
    }
}

// Fonction pour modifier un article
function updateArticle($id_article, $titre, $contenu, $photo, $category_id) {

    $cnx = connexionBdd();
    $sql = "UPDATE articles SET titre = :titre, contenu = :contenu, photo = :photo, category_id = :category_id WHERE id_article = :id_article";
    $request = $cnx->prepare($sql);
    $request->execute([
        ':titre' => $titre,
        ':contenu' => $contenu,
        ':photo' => $photo,
        ':category_id' => $category_id,
        ':id_article' => $id_article
    ]);
    $result = $request->fetch();
    return $result;
}



// Fonction pour afficher les articles d'une catégorie
function getArticlesByCategory($category_id) {
    $cnx = connexionBdd();
    $sql = "SELECT a.*, u.pseudo,
        (SELECT COUNT(*) FROM favorites f WHERE f.article = a.id_article) AS nb_favoris
        FROM articles a
        JOIN users u ON a.id_user = u.id_user
        WHERE a.status = 'validé' AND a.category_id = :category_id
        ORDER BY a.date_publication DESC";
    $stmt = $cnx->prepare($sql);
    $stmt->execute([':category_id' => $category_id]);
    return $stmt->fetchAll();
}
// ################################# UTILISATEURS
// Fonction pour récupérer les 3 derniers articles validés d'un utilisateur
function getLastThreeArticlesByUser(int $id_user): array {
    $cnx = connexionBdd();
    $sql = "SELECT * FROM articles WHERE id_user = :id_user AND status = 'validé' ORDER BY date_publication DESC LIMIT 3";
    $request = $cnx->prepare($sql);
    $request->execute([':id_user' => $id_user]);
    return $request->fetchAll();
}


// Fonction pour céer la table commentaires avec une clé étrangère sur la table articles et une clé étrangère sur la table users
function createTableCommentaires()
{
    // On se connecte à la BDD
    $cnx = connexionBdd();
    // On prépare la requête de création de la table commentaires
    $sql = "CREATE TABLE IF NOT EXISTS commentaires (
        id_commentaire INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        comment TEXT NOT NULL,
        date_publication DATETIME DEFAULT CURRENT_TIMESTAMP,
        article_id INT(11) NOT NULL,
        user_id INT(11) NOT NULL,
        FOREIGN KEY (article_id) REFERENCES articles(id_article),
        FOREIGN KEY (user_id) REFERENCES users(id_user)
    )";
    $request = $cnx->exec($sql);
}
// createTableCommentaires()
// Fonction pour ajouter un commentaire
function addComment(int $article_id, int $user_id, string $comment): void {
    $cnx = connexionBdd();
    $sql = "INSERT INTO commentaires (article_id, user_id, comment, date_publication) VALUES (:article_id, :user_id, :comment, NOW())";
    $stmt = $cnx->prepare($sql);
    $stmt->execute([
        ':article_id' => $article_id,
        ':user_id' => $user_id,
        ':comment' => $comment
    ]);
}
// Fonction pour vérifier si un commentaire existe déjà

function checkCommentExist(int $article_id, int $user_id, string $comment): mixed {
    $cnx = connexionBdd();
    $sql = "SELECT * FROM commentaires WHERE article_id = :article_id AND user_id = :user_id AND comment = :comment";
    $request = $cnx->prepare($sql);
    $request->execute([
        ':article_id' => $article_id,
        ':user_id' => $user_id,
        ':comment' => $comment
    ]);
    $result = $request->fetch();

    return $result;
}
// Fonction pour récupérer tous les commentaires d'un article

function getCommentsByArticle(int $article_id): array {
    $cnx = connexionBdd();
    $sql = "SELECT c.comment, c.date_publication, u.pseudo 
            FROM commentaires c
            JOIN users u ON c.user_id = u.id_user
            WHERE c.article_id = :article_id
            ORDER BY c.date_publication DESC";
    $request = $cnx->prepare($sql);
    $request->execute([':article_id' => $article_id]);

    $result = $request->fetchAll();
    return $result;
}
// Fonction pour afficher les articles commentés par un utilisateur
function getArticlesCommentedByUser(int $user_id): mixed
{
    $cnx = connexionBdd();
    $sql = "SELECT a.*, MAX(c.date_publication) AS date_commentaire
            FROM articles a
            JOIN commentaires c ON a.id_article = c.article_id
            WHERE c.user_id = :user_id
            GROUP BY a.id_article
            ORDER BY date_commentaire DESC";
    $request = $cnx->prepare($sql);
    $request->execute([
        ':user_id' => $user_id,
    ]);
    return $request->fetchAll();
}


// Fonction pour afficher les articles d'un utilisateur
function getArticlesByUser(int $id_user): mixed
{

    $cnx = connexionBdd();
    $sql = "SELECT * FROM articles WHERE id_user = :id_user";
    $request = $cnx->prepare($sql);
    $request->execute(array(
        ':id_user' => $id_user,

    ));
    $result = $request->fetchAll(); 

    return $result;
}
// Fonction getArticleById pour récupérer un article par son ID
function getArticleById(int $id_article): mixed
{
    $cnx = connexionBdd();
    $sql = "SELECT * FROM articles WHERE id_article = :id_article";
    $request = $cnx->prepare($sql);
    $request->execute([':id_article' => $id_article]);
    return $request->fetchAll(); 
}

// création de la table événements
function createTableEvents()
{
    // On se connecte à la BDD
    $cnx = connexionBdd();
    // On prépare la requête de création de la table événements
    $sql = "CREATE TABLE IF NOT EXISTS events (
        id_event INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        titre VARCHAR(50) NOT NULL,
        description TEXT NOT NULL,
        date_event DATETIME NOT NULL,
        lieu VARCHAR(50) NOT NULL,
        image VARCHAR(255) NOT NULL,
        prix DECIMAL(10, 2) NOT NULL,
        nombre_places INT(11) NOT NULL
    )";
    $request = $cnx->exec($sql);
}
// createTableEvents();
// Fonction pour ajouter un événement
function addEvent(string $titre, string $description, string $date_event, string $lieu, string $image, float $prix, int $nombre_places): void
{

    $cnx = connexionBdd();
    $sql = "INSERT INTO events (titre, description, date_event, lieu, image, prix, nombre_places) VALUES (:titre, :description, :date_event, :lieu, :image, :prix, :nombre_places)";
    $request = $cnx->prepare($sql);
    $request->execute(array(
        ':titre' => $titre,
        ':description' => $description,
        ':date_event' => $date_event,
        ':lieu' => $lieu,
        ':image' => $image,
        ':prix' => $prix,
        ':nombre_places' => $nombre_places
    ));
}
// Fonction pour récupérer tous les événements
function allEvents(): mixed
{

    $cnx = connexionBdd();
    $sql = "SELECT * FROM events";
    $request = $cnx->query($sql);
    $result = $request->fetchAll(); 
    return $result;
}
// Fonction pour afficher un événement par son nom
function getEventByName(string $titre): mixed
{

    $cnx = connexionBdd();
    $sql = "SELECT * FROM events WHERE titre = :titre";
    $request = $cnx->prepare($sql);
    $request->execute(array(
        ':titre' => $titre,

    ));
    $result = $request->fetch();

    return $result;
}
// Fonction pour afficher un événement par son id
function getEventById(int $id_event): mixed
{

    $cnx = connexionBdd();
    $sql = "SELECT * FROM events WHERE id_event = :id_event";
    $request = $cnx->prepare($sql);
    $request->execute(array(
        ':id_event' => $id_event,

    ));
    $result = $request->fetch();

    return $result;
}
// Fonction pour afficher un événement par son id
function showEventById(int $id_event): mixed
{

    $cnx = connexionBdd();
    $sql = "SELECT * FROM events WHERE id_event = :id_event";
    $request = $cnx->prepare($sql);
    $request->execute(array(
        ':id_event' => $id_event,

    ));
    $result = $request->fetch();

    return $result;
}

// Fonction pour modiffier un événement
function updateEvent(string $titre, string $description, string $date_event, string $lieu, string $image, float $prix, int $nombre_places, int $id_event): void
{

    $cnx = connexionBdd();
    $sql = "UPDATE events SET titre = :titre, description = :description, date_event = :date_event, lieu = :lieu, image = :image, prix = :prix, nombre_places = :nombre_places WHERE id_event = :id_event";
    $request = $cnx->prepare($sql);
    $request->execute(array(
        ':titre' => $titre,
        ':description' => $description,
        ':date_event' => $date_event,
        ':lieu' => $lieu,
        ':image' => $image,
        ':prix' => $prix,
        ':nombre_places' => $nombre_places,
        ':id_event' => $id_event
    ));
}
// Fonction pour supprimer un événement
function deleteEvent(int $id_event): void
{

    $cnx = connexionBdd();
    $sql = "DELETE FROM events WHERE id_event = :id_event";
    $request = $cnx->prepare($sql);
    $request->execute(array(

        ':id_event' => $id_event

    ));
}


// Creation de la table réservations
function createTableReservations()
{
    // On se connecte à la BDD
    $cnx = connexionBdd();
    // On prépare la requête de création de la table réservations
    $sql = "CREATE TABLE IF NOT EXISTS reservations (
        id_reservation INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        event_id INT(11) NOT NULL,
        nom VARCHAR(50) NOT NULL,
        email VARCHAR(100) NOT NULL,
        date_reservation DATETIME DEFAULT CURRENT_TIMESTAMP,
         FOREIGN KEY (user_id) REFERENCES users(id_user) ON DELETE CASCADE,
         FOREIGN KEY (event_id) REFERENCES events(id_event) ON DELETE CASCADE
    )";
    $request = $cnx->exec($sql);
}
// createTableReservations();
// Fonction pour ajouter une réservation
function addReservation(int $user_id, int $event_id, string $nom, string $email): void
{

    $cnx = connexionBdd();
    $sql = "INSERT INTO reservations (user_id, event_id, nom, email) VALUES (:user_id, :event_id, :nom, :email)";
    $request = $cnx->prepare($sql);
    $request->execute(array(
        ':user_id' => $user_id,
        ':event_id' => $event_id,
        ':nom' => $nom,
        ':email' => $email
    ));
}
// Fonction pour récupérer toutes les réservations
function allReservations(): mixed
{

    $cnx = connexionBdd();
    $sql = "SELECT * FROM reservations";
    $request = $cnx->query($sql);
    $result = $request->fetchAll(); 
    return $result;
}
// Fonction pour afficher une réservation par son id
function showReservationById(int $id): mixed
{

    $cnx = connexionBdd();
    $sql = "SELECT * FROM reservations WHERE id_reservation = :id";
    $request = $cnx->prepare($sql);
    $request->execute(array(
        ':id' => $id,

    ));
    $result = $request->fetch();

    return $result;
}
// Fonction pour afficher les réservations d'un utilisateur
function getReservationByUser(int $user_id): mixed
{

    $cnx = connexionBdd();
    $sql = "SELECT * FROM reservations WHERE user_id = :user_id";
    $request = $cnx->prepare($sql);
    $request->execute(array(
        ':user_id' => $user_id,

    ));
    $result = $request->fetchAll(); 

    return $result;
}
// Fonction pour récupérer les 3 dernières réservations d'un utilisateur
function getLastThreeReservationsByUser(int $user_id): array {
    $cnx = connexionBdd();
    $sql = "SELECT * FROM reservations WHERE user_id = :user_id ORDER BY date_reservation DESC LIMIT 3";
    $request = $cnx->prepare($sql);
    $request->execute([':user_id' => $user_id]);
    return $request->fetchAll();
}
// Fonction pour supprimer une réservation
function deleteReservation(int $id_reservation): bool
{
    $cnx = connexionBdd();
    $sql = "DELETE FROM reservations WHERE id_reservation = :id_reservation";
    $request = $cnx->prepare($sql);
    return $request->execute([
        ':id_reservation' => $id_reservation
    ]);
}

// Fonction pour créer la table favoris
function creatTableFovorites (){
    $cnx = connexionBdd();
    $sql = "CREATE TABLE favorites (
    id_favorite INT AUTO_INCREMENT PRIMARY KEY,
    user INT NOT NULL,
    article INT NOT NULL,
    date_added DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user) REFERENCES users(id_user) ON DELETE CASCADE,
    FOREIGN KEY (article) REFERENCES articles(id_article) ON DELETE CASCADE
    )";
     $request = $cnx->exec($sql);

}
// creatTableFovorites();

// Fonction pour ajouter un favori
function addFavorite($user, $article) {
    $cnx = connexionBdd();
    $sql = "INSERT INTO favorites (user, article) VALUES (:user, :article)";
    $request = $cnx->prepare($sql);
    $request->execute([
        ':user' => $user,
        ':article' => $article
    ]);
}

// Fonction pour vérifier si un article est déja en favori
function isFavorite($user, $article) {
    $cnx = connexionBdd();
    $sql = "SELECT * FROM favorites WHERE user = :user AND article = :article";
    $request = $cnx->prepare($sql);
    $request->execute([
        ':user' => $user,
        ':article' => $article
    ]);
    $result = $request->fetch();
    return $result;
}
// Fonction pour supprimer un favoris
function removeFavorite($user, $article) {
    $cnx = connexionBdd();
    $sql = "DELETE FROM favorites WHERE user = :user AND article = :article";
    $request = $cnx->prepare($sql);
    $request->execute([
        ':user' => $user,
        ':article' => $article
    ]);
}
// Fonction pour récupérer tous les favoris d'un utilisateur
function getFavoritesByUser($user) {
    $cnx = connexionBdd();
    $sql = "SELECT * FROM favorites WHERE user = :user";
    $request = $cnx->prepare($sql);
    $request->execute([
        ':user' => $user
    ]);
    $result = $request->fetchAll();
    return $result;
}
//  Fonction pour récupérer tous les articles favoris d'un utilisateur
function getFavoriteArticlesByUser($user) {
    $cnx = connexionBdd();
    $sql = "SELECT a.* FROM favorites f
            JOIN articles a ON f.article = a.id_article
            WHERE f.user = :user";
    $request = $cnx->prepare($sql);
    $request->execute([
        ':user' => $user
    ]);
    $result = $request->fetchAll();
    return $result;
}
// Fonction pour récupérer le nombre de favoris d'un article
function getFavoriteCount($article) {
    $cnx = connexionBdd();
    $sql = "SELECT COUNT(*) AS count FROM favorites WHERE article = :article";
    $request = $cnx->prepare($sql);
    $request->execute([
        ':article' => $article
    ]);
    $result = $request->fetch();
    return $result['count'];
}
// Fonction pour récupérer les 3 derniers favoris d'un utilisateur
function getLastThreeFavoritesByUser($user) {
    $cnx = connexionBdd();
    $sql = "SELECT a.* 
            FROM favorites f
            JOIN articles a ON f.article = a.id_article
            WHERE f.user = :user
            ORDER BY f.date_added DESC
            LIMIT 3";
    $request = $cnx->prepare($sql);
    $request->execute([
        ':user' => $user
    ]);
    $result = $request->fetchAll();
    return $result;
}

// Creation de la table contact
function createTableContact()
{
    $cnx = connexionBdd();
    $sql = "CREATE TABLE IF NOT EXISTS contacts (
        id_contact INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        nom VARCHAR(50) NOT NULL,
        email VARCHAR(100) NOT NULL,
        message TEXT NOT NULL
    )";
    $request = $cnx->exec($sql);
}
// createTableContact();
// fonction pour ajouter un contact
function addContact(string $nom, string $email, string $message): void
{

    $cnx = connexionBdd();
    $sql = "INSERT INTO contacts (nom, email, message) VALUES (:nom, :email, :message)";
    $request = $cnx->prepare($sql);
    $request->execute(array(
        ':nom' => $nom,
        ':email' => $email,
        ':message' => $message
    ));
}
// Fonction pour vérifier si le contact existe déjà dans la BDD
function checkContact(string $nom, string $email): mixed
{

    $cnx = connexionBdd();
    $sql = "SELECT nom FROM contacts WHERE nom = :nom AND email = :email";
    $request = $cnx->prepare($sql);
    $request->execute(array(

        ':nom' => $nom,
        ':email' => $email
    ));
    $result = $request->fetch();

    return $result;
}
// Fonction pour récupérer tous les contacts
function allContacts(): mixed
{

    $cnx = connexionBdd();
    $sql = "SELECT * FROM contacts";
    $request = $cnx->query($sql);
    $result = $request->fetchAll(); 
    return $result;
}


?>