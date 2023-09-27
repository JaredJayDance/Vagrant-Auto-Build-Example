<?php

$host = '192.168.56.13';
$dbname = 'netcafe';
$username = 'webuser';
$password = 'Quack1nce4^';

// Establish connection
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Add User
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_user'])) {
    $username = $_POST['username'];
    $stmt = $pdo->prepare("INSERT INTO users (username) VALUES (?)");
    $stmt->execute([$username]);
}

// Remove User
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_user'])) {
    $user_id = $_POST['user_id'];
    $stmt = $pdo->prepare("DELETE FROM users WHERE user_id = ?");
    $stmt->execute([$user_id]);
}

// Remove Booking
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_booking'])) {
    $booking_id = $_POST['booking_id'];
    
    try {
        $stmt = $pdo->prepare("SELECT machine_id FROM bookings WHERE booking_id = ?");
        $stmt->execute([$booking_id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $machine_id = $row['machine_id'];
        
        $deleteStmt = $pdo->prepare("DELETE FROM bookings WHERE booking_id = ?");
        $deleteStmt->execute([$booking_id]);

        $updateStmt = $pdo->prepare("UPDATE machines SET machine_status = 'Available' WHERE machine_id = ?");
        $updateStmt->execute([$machine_id]);

        echo "Booking removed successfully!";
    } catch (PDOException $e) {
        echo "Error removing booking: " . $e->getMessage();
    }
}

// Add Machine
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_machine'])) {
    $machine_id = $_POST['machine_id'];

    $stmt = $pdo->prepare("INSERT INTO machines (machine_id, machine_status) VALUES (?, 'Available')");
    $stmt->execute([$machine_id]);
}

// Change Machine Status
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_status'])) {
    $machine_id = $_POST['machine_id'];
    $new_status = $_POST['new_status'];
    
    try {
        $stmt = $pdo->prepare("UPDATE machines SET machine_status = ? WHERE machine_id = ?");
        $stmt->execute([$new_status, $machine_id]);

        echo "Machine status updated!";
    } catch (PDOException $e) {
        echo "Error updating machine status: " . $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Admin Panel</h1>

    <!-- Link to create booking -->
    <a href="booking.php"><button>Create Booking</button></a>

    <!-- Add User Form -->
    <form method="post">
        <input type="text" name="username" placeholder="Username" required>
        <button type="submit" name="add_user">Add User</button>
    </form>

    <!-- Remove User Form -->
    <form method="post">
        <select name="user_id" required>
            <option value="" disabled selected>Select User</option>
            <?php
            // Retrieve users from the database
            $stmt = $pdo->query("SELECT * FROM users");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='{$row['user_id']}'>{$row['username']}</option>";
            }
            ?>
        </select>
        <button type="submit" name="remove_user">Remove User</button>
    </form>

    <!-- Remove Booking Form -->
    <form method="post">
        <select name="booking_id" required>
            <option value="" disabled selected>Select Booking</option>
            <?php
            $stmt = $pdo->query("SELECT * FROM bookings");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='{$row['booking_id']}'>Booking ID {$row['booking_id']} (Machine {$row['machine_id']})</option>";
            }
            ?>
        </select>
        <button type="submit" name="remove_booking">Remove Booking</button>
    </form>

    <!-- Add Machine Form -->
    <form method="post">
        <input type="number" name="machine_id" placeholder="Machine ID" required>
        <button type="submit" name="add_machine">Add Machine</button>
    </form>

    <!-- Change Machine Status Form -->
    <form method="post">
        <select name="machine_id" required>
            <option value="" disabled selected>Select Machine</option>
            <?php
            // Retrieve machines from the database
            $stmt = $pdo->query("SELECT * FROM machines");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='{$row['machine_id']}'>Machine {$row['machine_id']}</option>";
            }
            ?>
        </select>
        <select name="new_status" required>
            <option value="" disabled selected>Select Status</option>
            <option value="Available">Available</option>
            <option value="Maintenance">Maintenance</option>
        </select>
        <button type="submit" name="change_status">Change Status</button>
    </form>

</body>
</html>
