# 🚀 Saiwak Ram – Full Stack Developer Portfolio

A modern, fully responsive, dynamic, and production-ready personal portfolio website built with **PHP**, **MySQL**, **Bootstrap 5**, **CSS3**, and **JavaScript (ES6)**.

---

## 📁 Folder Structure
```
portfolio/
├── index.php               # Main homepage (all sections)
├── contact.php             # Contact form handler (AJAX + regular)
├── .htaccess               # Apache security & performance rules
├── database.sql            # MySQL database schema + seed data
│
├── config/
│   └── db.php              # PDO database connection
│
├── admin/
│   ├── login.php           # Admin login page
│   ├── dashboard.php       # Dashboard (stats + projects + messages)
│   ├── add_project.php     # Add new project with image upload
│   ├── edit_project.php    # Edit existing project
│   └── logout.php          # Destroy session
│
└── assets/
    ├── css/style.css        # Main stylesheet (glassmorphism, dark/light mode)
    ├── js/script.js         # Typing effect, scroll animations, counter, form AJAX
    └── images/
        └── profile.jpg      # ← Upload your profile photo here
```

---

## ⚙️ Setup Instructions

### 1. Requirements
- PHP 7.4+ or 8.x
- MySQL 5.7+ or MariaDB 10.4+
- Apache with `mod_rewrite` enabled (XAMPP / WAMP / LAMP)

### 2. Database Setup
1. Open **phpMyAdmin** (or MySQL CLI)
2. Create the database by importing `database.sql`:
   ```sql
   SOURCE /path/to/portfolio/database.sql;
   ```
   Or use phpMyAdmin → Import → Select `database.sql` → Go

### 3. Configure Database Connection
Edit `config/db.php`:
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'portfolio_db');
define('DB_USER', 'root');       // Your MySQL username
define('DB_PASS', '');           // Your MySQL password
```

### 4. Upload Profile Photo
Place your photo at:
```
assets/images/profile.jpg
```

### 5. Place in Web Root
Put the `portfolio/` folder inside:
- **XAMPP**: `C:\xampp\htdocs\portfolio\`
- **WAMP**: `C:\wamp64\www\portfolio\`

### 6. Access the Website
- **Portfolio**: `http://localhost/portfolio/`
- **Admin Panel**: `http://localhost/portfolio/admin/login.php`

---

## 🔐 Default Admin Credentials

| Field    | Value                       |
|----------|-----------------------------|
| Email    | saiwakram786pur@gmail.com   |
| Password | **Admin@1234**              |

> ⚠️ **Change the password immediately** after first login!
> 
> To generate a new hash: `echo password_hash('YourNewPassword', PASSWORD_DEFAULT);`
> Then update the `users` table in phpMyAdmin.

---

## ✨ Features

| Feature | Status |
|---------|--------|
| Responsive Design (Mobile/Tablet/Desktop) | ✅ |
| Dark / Light Mode Toggle | ✅ |
| Glassmorphism UI | ✅ |
| Typing Effect in Hero | ✅ |
| Animated Skill Progress Bars | ✅ |
| Counter Animations | ✅ |
| Scroll Reveal Animations | ✅ |
| Dynamic Projects (from Database) | ✅ |
| AJAX Contact Form → Saved to DB | ✅ |
| Admin Panel Login (Session-based) | ✅ |
| Admin: Add / Edit / Delete Projects | ✅ |
| Admin: View Messages | ✅ |
| Image Upload for Projects | ✅ |
| PDO Prepared Statements (Security) | ✅ |
| Password Hashing with `password_hash()` | ✅ |
| Input Sanitization & Validation | ✅ |
| SEO Meta Tags | ✅ |
| Apache Security (.htaccess) | ✅ |
| Project Modal Quick Preview | ✅ |
| Sticky Navbar | ✅ |
| WhatsApp & Email Quick Links | ✅ |

---

## 🎨 Technologies Used

- **Frontend**: HTML5, CSS3, Bootstrap 5.3, JavaScript ES6
- **Backend**: PHP 8.x
- **Database**: MySQL with PDO
- **Icons**: Bootstrap Icons 1.11
- **Fonts**: Google Fonts (Outfit, Inter)
- **Animations**: CSS keyframes + IntersectionObserver

---

## 📞 Contact

**Saiwak Ram**  
📧 saiwakram786pur@gmail.com  
📱 +92 318 8280472  
📍 Punjab, Pakistan  
🔗 [GitHub](https://github.com/saiwakram)

---

*Built with ❤️ by Saiwak Ram*
