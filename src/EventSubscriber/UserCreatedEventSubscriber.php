<?php

namespace App\EventSubscriber;

use App\Event\UserCreatedEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserCreatedEventSubscriber implements EventSubscriberInterface
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function onUserCreated(UserCreatedEvent $event)
    {
        $user = $event->getUser();
        $this->logger->info(sprintf('User created: %s, %s, %s', $user->getEmail(), $user->getFirstName(), $user->getLastName()));
    }

    public static function getSubscribedEvents()
    {
        return [
            UserCreatedEvent::class => 'onUserCreated',
        ];
    }
}