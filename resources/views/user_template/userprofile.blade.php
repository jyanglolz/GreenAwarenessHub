@extends('user_template.layouts.user_profile_template')
@section('profilecontent')
<h2>Dashboard</h2> 
<p>welcome,{{Auth::user()->name}}</p>
@endsection