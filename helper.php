<?php
require_once getcwd() . '/header.php';

if (!function_exists('sum')) {
  function sum($carry, $item)
  {
      $carry += $item;
      return $carry;
  }
}
if (!function_exists('extractPrice')) {
  function extractPrice($item)
  {
      return $item['price'];
  }
}
if (!function_exists('addProductReference')) {
  function addProductReference($item)
  {
      $item['product_ref_id'] = $item['product_id'];
      return $item;
  }
}

if (!function_exists('transformSimpleProduct')) {
    function transformSimpleProduct($product)
    {
      $outOfStock = ($product['variants'][0]['inventory_quantity'] === 0
                    ? true
                    : false);

      if (!$product['variants'][0]['requires_shipping']) {
        $outOfStock = false;
      }

      $productTags = explode(",", $product['tags']);

      $productImage = ($product['image'] != null) ? $product['image']['src'] : "";

      $formattedProduct = new \Swagger\Client\Model\Product();
      $productVariant = new \Swagger\Client\Model\ProductVariants();

      $formattedProduct->setCategories($product['product_type']);
      $formattedProduct->setCurrency("USD");
      $formattedProduct->setHandle(sprintf("https://modern-carg-cult.myshopify.com/products/%s", $product['handle']));
      $formattedProduct->setImageSourceUrl($productImage);
      $formattedProduct->setImageThubnail($productImage);
      $formattedProduct->setIsDownloadable(!$product['variants'][0]['requires_shipping']);
      $formattedProduct->setIsVirtual(!$product['variants'][0]['requires_shipping']);
      $formattedProduct->setOutStock($outOfStock);
      $formattedProduct->setPrice($product['variants'][0]['price'] ? floatval($product['variants'][0]['price']) : 0.00);
      $formattedProduct->setPriceCompare($product['variants'][0]['compare_at_price'] ? floatval($product['variants'][0]['compare_at_price']) : 0.00);
      $formattedProduct->setProductTags($productTags);
      $formattedProduct->setPublishedAt($product['published_at']);
      $formattedProduct->setRefId($product['id'] . "");
      $formattedProduct->setSku($product['variants'][0]['sku']);
      $formattedProduct->setSource("shopify");
      $formattedProduct->setTags($product['tags']);
      $formattedProduct->setTitle($product['title']);
      $formattedProduct->setType("simple");
      $formattedProduct->setUserId("");
      $formattedProduct->setVendor($product['vendor']);

      $formattedProduct->variants = array();

      $productVariant->setAttributes(array());
      $productVariant->setCreated($product['variants'][0]['created_at']);
      $productVariant->setImageSourceUrl($productImage);
      $productVariant->setInStock(!$outOfStock);
      $productVariant->setInventoryManagement($product['variants'][0]['inventory_management'] || "");
      $productVariant->setInventoryQuantity($product['variants'][0]['inventory_quantity'] . "");
      $productVariant->option1 = "";
      $productVariant->setPrice($product['variants'][0]['price'] ? floatval($product['variants'][0]['price']) : 0.00);
      $productVariant->setPriceCompare($product['variants'][0]['compare_at_price'] ? floatval($product['variants'][0]['compare_at_price']) : 0.00);
      $productVariant->setProductRefId($product['id'] . "");
      $productVariant->setRefId($product['variants'][0]['id'] . "");
      $productVariant->setSku($product['variants'][0]['sku'] . "");
      $productVariant->setTaxable($product['variants'][0]['taxable']);
      $productVariant->setTitle($product['variants'][0]['title']);
      $productVariant->setUpdated($product['variants'][0]['updated_at']);
      $productVariant->setVisible(true);
      $productVariant->setWeight($product['variants'][0]['weight']);

      array_push($formattedProduct->variants, $productVariant);

      return $formattedProduct;
    }
}


