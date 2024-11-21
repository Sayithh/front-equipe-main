
@extends('layouts.app')

@section('title', ' - Statistiques Publiques')

@section('content')
<div class="container py-4">
    <h1 class="mb-4 text-center">Statistiques Publiques</h1>
    <div class="row">
        <div class="col-md-4">
            <div id="totalHackathonsChart"></div>
        </div>
        <div class="col-md-4">
            <div id="totalEquipesChart"></div>
        </div>
        <div class="col-md-4">
            <div id="totalMembresChart"></div>
        </div>
    </div>
</div>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script>
    Highcharts.chart('totalHackathonsChart', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Nombre total de Hackathons'
        },
        xAxis: {
            categories: ['Hackathons']
        },
        yAxis: {
            title: {
                text: 'Nombre'
            }
        },
        series: [{
            name: 'Hackathons',
            data: [{{ $totalHackathons }}]
        }]
    });

    Highcharts.chart('totalEquipesChart', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Nombre total d\'équipes'
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
            data: [{{ $totalEquipes }}]
        }]
    });

    Highcharts.chart('totalMembresChart', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Nombre total de membres'
        },
        xAxis: {
            categories: ['Membres']
        },
        yAxis: {
            title: {
                text: 'Nombre'
            }
        },
        series: [{
            name: 'Membres',
            data: [{{ $totalMembres }}]
        }]
    });
</script>
@endsection