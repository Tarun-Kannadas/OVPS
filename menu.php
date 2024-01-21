<!DOCTYPE html>
<html>
<head>
<link rel = "stylesheet" href = "Styles\menu.css">
</head>
<body> 
  <ul class="menu">
    <li class = "menu-item"><a href = "homepage.php">Home</a></li>
    <!-- <li class = "menu-item"><a href = "about.php">About</a></li> -->
    <?php
      session_start();
      $admin=$_SESSION["isadmin"];

      echo" <li class = 'menu-item'><a href = 'ticket.php'>Ticket Booking</a></li>";
      echo"<li class = 'menu-item'><a href = 'feedback.php'>FeedBack</a></li>";
    ?>
    <li class = "menu-item2">
        <?php
            // Check if the user is logged in
            if (isset($_SESSION["username"])) 
            {
              if($admin==1)
              {
                header("Location: admin.php");
                exit();
              }
              $username = $_SESSION["username"];
                echo "<label class = 'mainusername'>User: &nbsp;" . $_SESSION["username"]."<label>";
            } 
            else 
            {
                // If not logged in, redirect to login page
                header("Location: index.php");
                exit();
            }
        ?>
    </li>

    <li class = "menu-item2">
      <a href=logout.php><button class=logout>Logout</button></a>
    </li>
  </ul>

</body>
</html>