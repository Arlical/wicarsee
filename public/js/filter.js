$(document).ready(function () {

    $("#brand_filter").change(function () {

        $.post(
            'http://localhost/wicarsee/php/index.php?EX=filter',
            {
                BRAND : $("#brand_filter").val()
            },
            function (data) {
                $("#model_filter option").remove();
                $("#model_filter").append(data);
            },
            'html'
        );

    });

    $("#model_filter").change(function () {

        $.post(
            'http://localhost/wicarsee/php/index.php?EX=filter',
            {
            MODEL : $("#model_filter").val()
            },
            function (data) {
                $("#brand_filter option").remove();
                $("#brand_filter").append(data);
            },
            'html'
        );

    });

});
