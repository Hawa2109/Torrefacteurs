<?php
require_once 'inc/config.inc.php';

$message = "";

// Validation du formulaire de contact
if (!empty($_POST)) {
    // On vérifie si un champs est vide 

    $verification = true;
    foreach ($_POST as $key => $value) {

        if (empty(trim($value))) {

            $verification = false;
        }
    }

    if ($verification === false) {

        $message = error("Veuillez renseigner tout les champs", "danger");
    }else {
        // On va vérifier si les champs sont valides
        if (!isset($_POST['nom']) || strlen(trim($_POST['nom'])) < 2 || strlen(trim($_POST['nom'])) > 50) {

            $message .= error("Le champ nom n'est pas valide", "danger");
        }
        if (!isset($_POST['email']) ||  strlen(trim($_POST['email'])) < 5 || strlen(trim($_POST['email'])) > 100 || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {

            $message .= error("Le champ email n'est pas valide", "danger");
        }
        if (!isset($_POST['message']) || strlen(trim($_POST['message'])) < 30 ) {

            $message .= error("Le champ message n'est pas valide", "danger");
        }
        // Je stoke mes données dans des variables
        if (empty($message)) {
            $name = htmlspecialchars(trim($_POST['nom']));
            $email = htmlspecialchars(trim($_POST['email']));
            $mess = htmlspecialchars(trim($_POST['message']));
             
            // je vérifie si le message existe déjà dans la BDD
            $checkMessage = checkContact($name, $email, $mess);
            if ($checkMessage){
                $message = error("Ce message existe déjà", "danger");
            } elseif (empty($message)) {
                addContact($name, $email, $mess);
                $message = error("Votre message a bien été envoyé", "success");
            }

        }
    }
}


require_once 'inc/header.inc.php';
?>
<section class="hero bg-dark text-white text-center py-5 mt-5">
    <div class="div-titre mt-4 container">
        <div class="row">
            <div class="col-lg-12 text-center mb-5">
                <h1 class="apropos-titre text-center mt-4">À propos de Torréfacteurs</h1>
                <p class="apropos-firstPara text-muted">Votre communauté passionnée de café depuis 2024</p>
                <div class="apropos-btns gap-4 d-flex justify-content-center mt-4">
                    <!-- Si l'utilisateur n'est pas connecté, afficher le bouton d'inscription -->
                    <?php if (!isset($_SESSION['client'])): ?>
                    <a href="inscription.php" class="index-btn btn btn-danger mt-3">Rejoignez-nous !</a>
                    <?php else: ?>
                    <a href="blog.php" class="index-btn btn btn-danger mt-3">Découvrer la communauté</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
</section>
<div class="container mt-5"> 

    <!-- Section Notre Histoire -->
    <div class="row mb-5">
        <div class="col-md-6">
            <img src="assets/img/Torr_Art.JPG" alt="Torréfaction du café" class="history-image img-fluid rounded shadow-lg">
        </div>
        <div class="col-md-6">
            <h2 class="mb-4">Notre Histoire</h2>
            <p>Torréfacteurs est né d'une passion partagée pour le café et particulièrement pour l'art de la torréfaction, avec la volonté de créer un espace où les amateurs et connaisseurs peuvent échanger leurs expériences, connaissances et découvertes.</p>
            <p>Tout a commencé en 2023, lorsqu'un groupe d'amis passionnés par l'univers du café a décidé de créer une plateforme en ligne dédiée à la torréfaction et aux multiples facettes du café. Depuis, notre communauté n'a cessé de grandir, réunissant des personnes de tous horizons autour d'une passion commune : le café artisanal et sa transformation.</p>
            <p>Notre mission est de promouvoir l'art de la torréfaction, d'éduquer sur les différentes techniques et origines des cafés, et de célébrer la diversité des saveurs que peut offrir un grain de café bien torréfié.</p>
        </div>
    </div>

    <!-- Section Notre Équipe -->
    <div class="section-equipe row mb-5">
        <div class="col-lg-12 text-center mb-4">
            <h2>Notre Équipe</h2>
            <p class="text-muted">Les passionnés qui font vivre Torréfacteurs</p>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="equipe-carte card h-100 shadow">
                <img src="assets/img/Portrait1.jpg" class="equipe-img card-img-top" alt="Fondateur">
                <div class="card-body text-center">
                    <h5 class="card-title fw-bold">Thomas Dupont</h5>
                    <p class="card-text text-muted">Fondateur & Maître Torréfacteur</p>
                    <p class="card-text">Passionné de café depuis plus de 15 ans, Thomas a travaillé dans des torréfactions artisanales à travers le monde avant de créer Torréfacteurs.</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="equipe-carte card h-100 shadow">
                <img src="assets/img/redactrice.jpg" class="equipe-img card-img-top" alt="Rédactrice en chef">
                <div class="card-body text-center">
                    <h5 class="card-title fw-bold">Sophie Martin</h5>
                    <p class="card-text text-muted">Rédactrice en chef & Experte en analyse sensorielle</p>
                    <p class="card-text">Sophie apporte son expertise en matière de profils de torréfaction et d'analyse sensorielle pour enrichir notre contenu éditorial.</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="equipe-carte card h-100 shadow">
                <img src="assets/img/responsable.jpg" class="equipe-img card-img-top" alt="Responsable communauté">
                <div class="card-body text-center">
                    <h5 class="card-title fw-bold">Marc Leroy</h5>
                    <p class="card-text text-muted">Responsable communauté & Spécialiste des origines</p>
                    <p class="card-text">Marc anime notre communauté et partage sa passion pour les différentes origines de café et leur influence sur les profils de torréfaction.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Section Notre Philosophie -->
    <div class="row mb-5">
        <div class="col-md-12">
            <h2 class="text-center mb-4">Notre Philosophie</h2>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="philo-carte card h-100 border-0 shadow p-3">
                        <div class="card-body text-center">
                            <i class="fas fa-leaf fa-3x mb-3 text-success"></i>
                            <h4 class="card-title">Durabilité</h4>
                            <p class="card-text">Nous soutenons les pratiques de torréfaction et de production de café durables et équitables, en mettant en avant les producteurs et torréfacteurs qui respectent l'environnement et offrent des conditions de travail justes.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 mb-4">
                    <a href="<?= CHEMIN_SITE ?>blog.php" class="text-decoration-none">
                        <div class="philo-carte card h-100 border-0 shadow p-3">
                            <div class="card-body text-center">
                                <i class="fas fa-users fa-3x mb-3 text-primary"></i>
                                <h4 class="card-title">Communauté</h4>
                                <p class="card-text">Notre force réside dans notre communauté. Nous encourageons le partage de techniques de torréfaction, l'entraide et la bienveillance entre tous les membres, qu'ils soient novices ou experts.</p>
                            </div>
                        </div>
                    </a>
                </div>
                
                <div class="col-md-4 mb-4">
                    <div class="philo-carte card h-100 border-0 shadow p-3">
                        <div class="card-body text-center">
                            <i class="fas fa-fire fa-3x mb-3 text-danger"></i>
                            <h4 class="card-title">Artisanat</h4>
                            <p class="card-text">Nous valorisons l'art de la torréfaction artisanale et le savoir-faire qui transforme un simple grain en une expérience gustative exceptionnelle. Notre objectif est de préserver et promouvoir cet artisanat.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section Ce que nous proposons -->
    <div class="row mb-3">
        <div class="col-md-12 text-center mb-4">
            <h2>Ce que nous proposons</h2>
            <p class="text-muted">Découvrez les richesses de notre communauté</p>
        
            <div class="row">
                <div class="col-md-4 mb-4">
                    <a href="blog.php" class="text-decoration-none">
                        <div class="Decouvert-carte card h-100 shadow">
                            <div class="card-body text-center">
                                <i class="fas fa-newspaper fa-3x mb-3 text-warning"></i>
                                <h4 class="card-title">Articles</h4>
                                <p class="card-text">Des articles complets sur les techniques de torréfaction, les origines des cafés, et les dernières tendances.</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 mb-4">
                    <a href="evenements.php" class="text-decoration-none">
                        <div class="Decouvert-carte card h-100 shadow">
                            <div class="card-body text-center">
                                <i class="fas fa-calendar-alt fa-3x mb-3 text-success"></i>
                                <h4 class="card-title">Événements</h4>
                                <p class="card-text">Des ateliers, dégustations et rencontres avec des torréfacteurs professionnels.</p>
                            </div>
                        </div>
                    </a>
                </div>
                
                <div class="col-md-4 mb-4">
                        <div class="Decouvert-carte card h-100 shadow">
                            <div class="card-body text-center">
                                <i class="fas fa-book fa-3x mb-3 text-danger"></i>
                                <h4 class="card-title">Guides</h4>
                                <p class="card-text">Des guides détaillés pour maîtriser l'art de la torréfaction, de débutant à expert.</p>
                            </div>
                        </div>
                </div>
            </div>
        </div>
        
    </div>

    <!-- Section Nos Partenaires -->
    <div class="partenaire row mb-3">
        <div class="col-lg-12 text-center mb-4">
            <h2>Nos Partenaires</h2>
            <p class="text-muted">Les artisans et entreprises qui nous font confiance</p>
        </div>
        
        <div class="col-md-3 mb-4 text-center">
            <img src="assets/img/Cafe_special.JPG" alt="Partenaire 1" class="img-fluid" style="max-height: 200px;">
            <p class="mt-2">Café de Spécialité France</p>
        </div>
        
        <div class="col-md-3 mb-4 text-center">
            <img src="assets/img/Torr_Art.JPG" alt="Partenaire 2" class="img-fluid" style="max-height: 200px;">
            <p class="mt-2">Torréfaction Artisanale</p>
        </div>
        
        <div class="col-md-3 mb-4 text-center">
            <img src="assets/img/Equipe.jpg" alt="Partenaire 3" class="img-fluid" style="max-height: 200px;">
            <p class="mt-2">Equipment Pro</p>
        </div>
        
        <div class="col-md-3 mb-4 text-center">
            <img src="assets/img/Visit-plant2.JPG" alt="Partenaire 4" class="img-fluid" style="max-height: 200px;">
            <p class="mt-2">Association des Cafés Verts</p>
        </div>
    </div>

    <!-- Section Nous Rejoindre -->
    <div class="row mb-3">
        <div class="col-md-8 offset-md-2 text-center">
            <h2 class="mb-4">Rejoignez Notre Communauté</h2>
            <p>Vous êtes passionné(e) par le café et la torréfaction et souhaitez partager votre expérience avec d'autres amateurs ? Rejoignez Torréfacteurs pour :</p>
            <ul class="list-unstyled">
                <li><i class="fas fa-check text-success me-2"></i> Partager vos techniques et profils de torréfaction</li>
                <li><i class="fas fa-check text-success me-2"></i> Apprendre des conseils de torréfacteurs professionnels</li>
                <li><i class="fas fa-check text-success me-2"></i> Participer à des discussions sur les différentes origines et méthodes</li>
                <li><i class="fas fa-check text-success me-2"></i> Découvrir les dernières tendances dans le monde du café artisanal</li>
            </ul>
            <p>Que vous soyez un torréfacteur amateur ou un passionné de café, votre place est parmi nous !</p>
            <!-- Si l'utilisateur n'est pas connecté, afficher le bouton d'inscription -->
            <?php if (!isset($_SESSION['client'])): ?>
            <a href="inscription.php" class="apropos-btn btn btn-danger btn-lg mt-3">Rejoignez-nous !</a>
            <?php else: ?>
            <a href="blog.php" class="apropos-btn btn btn-danger btn-lg mt-3">Visiter le blog</a>
            <?php endif; ?>
            
        </div>
    </div>

    <!-- Section Contact -->
    <div class="row">
        <div class="col-md-6">
            <h2 class="mb-4 text-center">Contactez-nous</h2>
            <form action="" method="POST">
                <?php
                    echo $message;
                ?>
                <div class="mb-3">
                    <label for="nom" class="form-label">Nom</label>
                    <input type="text" class="form-control" id="nom" name="nom">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" class="form-control" id="email" name="email">
                </div>
            
                <div class="mb-3">
                    <label for="message" class="form-label">Message</label>
                    <textarea class="form-control" id="message" name="message" rows="4"></textarea>
                </div>
                <div class="text-center">
                    <button type="submit" class="apropos-btn btn btn-danger">Envoyer</button>
                </div>
            </form>
        </div>
        <!-- Localisation -->
        <div class="col-md-6">
            <h2 class="mb-4 text-center">Où nous trouver</h2>
            <div class="mb-3">
                <h5><i class="fas fa-map-marker-alt me-2 text-danger"></i> Adresse</h5>
                <p>42 Rue de la Torréfaction, 75001 Paris, France</p>
            </div>
            <div class="mb-3">
                <h5><i class="fas fa-phone me-2 text-danger"></i> Téléphone</h5>
                <p>+33 1 23 45 67 89</p>
            </div>
            <div class="mb-3">
                <h5><i class="fas fa-envelope me-2 text-danger"></i> Email</h5>
                <p>contact@torrefacteurs.fr</p>
            </div>
            <div class="mb-3">
                <h5><i class="fas fa-clock me-2 text-danger"></i> Horaires</h5>
                <p>Lundi - Vendredi: 9h00 - 18h00</p>
            </div>
            <div class="social-media mt-4 fs-4">
                <h5>Suivez-nous</h5>
                <i class="bi bi-pinterest"></i>
                <i class="bi bi-instagram"></i>
                <i class="bi bi-facebook"></i>
                <i class="bi bi-twitter"></i>
               
            </div>
        </div>
    </div>
</div>

<?php
require_once 'inc/footer.inc.php';
?>