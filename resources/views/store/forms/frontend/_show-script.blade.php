<script>
    @if(!empty($hasTimeLimit) && $hasTimeLimit == 1)
    UIkit.modal("#quizHasTimeModal").show();
    @endif
    function startTimer(duration, display) {
        var timer = duration, minutes, seconds;
        var timerWarning = (timer/100) * 5;
        var myTimer = setInterval(function () {
            minutes = parseInt(timer / 60, 10);
            seconds = parseInt(timer % 60, 10);

            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;
            display.textContent = minutes + ":" + seconds;
            console.log(timer);
            if (--timer < 0) {
                clearInterval(myTimer);
                UIkit.modal("#quizEndedModal").show();
            }
            if (timerWarning > timer){
                // UIkit.notification("<span uk-icon='icon: warning'></span> 5 minutes remaining ", {pos: 'top-center', status:'warning'})
                $('.timer').addClass('uk-text-warning');
            }
        }, 1000);
    }

    $('.start-quiz').click(function (){
        UIkit.modal("#quizHasTimeModal").hide();
        var duration = {{$timeLimit}} * 60;
        var display = document.querySelector('#time');
        startTimer(duration, display);
        $('.quiz-section').slideDown();
        $('.quiz-countdown').show();

    });
</script>
<script>
    $('.pass-question').click(function (){
        var checkboxItem =  $(this);
        var lastCheckboxItem = $( ".pass-question:checked").last();
        var lastCheckboxItem = $( ".pass-question:checked").first();
        var row = checkboxItem.closest('.question-row');
        row.toggleClass('uk-background-danger-light');
    });
    $('.review-question').click(function (){
        var row = $(this).closest('.question-row');
        row.toggleClass('uk-background-warning-light');
    });
</script>