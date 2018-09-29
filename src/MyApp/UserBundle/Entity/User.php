<?php
namespace MyApp\UserBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Mgilet\NotificationBundle\Entity\UserNotificationInterface;

/**
 * @ORM\Entity(repositoryClass="MyApp\UserBundle\Repository\UserRepository")
 * @ORM\Table(name="user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Date/Time of the last activity
     *
     * @var \Datetime
     * @ORM\Column(name="last_activity_at", type="datetime", nullable = true)
     */
    protected $lastActivityAt;

    /**
     * @ORM\Column(name="nom", type="string", length=255, nullable=true)
     */
    private  $nom;
    /**
     * @ORM\Column(name="prenom", type="string", length=255, nullable=true)
     */
    private $prenom;
    /**
     * @ORM\Column(name="adresse", type="string", length=255, nullable=true)
     */
    private $adresse;
    /**
     * @ORM\Column(name="dateDeNaissance", type="string", length=255, nullable=true)
     */
    private $dateDeNaissance;
    /**
     * @ORM\Column(name="solde", type="integer", nullable=true)
     */
    private $solde;

    /**
     * @ORM\Column(name="login", type="string", length=255, nullable=true)
     */
    private $login;
    /**
     * @ORM\Column(name="etat", type="boolean",  nullable=true)
     */
    private $etat;
    /**
     * @ORM\Column(name="sexe", type="string", length=255, nullable=true)
     */
    private $sexe;
    /**
     * @ORM\Column(name="type", type="string", length=255, nullable=true)
     */
    private $type;
    /**
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;
    /**
     * @ORM\Column(name="photo", type="string", length=255, nullable=true)
     */
    private $photo;
    /**
     * @ORM\Column(name="bann_compte", type="string", length=255, nullable=true)
     */
    private $bannCompte;
    /**
     * @ORM\Column(name="bann_forum", type="boolean",  nullable=true)
     */
    private $bannForum;
    /**
     * @ORM\Column(name="id_parrain", type="integer",  nullable=true)
     */
    private $idParain;
    /**
     * @var Notification
     * @ORM\OneToMany(targetEntity="\MyApp\UserBundle\Entity\Notification", mappedBy="user", orphanRemoval=true)
     */
    protected $notifications;

    /**
     * User constructor.
     */


    public function __construct()
    {
        parent::__construct();
        $this->notifications = new ArrayCollection();
        $this->bannCompte="active";
        
    }

    public function getParent(){
        return 'FOSUserBundle';
    }

    /**
     * @return \Datetime
     */
    public function getLastActivityAt()
    {
        return $this->lastActivityAt;
    }

    /**
     * @param \Datetime $lastActivityAt
     */
    public function setLastActivityAt($lastActivityAt)
    {
        $this->lastActivityAt = $lastActivityAt;
    }

    public function isActiveNow()
    {
        // Delay during wich the user will be considered as still active
        $delay = new \DateTime('2 minutes ago');

        return ( $this->getLastActivityAt() > $delay );
    }

    /**
     * @return mixed
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * @param mixed $adresse
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
    }

    /**
     * @return mixed
     */
    public function getBannCompte()
    {
        return $this->bannCompte;
    }

    /**
     * @param mixed $bannCompte
     */
    public function setBannCompte($bannCompte)
    {
        $this->bannCompte = $bannCompte;
    }

    /**
     * @return mixed
     */
    public function getBannForum()
    {
        return $this->bannForum;
    }

    /**
     * @param mixed $bannForum
     */
    public function setBannForum($bannForum)
    {
        $this->bannForum = $bannForum;
    }

    /**
     * @return mixed
     */
    public function getDateDeNaissance()
    {
        return $this->dateDeNaissance;
    }

    /**
     * @param mixed $dateDeNaissance
     */
    public function setDateDeNaissance($dateDeNaissance)
    {
        $this->dateDeNaissance = $dateDeNaissance;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getSolde()
    {
        return $this->solde;
    }

    /**
     * @param mixed $solde
     */
    public function setSolde($solde)
    {
        $this->solde = $solde;
    }

    /**
     * @return mixed
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * @param mixed $etat
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getIdParain()
    {
        return $this->idParain;
    }

    /**
     * @param mixed $idParain
     */
    public function setIdParain($idParain)
    {
        $this->idParain = $idParain;
    }

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param mixed $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return mixed
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param mixed $prenom
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    /**
     * @return mixed
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param mixed $login
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @param mixed $photo
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
    }

    /**
     * @return mixed
     */
    public function getSexe()
    {
        return $this->sexe;
    }

    /**
     * @param mixed $sexe
     */
    public function setSexe($sexe)
    {
        $this->sexe = $sexe;
    }

    /**
     * {@inheritdoc}
     */
    public function getNotifications()
    {
        return $this->notifications;
    }

    /**
     * {@inheritdoc}
     */
    public function addNotification($notification)
    {
        if (!$this->notifications->contains($notification)) {
            $this->notifications[] = $notification;
            $notification->setUser($this);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeNotification($notification)
    {
        if ($this->notifications->contains($notification)) {
            $this->notifications->removeElement($notification);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getIdentifier()
    {
        $this->getId();
    }

}
