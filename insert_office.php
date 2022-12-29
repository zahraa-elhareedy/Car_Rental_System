<?php
$location = $_POST['office_name'];

$conn = new mysqli('localhost','root','','car_rental');
if($conn->connect_error){
    echo "$conn->connect_error";
    die("Connection Failed : ". $conn->connect_error);
} 
else {
    $check_duplicate_loc = "SELECT location FROM office WHERE location = '$location' ";
    $result = mysqli_query($conn,$check_duplicate_loc);
    $count = mysqli_num_rows($result);
    if($count>0){
        echo'<script>
        alert("office already exists!");
        window.location = "admin_main.php";
        </script>';
    }
    else{
        $statement = $conn->prepare("insert into office(location) values(?)");
        $statement->bind_param("s",$location);
        $execval = $statement->execute();
        $statement->close();
        $conn->close();
        echo'<script>
        alert("Office Added Successfully");
        window.location = "admin_main.php";
        </script>';
    }
}
?>