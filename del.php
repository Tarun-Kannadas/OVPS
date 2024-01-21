<!DOCTYPE html>
<html lang="en">
<head>
  
</head>
<body>
  <?php
  $con=mysqli_connect("localhost","root","","parkingsystem");

  if ($con->connect_error) {
    die("Connection failed: " . $conn->connect_error);
 }
   echo "Connected successfully";
   echo"<form action='' method='post'>Enter ticket
   <input type='text' name='ticket'>
   <input type='submit' name=delete value='Delete ticket'>
   </form>
   ";

  if(isset($_POST['delete']))
  {
    $id=$_POST['ticket'];
    $delpay = "DELETE FROM payment WHERE slotnum IN (SELECT slotnum FROM slot WHERE ticketid =$id)";
    $delslot="delete FROM slot WHERE ticketid = $id";
    $insslot="INSERT INTO `slot`(`slotnum`, `vehicletypeslot`,`status`) VALUES (1,1,0)";
    $delticket="DELETE FROM tickets WHERE ticketid = $id;";
    $data=mysqli_query($con,$delpay);
    $data1=mysqli_query($con,$delslot);
    $data2=mysqli_query($con,$insslot);
    $data3=mysqli_query($con,$delticket);
    if($data&&$data1&&$data2&&$data3)
    {
      echo"<script>alert('done')</script>";
    }
  }
  ?>
</body>
</html>