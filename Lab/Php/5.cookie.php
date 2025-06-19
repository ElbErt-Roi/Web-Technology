<?php
  $name = isset($_POST['username']) ? $_POST['username'] : '';
  $email = isset($_POST['email']) ? $_POST['email'] : '';

  // Store cookie (valid for 1 hour)
  if (isset($_POST['store'])) {
      if (!empty($name) && !empty($email)) {
          setcookie("username", $name , time() + (7*24*60*60)); // 1 hour expiry
          setcookie("email", $email, time() + (7*24*60*60));
          $message = "Cookie has been stored.<br>";
      } else {
          $message = "Please enter both username and email to store.<br>";
      }
  }

  // Retrieve cookie
  if (isset($_POST['retrieve'])) {
      if (isset($_COOKIE['username']) && isset($_COOKIE['email'])) {
          $message = "Retrieved Cookie Value:<br> Name: " . $_COOKIE['username'] . "<br>E-mail: " . $_COOKIE['email'];
      } else {
          $message = "No cookie found.<br>";
      }
  }

  // Destroy cookie
  if (isset($_POST['destroy'])) {
      setcookie("username", "", time() - 1); // Expire the cookie
      setcookie("email", "", time() - 1);
      $message = "Cookie has been destroyed.<br>";
  }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Cookie Example</title>
    <style>
      form .contents label {
        display: inline-block;
        width: 130px;
      }
    </style>
</head>
<body>
    <h2> COOKIE (Store / Retrieve / Destroy)</h2>

    <form method="post">
        <div class="contents">
          <label>Enter Username:</label>
          <input type="text" name="username"><br><br>
          <label>Enter Email:</label>
          <input type="email" name="email">
        </div>
        <br><br>
        <input type="submit" name="store" value="Store Cookie">
        <input type="submit" name="retrieve" value="Retrieve Cookie">
        <input type="submit" name="destroy" value="Destroy Cookie">
    </form>

    <?php if (isset($message)): ?>
        <p><strong><?php echo $message; ?></strong></p>
    <?php endif; ?>
</body>
</html>
