<?php

namespace MyApp\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pays
 *
 * @ORM\Table(name="pays", indexes={@ORM\Index(name="id_continent", columns={"id_continent"})})
 * @ORM\Entity
 */
class Pays
{
    /**
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=20, nullable=false)
     */
    private $libelle;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var Continent
     *
     * @ORM\ManyToOne(targetEntity="Continent")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_continent", referencedColumnName="id")
     * })
     */
    private $idContinent;



    /**
     * Set libelle
     *
     * @param string $libelle
     *
     * @return Pays
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle
     *
     * @return string
     */
    public function getLibelle()
    {
        return $this->libelle;
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
     * Set idContinent
     *
     * @param Continent $idContinent
     *
     * @return Pays
     */
    public function setIdContinent(Continent $idContinent = null)
    {
        $this->idContinent = $idContinent;

        return $this;
    }

    /**
     * Get idContinent
     *
     * @return Continent
     */
    public function getIdContinent()
    {
        return $this->idContinent;
    }

    function __toString()
    {
      return $this->libelle;
    }

}
