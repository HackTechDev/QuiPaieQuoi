<html>
    <head>
        <title>
            Qui Paie Quoi ?
        </title>
        <link href="style.css" rel="stylesheet" media="all" type="text/css">
        <script type="text/javascript">
        </script>
    </head>
<body>
<h1>Qui Paie Quoi ?</h1>
Version : 2.0.0<br/>
<br/>
<?php

$numLigneCommande = 20;

// Recuperer toutes les valeurs du formulaire
if(isset($_POST["action"])){
    for($numCommande = 0; $numCommande < $numLigneCommande; $numCommande++){
        $commande[$numCommande]['nom']      = $_POST['commande'][$numCommande]['nom'];
        $commande[$numCommande]['avec']     = $_POST['commande'][$numCommande]['avec'];
        $commande[$numCommande]['service']  = $_POST['commande'][$numCommande]['service'];
        $commande[$numCommande]['tarif']    = $_POST['commande'][$numCommande]['tarif'];
        $commande[$numCommande]['paiement'] = $_POST['commande'][$numCommande]['paiement'];
        $commande[$numCommande]['partapayer']   = $_POST['commande'][$numCommande]['partapayer'];
        $commande[$numCommande]['part']     = $_POST['commande'][$numCommande]['part'];

        $commande[$numCommande]['arendre']  = $commande[$numCommande]['paiement'] - $commande[$numCommande]['tarif'];


        if ( $commande[$numCommande]['tarif'] > $commande[$numCommande]['paiement'] ) {
            $commande[$numCommande]['message']     = "Pas assez percu";
        }
        else if ($commande[$numCommande]['tarif'] < $commande[$numCommande]['paiement'] ) {
            $commande[$numCommande]['message']     = "Trop percu";
        }
    }
}

// Calcul du montant de la commande
for($numCommande = 0; $numCommande < $numLigneCommande; $numCommande++){
   $tarif += $_POST['commande'][$numCommande]['tarif'];
}

// Calcul du paiment a donner
for($numCommande = 0; $numCommande < $numLigneCommande; $numCommande++){
   $paiement += $_POST['commande'][$numCommande]['paiement'];
}

$message = "";

if ($tarif > $paiement) {
    $message = "Il manque de l'argent"; 
} else if ($tarif < $paiement ) {
    $message = "Il y a trop d'argent";
}

// Calcul des quantites de service

$produit = array();
for($numCommande = 0; $numCommande < $numLigneCommande; $numCommande++){
   $produit[$_POST['commande'][$numCommande]['service']]++;
}

// Genere la commande finale
$commandeFinale = "";
foreach($produit as $key => $value) {
    if($key != "") {
        $commandeFinale .= $key . " = " . $value . "\n";
    }
}

// Genere la montant a donner pour chaque personne

$montantPersonne = array();
for($numCommande = 0; $numCommande < $numLigneCommande; $numCommande++){
    $montantPersonne[$_POST['commande'][$numCommande]['nom']] += $_POST['commande'][$numCommande]['paiement'];
}
?>
<hr>
Montant a payer pour chaque personne :<br/>
<br/>
<?php
foreach($montantPersonne as $key => $value) {
    if ($value != 0) {
        echo $key . " = " . $value . "<br/>";
    }
}
?>
<br/>
<form name="form" action="index.php" method="post">
    <table border="1">
        <tr>
            <td>
                Id
            </td>
            <td style="text-align: center">
               
                Nom
            </td>
            <td style="display:none;text-align: center">
                Avec
            </td>
            <td style="text-align: center">
                Service
            </td>
            <td style="text-align: center">
                Tarif
            </td>
            <td style="text-align: center;width:100px">
                Paiement
            </td>
            <td style="display:none;text-align: center">
                Part &agrave; payer
            </td>
            <td style="display:none;text-align: center">
                Part
            </td>
            <td style="text-align: center">
                A rendre
            </td>
            <td style="text-align: center">
                Message
            </td>
            <td style="text-align: center">
               Action 
            </td>
        </tr>
