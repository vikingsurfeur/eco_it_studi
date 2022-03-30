<?php

namespace App\EventSubscriber;

use App\Entity\Tag;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\String\Slugger\SluggerInterface;

class TagCreateSubscriber implements EventSubscriberInterface
{
    private $security;
    private $slugger;

    public function __construct(SluggerInterface $slugger, Security $security)
    {
        $this->security = $security;
        $this->slugger = $slugger;
    }

    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class => 'setTagPropertiesByDefault',
            BeforeEntityUpdatedEvent::class => 'setTagPropertiesByUpdated',
        ];
    }

    public function setTagPropertiesByDefault(BeforeEntityPersistedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if ($entity instanceof Tag) {
            $entity->setSlug($this->slugger->slug($entity->getName()));
            $entity->setUser($this->security->getUser());
        }

        return;
    }

    public function setTagPropertiesByUpdated(BeforeEntityUpdatedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if ($entity instanceof Tag) {
            $entity->setSlug($this->slugger->slug($entity->getName()));
        }

        return;
    }
}