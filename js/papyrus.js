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


//chosen initalisieren
var config = {
  '.chosen-select'           : {},
  '.chosen-select-deselect'  : {allow_single_deselect:true},
  '.chosen-select-no-single' : {disable_search_threshold:10},
  '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
  '.chosen-select-width'     : {width:"95%"}
};
for (var selector in config) {
  $(selector).chosen(config[selector]);
}