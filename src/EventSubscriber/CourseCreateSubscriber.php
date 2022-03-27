<?php

namespace App\EventSubscriber;

use App\Entity\Course;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\String\Slugger\SluggerInterface;

class CourseCreateSubscriber implements EventSubscriberInterface
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
            BeforeEntityPersistedEvent::class => 'setCourseSlugAndInstructor',
            BeforeEntityUpdatedEvent::class => 'setCourseSlugAndInstructorUpdated',
        ];
    }

    public function setCourseSlugAndInstructor(BeforeEntityPersistedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if ($entity instanceof Course) {
            $entity->setSlug($this->slugger->slug($entity->getTitle()));
            $entity->setCreatedAt(new \DateTime('now'));
            $entity->setUser($this->security->getUser());
        }

        return;
    }

    public function setCourseSlugAndInstructorUpdated(BeforeEntityUpdatedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if ($entity instanceof Course) {
            $entity->setSlug($this->slugger->slug($entity->getTitle()));
            $entity->setUpdatedAt(new \DateTime('now'));
        }

        return;
    }
}