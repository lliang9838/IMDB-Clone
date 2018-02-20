<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Project 1b</title>
  </head>
  <body>
    <?php //Search for Movie title
      $query = "SELECT first, last
                FROM Actor
                WHERE id =" . $_GET['id'];

      //Establishing connection
      $db_connection = mysql_connect("localhost", "cs143", "");
      if (!$db_connection)
          die("Error while establishing a connection to host: " . mysql_error());

      //Selecting database
      $db_selected = mysql_select_db("CS143", $db_connection);
      if (!$db_selected)
          die("Error while selecting a database: " . mysql_error());

      //Issuing queries
      $rs = mysql_query($query, $db_connection);
      if (!$rs)
          die("Error issuing query: " . mysql_error());

      //Check if any results were found from search
      if (mysql_num_rows($rs) == 0)
          die("No results were found");

      $row = mysql_fetch_row($rs);
      $name = $row[0] . " " . $row[1];
      echo "<h1>" . $name . "</h1>";
     ?>
    <table cellspacing=10>
      <tr>
        <td>
          <?php //Search for Actor's personal info
            $query = "SELECT first, sex, dob, dod
                      FROM Actor
                      WHERE id =" . $_GET['id'] .
                      " ORDER BY first;";

            //Establishing connection
            $db_connection = mysql_connect("localhost", "cs143", "");
            if (!$db_connection)
                die("Error while establishing a connection to host: " . mysql_error());

            //Selecting database
            $db_selected = mysql_select_db("CS143", $db_connection);
            if (!$db_selected)
                die("Error while selecting a database: " . mysql_error());

            //Issuing queries
            $rs = mysql_query($query, $db_connection);
            if (!$rs)
                die("Error issuing query: " . mysql_error());

            //Check if any results were found from search
            if (mysql_num_rows($rs) == 0)
                die("No results were found");

            // Parse personal info
            $row = mysql_fetch_row($rs);
            $sex = $row[1];
            $dob = $row[2];
            if(!($dod = $row[3]))
              $dod = "N/A";
            else
              $dod = $row[3];

            //Display personal info
            echo "<font size=4><b><u>Personal Info:</u></b></font><br>";
            echo '<table cellspacing="10">';
            echo "<tr><td>Sex: </td><td>" . $sex . "</td></tr>";
            echo "<tr><td>Date of birth: </td><td>" . $dob . "</td></tr>";
            echo "<tr><td>Date of death: </td><td>" . $dod . "</td></tr>";
            echo "</table>";

            //Closing connection
            if (!mysql_close($db_connection))
                die("Error while closing connection: " . mysql_error());
           ?>
        </td>
      </tr>
      <tr>
        <td>
          <?php //Search for Movies associated with Actor/Director
              $query = "SELECT role, title, mid
                        FROM  MovieActor
                        JOIN  Movie ON MovieActor.mid = Movie.id
                        WHERE aid =" . $_GET['id'] . ";";

              // echo "Query is: " . $query . "<br>";
              echo "<br><font size=4><b><u>Movie Roles:</u></b></font><br>";

              //Establishing connection
              $db_connection = mysql_connect("localhost", "cs143", "");
              if (!$db_connection)
                  die("Error while establishing a connection to host: " . mysql_error());

              //Selecting database
              $db_selected = mysql_select_db("CS143", $db_connection);
              if (!$db_selected)
                  die("Error while selecting a database: " . mysql_error());

              //Issuing queries
              $rs = mysql_query($query, $db_connection);
              if (!$rs)
                  die("Error issuing query: " . mysql_error());

              //Check if any results were found from search
              if (mysql_num_rows($rs) == 0)
                  die("<p>No results were found</p>");

              //Create table
              echo '<table cellspacing="10">';
              echo '<tr><td style="padding-left: 40px"><b>Movie</b></td>';
              echo '<td style="padding-left: 40px"><b>Role</b></td></tr>';

              //Display Movie and Role info
              while($row = mysql_fetch_row($rs)){

                  //Parse Movie and Role info
                  $role=current($row);
                  next($row);
                  $title=current($row);
                  next($row);
                  $id=current($row);

                  echo '<tr><td><a href="m_info.php?id=' . $id . '">' . $title . "</td>";
                  echo "<td>" . $role . "</td></tr>";
              }
              echo "</table>";

              //Closing connection
              if (!mysql_close($db_connection))
                  die("Error while closing connection: " . mysql_error());
           ?>
        </td>
      </tr>
    </table>
  </body>
</html>
