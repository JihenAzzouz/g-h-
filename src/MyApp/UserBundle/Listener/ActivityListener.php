<?php
/**
 * Created by PhpStorm.
 * User: Imen Rajhi
 * Date: 25/03/2017
 * Time: 17:44
 */

namespace MyApp\UserBundle\Listener;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\HttpKernel;
use Doctrine\ORM\EntityManager;
use MyApp\UserBundle\Entity\User;


class ActivityListener
{
    protected $token;
    protected $entityManager;

    public function __construct(TokenStorage $token, EntityManager $entityManager)
    {
        $this->token = $token;
        $this->entityManager = $entityManager;
    }

    /**
     * Update the user "lastActivity" on each request
     * @param FilterControllerEvent $event
     */
    public function onCoreController(FilterControllerEvent $event)
    {
        // Check that the current request is a "MASTER_REQUEST"
        // Ignore any sub-request
        if ($event->getRequestType() !== HttpKernel::MASTER_REQUEST) {
            return;
        }

        // Check token authentication availability
        if ($this->token->getToken()) {
            $user = $this->token->getToken()->getUser();
            if ( ($user instanceof User) && !($user->isActiveNow()) ) {
                $user->setLastActivityAt(new \DateTime());
                $this->entityManager->flush($user);
            }

        }
    }
}
