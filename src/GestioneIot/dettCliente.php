<?php
error_reporting(0);



include_once '../header.php';
include_once '../includes/DbManagement/dbh.inc.php';

if (isset($_POST['delete'])) {

    $cod = mysqli_real_escape_string($conn, $_POST['delete']);
    $sql2 = " DELETE FROM zona_cliente WHERE cliente = '$cod';";
    $sql = " DELETE FROM cliente WHERE cod_cliente = '$cod ';";

    $result1 = mysqli_query($conn, $sql2);
    $result = mysqli_query($conn, $sql);

    if ($result) {
    	?>
        <script LANGUAGE='JavaScript'>
    		window.alert('Cliente cancellato !');
    		window.location.href='HomeIOT.php';
    		</script>
    <?php
    } else {
    ?>
     <script LANGUAGE='JavaScript'>
    		window.alert('Errore riprovare !');
    		window.location.href='HomeIOT.php';
    		</script>
    <?php
    }

}elseif (isset($_POST['deleteSENS'])){

	$targetSens= mysqli_real_escape_string($conn, $_POST['deleteSENS']);
	$sqlDelSens= "DELETE FROM sensori_zona WHERE id_sensori = '$targetSens' ; ";
	$resDelSen= mysqli_query($conn, $sqlDelSens);
		if($resDelSen){
		?>
		<script LANGUAGE='JavaScript'>
    			window.alert('Sensore cancellato !');
    			window.location.href='HomeIOT.php';
    			</script>
    	<?php
		}else {
		?>
			<script LANGUAGE='JavaScript'>
    		window.alert('Errore riprovare !');
    		window.location.href='HomeIOT.php';
    		</script>
    	<?php
        }
	








}elseif (isset($_POST['btnUpdateCliente'])) {

    $codC = mysqli_real_escape_string($conn, $_POST['btnUpdateCliente']);
	$nAzienda = mysqli_real_escape_string($conn, $_POST['newAzienda']);
    $nTelefono = mysqli_real_escape_string($conn, $_POST['newTelefono']);
	$nSede = mysqli_real_escape_string($conn, $_POST['newSede']);

	if (empty($nTelefono) && empty($nSede) && empty($nAzienda)) {
		?>
		<script LANGUAGE='Javascript'>
		window.alert('Nulla da aggiornare!'); 
		window.location.href='HomeIOT.php';
		</script>
		<?php

	} elseif(empty($nAzienda) && empty($nTelefono) ){

		//query aggiorna solo sede
		$sqlUpdateSede = " UPDATE cliente SET sede = '$nSede' WHERE cod_cliente = '$codC' ; " ;
		$resUpdateSede = mysqli_query($conn, $sqlUpdateSede);
		//header("Location:HomeIOT.php?cod:". $sqlUpdateSede);
		
		if ($resUpdateSede) {
		?>	
			<script LANGUAGE='Javascript'>
			window.alert('Sede modificata'); 
			window.location.href='HomeIOT.php';
			</script>
		<?php
		} 
		
	} elseif (empty($nAzienda) && empty($nSede)) {
		//query aggiorna telefono
		$sqlUpdateTelefono = " UPDATE cliente SET telefono = '$nTelefono' WHERE cod_cliente = '$codC' ; " ;
		$resUpdateTelefono = mysqli_query($conn, $sqlUpdateTelefono);
		//header("Location:HomeIOT.php?cod:". $sqlUpdateTelefono);

		if ($resUpdateTelefono) {
		?>	
			<script LANGUAGE='Javascript'>
			window.alert('Recapito modificato'); 
			window.location.href='HomeIOT.php';
			</script>
		<?php
		}
		

	} elseif (empty($nTelefono) && empty($nSede)) {
		//query aggiorna nomeAzienda
		$sqlUpdateAzienda= " UPDATE cliente SET azienda = '$nAzienda' WHERE cod_cliente = '$codC' ; " ;
		$resUpdateAzienda = mysqli_query($conn, $sqlUpdateAzienda);
		//header("Location:HomeIOT.php?cod:". $sqlUpdateAzienda);

		if ($resUpdateAzienda) {
		?>	
			<script LANGUAGE='Javascript'>
			window.alert('Nome aziendale modificato'); 
			window.location.href='HomeIOT.php';
			</script>
		<?php
		}

	} else{
		//Query aggiorna tutto
		$sqlUpdateAll= " UPDATE cliente SET sede = '$nSede' , telefono = '$nTelefono' , azienda = '$nAzienda' WHERE cod_cliente = '$codC' ; " ;
		$resUpdateAll = mysqli_query($conn, $sqlUpdateAll);
		//header("Location:HomeIOT.php?cod:". $sqlUpdateAll);

		if ($resUpdateAll) {
		?>	
			<script LANGUAGE='Javascript'>
			window.alert('Profilo cliente modificato'); 
			window.location.href='HomeIOT.php';
			</script>
		<?php
		}

	} 









}elseif (isset($_POST['delAllSens'])) {
	
	/* prima di riumuovere la zona la svuota */
	$targetZona = mysqli_real_escape_string($conn, $_POST['delAllSens']);
	$squDelAllSensInZone= "DELETE FROM sensori_zona WHERE id_pos = '$targetZona';";
	$resDelAllSensInZone= mysqli_query($conn,$squDelAllSensInZone);

	if($resDelAllSensInZone){
	?>		
			<script LANGUAGE='JavaScript'>
			window.alert('Tutti i sensori in zona cancellati !');
			window.location.href='HomeIOT.php';
			</script>
	<?php		
		
	}else {
	?>		
			<script LANGUAGE='JavaScript'>
		window.alert('Errore riprovare !');
		window.location.href='HomeIOT.php';
		</script>
	<?php
			
	}



}elseif (isset($_POST['delZona'])) {
	$targetZona = mysqli_real_escape_string($conn, $_POST['delZona']);
	/* prima di riumuovere la zona la svuota */
	$squDelAllSensInZone= "DELETE FROM sensori_zona WHERE id_pos = '$targetZona';";
	$resDelAllSensInZone= mysqli_query($conn,$squDelAllSensInZone);
	
	/* poi la cancella */
	$squDelZona= "DELETE FROM zona_cliente WHERE id_pos = '$targetZona';";
	$resDelZona= mysqli_query($conn,$squDelZona);

	if($resDelZona){
	?>
	<script LANGUAGE='JavaScript'>
			window.alert('Zona eliminata!');
			window.location.href='HomeIOT.php';
			</script>
	<?php
		
	}else {
	?>
			<script LANGUAGE='JavaScript'>
		window.alert('Errore riprovare !');
		window.location.href='HomeIOT.php';
		</script>
	<?php	
		
	}

}elseif (isset($_POST['dectail'])) {
    $cod = mysqli_real_escape_string($conn, $_POST['dectail']);

    $zone = "SELECT * FROM zona_cliente WHERE cliente = '$cod' ; ";

    $resultZone = mysqli_query($conn, $zone);
    $resultCheckZone = mysqli_num_rows($resultZone);
    $resultZ = mysqli_fetch_array($resultZone);

    ?>

    <section class="cover cover--single" style="margin-top: 50px">
        <div class="cover__filter"></div>
        <div class="cover__caption">
            <div class="cover__caption__copy">
                <h1 style="margin: auto">Dettagli Cliente </h1>
                <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#ModalAddZ">
 					 Aggiungi Zona
		</button>

                <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#ModalAddS">
 					 Aggiungi Sensore
		</button>
            </div>
        </div>
    </section>
    <br>



    <section class="main-container">


        <div class="tabel-wrapper centrato">


            <?php
if ($resultCheckZone<1) {
	 ?>
	 <h1>QUESTO ACCOUNT NON HA ANCORA ZONE</h1>
	<?php
} else{
    foreach ($resultZone as $resultZ) {

        $sensor = $resultZ['id_pos'];
        $querySensor = "SELECT * FROM sensori_zona WHERE id_pos = '$sensor';";
        $resultSensor = mysqli_query($conn, $querySensor);
		$resultS = mysqli_fetch_array($resultSensor);
		$resultS2= mysqli_num_rows($resultSensor);

		?>
		<form method="POST" action="dettCliente.php">
				<table class="table table-bordered">
					<thead>
      					<tr>
							<th>Serial Number</th>
								<th>Tipo</th>
									<th>Nome</th>
								<th></th>
     					</tr>
					</thead>
		<?php
		$collocazione=$resultZ['id_pos'];
        if ($resultS) {
            foreach ($resultSensor as $resultS) {
				$id = $resultS['id_sensori'];
				$collocazione= $resultS['id_pos'];

				$idS=htmlspecialchars($resultS['id_sensori']);
				$tip=htmlspecialchars($resultS['tipo']);
				$nomeS=htmlspecialchars($resultS['nome_sensore']);

                ?>
               <tbody>
						<tr>
								<input type="hidden" name="name" value=<?php echo $id; ?>>
								<input type="hidden" name="name" value=<?php echo $collocazione; ?>/>
								<td name="serial"><?php echo $idS; ?></td>
								<td> <?php echo $tip; ?></td>
								<td><?php echo $nomeS; ?></td>
								<td>
									<button
										type="submit"
										class="btn btn-default btn-sm"
										name="deleteSENS"
										value=<?php echo $id; ?>
									>
										<span class="glyphicon glyphicon-remove-circle"></span>
									</button>
								</td>
						</tr>
					</tbody>
			<?php
			 }
        }
        $rZona=htmlspecialchars($resultZ['zona']);
        ?>
		
			<h3 class="intestazione"> <?php echo $rZona; ?></h3>
			<button
			type="submit"
			name="delAllSens"
			value=<?php echo $collocazione; ?>
			>Svuota Zona
			</button>

			<button
			type="submit"
			name="delZona"
			value=<?php echo $collocazione; ?>
			>Elimina Zona
			</button>

			</form>
		<?php

	}
}
    ?>




        </div>
    </section>






    <!-- MODAL ADD ZONA-->
    <section>
        <div class="modal fade" id="ModalAddZ" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Aggiungi Zona</h4>
                    </div>
                    <div class="modal-body">
                        <form class="signup-form" action="../includes/ItemManagement/addItem.inc.php?id=<?php
			echo $cod;
    	?>" method="POST">

                            <h3>Nome zona</h3><input type="text" name="zona">

                            <button type="submit" name="bottZONA" onclick="mostraAllert()">Inserisci</button>
                        </form>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </section>







    <!-- MODAL ADD SENS-->
    <section>
        <div class="modal fade" id="ModalAddS" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Aggiungi Sensore</h4>
                    </div>
                    <div class="modal-body">
                        <form class="signup-form" action="../includes/ItemManagement/addItem.inc.php?id=<?php
		echo $cod;
    	?>" method="POST">

                            <h3>Nome Sensore</h3><input type="text" name="name" placeholder="">
                            <h3>Serial Number Sensore</h3><input type="text" name="id">

                            <h3> Tipo </h3><select name="tipo">
		<?php
			$sqlTipiDidponibili = 'SELECT * FROM TipiSensori; ';
			$resultTipiDisponibili = mysqli_query($conn, $sqlTipiDidponibili);
			$resultTD = mysqli_fetch_array($resultTipiDisponibili);
			foreach ($resultTipiDisponibili as $resultTD ) {
				$tipo = $resultTD['tipologia'];
				?>
				<option value=<?php echo $tipo; ?>><?php echo $tipo; ?> </option>
				<?php
			}
	?>

 	</select>

                            <h3>Marca</h3><input type="text" name="marca">

                            <h3>Zona</h3><select name="zona">
	<?php
		$sqlZoneDidponibili = "SELECT zona FROM zona_cliente WHERE cliente = '$cod'; ";
		$resultZoneDisponibili = mysqli_query($conn, $sqlZoneDidponibili);
		$resultZD = mysqli_fetch_array($resultZoneDisponibili);
		foreach ($resultZoneDisponibili as $resultZD ) {
			$zonax = $resultZD['zona'];
			?>
			<option value=<?php echo $zonax; ?>> <?php echo $zonax; ?> </option>
		<?php
		}
	?>
	</select>
                            <h3>Minimo Accettabile</h3><input type="text" name="MinA">
                            <h3>Massimo Accettabile</h3><input type="text" name="MaxA">
                            <h3>Minimo Critico</h3><input type="text" name="MinC">
                            <h3>Massimo Critico</h3><input type="text" name="MaxC">

                            <button type="submit" name="bottSENS" onclick="mostraAllert()">Inserisci</button>
                        </form>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <?php }
//altrnativa a eliminaSensZona


?>