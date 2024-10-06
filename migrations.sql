-- Creazione del database
CREATE DATABASE IF NOT EXISTS owly_learning;
USE owly_learning;


CREATE TABLE IF NOT EXISTS subjects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE
);


CREATE TABLE IF NOT EXISTS courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    available_slots INT NOT NULL
);


CREATE TABLE IF NOT EXISTS course_subject (
    course_id INT,
    subject_id INT,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,
    FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE CASCADE,
    PRIMARY KEY (course_id, subject_id)
);


