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
    <section id="form">
        <div id="form-upper-text">Login</div>
        <form action="/login" method="post">
            <div class="input-container">
                <div class="input-container_img" >
                    <img src="img/email_input_icon_64.png">
                </div>
                <input type="text" name="email" placeholder="Email" required>
            </div>

            <div class="input-container">
                <div class="input-container_img" >
                    <img src="img/password_input_icon_64.png">
                </div>
                <input type="password" name="password" placeholder="Password" required>
            </div>
    
            <input type="submit" name="submitButton" value="Login">
            <div id="already-accout">Don't have an account? <a href="/register">Sign up</a></div>
        </form>
    </section>
</div>


@endsection