if (!function_exists('transformComplexProduct')) {
    function transformComplexProduct($product)
    {
      $outOfStock = ($product['variants'][0]['inventory_quantity'] === 0
                    ? true
                    : false);

      if (!$product['variants'][0]['requires_shipping']) {
        $outOfStock = false;
      }

      $productTags = explode(",", $product['tags']);

      $productImage = ($product['image'] != null) ? $product['image']['src'] : "";

      $formattedProduct = new \Swagger\Client\Model\Product();


      $formattedProduct->setCategories($product['product_type']);
      $formattedProduct->setCurrency("USD");
      $formattedProduct->setHandle(sprintf("https://modern-carg-cult.myshopify.com/products/%s", $product['handle']));
      $formattedProduct->setImageSourceUrl($productImage);
      $formattedProduct->setImageThubnail($productImage);
      $formattedProduct->setIsDownloadable(!$product['variants'][0]['requires_shipping']);
      $formattedProduct->setIsVirtual(!$product['variants'][0]['requires_shipping']);
      $formattedProduct->setOutStock($outOfStock);
      $formattedProduct->setPrice($product['variants'][0]['price'] ? floatval($product['variants'][0]['price']) : 0.00);
      $formattedProduct->setPriceCompare($product['variants'][0]['compare_at_price'] ? floatval($product['variants'][0]['compare_at_price']) : 0.00);
      $formattedProduct->setProductTags($productTags);
      $formattedProduct->setPublishedAt($product['published_at']);
      $formattedProduct->setRefId($product['id'] . "");
      $formattedProduct->setSku($product['variants'][0]['sku']);
      $formattedProduct->setSource("shopify");
      $formattedProduct->setTags($product['tags']);
      $formattedProduct->setTitle($product['title']);
      $formattedProduct->setType("variable");
      $formattedProduct->setUserId("");
      $formattedProduct->setVendor($product['vendor']);

      $formattedProduct->variants = array();

      foreach ($product['variants'] as $key => $variant) {

        $productVariant = new \Swagger\Client\Model\ProductVariants();

        $productVariant->setAttributes(array());
        $productVariant->setCreated($variant['created_at']);
        $productVariant->setImageSourceUrl($productImage);
        $productVariant->setInStock(!$outOfStock);
        $productVariant->setInventoryManagement($variant['inventory_management'] || "");
        $productVariant->setInventoryQuantity($variant['inventory_quantity'] . "");
        $productVariant->setPrice($variant['price'] ? floatval($variant['price']) : 0.00);
        $productVariant->setPriceCompare($variant['compare_at_price'] ? floatval($variant['compare_at_price']) : 0.00);
        $productVariant->setProductRefId($product['id'] . "");
        $productVariant->setRefId($variant['id'] . "");
        $productVariant->setSku($variant['sku'] . "");
        $productVariant->setTaxable($variant['taxable']);
        $productVariant->setTitle($variant['title']);
        $productVariant->setUpdated($variant['updated_at']);
        $productVariant->setVisible(true);
        $productVariant->setWeight($variant['weight']);

        array_push($formattedProduct->variants, $productVariant);
      }


      return $formattedProduct;
    }
}

