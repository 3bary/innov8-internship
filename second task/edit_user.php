<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'db.php';
require_once 'user.php';
$database = new Database();
$db = $database->connect();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update user
    $id = $_POST['id'];
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $hobbies = $_POST['hobbies'];
    $country = $_POST['country'];

    $stmt = $db->prepare("UPDATE users SET fullname = ?, email = ?, gender = ?, hobbies = ?, country = ? WHERE id = ?");
    $stmt->bind_param("sssssi", $fullname, $email, $gender, $hobbies, $country, $id);

    if ($stmt->execute()) {
        echo "<h2>User updated successfully.</h2>";
    } else {
        echo "Error updating user: " . $stmt->error;
    }

    $stmt->close();

} else {
    // GET method: show the form with user data
    if (!isset($_GET['id'])) {
        echo "User ID is missing.";
        exit;
    }

    $id = $_GET['id'];
    $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $user = new User(
            $row['fullname'],
            $row['email'],
            $row['password'], // password is not edited here
            $row['gender'],
            $row['hobbies'],
            $row['country']
        );
        $user->id = $row['id'];

        // Make user object available to the form
        include 'edit_user.html';
    } else {
        echo "User not found.";
    }

    $stmt->close();
}

$database->disconnect();
?>
