<?php
/**
 * Created by PhpStorm.
 * User: asma
 * Date: 07/04/2017
 * Time: 12:18
 */

namespace MyApp\UserBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * question
 *
 * @ORM\Table(name="Reponsequestionnaire")
 * @ORM\Entity
 */

class Reponsequestionnaire
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var Reponsequestionnaire
     *
     * @ORM\OneToOne(targetEntity="question")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="question", referencedColumnName="id")
     * })
     */
    private $idQuestion;


    /**
     * @ORM\Column(name="avis", type="string", length=255, nullable=true)
     */
    private $avis;

    /**
     * Reponsequestionnaire constructor.
     */
    public function __construct()
    {
    }




    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return Reponsequestionnaire
     */
    public function getIdQuestion()
    {
        return $this->idQuestion;
    }

    /**
     * @param Reponsequestionnaire $idQuestion
     */
    public function setIdQuestion($idQuestion)
    {
        $this->idQuestion = $idQuestion;
    }

    /**
     * @return mixed
     */
    public function getAvis()
    {
        return $this->avis;
    }

    /**
     * @param mixed $avis
     */
    public function setAvis($avis)
    {
        $this->avis = $avis;
    }



}