@extends('layouts.main')

@section('title')
    Отзывы
@endsection

@section('content')
    <div class="comments-wrapper">

        <div class="white-box">

            @foreach($comments as $i => $item)

                <div id="{{ $item->branch  }}" class="comment-wrapper" @if($item->answer !== 0) style="margin-left: 50px;"  @endif>

                    <div class="comment" id="comment-{{ $item->id }}">
                        <div class="user-img"><img src="{{ asset('images/users/default.svg') }}"></div>
                        <div class="content-comment">
                            @if($item->description !== "Комментарий удален" && Auth::user()->name == $item->name)
                                <div class="actions">
                                    <button class="edit" onclick="showedit(this)"></button>
                                    <button class="delete" onclick="deletecomment(this)"></button>
                                </div>
                            @endif
                            <h5>{{ $item->name }}</h5>
                            <span class="date-time">{{ $item->created_at }}</span>
                            <span class="description">{{ $item->description }}</span>
                            @if($item->description !== "Комментарий удален")
                                <div class="your-rating">
                                    <span>Рейтинг:</span>
                                    <span>
                                        <select class="add-rating" id="rating-{{ $item->id }}" name="rating" data-current-rating="{{ $item->rating }}" autocomplete="off">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach

                <div class="panel" style="display: block">
                    <div class="write-wrapper">
                        <div class="user-img"><img src="{{ asset('images/users/default.svg') }}"></div>
                        <div class="answer">
                            <input class="description textarea" placeholder="Ваше сообщение..." onchange="insert(this)">
                        </div>
                    </div>
                </div>
         </div>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript">

        function insert(obj)
        {
            var text = $(".textarea").val();

            var branch = $(obj).parents(".white-box").children(".comment-wrapper").attr("id");

            $.ajax
            ({
                type: 'POST',
                url: '/comment/insert',
                data: {'branch' : branch, 'message' : text, '_token': $('meta[name="csrf-token"]').attr('content')},
                success: function(data)
                {
                    console.log("success");
                }
            });
        }

        function edit(obj)
        {
            var id = $(obj).parents(".comment").attr("id").split("-")[1];

            var text = $(".description").val();

            $.ajax
            ({
                type: 'POST',
                url: '/comment/edit',
                data: {'id' : id, 'message' : text, '_token': $('meta[name="csrf-token"]').attr('content')},
                success: function(data)
                {
                    console.log("edited");
                }
            });
        }

        function deletecomment(obj)
        {
            var id = $(obj).parents(".comment").attr("id").split("-")[1];

            $.ajax
            ({
                type: 'POST',
                url: '/comment/delete',
                data: {'id' : id, '_token': $('meta[name="csrf-token"]').attr('content')},
                success: function(data)
                {
                    if(data == "delete")
                    {
                        $(obj).parents(".comment-wrapper").remove();
                    } else
                    {
                        $(obj).parents(".content-comment").children(".your-rating").remove();
                        $(obj).parents(".content-comment").children(".description").html(data);
                        $(obj).parents(".content-comment").children(".actions").remove();
                    }
                }
            });
        }

        $(document).ready(function()
        {
            $(function()
            {
                @foreach($comments as $item)

                    var currentRating = $('#rating-{{ $item->id }}').data('current-rating');

                    $('#rating-{{ $item->id }}').barrating
                    ({
                        initialRating: currentRating,
                        theme: 'fontawesome-stars-o',
                        onSelect: function(value, text)
                        {
                            $.ajax
                            ({
                                type: 'POST',
                                url: '/comment/rating',
                                data: {'rating' : value, 'id' : '{{ $item->id }}', '_token': $('meta[name="csrf-token"]').attr('content')},
                                success: function()
                                {
                                    console.log("rating edit");
                                }
                            });

                        }
                    });

                @endforeach
            });
        });

    </script>

@endsection
