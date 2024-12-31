## [Swagger API](https://app.swaggerhub.com/apis-docs/ESLAMALSAYED8133/approval_chain/1.0.0)

# Approval Management System

## Introduction

The Approval Management System project is designed to manage project approvals through a sequential approval process. Projects are reviewed and approved by multiple roles, with each role approving the project one after the other. If a project is approved by the first responsible party, it moves to the next role for review. If any responsible party rejects the project, it is removed from the process.

This system ensures that all projects pass through a structured, role-based approval chain, where each responsible role has the opportunity to approve or reject the project based on predefined criteria.

## Features

-   **Sequential Project Approval**: Projects are approved in sequence by different roles (e.g., Admin1, Admin2, etc.). If any role rejects the project, it is removed from the approval chain.
-   **Project Management**: Add, delete, and manage projects.
-   **Project Rejection**: Projects can be rejected by any role, causing the project to be removed from the approval flow.

## Installation

### 1. Clone the Repository

```bash
git clone https://github.com/IslamAlsayed/approval-chain.git

cd approval-chain
```

## 2. Install Dependencies

```bash
composer update
```

## 3. Set Up Environment File

```bash
cp .env.example .env
```

### 4. Edit the .env file

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

## 5. Migrate Tables and Seed Data

### Run the following command to migrate the database tables and seed the initial data

```bash
php artisan migrate --seed
```

## 6. Running the Application

### To start the application, use the built-in PHP server with the following command:

```bash
php artisan serve
```

## 7. Accessing the Application

### The API should now be running and accessible at 

### [http://localhost:8000]

## Contact me

### If you have any questions or need further assistance, you can reach out to me:

### Email: eslamalsayed8133@gmail.com

### LinkedIn: [IslamAlsayed](https://www.linkedin.com/in/islam-alsayed7)
