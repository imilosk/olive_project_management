@extends('../body')

<title>Register</title>

@section('content')

<header>
	<div id="header-container" class="clearfix">
		<div id="header-container_logo">
			<img src="img/olive_logo_128.png">
		</div>
    	<div id="header-container_title">
    		<span class="highlighted">Olive</span><br>
    		<span>Project Management</span>
    	</div>
    </div>
</header>
<div class="container">
	<div id="form">
		<div id="form-upper-text">Register</div>
	    <form action="/register" method="post">
			<div class="input-container">
				<div class="input-container_img" >
					<img src="img/email_input_icon_64.png" width="20" height="20">
				</div>
				<input type="text" name="email" placeholder="Email" required>
			</div>
			
			@if($msg && (explode(" ", $msg)[1] == 'email' || explode(" ", $msg)[1] == 'already')) 
				<div id="message"> {{ $msg }} </div>
			@endif

			<div class="input-container">
				<div class="input-container_img" >
					<img src="img/password_input_icon_64.png" width="20" height="20">
				</div>
				<input type="password" id="password1" name="password" placeholder="Password" required>			
			</div>
			
			@if($msg && explode(" ", $msg)[1] == 'password') 
				<div id="message"> {{ $msg }} </div>	
			@endif	
	        
	        <div class="input-container">
				<div class="input-container_img">
					<img src="img/password_input_icon_64.png" width="20" height="20">
				</div>
				<input type="password" id="password2" name="password_repeat" placeholder="Repeat Password" required>
			</div>
			
			@if($msg && explode(" ", $msg)[0] == 'Passwords') 
				<div id="message"> {{ $msg }} </div>	
			@endif	
			
	        <input type="submit" name="submitButton" id="registerbutton" value="Register">
	        <div id="already-accout">Have an account? <a href="/login">Log in</a></div>
	    </form>
    <div>
</div>

<script type="text/javascript" src="js/auth.js"></script>

@endsection
