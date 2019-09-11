      <?php
      if (isset($_POST['submitted'])) {
      include ('mysql_connect.php');
      if (empty($_POST['title'])) {
      echo '<p><font color="red">You need to enter a title.</font></p>';
      } else {
      $title = $_POST['title'];
      }
      
      if (empty($_POST['name'])) {
      echo '<p><font color="red">You need to enter a name.</font></p>';
      } else {
      $name = $_POST['name'];
      }
       
      if (empty($_POST['message'])) {
      echo '<p><font color="red">You need to enter a message.</font></p>';
      } else {
      $message = $_POST['message'];
      }
       
      if ($title && $name && $message) {
      $query = "INSERT INTO news_posts (title, author, post, date) VALUES ('$title', '$name', '$message', NOW())";
      $result = @mysql_query($query);
       
      if ($result) {
      echo '<p><font color="red">News was added!</font></p>';
      } else {
      echo '<font color="red"><p>News could not be added! Please try again.</p></font>';
      }
      } else {
      echo '<p><font color="red">Please fill in the appropriate information</font></p>';
      }
      }
      ?>

      <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
      <p><b>News Title :</b><br />
      <input type="input" name="title" size="25" maxlength="60" value="<?php if(isset($_POST['title'])) echo $_POST['title']; ?>" /></p>

      <p><b>Name :</b><br />
      <input type="input" name="name" size="15" maxlength="35" value="<?php if(isset($_POST['name'])) echo $_POST['name']; ?>" /></p>

      <p><b>Message :</b><br />

      <textarea rows="7" cols="55" name="message"><?php if(isset($_POST['message'])) echo $_POST['message']; ?></textarea></p>

      <p><input type="submit" name="submit" value="Add News" /></p>
      <input type="hidden" name="submitted" value="TRUE" /></p>
      </form>

