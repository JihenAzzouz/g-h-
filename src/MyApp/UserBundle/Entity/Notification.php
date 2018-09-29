<?php
/**
 * Created by PhpStorm.
 * User: amira
 * Date: 03/04/2017
 * Time: 22:20
 */

namespace MyApp\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Mgilet\NotificationBundle\Entity\AbstractNotification;

/**
 * @ORM\Entity
 * @ORM\Table(name="notification")
 */
class Notification extends AbstractNotification
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="\MyApp\UserBundle\Entity\User", inversedBy="notifications",cascade={"persist"})
     */
    protected $user;


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return Notification
     */
    public function setUser($user)
    {
        $this->user = $user;
        $user->addNotification($this);

        return $this;
    }


}