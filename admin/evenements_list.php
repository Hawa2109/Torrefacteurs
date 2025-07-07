<?php
require_once '../inc/config.inc.php';
$message = "";

if (isset($_GET['action'], $_GET['id']) && $_GET['action'] === 'delete') {
    $id = intval($_GET['id']);
    deleteEvent($id); // Cette fonction doit exister dans config.inc.php
    header('Location: evenements_list.php');
}
require_once '../inc/header.inc.php';
?>
<!-- Bannière d'administration avec design moderne -->
<section class="admin-header text-white py-5 mt-5 position-relative">
    <div class="floating-elements"></div>
    <div class="container content">
        <div class="text-center">
            <div class="welcome-icon mb-3">
                <i class="bi bi-calendar-event" style="font-size: 3rem; color: #d7bda6;"></i>
            </div>
            <h2 class="mb-3">Bienvenue <?= $_SESSION['client']['pseudo'] ?></h2>
            <p class="lead mb-0">
                <i class="bi bi-gear-fill me-2" style="color: #d7bda6;"></i>
                Gestion des événements
                <i class="bi bi-gear-fill ms-2" style="color: #d7bda6;"></i>
            </p>
        </div>
    </div>
</section>



<div class="container mt-5">
    <?php
    $evenements = AllEvents(); // À adapter selon ta fonction
    $totalEvents = count($evenements);
    $upcoming = 0;
    $past = 0;
    $cancelled = 0;
    $today = date('Y-m-d');
    foreach ($evenements as $event) {
       
        if ($event['date_event'] < $today) $past++;
        else $upcoming++;
    }
    ?>
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="stats-card text-center">
                <i class="bi bi-calendar-event" style="font-size: 2rem; color: #6e7c59;"></i>
                <h4 class="mt-2 mb-1" style="color: #4e342e;"><?= $totalEvents ?></h4>
                <p class="text-muted mb-0">Événements totaux</p>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stats-card text-center">
                <i class="bi bi-calendar-check-fill" style="font-size: 2rem; color: #6e7c59;"></i>
                <h4 class="mt-2 mb-1" style="color: #4e342e;"><?= $upcoming ?></h4>
                <p class="text-muted mb-0">À venir</p>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stats-card text-center">
                <i class="bi bi-calendar-x-fill" style="font-size: 2rem; color: #d7bda6;"></i>
                <h4 class="mt-2 mb-1" style="color: #4e342e;"><?= $past ?></h4>
                <p class="text-muted mb-0">Passés</p>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stats-card text-center">
                <i class="bi bi-x-circle-fill" style="font-size: 2rem; color: #4e342e;"></i>
                <h4 class="mt-2 mb-1" style="color: #4e342e;"><?= $cancelled ?></h4>
                <p class="text-muted mb-0">Annulés</p>
            </div>
        </div>
    </div>
</div>

<div class="container mb-5">
    <div class="admin-card p-4">
        <h1 class="page-title text-center mb-5">Gestion des Événements</h1>
        <div class="table-responsive">
            <table class="table custom-table mb-0">
                <thead>
                    <tr>
                        <th class="text-center">Image</th>
                        <th>Nom</th>
                        <th>Date</th>
                        <th class="text-center">Lieu</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($evenements as $event): ?>
                    <tr>
                        <td class="text-center">
                            <div class="image-container">
                                <img src="<?= CHEMIN_SITE ?>assets/img/<?= $event['image'] ?>" 
                                     alt="<?= htmlspecialchars($event['titre']) ?>" 
                                     class="article-image"
                                     style="width: 120px; height: 80px;">
                            </div>
                        </td>
                        <td><?= htmlspecialchars($event['titre']) ?></td>
                        <td><?= date('d/m/Y', strtotime($event['date_event'])) ?></td>
                        <td class="text-center"><?= htmlspecialchars($event['lieu']) ?></td>
                        <td class="text-center">
                            <a href="evenements_list.php?action=delete&id=<?= $event['id_event'] ?>" 
                               class="action-btn btn-delete" 
                               onclick="return confirm('🗑️ Êtes-vous sûr de vouloir supprimer cet événement ?\n\nCette action est irréversible.')">
                                <i class="bi bi-trash3-fill me-1"></i>
                                Supprimer
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
require_once '../inc/footer.inc.php';
?>