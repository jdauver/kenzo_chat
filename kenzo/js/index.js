$(function () {

    // メインページーーーーーーーーーーーーーーーーーー

    // 友達人数の紹介
    $("#cursor").on("click", function () {
        /* クラスがfriend_imgどうかの確認 */
        if ($("#friend_id").attr("class") == "friend_img") {
            /* friend_idのsrcを変える */
            $("#friend_id").attr("src", "img/up1.png");

            $("#scroll_info").slideDown("slow");
            $('html, body').animate({
                scrollTop: $('#cursor').offset().top
            }, 700);
        } else if ($("#friend_id").attr("class") == "") {

            $("#scroll_info").slideUp("slow");
            $("#friend_id").attr("src", "img/down1.png");
        }
        $("#friend_id").toggleClass("friend_img");
    });

    $("#upstyle").on("click", function () {

        if ($("#friend_id1").attr("class") == "friend_img") {
            $("#friend_id1").attr("src", "img/down1.png");
            $("#friend_id").attr("src", "img/down1.png");
            $("#scroll_info").slideUp("slow");
        }
    });


    // トークページーーーーーーーーーーーーーーー

    // ajaxでphpと連動ーーーーーーーーーーーー
    $(".friends").click(function () {
        $.ajax({
            url: "ajax/ajax.php",
            type: "post",
            dataType: "text",
            data: {
                'id': $("#hiddenid", this).val(),
                'img': $("#hiddenimg", this).val(),
                'name': $("#hiddenname", this).val()
            }

        }).done(function (response) {
            var array = JSON.parse(response);
            window.location.href = 'chat.php';


        }).fail(function (xhr, textStatus, errorThrown) {
            location.reload();
        });
    });

    // 友達になってトーク押したときチャットに飛ぶ------
    $("#search_talk").click(function () {
        window.location.href = 'chat.php';
        $.ajax({
            url: "ajax/friend_search.ajax.php",
            type: "post",
            dataType: "text",
            data: {
                'id': $("#frid").val(),
                'img': $("#frimg").val(),
                'name': $("#friname").val()
            }

        }).done(function () {
            // var array = JSON.parse(response);
            window.location.href = 'chat.php';


        }).fail(function (xhr, textStatus, errorThrown) {
            location.reload();
        });
    });


    // チャットページの下ボタン
    $("#sitabtn").on("click", function () {
        $('html, body').animate({
            scrollTop: $(document).height()
        }, 700);
    });



    // トーク内容送信時処理にデータベースに入れる

    $('#send').click(function () {
        if ($(".textarea").val() != "") {
            $.ajax({
                url: "ajax/insert_talk.php",
                type: "post",
                dataType: "text",
                data: { 'message': $(".textarea").val() }

            }).done(function () {

            }).fail(function (xhr, textStatus, errorThrown) {
                location.reload();
            });
        }
    });



    // 画像選択時に正規表現　　データベースに入れるーーーーーーーーーーーーーーー
    $('#img').on('change', function () {

        //fileの値は空ではなくなるはず
        if ($('#img').val() !== '') {


            //propを使って、file[0]にアクセスする
            var image_ = $('#img').prop('files')[0];
            //添付されたのが本当に画像かどうか、ファイル名と、ファイルタイプを正規表現で検証する
            if (!/\.(jpg|jpeg|png|gif|JPG|JPEG|PNG|GIF)$/.test(image_.name) || !/(jpg|jpeg|png|gif)$/.test(image_.type)) {
                alert('JPG、GIF、PNGファイルの画像を添付してください。');
                //添付された画像ファイルが１M以下か検証する
            } else if (2048576 < image_.size) {
                alert('2MB以下の画像を添付してください。');
            } else {

                var fd = new FormData();

                fd.append("file", $('#img').prop('files')[0]);

                $.ajax({
                    url: "ajax/insert_img.php",
                    type: "post",
                    dataType: "json",
                    data: fd,
                    processData: false,
                    contentType: false

                }).done(function () {
                    $('html, body').animate({
                        scrollTop: $(document).height()
                    }, 700);
                }).fail(function (xhr, textStatus, errorThrown) {
                });

            }
        } else {
            //ダメだったら値をクリアする
            $('#image').val('');
        }
    });




    // 設定ページーーーーーーーーーーーーーーーーーーーーーーーーーーー

    // 設定ページのアカウント画像選択時プレビュー
    $('#file_img').change(function () {

        var file_ = $('#file_img').prop('files')[0];
        if ($('#file_img').val().length) {

            if (!/\.(jpg|jpeg|png|gif|JPG|JPEG|PNG|GIF)$/.test(file_.name) || !/(jpg|jpeg|png|gif)$/.test(file_.type)) {
                alert('JPG、GIF、PNGファイルの画像を添付してください。');
                //添付された画像ファイルが１M以下か検証する
            } else if (2048576 < file_.size) {
                alert('2MB以下の画像を添付してください。');
            } else {


                var reader_ = new FileReader();

                reader_.onload = function () {


                    $.ajax({
                        url: "ajax/session_file_img.php",
                        type: "post",
                        dataType: "text",
                        data: { 'img': reader_.result }

                    }).done(function (response) {
                        var img = JSON.parse(response);

                        $(".pv_img").css("background-image", "url(" + img + ")");
                    }).fail(function (xhr, textStatus, errorThrown) {
                        location.reload();
                    });


                }
                reader_.readAsDataURL(file_);
            }
        }
    });




    /* ログインと登録の正規表現 */
    $("#name").on("blur", check0);
    $("#pass").on("blur", check1);
    $("#id").on("blur", check2);
    $("#submit").on("click", check3);


    function check0() {
        var pass0 = $("#name").val();
        // alert(pass0.length);
        if (pass0.length > 12) {
            if ($(".nameng").html() !== "12文字以内でしか記入できません。") {
                $("#name").before("<p class='nameng'>12文字以内でしか記入できません。</p>");
                $("#name").css("background", "rgba(255, 103, 103, 0.445)");
            }
        } else if (pass0 == "") {
            $("#name").attr("placeholder", "12文字以内でご記入ください");
            $("#name").css("background", "rgba(255, 103, 103, 0.445)");
            $(".nameng").html("");

        } else {
            $(".nameng").remove();
            $("#name").css("background", "transparent");
        }
    };

    function check1() {
        var pass1 = $("#pass").val();

        if (!pass1.match(/^([a-zA-Z0-9]{6,20})$/)) {
            if ($(".passng").html() !== "英数字の6〜20文字以内でしか記入できません。") {
                $("#pass").before("<p class='passng'>英数字の6〜20文字以内でしか記入できません。</p>");
                $("#pass").css("background", "rgba(255, 103, 103, 0.445)");
            }
        } else if (pass1 == "") {
            $("#pass").attr("placeholder", "6〜20文字以内、英数字のみでご記入ください");
            $("#pass").css("background", "rgba(255, 103, 103, 0.445)");
        } else {
            $(".passng").remove();
            $("#pass").css("background", "transparent");
        }
    };

    function check2() {
        var pass2 = $("#id").val();

        if (!pass2.match(/^([a-zA-Z0-9]{6,20})$/)) {
            if ($(".idng").html() !== "英数字の6〜20文字以内でしか記入できません。") {
                $("#id").before("<p class='idng'>英数字の6〜20文字以内でしか記入できません。</p>");
                $("#id").css("background", "rgba(255, 103, 103, 0.445)");
            }
        } else if (pass2 == "") {
            $("#id").attr("placeholder", "6〜20文字以内、英数字のみでご記入ください");
            $("#id").css("background", "rgba(255, 103, 103, 0.445)");
        } else {
            $(".idng").remove();
            $("#id").css("background", "transparent");
        }
    };

    function check3() {
        if ($(".idng").html() == "英数字の6〜20文字以内でしか記入できません。" || $(".passng").html() == "英数字の6〜20文字以内でしか記入できません。") {
            alert("登録フォームに誤りがあります。");
            return false;
        }
    }

});



