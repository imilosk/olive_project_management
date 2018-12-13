@extends('../body')

@section('content')

	<header class="header-wrapper">
        @include('includes/navbar')
    </header>
    
    @foreach ($users as $user)
        <p>{{ $user['email'] }}</p>
    @endforeach

@endsection
