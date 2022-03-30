<?php

namespace App\EventSubscriber;

use App\Entity\Lesson;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\String\Slugger\SluggerInterface;

class LessonCreateSubscriber implements EventSubscriberInterface
{
    private $slugger;
    private $security;

    public function __construct(SluggerInterface $slugger, Security $security)
    {
        $this->slugger = $slugger;
        $this->security = $security;
    }

    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class => 'setLessonPropertiesByDefault',
            BeforeEntityUpdatedEvent::class => 'setLessonPropertiesByUpdated',
        ];
    }

    public function setLessonPropertiesByDefault(BeforeEntityPersistedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if ($entity instanceof Lesson) {
            $entity->setSlug($this->slugger->slug($entity->getTitle()));
            $entity->setCreatedAt(new \DateTime('now'));
            $entity->setIsFinished(false);
            $entity->setUser($this->security->getUser());
        }

        return;
    }

    public function setLessonPropertiesByUpdated(BeforeEntityUpdatedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if ($entity instanceof Lesson) {
            $entity->setSlug($this->slugger->slug($entity->getTitle()));
            $entity->setUpdatedAt(new \DateTime('now'));
        }

        return;
    }
}