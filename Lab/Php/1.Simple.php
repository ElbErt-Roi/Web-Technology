<?php
  $p = $t = $r = '';
  $ans = '';
  $a = '';
  $type = '';
  $error_p = $error_t = $error_r = "";

  if ($_SERVER['REQUEST_METHOD'] == "POST") {

    if (isset($_POST['principle']) && trim($_POST['principle']) && !empty($_POST['principle'])) {
      $p = (float) $_POST['principle'];
    } else {
      $error_p = "Please enter principle.<br>";
    }

    if (isset($_POST['time']) && trim($_POST['time']) && !empty($_POST['time'])) {
      $t = (float) $_POST['time'];
    } else {
      $error_t = "Please enter time.<br>";
    }

    if (isset($_POST['rate']) && trim($_POST['rate']) && !empty($_POST['rate'])) {
      $r = (float) $_POST['rate'];
    } else {
      $error_r = "Please enter rate.<br>";
    }

    if ($error_p === "" && $error_t === "" && $error_r === "") {
      if (isset($_POST['SI'])) {
        $type = "Simple Interest: ";
        $ans = ($p * $t * $r) / 100;
      } elseif (isset($_POST['CI'])) {
        $type = "Compound Interest: ";
        $a = $p * pow((1 + $r / 100), $t);
        $ans = $a - $p;
      }
    }
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Simple Interest & Compound Interest Calculation</title>
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
      .contents input[type="number"] {
        height: 30px;
        width: 270px;
      }
      .error{
        margin-left: 185px;
        color:red;
      }
      .buttons{
        display:inline-block;
        /* background-color:aqua;  */
        margin-bottom: 20px;
        margin-left:185px;
      }
      .buttons input[type="submit"]{
        padding: 10px;
        font-size: 12px;
        font-weight:bold;
        width: 120px;
      }
      .buttons input[type="submit"]:nth-child(2){
        width:150px;
      }

    </style>
  </head>
  <body>
    <h1>SIMPLE & COMPOUND INTEREST  CALCULATOR</h1>
    <div class="container">
      <form action="#" method="post"> 
        <div class="contents">
          <label for="principle">Principle: </label>
          <input type="number" step="any" placeholder="Enter Principle" name="principle" value="<?php echo $p; ?>"><br>
          <div class="error"><?php echo $error_p; ?></div>
        </div>
        
        <div class="contents">
          <label for="rate">Rate: </label>
          <input type="number" step="any" placeholder="Enter Rate" name="rate" value="<?php echo $r; ?>"><br>
          <div class="error"><?php echo $error_r; ?></div>
        </div>

        <div class="contents">
          <label for="time">Time: </label>
          <input type="number" step="any" placeholder="Enter Time" name="time" value="<?php echo $t; ?>"><br>
          <div class="error"><?php echo $error_t; ?></div>
        </div>

        <div class="buttons">
          <input type="submit" name="SI" value="Simple Interest">
          <input type="submit" name="CI" value="Compound Interest">
        </div>

        <div class="contents">
          <label for="answer"><?php echo $type; ?></label>
          <input type="number" step="any"  value="<?php echo $ans; ?>" readonly>
        </div>
      </form>
    </div>
  </body>
</html>