<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Project 1b</title>
  </head>
  <body>
    <?php //Search for Movie title
      $query = "SELECT title
                FROM Movie
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
      $title = current($row);
      echo "<h1>" . $title . "</h1>";
    ?>
    <table cellspacing=10>
      <tr>
        <td>
          <?php //Search for Movie info
            $query = "SELECT title, year, rating, company
                      FROM Movie
                      WHERE id =" . $_GET['id'] .
                      " ORDER BY title;";

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

            // Parse movie info
            $row = mysql_fetch_row($rs);
            $title = current($row);
            next($row);
            $year = current($row);
            next($row);
            $rating = current($row);
            next($row);
            $company = current($row);

            //Create other queries
            $director_query = "SELECT first, last
                           FROM MovieDirector
                           JOIN Director
                           ON MovieDirector.did=Director.id
                           WHERE mid=" . $_GET['id'];

            $genre_query = "SELECT genre
                            FROM MovieGenre
                            WHERE mid=" . $_GET['id'];

            //Issuing directory_query
            $rs = mysql_query($director_query, $db_connection);
            if (!$rs)
                die("Error issuing director_query: " . mysql_error());

            //Check if any results were found from search
            if (mysql_num_rows($rs) == 0)
                $director_name = "N/A";
            else{
              $row = mysql_fetch_row($rs);
              $director_name = $row[0] . " " . $row[1];
            }

            //Issuing genre queries
            $rs = mysql_query($genre_query, $db_connection);
            if (!$rs)
                die("Error issuing genre_query: " . mysql_error());

            //Check if any results were found from search
            $genre_name = "";
            $counter = 0;
            if (mysql_num_rows($rs) == 0)
                $genre_name = "N/A";
            else{
              while($row = mysql_fetch_row($rs)){
                if($counter == 0)
                  $genre_name = $row[0];
                else
                  $genre_name = $genre_name . ", " . $row[0];
                $counter = $counter + 1;
              }
            }

            //Display movie info
            echo "<font size=4><b><u>Movie Info:</u></b></font><br>";
            echo '<table cellspacing="10">';
            echo "<tr><td>Release Year: </td><td>" . $year . "</td></tr>";
            echo "<tr><td>MPAA Rating: </td><td>" . $rating . "</td></tr>";
            echo "<tr><td>Genre: </td><td>" . $genre_name . "</td></tr>";
            echo "<tr><td>Director: </td><td>" . $director_name . "</td></tr>";
            echo "<tr><td>Production company: </td><td>" . $company . "</td></tr>";
            echo "</table>";

            //Closing connection
            if (!mysql_close($db_connection))
                die("Error while closing connection: " . mysql_error());
           ?>
        </td>
        <td valign=top>
          <font size=4><b><u>Reviews</u></b></font>
          <?php //Search for Ratings
            $query = "SELECT avg(rating)
                      FROM Review
                      WHERE mid =" . $_GET['id'];

            $other_rating = "SELECT imdb, rot
                             FROM MovieRating
                             WHERE mid =" . $_GET['id'];

            //Establishing connection
            $db_connection = mysql_connect("localhost", "cs143", "");
            if (!$db_connection)
                die("Error while establishing a connection to host: " . mysql_error());

            //Selecting database
            $db_selected = mysql_select_db("CS143", $db_connection);
            if (!$db_selected)
                die("Error while selecting a database: " . mysql_error());

            //Issuing avg review query
            $rs = mysql_query($query, $db_connection);
            if (!$rs)
                die("Error issuing query: " . mysql_error());

            $row = mysql_fetch_row($rs);
            $rating = current($row);

            //Issuing other ratings queries
            $rs = mysql_query($other_rating, $db_connection);
            if (!$rs)
                die("Error issuing query: " . mysql_error());


            $row = mysql_fetch_row($rs);
            $imdb = $row[0];
            $rot = $row[1];

            //Display the ratings
            echo '<table cellspacing=10>';
            echo '<tr><td>IMDb Rating: </td><td>';
            if(!$imdb)
              echo "N/A</td></tr>";
            else
              echo  $imdb . "</td></tr>";

            echo '<tr><td>Rotten Tomatoes Rating: </td><td>';
            if(!$rot)
              echo "N/A</td></tr>";
            else
              echo $rot . "</td></tr>";

            echo '<tr><td>Average User Rating:</td><td>';
            if(!$rating)
              echo "N/A</td></tr>";
            else{
              echo number_format($rating, 2) . "</td></tr>";
              echo '<tr><td><a href="add_m_review.php">Click here</a> to add your own review!</td></tr>';
            }
            echo '</table>';
           ?>
        </td>
      </tr>
      <tr>
        <td valign=top>
          <?php //Search for Movie cast
            $query = "SELECT first, last, role, aid
                      FROM  MovieActor
                      JOIN  Actor ON MovieActor.aid = Actor.id
                      WHERE mid =" . $_GET['id'] .
                      " ORDER BY first;";

            // echo "Query is: " . $query . "<br>";
            echo "<br><font size=4><b><u>Movie Cast:</u></b></font><br>";
            //Create table
            echo '<table cellspacing="10">';


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
                echo "<tr><td>No results were found</td></tr>";
            else{
              echo '<tr><td style="padding-left: 40px"><b>Actor</b></td>';
              echo '<td style="padding-left: 40px"><b>Role</b></td></tr>';

              //Display Movie and Role info
              while($row = mysql_fetch_row($rs)){

                //Parse Movie and Role info
                $name = current($row);
                next($row);
                $name = $name . " " . current($row);
                next($row);
                $role = current($row);
                next($row);
                $id = current($row);

                echo '<tr><td><a href="a_info.php?id=' . $id . '">' . $name . "</td>";
                echo "<td>" . $role . "</td></tr>";
              }
            }
            echo "</table>";

            //Closing connection
            if (!mysql_close($db_connection))
                die("Error while closing connection: " . mysql_error());
           ?>
        </td>
        <td valign=top>
          <font size=4><b><u><br>Other User Comments<br></u></b></font>
          <?php //Search for User Reviews
            $query = "SELECT name, time, rating, comment
                      FROM Review
                      WHERE mid =" . $_GET['id'] .
                      " ORDER BY time DESC;";

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
            if (mysql_num_rows($rs) == 0){
              echo '<table cellspacing=10><tr><td>There are currently no user reviews.</td></tr>';
              echo '<tr><td><a href="add_m_review.php">Be the first to leave a review</a>!</td></tr></table>';
            }

            //Display reviews
            echo "<table cellspacing=10>";
            while($row = mysql_fetch_row($rs)){
              $name = $row[0];
              $time = $row[1];
              $rating = $row[2];
              $comment = '"' . $row[3] . '"';

              echo "<tr><td><b>" . $name . "</b> rated <b>" . $rating . "/5</b> on <b>" . $time . "</b></td></tr>";
              echo '<tr><td style="padding: 0px 0px 0px 30px;">' . $comment . "</td></tr><tr></tr>";
            }
            echo "</table>";

           ?>
        </td>
      </tr>
    </table>
  </body>
</html>
