# TRMS Backend

## Setup

1. Create database: `mysql -u root -p < database.sql`
2. Configure `.env` with your database credentials
3. Serve with PHP built-in server: `php -S localhost:8000 -t public`

## Endpoints

### Auth
- `POST /api/auth/login` - Login with email/password
- `GET /api/auth/me` - Get current user

### Dashboard
- `GET /api/dashboard` - Stats + activities
- `GET /api/dashboard/stats` - Stats only
- `GET /api/dashboard/activities` - Activities only

### Events
- `GET /api/events` - All events
- `GET /api/events/upcoming` - Upcoming 5 events
- `GET /api/events/month?month=6` - Events by month
- `GET /api/events/{id}` - Single event
- `POST /api/events` - Create event (auth required)
- `PUT /api/events/{id}` - Update event (auth required)
- `DELETE /api/events/{id}` - Delete event (auth required)

### Profile
- `GET /api/profile` - Current user profile (auth required)
- `PUT /api/profile` - Update profile (auth required)

## Default Login
- Email: `alexander@trms.edu`
- Password: `password123`
