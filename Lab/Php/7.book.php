<?php 
  $host = "localhost";
  $user = "root";
  $pass = "";
  $db = "project";
  $conn = new mysqli($host, $user, $pass, $db);

  $message = $class = "";

  if(!$conn){
    die("Connection failed: " . mysqli_connect_error());
  }

  if($_SERVER['REQUEST_METHOD']=='POST'){
    if(isset($_POST['id']) && isset($_POST['title']) && isset($_POST['publisher']) && isset($_POST['author'])
    && isset($_POST['edition']) && isset($_POST['pages']) && isset($_POST['price'])
    && isset($_POST['date']) && isset($_POST['isbn'])){
        if(!empty($_POST['title']) && !empty($_POST['publisher']) && !empty($_POST['author'])
        && !empty($_POST['edition']) && !empty($_POST['pages']) && !empty($_POST['price']) 
        && !empty($_POST['date']) && !empty($_POST['isbn'])){
            $id = $_POST['id'];
            $title = $_POST['title'];
            $publisher = $_POST['publisher'];
            $author = $_POST['author'];
            $edition = $_POST['edition'];
            $pages = $_POST['pages'];
            $price = $_POST['price'];
            $date = $_POST['date'];
            $isbn = $_POST['isbn'];

            if(!is_numeric($pages) || !is_numeric($price)){
              $message = "Pages and Price both must be a number.";
              $class = "fail";
            }else{
              $sql="INSERT INTO books(id,title, publisher, author, edition, pages, price, publish_date, isbn)
              VALUES('$id','$title', '$publisher', '$author', '$edition', '$pages', '$price', '$date', '$isbn')";
              if(mysqli_query($conn, $sql)){
                $message = "Book Added Successfully";
                $class = "success";
              } else {
                $message = "Error Adding Book: " . mysqli_error($conn);
                $class = "fail";
              }
              $conn->close();
            }
        }else{
          $message = "Please enter all fields.";
          $class = "fail";
        }
    }
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Books</title>
    <style>
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
      <h1>Books Registration Form</h1>
      <form action="#" method="post">
        <fieldset>
            <!-- no_of_pages -->
          <div class="contents">
            <label for="id">ID</label>
            <input type="text" name="id" placeholder="Enter Books ID">
          </div>
          <!-- title -->
          <div class="contents">
            <label for="title">Title: </label>
            <input type="text" name="title" placeholder="Enter Title">
          </div>

          <!-- publisher -->
          <div class="contents">
            <label for="publisher">Publisher: </label>
            <input type="text" name="publisher" placeholder="Enter Publisher">
          </div>

          <!-- author -->
          <div class="contents">
            <label for="author">Author: </label>
            <input type="text" name="author" placeholder="Enter Author">
          </div>

          <!-- edition -->
          <div class="contents">
            <label for="edition">Edition: </label>
            <input type="text" name="edition" placeholder="Enter Edition">
          </div>

          <!-- no_of_pages -->
          <div class="contents">
            <label for="pages">No Of Pages: </label>
            <input type="text" name="pages" placeholder="Enter No. of Pages">
          </div>

          <!-- price -->
          <div class="contents">
            <label for="price">Price: </label>
            <input type="text" name="price" placeholder="Enter Price">
          </div>

          <!-- publish date -->
          <div class="contents">
            <label for="date">Publish Date: </label>
            <input type="date" name="date">
          </div>

          <!-- isbn -->
          <div class="contents">
            <label for="isbn">ISBN: </label>
            <input type="text" name="isbn" placeholder="Enter ISBN">
          </div>

          <div class="button">
            <input type="submit" name="submit" placeholder="SUBMIT">
          </div>
        </fieldset>
      </form>
      <div class="<?php echo $class; ?>"><?php echo $message;?></div>
    </div>
  </body>
</html>