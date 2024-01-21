<head>
    <title> Bill/Reciept </title>
    <link rel = stylesheet href = Styles\order.css>
</head>
<?php include 'menu.php'?>
<body>
    <center><h1>Your Ticket Booking Details for your Slot </h1></center>
    <?php
    
        $username = $_SESSION['username'];
        $numberplate = $_SESSION["numplate"];


        $con = mysqli_connect("localhost","root","","parkingsystem");
        $slotid=$_GET['slot'];
        $sql = "select * from payment where  slotnum=$slotid";
        $result = mysqli_query($con,$sql);
        $row = mysqli_fetch_assoc($result);
    
        $price = $row['price'];

        $sql2 = "select * from tickets where numberplate = '$numberplate'";
        $result2 = mysqli_query($con,$sql2);
        $row2 = mysqli_fetch_assoc($result2);

        $ticketid = $row2['ticketid'];
        $time1 = $row2['timein'];
        $time2 = $row2['timeout'];
        $numberplate = $row2['numberplate'];
        $vtype = $_SESSION["vtype"];
        $vehicletype = [1 => 'Two Wheeler',2 => 'Four Wheeler',3 => 'Electric Two Wheeler',4 => 'Electric Two Wheeler'];
        $vehicletype2 = $vehicletype[$vtype];
        $dateofbooking = $row2['dateofbooking'];
       
        echo "<div class = 'container'>";
            echo "<div class = 'container2'>";
                echo "<label>Ticket Number</label>";
                echo "<input type='text' value='$ticketid' readonly>";
                echo "<br><br>";
                echo "<label>Slot Number: </label>";
                echo "<input type='text' value='$slotid' readonly>";
                echo "<br><br>";
                echo "<label>Username: </label>";
                echo "<input type='text' value='$username' readonly>";
                echo "<br><br>";
                echo "<label>Vehicle Type: </label>";
                echo "<input type='text' value='$vehicletype2' readonly>";
                echo "<br><br>";   
                echo "<label>Number Plate ID: </label>";
                echo "<input type='text' value='$numberplate' readonly>";
                echo "<br><br>";
                echo "<label>Price: </label>";
                echo "<input type='text' value='$price' readonly>";
                echo "<br><br>";
                echo "<label>Time In: </label>";
                echo "<input type='time' value='$time1' readonly>";
                echo "<br><br>";
                echo "<label>Time Out: </label>";
                echo "<input type='time' value='$time2' readonly>";
                echo "<br><br>";
                echo "<form action='' method = 'post'>";
                echo "<input type='submit' class = 'gohome' name = 'bill' value='Go Home' >";
                echo "<br><br>";
                echo "<form>";
            echo "</div>";
        echo "</div>";

        if($_SERVER["REQUEST_METHOD"] == "POST" )
        {
            if(isset($_POST['bill'])) 
            {
                echo "<script>alert('Thank You for using our service.');</script>";
                echo "<script>window.location='homepage.php';</script>";
            } 
            else
            {
                echo '<script>alert("Sorry, your bill is not confirmed");</script>';
            }
        }
    ?>
</body>
</html>