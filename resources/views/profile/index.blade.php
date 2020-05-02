@extends('layouts.app')

@section('content')
        <profile :prof="{{json_encode($profile)}}"></profile>
@endsection
