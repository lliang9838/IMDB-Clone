<!DOCTYPE html>
<html>
<head>
<title> Add Director and Movie Relationship </title>
</head>
<body>
  <h1> Adding Director and Movie Relationship </h1>

  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" >
    <table  width="300" cellspacing="20">
      <tr>
        <td> Movie: </td>
        <td>
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
            $movie_query = "SELECT *
                            FROM Movie
                            ORDER BY title;";
            $result = mysql_query($movie_query, $db_connection);
            if (!$result)
                die("Error issuing query: " . mysql_error());

            //Populate movie drop down menu
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
        </td>
      </tr>
      <tr>
        <td> Director: </td>
        <td>
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
            $director_query = "SELECT *
                               FROM Director
                               ORDER BY first;";
            $result = mysql_query($director_query, $db_connection);
            if (!$result)
                die("Error issuing query: " . mysql_error());

            //Populate the director drop down menu
            echo "<select name='director' required>";
            if (mysql_num_rows($result) > 0){
              while ($row = mysql_fetch_array($result)){
                $did = $row[0];
                $last = $row[1];
                $first = $row[2];
                $dob = $row[3];

                echo "<option value=\"$did\">";
                echo $first . " " . $last . " ($dob)";
                echo "</option>";
                echo "\n";
              }
              mysql_free_result($result);
            }

            echo "</select>";
            echo "<br>";
            mysql_close($db_connection);
          ?>
        </td>
      </tr>
      <tr>
        <td>
          <input type="submit" name="final" value="ADD!" />
        </td>
      </tr>
    </table>
  </form><hr><br>

<?php
  //php to store my values and to access them
  if (isset($_POST['final'])){
    //Establishing connection
    $db_connection = mysql_connect("localhost", "cs143", "");
    if (!$db_connection)
        die("Error while establishing a connection to host: " . mysql_error());

    //Selecting database
    $db_selected = mysql_select_db("CS143", $db_connection);
    if (!$db_selected)
        die("Error while selecting a database: " . mysql_error());

    //Parse input for query
    $mid = $_POST["movie"];
    $did = $_POST["director"];

    $mid = "'" . mysql_real_escape_string($mid) . "'"; //putting quotes around mid
    $did = "'" . mysql_real_escape_string($did) . "'"; //putting quotes around did

    //Issuing query
    $query = "INSERT INTO MovieDirector VALUES($mid, $did)";
    if (!$result = mysql_query($query, $db_connection))
      die("Error while issuing a query: " . mysql_error());

    //Check if database was sucessfully updated
    if ( mysql_affected_rows($db_connection) != -1)
      echo "<br>Sucessfully added a MovieDirector relation. Thank you!<br>";
  }
  mysql_close($db_connection);
?>

</body>
</html>
