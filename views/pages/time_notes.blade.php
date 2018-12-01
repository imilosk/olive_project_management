@extends('../body')

@section('content')
    <h1>Time note<h1/>

    <select class="custom-select">
    <option selected>Open this select menu</option>
    <option value="1">One</option>
    <option value="2">Two</option>
    <option value="3">Three</option>
    </select>

    <h4>Plan:</h4>
    <div class="form-group">
        <label class="control-label">Time</label>
        <input placeholder="Time" name="time_plan" class="form-control" />
    </div>
    <div class="form-group">
        <label class="control-label">Units</label>
        <input placeholder="Units, LOC" name="units_plan" class="form-control" />
    </div>
    <br/>
    <h4>Majnka mi angkeščina(Dejanski rezultati):</h4>
    <div class="form-group">
        <label class="control-label">Time</label>
        <input placeholder="Time" name="time"  class="form-control" />
    </div>
    <div class="form-group">
        <label class="control-label">Units</label>
        <input placeholder="Units, LOC" name="units" class="form-control" />
    </div>
    <div class="form-group">
        <label class="control-label">Units</label>
        <input type="date" placeholder="Units, LOC" name="units" class="form-control" />
    </div>

    <table>
    <thead>
    <tr>
    <th>Date</th>
    <th>Opravilo</th>
    <th>Time</th>
    <th>Units</th>
    </tr>
    <thead>
    <tbody>
        <tr>
        </tr>
    </tbody>
    </table>

@endsection