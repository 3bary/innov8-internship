<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'db.php';
require_once 'user.php';
// Check if form was submitted
if ($_POST) {
    // Get form data and PREVENT XSS by cleaning input
    $fullname = htmlspecialchars($_POST['fullname'], ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
    $password = $_POST['password']; // Don't clean password (we'll hash it)
    $confirm_password = $_POST['confirm_password'];
    $gender = htmlspecialchars($_POST['gender'], ENT_QUOTES, 'UTF-8');
    $country = htmlspecialchars($_POST['country'], ENT_QUOTES, 'UTF-8');

    // Handle hobbies (checkboxes)
    $hobbies = "None selected";
    if (isset($_POST['hobbies'])) {
        $clean_hobbies = array_map(function ($hobby) {
            return htmlspecialchars($hobby, ENT_QUOTES, 'UTF-8');
        }, $_POST['hobbies']);
        $hobbies = implode(", ", $clean_hobbies);
    }

    // Simple password check
    if ($password !== $confirm_password) {
        echo "<h2>Error: Passwords do not match!</h2>";
        echo "<a href='registration.html'>Go back to registration form</a>";
        exit;
    }

      // Connect to DB
    $database = new Database();
    $dbConn = $database->connect();

    // Create user object
    $user = new User($fullname, $email, $password, $gender, $hobbies, $country);

    // Save user to DB
    if ($user->register($dbConn)) {
        echo "<h2>Registration Successful!</h2>";
        echo "<h3>Your submitted information:</h3>";
        echo "<p><strong>Full Name:</strong> $fullname</p>";
        echo "<p><strong>Email:</strong> $email</p>";
        echo "<p><strong>Password:</strong> " . str_repeat("*", strlen($password)) . "</p>";
        echo "<p><strong>Gender:</strong> $gender</p>";
        echo "<p><strong>Hobbies:</strong> $hobbies</p>";
        echo "<p><strong>Country:</strong> $country</p>";

        echo "<br><a href='registration.html'>Register another user</a>";
        echo "<br><a href='login.html'><button>Go to Login</button></a>";
    } else {
        echo "<h2>Error: Could not save user.</h2>";
        echo "<a href='registration.html'>Go back to registration form</a>";
    }

    // Disconnect from DB
    $database->disconnect();

} else {
    echo "<h2>No form data received!</h2>";
    echo "<a href='registeration.html'>Go to registration form</a>";
}
?>
