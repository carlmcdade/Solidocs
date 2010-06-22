$(document).ready(function(){
	$("select[name='url']").change(function(){
		document.location = $(this).val();
	});
		
	$(".list tbody tr td").click(function(){
		$(".list tbody tr").removeClass("active");
		$(this).parent().addClass("active");
	});
});