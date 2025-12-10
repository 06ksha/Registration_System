<?php

$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

$errors = [];  

if (empty($name)) {
    $errors[] = "Name is required";
}

if (empty($email)) {
    $errors[] = "Email is required";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid email format";
}

if (empty($password)) {
    $errors[] = "Password is required";
} elseif (strlen($password) < 6) {
    $errors[] = "Password must be at least 6 characters";
}

if ($password !== $confirm_password) {
    $errors[] = "Passwords do not match";
}

// If validation fails → show errors
if (!empty($errors)) {
    echo "<h3>Error:</h3>";
    foreach ($errors as $e) {
        echo "<p style='color:red;'>$e</p>";
    }
    echo "<a href='registration.html'>Go Back</a>";
    exit;
}

$file = "users.json";
$json_data = file_get_contents($file);
$users = json_decode($json_data, true);

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// New user
$new_user = [
    "name" => $name,
    "email" => $email,
    "password" => $hashed_password
];

// Add user to array
$users[] = $new_user;

// Save back to file
file_put_contents($file, json_encode($users, JSON_PRETTY_PRINT));

echo "<h3 style='color:green;'>Registration Successful!</h3>";
echo "<a href='registration.html'>Register Another User</a>";

?>