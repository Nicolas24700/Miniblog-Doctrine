<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription et Connexion</title>
    <link rel="stylesheet" href="./views/styles.css">
    <link rel="icon" href="./images/img_site/logo_blog.png" type="image/x-icon">
</head>

<body>
    <header>
        <nav class="navbar" id="navbar">
            <a href="index.php?action=home" class="logo">
                <img src="./images/img_site/logo_blog.png" alt="Accueil">
            </a>
            <ul class="nav-links">
                <li><a href="index.php?action=home">Blog</a></li>
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


    <section class="formconnexion">
        <div class="form-container" id="connexion">
            <h2>Connexion</h2>
            <!-- Affichage de l'erreur si il y'a une erreur -->
            <?php if (isset($_SESSION['errorconnexion'])) {
                echo "<p style='color: red;'>{$_SESSION['errorconnexion']}</p>";
                unset($_SESSION['errorconnexion']);
            } ?>
            <form action="index.php?action=connexion" method="POST">
                <div class="form-group">
                    <label for="login">Nom d'utilisateur :</label>
                    <input type="text" id="login" name="login" required>
                </div>
                <div class="form-group">
                    <label for="motdepasse">Mot de passe:</label>
                    <input type="password" id="motdepasse" name="motdepasse" required>
                </div>
                <input type="submit" class="button-form" value="Se connecter">
            </form>
        </div>
        <div class="form-container" id="inscription">
            <h2>Inscription</h2>

            <?php if (isset($_SESSION['error'])) {
                echo "<p style='color: red;'>{$_SESSION['error']}</p>";
                unset($_SESSION['error']);
            } ?>

            <form action="index.php?action=inscription" method="POST">
                <div class="form-group">
                    <label for="nom">Nom :</label>
                    <input type="text" id="nom" name="nom" required>
                </div>
                <div class="form-group">
                    <label for="prenom">Prénom :</label>
                    <input type="text" id="prenom" name="prenom" required>
                </div>
                <div class="form-group">
                    <label for="login">Nom d'utilisateur:</label>
                    <input type="text" id="login" name="login" required>
                </div>
                <div class="form-group">
                    <label for="motdepasse">Mot de passe:</label>
                    <input type="password" id="motdepasse" name="motdepasse" required>
                </div>
                <div class="form-group">
                    <label for="motdepasse2">Confirmer le mot de passe:</label>
                    <input type="password" id="motdepasse2" name="motdepasse2" required>
                </div>
                <input type="submit" class="button-form" value="S'inscrire">
            </form>
        </div>
    </section>
    <footer>
        <p>&copy; 2024 Mon Blog. Tous droits réservés. Site fait par Nicolas Molduch</p>
    </footer>
</body>

</html>