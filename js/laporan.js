$(document).ready(function() {
	$('#img').hide();
	$('#lap').on('keyup', function(){
		$('#img').show();
		$.get('tampilan_laporan.php?lap=' + $('#lap').val(), function(laporan){

			$('#container').html(laporan);
			$('#img').hide();

		});
	});
});