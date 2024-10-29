-- Create database
CREATE DATABASE grading_tool;
USE grading_tool;

-- Create table for students
CREATE TABLE students (
    student_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

-- Create table for grades
CREATE TABLE grades (
    grade_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT,
    homework1 INT,
    homework2 INT,
    homework3 INT,
    homework4 INT,
    homework5 INT,
    quiz1 INT,
    quiz2 INT,
    quiz3 INT,
    quiz4 INT,
    quiz5 INT,
    midterm INT,
    final_project INT,
    FOREIGN KEY (student_id) REFERENCES students(student_id)
);

-- Insert sample students
INSERT INTO students (name) VALUES ('Yeasin Arafat '), ('Muhtasin Hossain '), ('Hossain alvi');
