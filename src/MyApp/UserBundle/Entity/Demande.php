<?php

namespace MyApp\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Demande
 *
 * @ORM\Table(name="demande", indexes={@ORM\Index(name="id_user", columns={"id_user"}), @ORM\Index(name="id_ville", columns={"ville"})})
 * @ORM\Entity(repositoryClass="MyApp\UserBundle\Repository\DemandeRepository")
 */
class Demande
{
    /**
     * @var string
     *
     * @ORM\Column(name="type_maison", type="string", length=20, nullable=true)
     */
    private $typeMaison;

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
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
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
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * @var \MyApp\UserBundle\User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     * })
     */
    private $idUser;

    /**
     * @var Ville
     *
     * @ORM\ManyToOne(targetEntity="Ville")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ville", referencedColumnName="id")
     * })
     */
    private $ville;

    /**
     * @var Pays
     *
     * @ORM\ManyToOne(targetEntity="Pays")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="pays", referencedColumnName="id")
     * })
     */
    private $pays;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_ajout", type="date", nullable=true)
     */
    private $dateAjout;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_modif", type="date", nullable=true)
     */
    private $dateDerniereModif;

    /**
     * Demande constructor.
     * @param \DateTime $dateAjout
     */
    public function __construct()
    {
        $this->dateAjout = new \DateTime('now');
        $this->dateDerniereModif = new \DateTime('now');

    }

    /**
     * Set typeMaison
     *
     * @param string $typeMaison
     *
     * @return Demande
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
     * @return Demande
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
     * @return Demande
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
     * @return Demande
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
     * @return Demande
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
     * Set description
     *
     * @param string $description
     *
     * @return Demande
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
     * @return Demande
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
     * @return Demande
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
     * @return Demande
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * Set idUser
     *
     * @param User $idUser
     *
     * @return Demande
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
     * Set ville
     *
     * @param Ville $ville
     *
     * @return Demande
     */
    public function setVille(Ville $ville = null)
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
     * @return Pays
     */
    public function getPays()
    {
        return $this->pays;
    }

    /**
     * @param Pays $pays
     */
    public function setPays($pays)
    {
        $this->pays = $pays;
    }

    /**
     * @return \DateTime
     */
    public function getDateAjout()
    {
        return $this->dateAjout;
    }

    /**
     * @param \DateTime $dateAjout
     */
    public function setDateAjout($dateAjout)
    {
        $this->dateAjout = $dateAjout;
    }

    /**
     * @return \DateTime
     */
    public function getDateDerniereModif()
    {
        return $this->dateDerniereModif;
    }

    /**
     * @param \DateTime $dateDerniereModif
     */
    public function setDateDerniereModif($dateDerniereModif)
    {
        $this->dateDerniereModif = $dateDerniereModif;
    }




}
