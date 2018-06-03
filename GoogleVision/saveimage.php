<?php
$servername = "localhost";
$username = "root";
$password = "rx123";
$dbname = "newprescription";


include 'ChromePhp.php';
ChromePhp::log('This is just a log message');
ChromePhp::warn("This is a warning message " ) ;
ChromePhp::error("This is an error message" ) ;
ChromePhp::log($_SERVER);
 
// using labels
foreach ($_SERVER as $key => $value) {
    ChromePhp::log($key, $value);
}

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
// save image and other user info
if($_GET['data'] == "fields_data"){
		$last_id = $_GET["id"];
		$clinic = $_POST['clinic'];
		$patient = $_POST['patient'];
		$doc_type = $_POST['doc_type'];
		$date = $_POST['date'];
		$doctor = $_POST['doctor'];
	$sql = "UPDATE prescription_details SET clinic_name='$clinic',patient_name='$patient', visit_date='$date' , doc_type='$doc_type',doctor_name='$doctor' WHERE id = ".$last_id;
	if(mysqli_query($conn, $sql)){
				echo "data Saved Successfully";
			}else{
			echo"Data Not Saved";
			}
}else {
	if($_FILES){
	$fullname = explode(".", $_FILES['file']['name']);
    $filname = $fullname[0];
    $ext = $fullname[1];
    $random = rand();
    //$newname =  $filname."_".strtotime(date("Y-m-dH:i:s")).".".$ext;
    $newname = $filname."_".$random.".".$ext;	
//$newname = "test.png";
	$newloc = "./image/".$newname;
	//echo $newloc."\n";
	//echo move_uploaded_file($_FILES['file']['tmp_name'],$newloc)."\n";
	if(move_uploaded_file($_FILES['file']['tmp_name'],$newloc)){
        //if(file_put_contents($newloc,file_get_contents(($_FILES['file']['tmp_name'])))) {
		
	$sql = "INSERT INTO prescription_details (image_url)

	VALUES ('$newloc')";
//echo $sql;
	//move_uploaded_file(file,newloc)
		if(mysqli_query($conn, $sql)){
			$last_id = mysqli_insert_id($conn);
			echo "$last_id";

		}else{
		echo"Image Not Saved";
		}
	}else{
	echo"Something Went to Wrong 1";
	}
} else if($_POST && $_GET['data'] == "image"){

	$data = $_POST['file'];
	$data = base64_decode($data);
	$newName = "SnapImage_".strtotime(date("Y-m-dH:i:s")).".png";
	$newloc = "image/".$newName;
	if(file_put_contents("image/$newName", $data)){
		$sql = "INSERT INTO prescription_details (image_url,clinic_name) VALUES ('$newloc','$clinic')";
			if(mysqli_query($conn, $sql)){
				$last_id = mysqli_insert_id($conn);
				echo "$last_id";
			}else{
			echo"Image Not Saved";
			}
	}else{
	echo"Something Went to Wrong 2";
	}
}else{
echo"Something Went to Wrong 3";
}


}

?>
