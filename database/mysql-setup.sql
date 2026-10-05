-- Run once as a MySQL admin (e.g. `mysql -u root -p < database/mysql-setup.sql`).
-- Change the password before running.
CREATE DATABASE IF NOT EXISTS chasefast CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER IF NOT EXISTS 'chasefast_user'@'localhost' IDENTIFIED BY 'use-a-strong-password-here';
GRANT ALL PRIVILEGES ON chasefast.* TO 'chasefast_user'@'localhost';
FLUSH PRIVILEGES;
