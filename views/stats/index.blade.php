@extends('layouts.stats')

@section('content')
  <h1>Medical Statistics</h1>

  <form action="stats.php" method="POST">
    <div class="form-group row">
      <label for="eventTitle" class="col-sm-2 col-form-label">Event Title</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="eventTitle" name="eventTitle">
      </div>
    </div>

    <div class="form-group row">
      <label for="eventStart" class="col-sm-2 col-form-label">Event Dates</label>
      <div class="col-sm-5">
        <input type="text" class="form-control datepicker" id="eventStart" name="eventStart" placeholder="start">
      </div>
      <div class="col-sm-5">
        <input type="text" class="form-control datepicker" id="eventEnd" name="eventEnd" placeholder="end">
      </div>
    </div>

    <div class="form-group row">
      <label for="currentEventLabel" class="col-sm-2 col-form-label">Current Event</label>
      <div class="col-sm-3">
        <input type="text" class="form-control" id="currentEventLabel" name="currentEventLabel" placeholder="2018">
      </div>
      <div class="col-sm-7">
        <input type="text" class="form-control" id="currentEventPath" name="currentEventPath" placeholder="path/to/event/data">
      </div>
    </div>

    <div class="form-group row">
      <label for="previousEventLabel" class="col-sm-2 col-form-label">Previous Event</label>
      <div class="col-sm-3">
        <input type="text" class="form-control" id="previousEventLabel" name="previousEventLabel" placeholder="2016">
      </div>
      <div class="col-sm-7">
        <input type="text" class="form-control" id="previousEventPath" name="previousEventPath" placeholder="path/to/event/data">
      </div>
    </div>
    
    <button type="submit" class="btn btn-primary" name="go">Go</button>
  </form>
@endsection

@section('graph-data')

@endsection