# PHP Student Registration & Dynamic Form Management System

A web-based Student Registration and Form Management System built using PHP, MySQL, HTML, and CSS. The project is designed to simplify student data collection through customizable forms and centralized database management.

## 📌 Project Overview

This project provides a student registration system where form submissions can be processed using PHP and stored in a MySQL database.

The planned system includes an admin dashboard for managing student registrations and a dynamic form creation feature that allows administrators to customize forms and share form links with students.

## ✨ Key Features

- **Student Registration:** Collect student information through web forms.
- **Form Submission:** Process submitted details using PHP.
- **MySQL Database:** Store student information in a database.
- **Student Search:** Search and retrieve student details.
- **Admin Dashboard:** Centralized interface for managing registration data.
- **Dynamic Form Builder:** Create and customize forms based on requirements.
- **Shareable Form Links:** Share form links with students to collect responses.
- **Responsive Interface:** HTML and CSS-based user interface.

*Note: Features should be marked as completed only if they are implemented in the current source code.*

## 🛠️ Technologies Used

- **Frontend:** HTML5, CSS3
- **Backend:** PHP
- **Database:** MySQL
- **Local Development:** XAMPP
- **Version Control:** Git and GitHub

## 📂 Project Structure

```text
PHP-Student-Registration/
├── .gitignore
├── db.php
├── index.html
├── index.css
├── index.php
├── search.html
└── search.php
```

## ⚙️ Installation and Setup

### 1. Install XAMPP

Install XAMPP and start the Apache and MySQL services.

### 2. Clone the Repository

Open a terminal in your XAMPP `htdocs` directory and run:

```bash
git clone https://github.com/Prasanna-20740/PHP-Student-Registration.git
```

### 3. Configure the Database

1. Open phpMyAdmin at `http://localhost/phpmyadmin/`.
2. Create a MySQL database.
3. Create the required table or tables using the SQL schema for this project.
4. Update `db.php` with your local database connection settings.

**Important:** The database name, table structure, and column names must match the SQL queries used by the PHP files.

### 4. Run the Project

Start Apache and MySQL in XAMPP, then open:

```text
http://localhost/PHP-Student-Registration/
```

If the main page is `index.html`, you can also open:

```text
http://localhost/PHP-Student-Registration/index.html
```

## 🔄 Application Workflow

1. The student opens the registration form.
2. The student enters the required details and submits the form.
3. PHP processes the submitted information.
4. The application stores the data in MySQL.
5. Authorized administrators can retrieve and manage the collected information through implemented admin features.

## 🔐 Security Considerations

- Use prepared statements for database queries.
- Validate and sanitize user input on the server.
- Protect administrator pages with authentication and authorization.
- Never publish database passwords or secret credentials.
- Do not commit private configuration files to a public repository.

## 🚀 Future Enhancements

- Advanced form builder with configurable fields.
- Unique shareable links for individual forms.
- Admin dashboard with registration statistics.
- Export student data to Excel or CSV.
- Form response validation and duplicate submission prevention.
- Improved role-based access control.

## 👨‍💻 Author

**Prasanna P**

GitHub: [Prasanna-20740](https://github.com/Prasanna-20740)

## 📄 License

This project is available for learning and educational purposes. Add a formal license if you intend to permit reuse or redistribution.
