<?php 
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity]
#[ORM\Table(name: 'billets')]
class Billet {
    #[ORM\Id]
    #[ORM\Column(type: Types::INTEGER)]
    #[ORM\GeneratedValue]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private string $titre;

    #[ORM\Column(type: Types::TEXT)]
    private string $texte;
    
    #[ORM\Column(name: 'datepost', type: Types::DATETIME_MUTABLE)]
    private DateTime $datePost;


    #[ORM\ManyToOne(targetEntity: Utilisateur::class)]
    private $utilisateur;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $photoPost = null;

// ========================
    public function setDatePost($datePost){
        $this->datePost = $datePost;
    }
    public function getDatePost(){
        return $this->datePost;
    }
// ========================
    public function setTexte($texte){
        $this->texte = $texte;
    }
    public function getTexte(){
        return $this->texte;
    }
    // ========================
    public function setTitre($titre){
        $this->titre = $titre;
    }
    public function getTitre(){
        return $this->titre;
    }

    // ========================
    public function getId(){
        return $this->id;
    }
    public function setId($id){
        $this->id = $id;
    }
    // ========================
    public function getUtilisateur(){
        return $this->utilisateur;
    }
    public function setUtilisateur($utilisateur){
        $this->utilisateur = $utilisateur;
    }
    // ======================
    public function getPhotoPost(){
        return $this->photoPost;
    }
    public function setPhotoPost($photoPost){
        $this->photoPost = $photoPost;
    }
}