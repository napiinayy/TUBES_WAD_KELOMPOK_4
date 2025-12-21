# Laboratory Management System

A comprehensive web-based laboratory management system built with Laravel 11 for managing laboratory equipment, procurement, borrowing, and complaints.

## Features

- **User Authentication**: Role-based access control (Admin & Aslab)
- **Category Management**: Manage equipment categories (Wearpack, Glassware, etc.)
- **Item Management (Barang)**: Track laboratory items and equipment
- **Procurement System (Pengadaan)**: Request and approve equipment procurement
- **Borrowing System (Peminjaman)**: Manage equipment borrowing and returns
- **Complaint System (Keluhan)**: Report and track equipment issues
- **Privacy Filters**: Users only see their own activities (except catalog)
- **Real-time Status Updates**: Admin dashboard with AJAX status management

## Technologies Used

- **Backend**: Laravel 11
- **Database**: MySQL
- **Frontend**: Bootstrap 5, JavaScript (Vanilla)
- **Build Tool**: Vite
- **Authentication**: Laravel's built-in authentication

## Prerequisites

Before you begin, ensure you have the following installed:

- **PHP**: >= 8.2
- **Composer**: Latest version
- **Node.js**: >= 18.x
- **NPM**: Latest version
- **MySQL**: >= 8.0
- **Git**: For cloning the repository

## Installation Steps

### 1. Clone the Repository

```bash
git clone <repository-url>
cd TUBES_WAD_KELOMPOK_4
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Install Node Dependencies

```bash
npm install
```

### 4. Environment Configuration

Copy the example environment file and configure it:

**Windows:**
```bash
copy .env.example .env
```

**Linux/Mac:**
```bash
cp .env.example .env
```

Edit the `.env` file and configure your database connection:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password
```

### 5. Generate Application Key

```bash
php artisan key:generate
```

### 6. Create Database

Create a new MySQL database matching the name you set in `.env`:

```sql
CREATE DATABASE your_database_name CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 7. Run Migrations

Run all migrations to create the database structure:

```bash
php artisan migrate
```

This will create the following tables:
- `cache` - Laravel cache table
- `jobs` - Laravel queue jobs
- `categories` - Equipment category types
- `labs` - Laboratory information
- `users` - User authentication
- `kategoris` - Individual items/equipment (Barang)
- `pengadaans` - Procurement requests
- `keluhans` - Equipment complaints
- `peminjamans` - Borrowing records

### 8. Seed Database (Optional)

If seeders are available, run:

```bash
php artisan db:seed
```

Otherwise, you'll need to manually create:
- An admin user (through registration or database insert)
- Laboratory records (via SQL or admin interface once logged in)
- Initial categories (via admin interface)

### 9. Create Storage Link

```bash
php artisan storage:link
```

### 10. Build Frontend Assets

For development (with hot reload):
```bash
npm run dev
```

For production:
```bash
npm run build
```

### 11. Start Development Server

In a new terminal window, run:

```bash
php artisan serve
```

The application will be available at `http://localhost:8000`

## Project Structure

```
TUBES_WAD_KELOMPOK_4/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── BarangController.php       # Item management
│   │       ├── KategoriController.php     # Category management
│   │       ├── PengadaanController.php    # Procurement management
│   │       ├── PeminjamanController.php   # Borrowing management
│   │       ├── KeluhanController.php      # Complaint management
│   │       └── UserController.php         # User & dashboard
│   └── Models/
│       ├── Barang.php                     # Item model (kategoris table)
│       ├── Kategori.php                   # Category model (categories table)
│       ├── Pengadaan.php                  # Procurement model
│       ├── Peminjaman.php                 # Borrowing model
│       ├── Keluhan.php                    # Complaint model
│       ├── Lab.php                        # Laboratory model
│       └── User.php                       # User model
├── database/
│   └── migrations/                        # Database migrations
├── resources/
│   └── views/
│       ├── admin/                         # Admin views
│       │   ├── dashboard.blade.php        # Admin dashboard
│       │   ├── barang/                    # Item management views
│       │   ├── kategoris/                 # Category management views
│       │   └── users/                     # User management views
│       └── aslab/                         # Aslab views
│           ├── barang/                    # Item catalog (read-only)
│           ├── peminjaman/                # Borrowing management
│           ├── pengadaan/                 # Procurement requests
│           └── keluhan/                   # Complaint reporting
└── routes/
    └── web.php                            # Application routes
```

