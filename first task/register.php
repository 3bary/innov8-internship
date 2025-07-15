<?php
// Check if form was submitted
if ($_POST) {
    // Get form data
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $gender = $_POST['gender'];
    $country = $_POST['country'];
    
    // Handle hobbies (checkboxes)
    $hobbies = "";
    if (isset($_POST['hobbies'])) {
        $hobbies = implode(", ", $_POST['hobbies']);
    } else {
        $hobbies = "None selected";
    }
    
    // Simple password check
    if ($password != $confirm_password) {
        echo "<h2>Error: Passwords do not match!</h2>";
        echo "<a href='registration.html'>Go back to registration form</a>";
        exit;
    }
    
    // Display confirmation message
    echo "<h2>Registration Successful!</h2>";
    echo "<h3>Your submitted information:</h3>";
    echo "<p><strong>Full Name:</strong> " . $fullname . "</p>";
    echo "<p><strong>Email:</strong> " . $email . "</p>";
    echo "<p><strong>Password:</strong> " . str_repeat("*", strlen($password)) . "</p>";
    echo "<p><strong>Gender:</strong> " . $gender . "</p>";
    echo "<p><strong>Hobbies:</strong> " . $hobbies . "</p>";
    echo "<p><strong>Country:</strong> " . $country . "</p>";
    
    echo "<br><a href='registration.html'>Register another user</a>";
    
} else {
    // If someone tries to access register.php directly
    echo "<h2>No form data received!</h2>";
    echo "<a href='registration.html'>Go to registration form</a>";
}
?>