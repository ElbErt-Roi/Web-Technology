<?php
// Start the session
session_start();

// Store session data
if (isset($_POST['store'])) {
    $_SESSION['username'] = $_POST['username'];
    $message = "Session data stored successfully.";
}

// Retrieve session data
if (isset($_POST['retrieve'])) {
    if (isset($_SESSION['username'])) {
        $message = "Stored Username: " . $_SESSION['username'];
    } else {
        $message = "No session data found.";
    }
}

// Destroy session data
if (isset($_POST['destroy'])) {
    session_unset();       // Remove all session variables
    session_destroy();     // Destroy the session
    $message = "Session destroyed successfully.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Session Example</title>
</head>
<body>
    <h2>Session Example (Store / Retrieve / Destroy)</h2>

    <form method="post">
        <label>Enter Username:</label>
        <input type="text" name="username">
        <br><br>
        <input type="submit" name="store" value="Store Session">
        <input type="submit" name="retrieve" value="Retrieve Session">
        <input type="submit" name="destroy" value="Destroy Session">
    </form>

    <?php if (isset($message)): ?>
        <p><strong><?php echo $message; ?></strong></p>
    <?php endif; ?>
</body>
</html>
