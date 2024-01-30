@extends('layouts.app')

@section('content')
    <div class="container ms-lg-5-5-5">
        @if(isset($successMessage))
        <div class="alert alert-success" id="successMessage">
            {{ $successMessage }}
        </div>

        <script>
            setTimeout(function() {
                document.getElementById('successMessage').style.display = 'none';
            }, 5000);
        </script>
    @endif
        <form action="{{ route('storeUrl') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Title</label>
                <input type="text" class="form-control" name="title" id="exampleInputEmail1" aria-describedby="emailHelp">
                @error('title')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3 ">
                <label for="exampleInputEmail1" class="form-label">Orginal Url</label>
                <input type="text" class="form-control" name="original_url" id="exampleInputEmail1">
                @error('original_url')
                    <div class="text-danger">{{ $message }}</div>
                @enderror

                <div class="text-center mt-4 mb-5">
                    <button type="submit" class="btn btn-primary btn-lg mx-auto">Store Link</button>
                </div>
        </form>


    </div>


@endsection
