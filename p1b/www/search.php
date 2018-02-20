<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>

  <body>
    <h1>Search Results:</h1>

    <?php // Error message if neither box is checked
      if(!$_POST['actor'] && !$_POST['movie'])
        echo "Please make sure you have at least one of the boxes checked";
     ?>

    <table width="600" cellspacing="20"><tr>

    <?php // Display Actors if checked
      if($_POST['actor']){
        echo '<td valign="top">';
        echo nl2br("<font size='4'><b>Matching Actors:</b></font>\n");

        //Parse the input
        $input = $_POST['query'];
        $arr = explode(" ", $input);
        $query = "SELECT first, last, id
                  FROM Actor
                  WHERE (first LIKE '%$arr[0]%'
                  OR last LIKE '%$arr[0]%')";
        for($i = 1, $size = count($arr); $i < $size; $i++) {
          $query = $query . " AND " .
                    "(first LIKE '%$arr[$i]%'
                    OR last LIKE '%$arr[$i]%')";
        }
        $query = $query . "ORDER BY first";

        /*** Print results ***/

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

        // Check if any results were found from search
        if (mysql_num_rows($rs) == 0)
            echo "No results were found<br>";

        //Create table
        echo "<table border=0 cellpadding=2 cellspacing=5>";

        //Print values row by row
        while($row = mysql_fetch_row($rs)){
            echo "<tr><td>";
            $num_elems = count($row);

            // Parse the info
            $first=current($row);
            next($row);
            $last=current($row);
            next($row);
            $id=current($row);

            // Create html link with php data
            $link = '<a href="a_info.php' . '?id=' . $id . '", target="main">' . $first . " " . $last;
            echo $link;

            echo "</td></tr>";
        }
        echo "</table>";

        //Closing connection
        if (!mysql_close($db_connection))
            die("Error while closing connection: " . mysql_error());

        // Otherwise display "No results were found"
        echo nl2br("\n\n");
        echo "</td>";
      }
     ?>

    <?php // Display Movies if checked
      if($_POST['movie']){
        echo '<td valign="top">';
        echo nl2br("<font size='4'><b>Matching Movies:</b></font>\n");

        //Parse the input
        $input = $_POST['query'];
        $arr = explode(" ", $input);
        $query = "SELECT title, id
                  FROM Movie
                  WHERE title LIKE '%$arr[0]%'";
        for($i = 1, $size = count($arr); $i < $size; $i++) {
          $query = $query . " AND " .
                    "title LIKE '%$arr[$i]%'";
        }
        $query = $query . "ORDER BY title";

        //Create table
        echo "<table border=0 cellpadding=2 cellspacing=5>";

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

        // Check if any results were found from search
        if (mysql_num_rows($rs) == 0)
          echo "<tr><td>No results were found</td></tr>";

        //Print values row by row
        while($row = mysql_fetch_row($rs)){
            echo "<tr><td>";
            $num_elems = count($row);

            // Parse the info
            $title=current($row);
            next($row);
            $id=current($row);

            // Create html link with php data
            $link = '<a href="m_info.php' . '?id=' . $id . '", target="main">' . $title;
            echo $link;

            echo "</td></tr>";
        }
        echo "</table>";

        //Closing connection
        if (!mysql_close($db_connection))
            die("Error while closing connection: " . mysql_error());

        // Otherwise display "No results were found"
        echo nl2br("\n\n");
        echo "</td>";
      }
    ?>
  </body>
</html>
