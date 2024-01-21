<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AutoDeleteTickets</title>

    <STYLE>
        body
        {
            color:aliceblue;
            background: rgb(49, 49, 49);
        }
        .textthing
        {
            color:lightcoral
        }
        .users
        {
            color: white;
            display: flex;
            flex-direction: column;
        }
        .profile{
            width: 100px;
        }
        .items
        {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            font-size: 25px;
            border: 5px solid aliceblue;
            background-color:rgba(71, 61, 139, 0.486);
        }
  </STYLE>

</head>
<body>
    
    <?php

       echo"<form action='' method='post'>
            <input type = 'submit' class  = 'button' name = 'refresh' value = 'Refresh Slots'>
            </form>
            ";

        if(isset($_POST['refresh']))
        {
            $con = mysqli_connect("localhost", "root", "", "parkingsystem");

            if (!$con) 
            {
                die("Connection Failed: " . mysqli_connect_error());
            }

            // Set the timezone to match the one used in your application
            date_default_timezone_set('Asia/Kolkata');

            $currentDateTime = date('Y-m-d H:i:s');

            // Select tickets with timeout earlier than the current date and time
            $expiredTicketsQuery = "SELECT * FROM tickets WHERE timeout <= '$currentDateTime'";
            $expiredTicketsResult = mysqli_query($con, $expiredTicketsQuery);

            if ($expiredTicketsResult) 
            {
                while ($row = mysqli_fetch_assoc($expiredTicketsResult)) 
                {
                    $ticketId = $row['ticketid'];

                    $query = "SELECT * from slot where ticketid = $ticketId";
                    $result = mysqli_query($con, $query);
                    $row2 = mysqli_fetch_assoc($result);

                    $slotnum = $row2['slotnum'];
                    echo $slotnum;
                    $vtype = $row2['vehicletypeslot'];
                    echo $vtype;

                    $delpay = "DELETE FROM payment WHERE slotnum IN (SELECT slotnum FROM slot WHERE ticketid = $ticketId)";
                    $delslot="DELETE FROM slot WHERE ticketid = $ticketId";
                    $insslot = "INSERT INTO slot(`slotnum`, `vehicletypeslot`,`status`) VALUES ($slotnum,$vtype,0)";
                    $delticket="DELETE FROM tickets WHERE ticketid = $ticketId;";
                    $data=mysqli_query($con,$delpay);
                    $data1=mysqli_query($con,$delslot);
                    $data2=mysqli_query($con,$insslot);
                    $data3=mysqli_query($con,$delticket);
                    if($data&&$data1&&$data2&&$data3)
                    {
                      echo"<script>alert('done')</script>";
                    }

                    echo "Ticket $ticketId has expired and is deleted.<br><br>";
                }
            } 
            else 
            {
                echo "Error retrieving expired tickets: " . mysqli_error($con);
            }

            mysqli_close($con);
        }
    ?>
</body>
</html>
