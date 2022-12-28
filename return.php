<?php 
    session_start();
    $status="available";
    $car_plate=$_GET['car'];
    $start_date=$_POST['returndate'];
    $startres=$_POST['startres'];
    if($start_date<=$startres)
    {
        echo'<script>
        window.alert("Dates Invalid");
        window.location = "cust_rentals.php";
        </script>';
    }
    $register_no=$_POST['register_no'];
    $end_date=$_POST['end_date'];


    $conn = new mysqli('localhost','root','','car_rental');
    if($conn->connect_error){
        echo "$conn->connect_error";
    die("Connection Failed : ". $conn->connect_error);
} 
 else{
    $state="rented";
    $date=date_create($start_date);
    date_add($date,date_interval_create_from_date_string("1 day"));
    $next_date=date_format($date,"Y-m-d");
    $statement = $conn->prepare("update car_status SET end_date = ? where car_plate = ? AND status = ? order by start_date desc limit 1");
    $statement->bind_param("sss",$start_date, $car_plate,$state);
    $execval = $statement->execute();
    $statement->close();
    $statement = $conn->prepare("insert into car_status (car_plate,status,start_date) values(?, ?, ?)");
    $statement->bind_param("sss", $car_plate,$status, $next_date);
    $execval = $statement->execute();
    $statement->close();
    $statement = $conn->prepare("update car SET status = ? where car_plate = ?");
    $statement->bind_param("ss",$status, $car_plate);
    $execval = $statement->execute();
    $statement->close();
    $statement = $conn->prepare("update registration SET return_date = ? where register_no=?");
    $statement->bind_param("sd", $start_date,$register_no);
    $execval = $statement->execute(); 
    $statement->close();
    $true = TRUE;
    $statement = $conn->prepare("update registration SET is_returned = ? where register_no=?");
    $statement->bind_param("sd", $true,$register_no);
    $execval = $statement->execute(); 
    $statement->close();


    $conn->close();
    echo'<script>
    alert("Return Done");
    window.location = "cust_rentals.php";
    </script>';
 }