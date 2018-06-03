<?php
require_once('menu.html');
$servername = "localhost";
$username = "root";
$password = "rx123";
$dbname = "newprescription";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT image_keywords FROM `keywords`";

$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$keywords = $row["image_keywords"];

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <input type="hidden" id="image_keywords" name="image_keywords" value = "<?= $keywords?>" >
  <title>Enter a Rx</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  <style type="text/css">
  	input,select {
  		height: 35px;
    	
  	}
  	.form-fields {
  		width: 240px;
  	}

	#cover {
		background: url("../images/icons/loader.gif") no-repeat scroll center center #FFF;
		position: absolute;
		height: 100%;
		width: 100%;
		display: none;
	}
  </style>
 
<script src='./Main.js'></script>
</head>
<body>
<div id="cover"></div>
<div class="container">
  <h2>Enter a Rx</h2>
  <form>
    <div class="form-group form-fields">
      <input type="text" class="form-control" id="clinic1" placeholder="Enter clinic or Hospital name" name="clinic">
    </div>
    <div class="form-group form-fields">
      <input type="text" class="form-control" id="doctor1" placeholder="Enter doctor name" name="doctor">
    </div>
     <div class="form-group form-fields">
      <input type="text" class="form-control" id="patient1" placeholder="Enter patient name" name="patient">
    </div>
    <div class="form-group form-fields">
      <input type="text" class="form-control" id="medicine" placeholder="Enter Prescribed Drug" name="medicine_name">      	
    </div>
    <div class="form-group form-fields">
      <input type="text" class="form-control" id="dosage" placeholder="Enter dosage" name="dosage_qty">      	
    </div>


<div class="element-radio">
    <div class="column column2">
        <label>
            <input type="radio" name="typeofmedicine" id="radiobutton" value="Recurring" />  <!--onChange="findselected()"/>-->
            <span>Recurring</span>
        </label>
    </div>
    <span class="clearfix"></span>

    <div class="column column2">
        <label>
            <input type="radio" name="typeofmedicine" id="radiobutton" value="Foratimerange" /> <!-- onChange="findselected()"/> -->
            <span>For a time range</span>
        </label>
    </div>
    <span class="clearfix"></span>
</div>


<!-- <input id="inputtext" class="large" type="date" min="0" max="100" name="medicine_date" placeholder="Date Range" value="<?php echo $medicine_date?>" />
-->
 <p> Enter start date</p> 
 <div class="form-group form-fields">
      <input type="date" class="form-control" id="inputtext" placeholder="Enter Start date" name="start_date">
    </div>

<p>Enter end date</p>
  <div class="form-group form-fields">
      <input type="date" class="form-control" id="inputtext2" placeholder="Enter End date" name="end_date">
    </div>

    <button type="submit" class="btn btn-primary" id="submit1" style="margin-top: 20px">Submit</button>
  </form>
  
</div>

<!-- Validtion Success Modal 
  <div class="modal fade" id="validateSuccess" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Message</h4>
        </div>
        <div class="modal-body">
          <p>Image Validation Success.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div> -->
  
  <!-- Validtion Failure Modal 
  <div class="modal fade" id="validateFailed" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Message</h4>
        </div>
        <div class="modal-body">
          <p>Image Validation Failure.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div> -->

  <!--<script>
	
	$(document).ready(function(){
       //choose file change event
    document.getElementById("upload_photo").addEventListener("change", readFile);
	var video = document.getElementById('video');
	$("#takePhoto").click(function(){
		$("#photo-btn").show();
	$("#video").css("display","block");
	var video = document.getElementById('video');

	
	if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
    // Not adding `{ audio: true }` since we only want video now
    navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream) {
        video.src = window.URL.createObjectURL(stream);
        video.play();
		});
		navigator.getUserMedia(
    {   // we would like to use video but not audio
        // This object is browser API specific! - some implementations require boolean properties, others require strings!
        video: true, 
        audio: false
    },
    function(videoStream) {
        // 'success' callback - user has given permission to use the camera
        // my code to use the camera here ... 
    },
    function() {
        // 'no permission' call back
      window.location.reload();
    }               
);
}

//$(".takeSnapPage").css("display","none");
$(".snapPage").css("display","inline-block");
});

$("#cancel").click(function(){
//window.location.reload();
 $('#video').hide();
 $("#photo-btn").hide();
});

$("#enterrx").click(function() {
  window.location.hash = 'xyz';
});

var video = document.getElementById('video');

// Trigger photo take
document.getElementById("snap").addEventListener("click", function() {
	
	var base64 = getBase64Image(document.getElementById("video"));
	process_image(base64);
	snapbtn = true;
}); 

		$("#validateSuccess, #validateFailed").on("hidden.bs.modal", function () {
			// put your default event here
			window.location.reload();
		});
	
		});
	
	function getBase64Image(img) {
  var canvas = document.createElement("canvas");
  canvas.width = img.width;
  canvas.height = img.height;
  var ctx = canvas.getContext("2d");
  ctx.drawImage(img, 0, 0);
  var dataURL = canvas.toDataURL("image/png");
  return dataURL.replace(/^data:image\/(png|jpg);base64,/, "");
}

	
  </script> -->
  
</body>
</html>
