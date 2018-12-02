@extends('../body')

@section('content')
<a href="/create_project">New project</a>


<table>


<tr>
<th>Name</td>
<th>Description</td>
<th>ID organisation</td>
<tr>

    @foreach ($projects as $project)
        <tr>
        <td>{{ $project['name'] }} </td>
        <td> {{ $project['description']}}</td>
        <td> {{ $project['idOrganisation']}}</td>
        </tr>
    @endforeach
</table>
@endsection
