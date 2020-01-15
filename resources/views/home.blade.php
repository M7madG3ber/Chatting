@extends('layouts.app')

@section('content')
<div class="container">

    <!-- header -->
    <div class="row justify-content-center gaberHeader">
        <div class="col-sm-6 left">
            Chat Window
        </div>
        <div class="col-sm-6 right">
            @if( session()->get( 'user' ) !== null )
            {{ session()->get( 'user' )->name }}
            @endif
        </div>
    </div>

    <!-- users and messages -->
    <div class="row justify-content-center gaberUsers">
        <div class="col-sm-4 left">
            @foreach( $users as $user)
            <a  href="/user/{{ $user['id'] }}">
                <div class="user">{{ $user['name'] }}</div>
            </a>
            @endforeach
        </div>
        <div class="col-sm-8 right">
            <div class="messages" id="chatMessages">
                @if( session()->get( 'user' ) === null )
                <div class="oneMessage">
                    <h5>Choose User To Start Chatting</h5>
                </div>
                @endif

                <!--<div class="oneMessage">
                    <h5>ME ( Just Now )</h5>
                    <p>asd asd asd</p>
                </div>-->
            </div>
            <!-- <form action="{{ url('/user/sendmessage') }}" method="POST">
                @csrf -->
            <div class="gaberInput">
                <input id="message" type="text" placeholder="Type To Chat" name="text">
                <button id="sending" type="sumbit" class="btn btn-primary">Submit</button>
            </div>
            <!--</form> -->
        </div>
        @if( session()->get( 'user' ) !== null )
        <div id="clearChat" class="clearChat">Clear Chat</div>
        @endif
    </div>

</div>
@endsection
<script src="{{ asset('jq.js')}}"></script>
<script>
$(function() {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // get All messagse
    function gaberMessages() {
        $.ajax({
            url: '/getallmessages',
            type: 'post',
            data: {
                _token: '{{ csrf_token( ) }}',
            },
            success: function(mes) {
                var m = JSON.parse(mes);
                if (m.length > 0) {
                    $("#chatMessages").html('');
                    for (var i = 0; i < m.length; i++) {
                        var name = "";
                        if (m[i]['from'] == {{ auth()-> user()->id }} ) {
                            name = "ME";
                        } else {
                            name = "<?php
                            if( session()->get('user') !== null )
                            { echo session()->get( 'user')->name ; } 
                            ?>";
                        }
                        $("#chatMessages").append('<div class="oneMessage"><h5>' + name +
                            '</h5><p>' + m[i]['text'] + '</p></div>');
                    }
                }
            }
        });
    }
    setInterval(gaberMessages, 500);

    /* send message */ 
    $("#sending").click(function() {
        $.ajax({
            url: '/user/sendmessage',
            type: 'post',
            data: {
                _token: '{{ csrf_token( ) }}',
                'text': $("#message").val()
            },
            success: function(mes) {
                $("#message").val('');
            }
        });
    });

    /* clear Chat */
    $("#clearChat").click(function() {
        $.ajax({
            url: '/deleteMessages',
            type: 'post',
            data: {
                _token: '{{ csrf_token( ) }}',
            },
            success: function(mes) {
                $("#chatMessages").html('');
            }
        });
    });




});
</script>