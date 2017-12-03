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

		//alert("id : " + id + "\nname : " + task_name);
	
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

});