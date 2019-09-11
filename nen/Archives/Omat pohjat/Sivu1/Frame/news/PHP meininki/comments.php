      <?php
      include ('mysql_connect.php');

      if (isset($_GET['id'])) {
      $id = $_GET['id'];
      } else {
      echo 'Please select a news post to view the comments.';
      exit();
      }
      $query = "SELECT * FROM comments WHERE nid = $id";
      $result = @mysql_query($query);
       
      while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
      echo '<b>'.$row['title'].'</b>
      <b>Author : </b>'.$row['author'].'<br />
      <b>Comment : </b>'.$row['comment'].'<br />
      <hr width="80%" />';
      }

      if (isset($_POST['submitted'])) {

      $errors = array();
      if (empty($_POST['title'])) {
      $errors[] = '<font color="red">Please enter in a title.</font>';
      } else {
      $title = $_POST['title'];
      }

      if (empty($_POST['author'])) {
      $errors[] = '<font color="red">Please enter in your name.</font>';
      } else {
      $author = $_POST['author'];
      }

      if (empty($_POST['comment'])) {
      $errors[] = '<font color="red">Please enter in a comment.</font>';
      } else {
      $comment = $_POST['comment'];
      }

      if (empty($errors)) {
      $query = "INSERT INTO comments (nid, title, author, comment, date) VALUES ($id, '$title', '$author', '$comment', NOW())";
      $result = @mysql_query($query);

      if ($result) {
      echo '<font color="blue">Your comment was added succesfully!</font>';
      } else {
      echo '<font color="red">There was an error when submitting your comment, please try again.</font>';
      }
      } else {
      echo '<b>There were a couple of errors -</b><br />';
      foreach ($errors as $msg) {
      echo " - $msg<br />\n";
      }
      }
      } else {
      ?>
      <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" />
      <p>Comment Title : <input type="text" name="title" maxlength="70" value="<?php if(isset($_POST['title'])) echo $_POST['author'];?>" /></p>

      <p>Your Name : <input type="text" name="author" length="25" maxlength="50" value="<?php if(isset($_POST['author'])) echo $_POST['author'];?>" /></p>

      <p>Comment : <textarea columns="6" rows="6" name="comment"><?php if(isset($_POST['comment'])) echo $_POST['comment'];?></textarea></p>

      <p><div align="center"><input type="submit" name="submit" value="Submit Comment" /></div></p>
      <input type="hidden" name="submitted" value="TRUE" />
      </form>
      <?php
      }
      ?>
      <div align="center"><a href="javascript:window.close()">Close this window</a></div>

