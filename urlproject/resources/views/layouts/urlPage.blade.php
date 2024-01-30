@extends('layouts.app')

@section('content')
    <div class="container ms-lg-5-5-5">

        <div class="card">
            @if (session('error_message'))
                <div class="error-message alert alert-danger mx-auto" role="alert">
                    {{ session('error_message') }}
                </div>
            @endif
            <div class="card-header">
                Links
            </div>
            <div class="card-body  mx-auto">
                @foreach ($url as $url)
                    <h5 class="card-title">URL Title</h5>
                    <p class="card-text">{{ $url->title }}</p>
                    @if (session('error_message'))
                        <a href="http://127.0.0.1:8000/{{ $url->shortened_url }}" class="btn btn-primary mx-auto disabled" disabled>Visit the
                            URL</a>
                    @else
                        <a href="http://127.0.0.1:8000/{{ $url->shortened_url }}" class="btn btn-primary mx-auto">Visit the
                            URL</a>
                    @endif
                @endforeach

            </div>
        </div>
    </div>
@endsection
