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
            font-size: 14px !important;
            /* font-family:Arial, Helvetica, sans-serif; */
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
            border-bottom: 1px dotted black;
            outline: none;
            width: 80px;
            padding: 0;
            margin: 0;
            position: relative;
            bottom: 8px;
            background: transparent;
        }

        ul li{
            text-decoration: none;
            list-style: none;
        }

        li strong{
            color: #6e6969
        }

        .question p{
            display: inline;
        }

        .question-7 *{
            display: inline;
        }

        .question-7 .droppable-blank{
            width: 100px;
            border-bottom: 2px dotted black;
            display: inline-block;
        }

        .first-blanks-section{
            margin: 20px 
        }
        .first-blanks{
          margin: 10px 0;
          background: #b4b3b3;
          display: inline;
          padding: 2px
        }
        .first-blank-item{
            padding: 5px;
            /* background: #b4b3b3; */
            display: inline;
            border-radius: 5px;
            margin-inline: 5px
        }

        * {
            /* padding: 0 !important;
            margin: 0 !important; */
            font-size: 14px !important;
        }

        /* .header *{
            
        } */

        .grid-container {
            display: grid;
            grid-template-columns: 1.3fr .5fr 1fr; /* Create 3 equal-width columns */
            gap: 0px; 
        }

      </style>
</head>
<body>



<div class="container  header">
    <div class="grid-container ">
        <div class="grid-item">
            <span class="font-weight-bold"><strong>Republic Of Iraq Ministry of Education</strong></span>
            <br><span class="font-weight-bold"><strong>Examination in English for Preparatory Schools</strong></span>
            <br><span><strong>School name:</strong> {{$data['settings']['export_school_name'] ?? ''}}</span>
        </div>
        <div class="grid-item ">
            <img src="https://jor.rdd.edu.iq/img/logo.png" width="100px" height="100px" alt="">
        </div>
        <div class="grid-item">
            <ul>
                <li><strong>Date:</strong> {{$data['settings']['export_date'] ?? ''}}</li>
                <li><strong>Branch:</strong> {{$data['settings']['export_branch'] ?? ''}}</li>
                <li><strong>Trail:</strong> {{$data['settings']['export_trail'] ?? ''}}</li>
                <li><strong>Time:</strong> {{$data['settings']['export_time'] ?? ''}}</li>
            </ul>
        </div>
    </div>
    <p><strong>Note:</strong></p>
</div>

<div class="container-fluid">
    @php
        $sectionIndex = 0;
        $firstBlanks = [];
    @endphp



    @foreach ($data['items'] as $item)
    
        @if ($item->type == 0 )
            @php
                $sectionIndex++;
                $itemIndex = 0;
                // $firstBlanks[$sectionIndex] = [];
            @endphp

            @if ($item->title != '')
                <div class="qs-type d-flex justify-content-between mt-2">
                    @php
                        $arr = explode(':', $item->title);
                    @endphp
                    <span class="text-start">{{$arr[0]?? ''}}</span>
                    <span class="text-end">{{$arr[1] ?? ''}}</span>
                </div>
            @endif

            <div>
                <p class="px-5">
                    {!! $item->description !!}
                </p>
            </div>

            {{-- @if ($sectionIndex == 5 || $sectionIndex == 6)
                <!-- Display firstBlanks after processing all items in a section -->
                @foreach ($firstBlanks as $sectionFirstBlanks)
                    @if (count($sectionFirstBlanks) > 0)
                        <div class="first-blanks">
                            @php
                                $dd = implode(', ', $sectionFirstBlanks);
                            @endphp
                            {{$dd}}
                        </div>
                    @endif
                @endforeach
            @endif --}}

        <!-- Add a marker for displaying first blanks -->
        <div class="first-blanks-section" data-section-index="{{$sectionIndex}}">
            <!-- This will be replaced with first blanks using JavaScript -->
        </div>

        @endif

        @if ($item->type == 7)
            @php
                $firstBlanks[$sectionIndex][] = $item->blanks[0];
            @endphp
        @endif

        @if ($item->type == 2)
            @php
                $itemIndex++;
            @endphp
            <div class="question mb-2 px-3">
                 {!! $item->title ?? '' !!}
            </div>     
        @endif

        @if ($item->type == 5)
            @php
                $itemIndex++;
            @endphp
            <div class="question px-3">
                 {{$itemIndex}}. {!! $item->title ?? '' !!} 
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

        @if ($item->type == 6 )
            @php
                $itemIndex++;
            @endphp
            <div class="question px-3">
                 {{$itemIndex}}. {!! $item->blank_paragraph ?? '' !!}
            </div>     
        @endif

        @if ($item->type == 7)
            @php
                $itemIndex++;
                // $firstBlanks[$sectionIndex][] = $item->blanks[0];
            @endphp
            
            <div class="question-7 px-3">
                 {{$itemIndex}}. {!! $item->blank_paragraph ?? '' !!}
            </div>  
        @endif


        {{-- @if ($loop->last)
            @dd($firstBlanks)
        @endif --}}


    @endforeach

    @php
        /// shuffling array items
        foreach ($firstBlanks as &$array) {
            shuffle($array);
        }

        unset($array); 
    @endphp
    
    {{-- @dd($firstBlanks) --}}

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.1/js/bootstrap.min.js" integrity="sha512-fHY2UiQlipUq0dEabSM4s+phmn+bcxSYzXP4vAXItBvBHU7zAM/mkhCZjtBEIJexhOMzZbgFlPLuErlJF2b+0g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


<script>
    $(document).ready(function() {
        // Loop through each section's marker
        $('.first-blanks-section').each(function() {
            var sectionIndex = $(this).data('section-index');
            var firstBlanksContainer = $(this);

            // Fetch the accumulated first blanks for the matching section
            var sectionFirstBlanks = <?= json_encode($firstBlanks) ?>;
            var sectionBlanks = sectionFirstBlanks[sectionIndex];

            console.log(sectionFirstBlanks);

            // Generate HTML for first blanks
            var firstBlanksHtml = '';
            if (sectionBlanks && sectionBlanks.length > 0) {
                firstBlanksHtml += '<div class="first-blanks">';
                sectionBlanks.forEach(function(firstBlank) {
                    firstBlanksHtml += '<span class="first-blank-item">' + firstBlank + '</span>';
                });
                firstBlanksHtml += '</div>';
            }

            // Inject HTML into the firstBlanksContainer
            firstBlanksContainer.html(firstBlanksHtml);
        });
    });
</script>


</body>
</html>