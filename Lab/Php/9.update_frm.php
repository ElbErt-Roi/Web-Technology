<?php
  $conn = new mysqli("localhost", "root", "", "project");
  if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

  $message = $class = "";
  $user = [];

  if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $result = $conn->query("SELECT * FROM books WHERE id = $id");
    if ($result && $result->num_rows === 1) {
      $user = $result->fetch_assoc();
    } else {
      $message = "Book not found.";
      $class = "fail";
    }
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['title'], $_POST['publisher'], $_POST['author'], $_POST['edition'],
            $_POST['pages'], $_POST['price'], $_POST['date'], $_POST['isbn'])) {

    if (!empty($_POST['title']) && !empty($_POST['publisher']) && !empty($_POST['author']) &&
        !empty($_POST['edition']) && !empty($_POST['pages']) && !empty($_POST['price']) &&
        !empty($_POST['date']) && !empty($_POST['isbn'])) {

      $id = intval($_POST['id']);
      $title = $conn->real_escape_string($_POST['title']);  
      $publisher = $conn->real_escape_string($_POST['publisher']);
      $author = $conn->real_escape_string($_POST['author']);
      $edition = $conn->real_escape_string($_POST['edition']);
      $pages = $conn->real_escape_string($_POST['pages']);
      $price = $conn->real_escape_string($_POST['price']);
      $date = $conn->real_escape_string($_POST['date']);
      $isbn = $conn->real_escape_string($_POST['isbn']);

      if (!is_numeric($pages) || !is_numeric($price)) {
        $message = "Pages and Price must be numeric.";
        $class = "fail";
      } else {
        $sql = "UPDATE books SET
                  title='$title',
                  publisher='$publisher',
                  author='$author',
                  edition='$edition',
                  pages='$pages',
                  price='$price',
                  publish_date='$date',
                  isbn='$isbn'
                WHERE id=$id";

        if ($conn->query($sql) === TRUE) {
          header("Location: 9.update.php");
          exit;
        } else {
          $message = "Error updating record: " . $conn->error;
          $class = "fail";
        }
      }

    } else {
      $message = "Please fill in all fields.";
      $class = "fail";
    }

  } else {
    $message = "Some fields are missing.";
    $class = "fail";
  }
}

  $conn->close();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Book</title>
  <style>
    /* Your styles here */
    .container{
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 20px;
      }
      form fieldset{
        padding: 40px 30px;
        border-radius: 20px;
      }
      .contents{
        margin-bottom: 15px;
      }
      .contents label{
        display: inline-block;
        width: 120px;
        font-size: 17px;
      }
      .contents input{
        height: 20px;
      }
      .button input{
        padding: 8px;
      }
      .success{color: green;}
      .fail{color: red;}
  </style>
</head>
  <body>
    <div class="container">
      <h1>Edit Book Info</h1>
      <form action="update_form.php?id=<?= htmlspecialchars($_GET['id']) ?>" method="post">
        <fieldset>
          <div class="contents">
            <label for="id">ID: </label>
            <input type="text" name="id" value="<?= htmlspecialchars(isset($_POST['id']) ? $_POST['id'] : $user['id']) ?>" readonly>
          </div>
          <!-- title -->
          <div class="contents">
            <label for="title">Title: </label>
            <input type="text" name="title" value="<?= htmlspecialchars(isset($_POST['title']) ? $_POST['title'] : $user['title']) ?>">
          </div>
          <!-- publisher -->
          <div class="contents">
            <label for="publisher">Publisher: </label>
            <input type="text" name="publisher" value="<?= htmlspecialchars(isset($_POST['publisher']) ? $_POST['publisher'] : $user['publisher']) ?>">
          </div>
          <!-- author -->
          <div class="contents">
            <label for="author">Author: </label>
            <input type="text" name="author" value="<?= htmlspecialchars(isset($_POST['author']) ? $_POST['author'] : $user['author']) ?>">
          </div>
          <!-- edition -->
          <div class="contents">
            <label for="edition">Edition: </label>
            <input type="text" name="edition" value="<?= htmlspecialchars(isset($_POST['edition']) ? $_POST['edition'] : $user['edition']) ?>">
          </div>
          <!-- no_of_pages -->
          <div class="contents">
            <label for="pages">No_Of_Pages: </label>
            <input type="text" name="pages" value="<?= htmlspecialchars(isset($_POST['pages']) ? $_POST['pages'] : $user['pages']) ?>">
          </div>
          <!-- price -->
          <div class="contents">
            <label for="price">Price: </label>
            <input type="text" name="price" value="<?= htmlspecialchars(isset($_POST['price']) ? $_POST['price'] : $user['price']) ?>">
          </div>
          <!-- publish date -->
          <div class="contents">
            <label for="date">Publish Date: </label>
            <input type="date" name="date" value="<?= htmlspecialchars(isset($_POST['date']) ? $_POST['date'] : $user['publish_date']) ?>">
          </div>
          <!-- isbn -->
          <div class="contents">
            <label for="isbn">ISBN: </label>
            <input type="text" name="isbn" value="<?= htmlspecialchars(isset($_POST['isbn']) ? $_POST['isbn'] : $user['isbn']) ?>">
          </div>
          <div class="button">
            <input type="submit" name="submit" >
          </div>
        </fieldset>
      </form>

      <div class="<?php echo $class; ?>"><?php echo $message;?></div>
    </div>
  </body>
</html>
