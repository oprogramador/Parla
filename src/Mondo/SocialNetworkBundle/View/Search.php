<?php
/****************************************
 *
 * Author: Piotr Sroczkowski, Paulina Ryfka
 *
 ****************************************/
?>
<?php include 'Base.php' ?>
<?php
use Mondo\UtilBundle\Core\DB;
use Mondo\SocialNetworkBundle\Entity\User;

?>

<?php startblock('javascripts') ?>
<?php endblock() ?>
<?php startblock('styles') ?>
    <link rel="stylesheet" href="../components/bootstrap/css/bootstrap.min.css">
<?php endblock() ?>
<?php startblock('content') ?>

City: <input name="city" />
Country: <input name="country" />

<?php endblock() ?>
