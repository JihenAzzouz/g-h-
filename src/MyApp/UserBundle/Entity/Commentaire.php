<?php

namespace MyApp\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* Commentaire
*
 * @ORM\Table(name="commentaire")
* @ORM\Entity
*/
class Commentaire
{

    /**
     * @var string
     *
     * @ORM\Column(name="commentaire", type="text", length=65535)
     */
    private $commentaire;

    /**
     * @var integer
     *
     * @ORM\Column(name="nblike", type="integer",nullable=true)
     */
    private $nblike;

    /**
     * @var integer
     *
     * @ORM\Column(name="dislike", type="integer", nullable=true)
     */
    private $dislike;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Date_Feedback", type="date", nullable=true)
     */
    private $dateFeedback;

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
     * @var Experience
     *
     * @ORM\ManyToOne(targetEntity="Experience")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_experience", referencedColumnName="id", nullable=true)
     * })
     */
    private $idExperience;

    /**
     * @var Annonce
     *
     * @ORM\ManyToOne(targetEntity="Annonce")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_annonce", referencedColumnName="id", nullable=true)
     * })
     */
    private $idAnnonce;

    /**
     * @var Offresguide
     *
     * @ORM\ManyToOne(targetEntity="Offresguide")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_offreGuide", referencedColumnName="id", nullable=true)
     * })
     */
    private $idOffreguide;

    /**
     * Commentaire constructor.
     */
    public function __construct()
    {
        $this->dateFeedback=new \DateTime('now');
    }

    /**
     * @return string
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }

    /**
     * @param string $commentaire
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;
    }

    /**
     * @return int
     */
    public function getNblike()
    {
        return $this->nblike;
    }

    /**
     * @param int $nblike
     */
    public function setNblike($nblike)
    {
        $this->nblike = $nblike;
    }

    /**
     * @return int
     */
    public function getDislike()
    {
        return $this->dislike;
    }

    /**
     * @param int $dislike
     */
    public function setDislike($dislike)
    {
        $this->dislike = $dislike;
    }

    /**
     * @return \DateTime
     */
    public function getDateFeedback()
    {
        return $this->dateFeedback;
    }

    /**
     * @param \DateTime $dateFeedback
     */
    public function setDateFeedback($dateFeedback)
    {
        $this->dateFeedback = $dateFeedback;
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
     * @return Experience
     */
    public function getIdExperience()
    {
        return $this->idExperience;
    }

    /**
     * @param Experience $idExperience
     */
    public function setIdExperience($idExperience)
    {
        $this->idExperience = $idExperience;
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
     * @return Offresguide
     */
    public function getIdOffreguide()
    {
        return $this->idOffreguide;
    }

    /**
     * @param Offresguide $idOffreguide
     */
    public function setIdOffreguide($idOffreguide)
    {
        $this->idOffreguide = $idOffreguide;
    }




}