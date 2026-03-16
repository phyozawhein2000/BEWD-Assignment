<?php
require_once 'db.php'; //connection

try {
    // 1. Users Table
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

    // 2. Recipes Table
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

    // 3. Community Cookbook Table
    $sql_cookbook = "CREATE TABLE IF NOT EXISTS community_cookbook (
        submission_id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT,
        recipe_title VARCHAR(150),
        recipe_content TEXT,
        submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB;";
    $sql = "ALTER TABLE community_cookbook 
            ADD COLUMN image_url VARCHAR(255) AFTER recipe_content";
    $sql_1 = "ALTER TABLE community_cookbook 
              ADD COLUMN difficulty ENUM('Easy', 'Medium', 'Hard') AFTER image_url";
    $sql_2 = "ALTER TABLE community_cookbook 
              ADD COLUMN cuisine_type VARCHAR(50) AFTER image_url";
    $sql_3 = "ALTER TABLE community_cookbook 
              ADD COLUMN totalLike INT DEFAULT 0 AFTER image_url";
    $sql_4 = "ALTER TABLE community_cookbook 
              ADD COLUMN totalComment INT DEFAULT 0 AFTER totalLike";              
              
              
    //4. Contact Form Table
    $sql_contact = "CREATE TABLE IF NOT EXISTS contact_messages (
        message_id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL,
        subject VARCHAR(150) NOT NULL,
        message TEXT NOT NULL,
        status ENUM('unread', 'read') DEFAULT 'unread',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB;";
    
    //5. Subscribers Table
    $sql_subscibe = "CREATE TABLE IF NOT EXISTS subscribers (
        id INT AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(255) NOT NULL UNIQUE,
        subscribed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB;";

    $sql_like = "CREATE TABLE IF NOT EXISTS cookbook_likes (
        like_id INT AUTO_INCREMENT PRIMARY KEY,
        submission_id INT, 
        user_id INT,      
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (submission_id) REFERENCES community_cookbook(submission_id) ON DELETE CASCADE,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
        UNIQUE KEY unique_like (submission_id, user_id) 
    ) ENGINE=InnoDB;";

    $sql_comment = "CREATE TABLE IF NOT EXISTS cookbook_comments (
        comment_id INT AUTO_INCREMENT PRIMARY KEY,
        submission_id INT, 
        user_id INT,      
        comment TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (submission_id) REFERENCES community_cookbook(submission_id) ON DELETE CASCADE,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB;";

    // Execute queries
    $pdo->exec($sql_users);
    $pdo->exec($sql_recipes);
    $pdo->exec($sql_cookbook);
    $pdo->exec($sql_contact);
    $pdo->exec($sql_subscibe);
    // $pdo->exec($sql);
    // $pdo->exec($sql_1);
    // $pdo->exec($sql_2);
    // $pdo->exec($sql_3);
    $pdo->exec($sql_4);
    $pdo->exec($sql_like);
    $pdo->exec($sql_comment);
    echo "Table updated successfully! Image column added.";

    // echo "Database tables created successfully! [cite: 44]";

} catch (PDOException $e) {
    die("Error creating tables: " . $e->getMessage());
}
?>