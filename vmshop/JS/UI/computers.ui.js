$(document).ready(function() {

	$(".addons_toggle").click(function() {

		var id = $(this).attr('id');

		$("#addons_" + id).toggle();
	});

	$(".addon_form_toggle").click(function() {

		var id = $(this).val();
		var html = $(this).html();

		if(html == "Přidat dodatek ▼")
			$(this).html("Přidat dodatek &#9650;");
		else
			$(this).html("Přidat dodatek &#9660;");

		$("#addon_form_" + id).toggle();
	});

});