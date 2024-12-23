
@extends('admin-panel.layouts.app')
@section('content')
<div>
    <form action="{{route('csvCreator')}}" method="post" enctype="multipart/form-data">
    @csrf
    <meta name="csrf_token" content="{{ csrf_token() }}">

    <h1>file Uploader</h1>
    <input type="file" name="csv_file"></input>
    <button type="submit">button</button>
    </form>
</div>
@endsection

@push('scripts')
<script>


    </script>

@endpush
