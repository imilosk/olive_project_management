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
    @php
    	$id = $auth->getUserId();
    	echo $id;
	@endphp
    <div class="container">
	    @foreach ($users as $user)
	        <p>{{ $user['email'] }}</p>
	    @endforeach
	</div>
@endsection
