<section class="content-section">
	<div class="container">
	
		<h3>{{ @course ? 'Izmjena' : 'Dodavanje' }} predmeta</h3>
		<hr>
		
		<check if="{{ @course }}">
			<true>
				<form class="course" method="POST" action="{{ @BASE.@ALIASES.course_edit }}">
			</true>
			<false>
				<form class="course" method="POST" action="{{ @BASE.@ALIASES.course_add }}">
			</false>
		</check>
			
			<label class="control-labele">Naziv:</label>
			<input type="text" class="form-control" name="ime" value="{{ @course.ime }}">
			
			<label class="control-labele">Kod:</label>
			<input type="text" class="form-control" name="kod" value="{{ @course.kod }}">
			
			<div class="textarea-input">
				<label class="control-label">Program:</label>
				<textarea rows="4" cols="50" class="form-control" name="program">{{ @course.program }}</textarea>
			</div>
			
			<label class="control-label">ECTS:</label>
			<input type="text" class="form-control" name="bodovi" value="{{ @course.bodovi }}">
			
			<label class="control-label">Semestar redovni:</label>
			<input type="text" class="form-control" name="sem_redovni" value="{{ @course.sem_redovni }}">
			
			<label class="control-label">Semestar izvanredni:</label>
			<input type="text" class="form-control" name="sem_izvanredni" value="{{ @course.sem_izvanredni }}">
		
			<label class="control-label">Izborni?</label>
			<input type="text" class="form-control" name="izborni" value="{{ @course.izborni }}">
			
			<hr>
			
			<input type="submit" id="submit" name="{{ @course ? 'edit_course' : 'add_course'}}" value="Gotovo">
			<input type="submit" id="submit" name="cancel" value="Odustani">

		</form>

	</div>
</section>