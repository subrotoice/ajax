<? if ($usu_valido) {
    include("conexion.php");
    $resUSU = mysql_query("SELECT * FROM usuario WHERE clave = $usu_valido",$conexion);
    $rowUSU = mysql_fetch_array($resUSU);
    mysql_close();
  }
?>
<?
  session_cache_limiter('private, must-revalidate');
  session_start();
  include_once('lib.php');
  if (empty($_SESSION['usu_valido'])) {
    include('acces.php');
    return;
  }
  extract($_SESSION); extract($_POST); extract($_GET);

  include('conexion.php');
  
  $usuario = $_SESSION['usu_valido'];
  
   $resUSU= mysql_query("SELECT * FROM usuario WHERE clave=$usuario", $conexion);
   $rowUSU= mysql_fetch_array($resUSU);
   $categorias_usu= explode(',',$rowUSU['categorias_herramientas']);

   // Revisa si el usuario tiene configurado un template,
   // y asigna las categora de herramientas configuradas en ese template
   $template= $rowUSU['template'];
   $resLAN= mysql_query("SELECT * FROM landing_page WHERE clave=$template",$conexion);
   $rowLAN= mysql_fetch_array($resLAN);
   $categorias_tem= explode(',',$rowLAN['categorias_herramientas']);
   
   
   if (empty($rowUSU['categorias_herramientas']) AND empty($rowLAN['categorias_herramientas']))
       header('Location: herramientas.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
 <meta http-equiv="content-type" content="text/html;charset=utf-8" />
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
 <title><? include('titulo.php'); ?></title>
 <style>
   .side-tab-btn{
     display: block
   }
   #myTab img {
       max-width: 100px;
       margin-right: 4px;
   }
   .playlist .col-md-9 {
       padding-right: 0;
   }
   .playlist .col-md-3 {
       padding-left: 0;
   }
   .playlist .nav-link{
       padding: 0;
   }
   .playlist .nav-tabs, .playlist .nav-link {
       border: none;
       border-radius: 0;
   }
   .playlist .nav-tabs {
       border-bottom: none;
   }
   .playlist a.nav-link {
       padding: 7px 0 9px 5px;
   }
   .playlist a.active {
       background: #414141 !important;
   }
   ul#myTab {
       background: #252525;
   } 
   .playlist a{
       color: #fff !important;
   }
   .widgetcontent {
     margin-bottom: 10px;
   }
 
   /*** HEADER ***/
   .header { background: #3b6c8e; clear: both; height: 110px; margin: -16px 0 0 0;}
   .headerinner { margin-left: 260px; }
   .header .logo { width: 260px; text-align: center; padding-top: 40px; float: left; }

   .headmenu { list-style: none; }
   .headmenu .dropdown-menu { border: 2px solid #3b6c8e; border-top: 0; margin: 0; }
   .headmenu .nav-header {
     text-shadow: none; font-weight: normal; padding: 3px 15px; color: #999; font-size: 11px;
     text-transform: uppercase; }
   .headmenu .dropdown-menu::after {
     position: absolute; top: -6px; left: 45px; display: none; border-right: 6px solid transparent;
     border-bottom: 6px solid white; border-left: 6px solid transparent; content: ''; }
     .dropdown-toggle::after {
   display: none;
   width: 0;
   height: 0;
   margin-left: .255em;
   vertical-align: .255em;
   content: "";
   border-top: .3em solid;
   border-right: .3em solid transparent;
   border-bottom: 0;
   border-left: .3em solid transparent;
}
   .headmenu > li {
     display: inline-block; float: left; font-size: 14px; position: relative; border-right: 1px solid rgba(255,255,255,0.15); }
   .headmenu > li:first-child { border-left: 1px solid rgba(255,255,255,0.15); }
   .headmenu > li.odd { background: rgba(255,255,255,0.1); }
   .headmenu > li.right { float: right; border-right: 0; }
   .headmenu > li > a {
     min-width: 70px; position: relative; display: block; color: #fff;
     padding: 25px 20px 9px 20px; cursor: pointer; }
   .headmenu > li > a:hover { text-decoration: none; }
   .headmenu > li > a .count { position: absolute; top: 5px; right: 10px; opacity: 0.5; }
   .headmenu > li > a:hover .count, .headmenu > li.open > a .count { opacity: 1; }
   .headmenu > li > a .headmenu-label { display: block; margin: 2px 0 3px 0; opacity: 0.5; text-align: center; }
   .headmenu > li > a:hover .headmenu-label, .headmenu > li.open > a .headmenu-label { opacity: 1; }

   .headmenu > li > a .head-icon { width: 50px; height: 50px; display: block; margin: auto; opacity: 0.5; }
   .headmenu > li > a:hover .head-icon, .headmenu > li.open a .head-icon { opacity: 1; }
   @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap');
   .headmenu > li, .leftmenu .nav-tabs.nav-stacked a, .pagetitle h1, .shortcuts li {
     font-family: 'Roboto', sans-serif;
     }

   .head-message { background-image: url(https://vioniko.com/images/icons/message.png); }
   .head-users { background-image: url(https://vioniko.com/images/icons/users.png); }
   .head-bar { background-image: url(https://vioniko.com/images/icons/bar.png); }
   .head-retorn { background-image: url(https://vioniko.com/images/icons/retorn.png); }
   .head-video { background-image: url(https://vioniko.com/images/icons/video.png); }

   .viewmore a { font-size: 11px; text-transform: uppercase; font-size: 11px !important; }

   .newusers { min-width: 200px; }
   .newusers li a:hover { background; #eee; }
   .newusers li a::after { clear: both; display: block; content: ''; }
   .newusers .userthumb { width: 35px; display: block; float: left; margin: 3px 10px 3px 0; }
   .newusers strong { display: block; line-height: normal; }
   .newusers small { color: #999; line-height: normal; }

   .userloggedinfo { padding: 11px; color: #fff; }
   .userloggedinfo img { padding: 3px; background: rgba(255,255,255,0.2); width: 85px; float: left; }
   .userloggedinfo .userinfo { float: left; margin-left: 10px; }
   .userloggedinfo .userinfo small { font-size: 11px; opacity: 0.6; color: #fff; font-family: sans-serif; font-style: italic; }
   .userloggedinfo ul { list-style: none; margin-top: 5px; }
   .userloggedinfo ul li { display: block; font-size: 11px; line-height: normal; margin-bottom: 1px; }
   .userloggedinfo ul li a { padding: 4px 5px 3px 5px; color: #fff; line-height: normal; background: rgba(255,255,255,0.1); display: block; }
   .userloggedinfo ul li a:hover { text-decoration: none; background: rgba(255,255,255,0.2); }

   .no-borderradius .userloggedinfo .userinfo { float: none; margin-left: 92px; }
   .header h5 {
     margin-bottom: .5rem;
     font-family: 'Roboto', sans-serif;
     font-weight: 500;
     line-height: 1.2;
     color: inherit;
     font-size: 14px;
   }
   .header, .container-fluid {
    overflow: hidden;
  }
  span.videoTitle {
    font-size: 11px;
    line-height: 12px;
    padding-right: 15px;
    position: absolute;
}


 </style>
 <SCRIPT LANGUAGE="JavaScript">
 function buscar() {
   document.forma.numpag.value=1;
   document.forma.action='lista_herramientas.php';
   document.forma.target='_self';
   document.forma.submit();
 }

 function ir(form, Pag) {
   form.numpag.value = Pag;
   form.action='lista_herramientas.php';
   form.target='_self';
   form.submit();
 }

 function ordena(orden) {
   document.forma.ord.value = orden;
   document.forma.numpag.value = 1;
   document.forma.action='lista_herramientas.php';
   document.forma.target='_self';
   document.forma.submit();
 }

</SCRIPT>
</head>
<body>
<?


if (empty($ver)) $ver='10';
if (empty($numpag)) $numpag='1';
if (empty($ord)) $ord='titulo';

if     ($ord=='titulo') $orden='ORDER BY titulo';
elseif ($ord=='descripcion') $orden='ORDER BY descripcion';


// obtener el total de registros que coinciden...
// y establecer algunas variables
 

// construir la condición de búsqueda
$condicion = "WHERE activa=1 ";

$condicion .= "AND (1=2 ";
for ($i=0; $i<count($categorias_usu)-1; $i++) {
$cat = trim($categorias_usu[$i]);
$condicion .= " OR categoria=$cat";
}
for ($i=0; $i<count($categorias_tem)-1; $i++) {
$cat = trim($categorias_tem[$i]);
$condicion .= " OR categoria=$cat";
}
$condicion .= ")";



if (!empty($texto))
 $condicion .= " AND (titulo LIKE '%$texto%' OR descripcion LIKE '%$texto%')";

if (!empty($tipo))
 $condicion .= " AND tipo='$tipo'";

if (!empty($categoria))
 $condicion .= " AND categoria=$categoria";

 $resultadotot= mysql_query("SELECT * FROM herramienta $condicion",$conexion);
 $totres = mysql_num_rows ($resultadotot);
 $totpags = ceil($totres/$ver);
 if ($totres==0)
  $numpag = 0;

?>
<div class="header">
   <div class="logo" style="margin-left: 0px;">
       <a href="principal.php"><img src="https://vioniko.com/images/w-logo3.0.png" alt="Vioniko 3.0 Logo"></a>
   </div>
   <div class="headerinner" style="margin-left: 218px;">
       <ul class="headmenu">
           <li class="odd">
               <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                   <span class="count">294</span>
                   <span class="head-icon head-bar"></span>
                   <span class="headmenu-label">Visitas</span>
               </a>
           </li>
           <li>
               <a class="dropdown-toggle" data-toggle="dropdown" data-target="#">
               <span class="count">0.01%</span>
               <span class="head-icon head-retorn"></span>
               <span class="headmenu-label">Retorno</span>
               </a>
           </li>
           <li class="odd">
               <a href="lista_eventos.php?tipo=21&amp;show_criterio=1" class="dropdown-toggle" data-toggle="" data-target="">
               <span class="count">2</span>
               <span class="head-icon head-users"></span>
               <span class="headmenu-label">Registros</span>
               </a>
           </li>
           <li>
               <a href="lista_eventos_interes.php" class="dropdown-toggle" data-toggle="" data-target="">
               <span class="count">2</span>
               <span class="head-icon head-video"></span>
               <span class="headmenu-label">Videos</span>
               </a>
           </li>
           <li class="odd">
               <a href="report_48_hours.php" class="dropdown-toggle" data-toggle="" data-target="">
               <span class="count">Reporte</span>
               <span class="head-icon head-bar"></span>
               <span class="headmenu-label">48 Horas</span>
               </a>
           </li>

           <li class="right">
               <div class="userloggedinfo">
                   <?
                   if (file_exists('images/avatars/'.$rowUSU['clave'].'.jpg')) 
                   echo '<img src="images/avatars/'.$rowUSU['clave'].'.jpg" height="100px" width="100px">';?>
                   <div class="userinfo">
                   <h5>
                       <? 
                       if ($usu_valido) 
                       echo $rowUSU['nombre'].' '.$rowUSU['apellidos']; ?>
                       <small>- <?= $rowUSU['email']; ?>
                       </small>
                   </h5>
                       <ul>
                           <li><a href="modificar_perfil.php">Editar Perfil</a></li>
                           <li><a href="modificar_metas.php">Editar Metas</a></li>
                           <?php //header('Content-type: text/html; charset=ISO-8859-1');  ?>
                           <li><a href="logout.php">Cerrar Sesi&oacute;n</a></li>
                       </ul>
                   </div>
               </div>
           </li>
       </ul> <!--headmenu-->

   </div>
</div> <!--Header End-->

<div class="container-fluid">
<h3>Your Customers List</h3>
<table class="table table-bordered">
  <thead>
    <tr>
      <th>No.</th>
      <th>Nombre</th>
      <th>Fecha <br>registro</th>
      <th>E-mail</th>
      <th>Subdominio</th>
      <th>Payment</th>
      <th>Total Sale and Commisions</th>
      <th>Note</th>
    </tr>
  </thead>
  <tbody>
    <?
    $loginUserEmail = mysql_fetch_array( mysql_query("SELECT email FROM usuario WHERE clave = $usu_valido",$conexion) );
    $loginUserEmail = $loginUserEmail["email"];
    // var_dump( $loginUserEmail );
		$renglon=0;
				$sql = "SELECT * FROM usuario, tracking_Payment WHERE usuario.clave=tracking_Payment.userid AND salesPerson='$loginUserEmail'";
			   $resultado= mysql_query($sql, $conexion);
			  //  var_dump($sql);
			$i=1;
             while ($row = mysql_fetch_array($resultado)) {
			   $usuario = $row['clave'];
			   $userEmail = $row['email'];
				
          ?>
    <tr valign="top" <?= color_lista($renglon); ?>>
      <td> <?= $i++ . "." ?> </td>
      <td> <?= $row['nombre'].' '.$row['apellidos'] . ' (' . $usuario . ')' ?> </td>
      <td> <?= date('d/m/Y',strtotime($row['fecha_registro'])); ?> </td>
      <td>
        <p style="padding:5px;text-align:center;background:#D1D1D1;border:2px solid cornflowerblue">
          <a href="mailto:
												<?= $row['email']; ?>"> <?= $row['email']; ?> </a>
        <p> <?php
					//----------subroto-19-feb-2017-start----------//
					$resMo = mysql_query("SELECT * FROM usuario WHERE clave IN (SELECT linked_user_id from usuario_linked_accounts WHERE user_id = '".$usuario."')",$conexion);
					while ($rowMoh = mysql_fetch_array($resMo))
					{
						echo '
												<br/>
												<p style="padding:5px;text-align:center;background:#D1D1D1;border:2px solid cornflowerblue">
													<button type="button" href="javascript:void(0)" class="deleteLinkedEmail" style="color:red" linked-id='.$rowMoh['clave'].' user-id='.$usuario.'>
									Unlink
								</button>
													<br/>
													<a href="mailto:'.$rowMoh['email'].'">'.$rowMoh['email'].'</a>
												</p>';
					}
					
					//----------subroto-19-feb-2017-end----------//
					?>
      </td>
      <!----------subroto-19-feb-2017-start---------->
      <td> <?= $row['subdominio']; ?> </td>
      <!-- <td >
											<?= $totalsize." MB" ; ?></td> -->
      <!-- <td >
											<?  $resCAT= mysql_query("SELECT * FROM cat_herramienta ORDER BY nombre",$conexion);
					  while ($rowCAT = mysql_fetch_array($resCAT)) {
						$cat_buscar = ' '.$rowCAT['clave'].',';
						if (strstr($row['categorias_herramientas'],$cat_buscar)) echo '-'.$rowCAT['nombre'].'<br />';
                      }
                  ?>
                  [<a href="javascript:openWindow('abc_cat_usuario.php?usuario=
											<?= $row['clave']; ?>','info','no','yes',500,460);">Editar</a>]</td><td>
											<? if ($row['subdominio_custom']==1) echo '-Config. subdominio<br />';
				  	   if ($row['tour_custom']==1) echo '-Config. tour virtual<br />';
				  	   if ($row['autoresponder_custom']==1) echo '-Config. autoresponder<br />';
				  	   if ($row['chat_custom']==1) echo '-Config. chat<br />';
					   if ($row['comments_custom']==1) echo '-Config. comments<br />';
					   if ($row['fbcomments_custom']==1) echo '-Config. comments Facebook<br />';
					   if ($row['fbpixel_custom']==1) echo '-Config. Pixel de conversi�n Facebook<br />';
                       if ($row['webminar_permission']==1) echo '-Config. Webinar<br />';
                       if($row['agenda_permission']==1){ echo '- Agenda '; }
					   if ($row['pagado']==0)
					   		echo '[<a href="javascript:openWindow(\'abc_permisos_usuario.php?usuario='.$row['clave'].'\',\'info\',\'no\',\'yes\',500,460);">Editar</a>]';
					   else echo '<strong>PAGANDO</strong><br>'.date('d/m/Y',strtotime($row['fecha_pago']));
					?></td><td>
											<? if ($row['template']) {
				  			$template = $row['template'];
							 $resTEM= mysql_query("SELECT * FROM landing_page WHERE clave=$template",$conexion);
			 				 $rowTEM= mysql_fetch_array($resTEM);
				  			 echo $rowTEM['nombre'].'<br>';
				  		}
					   if ($row['pagado2']==0)
					   		echo '[<a href="javascript:openWindow(\'abc_template_usuario.php?usuario='.$row['clave'].'\',\'info\',\'no\',\'yes\',500,460);">Editar</a>]';
					   else echo '<strong>PAGANDO</strong><br>'.date('d/m/Y',strtotime($row['fecha_pago2']));

				   ?></td><td>
											<?= $rowHIT['total_visitas'].'/'.number_format($retorno,2,'.',',').'%'; ?></td> -->
      <!-- Payment activation subroto 04 Sep 2022 Start -->
      <!-- <td><div class="tool_tip"><ul class="tt-wrapper">
											<? if ($row['presentaciones']==1) { ?><img src="../images/icon_activo.png" width="30" height="30"><li><a onClick="return confirm('&iquest;Est&aacute;s seguro que deseas Desactivar\nlas Presentaciones Autom&aacute;ticas\nal Usuario?')" href="desactivar_presentaciones.php?usuario=
											<?= $row['clave']; ?>"><img src="../images/icon_desactivar.png" alt="Desactivar Presentaciones Autom&aacute;ticas" width="30" height="30" border="0"><span>Desactivar presentaciones autom&aacute;ticas</span></a></li>
											<? } else { ?><li><a onClick="return confirm('&iquest;Est&aacute;s seguro que deseas Activar\nlas Presentaciones Autom�ticas\nal Usuario?')" href="activar_presentaciones.php?usuario=
											<?= $row['clave']; ?>"><img src="../images/icon_activar.png" alt="Activar Presentaciones Autom�ticas" width="30" height="30" border="0"><span>Activar presentaciones autom&aacute;ticas</span></a></li>
											<? } ?></ul></div></td> -->

      <td>
	<?php 
		$paymentStatus= mysql_query("select * from tracking_Payment WHERE userid=" . $usuario, $conexion);
		$paymentStatus= mysql_fetch_array($paymentStatus);
		if( $paymentStatus['nextPaymentDate'] !=null ) {
			$new_paymentDate = date('Y-m-d', strtotime( $paymentStatus['paymentDate'] ));
			echo "<p class='paymentDetails'>Paid On: " . $new_paymentDate . "</p>";
			$date1=date_create( date('Y-m-d') );
			$date2=date_create( $paymentStatus['nextPaymentDate'] );
			// var_dump(date_diff($date1, $date2)->days);
			if($date1>$date2) {
				// echo "Date1: " . date('Y-m-d'). " Date2: ". $paymentStatus['nextPaymentDate'];
				echo "<p class='redcolor'><span style='font-weight: bold;'>" . date_diff($date1, $date2)->days . "</span> days Over <br></p>";
			} else {
				echo "<p class='redcolor'><span style='font-weight: bold;'>" . date_diff($date1, $date2)->days . "</span> days to next payment <br></p>";
			}
			
		} else {
			// var_dump("select paymentDate, note from tracking_Payment WHERE userid=" . $usuario);
			if($paymentStatus['paymentReceipt']==NULL) {
				echo "<p class='redcolor'>No Payment Receipt Has been uploaded. User ID: " . $usuario . "</p>";
			} else {
				$target_file = "../paymentreceipt/" . $paymentStatus['paymentReceipt'];
				if (file_exists( $target_file )) {
					$fullFullPath = "https://vioniko.com/paymentreceipt/" . $paymentStatus['paymentReceipt'];
					// echo '<a target="_blank" href="'. $fullFullPath .'">View Receipt<img src="'. $fullFullPath .'"></a>';
					echo '<a target="_blank" href="'. $fullFullPath .'">View Receipt</a>';
				} else {
				echo "Uploaded But Not File Present Now.";
				}
				
			} ?>
		<?php } ?>
</td>	
<td>
  <?php
    $userid = $paymentStatus['userid'];
    $paidCommisions = $paymentStatus['paidCommisions'];
    $amount = mysql_fetch_array(mysql_query("SELECT SUM(amount) as amount FROM tracking_Payment WHERE salesPerson=(SELECT email FROM usuario WHERE clave=$userid)" , $conexion))['amount'];
    $amount = ($amount!=null) ? $amount : '0,00';
    $commisions = number_format($amount * 0.25, 2);
    echo "Total Sale: $$amount <br>Commisions: $$commisions (25%)<br>Paid: $$paidCommisions";
  ?>
	<input id="paidCommisions" name="paidCommisions" data-userid="<?php echo $usuario ?>" placeholder="Paid Commision Update">
	<p class="paidCommisions<?php echo $usuario ?>" style="color: green;"></p>
  
</td>
<td>
	<textarea id="w3review" name="w3review" rows="4" cols="30" data-userid="<?php echo $usuario ?>"><?php echo $paymentStatus['moderatorNote']; ?></textarea>
	<p class="saved<?php echo $usuario ?>" style="color: green;"></p>
</td>				
      <!-- End Opciones Column Subroto 07 Sep 2022-->
    </tr>
    
    <?
                 } // WHILE
              ?>
  </tbody>
</table>
</div>

<script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" ></script>
<script>
  // Note update dinamic
	$("textarea#w3review").blur(function(){
		var noteId = $(this).data('userid');
		// alert(values);
		var noteContent= $(this).val();
		var notificationClass= "saved" + noteId;
		var url = "ajaxload.php?noteId=" + noteId + "&noteContent=" + noteContent;
		// alert(url);
    // exit();
		$.get( url, function( data ) {
			// alert(notificationClass);
			// $( "." + notificationClass ).show( );
			$( "." + notificationClass ).html( data );
		});
  	});

  // Paid Commisions update dinamic
	$("input#paidCommisions").blur(function(){
		var paidCommisionsId = $(this).data('userid');
		// alert(values);
		var paidCommisionsAmount= $(this).val();
		var notificationClass= "paidCommisions" + paidCommisionsId;
		var url = "ajaxload.php?paidCommisionsId=" + paidCommisionsId + "&paidCommisionsAmount=" + paidCommisionsAmount;

		$.get( url, function( data ) {
			$( "." + notificationClass ).html( data );
		});
  	});
</script>
</body>
</html>
