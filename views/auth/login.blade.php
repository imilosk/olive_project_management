@extends('../body')

<title>Login</title>

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
    <section id="form">
        <div id="form-upper-text">Login</div>
        <form action="/login" method="post">
            <div class="input-container">
                <div class="input-container_img" >
                    <img src="img/email_input_icon_64.png">
                </div>
                <input type="text" name="email" placeholder="Email" required>
            </div>
			
			@if($msg && (explode(" ", $msg)[1] == 'email' || explode(" ", $msg)[1] == 'not')) 
				<div id="message"> {{ $msg }} </div>
			@endif

            <div class="input-container">
                <div class="input-container_img" >
                    <img src="img/password_input_icon_64.png">
                </div>
                <input type="password" name="password" placeholder="Password" required>
            </div>
			
			@if($msg && explode(" ", $msg)[1] == 'password') 
				<div id="message"> {{ $msg }} </div>	
			@endif
    
            <input type="submit" name="submitButton" value="Login">
            <div id="already-accout">Don't have an account? <a href="/register">Sign up</a></div>
        </form>
    </section>
</div>

@endsection
