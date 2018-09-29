<?php

namespace MyApp\UserBundle\Entity;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use Doctrine\ORM\Mapping as ORM;

/**
 * Image
 *
 * @ORM\Table(name="image", indexes={@ORM\Index(name="id_experience", columns={"id_experience"}), @ORM\Index(name="is_offreGuide", columns={"id_offreGuide"}), @ORM\Index(name="id_cuisine", columns={"id_cuisine"}), @ORM\Index(name="id_annonce", columns={"id_annonce"})})
 * @ORM\Entity
 */
class Image
{
    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     */
    private $url;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_image", type="datetime", nullable=true)
     */
    private $dateImage;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_lieux", type="integer", nullable=true)
     */
    private $idLieux;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var Experience
     *
     * @ORM\ManyToOne(targetEntity="Experience", inversedBy="images", cascade={"persist", "remove"},fetch="EAGER")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_experience", referencedColumnName="id")
     * })
     */
    private $idExperience;

    /**
     * @var Annonce
     *
     * @ORM\ManyToOne(targetEntity="Annonce")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_annonce", referencedColumnName="id")
     * })
     */
    private $idAnnonce;

    /**
     * @var Cuisine
     *
     * @ORM\ManyToOne(targetEntity="Cuisine")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_cuisine", referencedColumnName="id")
     * })
     */
    private $idCuisine;

    /**
     * @var Offresguide
     *
     * @ORM\ManyToOne(targetEntity="Offresguide")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_offreGuide", referencedColumnName="id")
     * })
     */
    private $idOffreguide;



    /**
     * Set url
     *
     * @param string $url
     *
     * @return Image
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set dateImage
     *
     * @param \DateTime $dateImage
     *
     * @return Image
     */
    public function setDateImage($dateImage)
    {
        $this->dateImage = $dateImage;

        return $this;
    }

    /**
     * Get dateImage
     *
     * @return \DateTime
     */
    public function getDateImage()
    {
        return $this->dateImage;
    }

    /**
     * Set idLieux
     *
     * @param integer $idLieux
     *
     * @return Image
     */
    public function setIdLieux($idLieux)
    {
        $this->idLieux = $idLieux;

        return $this;
    }

    /**
     * Get idLieux
     *
     * @return integer
     */
    public function getIdLieux()
    {
        return $this->idLieux;
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
     * Set idExperience
     *
     * @param Experience $idExperience
     *
     * @return Image
     */
    public function setIdExperience(Experience $idExperience = null)
    {
        $this->idExperience = $idExperience;

        return $this;
    }

    /**
     * Get idExperience
     *
     * @return Experience
     */
    public function getIdExperience()
    {
        return $this->idExperience;
    }

    /**
     * Set idAnnonce
     *
     * @param Annonce $idAnnonce
     *
     * @return Image
     */
    public function setIdAnnonce(Annonce $idAnnonce = null)
    {
        $this->idAnnonce = $idAnnonce;

        return $this;
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

    /**
     * Set idCuisine
     *
     * @param Cuisine $idCuisine
     *
     * @return Image
     */
    public function setIdCuisine(Cuisine $idCuisine = null)
    {
        $this->idCuisine = $idCuisine;

        return $this;
    }

    /**
     * Get idCuisine
     *
     * @return Cuisine
     */
    public function getIdCuisine()
    {
        return $this->idCuisine;
    }

    /**
     * Set idOffreguide
     *
     * @param Offresguide $idOffreguide
     *
     * @return Image
     */
    public function setIdOffreguide(Offresguide $idOffreguide = null)
    {
        $this->idOffreguide = $idOffreguide;

        return $this;
    }

    /**
     * Get idOffreguide
     *
     * @return Offresguide
     */
    public function getIdOffreguide()
    {
        return $this->idOffreguide;
    }
    protected $file;

    public function getPath(){
        return __DIR__.'/../../../../../../../uprofils';
    }
    public function upload()
    {
        if($this->file===null){
            return;
        }
        $this->setUrl(md5(uniqid()).'.'.$this->file->guessExtension());
        $this->file->move($this->getPath(),$this->url);
        unset($this->file);
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
    public function setFile(UploadedFile $file)
    {
        $this->file = $file;
    }

    function __toString()
    {
        return $this->url;
    }
}
