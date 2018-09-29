<?php
/**
 * Created by PhpStorm.
 * User: Imen Rajhi
 * Date: 27/03/2017
 * Time: 00:29
 */

namespace MyApp\UserBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Vues
 * @package MyApp\UserBundle\Entity
 * @ORM\Entity
 */

class Vues
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private  $id;

    /**
     * @ORM\Column(type="string",length=255)
     */
    private $ipUuser;

    /**
     * @ORM\ManyToOne(targetEntity="Discussion")
     * @ORM\JoinColumn(name="idDiscussion",referencedColumnName="id",onDelete="CASCADE")
     */
    private $discussion;
    /**
     * @ORM\Column(type="datetime")
     */
    private $date;
    /**
     * Vues constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getIpUuser()
    {
        return $this->ipUuser;
    }

    /**
     * @param mixed $ipUuser
     */
    public function setIpUuser($ipUuser)
    {
        $this->ipUuser = $ipUuser;
    }

    /**
     * @return mixed
     */
    public function getDiscussion()
    {
        return $this->discussion;
    }

    /**
     * @param mixed $discussion
     */
    public function setDiscussion($discussion)
    {
        $this->discussion = $discussion;
    }




}