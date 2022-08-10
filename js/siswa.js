$(document).ready(function() {
	$('#img').hide();
	$('#saya').on('keyup', function(){
		$('#img').show();
		$.get('tampilan_siswa.php?saya=' + $('#saya').val(), function(siswa){

			$('#container').html(siswa);
			$('#img').hide();

		});
	});
});