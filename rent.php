<?php 
    session_start();
    $status="rented";
    $car_plate=$_POST['car_plate'];
    $start_date=$_POST['startdate'];
    $end_date=$_POST['enddate'];
    $daily_price=$_POST['daily_price'];
    $cust_id = $_SESSION['cust_id'];
    $office_id=$_SESSION['office_id'];
    $sdate=new DateTime($start_date);
    $edate=new DateTime($end_date);
    $interval=$sdate->diff($edate);
    $days=$interval->d;
    $payment=$days*$daily_price;
    $conn = new mysqli('localhost','root','','car_rental');
    if($conn->connect_error){
        echo "$conn->connect_error";
    die("Connection Failed : ". $conn->connect_error);
} 
 else{
    $statement = $conn->prepare("insert into car_status (car_plate,status,start_date,end_date) values(?, ?, ?,?)");
    $statement->bind_param("ssss", $car_plate,$status, $start_date, $end_date);
    $execval = $statement->execute();
    $statement->close();
    $statement = $conn->prepare("update car SET status = ? where car_plate = ?");
    $statement->bind_param("ss",$status, $car_plate);
    $execval = $statement->execute();
    $statement->close();
    $statement = $conn->prepare("insert into registration (car_plate ,cust_id , office_id, payment,start_date,end_date) values(?,?,?,?,?,?)");
    $statement->bind_param("sdddss", $car_plate,$cust_id,$office_id,$payment, $start_date, $end_date);
    $execval = $statement->execute();
    $conn->close();
    echo'<script>
    window.alert("Reservation Done");
    window.location = "cust_rentals.php";
    </script>';
 }
 ?>