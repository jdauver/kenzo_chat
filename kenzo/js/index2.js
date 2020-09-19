$(function () {

    // 今までのチャット表示ーーーーーー
    $.ajax({
        url: "ajax/talk_hyouzi.php",
        type: "post",
        dataType: 'text',
        data: { id: $('.message .talk:last-of-type').attr('id') },
    }).done(function (response) {
        var talk = JSON.parse(response);
        for ($i = 0; $i < talk.length; $i++) {
            $(".message").append(talk[0][$i]);
        }
        $(".zibun-topuga").css("background-image", "url(upload/" + talk[1] + ")");
        $(".aite-topuga").css("background-image", "url(upload/" + talk[2] + ")");
        // alert(talk[2]);
    }).fail(function (xhr, textStatus, errorThrown) {
        location.reload();
    });



    // チャットページ開いたときに一番下へーーーーー

    setTimeout(function () {
        if ($('.message .talk:last-of-type').offset().top > $('.message_box').offset().top - 150) {
            $('html, body').animate({
                scrollTop: $('.message .talk:last-of-type').offset().top
            }, 700);
        }
    }, 2000);



    // 送信押したとき一番下へーーーーーー
    $("#send").on("click", function () {
        if ($('.message .talk:last-of-type').offset().top > $('.message_box').offset().top - 150) {
            $('html, body').animate({
                scrollTop: $(document).height()
            }, 700);
        }
    });



    // トーク内容0.1秒ごとに更新するajax
    window.setInterval(function () {
        if ($(".zibun").length || $(".aite").length) {
            // console.log("a");
            $.ajax({
                url: "ajax/talk_roop.php",
                type: "post",
                dataType: 'text',
                data: { id: $('.message .talk:last-of-type').attr('id') },
            }).done(function (response2) {
                var talk = JSON.parse(response2);
                // console.log(talk[2]);
                // console.log(talk[3]);
                if (talk[1]) {
                    for ($i = 0; $i < talk[0].length; $i++) {
                        $(".message").append(talk[0][$i]);
                    }
                }

                $(".zibun-topuga").css("background-image", "url(upload/" + talk[2] + ")");
                $(".aite-topuga").css("background-image", "url(upload/" + talk[3] + ")");
                // $(".aite-topuga").css("background-image", "url (upload/" + talk[3] + ")");


            }).fail(function (xhr, textStatus, errorThrown) {
                location.reload();
            });
        } else {
            $.ajax({
                url: "ajax/talk_hyouzi.php",
                type: "post",
                dataType: 'text',
                data: { id: $('.message .talk:last-of-type').attr('id') },
            }).done(function (response) {
                var talk = JSON.parse(response);
                for ($i = 0; $i < talk.length; $i++) {
                    $(".message").append(talk[0][$i]);
                }
            }).fail(function (xhr, textStatus, errorThrown) {
                location.reload();
            });
        }

    }, 500);


});
