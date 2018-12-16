@extends('../body')

@php
    global $auth;
@endphp

@if (!$auth->isLoggedIn())
@php 
	header('Location: /login'); 
	exit();
@endphp
@endif

@section('content')

	<header class="header-wrapper">
        @include('includes/navbar')
    </header>
    
    @foreach ($users as $user)
        <p>{{ $user['email'] }}</p>
    @endforeach

@endsection
