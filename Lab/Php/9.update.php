<?php
$conn = new mysqli("localhost", "root", "", "project");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$info = [];
$sql = "SELECT * FROM books";
$result = $conn->query($sql);

if (!$result) {
  die("Error: " . $conn->error);
}

while ($row = $result->fetch_assoc()) {
  $info[] = $row;
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Update Books Info</title>
  <style>
    .container{
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 20px;
      }
      table{width: 90%;}
      table,tr,th,td{
        border-collapse: collapse;
        border: 1px solid black;
        padding: 20px;
      }
      th{
        background-color:rgb(215, 215, 215);
      }
  </style>
</head>
<body>
  <div class="container">
    <h1>Update Books Info</h1>
    <table>
      <tr>
        <th>ID</th><th>Title</th><th>Publisher</th><th>Author</th><th>Edition</th>
        <th>No of Pages</th><th>Price</th><th>Publish Date</th><th>ISBN</th><th>Update</th>
      </tr>
      <?php foreach ($info as $val){ ?>
        <tr>
          <td><?= htmlspecialchars($val['id']) ?></td>
          <td><?= htmlspecialchars($val['title']) ?></td>
          <td><?= htmlspecialchars($val['publisher']) ?></td>
          <td><?= htmlspecialchars($val['author']) ?></td>
          <td><?= htmlspecialchars($val['edition']) ?></td>
          <td><?= htmlspecialchars($val['pages']) ?></td>
          <td><?= htmlspecialchars($val['price']) ?></td>
          <td><?= htmlspecialchars($val['publish_date']) ?></td>
          <td><?= htmlspecialchars($val['isbn']) ?></td>
          <td><a href="9.update_frm.php?id=<?= urlencode($val['id']) ?>">Update</a></td>
        </tr>
      <?php } ?>
    </table>
  </div>
</body>
</html>
