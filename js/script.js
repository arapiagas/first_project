$(document).ready(function() {
	$('#img').hide();
	$('#keyword').on('keyup', function(){
		$('#img').show();
		$.get('tampilan_petugas.php?keyword=' + $('#keyword').val(), function(data){

			$('#container').html(data);
			$('#img').hide();

		});
	});
});