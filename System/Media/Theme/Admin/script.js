$(document).ready(function(){
	$("select[name='url']").change(function(){
		document.location = $(this).val();
	});
});