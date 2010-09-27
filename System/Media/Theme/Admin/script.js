$(document).ready(function(){
	$("select.actions").change(function(){
		document.location = $(this).val();
	});
});