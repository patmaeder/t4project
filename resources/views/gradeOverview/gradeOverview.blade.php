@extends('layouts.app')

@section('content')
<style>
.color {
    color: #555;
    cursor: pointer;
}
</style>
<div class="container">
    <div class="accordion" id="accordionExample">

        @foreach ($semesters as $key => $semester)
        <div class="card">
            <div class="card-header" id="heading{{ $key }}">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse{{ $key }}" aria-expanded="true" aria-controls="collapse{{ $key }}" onclick="hideInput()">
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
                                <th class="border-top-0" style="width: 23%" >Note</th>
                                <th class="border-top-0" style="width: 23%">ECTS</th>
                                <th class="border-top-0" style="width:4%"></th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($semester as $Index)
                                @foreach ($Index as $Fach => $Grades)
                                <tr id="{{ $Grades['id'] }}">
                                    <td onclick="editSubject()">{{ $Fach }}</td>
                                    <td class="grade" onclick="editSubject()">{{ $Grades['grade'] }}</td>
                                    <td class="ects" onclick="editSubject()">{{ $Grades['ECTS'] }}</td>
                                    <td>
                                       <i class="fas fa-times color" onclick="deleteSubject()"></i>
                                    </td>
                                </tr>
                                @endforeach
                            @endforeach
                            <tr class="divider">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr class='summary'>
                                <td class="border-top-0">&nbsp</td>
                                <td class="border-top-0" id='avg'></td>
                                <td class="border-top-0" id='ECTS'></td>
                                <td class="border-top-0"></td>
                            </tr>
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-primary mt-3" id="{{ $key }}" onclick="createNewSubject()">Neues Fach hinzufügen</button>
                </div>
            </div>
        </div>
        @endforeach

    </div>
    <button type="button" class="btn btn-primary mt-3" id="addSemester" onclick="createNewSemester()">Semester hinzufügen</button>
</div>

<script src="{{ asset('js/gradeOverview.js') }}"></script>
@endsection