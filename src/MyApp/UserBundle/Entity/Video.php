<?php

namespace MyApp\UserBundle\Entity;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use Doctrine\ORM\Mapping as ORM;

/**
 * Video
 *
 * @ORM\Table(name="video", indexes={@ORM\Index(name="id_annonce", columns={"id_annonce"}), @ORM\Index(name="id_experience", columns={"id_experience", "id_offreGuide"}), @ORM\Index(name="id_offreGuide", columns={"id_offreGuide"}), @ORM\Index(name="IDX_7CC7DA2CA01A41D4", columns={"id_experience"})})
 * @ORM\Entity
 */
class Video
{
    /**
     * @var string
     *
     * @ORM\Column(name="url", type="text", length=65535, nullable=false)
     */
    private $url;
   

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
     *   @ORM\JoinColumn(name="id_offreGuide", referencedColumnName="id")
     * })
     */
    private $idOffreguide;

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
     * @var Experience
     *
     * @ORM\ManyToOne(targetEntity="Experience", inversedBy="videos" ,cascade={"persist", "remove"}, fetch="EAGER")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_experience", referencedColumnName="id")
     * })
     */
    private $idExperience;



    /**
     * Set url
     *
     * @param string $url
     *
     * @return Video
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set idOffreguide
     *
     * @param Offresguide $idOffreguide
     *
     * @return Video
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

    /**
     * Set idAnnonce
     *
     * @param Annonce $idAnnonce
     *
     * @return Video
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
     * Set idExperience
     *
     * @param Experience $idExperience
     *
     * @return Video
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
    protected $file;

    public function getPath(){
        return __DIR__.'/../../../../../u';
    }
    public function upload()
    {
        dump($this->file);
        if($this->file===null){
            return;
        }
        $a=md5(uniqid());
        $this->setUrl($a.'.'.$this->file->guessExtension());
        //$this->file->move($this->getPath(),$this->url);
        move_uploaded_file($this->file, 'C:\\wamp64\\www\\Video\\'.$a.'.'.$this->file->guessExtension());
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
