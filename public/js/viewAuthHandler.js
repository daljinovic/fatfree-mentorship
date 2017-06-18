$(window).load(function()
{
	$('#show-login').on('click', function(e)
	{		
		$('div#choice').hide();
		$('form#login').show();
	});
	
	$('#show-register').on('click', function(e)
	{		
		$('div#choice').hide();
		$('form#register').show();
	});	
});