<?php

namespace MyApp\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LieuxAVisiter
 *
 * @ORM\Table(name="lieux_a_visiter", indexes={@ORM\Index(name="id_guide", columns={"id_guide"})})
 * @ORM\Entity
 */
class LieuxAVisiter
{
    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=20, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="descriptif", type="text", length=65535, nullable=false)
     */
    private $descriptif;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=2000, nullable=true)
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=1600, nullable=true)
     */
    private $image;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var Offresguide
     *
     * @ORM\ManyToOne(targetEntity="Offresguide")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_guide", referencedColumnName="id")
     * })
     */
    private $idGuide;



    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return LieuxAVisiter
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set descriptif
     *
     * @param string $descriptif
     *
     * @return LieuxAVisiter
     */
    public function setDescriptif($descriptif)
    {
        $this->descriptif = $descriptif;

        return $this;
    }

    /**
     * Get descriptif
     *
     * @return string
     */
    public function getDescriptif()
    {
        return $this->descriptif;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     *
     * @return LieuxAVisiter
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return LieuxAVisiter
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
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
     * Set idGuide
     *
     * @param Offresguide $idGuide
     *
     * @return LieuxAVisiter
     */
    public function setIdGuide(Offresguide $idGuide = null)
    {
        $this->idGuide = $idGuide;

        return $this;
    }

    /**
     * Get idGuide
     *
     * @return Offresguide
     */
    public function getIdGuide()
    {
        return $this->idGuide;
    }
}
