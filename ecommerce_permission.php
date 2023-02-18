<?
   session_cache_limiter('private, must-revalidate');
   session_start();
   include_once('lib.php');
   if (empty($_SESSION['usu_valido'])) {
    $usuario = $_SESSION['usu_valido'];
     include('acces.php');
	 return;
   }

   extract($_SESSION); extract($_POST); extract($_GET);
   $ui_lang = isset($_GET['lang']) ? $_GET['lang'] : "es";
// echo "<pre>"; var_dump($_SESSION["usu_valido"]);exit();
?>
<!DOCTYPE html>
<html>
<head>
<title><? include('titulo.php'); ?></title>
<meta charset="UTF-8">
<link rel="icon" href="images/favicon3.0.ico" type="image/x-icon" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link rel="stylesheet" href="css/style.default.css" />
<link rel="stylesheet" href="css/responsive-tables.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="css/jquery.fancybox.min.css">

<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->

<script src="//code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="js/jquery.fancybox.min.js"></script>
<script src="js/jquery-migrate-1.2.1.min.js"></script>
<script src="js/jquery-ui-1.10.3.min.js"></script>

<script src="js/bootstrap.min.js"></script>
<script src="js/modernizr.min.js"></script>
<script src="js/jquery.cookies.js"></script>
<script src="js/jquery.uniform.min.js"></script>
<script src="js/flot/jquery.flot.min.js"></script>
<script src="js/flot/jquery.flot.resize.min.js"></script>
<script src="js/responsive-tables.js"></script>
<script src="js/jquery.slimscroll.js"></script>
<script src="js/custom.js"></script>

<script type="text/javascript" src="js/setup.js"></script>
<script type="text/javascript" src="scripts_lib.js"></script>
<script type="text/javascript" src="js/main.js"></script>

<script type="text/javascript" src="js/Chart.js"></script>
<style>
  .form-control {
    display: inline-block;
    width: auto;
    vertical-align: middle;
    padding: .375rem .75rem;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: .25rem;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
}
.btn-primary {
    color: #fff;
    background-color: #007bff;
    border-color: #007bff;
}
.btn {
    display: inline-block;
    font-weight: 400;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    border: 1px solid transparent;
    padding: .60rem 2rem;
    line-height: 1.5;
    border-radius: .25rem;
    margin-right: 10px;
    transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
}
.rateValue , .promoValue, .paypalValue, .durationValue, .linkAfterLoginValue, .percentageOfCommisionsValue {
  font-weight: 600;
}
.info {
  font-size: 10px;
  color: #e74c3c;
}
</style>

<script language="JavaScript">
  function meta() {
    document.forma.action='principal.php';
	document.forma.target='_self';
    document.forma.submit();
  }
  function imprimir(cond,ini,fin,ini2,fin2) {
    document.forma.fec_ini.value=ini;
    document.forma.fec_fin.value=fin;
	document.forma.fecha_ini.value=ini2;
	document.forma.fecha_fin.value=fin2;
	document.forma.condicion_print.value=cond;
    document.forma.action='imprimir_eventos.php';
	document.forma.target='_blank';
    document.forma.submit();
  }
  // Code goes here
  $(document).ready(function(){
      $("#button2").click(function(){
        if ( $.trim( $(this).text() ) == "MOSTRAR") {
          $(this).html('<i class="fa fa-angle-up"></i> OCULTAR');
        } else {
          $(this).html('<i class="fa fa-angle-down"></i> MOSTRAR');
        }
      });
      $("#button1").click(function(){
        if ( $.trim( $(this).text() ) == "MOSTRAR") {
          $(this).html('<i class="fa fa-angle-up"></i> OCULTAR');
        } else {
          $(this).html('<i class="fa fa-angle-down"></i> MOSTRAR');
        }
      });
  });
</script>

<!--[if lte IE 8]>
<script src="js/excanvas.min.js"></script>
<![endif]-->

</head>

<body>

