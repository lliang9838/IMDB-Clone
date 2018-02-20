<!DOCTYPE html>
<html>
<head>
<title> Add Actor and Movie Relationship </title>
</head>
<body>
<h1> Adding Actor and Movie Relationship </h1>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" >
  <table width="300" cellspacing="20">
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

          //Populate the movie drop down menu
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
      <td> Actor: </td>
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
          $actor_query = "SELECT *
                          FROM Actor
                          ORDER BY first;";
          $result = mysql_query($actor_query, $db_connection);
          if (!$result)
              die("Error issuing query: " . mysql_error());

          //Populate the actor drop down menu
          echo "<select name='actor' required>";
          if (mysql_num_rows($result) > 0){
            while ($row = mysql_fetch_array($result)){
              $aid = $row[0];
              $last = $row[1];
              $first = $row[2];
              $dob = $row[4];

              echo "<option value=\"$aid\">";
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
      <td> Role: </td>
      <td>
        <input type="text" name="role" size="25" maxlength="30" required >
      </td>
    </tr>
    <tr>
      <td>
        <input type="submit" name="final" value="ADD!" />
      </td>
    </tr>
  </table>
</form><hr>

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
      $aid = $_POST["actor"];
      $role = $_POST["role"];

      $mid = "'" . mysql_real_escape_string($mid) . "'"; //putting quotes around mid
      $aid = "'" . mysql_real_escape_string($aid) . "'"; //putting quotes around aid
      $role = "'" . mysql_real_escape_string($role) . "'"; //putting quotes around mid

      $query = "INSERT INTO MovieActor VALUES($mid, $aid, $role)";

      //Issuing query
      if (!$result = mysql_query($query, $db_connection))
        die("Error while issuing a query: " . mysql_error());

      //Check if database was sucessfully updated
      if ( mysql_affected_rows($db_connection) != -1)
        echo "<br>Sucessfully added a MovieActor relation. Thank you!<br>";
    }
    mysql_close($db_connection);
  ?>

</body>
</html>
