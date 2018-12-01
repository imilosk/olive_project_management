@extends('../body')

@section('content')

    @foreach ($users as $user)
        <p>{{ $user['email'] }}</p>
    @endforeach

@endsection
