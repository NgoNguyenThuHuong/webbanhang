<?php
try {
    $db = new PDO('sqlite:app/config/database.sqlite');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $cols = ['email', 'phone', 'address', 'avatar_url'];
    foreach ($cols as $col) {
        try {
            $db->exec("ALTER TABLE users ADD COLUMN $col TEXT");
            echo "Added column $col\n";
        } catch (Exception $e) {
            echo "Column $col might already exist: " . $e->getMessage() . "\n";
        }
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
