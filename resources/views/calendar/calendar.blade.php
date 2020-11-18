@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/calendar.css') }}">
<div class="container">

    @if(session()->get('success'))
    <div class="alert alert-success">
        {{session()->get('success')}}
    </div>
    @elseif(session()->get('error'))
    <div class="alert alert-danger">
        {{session()->get('error')}}
    </div>
    @endif

    <div class="d-flex justify-content-between mb-4">
        <button type="button" class="btn btn-link" id="preceding">
            <i class="fas fa-chevron-left"></i>
        </button>
        <h2>&nbsp;</h2>
        <button type="button" class="btn btn-link" id="following">
         <i class="fas fa-chevron-right"></i>
        </button>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th><p>Montag</p></th>
                <th><p>Dienstag</p></th>
                <th><p>Mittwoch</p></th>
                <th><p>Donnerstag</p></th>
                <th><p>Freitag</p></th>
                <th><p>Samstag</p></th>
                <th><p>Sonntag</p></th>
            </tr>
        </thead>
        <tbody>

            @for ($i = 1; $i <= 6; $i++)
            <tr>

                @for ($a = 1; $a <= 7; $a++)
                <td class="day"><div class="cell_wrapper"><span>&nbsp</span></div></td>
                @endfor 

            </tr>
            @endfor
            
        </tbody>
    </table>

    <a href="{{ route('calendar.create') }}"><button type="button" class="btn btn-primary">Neuer Termin</button></a>

</div>

<script src="{{ asset('js/calendar.js') }}"></script>
@endsection