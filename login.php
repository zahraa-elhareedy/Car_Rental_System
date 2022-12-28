<?php
$email = $_POST['email_login'];
$password = $_POST['password_login'];
$login_type =$_POST['login_type'];
$conn = new mysqli('localhost','root','','car_rental');
if($conn->connect_error){
    echo "$conn->connect_error";
    die("Connection Failed : ". $conn->connect_error);
}
else {
        if($login_type=="Admin"){
            $statement = $conn->prepare("select * from admin where email = ?"); 
        }
        else if ($login_type=="Customer"){
            $statement = $conn->prepare("select * from customer where email = ?");  
        }
        $statement->bind_param("s",$email);
        $statement->execute();
        $statement_result = $statement->get_result();
        if($statement_result->num_rows > 0){
            $data = $statement_result->fetch_assoc();
            if($data['password'] === md5($password))
            {
                 if ($login_type=="Admin"){
                    header('Location:admin_main.php');  
                }
                else
                {
                   $cu_id= $data['cust_id'];
                   $today=$_POST['today_date'];
                    session_start();
                    $_SESSION['cust_id'] =$cu_id;
                    $_SESSION['today_date']=$today;
                    header('Location:customer_home.php');
                }
                
            }
            else
            {
                echo'<script>
                alert("Incorrect password");
                window.location = "registration_login.html";
                </script>';
            }
        }
        else{
            echo'<script>
            alert("Incorrect E-mail");
            window.location = "registration_login.html";
            </script>';
        }
      
    
}
?>