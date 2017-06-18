$(window).load(function()
{
	var re = new RegExp(/^.*\//);
	var base = re.exec(location.pathname);		
		
	$('.semester').on('click', 'a.insertToCard', function(e)
	{
		e.preventDefault();		
		$.ajax(
		{
			type: 'get',
			url: $(this).attr('id'),
			async: false,
			dataType: 'json',
			success: function(course)
			{
				var html = '<div class="card-course row" id="card-course_'+course.id+'">';
				html += '<div class="col-lg-8">'+course.id+': '+course.ime+'</div>';
				html += '<div class="col-lg-4">';
				html += '<a href="#" id="'+base+'update/'+course.uid+'/'+course.id+'" class="makePassed toggle btn btn-default">Položio?</a>';
				html += '<a href="#" id="'+base+'remove/'+course.uid+'/'+course.id+'" class="deleteFromCard toggle btn btn-default">Ispiši</a>';
				html += '<a href="#" id="'+base+'update/'+course.uid+'/'+course.id+'" class="makeNonPassed toggle btn btn-default" style="display: none">Položeno</a>';
				html += '</div></div>';
				
				$('div#sem_'+course.sem).append(html);				
				$('div#course_'+course.id).hide();				
			},
			fail: function(jqXHR, status, error)
			{
				alert('error: '+jqXHR.responseText+status+error);
			}
		});
		return false;
	});
	
	
	
	$('.semester').on('click', 'a.deleteFromCard', function(e)
	{
		e.preventDefault();		
		$.ajax(
		{
			type: 'get',
			url: $(this).attr('id'),
			async: false,
			dataType: 'json',
			success: function(course)
			{			
				$("div#card-course_"+course.id).remove();				
				
				if($("div#course_"+course.id).length > 0)
					$("div#course_"+course.id).show();
				else{
					var html = '<div id="course_'+course.id+'" class="course row">';
					html += '<div class="col-lg-10">'+course.id+': '+course.ime+'</div>';
					html += '<a href="#" id="'+base+'add/'+course.uid+'/'+course.id+'" class="insertToCard btn btn-default col-lg-2">Upiši</a>';
					html += '</div>';
					
					$('div#'+course.sem).append(html);
				}
			},
			error: function(jqXHR, status, error)
			{
				alert('error: '+jqXHR.responseText+status+error);
			}
		});
		return false;
	});
	
	
	
	
	$('.semester').on('click', 'a.makePassed', function(e)
	{
		e.preventDefault();		
		$.ajax(
		{
			type: 'get',
			url: $(this).attr('id'),
			async: false,
			dataType: 'json',
			success: function(course)
			{					
				$("div#card-course_"+course.id+" .toggle").toggle();
			},
			error: function(jqXHR, status, error)
			{
				alert('error: '+jqXHR.responseText+status+error);
			}
		});
		return false;
	});
	
	
	
	$('.semester').on('click', 'a.makeNonPassed', function(e)
	{
		e.preventDefault();		
		$.ajax(
		{
			type: 'get',
			url: $(this).attr('id'),
			async: false,
			dataType: 'json',
			success: function(course)
			{					
				$("div#card-course_"+course.id+" .toggle").toggle();
			},
			error: function(jqXHR, status, error)
			{
				alert('error: '+jqXHR.responseText+status+error);
			}
		});
		return false;
	});
	
	
});