<section class="content-section">
<div class="container">
	<h3>Lista studenata</h3>
	<p>Kliknite na ime za prikaz upisnog lista!</p>
	<hr>
	
	<div class="row">
	
		<div id="redovni" class="students col-lg-6">
			<h4>Redovni studenti</h4>
			<hr>
			
			<ol>
			<repeat group="{{ @students }}" value="{{ @student }}">			
				<check if="{{ @student.status == 'redovni' }}">
					<li>					
						<a href="{{@BASE}}{{ 'studentCard', 'uid='.@student.id | alias }}">{{ @student.email}}</a>
					</li>
				</check>				
			</repeat>          
			</ol>
		</div>

		<div id="izvanredni" class="students col-lg-6">	
			<h4>Izvanredni studenti</h4>
			<hr>
			
			<ol>
			<repeat group="{{ @students }}" value="{{ @student }}">
			
				<check if="{{ @student.status == 'izvanredni' }}">				
					<li>
						<a href="{{@BASE}}{{ 'studentCard', 'uid='.@student.id | alias }}">{{ @student.email}}</a>
					</li>
				</check>				
			</repeat>  
			</ol>
			
		</div>

	</div>
</div>
</section>