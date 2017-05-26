<?php
require_once getcwd() . '/helper.php';

$inTestMode = true;

$products = $shopify->getProducts();
$customers = $shopify->getCustomers();
$orders = $shopify->getOrders();

$productsArray = $products['products'];
$customersArray = $customers['customers'];
$ordersArray = $orders['orders'];

foreach ($customersArray as $key => $customer) {
  # code...
  $transformedCustomer = transformCustomer($customer);

  try {
      $result = $customer_api_instance->createOrUpdateCustomer($transformedCustomer);
      print_r($result);
  } catch (Exception $e) {
      echo 'Exception when calling CustomersApi->createOrUpdateCustomer: ', $e->getMessage(), PHP_EOL;
  }

}

foreach ($productsArray as $key => $product) {
  # code...
  if (count($product['variants']) > 1) {
    $transformedProduct = transformComplexProduct($product);
  } else {
    $transformedProduct = transformSimpleProduct($product);
  }

  try {
      $result = $product_api_instance->createOrUpdateProduct($transformedProduct);
      print_r($result);
  } catch (Exception $e) {
      echo 'Exception when calling ProductsApi->createOrUpdateProduct: ', $e->getMessage(), PHP_EOL;
  }

}

foreach ($ordersArray as $key => $order) {

  $transformedOrder = transformOrder($order);

  try {
    $result = $order_api_instance->createOrUpdateOrder($transformedOrder);
    print_r($result);
  } catch (Exception $e) {
    echo 'Exception when calling OrdersApi->createOrUpdateOrder: ', $e->getMessage(), PHP_EOL;
  }

}

$webhookTypes = array(
  'customers/create',
  'customers/update',
  'products/create',
  'products/update',
  'orders/paid'
);

// if shopify is in test mode wipe all webhooks from the store
  if ($inTestMode) {
    $webhooksForDelete = $shopify->getWebhooks();

    foreach ($webhooksForDelete['webhooks'] as $key => $value) {

      try {
        $result = $shopify->deleteWebhook(["id" => $value['id']]);
        print_r($result);
      } catch (Exception $e) {
        echo 'Exception when calling $shopify->deleteWebhook: ', $e->getMessage(), PHP_EOL;
      }
    }

  }

  foreach ($webhookTypes as $webhookType) {

    try {
      $result = $shopify->createWebhook(['webhook' => array('topic' => $webhookType,
                                         'address' => 'https://amplifyphp.localtunnel.me/amplify-shopify-example/webhook.php',
                                         'format' => 'json')]);
      print_r($result);
    } catch (Exception $e) {
      echo 'Exception when calling $shopify->createWebhook: ', $e->getMessage(), PHP_EOL;
    }
  }


?>
