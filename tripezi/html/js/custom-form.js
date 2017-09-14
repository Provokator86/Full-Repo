
$(document).ready(function() {
	
	$(".checklist input:checked").parent().addClass("selected");
	
	$(".checklist .checkbox-select").click(
		function(event) {
			event.preventDefault();
			$(this).parent().addClass("selected");
			$(this).parent().find(":checkbox").attr("checked","checked");
		}
	);
	
	$(".checklist .checkbox-deselect").click(
		function(event) {
			event.preventDefault();
			$(this).parent().removeClass("selected");
			$(this).parent().find(":checkbox").removeAttr("checked");
		}
	);


	// Pretty Radio Buttons, by Sean Foushee based on Pretty Checkboxes by Aaron Weyenberg
			
	
			
	
});





$(document).ready(function() {
	
	$(".checklist02 input:checked").parent().addClass("selected");
	
	$(".checklist02 .checkbox-select").click(
		function(event) {
			event.preventDefault();
			$(this).parent().addClass("selected");
			$(this).parent().find(":checkbox").attr("checked","checked");
		}
	);
	
	$(".checklist02 .checkbox-deselect").click(
		function(event) {
			event.preventDefault();
			$(this).parent().removeClass("selected");
			$(this).parent().find(":checkbox").removeAttr("checked");
		}
	);


	// Pretty Radio Buttons, by Sean Foushee based on Pretty Checkboxes by Aaron Weyenberg
			
	// Pretty Radio Buttons, by Sean Foushee based on Pretty Checkboxes by Aaron Weyenberg
	$("div.fst_radio").addClass("radiolist");
	$("div.radiolist .radio_box").append('<a class="radio-select" href="#">Select</a><a class="radio-deselect" href="#">Cancel</a>');
	
	// code from here on is the same as Aaron Weyenberg
	$(".radiolist .radio-select").click(
		function(event) {
			event.preventDefault();
			var $boxes = $(this).parent().parent().children();
			$boxes.removeClass("selected");
			$(this).parent().addClass("selected");
			$(this).parent().find(":radio").attr("checked","checked");
		}
	);
	
	$(".radiolist .radio-deselect").click(
		function(event) {
			event.preventDefault();
			$(this).parent().removeClass("selected");
			$(this).parent().find(":radio").removeAttr("checked");
		}
	);
	
	
	// Pretty Radio Buttons, by Sean Foushee based on Pretty Checkboxes by Aaron Weyenberg
	$("div.fst_radio").addClass("radiolist02");
	$("div.radiolist02 .radio_box").append('<a class="radio-select" href="#">Select</a><a class="radio-deselect" href="#">Cancel</a>');
	
	// code from here on is the same as Aaron Weyenberg
	$(".radiolist02 .radio-select").click(
		function(event) {
			event.preventDefault();
			var $boxes = $(this).parent().parent().children();
			$boxes.removeClass("selected");
			$(this).parent().addClass("selected");
			$(this).parent().find(":radio").attr("checked","checked");
		}
	);
	
	$(".radiolist02 .radio-deselect").click(
		function(event) {
			event.preventDefault();
			$(this).parent().removeClass("selected");
			$(this).parent().find(":radio").removeAttr("checked");
		}
	);
	
});

	
