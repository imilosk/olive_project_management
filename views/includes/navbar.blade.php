<script src="~/public/js/jquery-3.3.1.js"></script>
<script src="~/public/js/bootstrap.js"></script>

<link rel="stylesheet" href="~/public/css/bootstrap.css" />

@php
    global $auth;
@endphp

<a href="/">Home</a>

@if ($auth->isLoggedIn())

	<a href="/timeNotes">Time Notes</a>
	<a href="/Mistakes">Mistakes</a>
	<a href="/logout">Logout</a>
@else
	<a href="/register">Register</a>
	<a href="/login">Login</a>
	<hr/>
@endif

