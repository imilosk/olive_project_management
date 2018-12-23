@extends('../body')

@section('content')

<header class="header-wrapper">
    @include('includes/navbar')
</header>

<a href="/create_project">New organisation</a>


<table>


<tr>

<th>ID organisation</th>
<th>Organisation</th>
<th></th>
</tr>

    @foreach ($organisations as $org)
        <tr>
        <td> {{ $org['id']}}</td>
        <td>{{ $org['name'] }} </td>
        <td> <a href="/organisation/{{ $org['id']}}">Manage users</a></td>
        </tr>
    @endforeach
</table>
@endsection
