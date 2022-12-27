<?php
$name = $_POST['name_reg'];
$email = $_POST['email_reg'];
$password = $_POST['password_reg'];
$md5password= md5($password);

$conn = new mysqli('localhost','root','','car_rental');
if($conn->connect_error){
    echo "$conn->connect_error";
    die("Connection Failed : ". $conn->connect_error);
} 
else {
    $check_duplicate_mail = "SELECT email FROM customer WHERE email = '$email' ";
    $result = mysqli_query($conn,$check_duplicate_mail);
    $count = mysqli_num_rows($result);
    if($count>0){
        echo'<script>
        alert("Email Already Exists!");
        window.location = "registration_login.html";
        </script>';
    }
    else{
        $statement = $conn->prepare("insert into customer(name, email, password) values(?, ?, ?)");
        $statement->bind_param("sss", $name, $email, $md5password);
        $execval = $statement->execute();
        $statement->close();
        $conn->close();
        echo'<script>
        alert("Registration successfull. Please Login.");
        window.location = "registration_login.html";
        </script>';
    }
}
?>