<?php

namespace App\EventSubscriber;

use App\Entity\Course;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\String\Slugger\SluggerInterface;

class InstructorCreateCourseSubscriber implements EventSubscriberInterface
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
        ];
    }

    public function setCourseSlugAndInstructor(BeforeEntityPersistedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if ($entity instanceof Course) {
            $entity->setSlug($this->slugger->slug($entity->getTitle()));
            $entity->setCreatedAt(new \DateTime('now'));
            $entity->setUserInstructor($this->security->getUser());
        }

        return;
    }
}