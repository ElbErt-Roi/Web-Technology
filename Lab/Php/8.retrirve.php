<?php
  $conn = new mysqli("localhost", "root", "", "project");

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $info = [];
  $sql = "SELECT * FROM books"; // ✅ Corrected query
  $result = mysqli_query($conn, $sql);

  if (!$result) {
    printf("Error: %s\n", mysqli_error($conn));
    exit();
  }

  // ✅ Fetch results as associative array
  while ($row = mysqli_fetch_assoc($result)) {
    $info[] = $row;
  }

  mysqli_close($conn);
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Book Info</title>
    <style>
      *{margin: 0; padding: 0;}
      h1{margin-top: 20px;}
      .container{
        display:flex;
        flex-direction: column;
        align-items: center;
        gap: 20px;
      }
      table {
        border-collapse: collapse;
        width: 90%;
      }
      th, td {
        border: 1px solid black;
        padding: 10px;
        text-align: center;
      }
      th {
        background-color: #f2f2f2;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <h1>Book Information</h1>
      <table>
        <tr>
          <th>ID</th>
          <th>Title</th>
          <th>Publisher</th>
          <th>Author</th>
          <th>Edition</th>
          <th>No of Pages</th>
          <th>Price</th>
          <th>Publish Date</th>
          <th>ISBN</th>
        </tr>
        <?php foreach($info as $val) { ?>
        <tr>
          <td><?php echo $val['id']; ?></td>
          <td><?php echo $val['title']; ?></td>
          <td><?php echo $val['publisher']; ?></td>
          <td><?php echo $val['author']; ?></td>
          <td><?php echo $val['edition']; ?></td>
          <td><?php echo $val['pages']; ?></td>
          <td><?php echo $val['price']; ?></td>
          <td><?php echo $val['publish_date']; ?></td>
          <td><?php echo $val['isbn']; ?></td>
        </tr>
        <?php } ?>
      </table>
    </div>
  </body>
</html>
