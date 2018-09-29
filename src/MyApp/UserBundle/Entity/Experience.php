<?php

namespace MyApp\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;


/**
 * Experience
 *
 * @ORM\Table(name="experience", indexes={@ORM\Index(name="id_user", columns={"id_user"}), @ORM\Index(name="id_ville", columns={"id_ville"}), @ORM\Index(name="id_pays", columns={"id_pays"})})
 * @ORM\Entity(repositoryClass="MyApp\UserBundle\Repository\ExperienceRepository")
 */
class Experience
{
    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255, nullable=false)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=false)
     */
    private $description;

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
     * @var Ville
     *
     * @ORM\ManyToOne(targetEntity="Ville")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_ville", referencedColumnName="id")
     * })
     */
    private $idVille;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     * })
     */
    private $idUser;



    /**
     * Set titre
     *
     * @param string $titre
     *
     * @return Experience
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
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
     * Set description
     *
     * @param string $description
     *
     * @return Experience
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
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
     * @return Experience
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

    /**
     * Set idVille
     *
     * @param Ville $idVille
     *
     * @return Experience
     */
    public function setIdVille(Ville $idVille = null)
    {
        $this->idVille = $idVille;

        return $this;
    }

    /**
     * Get idVille
     *
     * @return Ville
     */
    public function getIdVille()
    {
        return $this->idVille;
    }

    /**
     * Set idUser
     *
     * @param User $idUser
     *
     * @return Experience
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

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Image" , mappedBy="idExperience", cascade={"persist", "remove"}, fetch="EAGER")
     *
     *
     */
    private $images;
    /**
     *@var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Video" , mappedBy="idExperience" ,cascade={"persist", "remove"}, fetch="EAGER")
     *
     *
     */

    private $videos;

    public function __construct()
    {
        $this->images = new  ArrayCollection();
        $this->videos = new  ArrayCollection();
    }

    public function addImage(Image $image)
    {

        $this->images->add($image);

        return $this;
    }

    public function removeImage(Image $image)
    {
        $this->images->removeElement($image);
    }

    /**
     * @return ArrayCollection
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @param ArrayCollection $images
     */
    public function setImages($images)
    {
        $this->images = $images;
    }





    protected $file;
    protected $file1;
    protected $file2;
    protected $file3;
    protected $file4;

    /**
     * @return mixed
     */
    public function getFile4()
    {
        return $this->file4;
    }

    /**
     * @param mixed $file4
     */
    public function setFile4($file4)
    {
        $this->file4 = $file4;
    }

    /**
     * @return mixed
     */
    public function getFile1()
    {
        return $this->file1;
    }

    /**
     * @param mixed $file1
     */
    public function setFile1(UploadedFile $file1)
    {
        $this->file1 = $file1;
    }

    /**
     * @return mixed
     */
    public function getFile2()
    {
        return $this->file2;
    }

    /**
     * @param mixed $file2
     */
    public function setFile2(UploadedFile $file2)
    {
        $this->file2 = $file2;
    }

    /**
     * @return mixed
     */
    public function getFile3()
    {
        return $this->file3;
    }

    /**
     * @param mixed $file3
     */
    public function setFile3(UploadedFile $file3)
    {
        $this->file3 = $file3;
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

    /**
     * @return ArrayCollection
     */
    public function getVideos()
    {
        return $this->videos;
    }

    /**
     * @param ArrayCollection $videos
     */
    public function setVideos($videos)
    {
        $this->videos = $videos;
    }



}
