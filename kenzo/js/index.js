$(function () {

    // メインページーーーーーーーーーーーーーーーーーー

    // 友達人数の紹介
    // alert("aaa");
    $("#cursor").on("click", function () {
        /* クラスがfriend_imgどうかの確認 */
        if ($("#friend_id").attr("class") == "friend_img") {
            // alert("aaa");
            /* friend_idのsrcを変える */
            $("#friend_id").attr("src", "img/up1.png");
            // alert("bbb");

            $("#scroll_info").slideDown("slow");
            // alert("ccc");
        } else if ($("#friend_id").attr("class") == "") {
            // alert("bbb");

            $("#scroll_info").slideUp("slow");
            $("#friend_id").attr("src", "img/down1.png");
        }
        $("#friend_id").toggleClass("friend_img");
    });

    $("#upstyle").on("click", function () {
        // alert("ccc");

        if ($("#friend_id1").attr("class") == "friend_img") {
            // alert("ddd");
            $("#friend_id1").attr("src", "img/down1.png");
            // alert("eee");
            $("#friend_id").attr("src", "img/down1.png");
            $("#scroll_info").slideUp("slow");
        }
    });



    // トークページーーーーーーーーーーーーーーー

    // ajaxでphpと連動ーーーーーーーーーーーー

    // 友達押したとき処理
    $('.friends').click(function () {
        $.ajax({
            url: "ajax/ajax.php",
            type: "post",
            dataType: "text",
            data: {
                'id': $("#hiddenid", this).val(),
                'img': $("#hiddenimg", this).val()
            }

        }).done(function (response) {
            var array = JSON.parse(response);
            window.location.href = 'chat.php';


        }).fail(function (xhr, textStatus, errorThrown) {
            location.reload();
        });
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

                // var reader_ = new FileReader();

                // reader_.onload = function () {
                var fd = new FormData();
                // fd.append("mode", "upload_pdf");
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

                // }
                // reader_.readAsDataURL(image_);
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



    // 友達になってトーク押したときチャットに飛ぶ
    $("#talkjump").click(function () {
        window.location.href = 'chat.php';

    })




});

