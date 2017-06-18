<section id="redovni" class="content-section">
<div class="container">

	<h3>Upisni list: {{ @card_owner.email }}</h3>

	<form id="pdf_form" method="POST" action="{{ @BASE.@ALIASES.makePDFCard }}">

		<input type="hidden" name="userid" value="{{ @card_owner.id }}" />
		<input type="hidden" name="username" value="{{ @card_owner.email }}" />		
		<input type="submit" id="submit" name="show_pdf_card" value="PDF verzija" />	
		
	</form>
	<hr>

<div class="row">

<div class="col-lg-6">
	<div class="courses">
	
		<h4>Predmeti:</h4>
		<hr>
		
		<loop from="{{ @sem=1 }}" to="{{ @sem < 7 }}" step="{{ @sem++ }}">		

			<label><a href="{{ '#'.@sem }}" data-toggle="collapse">Semestar {{ @sem }}</a></label>
			
			<div id="{{ @sem }}" class="collapse semester">			
				<repeat group="{{ @courses }}" value="{{ @course }}">				
					<check if="{{ @course.sem_redovni == @sem }}">
					
						<div id="{{ 'course_'.@course.id }}" class="course row">
							<div class="col-lg-10">{{ @course.id }}. {{ @course.ime }}</div>
							<a href="#" id="{{@BASE}}{{ 'course_to_card', 'uid='.@card_owner.id.',cid='.@course.id | alias }}" 
										class="insertToCard btn btn-default col-lg-2">Upiši</a>
						</div>
						
					</check>
				</repeat>
			</div>
			<hr>
		</loop>
	</div>
</div>

<div class="col-lg-6">
	<div class="cardCourses">
	
	<h4>Upisi:</h4>
	<hr>
	
	<loop from="{{ @sem=1 }}" to="{{ @sem < 7 }}" step="{{ @sem++ }}">		
		<div id="{{ 'sem_'.@sem }}" class="semester">
		
			<label>Semestar {{ @sem }}</label>				
			
			<repeat group="{{ @card }}" value="{{ @card_course }}">				
				<check if="{{ @card_course.sem_redovni == @sem }}">
				
					<div id="{{ 'card-course_'.@card_course.id }}" class="card-course row">
						<div class="col-lg-8">{{ @card_course.id }}. {{ @card_course.ime }}</div>
						
						<div class="col-lg-4">
						<check if="{{ @card_course.status != 'passed' }}">
							<true>								
								<a href="#" id="{{@BASE}}{{ 'course_card_update', 'uid='.@card_owner.id.',cid='.@card_course.id | alias }}" class="makePassed toggle btn btn-default">Položio?</a>
								<a href="#" id="{{@BASE}}{{ 'course_card_remove', 'uid='.@card_owner.id.',cid='.@card_course.id | alias }}" class="deleteFromCard toggle btn btn-default">Ispiši</a>
								<a href="#" id="{{@BASE}}{{ 'course_card_update', 'uid='.@card_owner.id.',cid='.@card_course.id | alias }}" class="makeNonPassed toggle btn btn-default" style="display: none">Položeno</a>
							</true>
							<false>					
								<a href="#" id="{{@BASE}}{{ 'course_card_update', 'uid='.@card_owner.id.',cid='.@card_course.id | alias }}" class="makePassed toggle btn btn-default" style="display: none">Položio?</a>
								<a href="#" id="{{@BASE}}{{ 'course_card_remove', 'uid='.@card_owner.id.',cid='.@card_course.id | alias }}" class="deleteFromCard toggle btn btn-default" style="display: none">Ispiši</a>
								<a href="#" id="{{@BASE}}{{ 'course_card_update', 'uid='.@card_owner.id.',cid='.@card_course.id | alias }}" class="makeNonPassed toggle btn btn-default">Položeno</a>
							</false>
						</check>
						</div>						
					</div>
					
				</check>
			</repeat>
		</div>
	</loop>	
	</div>
</div>

</div>	
</div>	
</section>	