<?php

// src/App/EventListener/JWTCreatedListener.php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\RequestStack;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

class JWTCreatedListener
{
    
    /** 
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * @param JWTCreatedEvent $event
     *
     * @return void
     */
    
    public function onJWTCreated(JWTCreatedEvent $event)
    {
        /** @var $user \AppBundle\Entity\User */
        $user = $event->getUser();

        if (!$user->getIsActive()){
            throw new  CustomUserMessageAuthenticationException('Votre compte a été bloqué veuillez appoché votre administrateur');
        }
        // merge with existing event data
            $payload = array_merge(
            $event->getData(),
            [
                'id' => $user->getId()
            ]
        );

       $event->setData($payload);
    }
}