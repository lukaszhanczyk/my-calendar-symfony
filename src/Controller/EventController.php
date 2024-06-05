<?php

namespace App\Controller;

use App\Entity\Event;
use App\Repository\EventRepository;
use App\Repository\UserRepository;
use App\Request\Event\CreateEventRequest;
use App\Request\Event\UpdateEventRequest;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class EventController extends AbstractController
{
    public function __construct(
        private readonly EventRepository $eventRepository,
        private readonly UserRepository $userRepository
    ){
    }

    #[Route('/event/all', name: 'app_event_index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $events = $this->eventRepository->findAll();

        return $this->json($events);
    }

    #[Route('/event/create', name: 'app_event_create', methods: ['POST'])]
    public function create(CreateEventRequest $request): JsonResponse
    {
        if ($validation = $request->validate()){
            return $this->json([
                'errors' => $validation['errors'],
            ], 403);
        }

        try {
            $user = $this->userRepository->findOneBy(['id' => $request->user_id]);

            $event = new Event();
            $event->setTitle($request->title);
            $event->setDescription($request->description);
            $event->setDate(new DateTime($request->date));
            $event->setColor($request->color);
            $event->setUser($user);

            $this->eventRepository->create($event);
        } catch(\Exception $e){
            return $this->json([
                'error' => 'Error while creating event',
                'message' => $e->getMessage(),
            ], 500);
        }

        return $this->json([
            'message' => 'Event was created.',
        ]);
    }

    #[Route('/event/update', name: 'app_event_update', methods: ['PUT'])]
    public function update(UpdateEventRequest $request): JsonResponse
    {
        if ($validation = $request->validate()){
            return $this->json([
                'errors' => $validation['errors'],
            ], 403);
        }

        try {
            $user = $this->userRepository->findOneBy(['id' => $request->user_id]);

            $event = $this->eventRepository->findOneBy(['id' => $request->id]);
            $event->setTitle($request->title);
            $event->setDescription($request->description);
            $event->setDate(new DateTime($request->date));
            $event->setColor($request->color);
            $event->setUser($user);

            $this->eventRepository->create($event);
        } catch(\Exception $e){
            return $this->json([
                'error' => 'Error while creating event',
                'message' => $e->getMessage(),
            ], 500);
        }

        return $this->json($event);
    }

    #[Route('/event/delete/{id}', name: 'app_event_delete', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        try {
            $event = $this->eventRepository->findOneBy(['id' => $id]);
            $this->eventRepository->delete($event);
        } catch(\Exception $e){
            return $this->json([
                'error' => 'Error while creating event',
                'message' => $e->getMessage(),
            ], 500);
        }

        return $this->json([
            'message' => 'Event was deleted.',
        ]);
    }
}
