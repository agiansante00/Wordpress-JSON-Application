jQuery(document).ready(function($){
	
	$.post(ajaxurl, {
		
		
		action: 'pgnyt_articles_refresh_results'
		
	}, function( responce ){
		console.log ( 'AJAX complete' );
	});
	
});