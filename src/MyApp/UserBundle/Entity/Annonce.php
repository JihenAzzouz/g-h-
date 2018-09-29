<?php

namespace MyApp\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Annonce
 *
 * @ORM\Table(name="annonce", indexes={@ORM\Index(name="id_user", columns={"id_user"}), @ORM\Index(name="id_ville", columns={"ville"}), @ORM\Index(name="id_continent", columns={"id_continent"}), @ORM\Index(name="id_pays", columns={"id_pays"})})
 * @ORM\Entity(repositoryClass="MyApp\UserBundle\Repository\AnnonceRepository")
 */
class Annonce
{
    /**
     * @var string
     *
     * @ORM\Column(name="type_maison", type="string", length=20, nullable=true)
     */
    private $typeMaison;


    /**
     * @ORM\Column(type="datetime", options={"default": 0})
     * @ORM\version=true
     */
    private $dateDemande;

    /**
     * @return mixed
     */
    public function getDateDemande()
    {
        return $this->dateDemande;
    }



    /**
     * @var string
     *
     * @ORM\Column(name="type_logement", type="string", length=20, nullable=true)
     */
    private $typeLogement;

    /**
     * @var integer
     *
     * @ORM\Column(name="nombre_chambre", type="integer", nullable=true)
     */
    private $nombreChambre;

    /**
     * @var integer
     *
     * @ORM\Column(name="nombre_salle_deBain", type="integer", nullable=true)
     */
    private $nombreSalleDebain;

    /**
     * @var integer
     *
     * @ORM\Column(name="nombre_voyageur", type="integer", nullable=true)
     */
    private $nombreVoyageur;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbre_lit", type="integer", nullable=true)
     */
    private $nbreLit;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_debut", type="date", nullable=true)
     */
    private $dateDebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_fin", type="date", nullable=true)
     */
    private $dateFin;

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float", precision=10, scale=0, nullable=true)
     */
    private $prix;

    /**
     * @var string
     *
     * @ORM\Column(name="image360", type="string", length=200, nullable=true)
     */
    private $image360;

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
     * @var string
     *
     * @ORM\Column(name="id_pays", type="string", length=40, nullable=true)
     */
    private $idPays;

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
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=40, nullable=true)
     */
    private $ville;
    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=255, nullable=true)
     */
    private $adresse;
    /**
     * @var string
     *
     * @ORM\Column(name="longitude", type="string", length=255, nullable=true)
     */
    private $longitude;
    /**
     * @var string
     *
     * @ORM\Column(name="altitude", type="string", length=255, nullable=true)
     */
    private $altitude;

    /**
     * @return string
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param string $longitude
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }

    /**
     * @return string
     */
    public function getAltitude()
    {
        return $this->altitude;
    }

    /**
     * @param string $altitude
     */
    public function setAltitude($altitude)
    {
        $this->altitude = $altitude;
    }
    /**
     * @var string
     *
     * @ORM\Column(name="rue", type="string", length=40, nullable=true)
     */
    private $rue;
private $file1;
    private $file2;
    private $file3;
    private $file4;
    private $file5;
    private $file6;

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
    public function getFile4()
    {
        return $this->file4;
    }

    /**
     * @param mixed $file4
     */
    public function setFile4(UploadedFile $file4)
    {
        $this->file4 = $file4;
    }

    /**
     * @return mixed
     */
    public function getFile5()
    {
        return $this->file5;
    }

    /**
     * @param mixed $file5
     */
    public function setFile5(UploadedFile $file5)
    {
        $this->file5 = $file5;
    }

    /**
     * @return mixed
     */
    public function getFile6()
    {
        return $this->file6;
    }

    /**
     * @param mixed $file6
     */
    public function setFile6(UploadedFile $file6)
    {
        $this->file6 = $file6;
    }


    /**
     * Annonce constructor.
     * @param ArrayCollection $image
     */
    public function __construct()
    {
        $this->image = new ArrayCollection();
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
     * @return ArrayCollection
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param ArrayCollection $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }






    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Image" , mappedBy="idAnnonce",cascade={"persist"})

     */
