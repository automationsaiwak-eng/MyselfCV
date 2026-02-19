-- ============================================================
-- Portfolio Database: portfolio_db
-- Author: Saiwak Ram
-- ============================================================

CREATE DATABASE IF NOT EXISTS portfolio_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE portfolio_db;

-- -------------------------------------------------------
-- Table: users (Admin accounts)
-- -------------------------------------------------------
CREATE TABLE IF NOT EXISTS users (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(100)  NOT NULL,
    email       VARCHAR(150)  NOT NULL UNIQUE,
    password    VARCHAR(255)  NOT NULL,
    created_at  TIMESTAMP     DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Default admin user: password = Admin@1234
INSERT INTO users (name, email, password) VALUES
('Saiwak Ram', 'saiwakram786pur@gmail.com',
 '$2y$12$Kix5w5pP1FNTRiMg4UElEuiOI4bDuawdEi7eSxWKj84O3v8n.DBBO');

-- -------------------------------------------------------
-- Table: projects
-- -------------------------------------------------------
CREATE TABLE IF NOT EXISTS projects (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    title        VARCHAR(150)  NOT NULL,
    description  TEXT          NOT NULL,
    technologies VARCHAR(255)  NOT NULL,
    image        VARCHAR(255)  DEFAULT NULL,
    github_link  VARCHAR(255)  DEFAULT NULL,
    demo_link    VARCHAR(255)  DEFAULT NULL,
    created_at   TIMESTAMP     DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Seed projects
INSERT INTO projects (title, description, technologies, github_link) VALUES
(
    'Transport ERP',
    'A full-featured Enterprise Resource Planning system for goods transport companies. Includes Admin, Transporter, and Driver panels with load management, fleet tracking, accounting, and real-time reporting modules.',
    'PHP, MySQL, Bootstrap 5, JavaScript, jQuery',
    'https://github.com/saiwakram'
),
(
    'Job Portal',
    'A dynamic job portal connecting employers and job-seekers. Features include job listings, search & filtering, application tracking, employer dashboards, and email notifications.',
    'PHP, MySQL, Bootstrap 5, JavaScript',
    'https://github.com/saiwakram'
),
(
    'Portfolio Website',
    'A modern, fully responsive personal portfolio website built with PHP and MySQL. Features include an admin CRUD panel, animated skill bars, typing effect hero section, and dark/light mode toggle.',
    'PHP, MySQL, Bootstrap 5, CSS3, JavaScript',
    'https://github.com/saiwakram'
),
(
    'Medical Store System',
    'A comprehensive Medical Store Inventory & Stock Management System to manage medicines, purchases, sales, suppliers, and expiry dates with full reporting and dashboards.',
    'PHP, MySQL, Bootstrap 5, JavaScript, Chart.js',
    'https://github.com/saiwakram'
);

-- -------------------------------------------------------
-- Table: messages (Contact form submissions)
-- -------------------------------------------------------
CREATE TABLE IF NOT EXISTS messages (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(100)  NOT NULL,
    email       VARCHAR(150)  NOT NULL,
    subject     VARCHAR(200)  NOT NULL,
    message     TEXT          NOT NULL,
    is_read     TINYINT(1)    DEFAULT 0,
    created_at  TIMESTAMP     DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;
