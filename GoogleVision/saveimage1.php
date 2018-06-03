<?php
$servername = "localhost";
$username = "root";
$password = "rx123";
$dbname = "newprescription";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
// save image and other user info
		$clinic = $_POST['clinic1'];
		$patient = $_POST['patient1'];
		$medicine_name = $_POST['medicine'];
                $dosage_qty = $_POST['dosage'];
                $typeofmedicine = $_POST['radiobutton'];
		$doctor = $_POST['doctor1'];
		$sql = "INSERT INTO prescription_details1 (clinic1,patient1,medicine,dosage,doctor1,radiobutton) VALUES ('$clinic','$patient','$medicine_name','dosage_qty','$doctor','typeofmedicine')";
		if(mysqli_query($conn, $sql)){
				echo "data Saved Successfully";
		}else{
			echo"Data Not Saved";
		}

?>
