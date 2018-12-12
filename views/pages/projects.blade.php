@extends('../body')

@section('content')
<a href="/create_project">New project</a>


<table>


<tr>
<th>Name</th>
<th>Description</th>
<th>ID organisation</th>
</tr>

    @foreach ($projects as $project)
        <tr>
        <td>{{ $project['name'] }} </td>
        <td> {{ $project['description']}}</td>
        <td> {{ $project['idOrganisation']}}</td>
        <td> <a href="/projects/delete/{{ $project['id']}}"> Delete</a></td>
        </tr>
    @endforeach
</table>
@endsection
