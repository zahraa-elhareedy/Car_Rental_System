<?php
$plate = $_POST['car_plate'];
$model = $_POST['model'];
$year = $_POST['year'];
$color = $_POST['color'];
$daily_price = $_POST['daily_price'];
$office = $_POST['office'];
$targetDir = "uploads/";
$fileName = basename($_FILES["file"]["name"]);
$targetFilePath = $targetDir . $fileName;
$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);


$conn = new mysqli('localhost','root','','car_rental');
if($conn->connect_error){
    echo "$conn->connect_error";
    die("Connection Failed : ". $conn->connect_error);
} 
else {
    $check_duplicate_plate = "SELECT car_plate FROM car WHERE car_plate = '$plate' ";
    $result = mysqli_query($conn,$check_duplicate_plate);
    $count = mysqli_num_rows($result);
    if($count>0){
        echo'<script>
        alert("car plate already exists!");
        window.location = "admin_main.php";
        </script>';
    }
    else{
if(!empty($_FILES["file"]["name"]))
{
    // Allow certain file formats
    $allowTypes = array('jpg','png','jpeg','gif','pdf');
    $state='available';
    if(in_array($fileType, $allowTypes))
    {
        // Upload file to server
        if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath))
        {
            // Insert image file name into database
            $statement = $conn->prepare("insert into car(car_plate,model,model_year,color,daily_price,office_id,status,image) values(?, ?, ?, ?, ? , ? ,?, ?)");
            $statement->bind_param("ssdsddss", $plate, $model,$year,$color, $daily_price,$office,$state,$fileName);
            if($statement)
            {
                $statusMsg = "The file ".$fileName. " has been uploaded successfully.";
            }
            else
            {
                $statusMsg = "File upload failed, please try again.";
            } 
        }
        else
        {
            $statusMsg = "Sorry, there was an error uploading your file.";
        }
    }
    else
    {
        $statusMsg = 'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
    }
}else
{
    $statusMsg = 'Please select a file to upload.';
}
// Display status message
echo $statusMsg;
        $execval = $statement->execute();
        $statement->close();
        $statement = $conn->prepare("insert into car_status(car_plate,status,start_date,end_date) values(?, ?, ?,?)");
        $start_date = date("Y-m-d");
        $date = date_create(date("Y-m-d"));
        date_add($date,date_interval_create_from_date_string("4 years"));
        $end_date = date_format($date,"Y-m-d");
        $status = "available";
        $statement->bind_param("ssss", $plate, $status,$start_date,$end_date);
        $execval = $statement->execute();
        $statement->close();
        $conn->close();
        echo'<script>
        alert("Successfull Car Registeration");
        window.location = "admin_main.php";
        </script>';
    }
}
?>