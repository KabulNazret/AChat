(function( $ ) {

$.achatAddMessage = function(options) {
    var options = $.extend({
                        msg: '',
                        last: false,
                        ignore: false
    }, options);

    if(options.msg != '') {
        var msg = options.msg;

        //make string
        var name = ( msg.user_id == -1 ? '<i>Guest</i>' : '<b>' + msg.username + '</b>' );
        var str = name + ', ' + msg.datetime + ' : ' + msg.text;

        //mark last readed message
        if(options.last && !options.ignore) {
            //remove old marker
            $("#messages-list").find('li.last').removeClass('last');
            var li = '<li class="last" name="' + msg.id + '">' + str + '</li>';
        } else if(options.ignore) {
            //
            $("#messages-list").find('li.ignore').removeClass('ignore');
            var li = '<li class="ignore" name="' + msg.id + '">' + str + '</li>';
        } else {
            var li = '<li>' + str + '</li>';
        }

        $("#messages-list").append(li);
    }
}
})(jQuery);


(function( $ ) {
$.achatGetMessages = function() {

    //there may be a mistake here
    var validLocation = $(location).attr('href').indexOf( 'index.php', 0) >= 0
                            ? $(location).attr('href')
                            : $(location).attr('href') + 'index.php';

    var post = 'lastId=' + $("#messages-list").find('li.last').attr('name');
    //we must ignore this message because it's already shown
    post = post + '&ignoreId=' + $("#messages-list").find('li.ignore').attr('name');

    $.ajax({
        type: "POST",
        url: validLocation + '/AChat/json/get',
        data: post
    }).done(function( response ) {

        var answer = jQuery.parseJSON(response);

        //got new messages ?
        if(answer.status == 1) {
            if(answer.count > 0) {

                $.each(answer.messages, function(i, msg) {
                    var name = ( msg.user_id == -1 ? '<i>Guest</i>' : '<b>' + msg.username + '</b>' );
                    var str = name + ', ' + msg.datetime + ' : ' + msg.text;

                    //mark last readed message
                    if(answer.count == (i + 1)) {
                        $.achatAddMessage({msg: msg, last: true});
                    } else {
                        $.achatAddMessage({msg: msg, last: false});
                    }
                });

                //check stack
                var stackLen = $("#messages-list > li").length;
                if( stackLen > 15 ) {
                    var delLen = stackLen - 15;
                    for(i = 0; i < delLen; i++) {
                        $("#messages-list").find('li:first').remove();
                    }
                }

                $("#messages-div").scrollTo("ul > li.last", 200, {axis:"y"});
            }
        }
    }).fail(function(x, errText) {
        //alert(errText);
    });
};

})(jQuery);


