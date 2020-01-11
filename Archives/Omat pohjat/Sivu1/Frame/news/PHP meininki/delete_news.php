      <?php
      if (isset($_GET['id'])) {
      include('mysql_connect.php');
      if (is_numeric($_GET['id'])) {
      $id = $_GET['id'];

      $query = "DELETE FROM news_posts WHERE id = $id";
      $result = mysql_query($query);

      if ($result) {
      echo '<h3>Success!</h3><br />
      The news item was deleted succesfully.<br /><br />
      <b>Options :</b><br />
      Delete or Edit another news item : <a href="news_manage.php">[X]</a><br />
      Add a new news item : <a href="addnews.php">[X]</a><br />';
      } else {
      echo 'We are sorry to inform you but the news item you chose to delete could not be deleted. Please feel free to try again';
      }
      } else {
      echo 'Invalid news item, please choose a news item.';
      }
      } else {
      echo 'Before visiting this page please choose a news item to delete first!';
      }
      ?>

