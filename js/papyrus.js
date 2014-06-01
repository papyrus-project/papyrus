function favorise($master){
	$.ajax({
	  type: "POST",
	  url: "/ajax/FavoriseBook",
	  data: { book: $master}
	})
	  .done(function( msg ) {
	    console.log( msg );
	  });
}
