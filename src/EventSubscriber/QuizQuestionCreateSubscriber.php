<?php

namespace App\EventSubscriber;

use App\Entity\QuizQuestion;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Security;

class QuizQuestionCreateSubscriber implements EventSubscriberInterface
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class => 'setQuizQuestionPropertiesByDefault',
        ];
    }

    public function setQuizQuestionPropertiesByDefault(BeforeEntityPersistedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if ($entity instanceof QuizQuestion) {
            $entity->setCreatedBy($this->security->getUser());
        }

        return;
    }
}