<?php

namespace MyApp\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Favoris
 *
 * @ORM\Table(name="favoris", indexes={@ORM\Index(name="id_annonce", columns={"id_annonce"}), @ORM\Index(name="id_user", columns={"id_user"})})
 * @ORM\Entity
 */
class Favoris
{
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
     * Get id
     *
     * @return integer
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
     * @param mixed $idUser
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
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
     * @param mixed $idAnnonce
     */
    public function setIdAnnonce($idAnnonce)
    {
        $this->idAnnonce = $idAnnonce;
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
