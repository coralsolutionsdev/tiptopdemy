<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script>
	/*loading*/
	$(function () {
        $(".loading-overlay .spinner").fadeOut(500,function(){
            $("body").css("overflow","auto");
            $(this).parent().fadeOut(200,function(){
                $(this).remove();
            })
        });
    });
</script>

@yield('script')