// friend-searchページ
// 虫眼鏡で検索する
$(document).ready(function () {
    $('#fri-search').click(function () {
        $('#form_style').submit();
    });
});
$(document).ready(function () {
    $('#sagasu').click(function () {
        $('#form_style').submit();
    });



    
    //ログアウトの設定
    // $(function () {
    $('#id_li_style').on("click", function () {
        ret = confirm("ログインページに戻ります。ログアウトしますか？");
        if (ret == true) {

            $.ajax({
                type: "POST",
                url: "ajax/logout_ajax.php",
                data: {
                    "logout": "logout_ajax",
                },
                dataType: "json",
            }).done(function (response) {
                // console.log(response);
                // var array = JSON.parse(response);

                window.location.href = 'login.php';


            }).fail(function (xhr, textStatus, errorThrown) {
                location.reload();

            });

        }
    });
});

$(function () {
    $('#yameru').click(function () {
        window.location.href = "friend_search.php";
    })
})
$(function () {
    $('#modoru').click(function () {
        window.location.href = "friend_search.php";
    })
})


// chat画面　時間により背景画像変える
// 20秒ごと
// $(function () {
//     var today = new Date();

//     if (today.getSeconds() >= 0 && today.getSeconds() < 20) {
//         $("#chat").css("background-image", "url(img/sora.png)");
//     }
//     else if (today.getSeconds() >= 20 && today.getSeconds() < 40) {
//         $("#chat").css("background-image", "url(img/yusora.jpg)"
//         );
//     }
//     else {
//         $("#chat").css("background-image", "url(img/star.jpg)");
//     }
//     if (today.getSeconds() >= 40) {
//         $(".time").css("color", "white");
//         $(".date").css("color", "white");
//         $(".date").css("border-color", "white");
//     }
//     else {
//         $(".time").css("color", "black");
//         $(".date").css("color", "black");
//         $(".date").css("border-color", "black");
//     }
// });


// 本番用　昼・夕・晩
$(function () {
    var today = new Date();

    if (today.getHours() >= 6 && today.getHours() < 17) {
        $("#chat").css("background-image", "url(img/sora.png)");
    }
    else if (today.getHours() >= 17 || today.getHours() < 19) {
        $("#chat").css("background-image", "url(img/yusora.jpg)");
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
});


