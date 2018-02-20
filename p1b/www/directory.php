<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Project 1B</title>
  </head>
  <body>
    <!-- Home page -->
    <a href="welcome.php", target="main"><h1>CS 143</h1></a>

    <!-- Search bar -->
    <br><b>Search for Actors/Movies:</b>
    <form action="search.php" target="main" method="POST">
    <table cellspacing="10">
        <tr>
            <td><input type="text" name="query" size="30" maxlength="40"
              required value="<?php echo htmlspecialchars($_GET['query']); ?>" /></td>
        </tr>
        <tr>
            <td>
              <input type="checkbox" name="actor" value="checked" checked />Actor
              <input type="checkbox" name="movie" value="checked" checked />Movie
            </td>
        </tr>
        <tr>
          <td><input type="submit" value="Search"/></td>
        </tr>
    </table>
    </form>

    <!-- Add info links -->
    <br><b>Add Information:</b><br>
    <ul>
      <li>
        <a href="add_ad_info.php", target="main">Add Actor/Director Info</a>
      </li>
      <li>
        <a href="add_m_info.php", target="main">Add Movie Info</a>
      </li>
      <li>
        <a href="add_m_review.php", target="main">Add Movie Review</a>
      </li>
      <li>
        <a href="add_a2m_relation.php", target="main">Add Actor/Movie Relation</a>
      </li>
      <li>
        <a href="add_d2m_relation.php", target="main">Add Director/Movie Relation</a>
      </li>
    </ul>
  </body>
</html>
