$(document).ready(function () {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    var author = urlParams.get('author');

    $.ajax({
        method: "POST",
        url: "posts.php",
        data: {userId: author, type: 'scopus'},
    })
        .done(function (response) {
            if (response == "cookies") {
                $.ajax({
                    method: "POST",
                    url: "posts.php",
                    data: {userId: author, type: 'scopus', cookies: 'true'},
                })
                    .done(function (response) {
                        $('#loader1').hide();
                        if (response != "") {
                            try {

                                var posts = JSON.parse(response);
                                posts.posts.forEach((element) => {
                                    var html = '<div class="item-list">' +
                                        '<span class="type">' + element.type + '</span>' +
                                        '<span class="title">' + element.title + '</span>' +
                                        '<span class="source">' + element.source + '</span>' +
                                        '<span class="authors">' + element.authors + '</span>' +
                                        '</div>';
                                    $('.list-scopus').append(html);
                                })
                            } catch (e) {
                                var html = '<div class="error">На данный момент нет доступных статей</div>';
                                $('.list-scopus').append(html);
                            }
                        } else {
                            var html = '<div class="error">На данный момент нет доступных статей</div>';
                            $('.list-scopus').append(html);
                        }

                    });
            } else {
                $('#loader1').hide();
                if (response != "") {
                    try {
                        var posts = JSON.parse(response);
                        posts.posts.forEach((element) => {
                            var html = '<div class="item-list">' +
                                '<span class="type">' + element.type + '</span>' +
                                '<span class="title">' + element.title + '</span>' +
                                '<span class="source">' + element.source + '</span>' +
                                '<span class="authors">' + element.authors + '</span>' +
                                '</div>';
                            $('.list-scopus').append(html);
                        })
                    } catch (e) {
                        var html = '<div class="error">На данный момент нет доступных статей</div>';
                        $('.list-scopus').append(html);
                    }
                } else {
                    var html = '<div class="error">На данный момент нет доступных статей</div>';
                    $('.list-scopus').append(html);
                }
            }
        });
});


$('#scholar').click(function () {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    var author = urlParams.get('author');

    $.ajax({
        method: "POST",
        url: "posts.php",
        data: {userId: author, type: 'scholar'},
    })
        .done(function (response) {
            $('#loader2').hide();
            $('.list-scholar').empty();
            if (response != "") {
                try {
                    var posts = JSON.parse(response);
                    posts.posts.forEach((element) => {
                        var html = '<div class="item-list">' +
                            '<span class="title">' + element.title + '</span>' +
                            '<span class="source">' + element.source + '</span>' +
                            '<span class="authors">' + element.authors + '</span>' +
                            '</div>';
                        $('.list-scholar').append(html);
                    })
                } catch (e) {
                    var html = '<div class="error">На данный момент нет доступных статей</div>';
                    $('.list-scholar').append(html);
                }
            } else {
                var html = '<div class="error">На данный момент нет доступных статей</div>';
                $('.list-scholar').append(html);
            }

        });
});

$('.add-post').click(function () {
    var title = $('#title').val();
    var subTitle = $('#subTitle').val();
    var type = $('#type').val();
    var text = $('#text').val();

    $.ajax({
        method: "POST",
        url: "posts.php",
        data: {action: 'addPost', post: {title: title, sub_title: subTitle, type: type, text: text}},
    }).done(function (response) {
        console.log(response);
        if (response) {
            var html = '<div class="item-list">';
            if (type !== "") {
                html += '<span class="type">' + type + '</span>';
            }
            if (title !== "") {
                html += '<span class="title">' + title + '</span>';
            }
            if (subTitle !== "") {
                html += '<span class="sub-title">' + subTitle + '</span>';
            }
            if (text !== "") {
                html += '<span class="text">' + text + '</span>';
            }
            html += '</div>';
            $('.list-local').append(html);

            document.getElementById("close").click();

            $('#title').val('');
            $('#subTitle').val('');
            $('#type').val('');
            $('#text').val('');
        } else {
            alert("Произошла ошибка!");
        }
    });
});