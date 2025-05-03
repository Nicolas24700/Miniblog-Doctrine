<?php 
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity]
#[ORM\Table(name: 'messages')]
class Message {
    #[ORM\Id]
    #[ORM\Column(type: Types::INTEGER)]
    #[ORM\GeneratedValue]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private string $texte;

    #[ORM\Column(name: 'datepost', type: Types::DATETIME_MUTABLE)]
    private DateTime $datePost;

    #[ORM\ManyToOne(targetEntity: Utilisateur::class)]
    private $utilisateur;

    #[ORM\ManyToOne(targetEntity: Billet::class)]
    private $billet;
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
    // ==========================
    public function getBillet(){
        return $this->billet;
    }
    public function setBillet($billet){
        $this->billet = $billet;
    }
}