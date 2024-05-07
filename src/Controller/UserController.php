<?php

namespace App\Controller;

use App\Entity\User;
use App\Event\UserCreatedEvent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    private $eventDispatcher;

    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @Route("/users", name="create_user", methods={"POST"})
     */
    public function createUser(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $user = new User(
            $data['email'],
            $data['firstName'],
            $data['lastName']
        );

        // Save user data to database or log file

        $event = new UserCreatedEvent($user);
        $this->eventDispatcher->dispatch($event);

        return $this->json(['message' => 'User created successfully']);
    }
}