<?php
require_once '../inc/config.inc.php';

// Pour supprimer une réservation
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $result = deleteReservation($id);
    if ($result) {
        $message = "Réservation supprimée avec succès.";
       
    } else {
        $message = "Erreur lors de la suppression de la réservation.";
    }
}

// Récupère les réservations AVANT l'affichage
$reservations = AllReservations();
$totalReservations = count($reservations);

require_once '../inc/header.inc.php';
?>


<!-- Bannière d'administration avec design moderne -->
<section class="admin-header text-white py-5 mt-5 position-relative">
    <div class="floating-elements"></div>
    <div class="container content">
        <div class="text-center">
            <div class="welcome-icon mb-3">
                <i class="bi bi-calendar-check" style="font-size: 3rem; color: #d7bda6;"></i>
            </div>
            <h2 class="mb-3">Bienvenue <?= $_SESSION['client']['pseudo'] ?></h2>
            <p class="lead mb-0">
                <i class="bi bi-gear-fill me-2" style="color: #d7bda6;"></i>
                Gestion des réservations
                <i class="bi bi-gear-fill ms-2" style="color: #d7bda6;"></i>
            </p>
        </div>
    </div>
</section>

<section class="container my-5">
    <h1 class="text-center">Gestion des réservations</h1>
    
    <div class="container mb-5">
    <div class="admin-card p-4">
        <h1 class="page-title text-center mb-5">Gestion des Réservations</h1>
        <div class="table-responsive">
            <table class="table table-striped table-bordered text-center custom-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Date de réservation</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reservations as $reservation): ?>
                    <tr>
                        <td><?= $reservation['id_reservation'] ?></td>
                        <td><?= htmlspecialchars($reservation['nom']) ?></td>
                        <td><?= htmlspecialchars($reservation['email']) ?></td>
                        <td><?= date('d/m/Y', strtotime($reservation['date_reservation'])) ?></td>
                        <td>
                            <!-- <a href="<?= CHEMIN_SITE ?>evenements.php?action=update&id=<?= $reservation['id_reservation'] ?>" class="btn fs-5 edit-btn"><i class="bi bi-pen-fill"></i></a> -->
                            <a href="reservations.php?action=delete&id=<?= $reservation['id_reservation'] ?>" class="btn fs-5 delete-btn" onclick="return(confirm('Êtes-vous sûr de vouloir supprimer cette réservation ?'))"><i class="bi bi-trash-fill"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="text-center mt-3">
            <a href="<?= CHEMIN_SITE ?>evenements.php" class="Profil-btn btn btn-outline-primary"><i class="bi bi-calendar-plus me-2"></i>Réserver un événement</a>
        </div>
    </div>
</div>
</section>

<div class="container mt-5">
    <?php
    $reservations = AllReservations();
    $totalReservations = count($reservations);
    ?>
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="stats-card text-center">
                <i class="bi bi-calendar-check" style="font-size: 2rem; color: #6e7c59;"></i>
                <h4 class="mt-2 mb-1" style="color: #4e342e;"><?= $totalReservations ?></h4>
                <p class="text-muted mb-0">Réservations totales</p>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="stats-card text-center">
                <i class="bi bi-person" style="font-size: 2rem; color: #4e342e;"></i>
                <h4 class="mt-2 mb-1" style="color: #4e342e;">
                    <?= count(array_unique(array_column($reservations, 'email'))) ?>
                </h4>
                <p class="text-muted mb-0">Clients uniques</p>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="stats-card text-center">
                <i class="bi bi-calendar-plus" style="font-size: 2rem; color: #d7bda6;"></i>
                <h4 class="mt-2 mb-1" style="color: #4e342e;">
                    <?= date('d/m/Y') ?>
                </h4>
                <p class="text-muted mb-0">Aujourd'hui</p>
            </div>
        </div>
    </div>
</div>

<?php
require_once '../inc/footer.inc.php';
?>