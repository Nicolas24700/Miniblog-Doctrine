<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin</title>
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
                <li><a href="index.php?action=home">Blog</a></li>
                <li><a href="index.php?action=archives">Archives</a></li>
                <li><a href="index.php?action=profil">Profil</a></li>
                <li><a href='index.php?action=admin' class="pageactive">Administration</a></li>
            </ul>
            <!-- Si l'utilisateur est connecté, on affiche vous êtes connecté, sinon on affiche Se connecter -->
            <?php if (isset($_SESSION['login'])) {
                echo "<a href='index.php?action=authentification' class='login-link'>Vous êtes connecté</a>";
            } else {
                echo "<a href='index.php?action=authentification' class='login-link'>Se connecter</a>";
            } ?>
        </nav>
    </header>
    <?php
    if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {

        ?>
        <div class="admin-section">
            <nav class="barrehorizontale">
                <ul>
                    <li><button onclick="afficherSection('createpost')">Création de Post</button></li>
                    <li><button onclick="afficherSection('utilisateurs')">Gestion des utilisateurs</button></li>
                    <li><button onclick="afficherSection('commentaires')">Gestion des post</button></li>
                </ul>
            </nav>

            <div class="main-content">
                <section id="default" class="paneladmin-section active">
                    <h1>Bienvenue sur le panel d'administration</h1>
                    <?php if (isset($_SESSION['Adminmessage'])) {
                        echo "<p class='billetmessage'>{$_SESSION['Adminmessage']}</p>";
                        unset($_SESSION['Adminmessage']);
                    } ?>
                </section>

                <!-- SECTION création de post -->
                <section id="createpost" class="paneladmin-section">
                    <h1>Création de Post</h1>
                    <div class="form-containercreateposte">
                        <h2>Créer un nouveau post</h2>
                        <form action="index.php?action=addbillet" method="POST" enctype="multipart/form-data">
                            <div class="form-groupAdmin">
                                <label for="titre">Titre du post :</label>
                                <input type="text" id="titre" name="titre" placeholder="Entrez le titre de votre post"
                                    required>
                            </div>
                            <div class="form-groupAdmin">
                                <label for="contenu">Contenu du post :</label>
                                <textarea id="contenu" name="contenu" rows="6"
                                    placeholder="Écrivez le contenu de votre post" required></textarea>
                            </div>
                            <div class="form-groupAdmin">
                                <p style='color:#FF0000'>Taille d'image conseillée 1000 X 200 px</p>
                                <label for="photo_post">Image du post :</label>
                                <input type="file" id="photo_post" name="photo_post">
                            </div>
                            <input type="submit" class="createpost-button" value="Publier le post">
                        </form>
                    </div>


                </section>
                <!-- SECTION gestion des utilisateurs -->
                <section id="utilisateurs" class="paneladmin-section">
                    <div class="tablescroll">
                        <div class="admin-container">
                            <h1>Gestion des Utilisateurs</h1>
                            <!-- Table des utilisateurs -->
                            <table>
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Login</th>
                                        <th>Nom</th>
                                        <th>Prénom</th>
                                        <th>Photo Url</th>
                                        <th>Photo de profil</th>
                                        <th>Administrateur</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $result = $entityManager->getRepository('Utilisateur')->findBy([],['id' => 'ASC']);
                                    foreach ($result as $info) {
                                        // Info Utilisateurs
                                        echo "<tr>
                                        <td>{$info->getId()}</td>
                                        <td>{$info->getLogin()}</td>
                                        <td>{$info->getNom()}</td>
                                        <td>{$info->getPrenom()}</td>
                                        <td>{$info->getPhoto()}</td>
                                        <td><img src='{$info->getPhoto()}' width='50'></td>
                                        <td>{$info->getAdmin()}</td>";

                                        // Boutons de suppresion de l'utilisateur
                                        echo "<td>
                                        <button class='custom_user'>Modifier</button>
                                        <form method='POST' action='index.php?action=suppUser'>";
                                        // On envoie l'id de l'utilisateur à supprimer avec un input hidden pour le récupérer dans le POST
                                        echo "<input type='hidden' name='delete_user' value='{$info->getId()}'>
                                        <button type='submit' class='delete-boutton'>Supprimer</button>
                                        </form>
                                        </td>

                                        </tr>";

                                        // Formulaire de modification de l'utilisateur
                                        echo "<tr class='modificationUser'>
                                        <form action='index.php?action=modifUser' method='POST'>";
                                        // On envoie l'id de l'utilisateur à modifier avec un input hidden pour le récupérer dans le POST
                                        echo "<input type='hidden' name='id_personne' value='{$info->getId()}'>
                                        <td>{$info->getId()}</td>
                                        <td>
                                        <label for='login'>Login :</label><br>
                                        <input type='text' name='login' value='{$info->getLogin()}' required>
                                        </td>
                                        <td>
                                        <label for='nom'>Nom :</label><br>
                                        <input type='text' name='nom' value='{$info->getNom()}' required>
                                        </td>
                                        <td>
                                        <label for='prenom'>Prénom :</label><br>
                                        <input type='text' name='prenom' value='{$info->getPrenom()}' required>
                                        </td>
                                        <td>
                                        <label for='photo'>Photo Url :</label><br>
                                        <input type='text' name='photo' value='{$info->getPhoto()}' required>
                                        </td>
                                        <td>
                                        <img src='{$info->getPhoto()}' alt='photo' width='50'>
                                        </td>
                                        <td>
                                        <label for='admin'>Administrateur :</label><br>
                                        <input type='text' name='admin' value='{$info->getAdmin()}'
                                        </td>
                                        <td>
                                        <button type='submit' class='modif_userform'>Modifier</button>
                                        </td>
                                        </form>
                                        </tr>";

                                    }
                                    // FORMULAIRE ORIGNALE ========================================================
                                

                                    //=============================================================================
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </section>
                <section id="commentaires" class="paneladmin-section">
                    <?php
                    $billets = $entityManager->getRepository('Billet')->findBy([], ['datePost' => 'DESC']);
                    foreach ($billets as $billet) {
                        echo "<div class='Billet-blog'>
                        <div class='post-container'>
                        <button class='commentButton'>Voir les commentaires</button>
                        <div class='post-header'>
                        <p style='color:#FF0000'>ID : {$billet->getId()}</p>
                        <h2>{$billet->getTitre()}</h2>
                        <p class='post-auteur'>Publié par {$billet->getUtilisateur()->getLogin()} le {$billet->getDatePost()->format('d/m/Y H:i')}</p>
                        </div>
                        <div class='post-content scroll'>";
                        if ($billet->getPhotoPost() != null) {
                            echo "<img src='{$billet->getPhotoPost()}' alt='' class='post-image'>";
                        }
                        echo "<p>{$billet->getTexte()}</p>
                        </div>

                        <div class='lesbouttons'>
                        <button class='modifbuttonbillet'>Modifier le billet</button>

                        <form method='POST' action='index.php?action=suppbillet'>";
                        echo "<input type='hidden' name='supp_id' value='{$billet->getId()}'>
                        <button type='submit'>Supprimer le billet</button>
                        </form>
                        </div>

                        <div class='billet_class_modif'>
                        <form method='POST' action='index.php?action=modifbillet'>";
                        echo "<input type='hidden' name='id_billets' value='{$billet->getId()}'>
                        <label for='titre'>Titre du post :</label>
                        <input type='text' id='titre' name='titre' value='{$billet->getTitre()}' required>
                        <br><br>
                        <label for='contenu'>Contenu du post :</label>
                        <textarea name='contenu' id='contenu' required>{$billet->getTexte()}</textarea>
                        <br><br>
                        <input type='submit' value='Modifier le billet'>
                        </form>
                        </div>
                        </div>

                        <div class='comments-container'>
                        <h3>Commentaires</h3>
                        <div class='scrollable'>";
                        $messages = $entityManager->getRepository('Message')->findBy(['billet' => $billet->getId()]);
                        if ($messages) {
                            foreach ($messages as $message) {
                                echo "<div class='commentaireadmin'>
                                <img src='{$message->getUtilisateur()->getPhoto()}' alt='' class='photo_profil_comment'>
                                <div class='commentaireadminP'>
                                <p style='color:#FF0000'>ID : {$message->getId()}</p>
                                <p>{$message->getUtilisateur()->getLogin()}</p>
                                <p>le {$message->getDatePost()->format('d/m/Y H:i')}</p>
                                <p>{$message->getTexte()}</p>
                                </div>
                                <form method='POST' action='index.php?action=suppcomment'>";
                                // On envoie l'id du commentaire à supprimer avec un input hidden pour le récupérer dans le POST
                                echo "<input type='hidden' name='suppcomment_id' value='{$message->getId()}'>
                                <button type='submit'>Supprimer le commentaire</button>
                                </form>
                                <br>
                                <button class='modifbuttoncomment'>Modifier le commentaire</button>

                                <div class='commentaire_class_modif'>
                                <form method='POST' action='index.php?action=modifcomment'>";
                                // On envoie l'id du commentaire à modifier avec un input hidden pour le récupérer dans le POST
                                echo "<input type='hidden' name='id_commentaires' value='{$message->getId()}'>
                                <label for='contenu'>Contenu du commentaire :</label>
                                <textarea name='contenu' id='contenu' required>{$message->getTexte()}</textarea>
                                <br><br>
                                <input type='submit' value='Modifier le commentaire'>
                                </form>
                                </div>
                                </div>";
                            }
                        } else {
                            echo "<p class='text'>--Aucun commentaire pour le moment--</p>";
                        }
                        echo "</div>
                        </div>
                        </div>";
                    }
                    ?>

                </section>
            </div>
        </div>
        <?php
    } else {
        echo "<h1 class='h1sansperm'>Vous n'avez pas les droits pour accéder à cette page</h1>";
    }
    ?>
    <footer>
        <p>&copy; 2024 Mon Blog. Tous droits réservés. Site fait par Nicolas Molduch</p>
    </footer>
</body>

</html>