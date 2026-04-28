@extends('layouts.admin')
@section('page', 'Lotes')
@section('title')
    {{ Breadcrumbs::render('bajoStock') }}
@endsection

@section('content')

    @include('lotes.informacion')

@endsection