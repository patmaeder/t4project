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
   line-height: 70px;
   min-height: 70px;
   height: 70px;
}
</style>
<div class="container">

    <div class="d-flex justify-content-between mb-4">
        <button type="button" class="btn btn-outline-primary glyphicon glyphicon-chevron-left"></button>
        <h2>{{ $month }}</h2>
        <button type="button" class="btn btn-outline-primary glyphicon glyphicon-chevron-right"></button>
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

            @for ($i = 0; $i < 6; $i++)
            <tr>

                @for ($a = 0; $a < 7; $a++)
                <td><span>{{ $a }}</span></td>
                @endfor 

            </tr>
            @endfor
            
        </tbody>
    </table>

    <a href="{{ route('calendar.create') }}"><button type="button" class="btn btn-primary">Neuer Termin</button></a>

</div>
@endsection