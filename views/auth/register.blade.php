@extends('../body')

@section('content')

    @if($msg) 
        <p id="message"> {{ $msg }}<p>
    @endif

    <form action="/register" method="post">
        <input type="email" name="email" placeholder="Email" required><br/>
        <input type="password" name="password" placeholder="Password" required><br/>
        <input type="submit" name="submitButton">
    </form>

@endsection
