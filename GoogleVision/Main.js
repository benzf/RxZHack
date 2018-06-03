snapbtn = false;
var image_bade64,processed_data,image_status = false;
//get values of all keywords
var check_values = document.getElementById("image_keywords").value;
//var check_values = [ 'Tablet' , 'Patient', 'Hospital' ];
//check_values = check_values.replace(/['"]+/g, '');
check_values = check_values.split(",");

// to read the image file
function readFile() {
 snapbtn = false;
  image_bade64 = "";
  if (this.files && this.files[0]) {
    
    var FR= new FileReader();
    
    FR.addEventListener("load", function(e) {
     image_bade64 = e.target.result;
  var image_split = image_bade64.split(',');
  image_bade64 = "";
  for(var i = 1;i < image_split.length; i++){
   image_bade64 = image_bade64 + image_split[i];
  }
  if(image_bade64) {
  process_image(image_bade64);
  }
  
    }); 
    
    FR.readAsDataURL( this.files[0] );
  }
  
}

// process the image file with google vision api
function process_image(base64) {
 processed_data = '';
 image_status = false;
 $('#cover').fadeIn(100);
 $.ajax({
            url: 'https://content-vision.googleapis.com/v1/images:annotate?key=AIzaSyBn6wv-S9PUHsOvVTQ_FtotpJpBvvxhSKA&alt=json',
            type: 'post',
            dataType: 'json',
   contentType: "application/json; charset=utf-8",
            traditional: true,
            success: function (data) {
  $('#cover').fadeOut(1000);
             $("#submit").attr("disabled", false);
               console.log(data);
      processed_data = data.responses[0].textAnnotations;
      if(processed_data) {
      for(var i=0; i < processed_data.length; i++) {
       for(var j = 0; j < check_values.length; j++ ){
        if(check_values[j].toUpperCase() == processed_data[i].description.toUpperCase() ) {
         image_status = true;
         break;
        }
       }
      }
      }
      
 /*     if(image_status){
     $('#cover').fadeOut(1000);
    // alert('Image Validation Success');
     $('#validateSuccess').modal('show');
    // window.location.reload();
     //saveImage();
     
    }else {
     $('#cover').fadeOut(1000);
     $("#validateFailed").modal('show');
    // alert('Image Validation Fails');
    // window.location.reload();
    }*/
      
            },
            data: JSON.stringify(build_vision_obj(base64))
        });
 
 
}
function build_vision_obj(base64){
var obj =  {
  "requests": [
    {
      "image": {
        "content": base64
      },
      "features": [
        {
          "type": "TEXT_DETECTION"
        }
      ]
    }
  ]
};
 return obj;
}
// save image and other datas
function saveImage(){
 console.log("Image Saved..");
 var clinic = document.getElementById('clinic').value;
 var doctor = document.getElementById('doctor').value;
 var patient = document.getElementById('patient').value;
 var date = document.getElementById('date').value;
 var doc_type = document.getElementById('doc_type').value;
 if(snapbtn){
  var fileInput = document.getElementById('video');
  
  var canvas = document.createElement("canvas");
  canvas.width = fileInput.width;
  canvas.height = fileInput.height;
  var ctx = canvas.getContext("2d");
  console.log(clinic);
  console.log(doctor);
  ctx.drawImage(fileInput, 0, 0);
  var dataURL = canvas.toDataURL("image/png");
  var file = dataURL.replace(/^data:image\/(png|jpg);base64,/, "");
  
 } else{
      var fileInput = document.getElementById('upload_photo');
    var file = fileInput.files[0];
 }
  var formData = new FormData();
   formData.append('file', file);
        $.ajax({
            url: "saveimage.php?data=image",
            type: "POST",
            data: formData,
            async: false,
            success: function (data) {
             console.log(data);
                 $.ajax({
               url: "saveimage.php?data=fields_data&id="+data,
                  type: "POST",
               data: "clinic="+clinic+ "&doctor="+doctor+"&patient="+patient+"&date="+date+"&doc_type="+doc_type,
               async: false,
               success: function (msg) {
                   $('#cover').fadeOut(1000); 
              }
            
        });
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }
// submit form event
$(document).ready(function(){
 $("#submit").attr("disabled", true);
 $("#submit").click(function(e){
  e.preventDefault();
  e.stopPropagation();
  if(image_status){
   $('#cover').fadeOut(1000);
  // alert('Image Validation Success');
   saveImage();
   //$('#validateSuccess').modal('show');
   alert('Image Validation Succeed');
  // window.location.reload();
   //saveImage();
   
  }else {
   //$("#validateFailed").modal('show');
   alert('Image Validation Failed');
  // window.location.reload();
  }
  
 });
$("#enter_submit").click(function(e){
    e.preventDefault();
  e.stopPropagation();
  console.log('clicked enter submit');
  var clinic = document.getElementById('clinic1').value;
  var doctor = document.getElementById('doctor1').value;
  var patient = document.getElementById('patient1').value;
  var doc_type = document.getElementById('doc_type1').value;
   $.ajax({
            url: "saveimage1.php",
            type: "POST",
            data: "clinic1="+clinic+ "&doctor1="+doctor+"&patient1="+patient+"&doc_type1="+doc_type,
            async: false,
            success: function (data) {
     }       
        });
  });
});

