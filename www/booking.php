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

// Query all available machines
$query = "SELECT machine_id FROM machines WHERE machine_status = 'Available'";
$stmt = $pdo->query($query);
$availableMachines = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $machine_id = $_POST['machine_id'];
    $booking_date = $_POST['booking_date'];
    $booking_time = $_POST['booking_time'];

    try {
        // Add booking to database
        $stmt = $pdo->prepare("INSERT INTO bookings (user_id, machine_id, booking_date, booking_time) VALUES (?, ?, ?, ?)");
        $stmt->execute([$user_id, $machine_id, $booking_date, $booking_time]);
        
        // Update machines status
        $updateStmt = $pdo->prepare("UPDATE machines SET machine_status = 'Occupied' WHERE machine_id = ?");
        $updateStmt->execute([$machine_id]);

        echo "Booking successful!";
    } catch (PDOException $e) {
        echo "Error creating booking: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Internet Cafe Booking</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Create Booking</h1>

    <a id="admin_button" href="staffpage.php"><button>Admin Page</button></a>

    <!-- Create Booking Form -->
    <form method="post">
        <label for="user_id">User ID:</label>
        <input type="text" id="user_id" name="user_id" required><br>
        
        <label for="machine_id">Machine ID:</label>
        <select id="machine_id" name="machine_id" required>
        <option value="" disabled selected>Select Machine Number</option>
            <?php
            // Dynamically populate dropdown options based on available machines
            foreach ($availableMachines as $machine) {
                echo "<option value='{$machine['machine_id']}'>Machine {$machine['machine_id']}</option>";
            }
            ?>
        </select><br>
        
        <label for="booking_date">Booking Date:</label>
        <input type="date" id="booking_date" name="booking_date" required min="<?php echo date('Y-m-d'); ?>"><br>
        
        <label for="booking_time">Booking Time:</label>
        <input type="time" id="booking_time" name="booking_time" required step="3600"><br>
        
        <button type="submit">Create Booking</button>
    </form>
</body>
</html>
