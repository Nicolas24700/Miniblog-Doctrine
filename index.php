<?php
//permet de définir le fuseau horaire français pour les dates et heures.
date_default_timezone_set('Europe/Paris');
require_once 'bootstrap.php';

session_start();

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
    case 'authentification':
        include('./views/authentification.php');
        break;
    case 'inscription':
        // include('./views/authentification.php');
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $login = $_POST['login'];
            $motdepasse = $_POST['motdepasse'];
            $motdepasse2 = $_POST['motdepasse2'];

            if ($motdepasse !== $motdepasse2) {
                $_SESSION['error'] = "Les mots de passe ne correspondent pas";
            } else {
                $utilisateurexistant = $entityManager->getRepository('Utilisateur')->findOneBy(['login' => $login]);
                if ($utilisateurexistant) {
                    $_SESSION['error'] = "Login déjà pris";
                } else {
                    $utilisateur = new Utilisateur();
                    $photo = "images/uploads/profil_default.png";
                    $utilisateur->setPrenom($prenom);
                    $utilisateur->setNom($nom);
                    $utilisateur->setLogin($login);
                    $utilisateur->setAdmin(false);
                    $utilisateur->setPhoto($photo);
                    $utilisateur->setPasswd(password_hash($motdepasse, PASSWORD_BCRYPT));
                    $entityManager->persist($utilisateur);
                    $entityManager->flush();
                    $_SESSION['error'] = "Inscription réussie. Vous pouvez vous connecter";
                }
            }
        }
        include('./views/authentification.php');
        break;
    case 'connexion':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $login = $_POST['login'];
            $motdepasse = $_POST['motdepasse'];

            $utilisateur = $entityManager->getRepository('Utilisateur')->findOneBy(['login' => $login]);

            if ($utilisateur && password_verify($motdepasse, $utilisateur->getPasswd())) {
                $_SESSION["login"] = $utilisateur->getLogin();
                $_SESSION['admin'] = $utilisateur->getAdmin();
                header('Location: index.php?action=home');
            } else {
                $_SESSION["errorconnexion"] = "Login ou mot de passe incorrect";
                include('./views/authentification.php');
            }
        }
        break;
    case 'home':
        include('./views/blog.php');
        break;
    case 'logout':
        $_SESSION = array();
        session_destroy();
        header('Location: index.php');
        break;
    // =============== profil ===============
    case 'profil':
        if (isset($_SESSION['login'])) {
            $login = $_SESSION['login'];
            $utilisateur = $entityManager->getRepository('Utilisateur')->findOneBy(['login' => $login]);
        }
        include('./views/profil.php');
        break;
    case 'upload_Photo':
        if (isset($_FILES['photo'])) {
            if (isset($_SESSION['login'])) {
                $login = $_SESSION['login'];
                $user = $entityManager->getRepository('Utilisateur')->findOneBy(['login' => $login]);

                if ($user) {
                    $id_personne = $user->getId();
                    $target_dir = "images/uploads/";
                    $imageFileType = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
                    $target_file = $target_dir . "profil_" . $id_personne . "." . $imageFileType;
                    $uploadOk = 1;

                    // Limite la taille du fichier (1 Mo ici)
                    if ($_FILES['photo']['size'] > 1000000) {
                        $_SESSION['message'] = "Désolé, votre fichier est supérieur à 1Mo.";
                        $uploadOk = 0;
                    }

                    // Limite les formats de fichiers
                    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                        $_SESSION['message'] = "Désolé, seul les formats JPG, JPEG, PNG & GIF sont autorisée.";
                        $uploadOk = 0;
                    }

                    // Supprimer l'ancien fichier s'il existe
                    if (file_exists($target_file)) {
                        // Supprime le fichier
                        unlink($target_file);
                    }

                    // Si tout est ok, uploade le fichier
                    if ($uploadOk && move_uploaded_file($_FILES['photo']['tmp_name'], $target_file)) {
                        $user->setPhoto($target_file);
                        $entityManager->flush();
                        $_SESSION['message'] = "La photo de profil a été mise à jour avec succès.";

                    }
                }
            } else {
                $_SESSION['message'] = "Vous devez être connectée pour uploader une photo de profil.";
            }
        }
        header('Location: index.php?action=profil');
        break;
    // ==============================
    case 'archives':
        include('./views/archives.php');
        break;
    // =============== ADMIN ===============
    case 'admin':
        include('./views/admin.php');
        break;
    // =============== AJOUT / MODIFICATION / SUPPRESSION DE BILLET ===============
    case 'addbillet':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
                $titre = $_POST['titre'];
                $contenu = $_POST['contenu'];
                $login = $_SESSION['login'];

                $utilisateur = $entityManager->getRepository('Utilisateur')->findOneBy(['login' => $login]);
                $target_file = null;


                if (isset($_FILES['photo_post']) && $_FILES['photo_post']['error'] == 0) {
                    $target_dir = "images/uploads_post/";
                    $imageFileType = strtolower(pathinfo($_FILES['photo_post']['name'], PATHINFO_EXTENSION));
                    $target_file = $target_dir . "post_" . time() . "." . $imageFileType;
                    $uploadOk = 1;
                    if ($_FILES['photo_post']['size'] > 1000000) {
                        $_SESSION['Adminmessage'] = "Désolé, le post n'a pas été uploadé car votre image dépasse 1Mo.";
                        $uploadOk = 0;
                    }

                    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                        $_SESSION['Adminmessage'] = "Désolé, seul les formats JPG, JPEG, PNG & GIF sont autorisés. Votre post a été uploadé sans votre image.";
                        $uploadOk = 0;
                    }

                    if ($uploadOk && move_uploaded_file($_FILES['photo_post']['tmp_name'], $target_file)) {

                        $Billet = new Billet();
                        $Billet->setTitre($titre);
                        $Billet->setTexte($contenu);
                        $Billet->setDatePost(new DateTime());
                        $Billet->setUtilisateur($utilisateur);
                        $Billet->setPhotoPost($target_file);
                        $entityManager->persist($Billet);
                        $entityManager->flush();

                        $_SESSION['Adminmessage'] = "Le Post " . $titre . " a été uploadé avec succès.";
                    } else {
                        $target_file = null;
                    }
                } else {
                    $Billet = new Billet();
                    $Billet->setTitre($titre);
                    $Billet->setTexte($contenu);
                    $Billet->setDatePost(new DateTime());
                    $Billet->setUtilisateur($utilisateur);
                    $Billet->setPhotoPost($target_file);
                    $entityManager->persist($Billet);
                    $entityManager->flush();

                    $_SESSION['Adminmessage'] = "Le Post " . $titre . " a été uploadé avec succès.";
                }
            } else {
                $_SESSION['Adminmessage'] = "vous n'avez pas les permissions";
            }
            include('./views/admin.php');
        }
        break;
    case 'modifbillet':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
                $titre = $_POST['titre'];
                $contenu = $_POST['contenu'];
                $id = $_POST['id_billets'];

                $billet = $entityManager->getRepository('Billet')->find($id);
                $billet->setTitre($titre);
                $billet->setTexte($contenu);
                $entityManager->flush();
                $_SESSION['Adminmessage'] = "Le Billet $id avec comme titre : $titre , à été modifié avec succès.";
                include('./views/admin.php');
            } else {
                echo "vous n'avez pas les permissions";
            }
        }
        break;
    case 'suppbillet':
        if (isset($_POST['supp_id'])) {
            if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
                $postId = $_POST['supp_id'];
                $billet = $entityManager->getRepository('Billet')->find($postId);
                $profilePost = $billet->getPhotoPost();

                if ($profilePost && file_exists($profilePost)) {
                    unlink($profilePost);
                }

                $_SESSION['Adminmessage'] = "Le Billet $postId à été supprimé avec succès.";
                $billet = $entityManager->getRepository('Billet')->find($postId);
                $entityManager->remove($billet);
                $entityManager->flush();
                include('./views/admin.php');
            } else {
                echo "vous n'avez pas les permissions";
            }
        }
        break;
    // =============== MODIFICATION / SUPPRESSION D'UTILISATEUR ===============
    case 'suppUser':
        if (isset($_POST['delete_user'])) {
            if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
                $userId = $_POST['delete_user'];

                $utilisateur = $entityManager->getRepository('Utilisateur')->find($userId);

                if ($utilisateur) {
                    // Supprimer les commentaires de l'utilisateur
                    $commentaires = $entityManager->getRepository('Message')->findBy(['utilisateur' => $utilisateur]);
                    foreach ($commentaires as $commentaire) {
                        $entityManager->remove($commentaire);
                    }

                    // Supprimer la photo de profil si elle existe et n'est pas l'image par défaut
                    $profilePic = $utilisateur->getPhoto();
                    if ($profilePic && file_exists($profilePic)) {
                        if ($profilePic !== "images/uploads/profil_default.png") {
                            unlink($profilePic);
                        }
                    }

                    // Supprimer l'utilisateur
                    $entityManager->remove($utilisateur);
                    $entityManager->flush();

                    $_SESSION['Adminmessage'] = "Utilisateur $userId a été supprimé avec succès.";
                } else {
                    $_SESSION['Adminmessage'] = "Utilisateur non trouvé.";
                }
                include('./views/admin.php');
            } else {
                echo "vous n'avez pas les permissions";
            }
        }
        break;
    case 'modifUser':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
                $prenom = $_POST['prenom'];
                $nom = $_POST['nom'];
                $login = $_POST['login'];
                $photo = $_POST['photo'];
                $admin = $_POST['admin'];

                $utilisateur = $entityManager->getRepository('Utilisateur')->find($_POST['id_personne']);
                $utilisateur->setPrenom($prenom);
                $utilisateur->setNom($nom);
                $utilisateur->setLogin($login);
                $utilisateur->setPhoto($photo);
                $utilisateur->setAdmin($admin);
                $entityManager->flush();

                $_SESSION['Adminmessage'] = "Utilisateur $login a été modifié avec succès.";
                include('./views/admin.php');
            } else {
                echo "vous n'avez pas les permissions";
            }
            include('./views/admin.php');
        }
        break;
    // =============== AJOUT / MODIFICATION / SUPPRESSION DE COMMENTAIRE ===============
    case 'addComment':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_SESSION['login'])) {

                $billetId = $_POST['id_billet'];
                $contenu = $_POST['contenu'];

                $login = $_SESSION["login"];
                $utilisateur = $entityManager->getRepository('Utilisateur')->findOneBy(['login' => $login]);
                $auteur_id = $utilisateur->getId();

                $billet = $entityManager->getRepository('Billet')->find($billetId);

                $message = new Message();
                $message->setTexte($contenu);
                $message->setDatePost(new DateTime());
                $message->setUtilisateur($utilisateur);
                $message->setBillet($billet);
                $entityManager->persist($message);
                $entityManager->flush();
                header('Location: index.php?action=blog');
            } else {
                $_SESSION['message'] = "Vous devez être connecté pour ajouter un commentaire";
                header('Location: index.php?action=blog');
            }

        }
        break;
    case 'modifcomment':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
                $contenu = $_POST['contenu'];
                $IDcomment = $_POST['id_commentaires'];

                $_SESSION['Adminmessage'] = "Le commentaire $IDcomment du Post à été modifié avec succès, maintenant le commentaire est {$contenu}.";

                $commentaire = $entityManager->getRepository('Message')->find($IDcomment);
                $commentaire->setTexte($contenu);
                $entityManager->flush();
                include('./views/admin.php');
            } else {
                echo "vous n'avez pas les permissions";
            }
        }
        break;
    case 'suppcomment':
        if (isset($_POST['suppcomment_id'])) {
            if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
                $suppId = $_POST['suppcomment_id'];

                $commentaire = $entityManager->getRepository('Message')->find($suppId);
                $entityManager->remove($commentaire);
                $entityManager->flush();

                $_SESSION['Adminmessage'] = "Le commentaire $suppId à été supprimé avec succès.";
                include('./views/admin.php');
            } else {
                echo "vous n'avez pas les permissions";
            }
        }
        break;
    default:
        include './views/blog.php';
        break;

}

?>