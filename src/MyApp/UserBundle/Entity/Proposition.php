<?php

namespace MyApp\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Proposition
 *
 * @ORM\Table(name="proposition", indexes={@ORM\Index(name="IDX_C7CDC3536B3CA4B", columns={"id_user"}), @ORM\Index(name="IDX_C7CDC35328C83A95", columns={"id_annonce"}), @ORM\Index(name="IDX_C7CDC353F8097ED5", columns={"id_demande"})})
 * @ORM\Entity
 */
class Proposition
{
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=40, nullable=true)
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var Demande
     *
     * @ORM\ManyToOne(targetEntity="Demande")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_demande", referencedColumnName="id")
     * })
     */
    private $idDemande;

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
     * @var Annonce
     *
     * @ORM\ManyToOne(targetEntity="Annonce")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_annonce", referencedColumnName="id")
     * })
     */
    private $idAnnonce;



    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_proposition", type="date", nullable=true)
     */
    private $dateProposition;

    /**
     * Proposition constructor.
     * @param \DateTime $dateProposition
     */
    public function __construct()
    {
        $this->dateProposition= new \DateTime('now');
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return Demande
     */
    public function getIdDemande()
    {
        return $this->idDemande;
    }

    /**
     * @param Demande $idDemande
     */
    public function setIdDemande($idDemande)
    {
        $this->idDemande = $idDemande;
    }

    /**
     * @return User
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * @param User $idUser
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
    }

    /**
     * @return Annonce
     */
    public function getIdAnnonce()
    {
        return $this->idAnnonce;
    }

    /**
     * @param Annonce $idAnnonce
     */
    public function setIdAnnonce($idAnnonce)
    {
        $this->idAnnonce = $idAnnonce;
    }

    /**
     * @return \DateTime
     */
    public function getDateProposition()
    {
        return $this->dateProposition;
    }

    /**
     * @param \DateTime $dateProposition
     */
    public function setDateProposition($dateProposition)
    {
        $this->dateProposition = $dateProposition;
    }



}
