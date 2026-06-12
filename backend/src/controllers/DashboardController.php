<?php

declare(strict_types=1);

namespace TRMS\Controllers;

use TRMS\Core\Response;
use TRMS\Models\Stat;
use TRMS\Models\Activity;

class DashboardController
{
    public function index(): void
    {
        $statModel = new Stat();
        $activityModel = new Activity();

        $stats = $statModel->all('stats');
        $activities = $activityModel->recent(5);

        Response::json([
            'stats' => $stats,
            'activities' => $activities,
        ]);
    }

    public function stats(): void
    {
        $statModel = new Stat();
        $stats = $statModel->all('stats');

        Response::json($stats);
    }

    public function activities(): void
    {
        $activityModel = new Activity();
        $activities = $activityModel->recent(10);

        Response::json($activities);
    }
}
