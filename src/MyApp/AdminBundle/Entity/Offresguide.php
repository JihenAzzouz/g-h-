<?php

namespace MyApp\AdminBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Offresguide
 *
 * @ORM\Table(name="offresguide", indexes={@ORM\Index(name="id_ville", columns={"id_ville"}), @ORM\Index(name="id_pays", columns={"id_pays"})})
 * @ORM\Entity
 */
class Offresguide
{
    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=20, nullable=false)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="descriptif", type="text", length=65535, nullable=false)
     */
    private $descriptif;



    /**
     * @var integer
     *
     * @ORM\Column(name="tension_electricite", type="integer", nullable=false)
     */
    private $tensionElectricite;

    /**
     * @var string
     *
     * @ORM\Column(name="langue", type="string", length=20, nullable=false)
     */
    private $langue;

    /**
     * @var string
     *
     * @ORM\Column(name="capitale", type="string", length=20, nullable=false)
     */
    private $capitale;

    /**
     * @var integer
     *
     * @ORM\Column(name="population", type="integer", nullable=false)
     */
    private $population;

    /**
     * @var string
     *
     * @ORM\Column(name="monnaie", type="string", length=20, nullable=false)
     */
    private $monnaie;

    /**
     * @var integer
     *
     * @ORM\Column(name="frequence_electricite", type="integer", nullable=false)
     */
    private $frequenceElectricite;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=1500, nullable=true)
     */
    private $path;
    /**
 * @Assert\File(maxSize="6000000")
 */
    private $file;
    /**
     * @var string
     *
     * @ORM\Column(name="continent", type="string", length=300, nullable=true)
     */
    private $continent;

    /**
     * @return string
     */
    public function getContinent()
    {
        return $this->continent;
    }

    /**
     * @param string $continent
     */
    public function setContinent($continent)
    {
        $this->continent = $continent;
    }

    /**
     * @var \MyApp\UserBundle\Entity\Ville
     *
     * @ORM\ManyToOne(targetEntity="MyApp\UserBundle\Entity\Ville")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_ville", referencedColumnName="id")
     * })
     */
    private $idVille;

    /**
     * @var \MyApp\UserBundle\Entity\Pays
     *
     * @ORM\ManyToOne(targetEntity="MyApp\UserBundle\Entity\Pays")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_pays", referencedColumnName="id")
     * })
     */
    private $idPays;



    /**
     * Set titre
     *
     * @param string $titre
     *
     * @return Offresguide
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param mixed $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }


    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }


    /**
     * Set descriptif
     *
     * @param string $descriptif
     *
     * @return Offresguide
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
     * Set tensionElectricite
     *
     * @param integer $tensionElectricite
     *
     * @return Offresguide
     */
    public function setTensionElectricite($tensionElectricite)
    {
        $this->tensionElectricite = $tensionElectricite;

        return $this;
    }

    /**
     * Get tensionElectricite
     *
     * @return integer
     */
    public function getTensionElectricite()
    {
        return $this->tensionElectricite;
    }

    /**
     * Set langue
     *
     * @param string $langue
     *
     * @return Offresguide
     */
    public function setLangue($langue)
    {
        $this->langue = $langue;

        return $this;
    }

    /**
     * Get langue
     *
     * @return string
     */
    public function getLangue()
    {
        return $this->langue;
    }

    /**
     * Set capitale
     *
     * @param string $capitale
     *
     * @return Offresguide
     */
    public function setCapitale($capitale)
    {
        $this->capitale = $capitale;

        return $this;
    }

    /**
     * Get capitale
     *
     * @return string
     */
    public function getCapitale()
    {
        return $this->capitale;
    }

    /**
     * Set population
     *
     * @param integer $population
     *
     * @return Offresguide
     */
    public function setPopulation($population)
    {
        $this->population = $population;

        return $this;
    }

    /**
     * Get population
     *
     * @return integer
     */
    public function getPopulation()
    {
        return $this->population;
    }

    /**
     * Set monnaie
     *
     * @param string $monnaie
     *
     * @return Offresguide
     */
    public function setMonnaie($monnaie)
    {
        $this->monnaie = $monnaie;

        return $this;
    }

    /**
     * Get monnaie
     *
     * @return string
     */
    public function getMonnaie()
    {
        return $this->monnaie;
    }

    /**
     * Set frequenceElectricite
     *
     * @param integer $frequenceElectricite
     *
     * @return Offresguide
     */
    public function setFrequenceElectricite($frequenceElectricite)
    {
        $this->frequenceElectricite = $frequenceElectricite;

        return $this;
    }

    /**
     * Get frequenceElectricite
     *
     * @return integer
     */
    public function getFrequenceElectricite()
    {
        return $this->frequenceElectricite;
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
     * Set idVille
     *
     * @param \MyApp\UserBundle\Entity\Ville $idVille
     *
     * @return Offresguide
     */
    public function setIdVille(\MyApp\UserBundle\Entity\Ville $idVille = null)
    {
        $this->idVille = $idVille;

        return $this;
    }

    /**
     * Get idVille
     *
     * @return \MyApp\UserBundle\Entity\Ville
     */
    public function getIdVille()
    {
        return $this->idVille;
    }

    /**
     * Set idPays
     *
     * @param \MyApp\UserBundle\Entity\Pays $idPays
     *
     * @return Offresguide
     */
    public function setIdPays(\MyApp\UserBundle\Entity\Pays $idPays = null)
    {
        $this->idPays = $idPays;

        return $this;
    }

    /**
     * Get idPays
     *
     * @return \MyApp\UserBundle\Entity\Pays
     */
    public function getIdPays()
    {
        return $this->idPays;
    }









    public function getAbsolutePath()
    {
        return null === $this->path
            ? null
            : $this->getUploadRootDir() . '/' . $this->path;
    }

    public function getWebPath()
    {
        return null === $this->path
            ? null
            : $this->getUploadDir() . '/' . $this->path;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__ . '/../../../../web/' . $this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/guide';
    }


    public function upload()
    {
        // the file property can be empty if the field is not required
        if (null === $this->getFile()) {
            return;
        }

        // use the original file name here but you should
        // sanitize it at least to avoid any security issues

        // move takes the target directory and then the
        // target filename to move to
        $this->getFile()->move(
            $this->getUploadRootDir(),
            $this->getFile()->getClientOriginalName()
        );

        // set the path property to the filename where you've saved the file
        $this->path = $this->getFile()->getClientOriginalName();

        // clean up the file property as you won't need it anymore
        $this->file = null;
    }
}
