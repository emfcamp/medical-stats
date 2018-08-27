<?php $title = "An Error Occurred"; ?>
@extends('layouts.app')

@section('content')
<p class="alert alert-danger">{{ $msg }}</p>
@endsection