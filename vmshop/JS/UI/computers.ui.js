$(document).ready(function() {

	$(".addons_toggle").click(function() {

		var id = $(this).attr('id');

		$("#addons_" + id).toggle();
	});

});