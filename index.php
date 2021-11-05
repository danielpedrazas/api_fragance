<?php

require __DIR__ . '/vendor/autoload.php';
use Automattic\WooCommerce\Client;

// Conexión WooCommerce API destino
// ================================

$url_API_woo = 'https://fragancetienda.com/shop/';
$ck_API_woo = 'ck_6992dbe4f2319e41f86f69a73f33feeb36ae31f3';
$cs_API_woo = 'cs_c394be70c22c272427f97228d69af7774a469b6b';

$woocommerce = new Client(
    $url_API_woo,
    $ck_API_woo,
    $cs_API_woo,
    ['version' => 'wc/v3']
);
// ================================
// Conexión API origen
// ===================
$url_API="  ";

$ch = curl_init();
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL,$url_API);

echo "➜ Obteniendo datos origen ... \n";
$items_origin = curl_exec($ch);
curl_close($ch);

if ( ! $items_origin ) {
    exit('❗Error en API origen');
}
// ===================


//ACTUALIZAR PRODUCTOS

// Obtenemos datos de la API de origen
$items_origin = json_decode($items_origin, true);

$param_sku ='';
foreach ($items_origin as $item){
    $param_sku .= $item['sku'] . ',';
}

echo "➜ Obteniendo los ids de los productos... \n";
$products = $woocommerce->get('products/?sku='. $param_sku);

$item_data = [];
foreach($products as $product){

    $sku = $product->sku;
    $search_item = array_filter($items_origin, function($item) use($sku) {
        return $item['sku'] == $sku;
    });
    $search_item = reset($search_item);

    $item_data[] = [
        'id' => $product->id,
        'name' => $search_item['nombre'],
        'stock_quantity' => $search_item['stock'],
        'regular_price' => $search_item['precio'],
    ];

}

$data = [
    'update' => $item_data,
];

echo "➜ Actualización en lote ... \n";

// Actualización en lotes
$result = $woocommerce->post('products/batch', $data);

if (! $result) {
    echo("❗Error al actualizar productos \n");
} else {
    print("✔ Productos actualizados correctamente \n");
}



?>