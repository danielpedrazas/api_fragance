<?php
//LISTADO DE PRODUCTOS

$products=$woocommerce-›get('products');
echo'<pre>';
print_r($products);
echo'</pre>';




//Variables para traer desde API de Origen
$id_producto='';
$sku_producto='';
$tipo_de_producto='';
$nombre_producto='';
$descripcion_producto='';
$precio_regular='';
$precio_oferta='';
$id_categoria='';
$id_subcategoria='';





$data = [
    'id' => $id_producto;
    'sku' => $sku_producto;
    'name' => $nombre_producto;
    'description' => $descripcion_producto;
    'regular_price' => $precio_regular;
    'sale_price' => $precio_oferta;
];

print_r($woocommerce->put('products/'$id_producto', $data));


$data = [
   
];

print_r($woocommerce->put('products/'$id_producto', $data));

//ACTUALIZAR PRODUCTO UNO A UNO

$data = [
            'update' => 
            [

                [
                    'id' => $id_producto,
                    'sku' => $sku_producto,
                    'name' => $nombre_producto,
                    'description' => $descripcion_producto,
                    'regular_price' => $precio_regular,
                    'sale_price' => $precio_oferta,
                    ]
                ]
          ],
print_r($woocommerce->post('products/batch', $data));

//CREAR PRODUCTO UNO A UNO

$data = [
    'create' => [
        [
            'name' => $nombre_producto
            'type' => $tipo_de_producto,
            'regular_price' => $precio_regular,
            'description' => $descripcion_producto,
            'categories' => [
                [
                    'id' => $id_categoria
                ],
                [
                    'id' => $id_subcategoria
                ]
            ],
            'images' => [
                [
                    'src' => 'https://fragancetienda.com/wp-content/uploads/2021/11/product-default.png'
                ],
                [
                    'src' => 'https://fragancetienda.com/wp-content/uploads/2021/11/product-default.png'
                ]
            ]
        ]
    ],

print_r($woocommerce->post('products/batch', $data));


//ELIMINAR PRODUCTO UNO A UNO
$data = [

    'delete' => [
        $id_producto
    ]
    ];
print_r($woocommerce->post('products/batch', $data));

?>