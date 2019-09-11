      <?php
      include('mysql_connect.php');
      $query = "SELECT id, title FROM news_posts";
      $result = @mysql_query($query);

      if ($result) {
      echo '<div align="center">
      <table border="0">
      <tr>
      <td><b>ID</b></td>
      <td><b>Title</b></td>
      <td><b>Delete</b></td>
      <td><b>Edit</b></td>
      </tr>';
       
      while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
      echo '<tr>
      <td>'.$row['id'].'</td>
      <td>'.$row['title'].'</td>
      <td><a href="delete_news.php?id='.$row['id'].'">Delete</a></td>
      <td><a href="edit_news.php?id='.$row['id'].'">Edit
      </tr>';
      }
      } else {
      echo 'Sorry, but we could not retrieve any news item records.';
      }
      ?>

