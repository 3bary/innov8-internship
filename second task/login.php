<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'db.php';
require_once 'user.php';
// Check if form was submitted
if ($_POST) {
    // Get form data and PREVENT XSS by cleaning input
    $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
    $password = $_POST['password']; // Don't clean password


    // Connect to DB
    $database = new Database();
    $dbConn = $database->connect();

    // Prepare and run login query
    $result = User::login($dbConn, $email, $password);


    // If login successful
    if ($result && $result->num_rows > 0) {
        echo "<h2>Login Successful!</h2>";

        // Get all users to display
        $allUsers = $database->query("SELECT id, fullname, email, gender, hobbies, country FROM users");

        if ($allUsers && $allUsers->num_rows > 0) {
            echo "<h3>All Registered Users</h3>";
            echo "<table border='1' cellpadding='10'>";
            echo "<tr><th>Full Name</th><th>Email</th><th>Gender</th><th>Hobbies</th><th>Country</th><th>Action</th></tr>";

            $users = [];

            while ($row = $allUsers->fetch_assoc()) {
                $user = new User(
                    $row['fullname'],
                    $row['email'],
                    null,  // Only if needed — can use empty string if not used
                    $row['gender'],
                    $row['hobbies'],
                    $row['country']
                );
                $user->id = $row['id']; 
                $users[] = $user;
            }

            // Now loop over the array of User objects
            foreach ($users as $user) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($user->fullname) . "</td>";
                echo "<td>" . htmlspecialchars($user->email) . "</td>";
                echo "<td>" . htmlspecialchars($user->gender) . "</td>";
                echo "<td>" . htmlspecialchars($user->hobbies) . "</td>";
                echo "<td>" . htmlspecialchars($user->country) . "</td>";
                echo "<td><a href='edit_user.php?id=" . $user->id . "'>Edit</a></td>";
                echo "</tr>";
            }


            echo "</table>";
        } else {
            echo "<p>No users found in the database.</p>";
        }
    } else {
        echo "<h2>Login Failed!</h2>";
        echo "<p>Invalid email or password.</p>";
        echo "<br><a href='login.html'>Back to Login</a>";
        echo "<br><a href='registration.html'>Don't have an account? Register here</a>";
    }

    // Disconnect from DB
    $database->disconnect();
} else {
    // If someone tries to access login.php directly
    echo "<h2>No login data received!</h2>";
    echo "<a href='login.html'>Go to login form</a>";
}
?>