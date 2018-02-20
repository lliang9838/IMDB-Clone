<!DOCTYPE html>
<html>
<head>
<title> Add a Movie Review </title>
</head>

<body>
  <h1> Adding a Movie Review </h1>
  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" >
    <fieldset>
      <?php
        //Establishing connection
        $db_connection = mysql_connect("localhost", "cs143", "");
        if (!$db_connection)
            die("Error while establishing a connection to host: " . mysql_error());

        //Selecting database
        $db_selected = mysql_select_db("CS143", $db_connection);
        if (!$db_selected)
            die("Error while selecting a database: " . mysql_error());

        //Issuing query
        $movie_query = "SELECT * FROM Movie ORDER BY title;";
        $result = mysql_query($movie_query, $db_connection);
        if (!$result)
          die("Error issuing query: " . mysql_error());

        //Populate the movie drop down menu
        echo "<label>  Movie:  </label>";
        echo "<select name='movie' required>";
        if (mysql_num_rows($result) > 0){
      		while ($row = mysql_fetch_array($result)){
            $mid = $row[0];
            $title = $row[1];
            $year = $row[2];

            echo "<option value=\"$mid\">";
            echo "$title ($year)";
            echo "</option>";
            echo "\n";
          }
      		mysql_free_result($result);
        }

        echo "</select>";
        echo "<br>";
        mysql_close($db_connection);
       ?>
      <br>
      <label>   Name:     </label>
      <input type="text" name="name" SIZE=20 MAXLENGTH=30 value="Anonymous" required>
      <br><br>

      <label> Rating: </label>
      <select name="rating" required>
          <option value = "5"> 5-Oscar worthy</option>
          <option value = "4"> 4-Great</option>
          <option value = "3"> 3-Okay </option>
          <option value = "2"> 2-Mediocre</option>
          <option value = "1"> 1-God awful</option>
      </select><br><br>

      <label> Additional Comments: </label><br><br>
      <textarea name="comment" rows="10" cols="60" required></textarea><br>

      <input type="submit" name="final" value="ADD!" />
    </fieldset>
  </form>

	<?php
    if ( isset($_POST['final'])){
      //Establishing connection
      $db_connection = mysql_connect("localhost", "cs143", "");
      if (!$db_connection)
          die("Error while establishing a connection to host: " . mysql_error());

      //Selecting database
      $db_selected = mysql_select_db("CS143", $db_connection);
      if (!$db_selected)
          die("Error while selecting a database: " . mysql_error());

      //Parse input data
      $mid = $_POST["movie"];
      $name = $_POST["name"];
      $rating = $_POST["rating"];
      $comment = $_POST["comment"];

      $name = "'" . mysql_real_escape_string($name) . "'"; //putting quotes around name
      $comment = "'" . mysql_real_escape_string($comment) . "'"; //putting quotes around comment

      //Use the now() function to store the timestamp
      //Issuing query
      $query = "INSERT INTO Review VALUES($name, now(), $mid, $rating, $comment)";
      if (!$result = mysql_query($query, $db_connection))
        die("Error while issuing a query: " . mysql_error());

      //Check if database was sucessfully updated
      if ( mysql_affected_rows($db_connection) != -1)
        echo "<br>Sucessfully added a review. Thank you!<br>";
    }
    mysql_close($db_connection);
  ?>
</body>
</html>
