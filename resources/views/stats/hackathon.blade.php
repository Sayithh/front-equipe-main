<?php
@extends('layouts.app')

@section('title', ' - Statistiques du Hackathon')

@section('content')
<div class="container py-4">
    <h1 class="mb-4 text-center">{{ $hackathon->thematique }}</h1>
    <div class="row">
        <div class="col-md-6">
            <div id="equipesChart"></div>
        </div>
        <div class="col-md-6">
            <div id="participantsChart"></div>
        </div>
    </div>
</div>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script>
    Highcharts.chart('equipesChart', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Nombre d\'équipes'
        },
        xAxis: {
            categories: ['Équipes']
        },
        yAxis: {
            title: {
                text: 'Nombre'
            }
        },
        series: [{
            name: 'Équipes',
            data: [{{ $equipes }}]
        }]
    });

    Highcharts.chart('participantsChart', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Nombre de participants'
        },
        xAxis: {
            categories: ['Participants']
        },
        yAxis: {
            title: {
                text: 'Nombre'
            }
        },
        series: [{
            name: 'Participants',
            data: [{{ $participants }}]
        }]
    });
</script>
@endsection