<?php
// Test password verification
$password = 'admin123';
$hash = '$2y$10$LKry.ARXPS14sTEZD48YyekYYmyO9CLKEwL0a90JIBQqoltSp87ei';

if (password_verify($password, $hash)) {
    echo "✅ Password verification WORKS! The hash matches 'admin123'\n";
} else {
    echo "❌ Password verification FAILED! The hash does not match 'admin123'\n";
}

// Test database connection
try {
    $pdo = new PDO('mysql:host=localhost;dbname=lms_db', 'root', '');
    echo "✅ Database connection WORKS!\n";
    
    // Test getting admin user
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = 'admin'");
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        echo "✅ Admin user found in database!\n";
        echo "   Username: " . $user['username'] . "\n";
        echo "   Email: " . $user['email'] . "\n";
        echo "   Role: " . $user['role'] . "\n";
        
        if (password_verify('admin123', $user['password'])) {
            echo "✅ Password verification against database WORKS!\n";
        } else {
            echo "❌ Password verification against database FAILED!\n";
        }
    } else {
        echo "❌ Admin user NOT found in database!\n";
    }
    
} catch (PDOException $e) {
    echo "❌ Database connection FAILED: " . $e->getMessage() . "\n";
}
?> 
