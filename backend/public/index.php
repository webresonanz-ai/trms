<?php

declare(strict_types=1);

use TRMS\Middleware\Cors;

require_once __DIR__ . '/../src/middleware/Cors.php';

Cors::handle();

require_once __DIR__ . '/../src/core/Database.php';
require_once __DIR__ . '/../src/core/Model.php';
require_once __DIR__ . '/../src/core/Response.php';
require_once __DIR__ . '/../src/middleware/Auth.php';
require_once __DIR__ . '/../src/models/User.php';
require_once __DIR__ . '/../src/models/Event.php';
require_once __DIR__ . '/../src/models/Activity.php';
require_once __DIR__ . '/../src/models/Stat.php';
require_once __DIR__ . '/../src/controllers/AuthController.php';
require_once __DIR__ . '/../src/controllers/DashboardController.php';
require_once __DIR__ . '/../src/controllers/EventController.php';
require_once __DIR__ . '/../src/controllers/UserController.php';
require_once __DIR__ . '/../src/core/router.php';
