@extends('layouts.main')

@section('title')
    Ветки
@endsection

@section('content')

    <div class="comments-wrapper">

        @foreach($branches as $item)


            <div class="white-box" style="padding: 20px 25px;">
                <a href="/comment/branch/{{ $item->branch }}" class="date-time">{{ $item->created_at }}</a>
            </div>

        @endforeach

    </div>

@endsection

