# KUDRAT Student Grading System

## Project name

**KUDRAT Student Grading System**

## Description

KUDRAT Student Grading System is a web-based school management portal for recording and managing student assessment results. Authenticated users can maintain student records, calculate total marks and grades, and quickly find results by student, matriculation number, or subject.

## Technologies used

- **PHP** - Server-side application logic and page rendering
- **MySQL** - Storage for users and student result records
- **HTML5** - Application structure and forms
- **CSS3** - Responsive layout, styling, and visual design
- **JavaScript** - Password visibility toggle on the sign-in page
- **Apache/XAMPP** - Recommended local web-server environment

## Features

- Secure session-based sign-in and logout flow
- Student result dashboard with an organized results table
- Search results by student name, matriculation number, or subject
- Add new student results
- Edit existing student results
- Review and confirm before deleting a result
- Automatic total-mark calculation:
  - Test 1: 20 marks
  - Test 2: 30 marks
  - Final exam: 50 marks
- Automatic grade calculation based on the total mark
- Input validation for assessment mark ranges
- Responsive interface for desktop and smaller screens
- Accessible form labels, focus states, and status messages

## Local setup

1. Install [XAMPP](https://www.apachefriends.org/).
2. Copy this project into the XAMPP web root:

   ```text
   C:\xampp\htdocs\StudentGradingSystem
   ```

3. Start **Apache** and **MySQL** from the XAMPP control panel.
4. Create a MySQL database named `student_grade`.
5. Configure the `users` and `results` tables expected by the PHP pages.
6. Open the application at:

   [http://localhost/StudentGradingSystem/login.php](http://localhost/StudentGradingSystem/login.php)

The database connection is configured in `db.php` for a local MySQL server using the default XAMPP `root` account without a password.
