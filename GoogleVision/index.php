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
// get keywords from database
$sql = "SELECT image_keywords FROM `keywords`";

$result = mysqli_query($conn, $sql);
$keyArray = [];
//$row = mysqli_fetch_assoc($result);
//$keywords = $row["image_keywords"];
if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $keyArray[] = $row["image_keywords"];
    }
}
$keywords = implode(",",$keyArray);
?>
<html>
<input type="hidden" id="image_keywords" name="image_keywords" value = "<?= $keywords ?>" >
<head>
<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
  <script src='./Main.js'>

</script>
  
  <style>
	#cover {
		background: url("../images/icons/loader.gif") no-repeat scroll center center #FFF;
		position: absolute;
		height: 100%;
		width: 100%;
		display: none;
	}
  .menu_wrapper {
    text-align: center;
    margin: 30px;
  }
  .main_menu {
    background-color: #BCCDEA;
    padding: 25px;
    font-size: 24px;
    /* margin-top: 20px; */
    /* width: 49px; */
    width: 210px;
    border-radius: 7px;
    display: inline-block;
    text-decoration: none;
    color:#333;
  }
  a:hover , a:visited {
    text-decoration: none;
    color:#333;
  }
  </style>
  <script>
	
	$(document).ready(function(){
    document.getElementById("upload_photo").addEventListener("change", readFile);
	var video = document.getElementById('video');
	$("#takePhoto").click(function(){
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

$(".takeSnapPage").css("display","none");
$(".snapPage").css("display","inline-block");
});

$("#cancel").click(function(){
window.location.reload();
});

$("#scanrx").click(function() {
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

	
  </script>
  
  <style>
  input[type=file] {
    display: inline;
}
  </style>
</head>
<body>
<video id="video" width="640" height="480" autoplay style = "display:none;"></video>
<br>
<div id="cover"></div>
<div class="item col-xs-12 col-lg-12">
<div style="text-align: center"><img style="width:110px" src="../images/icons/logo.png"></div>
  <div id="scanrx" class="menu_wrapper">
    <a class="main_menu" href = "scan.php">Scan a Rx</a>
  </div>
  <div id="findrx" class="menu_wrapper">
     <a class="main_menu" href = "list.php">Find a Rx</a>

  </div>
  <div id="enterrx" class="menu_wrapper">
     <a class="main_menu" href = "enter.php">Enter a Rx</a>

  </div>
</div>
<div class="" >
  

  <div style="margin-bottom: 15px;text-align: center;">
    <button id="takePhoto" class="btn btn-primary takeSnapPage" style = "display:none;">Take Photo</button>
  </div>
  <button id="snap" class="btn btn-primary snapPage" style = "display:none;">Snap Photo</button>
  
  <button id="cancel" class="btn btn-primary snapPage" style = "display:none;">Cancel</button>
   <div style="margin-bottom: 15px;text-align: center;display:none;">
    <input type="file" accept="image/*" capture="filesystem" id="upload_photo" style = "width:180px" class="btn btn-primary takeSnapPage"/>

  </div>
  <div style="margin-bottom: 15px;text-align: center;display:none;">
    <a id= 'listHistory' href = "list.php" class="btn btn-primary takeSnapPage">View History</a> 
  </div>

</div>
<!-- Validtion Success Modal -->
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
  </div>
  
  <!-- Validtion Failure Modal -->
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
  </div>
  
</body>
</html>
