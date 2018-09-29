<?php

namespace MyApp\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Paiment
 *
 * @ORM\Table(name="paiment", indexes={@ORM\Index(name="id_user", columns={"id_user"})})
 * @ORM\Entity
 */
class Paiment
{
    /**
     * @var string
     *
     * @ORM\Column(name="historique", type="string", length=40, nullable=false)
     */
    private $historique;

    /**
     * @ORM\Column(type="datetime", options={"default": 0})
     * @ORM\version=true
     */
    private $datePaiment;

    /**
     * @var integer
     *
     * @ORM\Column(name="prix", type="integer", nullable=false)
     */
    private $prix;

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
     * Set historique
     *
     * @param string $historique
     *
     * @return Paiment
     */
    public function setHistorique($historique)
    {
        $this->historique = $historique;

        return $this;
    }

    /**
     * Get historique
     *
     * @return string
     */
    public function getHistorique()
    {
        return $this->historique;
    }

    /**
     * Set datePaiment
     *
     * @param \DateTime $datePaiment
     *
     * @return Paiment
     */
    public function setDatePaiment($datePaiment)
    {
        $this->datePaiment = $datePaiment;

        return $this;
    }

    /**
     * Get datePaiment
     *
     * @return \DateTime
     */
    public function getDatePaiment()
    {
        return $this->datePaiment;
    }

    /**
     * Set prix
     *
     * @param integer $prix
     *
     * @return Paiment
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
     * @return Paiment
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
}
