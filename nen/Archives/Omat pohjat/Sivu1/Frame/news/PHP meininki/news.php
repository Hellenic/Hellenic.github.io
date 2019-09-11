      <html>
      <head>
      <script type="text/javascript">
      function openComments(url)
      {
      comments = window.open(url, "Comment", "menubar=0,resizable=0,width=380,height=480")
      comments.focus()
      }
      </script>
      </head>
      
      <body>
      <?php
      include ('mysql_connect.php');
      $query = "SELECT id, title, author, post, DATE_FORMAT(date, '%M %d, %Y') as sd FROM news_posts";
      $result = @mysql_query($query);

      if ($result) {
      while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
      $url = 'comments.php?id='.$row['id'];
      echo '<p><b>'.$row['title'].'</b><br />
      '.$row['sd'].'<br />
      Posted by : <b>'.$row['author'].'</b><br />
      '.$row['post'].'<br />
      <a href="javascript:openComments(\''.$url.'\')">Add new comment or view posted comments</a></p>';
      }
      } else {
      echo 'There are no news posts to display';
      }
      ?>
      </body>
      </html>