<?php for($numCommande = 0; $numCommande < $numLigneCommande; $numCommande++) { ?>
        <tr>
            <td style="text-align: center">
                <?php echo $numCommande; ?>
            </td>
            <td>
                <input type="text" size="10" id="commande_<?php echo $numCommande; ?>_nom" name="commande[<?php echo $numCommande; ?>][nom]" value="<?php echo $commande[$numCommande]['nom']; ?>">
            </td>
            <td style="display:none;">
                <input type="text" size="10" id="commande_<?php echo $numCommande; ?>_avec" name="commande[<?php echo $numCommande; ?>][avec]" value="<?php echo $commande[$numCommande]['avec']; ?>">
            </td>
            <td>
                <input type="text" size="10" id="commande_<?php echo $numCommande; ?>_service" name="commande[<?php echo $numCommande; ?>][service]" value="<?php echo $commande[$numCommande]['service']; ?>">
            </td>
            <td>
                <input style="text-align: right;" type="text" size="10" id="commande_<?php echo $numCommande; ?>_tarif" name="commande[<?php echo $numCommande; ?>][tarif]" value="<?php echo $commande[$numCommande]['tarif']; ?>">
            </td>
            <td>
               <input style="text-align: right;" type="text" size="10" id="commande_<?php echo $numCommande; ?>_paiement" name="commande[<?php echo $numCommande; ?>][paiement]" value="<?php echo $commande[$numCommande]['paiement']; ?>">
            </td>
            <td style="display:none;">
                <input type="text" size="10" id="commande_<?php echo $numCommande; ?>_partapayer" name="commande[<?php echo $numCommande; ?>][partapayer]" value="<?php echo $commande[$numCommande]['partapayer']; ?>">
            </td>
            <td style="display:none;">
                <input type="text" size="10" id="commande_<?php echo $numCommande; ?>_part" name="commande[<?php echo $numCommande; ?>][part]" value="<?php echo $commande[$numCommande]['part']; ?>">
            </td>
            <td style="text-align: center">
                <?php
                     if ($commande[$numCommande]['arendre'] != 0 ) {
                ?>
                    <div style="color: red">
                    <?php
                        echo abs($commande[$numCommande]['arendre']); 
                    ?>
                    </div>
                <?php
                    } else {
                        echo "&nbsp;";
                    }
                ?>
            </td>
            <td style="text-align: center">
                 <div style="color: red">
                 <?php echo $commande[$numCommande]['message']; ?>
                </div>
            </td>
            <td style="text-align: center">
                &nbsp;   
            </td>
        </tr>
<?php } ?>
        <tr>
            <td colspan="3">
                  &nbsp;
            </td>
            <td style="text-align: right;">
                <?php
                    if($tarif != 0) { 
                        echo $tarif; 
                    }
                ?> 
                &nbsp;
            </td>
            <td style="text-align: right">
                <?php
                    if($paiement != 0) { 
                        echo $paiement; 
                    }
                ?>
                &nbsp;
            </td>
            <td style="text-align: center">
                 <div style="color: red">
                <?php 
                    $arendre = $tarif - $paiement;
                    if ($arendre == 0) {
                        echo "&nbsp;";
                    } else {
                        echo abs($arendre);
                    }
                ?>
                 </div>
            </td>
            <td colspan="2" style="text-align: center">
                <div style="color: red">
               <?php
                if($arendre < 0) {
                    echo "A redistribuer";
                } else if ($arendre > 0) {
                    echo "Manquant";
                } else {
                    echo "Compte bon";
                }
               ?>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="4">
                  &nbsp;
            </td>
            <td> 
               <div style="color: red">
                <?php echo $message; ?>
                </div>
            </td>
            <td colspan="3">
                &nbsp;
            </td>
        </tr>





    </table>
<br/>
<input type="submit" value="Calculer" name="action">
</form>
<hr/>
A commander: <br/><br/>
<textarea name="acommander" id="acommander" rows="10" cols="20" style="font-size: 200%;" readonly>
A payer : <?php echo $paiement . " E\n"; ?>
Services :
<?php
echo $commandeFinale;
?>
</textarea>

</body>
</html>
