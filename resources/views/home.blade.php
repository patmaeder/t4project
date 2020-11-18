@extends('layouts.app')

@section('content')

    <div class="container">

    @if(session()->get('success'))
    <div class="alert alert-success">
        {{session()->get('success')}}
    </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
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
});
</script>
@endsection
