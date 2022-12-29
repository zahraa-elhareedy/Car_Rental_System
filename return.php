<?php 
    session_start();
    $status="available";
    $car_plate=$_GET['car'];
    $return_date=$_POST['returndate'];
    $startres=$_POST['startres'];
    if($return_date<=$startres)
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
    $date=date_create($return_date);
    date_add($date,date_interval_create_from_date_string("1 day"));
    $next_date=date_format($date,"Y-m-d");
    $statement = $conn->prepare("update car_status SET end_date = ? where car_plate = ? AND status = ? and start_date =?");
    $statement->bind_param("ssss",$return_date, $car_plate,$state,$startres);//update end of rent
    $execval = $statement->execute();
    $statement->close();
    $date=date_create($end_date);
    date_add($date,date_interval_create_from_date_string("1 day"));
    $next_available_date=date_format($date,"Y-m-d");
    $statement = $conn->prepare("update car_status SET start_date = ? where car_plate = ? AND status = ? and start_date =?");
    $statement->bind_param("ssss",$next_date, $car_plate,$status,$next_available_date);//update start of available
    $execval = $statement->execute();
    $statement->close();
    $statement = $conn->prepare("update registration SET return_date = ? where register_no=?");
    $statement->bind_param("sd", $return_date,$register_no);
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