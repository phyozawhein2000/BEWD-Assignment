<?php
require_once 'db.php'; // အရင်ရေးခဲ့တဲ့ connection file ကို ခေါ်သုံးခြင်း

try {
    // 1. Users Table (Task 2 အတွက် lockout logic ပါဝင်သည်) [cite: 50]
    $sql_users = "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        first_name VARCHAR(50) NOT NULL,
        last_name VARCHAR(50) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        role ENUM('admin', 'user') DEFAULT 'user',
        failed_attempts INT DEFAULT 0,
        lockout_until DATETIME NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB;";

    // 2. Recipes Table (Recipe Collection အတွက်) [cite: 29, 55]
    $sql_recipes = "CREATE TABLE IF NOT EXISTS recipes (
        recipe_id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(150) NOT NULL,
        description TEXT,
        cuisine_type VARCHAR(50),
        dietary_preference VARCHAR(50),
        difficulty ENUM('Easy', 'Medium', 'Hard'),
        image_url VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB;";

    // 3. Community Cookbook Table (Foreign Key ပါဝင်သည်) [cite: 30, 45, 56]
    $sql_cookbook = "CREATE TABLE IF NOT EXISTS community_cookbook (
        submission_id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT,
        recipe_title VARCHAR(150),
        recipe_content TEXT,
        submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB;";

    // Execute queries
    $pdo->exec($sql_users);
    $pdo->exec($sql_recipes);
    $pdo->exec($sql_cookbook);

    echo "Database tables created successfully! [cite: 44]";

} catch (PDOException $e) {
    die("Error creating tables: " . $e->getMessage());
}
?>