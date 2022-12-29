<?php 
    session_start();
    $status="rented";
    $car_plate=$_POST['car_plate'];
    $start_date=$_POST['startdate'];
    $end_date=$_POST['enddate'];
    $daily_price=$_POST['daily_price'];
    $cust_id = $_SESSION['cust_id'];
    if($end_date<=$start_date)
    {
        echo'<script>
        window.alert("Dates Invalid");
        window.location = "cust_rentals.php";
        </script>';
    }
    $conn = new mysqli('localhost','root','','car_rental');
    if($conn->connect_error){
        echo "$conn->connect_error";
    die("Connection Failed : ". $conn->connect_error);
    } 
    else{
        $statement1 = $conn->prepare("select * from car where car_plate = ? ");
        $statement1->bind_param("s",$car_plate);
        $statement1->execute();
        $car = $statement1->get_result()->fetch_assoc();
        $statement1->close();
        $conn->close();
    }
    $office_id=$car['office_id'];
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
    $statement1 = $conn->prepare("SELECT * from car_status where car_plate =? and ( status = 'rented' or status ='inactive') and (NOT((start_date < ? and end_date < ?  )OR( start_date > ? and end_date > ? )))"); 
$statement1->bind_param("sssss",$car_plate,$start_date,$start_date,$end_date,$end_date);
$statement1->execute();
$cars = $statement1->get_result();
$statement1->close();
if($cars->num_rows==0){
    $state="available";
    $date=date_create($start_date);
    date_sub($date,date_interval_create_from_date_string("1 day"));
    $prev_date=date_format($date,"Y-m-d");
    $statement = $conn->prepare("update car_status SET end_date = ? where car_plate = ? AND status = ? AND start_date < ? order by start_date desc limit 1");
    $statement->bind_param("ssss",$prev_date, $car_plate,$state,$start_date);//update end of available
    $execval = $statement->execute();
    $statement->close();
    $statement = $conn->prepare("insert into car_status (car_plate,status,start_date,end_date) values(?, ?, ?,?)");
    $statement->bind_param("ssss", $car_plate,$status, $start_date, $end_date);//insert rented
    $execval = $statement->execute();
    $statement->close();
    $date=date_create($end_date);
    date_add($date,date_interval_create_from_date_string("1 day"));
    $next_date=date_format($date,"Y-m-d");
    $statement = $conn->prepare("insert into car_status (car_plate,status,start_date) values(?, ?, ?)");
    $statement->bind_param("sss", $car_plate,$state, $next_date);//insert new available
    $execval = $statement->execute();
    $statement->close();
    $statement = $conn->prepare("insert into registration (car_plate ,cust_id , office_id, payment,pay_date,start_date,end_date,return_date) values(?,?,?,?,?,?,?,?)");
    $statement->bind_param("sdddssss", $car_plate,$cust_id,$office_id,$payment,$start_date, $start_date, $end_date, $end_date);
    $execval = $statement->execute();
    $conn->close();
    echo'<script>
    window.alert("Reservation Done");
    window.location = "cust_rentals.php";
    </script>';
}else{
    echo'<script>
    window.alert("This Car is not available in this interval!");
    window.location = "customer_home.php";
    </script>';
}
 }
 ?>