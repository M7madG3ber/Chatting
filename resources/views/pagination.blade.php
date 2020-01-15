<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <link rel="stylesheet" href="{{ asset('bootstrap.css') }}">
        <script src="{{ asset('bootstrap.min.js') }}" ></script>

    </head>
    <body>

    <ul class="pagination">
        {{-- Previous Page Link --}}
        @if ($messages->onFirstPage())
            <li class="page-item disabled">
                <a class="page-link" href="#" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span>
                </a>
            </li>
@else
            <li class="page-item"><a href="{{ $messages->previousPageUrl() }}" class="page-link" rel="prev">&laquo;</a></li>
@endif
<ul>
    </body>
</html>
