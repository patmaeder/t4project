@extends('layouts.app')

@section('content')
<div class="container">
    <div class="accordion" id="accordionExample">

        @foreach ($semesters as $key => $semester)
        <div class="card">
            <div class="card-header" id="heading{{ $key }}">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse{{ $key }}" aria-expanded="true" aria-controls="collapse{{ $key }}">
                    {{ $key }}. Semester
                    </button>
                </h2>
            </div>

            <div id="collapse{{ $key }}" class="collapse show" aria-labelledby="heading{{ $key }}" data-parent="#accordionExample">
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="border-top-0 " style="width: 50%" >Fach</th>
                                <th class="border-top-0">Note</th>
                                <th class="border-top-0">ECTS</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($semester as $Fach => $Grades)
                            <tr>
                                <td>{{ $Fach }}</td>
                                <td>{{ $Grades['grade'] }}</td>
                                <td>{{ $Grades['ECTS'] }}</td>
                            </tr>
                            @endforeach
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr class='table-secondary'>
                                <td class="border-top-0">&nbsp</td>
                                <td class="border-top-0" id='avg'></td>
                                <td class="border-top-0" id='ECTS'></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endforeach

    </div>
    <button type="button" class="btn btn-primary mt-3" id="addSemester">Semester hinzufügen</button>
</div>

<script src="{{ asset('js/gradeOverview.js') }}"></script>
@endsection