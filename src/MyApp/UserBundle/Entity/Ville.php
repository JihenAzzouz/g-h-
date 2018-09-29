<?php

namespace MyApp\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ville
 *
 * @ORM\Table(name="ville", indexes={@ORM\Index(name="id_pays", columns={"id_pays"})})
 * @ORM\Entity
 */
class Ville
{
    /**
     * @var string
     *
     * @ORM\Column(name="libelle_ville", type="string", length=20, nullable=false)
     */
    private $libelleVille;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var Pays
     *
     * @ORM\ManyToOne(targetEntity="Pays")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_pays", referencedColumnName="id")
     * })
     */
    private $idPays;



    /**
     * Set libelleVille
     *
     * @param string $libelleVille
     *
     * @return Ville
     */
    public function setLibelleVille($libelleVille)
    {
        $this->libelleVille = $libelleVille;

        return $this;
    }

    /**
     * Get libelleVille
     *
     * @return string
     */
    public function getLibelleVille()
    {
        return $this->libelleVille;
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
     * Set idPays
     *
     * @param Pays $idPays
     *
     * @return Ville
     */
    public function setIdPays(Pays $idPays = null)
    {
        $this->idPays = $idPays;

        return $this;
    }

    /**
     * Get idPays
     *
     * @return Pays
     */
    public function getIdPays()
    {
        return $this->idPays;
    }

    function __toString()
    {
        return $this->libelleVille;
    }

}
