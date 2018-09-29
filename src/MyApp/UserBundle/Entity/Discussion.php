<?php

namespace MyApp\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Discussion
 *
 * @ORM\Table(name="discussion", indexes={@ORM\Index(name="id_user", columns={"id_user"}), @ORM\Index(name="id_categorie", columns={"id_categorie"})})
 * @ORM\Entity(repositoryClass="MyApp\UserBundle\Repository\DiscussionRepository")
 */
class Discussion
{
    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255, nullable=false)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=false)
     */
    private $description;

    /**
     * @var boolean
     *
     * @ORM\Column(name="open", type="boolean", nullable=false)
     */
    private $open;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datePost", type="datetime", nullable=true)
     */
    private $datepost;

    /**
     * @return \DateTime
     */
    public function getDateladtmodif()
    {
        return $this->dateladtmodif;
    }

    /**
     * @param \DateTime $dateladtmodif
     */
    public function setDateladtmodif($dateladtmodif)
    {
        $this->dateladtmodif = $dateladtmodif;
    }

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateladtmodif", type="datetime", nullable=true)
     */
    private $dateladtmodif;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datelastrep", type="datetime", nullable=true)
     */
    private $datelastrep;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbRep", type="integer", nullable=false)
     */
    private $nbrep;

    /**
     * @var integer
     *
     * @ORM\Column(name="nblikes", type="integer", nullable=true)
     */
    private $nblikes;

    /**
     * @return int
     */
    public function getNblikes()
    {
        return $this->nblikes;
    }

    /**
     * @param int $nblikes
     */
    public function setNblikes($nblikes)
    {
        $this->nblikes = $nblikes;
    }

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     * })
     */
    private $idUser;

    /**
     * @var Categorie
     *
     * @ORM\ManyToOne(targetEntity="Categorie")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_categorie", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     * })
     */
    private $idCategorie;

    /**
     * @var boolean
     *
     * @ORM\Column(name="edited", type="boolean", nullable=true)
     */
    private $edited;

    /**
     * @return boolean
     */
    public function isEdited()
    {
        return $this->edited;
    }

    /**
     * @param boolean $edited
     */
    public function setEdited($edited)
    {
        $this->edited = $edited;
    }

    /**
     * @var integer
     *
     * @ORM\Column(name="nbvues", type="integer", nullable=true)
     */
    private $nbvues;

    /**
     * @ORM\ManyToOne(targetEntity="Reponse")
     * @ORM\JoinColumn(name="idlastRep",referencedColumnName="id",onDelete="SET NULL")
     */
    private $lastRep;

    /**
     * @return mixed
     */
    public function getLastRep()
    {
        return $this->lastRep;
    }

    /**
     * @param mixed $lastRep
     */
    public function setLastRep($lastRep)
    {
        $this->lastRep = $lastRep;
    }

    /**
     * @return int
     */

    public function getNbvues()
    {
        return $this->nbvues;
    }

    /**
     * @param int $nbvues
     */
    public function setNbvues($nbvues)
    {
        $this->nbvues = $nbvues;
    }

    /**
     * Set titre
     *
     * @param string $titre
     *
     * @return Discussion
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Discussion
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set open
     *
     * @param boolean $open
     *
     * @return Discussion
     */
    public function setOpen($open)
    {
        $this->open = $open;

        return $this;
    }

    /**
     * Get open
     *
     * @return boolean
     */
    public function getOpen()
    {
        return $this->open;
    }

    /**
     * Set datepost
     *
     * @param \DateTime $datepost
     *
     * @return Discussion
     */
    public function setDatepost($datepost)
    {
        $this->datepost = $datepost;

        return $this;
    }

    /**
     * Get datepost
     *
     * @return \DateTime
     */
    public function getDatepost()
    {
        return $this->datepost;
    }

    /**
     * Set datelastrep
     *
     * @param \DateTime $datelastrep
     *
     * @return Discussion
     */
    public function setDatelastrep($datelastrep)
    {
        $this->datelastrep = $datelastrep;

        return $this;
    }

    /**
     * Get datelastrep
     *
     * @return \DateTime
     */
    public function getDatelastrep()
    {
        return $this->datelastrep;
    }

    /**
     * Set nbrep
     *
     * @param integer $nbrep
     *
     * @return Discussion
     */
    public function setNbrep($nbrep)
    {
        $this->nbrep = $nbrep;

        return $this;
    }

    /**
     * Get nbrep
     *
     * @return integer
     */
    public function getNbrep()
    {
        return $this->nbrep;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set idUser
     *
     * @param User $idUser
     *
     * @return Discussion
     */
    public function setIdUser(User $idUser = null)
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * Get idUser
     *
     * @return User
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * Set idCategorie
     *
     * @param Categorie $idCategorie
     *
     * @return Discussion
     */
    public function setIdCategorie(Categorie $idCategorie = null)
    {
        $this->idCategorie = $idCategorie;

        return $this;
    }

    /**
     * Get idCategorie
     *
     * @return Categorie
     */
    public function getIdCategorie()
    {
        return $this->idCategorie;
    }

    function __toString()
    {
        return $this->getTitre();
    }


}
