<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    {{-- <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge"> --}}
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.1/css/bootstrap.min.css" integrity="sha512-Z/def5z5u2aR89OuzYcxmDJ0Bnd5V1cKqBEbvLOiUNWdg9PQeXVvXLI90SE4QOHGlfLqUnDNVAYyZi8UwUTmWQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.1/js/bootstrap.min.js" integrity="sha512-fHY2UiQlipUq0dEabSM4s+phmn+bcxSYzXP4vAXItBvBHU7zAM/mkhCZjtBEIJexhOMzZbgFlPLuErlJF2b+0g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

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
            margin:10px 0
            
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
            color: #1b1b1b
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

        .blanks-section{
            margin: 5px 20px 
        }
        .blanks{
          margin: 10px 0;
          background: #b4b3b3;
          display: inline;
          padding: 2px
        }

        .lists-section {
            position: relative;
        }
        .matching .droppable-blank {
            border: none;
        }
        .list-items{
          background: transparent;
          position: absolute;
          top: 0px;
          left: 25%;

        }

        .blank-item{
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

        p{
            margin: 0;
        }

        .page-break {
            page-break-before: always;
        }

      </style>
</head>
<body>



<div class="container-fluid  header">
    <div class="grid-container ">
        <div class="grid-item">
            <span class="font-weight-bold"><strong>Republic Of Iraq Ministry of Education</strong></span>
            <br><span class="font-weight-bold"><strong>Examination in English for Preparatory Schools</strong></span>
            <br><span><strong>School name:</strong> {{$data['settings']['export_school_name'] ?? ''}}</span>
        </div>
        <div class="grid-item ">
            <img src="{{$data['settings']['export_logo'] ?? ''}}" width="100px" height="100px" alt="">
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
    <p><strong>Note: </strong>{{$data['settings']['export_note'] ?? ''}}</p>
</div>

<div class="container-fluid">
    @php
        $sectionIndex = 0;
        $blanks = [];
        $lists = [];
    @endphp



    @foreach ($data['items'] as $item)
    
        @if ($item->type == 0 )
            @php
                $sectionIndex++;
                $itemIndex = 0;
                // $blanks[$sectionIndex] = [];
            @endphp

            @if ($sectionIndex == 5)
            <div class="page-break"></div>
            @endif

            @if ($item->title != '')
                <div class="qs-type d-flex justify-content-between mt-2">
                    @php
                        $arr = explode(':', $item->title);
                    @endphp
                    <span class="text-start">{{$arr[0]?? ''}}</span>
                    <span class="text-end">{{$arr[1] ?? ''}}</span>
                </div>
            @endif

            <div class="mb-2">
                
                    {!! $item->description !!}
                
            </div>

      
            <div class="blanks-section" data-section-index="{{$sectionIndex}}">
                <!-- This will be replaced with  blanks using JavaScript -->
            </div>

            <div class="lists-section" data-section-index="{{$sectionIndex}}">
                <!-- This will be replaced with  lists using JavaScript -->
            </div>

            {{-- @if ($sectionIndex == 6)
            <h6>List A:</h6>
            @endif --}}
            
        @endif

        @if ($item->type == 7)
            @php
                if (isset($item->properties['display']) && $item->properties['display'] == 1) {
                    $blanks[$sectionIndex][] = $item->blanks[0];
                }elseif(isset($item->properties['display']) && $item->properties['display'] == 0){
                    $lists[$sectionIndex][] = $item->blanks[0];
                }
            @endphp
        @endif

        @if ($item->type == 2)
            @php
                $itemIndex++;
            @endphp
            <div class="question mb-2">
                 {!! $item->title ?? '' !!}
            </div>     
        @endif

        @if ($item->type == 5)
            @php
                $itemIndex++;
            @endphp
            <div class="question">
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
            <div class="question">
                 {{$itemIndex}}. {!! $item->blank_paragraph ?? '' !!}
            </div>     
        @endif

        @if ($item->type == 7)
            @php
                $itemIndex++;
            @endphp
            
            <div class="question-7 {{(isset($item->properties['display']) && $item->properties['display'] == 0) ? 'matching' : ''}}" 
                data-index="{{$sectionIndex}}">
                 {{$itemIndex}}. {!! $item->blank_paragraph ?? '' !!}
            </div>  
        @endif



    @endforeach

    @php
        /// shuffling array items
        foreach ($blanks as &$array) {
            shuffle($array);
        }

        unset($array);

        foreach ($lists as &$array) {
            shuffle($array);
        }

        unset($array);

    @endphp
    
    {{-- @dd($blanks) --}}

</div>


<script>
$(document).ready(function() {
 
    // Function to get alphabetic index (A, B, C, ...)
    function getAlphabeticIndex(index) {
        return String.fromCharCode(97 + index);
    }

    // Loop through each section's marker
    $('.blanks-section').each(function() {
        var sectionIndex = $(this).data('section-index');
        var blanksContainer = $(this);

        // Fetch the accumulated  blanks for the matching section
        var sectionblanks = <?= json_encode($blanks) ?>;
        var sectionBlanks = sectionblanks[sectionIndex];

        // Generate HTML for blanks
        var blanksHtml = '';
        if (sectionBlanks && sectionBlanks.length > 0) {
            blanksHtml += '<div class="blanks">';
            sectionBlanks.forEach(function(blank, index) {
                blanksHtml += '<span class="blank-item">' + blank + '</span>';
            });
            blanksHtml += '</div>';
        }

        // Inject HTML into the blanksContainer
        blanksContainer.html(blanksHtml);
    });

    // Loop through each section's marker
    $('.lists-section').each(function() {
        var sectionIndex = $(this).data('section-index');
        var blanksContainer = $(this);

        // Fetch the accumulated first blanks for the matching section
        var sectionlists = <?= json_encode($lists) ?>;
        var sectionlists = sectionlists[sectionIndex];

        // Generate HTML for first blanks
        var listsHtml = '';
        if (sectionlists && sectionlists.length > 0) {
            
            var matchingElement = $(`.matching[data-index="${sectionIndex}"]`).first();
            var newChildElement = $('<h5>List A:</h5>');
            matchingElement.before(newChildElement);

            listsHtml += '<div class="list-items">';
            listsHtml += '<h5>List B:</h5>'
            sectionlists.forEach(function(item, index) {
                // listsHtml += '<span class="blank-item">' + blank + '</span>';
                var alphabeticIndex = getAlphabeticIndex(index);
                listsHtml += '<div class="list-blanks">' + alphabeticIndex + '. ' + item + '</div>';
            });
            listsHtml += '</div>';
        }

        // Inject HTML into the lists Container
        blanksContainer.html(listsHtml);
    });
});

window.onload = function() {
    // window.print();
};

</script>


</body>
</html>