<?php
require_once '../inc/config.inc.php';

$users = allUsers();
// debug($users);
// session_start();
if (!isset($_SESSION['client'])) { // si une session n'existe pas avec un identiafaint user je me redérige vers la page de connexion

    header('location:' . CHEMIN_SITE . 'connexion.php');

}else {

    if ($_SESSION['client']['role'] == "ROLE_USER" ) {

        header('location:' . CHEMIN_SITE . 'profile.php');
    }
}



if (isset($_GET['action'])&& isset($_GET['id'])) {

    $idUser = htmlspecialchars($_GET['id']);
    
    $user = showUser($idUser);

    if (!empty($_GET['action']) && $_GET['action'] == "update" && !empty($_GET['id']) ) {

        
       
        if ($user['role'] =="ROLE_ADMIN") {

                // je change le rôle en ROLE_USER
                updateRole("ROLE_USER", $idUser );
            
        }else {

            // je change le rôle en ROLE_ADMIN
            updateRole("ROLE_ADMIN", $idUser );
        }
    }
    if (!empty($_GET['action']) && $_GET['action'] == "delete" && !empty($_GET['id']) ) {
           
        if ($user['role'] != "ROLE_ADMIN") {

             deleteUser($idUser);
        }

    }

    header("location:utilisateurs.php");
   
}
require_once '../inc/header.inc.php';
?>

<!-- Bannière d'administration avec design moderne -->
<section class="admin-header text-white py-5 mt-5 position-relative">
    <div class="floating-elements"></div>
    <div class="container content">
        <div class="text-center">
            <div class="welcome-icon mb-3">
                <i class="bi bi-people-fill text-white" style="font-size: 3rem; color: #d7bda6;"></i>

            </div>
            <h2 class="mb-3">Bienvenue <?= $_SESSION['client']['pseudo'] ?></h2>
            <p class="lead mb-0">
                <i class="bi bi-gear-fill me-2" style="color: #d7bda6;"></i>
                Gestion des utilisateurs
                <i class="bi bi-gear-fill me-2" style="color: #d7bda6;"></i>
            </p>
        </div>
    </div>
</section>

<!-- Statistiques rapides -->
<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="stats-card text-center">
                <i class="bi bi-people-fill text-primary" style="font-size: 2rem;"></i>
                <h4 class="mt-2 mb-1"><?= count($users) ?></h4>
                <p class="text-muted mb-0">Utilisateurs totaux</p>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="stats-card text-center">
                <i class="bi bi-shield-fill-check text-danger" style="font-size: 2rem;"></i>
                <h4 class="mt-2 mb-1">
                    <?php 
                    $adminCount = 0;
                    foreach($users as $user) {
                        if($user['role'] == 'ROLE_ADMIN') $adminCount++;
                    }
                    echo $adminCount;
                    ?>
                </h4>
                <p class="text-muted mb-0">Administrateurs</p>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="stats-card text-center">
                <i class="bi bi-person-fill text-success" style="font-size: 2rem;"></i>
                <h4 class="mt-2 mb-1"><?= count($users) - $adminCount ?></h4>
                <p class="text-muted mb-0">Utilisateurs standards</p>
            </div>
        </div>
    </div>
</div>

<!-- Liste des utilisateurs avec design moderne -->
<div class="container mb-5">
    <div class="admin-card p-4">
        <h1 class="page-title text-center mb-5">Gestion des Utilisateurs</h1>
        
        <div class="table-responsive">
            <table class="table custom-table mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Utilisateur</th>
                        <th>Nom Complet</th>
                        <th>Email</th>
                        <th>Rôle</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $users = allUsers();
                    foreach ($users as $user) {
                    ?>
                        <tr>
                            <td>
                                <span class="badge bg-light text-dark"><?= $user['id_user'] ?></span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="user-avatar">
                                        <?= strtoupper(substr($user['pseudo'], 0, 1)) ?>
                                    </div>
                                    <strong><?= htmlspecialchars($user['pseudo']) ?></strong>
                                </div>
                            </td>
                            <td>
                                <?= htmlspecialchars($user['firstName']) ?> 
                                <strong><?= htmlspecialchars($user['lastName']) ?></strong>
                            </td>
                            <td>
                                <i class="bi bi-envelope me-2 text-muted"></i>
                                <?= htmlspecialchars($user['email']) ?>
                            </td>
                            <td>
                                <a href="utilisateurs.php?action=update&id=<?= $user['id_user'] ?>" 
                                   class="role-badge <?= ($user['role'] === "ROLE_ADMIN") ? 'role-admin' : 'role-user'; ?>">
                                    <i class="bi bi-<?= ($user['role'] === "ROLE_ADMIN") ? 'shield-fill-check' : 'person-fill'; ?> me-1"></i>
                                    <?= ($user['role'] === "ROLE_ADMIN") ? 'Admin' : 'User'; ?>
                                </a>
                            </td>
                            <td class="text-center">
                                <a href="utilisateurs.php?action=delete&id=<?= $user['id_user'] ?>" 
                                   class="delete-btn"
                                   onclick="return(confirm('⚠️ Êtes-vous sûr de vouloir supprimer cet utilisateur ?\n\nCette action est irréversible.'))"
                                   data-bs-toggle="tooltip" 
                                   data-bs-placement="top" 
                                   title="Supprimer l'utilisateur">
                                    <i class="bi bi-trash3-fill"></i>
                                </a>
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
require_once "../inc/footer.inc.php";
?>