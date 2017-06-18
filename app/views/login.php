<!DOCTYPE html>

<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
		
	<link rel="icon" href="#">

	<title>Login</title>

	<!-- Bootstrap core CSS -->
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
	<link href="{{@BASE}}/public/css/style.css" rel="stylesheet">	

</head>

<body>
    
    <div class="container">    
		<div class="row">
			<div id="choice">
				<button class="btn btn-lg btn-primary btn-block" type="button" id="show-login">Prijava</button>
				<button class="btn btn-lg btn-primary btn-block" type="button" id="show-register">Registracija</button>
			</div>

			<form class="form-signin" id="login" method="POST" action="{{ @BASE.@ALIASES.login }}" style="display: none;">
				<h1 class="form-signin-heading">PRIJAVA</h1>
				
				<label for="inputEmail" class="sr-only">Username</label>
				<input type="text" id="inputEmail" name="username" class="form-control" placeholder="Username" required autofocus >
				
				<label for="inputPassword" class="sr-only">Password</label>
				<input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required >
				
				<button class="btn btn-lg btn-primary btn-block" type="submit" name="login">Sign in</button>
			</form>
			
			
			
			<form class="form-register" id="register" method="POST" action="{{ @BASE.@ALIASES.register }}" style="display: none;">
				<h1 class="form-signin-heading">REGISTRACIJA</h1>
				
				<label for="inputEmail" class="sr-only">Username</label>
				<input type="text" id="inputEmail" name="username" class="form-control" placeholder="Username" required />
				
				<label for="inputPassword" class="sr-only">Password</label>
				<input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required />
				
				<label for="repeatPassword" class="sr-only">Repeat password</label>
				<input type="password" id="repeatPassword" name="repass" class="form-control" placeholder="Repeat password" required />
				
				<input type="radio" id="status-option" name="status" value="redovni" />
				<label for="status-option">Redovan</label><br>
				<input type="radio" id="status-option" name="status" value="izvanredni" />
				<label for="status-option">Izvanredan</label><br>			
				
				<button class="btn btn-lg btn-primary btn-block" type="submit" name="register">Register</button>
				
			</form>

		</div>
    </div>
	
	
	<!-- JavaScript -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>	
	<script src="{{@BASE}}/public/js/viewAuthHandler.js"></script>	
	
   
</body>
</html>
