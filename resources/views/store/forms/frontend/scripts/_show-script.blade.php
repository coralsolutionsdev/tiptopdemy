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
    $('.leave-question').click(function (){
        var checkboxItem =  $(this);
        var lastCheckboxItem = $( ".leave-question:checked").last();
        var lastCheckboxItem = $( ".leave-question:checked").first();
        var row = checkboxItem.closest('.question-row');
        row.toggleClass('uk-background-danger-light');
    });
    $('.review-question').click(function (){
        var row = $(this).closest('.question-row');
        row.toggleClass('uk-background-warning-light');
    });

    $('.section-navigation').click(function (){
        var btn = $(this);
        var navType =  btn.attr('data-value')
        var section = btn.closest('.section');
        var sectionId = section.attr('id').split('-')[1];
        var nextId = 0;
        if (navType == 1){
            nextId = parseInt(sectionId) + 1;
        }else{
            nextId = parseInt(sectionId) - 1;
        }
        var itemsNo = $('.section-'+sectionId+'-item').length;
        var sectionAllowedNo = $('.section-'+sectionId+'-allowed-number').val();
        var leaveedItemsNo = $('.leave-question-'+sectionId+':checkbox:checked').length;
        var allowedToPass = parseInt(itemsNo) - parseInt(sectionAllowedNo);
        if (sectionAllowedNo > 0){
           var result = parseInt(itemsNo) - parseInt(leaveedItemsNo);
           if (sectionAllowedNo != result){
               var message = '{{__('main.You should answer')}} '+sectionAllowedNo+' {{__('main.questions and leave')}} '+allowedToPass+' {{__('main.only')}}.';
               $('.alert-modal-message').html(message);
               UIkit.modal('#alertModal').show();

               return false;
           }
        }
        if (navType == 3){
            $('#quiz-form').submit();
        }else{
            $('#section-'+sectionId).fadeOut(200, function (){
                $('#section-'+nextId).fadeIn();
            });
        }
    });
</script>