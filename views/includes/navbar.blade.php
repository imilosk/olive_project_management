
@php
    global $auth;
@endphp

<a href="/">Home</a>

@if ($auth->isLoggedIn())
	<a href="/logout">Logout</a>
@else
	<a href="/register">Register</a>
	<a href="/login">Login</a>
	<hr/>
@endif

