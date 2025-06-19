<?php
  $name = $pass = $pin = '';
  $error_name = $error_pass = $error_pin = "";
  $class = $message = '';

  $login = [
      [
          "name" => "Albert Rai",
          "pass" => "RAI123",
          "pin"  => "123"
      ],
      [
          "name" => "Ram Thapa",
          "pass" => "Ram123",
          "pin"  => "2d48"
      ]
  ];

  $user_input = [];

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['name']) && isset($_POST['password']) && isset($_POST['pin'])) {
      if (!empty($_POST['name']) && !empty($_POST['password']) && !empty($_POST['pin'])) {
        $user_input = [
          "name" => $_POST['name'],
          "password" => $_POST['password'],
          "pin" => $_POST['pin']
        ];

        $authenticated = false; // ✅ Added flag

        for ($i = 0; $i < 2; $i++) {
          if (
            $user_input['name'] == $login[$i]['name'] &&
            $user_input['password'] == $login[$i]['pass'] &&
            $user_input['pin'] == $login[$i]['pin']
          ) {
            $name = $login[$i]['name'];
            $pass = $login[$i]['pass'];
            $pin = $login[$i]['pin'];
            $message = "Authentication Successful :) Welcome, <strong>" . $name . "</strong>";
            $class = "success";
            $authenticated = true; // ✅ mark as success
            break; // ✅ stop checking further
          }
        }

        if (!$authenticated) { // ✅ Only show fail if no match
          $message = "Authentication failed :( Invalid credentials.";
          $class = "fail";
        }

      } else {
        $message = "Please enter all fields";
        $class = "fail";
      }
    }
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Authentication Form</title>
    <style>
      *{margin:0;padding:0;}
      .container{
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 20px;
      }
      h1{
        text-align: center;
        margin-top: 20px;
      }
      fieldset{
        border: 2px solid rgb(76, 76, 76);
        border-radius: 20px;
        padding: 30px 20px;
      }
      .contents label{
        display: inline-block;
        width: 100px;
        font-weight: bold;
      }
      .contents{margin-bottom:15px;}
      .button input{padding: 8px;}
      .error{color: red;}
      .success{color: green;}
      .fail{color: red;}
    </style>
  </head>
  <body>
    <div class="container">
      <h1>Authentication Form</h1>
      <form action="#" method="post">
        <fieldset>
          <div class="contents">
            <label for="name">Username: </label>
            <input type="text" name="name" placeholder="Enter username" value="<?php echo $name ?>">
            <div class="error"><?php echo $error_name ;?></div>
          </div>

          <div class="contents">
            <label for="password">Password: </label>
            <input type="password" name="password" placeholder="Enter password">
            <div class="error"><?php echo $error_pass ;?></div>
          </div>

          <div class="contents">
            <label for="pin">PIN: </label>
            <input type="text" name="pin" placeholder="Enter PIN" value="<?php echo $pin ?>">
            <div class="error"><?php echo $error_pin ;?></div>
          </div>

          <div class="button">
            <input type="submit" name="submit" value="SUBMIT">
          </div>
        </fieldset>
      </form>
      <div class="<?php echo $class?>"><?php echo $message; ?></div>
    </div>
  </body>
</html>