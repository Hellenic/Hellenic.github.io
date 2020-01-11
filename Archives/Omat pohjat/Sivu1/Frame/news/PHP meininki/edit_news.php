      <?php
      include('mysql_connect.php');
      if ((isset($_GET['id'])) && (is_numeric($_GET['id'])) ) {
      $id = $_GET['id'];
      } elseif ( (isset($_POST['id'])) && (is_numeric($_POST['id'])) ) {
      $id = $_POST['id'];
      } else {
      echo 'Please choose a news post to edit.';
      exit();
      }
       
      if (isset($_POST['submitted'])) {
      $errors = array();

      if (empty($_POST['title'])) {
      $errors[] = 'You forgot to enter a title.';
      } else {
      $title = $_POST['title'];

      }

      if (empty($_POST['name'])) {
      $errors[] = 'You forgot to enter an author.';
      } else {
      $name = $_POST['name'];
      }

      if (empty($_POST['message'])) {
      $errors[] = 'You forgot to enter a message';
      } else {
      $message = $_POST['message'];
      }

      if (empty($errors)) {
      $query = "UPDATE news_posts SET title='$title', author='$name', post='$message' WHERE id=$id";
      $result = mysql_query($query);

      if ($result) {
      echo "News Post Has Been Updated!";
      } else {
      echo "News post could not be updated.";
      }
      } else {
      echo 'News post could not be updated for the following reasons -<br />';
      foreach ($errors as $msg) {
      echo " - $msg<br />\n";
      }
      }
      } else {
      $query = "SELECT title, author, post, id FROM news_posts WHERE id=$id";
      $result = mysql_query($query);
      $num = mysql_num_rows($result);
      $row = mysql_fetch_array ($result, MYSQL_NUM);

      $title = $row['0'];
      $name = $row['1'];
      $message = $row['2'];

      if ($num == 1) {
      echo '<h3>Edit News Post</h3>
      <form action="?id=edit_news&num='.$id.'" method="post">
      <p>News Title : <input type="text" name="title" size="25" maxlength="255" value="'.$title.'" /></p>
      <p>Name : <input type="text" name="name" size="15" maxlength="255" value="'.$name.'" /></p>
      <p>Message : <br /><textarea rows="5" cols="40" name="message">'.$message.'</textarea></p>
      <p><input type="submit" name="submit" value="Submit" /></p>
      <input type="hidden" name="submitted" value="TRUE" /></p>
      <input type="hidden" name="id" value="'.$id.'" />';
      } else {
      echo 'News post could not be edited, please try again.';
      }
      }
      ?>

