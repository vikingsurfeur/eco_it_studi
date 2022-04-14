<?php

namespace App\EventSubscriber;

use App\Entity\QuizAnswerChoice;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Security;

class QuizAnswerCreateSubscriber implements EventSubscriberInterface
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class => 'setQuizAnswerPropertiesByDefault',
        ];
    }

    public function setQuizAnswerPropertiesByDefault(BeforeEntityPersistedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if ($entity instanceof QuizAnswerChoice) {
            $entity->setCreatedBy($this->security->getUser());
        }

        return;
    }
}