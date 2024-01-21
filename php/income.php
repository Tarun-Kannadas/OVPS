<!-- Did not include extraprice for the additional time that user adds -->

<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        body
        {
            color:white;
            background: rgb(49, 49, 49);
        }

        .tickets
        {
            font-size: 45px;
            border: 2px solid white;
            padding: 20px;
        }

        .ticketsinsert
        {
            font-size: 25px;
            border: 2px solid white;
            padding: 20px;
        }

        .textthing
        {
            color:lightcoral
        }

        .users
        {
            display: flex;
            flex-direction: column;
        }

        .profile
        {
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

        .username,.phonenumber,.ticketid,.dateofbooking,.timein,.timeout,.price,.paymentid,.report,.extraprice,.numberplate,.extratime
        {
            display: flex;
            flex-direction: column;
            flex:2;
            justify-items: center;
            align-items: center;
        }

        .button
        {
            padding: 10px;
            background-color: rgba(255, 0, 0, 0.603);
            color: white;
            border: none;
            border-radius: 5px;
        }

        .button:hover
        {
            background-color: red;
        }

        .revenue
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
    </style>
</head>

<body>
    <?php
    
    $con = mysqli_connect("localhost", "root", "", "parkingsystem");

    if (!$con) 
    {
        die("Connection failed! " . mysqli_connect_error(die));
    }

    $sql = "select vehicletype FROM tickets";

    $result = mysqli_query($con, $sql);

    $numRows = mysqli_num_rows($result);

    // echo "<div class='tickets'>";
    // echo "Number of Dates Available " . $numRows;
    // echo "</div>";

    echo "<div class='ticketsinsert'>";
    echo "Select Type of Vehicle to view the revenue";
    echo "<form action='' method=post>
            <select id='vehicletype' name='vehicletype'>
            <option value='1'>Two Wheelers</option>
            <option value='2'>Four Wheelers</option>
            <option value='3'>Electric Two Wheelers</option>
            <option value='4'>Electric Four Wheelers</option>
        </select>
            <input type=submit name=search value=SEARCH class=slotins>
        </form>";
    echo "</div>";

    if (isset($_POST['search']))
    {
        $vtype = $_POST['vehicletype'];

        if(!$numRows)
        {
            echo "No Recorded Dates available";
        }
        else
        {
            $sql3 = "SELECT users.username,
            users.phonenumber,
            tickets.ticketid,
            tickets.dateofbooking,
            tickets.timein,
            tickets.timeout,
            tickets.numberplate,
            tickets.extratime,
            slot.slotnum,
            payment.price,
            payment.paymentid,
            payment.extraprice
            FROM
                users 
            JOIN
                tickets  ON users.userid = tickets.userid
            JOIN
                slot  ON tickets.ticketid = slot.ticketid
            LEFT JOIN
                payment  ON slot.slotnum = payment.slotnum                        
                Where vehicletype = $vtype";
        
            $data=mysqli_query($con,$sql3);

            if (mysqli_num_rows($data) > 0) 
            {
                $var=0;
                while ($row = mysqli_fetch_assoc($data)) 
                {
                    // $id = $row['ticketid'];
                    echo"<div class=items>";
                        echo"<div class=username>";
                            echo "<span class=textthing>Username: </span>";
                            echo $row['username'];
                        echo"</div>";
                        echo"<div class=phonenumber>";
                            echo "<span class=textthing>Phone Number: </span>";
                            echo $row['phonenumber'];
                        echo"</div>";
                        echo"<div class=ticketid>";
                            echo "<span class=textthing>Ticket Number: </span>";
                            echo '#'.$row['ticketid'];
                        echo"</div>";
                        // echo"<div class=dateofbooking>";
                        //     echo "<span class=textthing>Ticket Date: </span>";
                        //     echo $row['dateofbooking'];
                        // echo"</div>";
                        echo"<div class=numberplate>";
                            echo "<span class=textthing>Number Plate: </span>";
                            echo $row['numberplate'];
                        echo"</div>";
                        echo"<div class=timein>";
                            echo "<span class=textthing>Time In: </span>";
                            echo $row['timein'];
                        echo"</div>";
                        echo"<div class=timeout>";
                            echo "<span class=textthing>Time Out: </span>";
                            echo $row['timeout'];
                        echo"</div>";
                        echo"<div class=extratime>";
                            echo "<span class=textthing>Additional Time</span>";
                            echo $row['extratime'].'hrs';
                        echo"</div>";
                        echo"<div class=extraprice>";
                            echo "<span class=textthing>Additional Time Price: </span>";
                            echo '$'.$row['extraprice'];
                        echo"</div>";
                        echo"<div class=price>";
                            echo "<span class=textthing>Price: </span>";
                            echo '$'.$row['price'];
                            $var = $var + $row['price'] + $row['extraprice'];
                        echo"</div>";
                        // echo"<div class=payment>";
                        //     echo "<span class=textthing>Payment Number: </span>";
                        //     echo $row['paymentid'];
                        // echo"</div>";

                        $ticketid = $row['ticketid'];

                        echo "<div class = report>
                            <form action='' method='post'>
                                <input type='text' value = '$ticketid' name = 'ticketid' hidden>
                                <input type='submit' class='button' name='print' value='Print More Info'>
                            </form>
                        </div>";
                    echo"</div>";
                }
                echo"<div class=revenue>";
                echo "<span class=textthing>Total Revenue Generated</span>";
                echo "$$var";
                echo"</div>";
            } 
            else 
            {
                echo "<script>alert('No Recorded Ticket details found');</script>";
            }
        }
    }

    if (isset($_POST['print']))
    {
        $ticketid = $_POST['ticketid'];
        echo "<script>window.location.href = 'reciept3.php?ticketid=$ticketid'</script>";
    }
    mysqli_close($con);
    ?>
</body>
</html>