<?php
require_once('menu.html');
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
// get all records from the database	
$sql = "SELECT * FROM `newprescription.prescription_details` ORDER BY `created_at` DESC";

$result = mysqli_query($conn, $sql);
?>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->


<style>
<style>
body {font-family: Arial, Helvetica, sans-serif;}

#myImg {
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
}
#filter-header {
	 margin-left: 15px;
}
#myImg:hover {opacity: 0.7;}

/* The Modal (background) */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
}

/* Modal Content (image) */
.modal-content {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
}

/* Caption of Modal Image */
#caption {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
    text-align: center;
    color: #ccc;
    padding: 10px 0;
    height: 150px;
}

/* Add Animation */
.modal-content, #caption {    
    -webkit-animation-name: zoom;
    -webkit-animation-duration: 0.6s;
    animation-name: zoom;
    animation-duration: 0.6s;
}
.hideDisplay{
    display: none !important;
}

@-webkit-keyframes zoom {
    from {-webkit-transform:scale(0)} 
    to {-webkit-transform:scale(1)}
}

@keyframes zoom {
    from {transform:scale(0)} 
    to {transform:scale(1)}
}

/* The Close Button */
.close {
    position: absolute;
    top: 15px;
    right: 35px;
    color: #f1f1f1;
    font-size: 40px;
    font-weight: bold;
    transition: 0.3s;
}

.close:hover,
.close:focus {
    color: #bbb;
    text-decoration: none;
    cursor: pointer;
}
.filter-field {
    width:  240px;
    margin-bottom: 10px;
}

/* 100% Image Width on Smaller Screens */
@media only screen and (max-width: 700px){
    .modal-content {
        width: 100%;
    }
}
</style>
</style>
<div class="container">
<br>
    <div id="products" class="row list-group col-xs-12 col-lg-12">
        <div id="filter-header" style="">
            <div style="font-size: 22px">Filter Records</div>
            <div class="form-group">
                <input type="text" class="form-control filter-field" id="clinic" placeholder="Enter clinic or Hospital name" name="clinic">
            </div>
             <div class="form-group">
                <input type="text" class="form-control filter-field" id="doctor" placeholder="Enter doctor name" name="doctor">
            </div>
			<div class="form-group">
                <input type="date" class="form-control filter-field" id="date" placeholder="Enter visit name" name="date">
            </div>
            <div class="form-group">
                <div id="filter-submit" class="btn btn-primary">Search</div>
            </div>

        </div>
	<?php if (mysqli_num_rows($result) > 0) { 
		$count = 1;
		 while($row = mysqli_fetch_assoc($result)) {
			 $dbImageUrl = $row['image_url'];
			  if (file_exists("$dbImageUrl")) {
				  $imageUrl = $row['image_url'];
			 } else{
					$imageUrl = "image/dummy.png";
			 }
             $visit_date = $row['visit_date'] == "0000-00-00" ? "-" : $row['visit_date'];
             $clinic_name = empty($row['clinic_name']) ? "-" : $row['clinic_name'];
             $doctor_name = empty($row['doctor_name']) ? "-" : $row['doctor_name'];
	?>
        <div class="item documents col-xs-12 col-lg-4" data-doctor = "<?= $doctor_name?>" data-clinic = "<?= $clinic_name?>" data-date = "<?= $visit_date?>">
            <div id="report_details" style="text-align: center;font-size: 22px;margin-bottom: 15px;margin-top: 15px">
                <div>
                    <div id="clinic_name">Clinic name: <?= $clinic_name?></div>
                </div>
                <div>
                    <div id="doctor_name">Doctor name: <?= $doctor_name?></div>
                </div>
                
                 <div>
                    <div id="visit_date">Visit date : <?= $visit_date?></div>
                </div>
            </div>
            
            <div class="thumbnail" style="text-align:center">
                 <img class="group list-group-image modelImage img-responsive" src="<?php echo $imageUrl;?>" alt="Image" style = "height:150px;max-width:200px" id="myImg"/>
                <!--<div class="caption">
                    <h4 class="group inner list-group-item-heading">
                        Product title</h4>
                    <p class="group inner list-group-item-text">
                        Product description... Lorem ipsum dolor sit amet, consectetuer adipiscing elit,
                        sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>
                    <div class="row">
                        <div class="col-xs-12 col-md-6">
                            <p class="lead">
                                $21.000</p>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <a class="btn btn-success" href="http://www.jquery2dotnet.com">Add to cart</a>
                        </div>
                    </div>
                </div>-->
            </div>
        </div>
		<?php 
		$count++;
		} }else{
		echo"No history found";
	}
	?>
    </div>
