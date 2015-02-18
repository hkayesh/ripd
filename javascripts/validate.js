// JavaScript Document
$(document).ready(function(){
	// validate signup form on keyup and submit
	var validator = $("#std_info_form").validate({
		rules: {
			std_id: {
				required: true,
				minlength: 9
			},
			std_name: {
				required: true,
				minlength: 4
			},
			check: {
				required: true,
			},
			dept: {
				required: true,
			},
			course: {
				required: true,
				minlength:2
			},
			room: {
				required: true,
			},
			std_photo: {
				required: true,
			},
			f_name: {
				required: true,
			},
			m_name: {
				required: true,
			},
			pre_address: {
				required: true,
			},
			par_address: {
				required: true,
			},
			p_contact: {
				required: true,
			},
			std_contact: {
				required: true,
			},
		},
		messages: {
			std_id: {
				required: "Please enter your student ID",
				minlength: jQuery.format("Your student ID needs to be at least {9} characters")
			},
			std_name: {
				required: "Please enter your name",
				minlength: "Your name needs to be at least {0} characters"
			},
			check: {
				required: "You must mention your gender!",
				minlength: jQuery.format("Check one checkbox only")
			},
			dept: {
				required: "You must select your depertment!",
				minlength: jQuery.format("Select your depertment")
			},
			course: {
				required: "enter your course no.!",
				minlength: jQuery.format("course no. needs to be at least {0} characters")
			},
			room: {
				required: "choose a room!",
			},
			std_photo: {
				required: "Student's photo should be attached",
			},
			f_name: {
				required: "Enter Student's Father name",
			},
			m_name: {
				required: "Enter Student's Mother name",
			},
			pre_address: {
				required: "Enter present address of student",
			},
			par_address: {
				required: "Enter student's parmenent address",
			},
			p_contact: {
				required: "Parent's contact no. is required",
			},
			std_contact: {
				required: "Enter student's contact no. ",
			},
		},
		// set this class to error-labels to indicate valid fields
		success: function(label) {
			label.addClass("checked");
		}
	});
});