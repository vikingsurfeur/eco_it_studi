<?php

namespace App\EventSubscriber;

use App\Entity\Image;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Security;

class ImageCreateSubscriber implements EventSubscriberInterface
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class => 'setImageInstructorandDate',
        ];
    }

    public function setImageInstructorandDate(BeforeEntityPersistedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if ($entity instanceof Image) {
            $entity->setCreatedAt(new \DateTime('now'));
            $entity->setUser($this->security->getUser());
        }

        return;
    }
}