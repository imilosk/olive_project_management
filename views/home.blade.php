@include('includes/navbar')

@foreach ($users as $user)
    <p>{{ $user['username'] }}</p>
@endforeach