</div>

<div id="myModal" class="modal">
  <span class="close">&times;</span>
  <img class="modal-content" id="img01">
  <div id="caption"></div>
</div>

<script>
// Get the modal
var modal = document.getElementById('myModal');

// Get the image and insert it inside the modal - use its "alt" text as a caption
var img = document.getElementById('myImg');
var modalImg = document.getElementById("img01");
var captionText = document.getElementById("caption");

$(document).ready(function(){
$(".modelImage").click(function(){
	$thisSrc = $(this).attr("src");
	modal.style.display = "block";
    modalImg.src = $thisSrc;
    captionText.innerHTML = this.alt;
});
//list filtering event based on user data
$("#filter-submit").click(function() {
    var doctor = $("#doctor").val();
    var clinic = $("#clinic").val();
    var date = $("#date").val();
    var drEmpty = false;
    var cliEmpty = false;
    var dateEmpty = false;
    var drNoMatch = false;
    var cliNoMatch = false;
    var dateNoMatch = false;
    if(doctor.length > 0) {
         $('.documents').removeClass('hideDisplay');
         if($('.documents[data-doctor = "'+doctor+'"]').length == 0) {
            /*if(!$('.documents:not([data-doctor = "'+doctor+'"])').hasClass('hideDisplay')) {
                drNoMatch = true;
            }*/
           drNoMatch = true;
         }else {
            $('.documents:not([data-doctor = "'+doctor+'"])').addClass('hideDisplay');
         }
    }else {
        drEmpty = true;
    }
    if(clinic.length > 0) {
       $('.documents').removeClass('hideDisplay');
       console.log($('.documents:not([data-clinic= "'+clinic+'"])'));
       if(!drNoMatch) {
            if($('.documents[data-clinic = "'+clinic+'"]').length == 0) {
                /*if(!$('.documents:not([data-clinic = "'+clinic+'"])').hasClass('hideDisplay')) {
                    cliNoMatch = true;
                }*/
                cliNoMatch = true;
             }else {
                $('.documents:not([data-clinic= "'+clinic+'"])').addClass('hideDisplay');
             }
       }
       
    }else {
        cliEmpty = true;
    }
    if(date.length > 0) {
        $('.documents').removeClass('hideDisplay');
        if(!drNoMatch && !cliNoMatch) {
            if($('.documents[data-date = "'+date+'"]').length == 0) {
                /*if(!$('.documents:not([data-date = "'+date+'"])').hasClass('hideDisplay')) {
                    
                    dateNoMatch = true;
                }*/
                dateNoMatch = true;
             }else {
                $('.documents:not([data-date = "'+date+'"])').addClass('hideDisplay');
             }
        }
        //$('.documents:not([data-date = "'+date+'"])').addClass('hideDisplay');
    }else {
        dateEmpty = true;
    }
    if(drEmpty && cliEmpty && dateEmpty) {
        $('.documents').removeClass('hideDisplay');
    }
    if(drNoMatch || dateNoMatch || cliNoMatch) {
        $('.documents').addClass('hideDisplay');
    }
});
});
// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() { 
    modal.style.display = "none";
}
</script>
