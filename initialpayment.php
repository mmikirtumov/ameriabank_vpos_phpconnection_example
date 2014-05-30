<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>
Ameriabank vPOS example
</title>
<body>
<?



//get orderID for request
$last_insert_id = mysql_insert_id();

// $db1->request("INSERT INTO orders_history VALUES ('','".$_SESSION['all']."','".$_SESSION['validuserid']."','".$_SESSION['total_price']."','".date("Y-m-d")."','','0','','".$_POST['branches']."','".$_POST['date_time']."','".$_POST['persons']."','".$last_insert_id."','')");


try{

$options = array( 

            'soap_version'    => SOAP_1_1, 

            'exceptions'      => true, 

            'trace'           => 1, 

            'wdsl_local_copy' => true

            );

            //header('Content-Type: text/plain');

$client = new SoapClient("https://payments.ameriabank.am/webservice/PaymentService.svc?wsdl", $options);

 

 

// Set parameters

$parms['paymentfields']['ClientID'] = 'yourclient'; // clientID from Ameriabank

$parms['paymentfields']['Description'] =ORDER_DESCRIPTION;

$parms['paymentfields'] ['OrderID']= $last_insert_id;// orderID wich must be unique for every transaction;

$parms['paymentfields'] ['Password']= "yourpassword"; // password from Ameriabank

$parms['paymentfields'] ['PaymentAmount']= 100; // payment amount of your Order

$parms['paymentfields'] ['Username']= "yourusername"; // username from Ameriabank

$parms['paymentfields'] ['backURL']= "http://wwwexample.com/back.html"; // your backurl after transaction rediracted to this url

 

// Call web service PassMember methord and print response

$webService = $client-> GetPaymentID($parms);

echo($webService->GetPaymentIDResult->Respcode." ");

echo($webService->GetPaymentIDResult->Respmessage." ");

echo($webService->GetPaymentIDResult->PaymentID." ");


if($webService->GetPaymentIDResult->Respcode == '1' && $webService->GetPaymentIDResult->Respmessage =='OK')
{
	
	//rediract to Ameriabank server or you can use iFrame to show on your page
	echo "<script type='text/javascript'>\n";
	echo "window.location.replace('https://payments.ameriabank.am/forms/frm_paymentstype.aspx?clientid=7030b78e-7630-42c0-af48-3b1998f1da29&clienturl=http://test.am/ameriarequestframe.aspx&lang=am&paymentid=".$webService->GetPaymentIDResult->PaymentID."');\n";
	echo "</script>";

}
else
{
	//Show your exception page
	echo "<script type='text/javascript'>\n";
	echo "window.location.replace(document.getElementsByTagName('base')[0].href+"."'".$langs_id."'"."+'/error.html');";
	echo "</script>";
}

       } catch (Exception $e) {

       echo 'Caught exception:',  $e->getMessage(), "\n";

} 
// End Send Receive Code //

//}
//}
?>
</body>
</head>
</html>
