<?php

declare(strict_types=1);

namespace TRMS\Controllers;

use TRMS\Core\Response;
use TRMS\Middleware\Auth;
use TRMS\Models\Event;

class EventController
{
    public function index(): void
    {
        try {
            $eventModel = new Event();
            $events = $eventModel->all('events');
            $events = array_map([$this, 'normalizeEvent'], $events);

            Response::json($events);
        } catch (\Throwable $e) {
            Response::serverError($e->getMessage());
        }
    }

    public function show(int $id): void
    {
        try {
            $eventModel = new Event();
            $event = $eventModel->find('events', $id);

            if (!$event) {
                Response::notFound('Event not found');
            }

            Response::json($this->normalizeEvent($event));
        } catch (\Throwable $e) {
            Response::serverError($e->getMessage());
        }
    }

    public function store(): void
    {
        Auth::handle();

        $input = $this->getJsonInput();
        $errors = $this->validate($input);

        if ($errors) {
            Response::validationError($errors);
        }

        try {
            $eventModel = new Event();
            $data = [
                'title' => trim($input['title']),
                'date' => $input['date'],
                'time' => $input['time'],
                'venue' => trim($input['venue']),
                'type' => $input['type'] ?? 'concert',
            ];

            $id = $eventModel->create('events', $data);
            $event = $eventModel->find('events', $id);

            Response::json($this->normalizeEvent($event), 201);
        } catch (\Throwable $e) {
            Response::serverError($e->getMessage());
        }
    }

    public function update(int $id): void
    {
        Auth::handle();

        $input = $this->getJsonInput();
        $errors = $this->validate($input);

        if ($errors) {
            Response::validationError($errors);
        }

        try {
            $eventModel = new Event();
            $existing = $eventModel->find('events', $id);

            if (!$existing) {
                Response::notFound('Event not found');
            }

            $data = [
                'title' => trim($input['title']),
                'date' => $input['date'],
                'time' => $input['time'],
                'venue' => trim($input['venue']),
                'type' => $input['type'] ?? $existing['type'],
            ];

            $eventModel->update('events', $id, $data);
            $event = $eventModel->find('events', $id);

            Response::json($this->normalizeEvent($event));
        } catch (\Throwable $e) {
            Response::serverError($e->getMessage());
        }
    }

    public function destroy(int $id): void
    {
        Auth::handle();

        try {
            $eventModel = new Event();
            $existing = $eventModel->find('events', $id);

            if (!$existing) {
                Response::notFound('Event not found');
            }

            $eventModel->delete('events', $id);

            Response::json(['message' => 'Event deleted successfully']);
        } catch (\Throwable $e) {
            Response::serverError($e->getMessage());
        }
    }

    public function upcoming(): void
    {
        try {
            $eventModel = new Event();
            $events = $eventModel->upcoming(5);
            $events = array_map([$this, 'normalizeEvent'], $events);

            Response::json($events);
        } catch (\Throwable $e) {
            Response::serverError($e->getMessage());
        }
    }

    public function byMonth(): void
    {
        try {
            $month = (int) ($_GET['month'] ?? date('n'));
            $eventModel = new Event();
            $events = $eventModel->forMonth($month);
            $events = array_map([$this, 'normalizeEvent'], $events);

            Response::json($events);
        } catch (\Throwable $e) {
            Response::serverError($e->getMessage());
        }
    }

    private function getJsonInput(): array
    {
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);

        return is_array($data) ? $data : [];
    }

    private function validate(array $input): array
    {
        $errors = [];

        if (empty($input['title'])) {
            $errors['title'] = 'Title is required';
        }

        if (empty($input['date'])) {
            $errors['date'] = 'Date is required';
        } elseif (!\DateTime::createFromFormat('Y-m-d', $input['date']) || \DateTime::createFromFormat('Y-m-d', $input['date'])->format('Y-m-d') !== $input['date']) {
            $errors['date'] = 'Date must be in YYYY-MM-DD format';
        }

        if (empty($input['time'])) {
            $errors['time'] = 'Time is required';
        } elseif (!$this->isValidTime($input['time'])) {
            $errors['time'] = 'Time must be in HH:MM:SS or HH:MM format';
        }

        if (empty($input['venue'])) {
            $errors['venue'] = 'Venue is required';
        }

        if (!empty($input['type']) && !in_array($input['type'], ['concert', 'class', 'rehearsal', 'recital', 'meeting', 'workshop'], true)) {
            $errors['type'] = 'Invalid event type';
        }

        return $errors;
    }

    private function isValidTime(string $time): bool
    {
        if (preg_match('/^\d{2}:\d{2}$/', $time)) {
            $time .= ':00';
        }

        return \DateTime::createFromFormat('H:i:s', $time) && \DateTime::createFromFormat('H:i:s', $time)->format('H:i:s') === $time;
    }

    private function normalizeEvent(array $event): array
    {
        return [
            'id' => isset($event['id']) ? (int) $event['id'] : 0,
            'title' => isset($event['title']) ? (string) $event['title'] : '',
            'date' => isset($event['date']) ? (string) $event['date'] : '',
            'time' => isset($event['time']) ? (string) $event['time'] : '',
            'venue' => isset($event['venue']) ? (string) $event['venue'] : '',
            'type' => isset($event['type']) ? (string) $event['type'] : 'concert',
            'created_at' => isset($event['created_at']) ? (string) $event['created_at'] : '',
            'updated_at' => isset($event['updated_at']) ? (string) $event['updated_at'] : '',
        ];
    }
}
