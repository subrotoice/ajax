<?php
// var_dump($_POST);
include("conexion.php");
$path = 'file_upload/files/'; // upload directory
if(isset($_POST['presentor_id'])) {
    $webinarId = $_POST['presentor_id'];
    $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
    if($_FILES['image']) {
    $img = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];
    // get uploaded file's extension
    $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
    // can upload same image using rand function
    $final_image = "presentor_" . $webinarId . '.' . $ext;
    var_dump($final_image);
    // check's valid format
    if(in_array($ext, $valid_extensions)) { 
    $path = $path.strtolower($final_image);
    if (file_exists($target_file)) {
        unlink($target_file);
    } 
        if(move_uploaded_file($tmp, $path)) {
            echo "<img src='$path' />"; // Json Output
            echo 'Image Full Path: ';
            $path = 'https://vioniko.com/' . $path;
            var_dump($path);
    
            // Database Updating Work
            $sql = "UPDATE webinar SET presentor_image= '$path' WHERE ID=$webinarId";
            var_dump($sql);
            $queryResult = mysql_query($sql, $conexion);
    
            // Redirect after work
            function Redirect($url, $permanent = false)
            {
                if (headers_sent() === false)
                {
                    header('Location: ' . $url, true, ($permanent === true) ? 301 : 302);
                }
    
                exit();
            }
            $url = "https://vioniko.com/webinar.php?id=" . $webinarId;
            Redirect( $url, false );
        }
        } else {
            echo 'invalid';  // Json Output
        }
    }
}

if(isset($_POST['thankyou_image_id'])) {
    $webinarId = $_POST['thankyou_image_id'];
    $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
    $path = 'file_upload1/'; // upload directory
    if($_FILES['image']) {
    $img = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];
    // get uploaded file's extension
    $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
    // can upload same image using rand function
    $final_image = "thankyou_image_" . $webinarId . '.' . $ext;
    var_dump($final_image);
    // check's valid format
    if(in_array($ext, $valid_extensions)) { 
    $path = $path.strtolower($final_image);
    if (file_exists($target_file)) {
        unlink($target_file);
    } 
        if(move_uploaded_file($tmp, $path)) {
            echo "<img src='$path' />"; // Json Output
            echo 'Image Full Path: ';
            $path = 'https://vioniko.com/' . $path;
            var_dump($path);
    
            // Database Updating Work
            $sql = "UPDATE webinar SET thankyou_image= '$path' WHERE ID=$webinarId";
            var_dump($sql);
            $queryResult = mysql_query($sql, $conexion);
    
            // Redirect after work
            function Redirect($url, $permanent = false)
            {
                if (headers_sent() === false)
                {
                    header('Location: ' . $url, true, ($permanent === true) ? 301 : 302);
                }
    
                exit();
            }
            $url = "https://vioniko.com/webinar.php?id=" . $webinarId;
            Redirect( $url, false );
        }
        } else {
            echo 'invalid';  // Json Output
        }
    }
}

if(isset($_GET['userid'])) {
    $userid = $_REQUEST["userid"];
    if(isset($_REQUEST["rate"]) && $_REQUEST["rate"]!="") {
        $rate = $_REQUEST["rate"];
        $sql = "UPDATE userPermission SET rate = '$rate' WHERE userid = $userid"; 
        $queryResult= mysql_query($sql, $conexion);
        echo json_encode( array('rateOrPromo' => 'rate', 'message'=> $rate) );
    } else if(isset($_REQUEST["promo"]) && $_REQUEST["promo"]!="") {
        $promo = $_REQUEST["promo"];
        $sql = "SELECT * FROM landing_page WHERE codigo_promo = '". $promo ."'";
        $promoTable = mysql_query($sql , $conexion);
        $promoTableClave = mysql_fetch_array($promoTable)['clave'];
        $rowCount = mysql_num_rows($promoTable);
        if( $rowCount>0 ) {
            $sql = "UPDATE userPermission SET codigo_promo = '$promoTableClave' WHERE userid = $userid"; 
            $queryResult= mysql_query($sql, $conexion);
            echo json_encode( array('rateOrPromo' => 'promo', 'message'=> $promo) );
        } else {
            echo json_encode( array('rateOrPromo' => '0', 'message'=> 'Invalid Promo') );
        }
    } else if(isset($_REQUEST["duration"]) && $_REQUEST["duration"]!="") {
        $duration = $_REQUEST["duration"];
        $sql = "UPDATE userPermission SET duration = $duration WHERE userid = $userid"; 
        $queryResult= mysql_query($sql, $conexion);
        $months = $duration > 1 ? ' Months' : ' Month';
        $duration = $duration . ' ' . $months;
        echo json_encode( array('rateOrPromo' => 'duration', 'message'=> $duration) );
    }  else if(isset($_REQUEST["paypal"]) && $_REQUEST["paypal"]!="") {
        $paypal = $_REQUEST["paypal"];
        $sql = "UPDATE userPermission SET paypal = '$paypal' WHERE userid = $userid"; 
        $queryResult= mysql_query($sql, $conexion);
        echo json_encode( array('rateOrPromo' => 'paypal', 'message'=> $paypal) );
    } else if(isset($_REQUEST["linkAfterLogin"])) {
        $linkAfterLogin = $_REQUEST["linkAfterLogin"];
        $sql = "UPDATE userPermission SET linkAfterLogin = '$linkAfterLogin' WHERE userid = $userid"; 
        $queryResult= mysql_query($sql, $conexion);
        echo json_encode( array('rateOrPromo' => 'linkAfterLogin', 'message'=> $linkAfterLogin) );
    } else if(isset($_REQUEST["percentageOfCommisions"])) {
        $percentageOfCommisions = $_REQUEST["percentageOfCommisions"];
        $sql = "UPDATE userPermission SET percentageOfCommisions = '$percentageOfCommisions' WHERE userid = $userid"; 
        $queryResult= mysql_query($sql, $conexion);
        echo json_encode( array('rateOrPromo' => 'percentageOfCommisions', 'message'=> $percentageOfCommisions) );
    } 
}

if(isset($_GET['noteId'])) {
    $noteId = $_GET['noteId'];
    $noteContent = $_REQUEST["noteContent"];

    // $sql = "INSERT INTO tracking_Payment (userid, paymentDate) VALUES ('$q', '$time')"; 
    $sql = "UPDATE tracking_Payment SET moderatorNote = '$noteContent' WHERE userid = $noteId"; 
    // var_dump($sql);
    $queryResult= mysql_query($sql, $conexion);
    $paymentStatus ="<p style='color: green; font-weight: bold;'> Saved </p>";
    // Output "no suggestion" if no hint was found or output correct values
    // echo $paymentStatus === "" ? "no suggestion" : $paymentStatus;

    echo $paymentStatus;
}

if(isset($_GET['paidCommisionsId'])) {
    $paidCommisionsId = $_GET['paidCommisionsId'];
    $paidCommisionsAmount = $_REQUEST["paidCommisionsAmount"];

    // $sql = "INSERT INTO tracking_Payment (userid, paymentDate) VALUES ('$q', '$time')"; 
    $sql = "UPDATE tracking_Payment SET paidCommisions = '$paidCommisionsAmount' WHERE userid = $paidCommisionsId"; 
    // var_dump($sql);
    $queryResult= mysql_query($sql, $conexion);
    $paymentStatus ="<p style='color: green; font-weight: bold;'> Saved </p>";
    // Output "no suggestion" if no hint was found or output correct values
    // echo $paymentStatus === "" ? "no suggestion" : $paymentStatus;

    echo $paymentStatus;
}


?>
