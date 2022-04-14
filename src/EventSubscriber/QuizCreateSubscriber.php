<?php

namespace App\EventSubscriber;

use App\Entity\Quiz;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Security;

class QuizCreateSubscriber implements EventSubscriberInterface
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class => 'setQuizPropertiesByDefault',
            BeforeEntityUpdatedEvent::class => 'setQuizPropertiesByUpdated',
        ];
    }

    public function setQuizPropertiesByDefault(BeforeEntityPersistedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if ($entity instanceof Quiz) {
            $entity->setCreatedAt(new \DateTime('now'));
            $entity->setCreatedBy($this->security->getUser());
        }

        return;
    }

    public function setQuizPropertiesByUpdated(BeforeEntityUpdatedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if ($entity instanceof Quiz) {
            $entity->setUpdatedAt(new \DateTime('now'));
        }

        return;
    }
}