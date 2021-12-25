@extends('layouts.admin')

@section('content')

<user-component
locale="{{ app()->getLocale() }}"></user-component>

@endsection