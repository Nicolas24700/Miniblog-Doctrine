<?php
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity]
#[ORM\Table(name: 'utilisateurs')]
class Utilisateur
{
    #[ORM\Id]
    #[ORM\Column(type: Types::INTEGER)]
    #[ORM\GeneratedValue]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private string $login;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private string $passwd;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private string $nom;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private string $prenom;

    #[ORM\Column(type: Types::BOOLEAN)]
    private bool $admin;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private string $photo;
    // ========================
    public function setLogin($login)
    {
        $this->login = $login;
    }
    public function getLogin()
    {
        return $this->login;
    }
    // ========================
    public function setPasswd($passwd): void
    {
        $this->passwd = $passwd;
    }
    public function getPasswd()
    {
        return $this->passwd;
    }
    // ========================
    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    // ==================
    public function getNom()
    {
        return $this->nom;
    }
    public function setNom($nom)
    {
        $this->nom = $nom;
    }
    // =================
    public function getPrenom(){
        return $this->prenom;
    }
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }
    // =================
    public function getAdmin(): bool
    {
        return $this->admin;
    }
    public function setAdmin(bool $admin)
    {
        $this->admin = $admin;
    }
    // =================
    public function getPhoto()
    {
        return $this->photo;
    }
    public function setPhoto($photo)
    {
        $this->photo = $photo;
    }

}