<?php

if (!isset($index_loaded)) {
    die('direct access to this file is forbidden');
}
class products
{
    public function Product_Display()
    {
        $product = ['id' => 0, 'name' => 'black dress', 'Description' => 'Little Black Evening dress', 'price' => '$99.99'];
        $page = new web_page();
        $page->title = 'Product'.$product['name'];
        $page->content = array_to_HTML_table($product);
        $page->render();
    }

    public function Products_List()
    {
        $DB = new db_pdo();
        $products = $DB->table('products'); //goto pdo_db page
        $table_html = table_display($products);
        $pageProducts = new web_page();
        $pageProducts->title = 'Products List';
        $pageProducts->content = table_display($products);
        $pageProducts->render();

        /*$products = [
                [
                    'id' => 0,
                    'name' => 'Red Jersey',
                    'description' => 'Manchester United Home Jersey, red, sponsored by Chevrolet',
                    'price' => 59.99,
                    'pic' => 'red_jersey.jpg',
                    'qty_in_stock' => 200,
                ],
                [
                    'id' => 1,
                    'name' => 'White Jersey',
                    'description' => 'Manchester United Away Jersey, white, sponsored by Chevrolet',
                    'price' => 49.99,
                    'pic' => 'white_jersey.jpg',
                    'qty_in_stock' => 133,
                ],
                [
                    'id' => 2,
                    'name' => 'Black Jersey',
                    'description' => 'Manchester United Extra Jersey, black, sponsored by Chevrolet',
                    'price' => 54.99,
                    'pic' => 'black_jersey.jpg',
                    'qty_in_stock' => 544,
                ],
                [
                    'id' => 3,
                    'name' => 'Blue Jacket',
                    'description' => 'Blue Jacket for cold and raniy weather',
                    'price' => 129.99,
                    'pic' => 'blue_jacket.jpg',
                    'qty_in_stock' => 14,
                ],
                [
                    'id' => 4,
                    'name' => 'Snapback Cap',
                    'description' => 'Manchester United New Era Snapback Cap- Adult',
                    'price' => 24.99,
                    'pic' => 'cap.jpg',
                    'qty_in_stock' => 655,
                ],
                [
                    'id' => 5,
                    'name' => 'Champion Flag',
                    'description' => 'Manchester United Champions League Flag',
                    'price' => 24.99,
                    'pic' => 'champion_league_flag.jpg',
                    'qty_in_stock' => 321,
                ],
            ];

        $pageProducts = new web_page();
        $pageProducts->title = 'Products List';
        $pageProducts->content = array_HTML_Products($products);
        $pageProducts->render();*/
    }

    public function Products_Catalogue()
    {
        /*$products = [
                        [
                            'id' => 0,
                            'name' => 'Red Jersey',
                            'description' => 'Manchester United Home Jersey, red, sponsored by Chevrolet',
                            'price' => 59.99,
                            'pic' => 'red_jersey.jpg',
                            'qty_in_stock' => 220,
                        ],
                        [
                            'id' => 1,
                            'name' => 'White Jersey',
                            'description' => 'Manchester United Away Jersey, white, sponsored by Chevrolet',
                            'price' => 49.99,
                            'pic' => 'white_jersey.jpg',
                            'qty_in_stock' => 133,
                        ],
                        [
                            'id' => 2,
                            'name' => 'Black Jersey',
                            'description' => 'Manchester United Extra Jersey, black, sponsored by Chevrolet',
                            'price' => 54.99,
                            'pic' => 'black_jersey.jpg',
                            'qty_in_stock' => 544,
                        ],
                        [
                            'id' => 3,
                            'name' => 'Blue Jacket',
                            'description' => 'Blue Jacket for cold and raniy weather',
                            'price' => 129.99,
                            'pic' => 'blue_jacket.jpg',
                            'qty_in_stock' => 14,
                        ],
                        [
                            'id' => 4,
                            'name' => 'Snapback Cap',
                            'description' => 'Manchester United New Era Snapback Cap- Adult',
                            'price' => 24.99,
                            'pic' => 'cap.jpg',
                            'qty_in_stock' => 655,
                        ],
                        [
                            'id' => 5,
                            'name' => 'Champion Flag',
                            'description' => 'Manchester United Champions League Flag',
                            'price' => 24.99,
                            'pic' => 'champion_league_flag.jpg',
                            'qty_in_stock' => 321,
                        ],
        ];*/

        $DB = new db_pdo();
        $products = $DB->table('products'); //goto pdo_db page

        $r = '';
        $r = '<form action="index.php?op=111" method="POST" >';
        $r .= '<input class="form-control" type="text" name="search" requried maxlength="8" style="width:300px;"  placeholder="Search" "><br>';
        $r .= ' <input class="btn btn-primary" type="submit" value="Continue" >';
        $r .= '</form>';

        foreach ($products as $key => $value) {
            if ($value['qty_in_stock'] > 0) {
                $r .= '<div class="product">';
                $r .= '<img src="products_images/'.$value['pic'].'" alt="'.$value['description'].'">';
                $r .= '<p class="name">'.$value['name'].'</p>';
                $r .= '<p class="description">'.$value['description'].'</p>';
                $r .= '<p class="price">'.$value['price'].'</p>';
                $r .= '</div>';
            }
        }
        $productCataloguePage = new web_page();
        $productCataloguePage->title = 'Products Catalogue';
        $productCataloguePage->content = $r;
        $productCataloguePage->render();
        /* $r = '';
         foreach ($arrayName as $key => $value) {
             if ($value['qty_in_stock'] > 0) {
                 $r .= '<div class="product">';
                 $r .= '<img src=products_images/'.$value['pic'].'>';
                 $r .= '<p class="name">'.$value['name'].'</p>';
                 $r .= '<p class="description">'.$value['description'].'</p>';
                 $r .= '<p class="price">'.$value['price'].'</p>';
                 $r .= '</div>';
             }
         }

         return $r;*/

        $productCataloguePage = new web_page();
        $productCataloguePage->title = 'Products Catalogue';
        $productCataloguePage->content = productCatalogue($products);
        $productCataloguePage->render();
    }

    public function searchDisplay($array)
    {
        $r = '';
        foreach ($array as $key => $value) {
            $r .= '<div class="product">';
            $r .= '<img src="products_images/'.$value['pic'].'" alt="'.$value['description'].'">';
            $r .= '<p class="name">'.$value['name'].'</p>';
            $r .= '<p class="description">'.$value['description'].'</p>';
            $r .= '<p class="price">'.$value['price'].'</p>';
            $r .= '</div>';
        }
        $productCataloguePage = new web_page();
        $productCataloguePage->title = 'Products Catalogue Search';
        $productCataloguePage->content = $r;
        $productCataloguePage->render();
    }
}
