$(document).ready(function() {

    $('#brand').autocomplete({
        source : 'http://localhost/wicarsee/php/advert.php?EX=autocomplete&TYPE=brand'
    });

    $('#model').autocomplete({
        source : 'http://localhost/wicarsee/php/advert.php?EX=autocomplete&TYPE=model'
    });

    $('#color').autocomplete({
       source : 'http://localhost/wicarsee/php/advert.php?EX=autocomplete&TYPE=color'
    });

});
