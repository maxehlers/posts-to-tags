// My Magic
jQuery(document).ready(function($) {
	$('#ptt_filter_form select').change(function(){
		$('#ptt_filter_form').submit();
	});

	// Search form
	document.getElementById('ptt-search-input').onsearch = function(){$('#ptt-searchform').submit();}

	// Pagination Form
	var totalPages = parseInt($('.total-pages').html(), 10);
	var paginationCheckForm = function(inputField){
		var v = parseInt(inputField.val(), 10);
		if(v < 1) inputField.val(1);
		if(v > totalPages) inputField.val(totalPages);
	}
	$('.paging-input').bind('change, keydown',function(){paginationCheckForm($(this));});
	$('.ptt-pagination-form').submit(function(){paginationCheckForm($(this).find('.pading-input'));});

	// Saving the terms via AJAX
	var pttTargetTax = $('#ptt_tax').val();
	var pttTargetTerm = $('#ptt_term').val();
	var pttTargetUrl = "admin.php?page=posts-to-tags&tax=" + pttTargetTax + "&tag=" + pttTargetTerm;
	$('.ptt-checkbox').click(function(){
		var $this = $(this);
		var pttId = $this.attr('data-id');
		var pttToDo = "remove";
		if($this.attr('checked') == "checked") pttToDo = "set";
		$.post(pttTargetUrl,{
			ajax: 'true',
			postid: pttId,
			toDo: pttToDo
		}, function(data){console.log("Post " + pttId + " was performing '" + pttToDo + " with term " + pttTargetTerm); $('#message').stop().slideDown().delay(3000).slideUp();});
	});
});