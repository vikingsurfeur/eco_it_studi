<?php

namespace App\EventSubscriber;

use App\Entity\Section;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\String\Slugger\SluggerInterface;

class SectionCreateSubscriber implements EventSubscriberInterface
{
    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class => 'setSectionSlugAndDate',
        ];
    }

    public function setSectionSlugAndDate(BeforeEntityPersistedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if ($entity instanceof Section) {
            $entity->setSlug($this->slugger->slug($entity->getTitle()));
            $entity->setCreatedAt(new \DateTime('now'));
        }

        return;
    }
}