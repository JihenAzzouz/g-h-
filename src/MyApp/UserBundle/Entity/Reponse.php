<?php

namespace MyApp\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reponse
 *
 * @ORM\Table(name="reponse", indexes={@ORM\Index(name="id_user", columns={"id_user"}), @ORM\Index(name="id_discussion", columns={"id_discussion"})})
 * @ORM\Entity
 */
class Reponse
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
     * @ORM\Column(name="contenu", type="text", length=65535, nullable=false)
     */
    private $contenu;

    /**
     * @var boolean
     *
     * @ORM\Column(name="edited", type="boolean", nullable=false)
     */
    private $edited;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateLastEdit", type="datetime", nullable=false)
     */
    private $datelastedit;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datePost", type="datetime", nullable=false)
     */
    private $datepost;

    /**
     * @var float
     *
     * @ORM\Column(name="rate", type="float", precision=10, scale=0, nullable=false)
     */
    private $rate;

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
     * @var Discussion
     *
     * @ORM\ManyToOne(targetEntity="Discussion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_discussion", referencedColumnName="id", onDelete="CASCADE")
     * })
     */
    private $idDiscussion;



    /**
     * Set titre
     *
     * @param string $titre
     *
     * @return Reponse
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

    function __toString()
    {
        return $this->getTitre();
    }

    /**
     * Set contenu
     *
     * @param string $contenu
     *
     * @return Reponse
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get contenu
     *
     * @return string
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * Set edited
     *
     * @param boolean $edited
     *
     * @return Reponse
     */
    public function setEdited($edited)
    {
        $this->edited = $edited;

        return $this;
    }

    /**
     * Get edited
     *
     * @return boolean
     */
    public function getEdited()
    {
        return $this->edited;
    }

    /**
     * Set datelastedit
     *
     * @param \DateTime $datelastedit
     *
     * @return Reponse
     */
    public function setDatelastedit($datelastedit)
    {
        $this->datelastedit = $datelastedit;

        return $this;
    }

    /**
     * Get datelastedit
     *
     * @return \DateTime
     */
    public function getDatelastedit()
    {
        return $this->datelastedit;
    }

    /**
     * Set datepost
     *
     * @param \DateTime $datepost
     *
     * @return Reponse
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
     * Set rate
     *
     * @param float $rate
     *
     * @return Reponse
     */
    public function setRate($rate)
    {
        $this->rate = $rate;

        return $this;
    }

    /**
     * Get rate
     *
     * @return float
     */
    public function getRate()
    {
        return $this->rate;
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
     * @return Reponse
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
     * Set idDiscussion
     *
     * @param Discussion $idDiscussion
     *
     * @return Reponse
     */
    public function setIdDiscussion(Discussion $idDiscussion = null)
    {
        $this->idDiscussion = $idDiscussion;

        return $this;
    }

    /**
     * Get idDiscussion
     *
     * @return Discussion
     */
    public function getIdDiscussion()
    {
        return $this->idDiscussion;
    }
}
