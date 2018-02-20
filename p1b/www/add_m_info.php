<!DOCTYPE html>
<html>
<head>
<title> Add Movie </title>
</head>

<body>
<h1> Adding Movie </h1>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" >
  <fieldset>
    <legend> Required Movie Information </legend>
        <p>
          <label> Movie name: </label>
          <input type = "text" name="movie" size=20 maxlength=100 required>
        </p>
        <p>
          <label> Company: </label>
          <input type = "text" name="company" size=20 maxlength="25"required>
        </p>
        <p>
          <label> Year: </label>
          <input type="text" name="year" size=5 maxlength=8 required>
        </p>
        <p>
          <label> Director: </label>
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
            $director_query = "SELECT first, last, dob, id
                               FROM Director
                               ORDER BY first;";
            $result = mysql_query($director_query, $db_connection);
            if (!$result)
              die("Error issuing query: " . mysql_error());

            //Populate the movie drop down menu
            echo "<select name='director' required>";
            if (mysql_num_rows($result) > 0){
          		while ($row = mysql_fetch_array($result)){
                $name = $row[0] . " " . $row[1];
                $dob = $row[2];
                $did = $row[3];

                echo "<option value=\"$did\">";
                echo "$name ($dob)";
                echo "</option>";
                echo "\n";
              }
          		mysql_free_result($result);
            }

            echo "</select>";
            echo "<br>";
            mysql_close($db_connection);
           ?>
        </p>
        <p>
          Director not found?
          <a href="add_ad_info.php">Click here</a> to add it to the list!
        </p>
        <p>
          <label> Genre: </label>
          <input type="checkbox" name="Action" value="Action"> Action </input>
          <input type="checkbox" name="Adult" value="Adult"> Adult </input>
          <input type="checkbox" name="Adventure" value="Adventure"> Adventure </input>
          <input type="checkbox" name="Animation" value="Animation"> Animation </input>
          <input type="checkbox" name="Comedy" value="Comedy"> Comedy </input>
          <input type="checkbox" name="Crime" value="Crime"> Crime </input>
          <input type="checkbox" name="Documentary" value="Documentary"> Documentary </input>
          <input type="checkbox" name="Drama" value="Drama"> Drama </input>
          <input type="checkbox" name="Family" value="Family"> Family </input>
          <input type="checkbox" name="Fantasy" value="Fantasy"> Fantasy </input>
          <input type="checkbox" name="Horror" value="Horror"> Horror </input>
          <input type="checkbox" name="Musical" value="Musical"> Musical </input>
          <input type="checkbox" name="Mystery" value="Mystery"> Mystery </input>
          <input type="checkbox" name="Romance" value="Romance"> Romance </input>
          <input type="checkbox" name="Sci-Fi" value="Sci-Fi"> Sci-Fi </input>
          <input type="checkbox" name="Short" value="Short"> Short </input>
          <input type="checkbox" name="Thriller" value="Thriller"> Thriller </input>
          <input type="checkbox" name="War" value="War"> War </input>
          <input type="checkbox" name="Western" value="Western"> Western </input>
        </p>
        <p>
          <label> MPAA Rating: </label>
          <select name="rating" required>
              <option value="G"> G </option>
              <option value="NC-17"> NC-17 </option>
              <option value="PG"> PG </option>
              <option value="PG-13"> PG-13 </option>
              <option value="R"> R </option>
              <option value="surrendere"> surrendere </option>
          </select><br>
        </p>
    </fieldset>
  <br><input type="submit" name="final" value="ADD!" />
</form><br><hr>

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
    $genre = $genres[$i];
    //echo "Genre is " . $genre;
    $movie = $_POST["movie"];
    $company = $_POST["company"];
    $year = $_POST["year"];
    $rating = $_POST["rating"];
    $did = $_POST['director'];

    //Issuing query to get MaxMovieID
    $query = "SELECT id FROM MaxMovieID";
    $rs = mysql_query($query, $db_connection);
    $id = 0;
    while($row = mysql_fetch_row($rs)){
      $id = $row[0] + 1;                  //new id will be MaxMovieID+1
      mysql_free_result($rs);
    }

    //Append quotes onto strings
    $movie = "'" . mysql_real_escape_string($movie) . "'";
    $company = "'" . mysql_real_escape_string($company) . "'";
    $rating = "'" . mysql_real_escape_string($rating) . "'";
    $did = "'" . mysql_real_escape_string($did) . "'";

    //Issuing query to add new movie
    $query = "INSERT INTO Movie VALUES($id, $movie, $year, $rating, $company)";
    if (!$result = mysql_query($query, $db_connection))
      die("Error while issuing a query: " . mysql_error());

    //Check if database was sucessfully updated
    if ( mysql_affected_rows($db_connection) != -1)
      echo "Sucessfully added Movie into Movie table<br>";

      //Create array of allowed genres
      $genres = array("Action", "Adult", "Adventure", "Animation", "Comedy", "Crime",
              "Documentary", "Drama", "Family", "Fantasy", "Horror", "Musical",
              "Mystery", "Romance", "Sci-Fi", "Short", "Thriller", "War", "Western");
      $genre = 0;
      $i = 0;
      $flag = 0;

    //Add all selected genres into MovieGenre relationship
    while ( $i < 19 ){
      if ( isset($_POST[$genres[$i]] )){
        $flag = 1;
        $genre = $genres[$i];
        $genre = "'" . mysql_real_escape_string($genre) . "'";

        //Add the new relationship
        $genre_query = "INSERT INTO MovieGenre VALUES($id, $genre)";
        if (!$result = mysql_query($genre_query, $db_connection))
          die("Error while issuing a query: " . mysql_error());
        if ( mysql_affected_rows($db_connection) != -1)
          echo "Sucessfully added Movie & Genre into MovieGenre table<br>";
      }
      $i = $i + 1;
    }

    if ( $flag ==0 )
      die("Error: Please select a genre option.");

    //Issue query to increase MaxMovieID by 1
    $id_query = "UPDATE MaxMovieID SET id = id + 1;";
    if ( !$result = mysql_query($id_query, $db_connection))
      die("Error while updating ID: " . mysql_error());

    //Check if database was succesfullu updated
    if ( mysql_affected_rows($db_connection) != -1)
        echo "Sucessfully incremented MaxMovieID<br>";
    else {
      echo "Was not sucessfuly incrementing MaxMovieID<br>";
    }

    //Issuing query to add MovieDirector relationship
    $md_query = "INSERT INTO MovieDirector VALUES($id, $did)";
    if (!$result = mysql_query($md_query, $db_connection))
      die("Error while issuing a query: " . mysql_error());

    //Check if database was sucessfully updated
    if ( mysql_affected_rows($db_connection) != -1){
      echo "<br>Sucessfully added a MovieDirector relation. Thank you!<br>";
      echo '<a href="add_a2m_relation.php">Click here</a> to add actors/actresses to the movie cast!<br>';
    }
  }
  mysql_close($db_connection);
 ?>

</body>
</html>
