@extends('../body')

@section('content')

<h1>Mistakes</h1>

  <h4>New mistake:</h4>
  <div class="form-group">
      <label class="control-label">Time for resolve:</label>
      <input placeholder="Time" name="time_plan" class="form-control" />
  </div>
  <select class="custom-select">
    <option selected>Faza najdbe</option>
    <option value="1">One</option>
    <option value="2">Two</option>
    <option value="3">Three</option>
  </select>

  <select class="custom-select">
    <option selected>Faza odprave</option>
    <option value="1">One</option>
    <option value="2">Two</option>
    <option value="3">Three</option>
  </select>




  <table>
  <thead>
  <tr>
  <th>Date</th>
  <th>Faza najdbe</th>
  <th>Faza odprave</th>
  <th>Time for resolve:</th>
  </tr>
  <thead>
  <tbody>
      <tr>
      </tr>
  </tbody>
  </table>

@endsection