if (!function_exists('transformCustomer')) {
    function transformCustomer($customer)
    {
      $areaCode = "000";

      if (!isset($customer['addresses']) || count($customer['addresses']) === 0) {
        $customer['addresses'] = array(
          phone => "0000000000",
        );
      }

      $customer['addresses'][0]['phone'] = preg_replace('/\D+/', "", $customer['addresses'][0]['phone']);

      if (!isset($customer['addresses'][0]['phone']) || $customer['addresses'][0]['phone'] === null) {
        $areaCode = "000";
      } else {
        if (strpos($customer['addresses'][0]['phone'], "1") === 1) {
          $customer['addresses'][0]['phone'] = ltrim($customer['addresses'][0]['phone'], "1");
        }
        $customer['addresses'][0]['phone'] = ltrim($customer['addresses'][0]['phone'], "+1");
        $areaCode = substr($customer['addresses'][0]['phone'], 0, 3);
      }

      $formattedCustomer = new \Swagger\Client\Model\Customer();

      $formattedCustomer->setActivationDate($customer['created_at']);
      $formattedCustomer->setAddress1($customer['addresses'][0]['address1']);
      $formattedCustomer->setAddress2($customer['addresses'][0]['address2']);
      $formattedCustomer->setAreaCode($areaCode);
      $formattedCustomer->setCity($customer['addresses'][0]['city']);
      $formattedCustomer->setCompany($customer['addresses'][0]['company'] ? $customer['addresses'][0]['company'] : "");
      $formattedCustomer->setCountry($customer['addresses'][0]['country_code']);
      $formattedCustomer->setEmail($customer['email']);
      $formattedCustomer->setFirstName($customer['first_name']);
      $formattedCustomer->setLastName($customer['last_name']);
      $formattedCustomer->setModifiedDate($customer['updated_at']);
      $formattedCustomer->setOrdersCount($customer['orders_count']);
      $formattedCustomer->setPhone($customer['addresses'][0]['phone'] ? $customer['addresses'][0]['phone'] : "");
      $formattedCustomer->setProvince($customer['addresses'][0]['province']);
      $formattedCustomer->setRefId($customer['id'] . "");
      $formattedCustomer->setSignedUpAt($customer['created_at']);
      $formattedCustomer->setTotalSpent($customer['total_spent'] ? floatval($customer['total_spent']) : 0.00);
      $formattedCustomer->setVerified(false);
      $formattedCustomer->setZip($customer['addresses'][0]['zip']);


      return $formattedCustomer;
    }
}

if (!function_exists('transformOrder')) {
    function transformOrder($order)
    {

      $totalShipping = array_reduce(array_map("extractPrice", $order['shipping_lines']), "sum", 10);

      $order['line_items'] = array_map("addProductReference", $order['line_items']);

      $formattedOrder = new \Swagger\Client\Model\Order();

      $formattedOrder->cart_token = $order['cart_token'];
      $formattedOrder->contact = $order['customer'];
      $formattedOrder->setContactRefId($order['customer']['id'] . "");
      $formattedOrder->email = $order['email'];
      $formattedOrder->setFinancialStatus($order['financial_status']);
      $formattedOrder->integration_id = "";
      $formattedOrder->setIqxOrder("");
      $formattedOrder->setProcessedAt($order['processed_at']);
      $formattedOrder->setRefId($order['id'] . "");
      $formattedOrder->setSubtotalPrice($order['subtotal_price'] ? floatval($order['subtotal_price']) : 0.00);
      $formattedOrder->setTotalPrice($order['total_price'] ? floatval($order['total_price']) : 0.00);
      $formattedOrder->setTotalShipping($totalShipping ? floatval($totalShipping) : 0.00);
      $formattedOrder->setTotalTax($order['total_tax'] ? floatval($order['total_tax']) : 0.00);
      $formattedOrder->setUserId("");

      $lineItemsArray = array();

      foreach ($order['line_items'] as $key => $lineItem) {

        $orderLineItem = new \Swagger\Client\Model\OrderLineItems();

        $orderLineItem->setFulfillableQuantity($lineItem['fulfillable_quantity'] ? intVal($lineItem['fulfillable_quantity']) : 0);
        $orderLineItem->setPrice($lineItem['price'] ? floatval($lineItem['price']) : 0.00);
        $orderLineItem->setOrderPrice(0.00);
        $orderLineItem->setSku($lineItem['sku']);
        $orderLineItem->setName($lineItem['name']);
        $orderLineItem->setTitle($lineItem['title']);
        $orderLineItem->setQuantity(intVal($lineItem['quantity']));
        $orderLineItem->setGrams($lineItem['grams'] ? intVal($lineItem['grams']) : 0);
        $orderLineItem->setRequiresShipping($lineItem['requires_shipping']);
        $orderLineItem->setProductRefId($lineItem['product_ref_id'] . "");

        array_push($lineItemsArray, $orderLineItem);
      }

      $formattedOrder->setLineItems($lineItemsArray);

      return $formattedOrder;
    }
}
