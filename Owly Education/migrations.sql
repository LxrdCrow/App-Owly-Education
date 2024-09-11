--creation database
CREATE DATABASE IF NOT EXISTS owly_learning;
USE owly_learning;

--table subjects
CREATE TABLE IF NOT EXISTS subjects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE
);

--table courses
CREATE TABLE IF NOT EXISTS courses (
    id INT AUTO_INCREMENT PRIMARY KEY;
    name VARCHAR(255) NOT NULL,
    available_slots INT NOT NULL
);

--creating relationship table between courses and subjects
CREATE TABLE IF NOT EXISTS course_subject (
    course_id INT,
    subject_id INT,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,
    FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE CASCADE,
    PRIMARY KEY (course_id, subject_id)
);

