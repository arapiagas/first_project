$(document).ready(function() {
	$('#img').hide();
	$('#word').on('keyup', function(){
		$('#img').show();
		$.get('tampilan_spp.php?word=' + $('#word').val(), function(spp){

			$('#container').html(spp);
			$('#img').hide();

		});
	});
});