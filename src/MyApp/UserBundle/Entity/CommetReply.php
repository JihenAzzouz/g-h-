<?php
/**
 * Created by PhpStorm.
 * User: asma
 * Date: 03/04/2017
 * Time: 11:39
 */

namespace MyApp\UserBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Commentaire
 *
 * @ORM\Table(name="commentreply")
 * @ORM\Entity
 */

class CommetReply
{
    /**
     * @var string
     *
     * @ORM\Column(name="commentairereply", type="text", length=65535)
     */
    private $commentaireReply;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Date_reply", type="date", nullable=true)
     */
    private $dateReply;

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
     * @var Commentaire
     *
     * @ORM\ManyToOne(targetEntity="Commentaire")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_commentaire", referencedColumnName="id")
     * })
     */
    private $idCommentaire;

    /**
     * @return string
     */
    public function getCommentaireReply()
    {
        return $this->commentaireReply;
    }

    /**
     * @param string $commentaireReply
     */
    public function setCommentaireReply($commentaireReply)
    {
        $this->commentaireReply = $commentaireReply;
    }

    /**
     * @return \DateTime
     */
    public function getDateReply()
    {
        return $this->dateReply;
    }

    /**
     * @param \DateTime $dateReply
     */
    public function setDateReply($dateReply)
    {
        $this->dateReply = $dateReply;
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
     * @return Commentaire
     */
    public function getIdCommentaire()
    {
        return $this->idCommentaire;
    }

    /**
     * @param Commentaire $idCommentaire
     */
    public function setIdCommentaire($idCommentaire)
    {
        $this->idCommentaire = $idCommentaire;
    }


    public function __construct()
    {
        $this->dateReply=new \DateTime('now');
    }
}