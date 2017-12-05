$(document).ready(function() {

	//GET
	function ajax_getComputer(id_data, opt_data, element) {

		$.ajax({

			method: "POST",
			url: "computers.inc.php",
			data: {getComputer_call:true, id:id_data, opt:opt_data},
			success: function(response) {

				console.log(response);

				if(opt_data == "latest")
					$("#" + element).append(response);
				else
					$("#" + element).html(response);
			}
		});
	}

	//UPDATE
	$(".task_done").click(function() {

		var info = $(this).attr('id').split("-");
		var id = info[0];
		var task_name = info[1];

		$.ajax({

			method: "POST",
			url: "computers.inc.php",
			data: {updateComputer_call:true, id, task_name},
			success: function(response) {

				if(response == 1)
					$("#computer_" + id).addClass("computer_finished");
				else
					$("#computer_" + id).removeClass("computer_finished");
			}
		});
	});

	//HIDE
	$(".hideComputer").click(function() {

		var id = $(this).val();

		$.ajax({

			method: "POST",
			url: "computers.inc.php",
			data: {toggleComputer_call:true, id},
			success: function(response) {

			}
		});

		$("#computer_contents_" + id).toggle();
	});
	
	//GET NOTIFICATIONS

	var init_number_send = $("#notifications_number").val();
	var init_number_notify = init_number_send;

	var number_notify = init_number_notify;

	console.log(init_number_send);

	$("#notification_toggle").click(function() {

		number_notify = init_number_notify;
		$("#notification_new").html("");
	});

	setInterval(function() {

		$.ajax({

			method: "POST",
			url: "computers.inc.php",
			data: {getNotificationsNumber_call:true, number:init_number_notify},
			success: function(response) {


				if(response > 0) {
					init_number_notify = parseInt(init_number_notify) + parseInt(response);
					$("#notification_new").html(init_number_notify - number_notify);
					console.log(response);
				}

				else
					init_number_notify = parseInt(init_number_notify) + parseInt(response);
				
				console.log("Response : " + response);
			} 
		});

		$.ajax({

			method: "POST",
			url: "computers.inc.php",
			data: {getNotifications_call:true, opt:"call", number:init_number_send},
			success: function(response) {

				$("#notification_div_content_new").html(response);
			}
		});

	}, 5000)

});