<?php
$connection = mysqli_connect("localhost", "root", "1234", "user_system");

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update user
    $id = $_POST['id'];
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $hobbies = $_POST['hobbies'];
    $country = $_POST['country'];

    $stmt = mysqli_prepare($connection, "UPDATE users SET fullname = ?, email = ?, gender = ?, hobbies = ?, country = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "sssssi", $fullname, $email, $gender, $hobbies, $country, $id);

    if (mysqli_stmt_execute($stmt)) {
        echo "<h2>User updated successfully.</h2>";
    } else {
        echo "Error updating user: " . mysqli_stmt_error($stmt);
    }

    mysqli_stmt_close($stmt);
} else {
    if (!isset($_GET['id'])) {
        echo "User ID is missing.";
        exit;
    }

    $id = $_GET['id'];
    $stmt = mysqli_prepare($connection, "SELECT * FROM users WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($user = mysqli_fetch_assoc($result)) {
        // Include the form HTML and pass $user
        include 'edit_user.html';
    } else {
        echo "User not found.";
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($connection);
?>
