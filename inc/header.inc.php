<?php

require_once 'config.inc.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="<?=CHEMIN_SITE?>assets/img/logo_Torr.png" type="image/png">
  <!-- Les balise metas -->
  <meta name="description" content="Torréfacteurs - Votre site de torréfaction de café">
  <meta name="keywords" content="café, torréfaction, café en grains, café moulu, boutique de café">
  <meta name="author" content="Torréfacteurs">
  <meta name="robots" content="index, follow">

  <title>Torréfacteurs</title>
  <!-- Lien Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
  <!-- Lien icones bootstrap -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <!-- Lien de mon CSS -->
  <link rel="stylesheet" href="<?=CHEMIN_SITE?>assets/css/style.css">
</head>
<body>
  
    <header class="header-fond bg-danger text-white fixed-top">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-dark">
                <!-- Logo aligné à gauche -->
                <a class="navbar-brand" href="<?=CHEMIN_SITE?>index.php">
                    <img src="<?=CHEMIN_SITE?>assets/img/logo_Torr.png" class="header-logo" alt="logo du site">
                </a>
                <!-- Bouton pour le menu mobile -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <!-- Menu de navigation aligné à droite -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-lien nav-item">
                            <a href="<?=CHEMIN_SITE?>index.php" class="nav-link text-white">Accueil</a>
                        </li>
                        
                        <?php if (!isset($_SESSION['client']) || $_SESSION['client']['role'] != "ROLE_ADMIN"): ?>
                            <li class="nav-lien nav-item">
                                <a href="<?=CHEMIN_SITE?>apropos.php" class="nav-link text-white">Notre mission</a>
                            </li>
                        
                        
                            <li class="nav-lien nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Catégories</a>
                                <ul class="drop-item dropdown-menu">
                                    <?php
                                        $categories = allCategories();
                                        foreach ($categories as $category) {
                                    ?>
                                        <li><a class="dropdown-item text-black" href="<?=CHEMIN_SITE?>blog.php?id=<?=$category['id_categorie']?>"><?=$category['name']?></a></li>
                                    <?php
                                        }
                                    ?>
                                </ul>
                            </li>
                        <?php endif; ?>
                        <li class="nav-lien nav-item">
                            <a href="<?=CHEMIN_SITE?>blog.php" class="nav-link text-white">Blog</a>
                        </li>
                        <?php if (isset($_SESSION['client']) && $_SESSION['client']['role'] == "ROLE_ADMIN"): ?>
                            <li class="nav-lien nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-white" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Ajouts
                                </a>
                                <ul class="drop-item dropdown-menu">
                                    <li><a class="dropdown-item" href="<?=CHEMIN_SITE?>creat_articles.php">Ajout d'un article</a></li>
                                    <li><a class="dropdown-item" href="<?=CHEMIN_SITE?>admin/categories.php">Gestion des catégories</a></li>
                                    <li><a class="dropdown-item" href="<?=CHEMIN_SITE?>admin/creat_events.php">Ajout d'un événement</a></li>
                                </ul>
                            </li>

                            <li class="nav-lien nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-white" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Affichages
                                </a>
                                <ul class="drop-item dropdown-menu">
                                    <li><a class="dropdown-item" href="<?=CHEMIN_SITE?>admin/utilisateurs.php">Utilisateurs</a></li>
                                    <li><a class="dropdown-item" href="<?=CHEMIN_SITE?>admin/articles.php">Les articles</a></li>
                                    <li><a class="dropdown-item" href="<?=CHEMIN_SITE?>admin/evenements_list.php">Les événements</a></li>
                                    <li><a class="dropdown-item" href="<?=CHEMIN_SITE?>admin/categories.php">Gestion des catégories</a></li>
                                    <li><a class="dropdown-item" href="<?=CHEMIN_SITE?>admin/reservations.php">Les réservations</a></li>
                                    <li><a class="dropdown-item" href="<?=CHEMIN_SITE?>admin/contacts.php">Les contacts</a></li>
                                </ul>
                            </li>
                         
                        <?php endif; ?>
                        <li class="nav-lien nav-item">
                            <a href="<?=CHEMIN_SITE?>evenements.php" class="nav-link text-white">Evenements</a>
                        </li>

                        <?php if (!isset($_SESSION['client'])): ?>
                            <li class="nav-lien nav-item">
                                <a href="<?=CHEMIN_SITE?>inscription.php" class="nav-link text-white">Inscription</a>
                            </li>
                            <li class="nav-lien nav-item">
                                <a href="<?=CHEMIN_SITE?>connexion.php" class="nav-link text-white">Connexion</a>
                            </li>
                        <?php else: ?>
                            <li class="nav-lien nav-item text-center">
                                <a href="<?=CHEMIN_SITE?>profile.php" class="nav-link text-white position-relative">
                                    <?php if ($_SESSION['client']['role'] == "ROLE_ADMIN"): ?>
                                            <i class="bi bi-person-circle fs-3" style="color: #FFD700; filter: drop-shadow(0 0 6px #FFD700);"></i>
                                            
                                    <?php else: ?>
                                        <i class="bi bi-person-circle fs-3"></i>
                                    <?php endif; ?>
                                    <div style="font-size: 10px;"><?= $_SESSION['client']['pseudo'] ?? 'Utilisateur' ?></div>
                                </a>
                            </li>
                            <li class="nav-lien nav-item">
                                <a href="?action=deconnexion" class="nav-link text-white"  onclick="return(confirm('Êtes-vous sûr de vouloir vous déconnecter ?'))">
                                    <i class="bi bi-box-arrow-right text-white" title="deconnexion"></i>
                                    
                                </a>
                            </li>
                            
                        <?php endif; ?>
                    </ul>
                </div>
            </nav>
        </div>
    </header>
  <main>

