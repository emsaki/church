@extends('adminlte::page')

@section('title', 'Tithe Reports (Priest)')

@section('content_header')
    <h1 class="font-weight-bold text-primary">
        <i class="fas fa-church"></i> Tithe Reports – Parishes
    </h1>
@stop

@section('content')

<div class="row">
@if($parish)
    <div class="col-md-4">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ number_format($parish->tithes_sum_amount) }} Tsh</h3>
                <p>{{ $parish->name }}</p>
            </div>
            <a href="{{ route('priest.tithes.parish', $parish->id) }}" 
               class="small-box-footer">
                View Parish Report <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
@else
    <div class="alert alert-warning">No parish assigned to this priest.</div>
@endif
</div>

@stop
