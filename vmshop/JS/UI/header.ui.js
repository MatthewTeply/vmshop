$(document).ready(function() {

	var isToggled_notifications = false;
	var isToggled_users = false;

	$("#notification_toggle").click(function() {

		if(isToggled_notifications == false) {

			$(this).attr('class', "fa fa-bell");
			isToggled_notifications = true;
		}

		else {

			$(this).attr('class', "fa fa-bell-o");
			isToggled_notifications = false;
		}

		$("#users_toggle").attr('class', "fa fa-user-o");
		$("#users_div").hide();
		isToggled_users = false;

		$("#notification_div").toggle();
	});

	$("#users_toggle").click(function() {

		if(isToggled_users == false) {

			$(this).attr('class', "fa fa-user");
			isToggled_users = true;
		}

		else {

			$(this).attr('class', "fa fa-user-o");
			isToggled_users = false;
		}

		$("#notification_toggle").attr('class', "fa fa-bell-o");
		$("#notification_div").hide();
		isToggled_notifications = false;

		$("#users_div").toggle();
	});

});