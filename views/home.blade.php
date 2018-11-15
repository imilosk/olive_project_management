@foreach ($users as $user)
    <p>{{ $user['username'] }}</p>
@endforeach

<form action="/api/user" method="POST">
    <input type="text" name="username" placeholder="Title" required >

    <input type="submit" >
</form>