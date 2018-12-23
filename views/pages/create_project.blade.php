
@extends('../body')

@section('content')

<form action="/create_project" method="post">
    <div class="form-group">
        <input type="text" name="name" class="form-control" placeholder="Name">
    </div>
    <div class="form-group">
        <textarea class="form-control" name="description"></textarea>
    </div>

    <div class="form-group">
        <select name="organisation">
            @foreach ($organisations as $organisation)
                <option value="{{ $organisation['id'] }}">  {{ $organisation['name']}}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <button type="submit" name="submitButton" class="btn btn-login">Create project</button>
    </div>
</form>

@endsection