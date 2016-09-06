$('.button').click(function() {

	 $.ajax({
	  type: "POST",
	  url: "userdb_control.php",
	  data: { password: "Alex" }
	}).done(function( msg ) {
	  alert( "Data Saved: " + msg );
	});    

    });