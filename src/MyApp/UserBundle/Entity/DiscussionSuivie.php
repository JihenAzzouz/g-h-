<?php

namespace MyApp\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DiscussionSuivie
 *
 * @ORM\Table(name="discussion_suivie")
 * @ORM\Entity
 */
class DiscussionSuivie
{
    /**
     * @var \string
     *
     * @ORM\Column(name="nature", type="string", length=255, nullable=false)
     */
    private $nature;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="iduser", referencedColumnName="id")
     * })
     */
    private $iduser;

    /**
     * @var Discussion
     *
     * @ORM\ManyToOne(targetEntity="Reponse")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idrep", referencedColumnName="id", nullable=true, onDelete="CASCADE")
     * })
     */
    private $idrep;

    /**
     * @var Discussion
     *
     * @ORM\ManyToOne(targetEntity="Discussion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="iddis", referencedColumnName="id", nullable=true, onDelete ="CASCADE")
     * })
     */
    private $iddis;

    /**
     * @return Discussion
     */
    public function getIddis()
    {
        return $this->iddis;
    }

    /**
     * @param Discussion $iddis
     */
    public function setIddis($iddis)
    {
        $this->iddis = $iddis;
    }

    /**
     * @return string
     */
    public function getNature()
    {
        return $this->nature;
    }

    /**
     * @param string $nature
     */
    public function setNature($nature)
    {
        $this->nature = $nature;
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
     * @return User
     */
    public function getIduser()
    {
        return $this->iduser;
    }

    /**
     * @param User $iduser
     */
    public function setIduser($iduser)
    {
        $this->iduser = $iduser;
    }

    /**
     * @return Discussion
     */
    public function getIdrep()
    {
        return $this->idrep;
    }

    /**
     * @param Discussion $idrep
     */
    public function setIdrep($idrep)
    {
        $this->idrep = $idrep;
    }

}
