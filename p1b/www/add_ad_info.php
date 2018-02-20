<!DOCTYPE html>
<html>
<head>
<title> Add Actor and/or Director </title>
</head>

<body>
  <h1> Adding New Actor and/or Director </h1>
  <p>*Required input fields</p>
<form method="POST" action="">
  <table cellspacing="20">
    <tr>
      <td> *Please select one:  </td>
      <td>
        <input type="radio" NAME="radio_ad" value="Actor" checked="true"> Actor
        <input type="radio" NAME="radio_ad" value="Director" align="left"> Director
      </td>
    </tr>
    <tr>
      <td> *First name:</td>
      <td><input type="text" name="first" SIZE=20 MAXLENGTH=20 required></td>
    </tr>
    <tr>
      <td> *Last name:</td>
      <td><input type="text" name="last" SIZE=20 MAXLENGTH=20 required></td>
    </tr>
    <tr>
      <td> *Sex: </td>
      <td>
        <input type="radio" name="radio_sex" value="male" checked="true"> Male
        <input type="radio" name="radio_sex" value="female"> Female
      </td>
    </tr>
    <tr>
      <td> *Date of Birth: </td>
      <td>
        <input type="text" name="dob_y" size="4" maxlength="4" placeholder="YYYY" required> -
        <input type="text" name="dob_m" size="3" maxlength="2" placeholder="MM" required> -
        <input type="text" name="dob_d" size="2" maxlength="2" placeholder="DD" required>
     </td>
    </tr>
    <tr>
      <td> Date of Death: </td>
      <td>
        <input type="text" name="dod_y" size="4" maxlength="4" placeholder="YYYY"> -
        <input type="text" name="dod_m" size="3" maxlength="2" placeholder="MM"> -
        <input type="text" name="dod_d" size="2" maxlength="2" placeholder="DD">
      </td>
    </tr>
    <tr>
      <td></td>
      <td><input type="submit" name="final" value="   ADD   "/></td>
    </tr>
  </table>
</form>

<?php // Create insert Statement
  // if(isset($_POST['final']))
    // echo "<br><hr> Successfully added new ".$_POST['radio_ad']."!";

  // Leslie
  if(isset($_POST['final']))
  {
    //Establishing connection
    $db_connection = mysql_connect("localhost", "cs143", "");
    if (!$db_connection)
        die("Error while establishing a connection to host: " . mysql_error());

    //Selecting database
    $db_selected = mysql_select_db("CS143", $db_connection);
    if (!$db_selected)
        die("Error while selecting a database: " . mysql_error());

    // Parse required input data variables
    $firstname = $_POST["first"];
    $lastname = $_POST["last"];
    $dob = $_POST["dob_y"] . "-" . $_POST["dob_m"] . "-" . $_POST["dob_d"];
    $dod_y = $_POST["dod_y"];
    $dod_m = $_POST["dod_m"];
    $dod_d = $_POST["dod_d"];
    $type = $_POST["radio_ad"];
    $sex = $_POST["radio_sex"];

    $firstname = "'" . mysql_real_escape_string($firstname) . "'";
    $lastname = "'" . mysql_real_escape_string($lastname) . "'";
    $dob = "'" . mysql_real_escape_string($dob) . "'";
    $sex = "'" . mysql_real_escape_string($sex) . "'";

    // Parse optional dod
    if (empty($dod_y) || empty($dod_m) || empty($dod_d))
        $dod = "NULL";
    else{
      $dod = $_POST["dod_y"] . "-" . $_POST["dod_m"] . "-" . $_POST["dod_d"];
      $dod = "'" . mysql_real_escape_string($dod) . "'";
    }

    // Getting the ID from maxpersonid
    $query = "SELECT id FROM MaxPersonID";
    $rs = mysql_query($query, $db_connection);
    $id = 0;
    while($row = mysql_fetch_row($rs)){
      $id = $row[0] + 1;
      mysql_free_result($rs);
    }

    // Echo test
    // echo $firstname . "<br>" . $lastname . "<br>" . $dob . "<br>" . $dod .
    //  "<br>" . $type . "<br>" . $sex . "<br>";

    //SQL statement
    if ($type == "Actor")
      $query = "INSERT INTO Actor VALUES($id, $lastname, $firstname, $sex, $dob, $dod)";
    else  //director
      $query = "INSERT INTO Director VALUES($id, $lastname, $firstname, $dob, $dod)";

    // Issuing query
    if (!$result = mysql_query($query, $db_connection))
      die("Error while issuing a query: " . mysql_error());

    // Check what has been sucessfully added
    if (mysql_affected_rows($db_connection) != -1){
      if ($type == "Actor")
        echo "<hr> Sucessfully added an Actor" . "<br>";
      else
        echo "<hr> Sucessfully added a Director" . "<br>";
    }
    else
      echo "Transaction unsucessful" . "<br>";

    // Increase MaxPersonID by 1
    $id_query = "UPDATE MaxPersonID SET id = id + 1;";
    if ( !$result = mysql_query($id_query, $db_connection))
      die("Error while updating ID: " . mysql_error());

    // Check to see if update was succesful
    if ( mysql_affected_rows($db_connection) != -1)
        echo "Sucessfully incremented MaxPersonID" . "<br>";
    else
      echo "Was not sucessfuly incrementing MaxPersonID" . "<br>";

    // TODO: update maxID before adding
    // TODO: check if all dod and dob input fields are correct, else die

    mysql_close($db_connection);
  }
 ?>

</body>
</html>
