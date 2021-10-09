$(document).ready(function () {

    $("#individual").on("change", function () {

        $.get("http://localhost/wicarsee/php/html/individual.html", function (data) {
           $("#suite").html(data);
        });

    });

    $("#compagny").on("change", function () {

        $.get("http://localhost/wicarsee/php/html/compagny.html", function (data) {
            $("#suite").html(data);
        });

    });

    var regexNumber = new RegExp("\d");
    var regexUppercase = new RegExp("[A-Z]");
    var regexTiny = new RegExp("[a-z]");
    var regexCara = new RegExp("[!@#$%^&*_=+-]")

    $("#password").on("keyup", function (e) {

        var password = e.target.value;
        var passwordCorrect = 'faible';
        var colorMessage = 'red';

        if (password.length >= 8 && regexNumber.test(password) && regexUppercase.test(password) && regexTiny.test(password) && regexCara.test(password))
        {
            passwordCorrect = 'suffisant';
            colorMessage = 'green';
        }
        else if (password.length >= 4 && regexUppercase.test(password) && regexTiny.test(password))
        {
            passwordCorrect = 'moyenne';
            colorMessage = 'orange';
        }

        $("#helpPassword").text('Niveau du mot de passe : ' + passwordCorrect).css('color', colorMessage);

    });

});
