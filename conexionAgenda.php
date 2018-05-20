<?php 
session_start();

if($_SESSION['username'] != true)
{   
    echo "<script>location.href='index.php'</script>";
}
else
{
	include("../assets/classes/admin_db.inc.php");
	include('../assets/classes/objects_mise.inc.php');
	include("../assets/include/header.php");

	$consulta	= 'SELECT *
				   FROM SEGU_USUARIOS SU, SEGU_ROL_USUARIOS SRU
				   WHERE SU.ID_USUARIOS = SRU.ID_USUARIOS AND SU.ID_USUARIOS = '.$_SESSION['id_user'];

	$datosPlan		= ejecuta_consulta_adodb($consulta,$db);

                
	if(!(empty($datosPlan)))
	{     
            $id=$datosPlan[0]['NUMERO_IDENTIFICACION'];
            $usu=$datosPlan[0]['NOMBRE_USUARIO'];
            $url='../agenda/agendaFront/#/'.$_GET['r'].'?id='.$id.'&usu='.$usu;
//            var_dump( $scr);
		if($datosPlan[0]['ID_ROLES'] == 288)
			echo "<script>location.href='../caracterizacion/caracterizacion.php?tipoDoc=".$datosPlan[0]['COD_TIPOIDENTIFICACION']."&id=".$datosPlan[0]['NUMERO_IDENTIFICACION']."&carpeta=caracterizacion&pagina=caracterizacion.php'</script>";
                        
		else{
	?>
	
        
	<script type="text/javascript" src="../assets/js/validaciones.js" ></script>
		<!-- Main -->
                <div class="container">
                    <input type=hidden name="identificacion" value="<?php echo $id; ?>"/>
                        <h2 class="Estilo1"></h2>
			<div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" src='<?php echo $url ?>' ></iframe>
                        </div>
                </div>			
<?php
}
?>

			<!-- Footer -->
<?php
			include("../assets/include/footer.php");
			?>


<?php 
	}
}
	
?>