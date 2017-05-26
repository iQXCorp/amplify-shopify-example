<?php
$webhook_content = '';
$webhook = fopen('php://input' , 'rb');
while(!feof($webhook)){ //loop through the input stream while the end of file is not reached
    $webhook_content .= fread($webhook, 4096); //append the content on the current iteration
}
fclose($webhook); //close the resource

$data = json_decode($webhook_content, true); //convert the json to array

require_once getcwd() . '/helper.php';

// get the topic
$topic = $_SERVER['HTTP_X_SHOPIFY_TOPIC'];

switch ($topic) {
  case "customers/create":
  case "customers/update":
      $transformedCustomer = transformCustomer($data);

      try {
          $result = $customer_api_instance->createOrUpdateCustomer($transformedCustomer);
          print_r($result);
      } catch (Exception $e) {
          echo 'Exception when calling CustomersApi->createOrUpdateCustomer: ', $e->getMessage(), PHP_EOL;
      }
      break;
  case "products/create":
  case "products/update":
      if (count($data['variants']) > 1) {
        $transformedProduct = transformComplexProduct($data);
      } else {
        $transformedProduct = transformSimpleProduct($data);
      }

      try {
          $result = $product_api_instance->createOrUpdateProduct($transformedProduct);
          print_r($result);
      } catch (Exception $e) {
          echo 'Exception when calling ProductsApi->createOrUpdateProduct: ', $e->getMessage(), PHP_EOL;
      }
      break;
  case "orders/paid":
      $transformedOrder = transformOrder($data);

      try {
        $result = $order_api_instance->createOrUpdateOrder($transformedOrder);
        print_r($result);
      } catch (Exception $e) {
        echo 'Exception when calling OrdersApi->createOrUpdateOrder: ', $e->getMessage(), PHP_EOL;
      }
      break;
}
?>