private $image;
    /**
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * @param string $adresse
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
    }

    /**
     * @return string
     */
    public function getRue()
    {
        return $this->rue;
    }

    /**
     * @param string $rue
     */
    public function setRue($rue)
    {
        $this->rue = $rue;
    }

    /**
     * @return string
     */
    public function getBatiment()
    {
        return $this->batiment;
    }

    /**
     * @param string $batiment
     */
    public function setBatiment($batiment)
    {
        $this->batiment = $batiment;
    }

    /**
     * @return int
     */
    public function getCodePostal()
    {
        return $this->codePostal;
    }

    /**
     * @param int $codePostal
     */
    public function setCodePostal($codePostal)
    {
        $this->codePostal = $codePostal;
    }
    /**
     * @var string
     *
     * @ORM\Column(name="batiment", type="string", length=40, nullable=true)
     */
    private $batiment;

    /**
     * @var integer
     *
     * @ORM\Column(name="codePostal", type="integer", nullable=false)
     */
    private $codePostal;


    /**
     * Set typeMaison
     *
     * @param string $typeMaison
     *
     * @return Annonce
     */
    public function setTypeMaison($typeMaison)
    {
        $this->typeMaison = $typeMaison;

        return $this;
    }

    /**
     * Get typeMaison
     *
     * @return string
     */
    public function getTypeMaison()
    {
        return $this->typeMaison;
    }

    /**
     * Set typeLogement
     *
     * @param string $typeLogement
     *
     * @return Annonce
     */
    public function setTypeLogement($typeLogement)
    {
        $this->typeLogement = $typeLogement;

        return $this;
    }

    /**
     * Get typeLogement
     *
     * @return string
     */
    public function getTypeLogement()
    {
        return $this->typeLogement;
    }

    /**
     * Set nombreChambre
     *
     * @param integer $nombreChambre
     *
     * @return Annonce
     */
    public function setNombreChambre($nombreChambre)
    {
        $this->nombreChambre = $nombreChambre;

        return $this;
    }

    /**
     * Get nombreChambre
     *
     * @return integer
     */
    public function getNombreChambre()
    {
        return $this->nombreChambre;
    }

    /**
     * Set nombreSalleDebain
     *
     * @param integer $nombreSalleDebain
     *
     * @return Annonce
     */
    public function setNombreSalleDebain($nombreSalleDebain)
    {
        $this->nombreSalleDebain = $nombreSalleDebain;

        return $this;
    }

    /**
     * Get nombreSalleDebain
     *
     * @return integer
     */
    public function getNombreSalleDebain()
    {
        return $this->nombreSalleDebain;
    }

    /**
     * Set nombreVoyageur
     *
     * @param integer $nombreVoyageur
     *
     * @return Annonce
     */
    public function setNombreVoyageur($nombreVoyageur)
    {
        $this->nombreVoyageur = $nombreVoyageur;

        return $this;
    }

    /**
     * Get nombreVoyageur
     *
     * @return integer
     */
    public function getNombreVoyageur()
    {
        return $this->nombreVoyageur;
    }

    /**
     * Set nbreLit
     *
     * @param integer $nbreLit
     *
     * @return Annonce
     */
    public function setNbreLit($nbreLit)
    {
        $this->nbreLit = $nbreLit;

        return $this;
    }

    /**
     * Get nbreLit
     *
     * @return integer
     */
    public function getNbreLit()
    {
        return $this->nbreLit;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Annonce
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
     * Set dateDebut
     *
     * @param \DateTime $dateDebut
     *
     * @return Annonce
     */
    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    /**
     * Get dateDebut
     *
     * @return \DateTime
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * Set dateFin
     *
     * @param \DateTime $dateFin
     *
     * @return Annonce
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    /**
     * Get dateFin
     *
     * @return \DateTime
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }

    /**
     * Set prix
     *
     * @param float $prix
     *
     * @return Annonce
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return float
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Set image360
     *
     * @param string $image360
     *
     * @return Annonce
     */
    public function setImage360($image360)
    {
        $this->image360 = $image360;

        return $this;
    }

    /**
     * Get image360
     *
     * @return string
     */
    public function getImage360()
    {
        return $this->image360;
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
     * @return Annonce
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

    /**
     * Set idPays
     *
     * @param Pays $idPays
     *
     * @return Annonce
     */
    public function setIdPays($idPays)
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
     * Set idUser
     *
     * @param User $idUser
     *
     * @return Annonce
     */
    public function setIdUser(User $idUser)
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
     * Set ville
     *
     * @param Ville $ville
     *
     * @return Annonce
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return Ville
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
}
