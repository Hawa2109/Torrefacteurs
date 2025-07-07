<?php
require_once '../inc/config.inc.php';
require_once '../inc/header.inc.php';
?>
<!-- On va mettre une bannière -->
<!-- Bannière d'administration avec design moderne -->
<section class="admin-header text-white py-5 mt-5 position-relative">
    <div class="floating-elements"></div>
    <div class="container content">
        <div class="text-center">
            <div class="welcome-icon mb-3">
                <i class="bi bi-shield-check text-warning" style="font-size: 3rem;"></i>
            </div>
            <h2 class="mb-3">Bienvenue <?= $_SESSION['client']['pseudo'] ?></h2>
            <p class="lead mb-0">
                <i class="bi bi-gear-fill me-2" style="color: #d7bda6;"></i>

                Gestion des contacts
                <i class="bi bi-gear-fill me-2" style="color: #d7bda6;"></i>

            </p>
        </div>
    </div>
</section>
<!-- Page pour afficher les infos de la table contacts -->

<?php
$contacts = allContacts();
$totalContacts = count($contacts);
$uniqueEmails = count(array_unique(array_column($contacts, 'email')));
?>
<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-md-6 mb-3">
            <div class="stats-card text-center">
                <i class="bi bi-envelope-fill" style="font-size: 2rem; color: #6e7c59;"></i>
                <h4 class="mt-2 mb-1" style="color: #4e342e;"><?= $totalContacts ?></h4>
                <p class="text-muted mb-0">Messages reçus</p>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="stats-card text-center">
                <i class="bi bi-people-fill" style="font-size: 2rem; color: #d7bda6;"></i>
                <h4 class="mt-2 mb-1" style="color: #4e342e;"><?= $uniqueEmails ?></h4>
                <p class="text-muted mb-0">Utilisateurs uniques</p>
            </div>
        </div>
    </div>
</div>

<div class="container mb-5">
    <div class="admin-card p-4">
        <h1 class="page-title text-center mb-5">Liste des messages de contact</h1>
        <div class="table-responsive">
            <table class="table table-striped table-bordered text-center custom-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Message</th>
                        <!-- <th>Date</th> -->
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($contacts as $contact): ?>
                        <tr>
                            <td><?= $contact['id_contact'] ?></td>
                            <td><?= htmlspecialchars($contact['nom']) ?></td>
                            <td><?= htmlspecialchars($contact['email']) ?></td>
                            <td><?= htmlspecialchars($contact['message']) ?></td>
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
