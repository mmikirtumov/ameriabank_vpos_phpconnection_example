<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ameriabank vPOS example backURL</title>
<body>

<?
// Send Receive Code //

try{

$options = array( 

            'soap_version'    => SOAP_1_1, 

            'exceptions'      => true, 

            'trace'           => 1, 

            'wdsl_local_copy' => true

            );

            //header('Content-Type: text/plain');

$client = new SoapClient("https://payments.ameriabank.am/webservice/PaymentService.svc?wsdl", $options);

 
//echo $_POST['orderid'];
//print_r($_POST);
 

// Set parameters

$parms['paymentfields']['ClientID'] = 'yourclient'; // clientID from Ameriabank

$parms['paymentfields']['Description'] = "Order Description";

$parms['paymentfields'] ['OrderID']= $_POST['orderID'];

$parms['paymentfields'] ['Password']= "yourpassword"; // password from Ameriabank

$parms['paymentfields'] ['PaymentAmount']= 100; // payment amount of your Order

$parms['paymentfields'] ['Username']= "yourusername"; // username from Ameriabank


 

// Call web service PassMember methord and print response

$webService = $client-> GetPaymentFields($parms);

echo($webService->GetPaymentFieldsResult->amount." ");

echo($webService->GetPaymentFieldsResult->respcode." ");

echo($webService->GetPaymentFieldsResult ->cardnumber." ");

echo($webService->GetPaymentFieldsResult ->paymenttype." ");
 	
echo($webService->GetPaymentFieldsResult ->authcode." ");



if($webService->GetPaymentFieldsResult->respcode == '00')
{
	if($webService->GetPaymentFieldsResult ->paymenttype == '1')
	 {
		$webService1 = $client-> Confirmation($parms);
		if($webService1->ConfirmationResult->Respcode == '00')
		 {
		 	// you can print your check or call Ameriabank check example
		   echo 	'<iframe id="idIframe" src="https://payments.ameriabank.am/forms/frm_checkprint.aspx?lang=am&paymentid='.$_POST['paymentid'].'" width="560px" height="820px" frameborder="0"></iframe>';
		 }
		 else
		 {
		 	// Rediract to Exception Page
			echo "<script type='text/javascript'>\n";
			echo "window.location.replace(document.getElementsByTagName('base')[0].href+"."'".$langs_id."'"."+'/error.html');";
			echo "</script>";
		 }
	 }
	 else
	 {
	 	// you can print your check or call Ameriabank check example
	   echo 	'<iframe id="idIframe" src="https://payments.ameriabank.am/forms/frm_checkprint.aspx?lang=am&paymentid='.$_POST['paymentid'].'" width="560px" height="820px" frameborder="0"></iframe>';
	 }
//$db1->request("
//			UPDATE orders_history	
//			SET    orders_history.payment_id = '".$webService->GetPaymentIDResult->PaymentID."'
//			WHERE  orders_history.order_id = '".$_POST['view_id']."'");	

}
else
{
	// Rediract to Exception Page
 	echo "<script type='text/javascript'>\n";
	echo "window.location.replace(document.getElementsByTagName('base')[0].href+"."'".$langs_id."'"."+'/error.html');";
	echo "</script>";

}
       } catch (Exception $e) {

       echo 'Caught exception:',  $e->getMessage(), "\n";

} 
// End Send Receive Code //

?>
</body>
</html>
