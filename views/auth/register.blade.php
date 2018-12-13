@extends('../body')

@section('content')

@if($msg) 
    <p id="message"> {{ $msg }}<p>
@endif

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

			<div class="input-container">
				<div class="input-container_img" >
					<img src="img/password_input_icon_64.png" width="20" height="20">
				</div>
				<input type="password" name="password" placeholder="Password" required>
			</div>
	        
	        <div class="input-container">
				<div class="input-container_img">
					<img src="img/password_input_icon_64.png" width="20" height="20">
				</div>
				<input type="password" name="password_repeat" placeholder="Repeat Password" required>
			</div>
	        <input type="submit" name="submitButton" value="Register">
	        <div id="already-accout">Have an account? <a href="/login">Log in</a></div>
	    </form>
    <div>
</div>

@endsection
