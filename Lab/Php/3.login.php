<?php
  // Start session
  session_start();

  // Database connection details
  $host = "localhost";        // Database host
  $user = "root";             // Database user
  $password = "";             // Database password
  $dbname = "project";        // Database name
  $status = "";
  $class = "";

  // Create connection
  $conn = mysqli_connect($host, $user, $password, $dbname);

  // Check connection
  if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
  }

  // Handle form submission
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // Sanitize inputs
      $name = trim($_POST['name']);
      $password = trim($_POST['password']);

      // Prepare SQL statement to prevent SQL injection
      $stmt = $conn->prepare("SELECT * FROM registration WHERE name = ? LIMIT 1");
      $stmt->bind_param("s", $name);
      $stmt->execute();
      $result = $stmt->get_result();

      // Check if user exists
      if ($row = $result->fetch_assoc()) {
          // Verify hashed password
          if (password_verify($password, $row['password'])) {
              // Login success
              $_SESSION['name'] = $row['name'];
              $_SESSION['email'] = $row['email'];

              $status = "Login successful! Welcome, " . $_SESSION['name'] . ". Your email is " . $_SESSION['email'] . ".";
              $class = "success";
          } else {
              $status = "Invalid password.";
              $class = "fail";
          }
      } else {
          $status = "User not found.";
          $class = "fail";
      }

      // Close statement
      $stmt->close();
  }

  // Close connection
  mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Login form</title>
  </head>
  <style> 
    body{
      font-family: 'Poppins', sans-serif;
    }
    .container{
      width: 350px;
      margin: auto;
    }
    h1{
      text-align: center;
    }
    form{
      /* background-color: aqua; */
      width: 350px;
      font-size: 16px;
    }
    label{
      width: 100px;
      display: inline-block;
      margin-right: 20px;
    }
    form fieldset{
      border: 2px solid black;
      border-radius: 10px;
      padding: 20px;
    }
    .cont{
      margin-bottom: 15px;
    }
    .button input[type="submit"]{
      padding: 8px;
      font-weight: bold;
    }
    .status{
      margin-top: 30px;
      font-weight: bold;
      text-align: justify;
    }
    .success{
      color: green;
    }
    .fail{
      color: red;
    }
    
  </style>
  <body>
    <h1>LOGIN FORM</h1>
    <div class="container">
      <form method="post" action="login.php">
        <fieldset>
          <div class="cont">
            <label for="">Username:</label> <input type="text" name="name" required><br>
          </div>

          <div class="cont">
            <label for="">Password:</label> <input type="password" name="password" required><br>
          </div>

          <div class="button">
            <input type="submit" value="Login">
          </div>
        </fieldset>
      </form>

    <div class="status <?php echo $class; ?>"><?php echo $status?></div>

    </div>

  </body>
</html>