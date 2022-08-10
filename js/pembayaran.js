$(document).ready(function() {
	$('#img').hide();
	$('#kw').on('keyup', function(){
		$('#img').show();
		$.get('tampilan_pembayaran.php?kw=' + $('#kw').val(), function(pembayaran){

			$('#container').html(pembayaran);
			$('#img').hide();

		});
	});
});