## Key Concepts

### Database Naming Convention

- **Kategori Model** → `categories` table: Represents category types (e.g., "Wearpack", "Glassware")
- **Barang Model** → `kategoris` table: Represents individual items/equipment
- Each Barang belongs to a Kategori (category type)

### User Roles

1. **Admin**:
   - Full access to all features
   - Manage categories, items, users
   - Approve/reject procurement and complaints
   - Update status of borrowing requests
   - View all activities

2. **Aslab** (Laboratory Assistant):
   - Submit procurement requests
   - Borrow equipment
   - Report complaints
   - View only their own activities (privacy filter)
   - Access shared item catalog

### Privacy Filters

For Aslab users, the system filters:
- **Pengadaan**: Only shows requests where `pengaju` matches user's name
- **Peminjaman**: Only shows borrowing where `peminjam` matches user's ID
- **Keluhan**: Only shows complaints where `created_by` matches user's ID
- **Barang Catalog**: Shared - all users can view all items

## API Endpoints

### Status Update Endpoints (AJAX)

```
PATCH /admin/pengadaan/{id}/status
PATCH /admin/peminjaman/{id}/status
PATCH /admin/keluhan/{id}/status
```

Request body:
```json
{
  "status": "approved|rejected|completed|dipinjam|dikembalikan|terlambat"
}
```

Response:
```json
{
  "success": true,
  "status": "approved"
}
```

## Common Issues & Troubleshooting

### Issue: "Class not found" errors
**Solution**: Run `composer dump-autoload`

### Issue: Views not updating
**Solution**: Clear view cache with `php artisan view:clear`

### Issue: Routes not found
**Solution**: Clear route cache with `php artisan route:clear`

### Issue: Foreign key constraint errors during migration
**Solution**: Ensure migrations run in correct order. Drop all tables and re-run migrations:
```bash
php artisan migrate:fresh
```

### Issue: Status updates not working on admin dashboard
**Solution**: 
1. Check CSRF token is present in meta tag of layout
2. Open browser console to check for JavaScript errors
3. Verify routes exist in `routes/web.php`
4. Ensure controller has `updateStatus()` method

### Issue: Permission denied errors
**Solution**: Set proper permissions on storage and cache directories:

**Windows:**
```bash
# Run as administrator or adjust folder permissions via properties
```

**Linux/Mac:**
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

## Development Workflow

1. **Make changes to views**: Views are cached, run `php artisan view:clear` if changes don't appear
2. **Make changes to routes**: Run `php artisan route:clear`
3. **Make changes to models**: Run `composer dump-autoload`
4. **Frontend changes**: Keep `npm run dev` running in a separate terminal for hot reload
5. **Database changes**: Create new migration with `php artisan make:migration migration_name`

## Testing the Application

### Test Admin Features
1. Login as admin
2. Navigate to dashboard at `/admin/dashboard`
3. Test status updates for pengadaan, peminjaman, keluhan
4. Go to "Daftar Kategori" to create new categories
5. Go to "Daftar Barang" to manage items
6. View user list and edit profiles

### Test Aslab Features
1. Login as aslab user
2. Navigate to aslab dashboard
3. Submit procurement request via "Pengadaan"
4. Submit borrowing request via "Peminjaman"
5. Report complaint via "Keluhan"
6. Verify you only see your own activities
7. Check that you can view all items in catalog

## Production Deployment

Before deploying to production:

1. Set `APP_ENV=production` in `.env`
2. Set `APP_DEBUG=false` in `.env`
3. Generate strong `APP_KEY`
4. Use strong database credentials
5. Run `npm run build` to compile assets
6. Optimize Laravel:
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   php artisan optimize
   ```
7. Set proper file permissions (775 for directories, 664 for files)
8. Configure web server (Apache/Nginx)
9. Enable SSL/HTTPS
10. Set up database backup system
11. Configure error logging
12. Set up monitoring

## Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## License

This project is developed for educational purposes.

## Support

For issues and questions, please open an issue in the repository.

## Acknowledgments

- Built with [Laravel Framework](https://laravel.com)
- Styled with [Bootstrap 5](https://getbootstrap.com)
- All contributors to this project
