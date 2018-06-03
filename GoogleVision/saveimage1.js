$("#submit1").click(function(e){
  		e.preventDefault();
		e.stopPropagation();
		var clinic = document.getElementById('clinic1').value;
		var doctor = document.getElementById('doctor1').value;
		var patient = document.getElementById('patient1').value;
		var doc_type = document.getElementById('doc_type1').value;
		 $.ajax({
            url: "saveimage1.php?",
            type: "POST",
            data: "clinic1="+clinic1+ "&doctor1="+doctor1+"&patient1="+patient1+"&doc_type1="+doc_type1,
            async: false,
            success: function (data) {
	           
        });
  });