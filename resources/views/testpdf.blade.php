<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.1/css/bootstrap.min.css" integrity="sha512-Z/def5z5u2aR89OuzYcxmDJ0Bnd5V1cKqBEbvLOiUNWdg9PQeXVvXLI90SE4QOHGlfLqUnDNVAYyZi8UwUTmWQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Document</title>
    <style>
        /* Custom CSS to center the container */
        body, html {
            padding-inline:10px; 
        }
        .br span{
            display: block
        }

        .qs-type{
            background: #ddd;
            color: #000;
            font-weight: bold;
            padding: 2px;
            text-transform: capitalize;
        }

        .qs-type span:first-child {
           text-align: left;
           display: inline-block;
        }
        .qs-type span:last-child {
            text-align: right;
            display: inline-block;
        }
        .input-blank{
            border: none;
            border-bottom: .5px dotted #3a3838;
            outline: none;
            width: 80px;
            padding: 0;
            margin: 0;
            position: relative;
            bottom: 8px;
            background: transparent;
        }

        .question p{
            display: inline;
        }

      </style>
</head>
<body>

<div class="container p-2">
    <div class="row d-flex">
        <div class="col-lg-5">
            <span class="font-weight-bold"><strong>Republic Of Iraq Ministry of Education</strong></span>
            <br><span class="font-weight-bold"><strong>Examination in English for Preparatory Schools</strong></span>
            <br><span>School name: {{$data['settings']['export_school_name'] ?? ''}}</span>
        </div>
        <div class="col-lg-3">
            <img src="https://img.freepik.com/free-vector/illustration-circle-stamp-banner-vector_53876-27183.jpg?w=740&t=st=1691597917~exp=1691598517~hmac=59a68dce9eb90b048ab96cd249d86368c153dce24e1b5beaecd3fe1ce00034e4" width="100px" height="100px" alt="">
        </div>
        <div class="col-lg-4 br">
            <span>Date: {{$data['settings']['export_date'] ?? ''}}</span>
            <span>Branch: {{$data['settings']['export_branch'] ?? ''}}</span>
            <span>Trail: {{$data['settings']['export_trail'] ?? ''}}</span>
            <span>Time: {{$data['settings']['export_time'] ?? ''}}</span>
        </div>
    </div>
    <p><strong>Note:</strong></p>
</div>

<div class="container-fluid">
    @foreach ($data['items'] as $item)

        @if ($item->type == 0 )

            @if ($item->title != '')
                <div class="qs-type d-flex justify-content-between mt-3">
                    @php
                        $arr = explode(':', $item->title);
                    @endphp
                    <span class="text-start">{{$arr[0]?? ''}}</span>
                    <span class="text-end">{{$arr[1] ?? ''}}</span>
                </div>
            @endif

            <div>
                <p>
                    {!! $item->description !!}
                </p>
            </div>
        @endif

        @if ($item->type == 5)
            <div class="question">
                {{$item->position}}. {!! $item->title ?? '' !!} 
                @if (isset($item->options))
                    
                    @foreach ($item->options as $opt)
                        @if ((isset($opt['title']) && $opt['title'] != 'Option title' ))
                            {{ $loop->first ? '(' : '' }}
                                {{$opt['title'] ?? '' }}{{ $loop->last ? '' : ' ,' }}
                            {{ $loop->last ? ')' : '' }}
                        @endif
                    @endforeach
                    
                @endif
            </div>
        @endif

        @if ($item->type == 6)
            <div class="question">
                {{$item->position}}. {!! $item->blank_paragraph ?? '' !!}
            </div>     
        @endif


    @endforeach
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.1/js/bootstrap.min.js" integrity="sha512-fHY2UiQlipUq0dEabSM4s+phmn+bcxSYzXP4vAXItBvBHU7zAM/mkhCZjtBEIJexhOMzZbgFlPLuErlJF2b+0g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>
</html>