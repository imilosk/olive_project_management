@include('../includes/navbar')

@if($msg) 
    {{ $msg }}
@endif

<form action="/register" method="post">
    <input type="text" name="username" placeholder="Username" required><br/>
    <input type="password" name="password" placeholder="Password" required><br/>
    <input type="email" name="email" placeholder="Email" required><br/>
    <input type="submit" name="submitButton">
</form>
