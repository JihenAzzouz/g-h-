<?php

namespace MyApp\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reservation
 *
 * @ORM\Table(name="reservation", indexes={@ORM\Index(name="id_annonce", columns={"id_annonce"}), @ORM\Index(name="id_user", columns={"id_user"})})
 * @ORM\Entity
 */
/**
 * @ORM\Entity(repositoryClass="MyApp\UserBundle\Repository\ReservationRepository")
 * @ORM\Table(name="reservation")
 */
class Reservation
{
    /**
     * @ORM\Column(type="datetime", options={"default": 0})
     * @ORM\version=true
     */
    private $dateDemande;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_debut", type="date", nullable=false)
     */
    private $dateDebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_fin", type="date", nullable=false)
     */
    private $dateFin;

    /**
     * @var integer
     *
     * @ORM\Column(name="prix_nuite", type="integer", nullable=false)
     */
    private $prixNuite;

    /**
     * @var integer
     *
     * @ORM\Column(name="nb_nuite", type="integer", nullable=false)
     */
    private $nbNuite;

    /**
     * @var integer
     *
     * @ORM\Column(name="prix", type="integer", nullable=false)
     */
    private $prix;

    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=20, nullable=false)
     */
    private $etat;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="id_User",referencedColumnName="id",onDelete="CASCADE")
     */
    private $idUser;

    /**
     * @ORM\ManyToOne(targetEntity="Annonce")
     * @ORM\JoinColumn(name="id_Annonce",referencedColumnName="id",onDelete="CASCADE")
     */
    private $idAnnonce;



    /**
     * Set dateDemande
     *
     * @param \DateTime $dateDemande
     *
     * @return Reservation
     */
    public function setDateDemande($dateDemande)
    {
        $this->dateDemande = $dateDemande;

        return $this;
    }

    /**
     * Get dateDemande
     *
     * @return \DateTime
     */
    public function getDateDemande()
    {
        return $this->dateDemande;
    }

    /**
     * Set dateDebut
     *
     * @param \DateTime $dateDebut
     *
     * @return Reservation
     */
    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    /**
     * Get dateDebut
     *
     * @return \DateTime
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * Set dateFin
     *
     * @param \DateTime $dateFin
     *
     * @return Reservation
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    /**
     * Get dateFin
     *
     * @return \DateTime
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }

    /**
     * Set prixNuite
     *
     * @param integer $prixNuite
     *
     * @return Reservation
     */
    public function setPrixNuite($prixNuite)
    {
        $this->prixNuite = $prixNuite;

        return $this;
    }

    /**
     * Get prixNuite
     *
     * @return integer
     */
    public function getPrixNuite()
    {
        return $this->prixNuite;
    }

    /**
     * Set nbNuite
     *
     * @param integer $nbNuite
     *
     * @return Reservation
     */
    public function setNbNuite($nbNuite)
    {
        $this->nbNuite = $nbNuite;

        return $this;
    }

    /**
     * Get nbNuite
     *
     * @return integer
     */
    public function getNbNuite()
    {
        return $this->nbNuite;
    }

    /**
     * Set prix
     *
     * @param integer $prix
     *
     * @return Reservation
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return integer
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Set etat
     *
     * @param string $etat
     *
     * @return Reservation
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return string
     */
    public function getEtat()
    {
        return $this->etat;
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
     * @return Reservation
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
     * Set idAnnonce
     *
     * @param Annonce $idAnnonce
     *
     * @return Reservation
     */
    public function setIdAnnonce(Annonce $idAnnonce = null)
    {
        $this->idAnnonce = $idAnnonce;

        return $this;
    }

    /**
     * Get idAnnonce
     *
     * @return Annonce
     */
    public function getIdAnnonce()
    {
        return $this->idAnnonce;
    }
}
