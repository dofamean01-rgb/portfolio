-- ============================================
-- База данных PortFolioPro
-- Электронное портфолио студента
-- ============================================

-- Создание базы (можно закомментировать, если база уже создана хостингом)
-- CREATE DATABASE portfolio_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
-- USE portfolio_db;

-- ============================================
-- 1. Пользователи (студенты и администраторы)
-- ============================================
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  full_name VARCHAR(150) NOT NULL,
  email VARCHAR(150) UNIQUE NOT NULL,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('student','admin') DEFAULT 'student',
  city VARCHAR(100),
  course INT,
  github VARCHAR(200),
  avatar_url VARCHAR(300),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ============================================
-- 2. Работы студента
-- ============================================
CREATE TABLE works (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  title VARCHAR(200) NOT NULL,
  type ENUM('course','lab','pet') NOT NULL,
  description TEXT,
  link VARCHAR(300),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- ============================================
-- 3. Компетенции
-- ============================================
CREATE TABLE skills (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  name VARCHAR(150) NOT NULL,
  level TINYINT NOT NULL CHECK (level BETWEEN 0 AND 100),
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- ============================================
-- 4. Справочник дисциплин
-- ============================================
CREATE TABLE subjects (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(200) NOT NULL UNIQUE
);

-- ============================================
-- 5. Оценки
-- ============================================
CREATE TABLE grades (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  subject_id INT NOT NULL,
  term VARCHAR(50) NOT NULL,
  grade TINYINT NOT NULL CHECK (grade BETWEEN 2 AND 5),
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (subject_id) REFERENCES subjects(id)
);

-- ============================================
-- 6. Заявки (для формы обратной связи)
-- ============================================
CREATE TABLE applications (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  phone VARCHAR(30) NOT NULL,
  email VARCHAR(150) NOT NULL,
  message TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  status ENUM('new','processed') DEFAULT 'new'
);

-- ============================================
-- ЗАПОЛНЕНИЕ ДАННЫМИ
-- ============================================

-- Дисциплины
INSERT INTO subjects (name) VALUES
('Веб-программирование'),
('Базы данных'),
('Проектирование ИС'),
('Программирование на JS'),
('Информационные системы');

-- Пользователь (студент)
INSERT INTO users (full_name, email, password_hash, role, city, course, github)
VALUES ('Иванов Иван Иванович', 'ivan@example.com', 'hash', 'student', 'Москва', 3, 'github.com/ivan');

-- Работы
INSERT INTO works (user_id, title, type, description, link) VALUES
(1, 'Сайт-портфолио', 'pet', 'Адаптивный сайт на HTML/CSS/JS', 'https://github.com/ivan/portfolio'),
(1, 'ИС учёта студентов', 'course', 'База данных + веб-интерфейс', 'https://github.com/ivan/students-is'),
(1, 'Лабораторная по SQL', 'lab', 'Запросы, представления, триггеры', 'https://github.com/ivan/sql-lab'),
(1, 'ToDo-приложение', 'pet', 'Хранение задач в localStorage', 'https://github.com/ivan/todo'),
(1, 'ИС для библиотеки', 'course', 'Учёт книг и читателей', 'https://github.com/ivan/library-is'),
(1, 'Лабораторная по JS', 'lab', 'Работа с DOM и событиями', 'https://github.com/ivan/js-lab');

-- Компетенции
INSERT INTO skills (user_id, name, level) VALUES
(1, 'HTML5 / CSS3', 85),
(1, 'JavaScript', 75),
(1, 'SQL / MySQL', 70),
(1, 'Git', 65),
(1, 'Figma', 60);

-- Оценки
INSERT INTO grades (user_id, subject_id, term, grade) VALUES
(1, 1, '5 семестр', 5),
(1, 2, '5 семестр', 4),
(1, 3, '6 семестр', 5),
(1, 4, '4 семестр', 5),
(1, 5, '6 семестр', 4);
