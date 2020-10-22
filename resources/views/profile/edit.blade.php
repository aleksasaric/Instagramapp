@extends('layouts.app')

@section('content')
    <profile-edit :prof="{{json_encode($profile)}}"></profile-edit>
@endsection
