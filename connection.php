<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "db_hpj";

    session_start();

    // Create a PDO connection
    try {
        $connPDO = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // Set PDO error mode to exception
        $connPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $session_login = isset($_SESSION['login']) ? $_SESSION['login'] : '';
        
        if (isset($session_login)) {
            $fetchQuery = "SELECT * FROM `user` WHERE user_id = ?";
            $fetchStmt = $connPDO->prepare($fetchQuery);
            $fetchStmt->execute([$session_login]);
            if ($fetchStmt->rowCount() > 0) {
                $fetchResult = $fetchStmt->fetch();

                $membership = $fetchResult['membership'];
    
                $_SESSION['membership'] = $membership;
            } else {

                $_SESSION['membership'] = 0;
            }
        }
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }

    // Create a mysqli connection
    $connMysqli = new mysqli($servername, $username, $password, $dbname);

    // Check mysqli connection
    if ($connMysqli->connect_error) {
        die("Mysqli Connection failed: " . $connMysqli->connect_error);
    }
?>


