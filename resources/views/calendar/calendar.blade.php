@extends('layouts.app')

@section('content')
<style>
th {
    width: calc(100% / 7);
}

th p {
    text-align: center;
    margin-bottom: 0;
}

tbody tr {
   line-height: 80px;
   min-height: 80px;
   height: 80px;
}

tbody td {
    text-align: right;
}

.day {
    vertical-align: top;
    display: inline-block;
    line-height: normal;
}
</style>
<div class="container">

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
                <td><span id="cell_{{ $i }}{{ $a }}" class="day"></span></td>
                @endfor 

            </tr>
            @endfor
            
        </tbody>
    </table>

    <a href="{{ route('calendar.create') }}"><button type="button" class="btn btn-primary">Neuer Termin</button></a>

</div>

<script src="{{ asset('js/calendar.js') }}"></script>
@endsection