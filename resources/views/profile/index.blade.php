@extends('layouts.app')

@section('content')
        <profile :prof="{{json_encode($profile)}}" :auth-user="{{json_encode($authProfile)}}"></profile>
@endsection