<div id="mainwrapper" class="mainwrapper">

    <div class="header">

        <div class="logo">
            <a href="principal.php"><? include('logo.php'); ?></a>
        </div>
        <div class="headerinner">
            <? include('header.php'); ?><!--headmenu-->
        </div>
    </div>

    <div class="leftpanel">

    <? include('menu.php'); ?>
    <!-- leftpanel -->

     </div><!-- leftpanel -->

    <div class="rightpanel">
		<div class="ecommerce" style="margin: 50px 0 0 50px;">
    <? 
      include('conexion.php');;
			$rateAndPromo = mysql_fetch_array(mysql_query("SELECT * FROM userPermission WHERE userid='$usuario'" , $conexion));
			$rate = $rateAndPromo['rate'];
			$promo = $rateAndPromo['codigo_promo'];
			$promo = mysql_fetch_array(mysql_query("SELECT codigo_promo FROM `landing_page` WHERE clave=$promo" , $conexion))['codigo_promo'];
			$duration = $rateAndPromo['duration'];
			$paypal = $rateAndPromo['paypal'];
			$linkAfterLogin = $rateAndPromo['linkAfterLogin'];
			$percentageOfCommisions = $rateAndPromo['percentageOfCommisions'];
    ?>
			<h4>Current rate:
  		<input type="number" name="rate" id="rate" class="rate form-control" placeholder="New Rate" data-userid="<?php echo $usuario; ?>">
			<button type="submit" class="button btn btn-primary"> Save </button> $<span class="rateValue"><?=$rate ?></span></h4> <br>
      <h4>Promo Code: </span>
  		<input type="text" name="promo" id="promo" class="promo form-control" placeholder="Update Promo" data-userid="<?php echo $usuario; ?>">
      <button type="submit" class="button btn btn-primary"> Save </button> <span class="promoValue"><?=$promo ?></h4> <br>
      <h4>Duration: 
      <select name="duration" placeholder="*Selecciona Month" class="form-control"  id="duration" data-userid="<?php echo $usuario; ?>">
        <option value="">*Selecciona tu Duration</option>
        <option value="1">1 Month</option>
        <option value="2">2 Months</option>
        <option value="3">3 Months</option>
        <option value="4">4 Months</option>
        <option value="5">5 Months</option>
        <option value="6">6 Months</option>
        <option value="7">7 Months</option>
        <option value="8">8 Months</option>
        <option value="9">9 Months</option>
        <option value="10">10 Months</option>
        <option value="11">11 Months</option>
        <option value="12">1 Year</option>
        <option value="24">2 Years</option>
      </select>
      <button type="submit" class="button btn btn-primary"> Save </button> <span class="durationValue"><?=$duration; echo ( $duration > 1 ) ? ' Months' : ' Month'; ?></span></h4> <br>
      <h4>PayPal Email: 
  		<input type="text" name="paypal" id="paypal" class="paypal form-control" placeholder="Update PayPal Email" data-userid="<?php echo $usuario; ?>">
      <button type="submit" class="button btn btn-primary"> Save </button> <span class="paypalValue"> <?=$paypal ?></span></h4><br>
      <h4>Link After Login:
  		<input type="text" name="linkAfterLogin" id="linkAfterLogin" class="linkAfterLogin form-control" placeholder="Link After Login" data-userid="<?php echo $usuario; ?>">
      <button type="submit" class="button btn btn-primary"> Save </button> <span class="linkAfterLoginValue"> <?=$linkAfterLogin ?></span>
      <span class="info">( Keep Blank for Default link )</span>
      </h4>      <br>
      <h4>Percentage of Commisions:
  		<input type="number" name="percentageOfCommisions" id="percentageOfCommisions" class="percentageOfCommisions form-control" placeholder="ie. 25%" data-userid="<?php echo $usuario; ?>">
      <button type="submit" class="button btn btn-primary"> Save </button> <span class="percentageOfCommisionsValue"> <?=$percentageOfCommisions ?>%</span>
      </h4>
      <div class="saveRateInfo"></div>
		</div>
        

    </div><!--rightpanel-->

</div>


