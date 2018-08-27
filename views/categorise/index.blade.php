@extends('layouts.app')

@section('content')
  <form action="categorise.php" method="POST">
    <div class="form-group" >
      <label for="path">Path</label>
      <input type="text" class="form-control" id="path" name="path" value="{{ $path }}">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
@endsection