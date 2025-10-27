# 🧾 Inventory Management System (Laravel)

## 📖 Description / Overview
The **Inventory Management System** is a Laravel-based web application that helps users manage and organize product data efficiently. It allows adding, updating, deleting, and categorizing items in stock. This system provides an easy-to-use interface for monitoring product availability and keeping track of inventory details.  
This project was developed as part of the **Midterm Examination**.

---

## 🎯 Objectives
- To develop a **Laravel-based inventory system** with a clean and organized structure.
- To apply **MVC (Model–View–Controller)** concepts in a real-world project.
- To implement **CRUD operations** using Laravel’s routing and Eloquent ORM.
- To understand **Blade templating**, **migrations**, and **controllers**.
- To practice creating **well-documented projects** using Markdown.

---

## ⚙️ Features / Functionality
- 📦 View, Add, Edit, and Delete Products  
- 🏷️ Add and Manage Categories  
- 🔍 Search and Filter Products by Category  
- 🧮 Automatically Update Product Quantities  
- 📋 User-friendly Dashboard Interface  
- 💡 Organized MVC Structure (Laravel Framework)  

---

## 🛠️ Installation Instructions

Follow these steps to set up and run the project locally:

1. **Install XAMPP**
   ```bash  
   Download and install XAMPP from [https://www.apachefriends.org/](https://www.apachefriends.org/).
   ```
   
2. **Install Composer**
   ```bash
   Laravel requires Composer.  
   Download it here: [https://getcomposer.org/](https://getcomposer.org/).
    ```
   
3. **Copy the Project Folder**
   ```bash
   Move your project folder `TH` into:
    ```
   
4. **Open the Project in Command Prompt**
    ```bash
    cd C:\xampp\htdocs\TH
    ```
    
5. Install Laravel Dependencies
   ```bash
    composer install
   ```

6. Set Up the Environment File
   ```bash
    - Copy .env.example and rename it to .env
    - Open .env and update your database connection:

    DB_DATABASE=inventory_db
    DB_USERNAME=root
    DB_PASSWORD=
    ```
   
7. Generate the Application Key
   ```bash
    php artisan key:generate
    ```
   
8. Run Migrations
    ```bash
    php artisan migrate
    ```

9. Start the Local Development Server
    ```bash
    php artisan serve
    ```

10. View the System
    ```bash
    http://127.0.0.1:8000
    ```


👥 Contributors

Name: Marben Antony L. Madrio
Course / Section: BS INFORMATION TECHNOLOGY 4A


📜 License

This project is developed for educational purposes only.
© 2025 Marben Antony L. Madrio. All Rights Reserved.



