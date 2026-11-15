CREATE DATABASE IF NOT EXISTS sl_al_exam_management
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE sl_al_exam_management;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  full_name VARCHAR(120) NOT NULL,
  email VARCHAR(190) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE subjects (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  subject_name VARCHAR(100) NOT NULL,
  target_hours DECIMAL(5,2) NOT NULL DEFAULT 1.00,
  chart_color VARCHAR(7) NOT NULL DEFAULT '#ff3b30',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_subject_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  UNIQUE KEY unique_user_subject (user_id, subject_name)
) ENGINE=InnoDB;

CREATE TABLE study_logs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  subject_id INT NOT NULL,
  study_date DATE NOT NULL,
  hours DECIMAL(5,2) NOT NULL DEFAULT 0,
  notes VARCHAR(500) NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_log_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  CONSTRAINT fk_log_subject FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE CASCADE,
  UNIQUE KEY unique_subject_day (subject_id, study_date),
  INDEX idx_user_date (user_id, study_date)
) ENGINE=InnoDB;

