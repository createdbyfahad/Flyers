function disable_field(element)
{
	var element = $(element);

	if(element.is(':disabled')){
		element.prop('disabled', false);
		return false;
	}else{
		element.val('');
		element.prop('disabled', true);
		return false;
	}
}

$('button.close').on('click', function(){
	return $(this).parent().remove();
})
