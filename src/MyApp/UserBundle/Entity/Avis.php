<?php

namespace MyApp\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Avis
 *
 * @ORM\Table(name="avis", indexes={@ORM\Index(name="id_user", columns={"id_user"}), @ORM\Index(name="id_offreGuide", columns={"id_offreGuide"}), @ORM\Index(name="id_experience", columns={"id_experience"}), @ORM\Index(name="id_annonce", columns={"id_annonce"})})
 * @ORM\Entity
 */
class Avis
{
    /**
     * @var integer
     *
     * @ORM\Column(name="etoile", type="integer", nullable=false)
     */
    private $etoile;

    /**
     * @var integer
     *
     * @ORM\Column(name="avis", type="integer", nullable=false)
     */
    private $avis;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

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
     * @var Experience
     *
     * @ORM\ManyToOne(targetEntity="Experience")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_experience", referencedColumnName="id")
     * })
     */
    private $idExperience;

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
     * @var Offresguide
     *
     * @ORM\ManyToOne(targetEntity="Offresguide")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_offreGuide", referencedColumnName="id")
     * })
     */
    private $idOffreguide;



    /**
     * Set etoile
     *
     * @param integer $etoile
     *
     * @return Avis
     */
    public function setEtoile($etoile)
    {
        $this->etoile = $etoile;

        return $this;
    }

    /**
     * Get etoile
     *
     * @return integer
     */
    public function getEtoile()
    {
        return $this->etoile;
    }

    /**
     * Set avis
     *
     * @param integer $avis
     *
     * @return Avis
     */
    public function setAvis($avis)
    {
        $this->avis = $avis;

        return $this;
    }

    /**
     * Get avis
     *
     * @return integer
     */
    public function getAvis()
    {
        return $this->avis;
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
     * Set idAnnonce
     *
     * @param Annonce $idAnnonce
     *
     * @return Avis
     */
    public function setIdAnnonce(Annonce $idAnnonce = null)
    {
        $this->idAnnonce = $idAnnonce;

        return $this;
    }

    /**
     * Get idAnnonce
     *
     * @return \\Annonce
     */
    public function getIdAnnonce()
    {
        return $this->idAnnonce;
    }

    /**
     * Set idExperience
     *
     * @param Experience $idExperience
     *
     * @return Avis
     */
    public function setIdExperience(Experience $idExperience = null)
    {
        $this->idExperience = $idExperience;

        return $this;
    }

    /**
     * Get idExperience
     *
     * @return Experience
     */
    public function getIdExperience()
    {
        return $this->idExperience;
    }

    /**
     * Set idUser
     *
     * @param User $idUser
     *
     * @return Avis
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
     * Set idOffreguide
     *
     * @param Offresguide $idOffreguide
     *
     * @return Avis
     */
    public function setIdOffreguide(Offresguide $idOffreguide = null)
    {
        $this->idOffreguide = $idOffreguide;

        return $this;
    }

    /**
     * Get idOffreguide
     *
     * @return Offresguide
     */
    public function getIdOffreguide()
    {
        return $this->idOffreguide;
    }
}
