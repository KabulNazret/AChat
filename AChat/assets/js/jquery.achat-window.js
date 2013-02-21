$(document).ready(function() {

        setInterval(function() {
            $.achatGetMessages();
            $("#messages-div").scrollTo('ul > li.last', 200, {axis:'y'});
        }, 5000);

        //hack for right border of the page
        $('html').css('overflow-x', 'hidden');

        //toggle chat wingow visibility
        $('.left').click(function() {
            if( $(".achat-window").hasClass('open') ) {
                $(".achat-window").animate({right: '-380px'}, 500).removeClass('open');
            } else {
                $(".achat-window").animate({right: '-30px'}, 500).addClass('open');
            }

            return false;
        });

        //ENTER listener
        $(".textarea-msg").keyup(function(e) {
            e = e || event;
            if(e.keyCode === 13 && !e.ctrlKey) {
                $("#achat-form").submit();
            }
            return true;
        });


});