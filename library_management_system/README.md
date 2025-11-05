# Library Management System (PHP + MySQLi + Bootstrap)

## Setup
1. Create DB and tables:
   ```sql
   SOURCE sql/library_db.sql;
   ```
2. Update credentials in `config/database.php`.
3. Put repo into your web root (e.g., `htdocs/library_management_system`).
4. Add Bootstrap 5 offline files to `assets/css/bootstrap.min.css` and `assets/js/bootstrap.bundle.min.js` 
   or switch to CDN in `includes/header.php` and `includes/footer.php`.
5. Visit `/register.php` to create student accounts. Login as admin:
   - Email: `admin@example.com`
   - Password: `Admin@123`

## Features
- Users table with roles (`admin`, `student`).
- Secure password hashing.
- Books CRUD for admin.
- Borrow flow for students with transaction safety.
- Search and filter books.
