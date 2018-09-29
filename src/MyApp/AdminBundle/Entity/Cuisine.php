<?php

namespace MyApp\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Cuisine
 *
 * @ORM\Table(name="cuisine", indexes={@ORM\Index(name="id_guide", columns={"id_guide"})})
 * @ORM\Entity
 */
class Cuisine
{
    /**
     * @var string
     *
     * @ORM\Column(name="descriptif", type="text", length=65535, nullable=false)
     */
    private $descriptif;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=20, nullable=false)
     */
    private $nom;
    /**
     * @Assert\File(maxSize="6000000")
     */
    private $file;
    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=1500, nullable=true)
     */
    private $path;

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
     * @var Offresguide
     *
     * @ORM\ManyToOne(targetEntity="Offresguide")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_guide", referencedColumnName="id")
     * })
     */
    private $idGuide;



    /**
     * Set descriptif
     *
     * @param string $descriptif
     *
     * @return Cuisine
     */
    public function setDescriptif($descriptif)
    {
        $this->descriptif = $descriptif;

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
     * Get descriptif
     *
     * @return string
     */
    public function getDescriptif()
    {
        return $this->descriptif;
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
     * Set nom
     *
     * @param string $nom
     *
     * @return Cuisine
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
     * Set prix
     *
     * @param integer $prix
     *
     * @return Cuisine
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
     * Set idGuide
     *
     * @param Offresguide $idGuide
     *
     * @return Cuisine
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
        return 'uploads/cuisine';
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
