<?php
  $hostname = "localhost";
  $username = "root";
  $password = "";
  $database = "project";
  $conn = "";

  $error_name = $error_email = $error_pass = $error_phone = $error_gender = "";
  $name  = $email = $password = $phone = $gender = $faculty = ""; 
  $class = $message="";

  // Establish connection
  $conn = new mysqli($hostname, $username, $password, $database);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['clear'])){
      $name  = $email = $password = $phone = $gender = $faculty = ""; 
    }
    if (isset($_POST['submit'])) {

      // Name Validation
      if (isset($_POST['name']) && trim($_POST['name'])) {
        $name = $_POST['name'];
      } else {
        $error_name = "Please enter your name";
      }

      // Email Validation
      if (isset($_POST['email']) && trim($_POST['email'])) {
        $email = $_POST['email'];
      } else {
        $error_email = "Please enter your email";
      }

      // Password Validation
      if (isset($_POST['password']) && trim($_POST['password'])) {
        $password = $_POST['password'];
      } else {
        $error_pass = "Please enter your password";
      }

      // Phone Validation
      if (isset($_POST['phone']) && trim($_POST['phone'])) {
        $phone = $_POST['phone'];
      } else {
        $error_phone = "Please enter your phone number";
      }

      // Gender Validation
      if (isset($_POST['gender']) && !empty(trim($_POST['gender']))) {
        $gender = $_POST['gender'];
      } else {
        $error_gender = "Please select your gender";
      }

      // Faculty (optional)
      if (isset($_POST['faculty']) && !empty(trim($_POST['faculty']))) {
        $faculty = $_POST['faculty'];
      }

      // Insert into database
      if ($error_name == "" && $error_email == "" && $error_pass == "" && $error_phone == "" && $error_gender == "") {
        $hpassword = password_hash($password, PASSWORD_DEFAULT);

        // Quote string values to avoid SQL syntax errors
        $sql = "INSERT INTO registration(name,email,password,phone,gender,faculty)
                VALUES('$name', '$email', '$hpassword', '$phone', '$gender', '$faculty')";

        // Move query inside form check
        if (mysqli_query($conn, $sql)) {
          $message = "Registration Successful";
          $class = "success";
        } else {
          $message = "Error: " . mysqli_error($conn);
          $class = "fail";
        }
      }
    }
  }
?>


<!DOCTYPE html>
<html>
  <head>
    <title>Registration Form</title>
    <style>
      h1{text-align:center;}
      .container {
        max-width: 500px;
        margin: auto;
        border: 1px solid black;
        padding: 50px 20px;
        border-radius: 20px;
        display:flex;
        justify-content: center;
      }
      .contents {
        width: 100%;
        margin-bottom: 20px;
      }
      .contents label {
        width: 180px;
        display: inline-block;
        font-size: 18px;
        font-weight:bold;
      }
      .contents input[type="text"], input[type="email"], input[type="password"] {
        height: 30px;
        width: 270px;
      }
      .contents .error{
        margin-left: 185px;
        color: red;
        margin-top: 5px;
        /* background-color: aqua; */
      }
      .contents select{
        width:135px;
        text-align:center;
        height:30px;  
      }
      .button{
        display:inline-block;
        /* background-color:aqua;  */
        margin-bottom: 20px;
        margin-left:185px;
      }
      .button input[type="submit"]{
        padding: 10px;
        font-weight:bold;
      }
      .success{
        color: green;
      }
      .fail{
        color: red;
      }
    </style>
  </head>
  <body>
    <h1>REGISTRATION FORM</h1>
    <div class="container">
      <form action="#" method="post">
        <div class="contents">
          <label for="name">Name: </label>
          <input type="text" name="name" placeholder="Enter name" value="<?php echo htmlspecialchars($name); ?>">
          <div class="error"><?php echo $error_name; ?></div>
        </div>

        <div class="contents">
          <label for="email">E-mail: </label>
          <input type="email" name="email" placeholder="Enter E-mail" value="<?php echo $email; ?>">
          <div class="error"><?php echo $error_email; ?></div>
        </div>

        <div class="contents">
          <label for="password">Password: </label>
          <input type="password" name="password" placeholder="Enter Password">
          <div class="error"><?php echo $error_pass; ?></div>
        </div>

        <div class="contents">
          <label for="phone">Phone: </label>
          <input type="text" name="phone" placeholder="Enter Phone" value="<?php echo $phone; ?>">
          <div class="error"><?php echo $error_phone; ?></div>
        </div>

        <div class="contents">
          <label for="gender">Gender: </label>
          <input type="radio" name="gender" value="Male">Male
          <input type="radio" name="gender" value="Female">Female
          <div class="error"><?php echo $error_gender; ?></div>
        </div>

        <div class="contents">
          <label for="faculty">Faculty: </label>
          <select name="faculty">
            <option value="BBS">BBS</option>
            <option value="BBA">BBA</option>
            <option value="BCA">BCA</option>
          </select>
        </div>

        <div class="button">
          <input type="submit" name="submit" value="SUBMIT">
          <input type="submit" name="clear" value="CLEAR">
        </div>

        <div class="<?php echo $class;?>"><?php echo $message;?></div>
      </form>
    </div>
  </body>
</html>