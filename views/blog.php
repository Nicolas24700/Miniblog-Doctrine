<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Blog</title>
    <link rel="stylesheet" href="./views/styles.css">
    <link rel="icon" href="./images/img_site/logo_blog.png" type="image/x-icon">
    <script defer src="./views/script.js"></script>
</head>

<body>
    <header>
        <nav class="navbar" id="navbar">
            <a href="index.php?action=home" class="logo">
                <img src="./images/img_site/logo_blog.png" alt="Accueil">
            </a>
            <ul class="nav-links">
                <li><a href="index.php?action=home" class="pageactive">Blog</a></li>
                <li><a href="index.php?action=archives">Archives</a></li>
                <li><a href="index.php?action=profil">Profil</a></li>
                <?php
                if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
                    echo "<li><a href='index.php?action=admin'>Administration</a></li>";
                }
                ?>
            </ul>
            <?php if (isset($_SESSION['login'])) {
                echo "<a href='index.php?action=authentification' class='login-link'>Vous êtes connecté</a>";
            } else {
                echo "<a href='index.php?action=authentification' class='login-link'>Se connecter</a>";
            } ?>
        </nav>
    </header>
    <main>
        <section class="accueilsection">
            <?php
            // Si il y'a un message dans la session, on l'affiche
            if (isset($_SESSION['message'])) {
                echo "<p class='pcommentadd'>{$_SESSION['message']}</p>";
                unset($_SESSION['message']); // on supprime la valeur de session message après affichage
            } ?>
            <h1>Bienvenue sur mon blog</h1>
            <div class="intro">
                <span class="arrow">&#8595;</span>
                <a href="index.php?action=home#recentpost">Les récents post.</a>
                <span class="arrow">&#8595;</span>
            </div>
        </section>
    </main>

    <section id="recentpost" class="recentpost">
        <?php
        $billets = $entityManager->getRepository('Billet')->findBy([], ['datePost' => 'DESC'],3);
        foreach ($billets as $billet) {
             //Div pour chaque billet
            echo "<div class='Billet-blog'>
            <div class='post-container'>
            <button class='commentButton'>Voir les commentaires</button>
            <div class='post-header'>
            <h2>{$billet->getTitre()}</h2>
            <p class='post-auteur'>Publié par {$billet->getUtilisateur()->getLogin()} le {$billet->getDatePost()->format('d/m/Y H:i')}</p>
            </div>
            <div class='post-content scroll'>";

            if ($billet->getPhotoPost() != null) {
                echo "<img src='{$billet->getPhotoPost()}' alt='' class='post-image'>";
            }

            echo "<p>{$billet->getTexte()}</p>
            </div>
            </div> ";

            //Div pour les commentaires
            echo "<div class='comments-container'>
            <h3>Commentaires</h3>
            <div class='scrollable'>";
            $messages = $entityManager->getRepository('Message')->findBy(['billet' => $billet->getId()], ['datePost' => 'DESC']);
            if ($messages){
                foreach ($messages as $message) {
                    echo "<div class='commentaire'>
                    <img src='{$message->getUtilisateur()->getPhoto()}' alt='' class='photo_profil_comment'>
                    <p>{$message->getUtilisateur()->getLogin()}</p>
                    <p>le {$message->getDatePost()->format('d/m/Y H:i')}</p>
                    <p class='text'>{$message->getTexte()}</p>
                    </div>";
                }
            } else {
                echo "<p class='text'>--Aucun commentaire pour le moment--</p>";
            }
             //Div pour le formulaire de commentaire
             echo "</div>
             <form action='index.php?action=addComment' method='POST' class='comment-form'>
             <label for='contenu'>Ajouter un commentaire :</label>
             <textarea name='contenu' id='contenu' rows='4' placeholder='Votre commentaire...' required></textarea>";

            // On récupère l'id du billet pour l'envoyer avec le commentaire
            echo "<input type='hidden' name='id_billet' value='{$billet->getId()}'>
            <input type='submit' class='button-commentaire' value='Envoyer'></button>
            </form>
            </div>
            </div>";
        }

        ?>
    </section>

    <footer>
        <p>&copy; 2024 Mon Blog. Tous droits réservés. Site fait par Nicolas Molduch</p>
    </footer>
</body>

</html>