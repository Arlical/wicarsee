$(document).ready(function () {

    $(".radio-vehicle").on("change", function () {

       $("#submit-vehicle").val("Editer mon annonce").addClass("btn btn-warning");

       if (!$("#delete-vehicle").length) {
         $('<input type="submit" class="btn btn-danger ml-1" name="ACTION" id="delete-vehicle" value="Supprimer mon annonce">').insertAfter($('#submit-vehicle'));
       }

    });

});
