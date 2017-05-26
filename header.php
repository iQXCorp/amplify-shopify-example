<?php

require 'vendor/autoload.php';

use Shopify\ShopifyClient;

$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

$access_token = getenv('SHOPIFY_ACCESS_TOKEN');
$amplify_api_key = getenv('AMPLIFY_API_KEY');

$shopify = new \Shopify\Client([
   "shopUrl" => "modern-cargo-cult.myshopify.com",
   "X-Shopify-Access-Token" => $access_token
]);

Swagger\Client\Configuration::getDefaultConfiguration()->setApiKey('authorization', $amplify_api_key);
Swagger\Client\Configuration::getDefaultConfiguration()->setSandboxMode(true);

$customer_api_instance = new Swagger\Client\Api\CustomersApi();
$product_api_instance = new Swagger\Client\Api\ProductsApi();
$order_api_instance = new Swagger\Client\Api\OrdersApi();
