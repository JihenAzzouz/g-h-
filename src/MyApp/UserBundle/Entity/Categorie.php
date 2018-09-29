<?php

namespace MyApp\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Categorie
 *
 * @ORM\Table(name="categorie")
 * @ORM\Entity
 */
class Categorie
{
    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=20, nullable=false)
     */
    private $titre;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbDiss", type="integer", nullable=false)
     */
    private $nbdiss;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbMsg", type="integer", nullable=false)
     */
    private $nbmsg;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    /**
     * @var Discussion
     *
     * @ORM\ManyToOne(targetEntity="Discussion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="lastmodifdis", referencedColumnName="id", onDelete="SET NULL")
     * })
     */
    private $lastmodifdis;

    /**
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * @param string $titre
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
    }

    /**
     * @return int
     */
    public function getNbdiss()
    {
        return $this->nbdiss;
    }

    /**
     * @param int $nbdiss
     */
    public function setNbdiss($nbdiss)
    {
        $this->nbdiss = $nbdiss;
    }

    /**
     * @return int
     */
    public function getNbmsg()
    {
        return $this->nbmsg;
    }

    /**
     * @param int $nbmsg
     */
    public function setNbmsg($nbmsg)
    {
        $this->nbmsg = $nbmsg;
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
     * @return Discussion
     */
    public function getLastmodifdis()
    {
        return $this->lastmodifdis;
    }

    /**
     * @param Discussion $lastmodifdis
     */
    public function setLastmodifdis($lastmodifdis)
    {
        $this->lastmodifdis = $lastmodifdis;
    }

    function __toString()
    {
        return $this->getTitre();
    }


}
