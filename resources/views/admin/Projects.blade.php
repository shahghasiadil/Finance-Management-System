@extends('layouts.admin')

@section('content')

<project-component
locale="{{ app()->getLocale() }}"></project-component>

@endsection