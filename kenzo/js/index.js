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



    $("#sitabtn").on("click", function () {
        $('html, body').animate({
            scrollTop: $(document).height()
        }, 700);
    });



    // トーク内容送信時処理
    $('#send').click(function () {
        $.ajax({
            url: "ajax/insert_talk.php",
            type: "post",
            dataType: "text",
            data: { 'message': $(".textarea").val() }

        }).done(function () {

        }).fail(function (xhr, textStatus, errorThrown) {
            location.reload();
        });
    });

    // 送信押したとき一番下へーーーーーー
    $("#send").on("click", function () {
        if ($('.message .talk:last-of-type').offset().top > $('.message_box').offset().top - 150) {
            $('html, body').animate({
                scrollTop: $(document).height()
            }, 700);
        }
    });



    // 画像選択時処理ーーーーーーーーーーーーーーー
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

    // 設定ページの背景画像選択時プレビュー
    $('#file_back').change(function () {
        //propを使って、file[0]にアクセスする
        var file2_ = $('#file_back').prop('files')[0];

        //添付されたのが本当に画像かどうか、ファイル名と、ファイルタイプを正規表現で検証する
        if ($("#file_back").val().length) {

            if (!/\.(jpg|jpeg|png|gif|JPG|JPEG|PNG|GIF)$/.test(file2_.name) || !/(jpg|jpeg|png|gif)$/.test(file2_.type)) {
                alert('JPG、GIF、PNGファイルの画像を添付してください。');
                //添付された画像ファイルが１M以下か検証する
            } else if (2048576 < file2_.size) {
                alert('2MB以下の画像を添付してください。');
            } else {

                var reader_ = new FileReader();

                reader_.onload = function () {

                    $.ajax({
                        url: "ajax/session_file_back.php",
                        type: "post",
                        dataType: "text",
                        data: { 'img2': reader_.result }

                    }).done(function (response) {
                        var back = JSON.parse(response);
                        $(".pv_back").css("background-image", "url(" + back + ")");

                        if ($(".pv_back").css("background-image").match(/uploadback\/back\.png/)) {
                            $(".pv_back").css("border", "solid 1px black");

                        } else {
                            $(".pv_back").css("border", "none");

                        }
                    }).fail(function (xhr, textStatus, errorThrown) {
                        location.reload();
                    });

                }
                reader_.readAsDataURL(file2_);

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
            // alert ("aaa");
            $(".nameng").html("");
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
            $(".passng").html("");
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
            $(".idng").html("");
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
// 虫眼鏡で検索
$(document).ready(function () {
    $('#fri-search').click(function () {
        $('#form_style').submit();
    });
});
$(document).ready(function () {
    $('#sagasu').click(function () {
        $('#form_style').submit();
    });

    // $('#touroku').click(function () {
    //     $('#touroku_form').submit();
    // });

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
    // });



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
var chat = document.getElementById('#chat');
$(function () {
    var today = new Date();
    console.log(today.getSeconds());

    if (today.getSeconds() >= 0 && today.getSeconds() < 5) {
        $("#chat").css("background-image", "url(img/sora.png)");

    } else if (today.getSeconds() >= 5 && today.getSeconds() <= 30) {
        $("#chat").css("background-image", "url(img/yusora.jpg)"
        );

    } else {
        $("#chat").css("background-image", "url(img/yozora.jpg)");
    }
});