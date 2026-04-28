@extends('layouts.admin')
@section('page', 'Lotes')
@section('title')
    {{ Breadcrumbs::render('vencidos') }}
@endsection

@section('content')

    @include('lotes.informacion')
    
@endsection