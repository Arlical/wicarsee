$(document).ready(function () {

    $('#addPicture').on("click", function () {

        var numberInput = $('input[type=file]').length;

        if ((numberInput+1) > 9)
        {
            $('#addPicture').hide();
        }

        $('#deletePicture').show();

        $('<div class="custom-file mt-1">\n' +
            '<label class="col-form-label" for="picture'+ (numberInput+1) +'">Upload des images pour votre annonce ('+ (numberInput+1) + '/' + 10 +')</label>\n' +
            '<input type="file" name="PICTURE'+ (numberInput+1) +'" class="form-control" id="picture'+ (numberInput+1) +'" lang="fr" accept=".jpg, .jpeg, .png .gif">\n' +
            '</div>').insertBefore($('#buttonPicture'));

    });


    $('#deletePicture').on("click", function () {

        if ($('input[type=file]').length > 1)
        {
            var numberInput = $('input[type=file]').length;
            var input = $('.custom-file');
            input[numberInput-1].remove();
        }

        if ((numberInput-1) < 10)
        {
            $('#addPicture').show();
        }

        if ($('input[type=file]').length < 2)
        {
            $('#deletePicture').hide();
        }

    });

});