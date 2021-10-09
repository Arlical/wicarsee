<?php
/**
 * Class VFooter de type Vue pour l'affichage du footer
 *
 * @author Arnaud Baldacchino
 * @version 1.0
 */
class VFooter
{

    /**
     * Constructeur de la class VFooter
     */
    public function __construct() {}

    /**
     * Destructeur de la class VFooter
     */
    public function __destruct() {}

    /**
     * @return void
     * Affiche le footer
     */
    public function showFooter() {

        echo <<<'NOW'
<!-- Footer -->
<footer class="page-footer font-small indigo">

  <!-- Footer Links -->
  <div class="container">

    <!-- Grid row-->
    <div class="row text-center d-flex justify-content-center pt-5 mb-3">

      <!-- Grid column -->
      <div class="col-md-3 mb-3">
        <h6 class="text-uppercase font-weight-bold">
          <a href="terms">Conditions générales</a>
        </h6>
      </div>
      <!-- Grid column -->

      <!-- Grid column -->
      <div class="col-md-3 mb-3">
        <h6 class="text-uppercase font-weight-bold">
          <a href="notice">Mentions légales</a>
        </h6>
      </div>
      <!-- Grid column -->

      <!-- Grid column -->
      <div class="col-md-3 mb-3">
        <h6 class="text-uppercase font-weight-bold">
          <a href="cookie">Cookie</a>
        </h6>
      </div>
      <!-- Grid column -->

      <!-- Grid column -->
      <div class="col-md-3 mb-3">
        <h6 class="text-uppercase font-weight-bold">
          <a href="policy">Politique de confidentialité</a>
        </h6>
      </div>
      <!-- Grid column -->

    </div>
    <!-- Grid row-->
    <hr class="rgba-white-light" style="margin: 0 15%;">

  </div>
  <!-- Footer Links -->

  <!-- Copyright -->
  <div class="footer-copyright text-center py-3">
    <a href="http://arnaudbaldacchino.com/" target="_blank"> Arnaud Baldacchino</a>
  </div>
  <!-- Copyright -->

</footer>
<!-- Footer -->
NOW;
        return;

    } // showFooter()

    public function showFooterAdmin() {

        echo <<<'NOW'
<!-- Footer -->
<footer class="page-footer font-small indigo" style="height: 8em">

  <!-- Footer Links -->
  <div class="container">

    
    <!-- Grid row-->
    <hr class="rgba-white-light" style="margin: 0 15%;">

  </div>
  <!-- Footer Links -->

  <!-- Copyright -->
  <div class="footer-copyright text-center py-3">
    <a href="http://arnaudbaldacchino.com/" target="_blank"> Arnaud Baldacchino</a>
  </div>
  <!-- Copyright -->

</footer>
<!-- Footer -->
NOW;
        return;
    } // showFooterAdmin()

} // class VFooter

?>
