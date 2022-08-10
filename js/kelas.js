$(document).ready(function() {
	$('#i').hide();
	$('#key').on('keyup', function(){
		$('#i').show();
		$.get('tampilan_kelas.php?key=' + $('#key').val(), function(database){

			$('#container').html(database);
			$('#i').hide();

		});
	});
});