
<?php


if (isset($_POST['submit'])){

	include_once '../DbManagement/dbh.inc.php';

	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$sql=" SELECT *  FROM cliente WHERE email = '$email' ;";
	$result = mysqli_query($conn,$sql);
	$resultCheck = mysqli_num_rows($result);
	$numcampi = mysqli_num_fields($result);

	if ($resultCheck>0) {


   		$row = mysqli_fetch_row($result);
   		

		?>
		<script LANGUAGE='JavaScript'>
    		window.location.href='<?php echo ("../../GestioneIot/cliente.php?cod=$row[0]&nome=$row[1]&cognome=$row[2]&azienda=$row[3]&telefono=$row[4]&iva=$row[5]&sede=$row[6]&mail=$row[7]"); ?>';
    		</script>");
		
	<?php
	
	

	}else{
		?>
	<script LANGUAGE='JavaScript'>
    		window.alert('Cliente non trovato, riprova !');
    		window.location.href='../../Index.php';
    </script>
    <?php
		
	}
}


/*
echo ("<script LANGUAGE='JavaScript'>
    		window.alert('Cliente trovato');
    		window.location.href='../cliente.php';
    		</script>");
		exit
*/

?>