<!--mainwrapper-->
<script type="text/javascript">
  // Rate Dynamic update
	$("input, select").blur(function(){
		var userid = $(this).data('userid');
		var rateValue= $(this).val();
    var rateOrPromo = $(this).attr("id");
    if(rateValue=="" && rateOrPromo!="linkAfterLogin") {
      exit();
    }
		var notificationClass= "saved" + userid;
		var url = "ajaxload.php?userid=" + userid + "&"+ rateOrPromo +"=" + rateValue;
		// alert( url );
		$.get( url, function( data ) {
      var objData = jQuery.parseJSON( data );
      if(objData.rateOrPromo == 'rate') {
        $( ".rateValue" ).text( objData.message );
        message = "<p style='color: green; font-weight: bold;'> " + objData.message + " Saved </p>";
        $( ".saveRateInfo" ).html( message );
      } else if(objData.rateOrPromo == 'promo') {
        $( ".promoValue" ).text( objData.message );
        message = "<p style='color: green; font-weight: bold;'> " + objData.message + " Saved </p>";
        $( ".saveRateInfo" ).html( message );
      } else if(objData.rateOrPromo == 'duration') {
        $( ".durationValue" ).text( objData.message );
        message = "<p style='color: green; font-weight: bold;'> " + objData.message + " Saved </p>";
        $( ".saveRateInfo" ).html( message );
      } else if(objData.rateOrPromo == 'paypal') {
        $( ".paypalValue" ).text( objData.message );
        message = "<p style='color: green; font-weight: bold;'> " + objData.message + " Saved </p>";
        $( ".saveRateInfo" ).html( message );
      } else if(objData.rateOrPromo == 'linkAfterLogin') {
        $( ".linkAfterLoginValue" ).text( objData.message );
        message = "<p style='color: green; font-weight: bold;'> " + objData.message + " Saved </p>";
        $( ".saveRateInfo" ).html( message );
      } else if(objData.rateOrPromo == 'percentageOfCommisions') {
        $( ".percentageOfCommisionsValue" ).text( objData.message );
        message = "<p style='color: green; font-weight: bold;'> " + objData.message + " Saved </p>";
        $( ".saveRateInfo" ).html( message );
      } else {
        message = "<p style='color: red; font-weight: bold;'> " + objData.message + "</p>";
        $( ".saveRateInfo" ).html( message );
      }

		});
  	});

    jQuery(document).ready(function(){

        //Replaces data-rel attribute to rel.
        //We use data-rel because of w3c validation issue
        jQuery('a[data-rel]').each(function() {
            jQuery(this).attr('rel', jQuery(this).data('rel'));
        });

        jQuery('#tooltips .btn').tooltip();
        jQuery('#popovers .btn').popover();
    });
</script>
<script>
	var randomScalingFactor = function(){ return Math.round(Math.random()*100)};

	var barChartData = {
		labels : ["Puntos de Hoy","Puntos de Ayer","Promedio de <?= $meses[$mes_anterior]?>","Puntos m&aacute;s Altos <?= $fecha_mostrar; ?>","Visitas","Registros","Videos"],
		datasets : [
			{
				fillColor : "rgba(220,220,220,0.5)",
				strokeColor : "rgba(220,220,220,0.8)",
				highlightFill: "rgba(220,220,220,0.75)",
				highlightStroke: "rgba(220,220,220,1)",
				data : [<?= $ganados_hoy; ?>,<?= $ganados_ayer; ?>,<?= $ganados_mesant; ?>,<?= $ganados_alto; ?>,<?= $rowHIT['total_visitas']; ?>,<?= $total_subdominio; ?>,<?= $total_videos; ?>]
			},
			{
				fillColor : "rgba(151,187,205,0.5)",
				strokeColor : "rgba(151,187,205,0.8)",
				highlightFill : "rgba(151,187,205,0.75)",
				highlightStroke : "rgba(151,187,205,1)",
				data : [<?= $rendimiento_hoy; ?>,<?= $rendimiento_ayer; ?>,<?= $rendimiento_mesant; ?>,<?= $rendimiento_alto; ?>,<?= number_format($retorno,2,'.',','); ?>,<?= $total_subdominio; ?>,<?= $total_videos; ?>]
			}
		]

	}
	window.onload = function(){
		var ctx = document.getElementById("canvas").getContext("2d");
		window.myBar = new Chart(ctx).Bar(barChartData, {
			responsive : true
		});
	}
	
	</script>

</body>
</html>
