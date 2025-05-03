document.addEventListener('DOMContentLoaded', function () {

    // SCRIPT POUR AFFICHER LES COMMENTAIRES
    const commentButtons = document.querySelectorAll('.commentButton');
    const commentaires = document.querySelectorAll('.comments-container');
    const postContainers = document.querySelectorAll('.post-container');

    commentButtons.forEach((button, index) => {
        button.addEventListener("click", function (event) {
            const commentaire = commentaires[index];
            const postContainer = postContainers[index];

            commentaire.classList.toggle('visible');
            postContainer.classList.toggle('with-comments');
        });
    });

    const modifbutton = document.querySelectorAll('.modifbuttonbillet');
    const billetmodif = document.querySelectorAll('.billet_class_modif');


    // boutton modif billets
    modifbutton.forEach((button, index) => {
        button.addEventListener("click", function (event) {
            const billetmodifs = billetmodif[index];

            if (billetmodifs.style.display === "") {
                billetmodifs.style.display = "block";
            } else {
                billetmodifs.style.display = "";
            }
        });
    });

    // boutton modif commentaires
    const modifcomment = document.querySelectorAll('.modifbuttoncomment');
    const commentmodif = document.querySelectorAll('.commentaire_class_modif');


    modifcomment.forEach((button, index) => {
        button.addEventListener("click", function (event) {
            const commentmodifs = commentmodif[index];

            if (commentmodifs.style.display === "") {
                commentmodifs.style.display = "block";
            } else {
                commentmodifs.style.display = "";
            }
        });
    });

});


// SCRIPT SCROLL NAVBAR 
window.addEventListener('scroll', function () {
    const navbar = document.getElementById('navbar');
    if (window.scrollY > 0) {
        navbar.classList.add('fixed-navbar');
    } else {
        navbar.classList.remove('fixed-navbar');
    }
});

// SCRIPT POUR AFFICHER LES SECTIONS DU PANEL ADMIN
function afficherSection(sectionId) {
    document.querySelectorAll('.paneladmin-section').forEach(section => {
        section.classList.remove('active');
    });
    document.getElementById(sectionId).classList.add('active');
}

// SCRIPT POUR AFFICHER LE FORMULAIRE DE MODIFICATION D'UN UTILISATEUR

const customUserButtons = document.querySelectorAll('.custom_user');
const modificationUsers = document.querySelectorAll('.modificationUser');

customUserButtons.forEach((button, index) => {
    button.addEventListener("click", function (event) {
        const modificationUser = modificationUsers[index];

        if (modificationUser.style.display == "") {
            modificationUser.style.display = "table-row";
        } else {
            modificationUser.style.display = "";
        }
    })
});