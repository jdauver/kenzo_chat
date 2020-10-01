$(function () {

    // 今までのチャット表示ーーーーーー---
    $.ajax({
        url: "ajax/talk_hyouzi.php",
        type: "post",
        dataType: 'text',
        data: { id: $('.message .talk:last-of-type').attr('id') },
    }).done(function (response) {
        var talk = JSON.parse(response);
        for ($i = 0; $i < talk[0].length; $i++) {
            if ($(".message .talk").length < 1) {
                $(".message").append(talk[0][$i]);
                var class_after = $(".message .talk:last").attr("class");
                var after_array = class_after.split(" ");
                var hiduke = after_array[1].split("-");
                $(".message .talk:last").before("<div class='date'>" + hiduke[0] + "年" + Number(hiduke[1]) + "月" + Number(hiduke[2]) + "日" + "</div>");

            } else {
                $(".message").append(talk[0][$i]);
                var class_before = $(".message .talk:last").prev().attr("class");
                var class_after = $(".message .talk:last").attr("class");

                var before_array = class_before.split(" ");
                var after_array = class_after.split(" ");

                var hiduke_before = before_array[1].split("-");
                var hiduke = after_array[1].split("-");

                if (hiduke_before[0] < hiduke[0]) {
                    $(".message .talk:last").before("<div class='date'>" + hiduke[0] + "年" + Number(hiduke[1]) + "月" + Number(hiduke[2]) + "日" + "</div>");
                } else if (before_array[1] < after_array[1]) {
                    $(".message .talk:last").before("<div class='date'>" + Number(hiduke[1]) + "月" + Number(hiduke[2]) + "日" + "</div>");
                }
            }

        }
        $(".zibun-topuga").css("background-image", "url(upload/" + talk[1] + ")");
        $(".aite-topuga").css("background-image", "url(upload/" + talk[2] + ")");

        var today = new Date();
        if (today.getHours() >= 19 || today.getHours() < 6) {
            $(".time").css("color", "white");
            $(".date").css("color", "white");
            $(".date").css("border-color", "white");
        } else {
            $(".time").css("color", "black");
            $(".date").css("color", "black");
            $(".date").css("border-color", "black");
        }


    }).fail(function (xhr, textStatus, errorThrown) {
        location.reload();
    });



    // チャットページ開いたときに一番下へーーーーー

    // setTimeout(function () {
    //     if ($('.message .talk:last-of-type').offset().top > $('.message_box').offset().top - 150) {
    //         $('html, body').animate({
    //             scrollTop: $('.message .talk:last-of-type').offset().top
    //         }, 700);
    //     }
    // }, 2000);



    // トーク内容0.1秒ごとに更新するajax
    window.setInterval(function () {
        if ($(".zibun").length || $(".aite").length) {
            $.ajax({
                url: "ajax/talk_roop.php",
                type: "post",
                dataType: 'text',
                data: { id: $('.message .talk:last-of-type').attr('id') },
            }).done(function (response2) {

                var talk = JSON.parse(response2);
                if (talk[1]) {
                    for ($i = 0; $i < talk[0].length; $i++) {
                        $(".message").append(talk[0][$i]);
                        var class_before = $(".message .talk:last").prev().attr("class");
                        var class_after = $(".message .talk:last").attr("class");

                        var before_array = class_before.split(" ");
                        var after_array = class_after.split(" ");

                        var hiduke_before = before_array[1].split("-");
                        var hiduke = after_array[1].split("-");
                        if (hiduke_before[0] < hiduke[0]) {
                            $(".message .talk:last").before("<div class='date'>" + hiduke[0] + "年" + Number(hiduke[1]) + "月" + Number(hiduke[2]) + "日" + "</div>");
                        } else if (before_array[1] < after_array[1]) {
                            $(".message .talk:last").before("<div class='date'>" + Number(hiduke[1]) + "月" + Number(hiduke[2]) + "日" + "</div>");
                        }
                        if (after_array[0] == "zibun") {
                            $('html, body').animate({
                                scrollTop: $('.message .talk:last-of-type').offset().top
                            }, 700);
                        }
                        if (after_array[0] == "aite") {
                            if ($('.message .talk:last-of-type').prev().offset().top > $('.message_box').offset().top + 150) {
                                alert("新着コメントがあります");
                            } else {
                                $('html, body').animate({
                                    scrollTop: $('.message .talk:last-of-type').offset().top
                                }, 700);
                            }
                        }
                    }
                }

                $(".zibun-topuga").css("background-image", "url(upload/" + talk[2] + ")");
                $(".aite-topuga").css("background-image", "url(upload/" + talk[3] + ")");


                var today = new Date();
                if (today.getHours() >= 6 && today.getHours() < 15) {
                    $("#chat").css("background-image", "url(img/sora.png)");
                }
                else if (today.getHours() >= 15 && today.getHours() < 19) {
                    $("#chat").css("background-image", "url(img/yusora.jpg)"
                    );
                }
                else {
                    $("#chat").css("background-image", "url(img/star.jpg)");
                }

                if (today.getHours() >= 19 || today.getHours() < 6) {
                    $(".time").css("color", "white");
                    $(".date").css("color", "white");
                    $(".date").css("border-color", "white");
                } else {
                    $(".time").css("color", "black");
                    $(".date").css("color", "black");
                    $(".date").css("border-color", "black");
                }



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
                for ($i = 0; $i < talk[0].length; $i++) {
                    $(".message").append(talk[0][$i]);
                    var class_after = $(".message .talk:last").attr("class");
                    var after_array = class_after.split(" ");
                    var hiduke = after_array[1].split("-");
                    $(".message .talk:last").before("<div class='date'>" + hiduke[0] + "年" + Number(hiduke[1]) + "月" + Number(hiduke[2]) + "日" + "</div>");
                }
                $(".zibun-topuga").css("background-image", "url(upload/" + talk[2] + ")");
                $(".aite-topuga").css("background-image", "url(upload/" + talk[3] + ")");


                var today = new Date();
                if (today.getHours() >= 6 && today.getHours() < 15) {
                    $("#chat").css("background-image", "url(img/sora.png)");
                }
                else if (today.getHours() >= 15 && today.getHours < 19) {
                    $("#chat").css("background-image", "url(img/yusora.jpg)"
                    );
                }
                else {
                    $("#chat").css("background-image", "url(img/star.jpg)");
                }

                if (today.getHours() >= 19) {
                    $(".time").css("color", "white");
                    $(".date").css("color", "white");
                    $(".date").css("border-color", "white");
                }
                else {
                    $(".time").css("color", "black");
                    $(".date").css("color", "black");
                    $(".date").css("border-color", "black");
                }

                
            }).fail(function (xhr, textStatus, errorThrown) {
                location.reload();
            });
        }

    }, 1500);


});
