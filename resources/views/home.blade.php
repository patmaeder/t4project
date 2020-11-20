@extends('layouts.app')

@section('content')

    <div class="container">

    @if(session()->get('success'))
    <div class="alert alert-success">
        {{session()->get('success')}}
    </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-6">
            <div class="card" style="height: 80vh">
                <div class="card-header"><a href="{{ url('/calendar') }}">{{ __('Anstehende Termine') }}</a></div>

                <div class="card-body" style="overflow-x: hidden; overflow-y: auto">

                    @foreach ($events as $item)
                    <div class="mb-4 border-bottom" style="padding: 1.25em" >
                        <h5 class="mb-3">{{ $item->date }}</h5>
                        <h3>{{ $item->title }}</h3>
                        <p class="mb-0">{{ $item->description }}</p> 
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header"><a href="{{ url('/grades') }}">{{ __('Semesterübersicht') }}</a></div>

                        <div class="card-body d-flex justify-content-around">
                            <div id="avg" class="mt-2">
                                <h1 style="text-align: center">{{  $semesters['avg'] }}</h1>
                                <p>Notendurchschnitt</p>
                             </div>
                             <div id="ects" class="mt-2">
                                <h1 style="text-align: center">{{  $semesters['ects'] }}</h1>
                                <p>ECTS Punkte dieses Semester</p>
                             </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 mt-4" style="heigth: 100%">
                    <div class="card">
                        <div class="card-header"><a href="#">{{ __('Notizen') }}</a></div>

                        <div class="card-body">
                            <textarea name="notizen" class="border-0" style="width: 100%; resize: none">{{ $notes['0']->notes }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {

    if (document.querySelector('.alert') != null) {

        setTimeout(() => {
            document.querySelector('.alert').style.display = "none";
        }, 4000);
    }

    resizeTextfield();
});

window.addEventListener("resize", resizeTextfield());

function resizeTextfield() {
    let height = document.querySelector(".col-6 .card").offsetHeight;
    let height2 = document.querySelector(".col-12").offsetHeight;

    let textfieldheight = height - height2 - 40 - 24 - 47  - 10;
    document.querySelector("textarea").style.height = textfieldheight+"px";
}

$("textarea").on("change keyup paste", function(){
    
    let note = document.querySelector("textarea").value;
    
    let RequestBody = {};
    RequestBody["notes"] = note;

    $.ajax({
        url: "http://application.test:8000/home",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type:"PATCH",
        data: RequestBody,

        success: function(response) {}
    });
});
</script>
@endsection
