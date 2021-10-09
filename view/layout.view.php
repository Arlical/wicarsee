<?php
/**
 * Fichier de mise en page
 *
 * @author Arnaud Baldacchino
 * @version 1.0
 */
 
// Classe d'affichage de la naigation
$vnav = new VNav();

// Classe d'affichage du footer
$vfooter = new VFooter();

// Variable pour appeler la bonne méthode et bonne classe
global $content;
$vcontent = new $content['class']();
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title><?= $content['title'] ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
        <link rel="icon" href="public/img/icon_wicarsee.ico">
        <link rel="stylesheet" href="https://bootswatch.com/5/zephyr/bootstrap.min.css">
        <link rel="stylesheet" href="public/css/style.css">
    </head>
    <body>

    <?php $vnav->showNav(); ?>

    <div class="container pb-5 pt-5" style="min-height: 80vh">
        <?php $vcontent->{$content['method']}($content['arg']) ?>
    </div>

    <?php $vfooter->showFooter(); ?>

    <script src="https://bootswatch.com/_vendor/jquery/dist/jquery.min.js"></script>
    <script src="https://bootswatch.com/_vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://bootswatch.com/_vendor/prismjs/prism.js" data-manual></script>
    <script src="https://bootswatch.com/_vendor/prismjs/prism.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="public/js/advertiser.js"></script>
    <script src="public/js/back.js"></script>
    <script src="public/js/advert.js"></script>
    <script src="public/js/carousel.js"></script>
    <script src="public/js/profile.js"></script>
    <script src="public/js/autocompletion.js"></script>
    <script src="public/js/filter.js"></script>

    </body>
</html>
