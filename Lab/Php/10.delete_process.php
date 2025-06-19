<?php
  // Establish connection with error checking
  $conn = new mysqli("localhost", "root", "", "project");
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $message = $class = "";
  $user = [];
  $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

  // Handle GET request to retrieve book info
  if ($_SERVER['REQUEST_METHOD'] == 'GET' && $id && empty($_POST)) {
    $sql = "SELECT * FROM books WHERE id = $id";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) == 1) {
      $user = mysqli_fetch_assoc($result);
    } else {
      $message = "No book found.";
      $class = "fail";
    }
  }

  // Handle POST request for deletion
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['yes'])) {
      $id = intval($_POST['id']);
      $sql = "DELETE FROM books WHERE id = $id";

      if (mysqli_query($conn, $sql)) {
        $message = "Record deleted successfully.";
        $class = "success";
        $user = []; // Clear user to hide form
      } else {
        $message = "Error deleting record: " . mysqli_error($conn);
        $class = "fail";
      }
    } elseif (isset($_POST['no'])) {
      header("Location: 10.delete.php");
      exit();
    }
  }
?>
<!DOCTYPE html>
<html>
<head>
  <title>Delete Book</title>
  <style>
    *{
      margin:0; padding: 0;
    }
    .container {
      display: flex;
      flex-direction: column;
      align-items: center;
      width: 50%;
      margin: 30px auto;
      border: 1px solid black;
      border-radius: 20px;
      padding: 20px;
    }
    .contents{
      font-size: 18px;
      margin: 30px 0;
    }
    .contents label{
      display: inline-block;
      font-weight: bold;
      width: 80px;
    }
    .buttons{
      display: flex;
      justify-content: space-evenly;
    }
    form input {
      padding: 8px;
      margin: 4px;
    }
    .success {
      color: green;
    }
    .fail {
      color: red;
    }
    .success, .fail{text-align: center; margin-top: 20px;}
  </style>
</head>
<body>
  <div class="container">
    <?php if (!empty($user)): ?>
      <h2>Do you want to delete this book info?</h2>
      <form action="" method="post">
        <input type="hidden" name="id" value="<?= $id ?>">

        <div class="contents">
          <label>Title:</label> <?= htmlspecialchars($user['title']) ?><br>
          <label>Author:</label> <?= htmlspecialchars($user['author']) ?><br>
        </div>

        <div class="buttons">
          <input type="submit" name="yes" value="DELETE">
          <input type="submit" name="no" value="GO BACK">
        </div>
      </form>
    <?php else: ?>
      <p style="font-size: 18px; margin: 20px;">No book to display.</p>
      <form action="" method="post">
        <input type="submit" name="no" value="GO BACK">
      </form>
    <?php endif; ?>
  </div>

  <!-- Message displayed below the container -->
  <?php if ($message): ?>
    <div class="<?= $class ?>">
      <?= htmlspecialchars($message) ?>
    </div>
  <?php endif; ?>
</body>
</html>
