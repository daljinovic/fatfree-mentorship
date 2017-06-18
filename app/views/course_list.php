<section class="content-section">
<div class="courses container">

	<h3>Lista predmeta</h3>
	
	<a href="{{ @BASE.@ALIASES.course_add }}">Dodaj novi predmet</a>
	<hr>
	
	<ol>
		<repeat group="{{ @courses }}" value="{{ @course }}">		
			<li>
				{{ @course.ime }}
				<a href="{{ '#'.@course.id }}" data-toggle="collapse">detalji</a>				
				<a href="{{@BASE}}{{ 'course_edit', 'cid='.@course.id | alias }}">izmijeni</a>

				<div id="{{ @course.id }}" class="collapse">
					<hr>
					<p> <label>Kod: </label> {{ @course.kod }}</p>
					<p> <label>Program: </label> {{ @course.program }}</p>
					<p> <label>ECTS: </label> {{ @course.bodovi }}</p>
					<p> <label>Semestar redovni: </label> {{ @course.sem_redovni }}</p>
					<p> <label>Semestar izvanredni: </label> {{ @course.sem_izvanredni }}</p>
					<p> <label>Izborni: </label> {{ @course.izborni }}</p>
				</div>
			</li>			
			<hr>
		</repeat>
	</ol>	

</div>
</section>