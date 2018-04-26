<?php
/*
* Avaliable $_POST Keys
* 'credit_card_number'
* 'credit_card_expiration'
* 'credit_card_code'
* 'order_description'
* 'customer_email'
* 'transaction_amount_usd'
*/

require 'vendor/autoload.php';

use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;

define("AUTHORIZENET_LOG_FILE", "authorizenet_log.txt");

$fp = fopen("response-file.txt", "a+");

if(isset($_POST['credit_card_number']) &&
  isset($_POST['credit_card_expiration']) &&
  isset($_POST['credit_card_code']) &&
  isset($_POST['order_description']) &&
  isset($_POST['customer_email']) &&
  isset($_POST['transaction_amount_usd'])) {

    $credit_card_number = $_POST['credit_card_number'];
    $credit_card_expiration = $_POST['credit_card_expiration'];
    $credit_card_code = $_POST['credit_card_code'];
    $order_description = $_POST['order_description'];
    $customer_email = $_POST['customer_email'];
    $transaction_amount_usd = intval($_POST['transaction_amount_usd']);

    /* Create a merchantAuthenticationType object with authentication details
       retrieved from the constants file */
    $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
    $merchantAuthentication->setName("8B8et3kYhP");
    $merchantAuthentication->setTransactionKey("8h97nADtm8G8493Y");

    // Set the transaction's refId
    $refId = 'ref' . time();

    // Create the payment data for a credit card
    $creditCard = new AnetAPI\CreditCardType();
    $creditCard->setCardNumber($credit_card_number); //$creditCard->setCardNumber("4111111111111111");
    $creditCard->setExpirationDate($credit_card_expiration); //$creditCard->setExpirationDate("2038-12");
    $creditCard->setCardCode($credit_card_code); //$creditCard->setCardCode("123");

    // Add the payment data to a paymentType object
    $paymentOne = new AnetAPI\PaymentType();
    $paymentOne->setCreditCard($creditCard);

    // Create order information
    $order = new AnetAPI\OrderType();
    $order->setDescription($order_description); //$order->setDescription("Donation");

    // Set the customer's identifying information
    $customerData = new AnetAPI\CustomerDataType();
    $customerData->setEmail($customer_email); //$customerData->setEmail("george.shaw@ennovar.wichita.edu");

    // Create a TransactionRequestType object and add the previous objects to it
    $transactionRequestType = new AnetAPI\TransactionRequestType();
    $transactionRequestType->setTransactionType("authCaptureTransaction");
    $transactionRequestType->setAmount($transaction_amount_usd); //$transactionRequestType->setAmount(20.20);
    $transactionRequestType->setOrder($order);
    $transactionRequestType->setPayment($paymentOne);
    $transactionRequestType->setCustomer($customerData);

    // Assemble the complete transaction request
    $request = new AnetAPI\CreateTransactionRequest();
    $request->setMerchantAuthentication($merchantAuthentication);
    $request->setRefId($refId);
    $request->setTransactionRequest($transactionRequestType);

    // Create the controller and get the response
    $controller = new AnetController\CreateTransactionController($request);
    // For PRODUCTION use
    $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);
    // For SANDBOX use
    // $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);

    if ($response != null) {
        // Check to see if the API request was successfully received and acted upon
        if ($response->getMessages()->getResultCode() == "Ok") {
            // Since the API request was successful, look for a transaction response
            // and parse it to display the results of authorizing the card
            $tresponse = $response->getTransactionResponse();

            if ($tresponse != null && $tresponse->getMessages() != null) {
                fwrite($fp," Successfully created transaction with Transaction ID: " . $tresponse->getTransId() . "\n");
                fwrite($fp," Transaction Response Code: " . $tresponse->getResponseCode() . "\n");
                fwrite($fp," Message Code: " . $tresponse->getMessages()[0]->getCode() . "\n");
                fwrite($fp," Auth Code: " . $tresponse->getAuthCode() . "\n");
                fwrite($fp," Description: " . $tresponse->getMessages()[0]->getDescription() . "\n");
            } else {
                fwrite($fp,"Transaction Failed \n");
                if ($tresponse->getErrors() != null) {
                    fwrite($fp," Error Code  : " . $tresponse->getErrors()[0]->getErrorCode() . "\n");
                    fwrite($fp," Error Message : " . $tresponse->getErrors()[0]->getErrorText() . "\n");
                }
            }
            // Or, print errors if the API request wasn't successful
        } else {
            fwrite($fp,"Transaction Failed \n");
            $tresponse = $response->getTransactionResponse();

            if ($tresponse != null && $tresponse->getErrors() != null) {
                fwrite($fp," Error Code  : " . $tresponse->getErrors()[0]->getErrorCode() . "\n");
                fwrite($fp," Error Message : " . $tresponse->getErrors()[0]->getErrorText() . "\n");
            } else {
                fwrite($fp," Error Code  : " . $response->getMessages()->getMessage()[0]->getCode() . "\n");
                fwrite($fp," Error Message : " . $response->getMessages()->getMessage()[0]->getText() . "\n");
            }
        }
    } else {
        fwrite($fp, "No response returned \n");
    }
}
else {
  fwrite($fp, "Not all of the required post data was sent at " . date("l jS \of F Y h:i:s A") . "\n");
  fwrite($fp, "Post Dump:\n");
  fwrite($fp, var_dump($_POST));
}

fwrite($fp, "\n");
fclose($fp);

if(isset($_POST["customer_email"])) {
  mail($_POST["customer_email"], "Thank you for your donation to Bethel College", "Thank you for your generous support of Bethel College and our students.  We appreciate your gift and the ways it helps to enhance the educational experience of our students. Please check us out on any of our social media platforms.\r\n\r\nSincerely,\r\nYour Bethel College Advancement Team");
}

mail("ghiebert@bethelks.edu", "New donation submission", print_r($_POST, true));

header('Location: https://www.bethelks.edu/');
exit();
?>
