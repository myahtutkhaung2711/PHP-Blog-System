USE mhk_blogweb;

-- --------------------------------------------------------
-- USERS TABLE
-- --------------------------------------------------------
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    role ENUM('superadmin','admin','customer') DEFAULT 'customer',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users (name, email, password, role) VALUES
('Super Admin', 'superadmin@gmail.com', '$2y$10$QZ9gQ2Z6RrZ7zYxU4m1FKeTn6mP5H7EJwR2H0Yl6z2YvV1kP9kqGa', 'superadmin'),
('Admin User', 'admin@gmail.com', '$2y$10$QZ9gQ2Z6RrZ7zYxU4m1FKeTn6mP5H7EJwR2H0Yl6z2YvV1kP9kqGa', 'admin'),
('User 1', 'user@gmail.com', '$2y$10$QZ9gQ2Z6RrZ7zYxU4m1FKeTn6mP5H7EJwR2H0Yl6z2YvV1kP9kqGa', 'customer'),
('User 2', 'user2@gmail.com', '$2y$10$QZ9gQ2Z6RrZ7zYxU4m1FKeTn6mP5H7EJwR2H0Yl6z2YvV1kP9kqGa', 'customer');


-- --------------------------------------------------------
-- CATEGORIES TABLE
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  description TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO categories (name, description) VALUES
('Technology', 'Latest updates and guides about tech.'),
('Lifestyle', 'Daily life, habits, and inspiration.'),
('Travel', 'Travel stories and guides.'),
('Education', 'Learning tips and resources.');


-- --------------------------------------------------------
-- POSTS TABLE
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS posts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  category_id INT,
  user_id INT,
  title VARCHAR(255) NOT NULL,
  content TEXT NOT NULL,
  image VARCHAR(255),
  status ENUM('draft', 'published') DEFAULT 'published',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

INSERT INTO posts (category_id, user_id, title, content, image, status)
VALUES
(1, 2, 'Getting Started with PHP', 'This post introduces the basics of PHP programming language.', 'php_tutorial.jpg', 'published'),
(2, 3, 'Morning Habits for Productivity', 'Simple morning routines to start your day strong.', 'morning_habits.jpg', 'published'),
(3, 2, 'Top 5 Places to Visit in Myanmar', 'Explore the most beautiful destinations around Myanmar.', 'travel_myanmar.jpg', 'published');

-- --------------------------------------------------------
-- COMMENTS TABLE
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS comments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  post_id INT NOT NULL,
  user_id INT NOT NULL,
  content TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

INSERT INTO comments (post_id, user_id, content) VALUES
(1, 3, 'Nice intro to PHP! Thanks for sharing.'),
(2, 3, 'Great tips, I’ll try them tomorrow morning.'),
(3, 2, 'Myanmar is truly beautiful.');


-- --------------------------------------------------------
-- SETTINGS TABLE
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS settings (
  id INT AUTO_INCREMENT PRIMARY KEY,
  site_name VARCHAR(255) DEFAULT 'My Blog Management System',
  site_description TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO settings (site_name, site_description)
VALUES ('MHK Blog Management System', 'A PHP + MySQL blog project by Mya Htut Khaung 💙');
