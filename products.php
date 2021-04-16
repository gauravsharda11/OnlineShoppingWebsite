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

    public function Products_Catalogue($products)
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

        //$products = $DB->table('products'); //goto pdo_db page

        $r = '';
        $r .= '<form action="index.php?op=111" method="POST" >';
        $r .= '<input class="form-control" type="text" name="search" requried maxlength="8" style="width:300px;"  placeholder="Search Products by Description" "><br>';
        $r .= ' <input class="btn btn-primary" type="submit" value="Continue" >';
        $r .= '<a  href="index.php?op=118">+ Add New Product</a>';
        // $r .= 'or <a href ';
        $r .= '</form>';

        // if (empty($search)) {
        //     $sqlString = "SELECT * from products where name = '%$search%' OR description like '%$search%'";
        // } else {

        //display products
        foreach ($products as $key => $value) {
            if ($value['qty_in_stock'] > 0) {
                $r .= '<div class="product">';
                $r .= '<img src="products_images/'.$value['pic'].'" alt="'.$value['description'].'">';
                $r .= '<p class="name">'.$value['name'].'</p>';
                $r .= '<p class="description">'.$value['description'].'</p>';
                $r .= '<p class="qty_in_stock">'.'$'.$value['qty_in_stock'].'</p>';
                $r .= '<p class="price">'.$value['price'].'</p>';

                $r .= '<a href="index.php?id='.$value['id'].'&&op=116">Edit || </a>';

                $r .= '<a href="index.php?id='.$value['id'].'&&op=120">delete</a>';
                $r .= '</div>';
            }
        }
        $productCataloguePage = new web_page();
        $productCataloguePage->title = 'Products Catalogue';
        $productCataloguePage->content = $r;
        $productCataloguePage->render();
    }

    public function searchDisplay($array)
    {
        $r = '';
        foreach ($array as $key => $value) {
            $r .= '<div class="product">';
            if ($value['pic'] != '') {
                $r .= '<img src="products_images/'.$value['pic'].'" alt="'.$value['description'].'">';
            } else {
                $r .= 'no image';
            }
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

    public function edit($prev_val = [], $err_msg = '')
    {
        $id = $_GET['id'];
        $alert = '';
        if ($prev_val == []) {
            //db conncetion
            $DB = new db_pdo();
            //fetch the record from db with selected id
            $sql_str = 'SELECT * from products where id = '.$id;
            $products = $DB->querySelect($sql_str);
            //var_dump($products);
            $prev_val = $products[0];
        }
        if ($err_msg == '') {
            $alert .= '   <div class="alert alert-primary">'.$err_msg.'</div>';
        } else {
            $alert .= ' <div class="alert alert-danger">'.$err_msg.'</div>';
        }

        if ($prev_val['pic'] == '') {
            $prev_val['pic'] = 'default.jpg';
        }

        $productPage = new web_page();
        $productPage->title = 'products Page';
        $productPage->content = <<< HTML
         <!-- <div class="alert alert-danger">{$err_msg}</div> -->
         {$alert}
        <form action="index.php?op=117" enctype="multipart/form-data" method="POST" style='width:40%' class="form-check">
        <input type="hidden"name="id"value={$id}>
        <fieldset>
            <!-- <input type="hidden" name="op" value="2"> -->
            <legend>Product Form </legend>
            <img src="products_images/{$prev_val['pic']}"style="width:200px;height:200">
        <p>Add an image(max 500kb jpg,JPG,gif or png)
            <input type="file"  name="user_pic">
        </p>
            <label class="form-check-label" for="name">Name </label>
            <input type="text"  name="name" maxlength="50" requried placeholder="Product Name" class="form-control" value="{$prev_val['name']}"><br>
            <label class="form-check-label" for="description">Description</label>
            <input type="text"  name="description" maxlength="255" width="20"  placeholder="Description" class="form-control" value="{$prev_val['description']}"><br>
            <label class="form-check-label" for="price">Price</label>
            <input type="number" name="price"  min="1.01" step="0.01" placeholder="Price" class="form-control" value="{$prev_val['price']}"><br>
            <label class="form-check-label"  for="qty_in_stock">Quantity in Stock</label>
            <input type="number" name="qty_in_stock"  min="0" placeholder="Quantity" class="form-control" value="{$prev_val['qty_in_stock']}"><br>
            <input class="btn btn-primary" type="submit" value='save'  >
                </fieldset>
        </form>
        HTML;

        $productPage->render();
        // $r = 'SELECT email FROM products where id="'.$id.'"';
        // $record = $DB->querySelect($r);
    }

    public function save()
    {
        $result = Picture_Save_File('user_pic', 'products_images/');
        $file_name = basename($_FILES['user_pic']['name']);
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $qty_in_stock = $_POST['qty_in_stock'];
        $DB = new db_pdo();
        $DB->query("UPDATE products SET name='$name',description='$description',price='$price','$file_name',qty_in_stock='$qty_in_stock' WHERE id=".$_POST['id']);
        $validPage = new web_page();
        $validPage->title = 'List Products';
        $validPage->content = array_HTML_Products($DB->querySelect('SELECT * from products'));
        $validPage->render();
    }

    public function add($prev_val = [], $err_msg = '')
    {
        $alert = '';

        if ($prev_val == []) {
            //db conncetion
            $DB = new db_pdo();
            $prev_val['name'] = '';
            $prev_val['description'] = '';
            $prev_val['price'] = '';
            $prev_val['qty_in_stock'] = '';
            $prev_val['pic'] = '';
        }
        if ($err_msg == '') {
            $alert .= '   <div class="alert alert-primary">'.$err_msg.'</div>';
        } else {
            $alert .= ' <div class="alert alert-danger">'.$err_msg.'</div>';
        }
        $productPage = new web_page();
        $productPage->title = 'products Page';
        $productPage->content = <<< HTML
         <!-- <div class="alert alert-danger">{$err_msg}</div> -->
         {$alert}
        <form action="index.php?op=119" enctype="multipart/form-data" method="POST" style='width:40%' class="form-check">
        
        <fieldset>
            <!-- <input type="hidden" name="op" value="2"> -->
            <legend>Product Form </legend>
            <!--<img src="products_images/{$prev_val['pic']}"style="width:200px;height:200"> -->
        <p>Add an image(max 500kb jpg,JPG,gif or png)
            <input type="file"  name="product_pic">
        </p>
            <label class="form-check-label" for="name">Name </label>
            <input type="text"  name="name" maxlength="50" requried placeholder="Product Name" class="form-control" value="{$prev_val['name']}"><br>
            <label class="form-check-label" for="description">Description</label>
            <input type="text"  name="description" maxlength="255" width="20"  placeholder="Description" class="form-control" value="{$prev_val['description']}"><br>
            <label class="form-check-label" for="price">Price</label>
            <input type="number" name="price" requried  min="1.01" step="0.01" placeholder="Price" class="form-control" value="{$prev_val['price']}"><br>
            <label class="form-check-label"   for="qty_in_stock">Quantity in Stock</label>
            <input type="number" name="qty_in_stock" requried  min="0" placeholder="Quantity" class="form-control" value="{$prev_val['qty_in_stock']}"><br>
            <input class="btn btn-primary" type="submit" value='Create'  >
                </fieldset>
        </form>
        HTML;

        $productPage->render();
    }

    public function saveAs()
    {
        $err_msg = '';
        if (isset($_POST['name'])) {
            $name = $_POST['name'];
        } else {
            $err_msg .= 'Error in name .reg.php  <br>';
        }

        if (isset($_POST['description'])) {
            $description = $_POST['description'];
        } else {
            $err_msg .= 'Error in description .reg.php  <br>';
        }

        if (isset($_POST['price'])) {
            $price = $_POST['price'];
        } else {
            $err_msg .= 'Error in price  .reg.php  <br>';
        }
        if (isset($_POST['qty_in_stock'])) {
            $qty_in_stock = $_POST['qty_in_stock'];
        } else {
            $err_msg .= 'Error in qty_in_stock .reg.php  <br>';
        }
        if ($name == '') {
            $err_msg .= 'Please enter a Product name <br>';
        }
        if ($price == '') {
            $err_msg .= 'Please enter a Product Price <br>';
        }
        if ($qty_in_stock == '') {
            $err_msg .= 'Please enter a Product Quantity <br>';
        }

        $result = Picture_Save_File('product_pic', 'products_images/');
        $DB = new db_pdo();
        $file_name = basename($_FILES['product_pic']['name']);
        $DB->query("INSERT into products(name,description,price,pic,qty_in_stock)
        VALUES('$name','$description','$price','$file_name','$qty_in_stock')");

        $validPage = new web_page();
        $validPage->title = 'List Products';
        $validPage->content = array_HTML_Products($DB->querySelect('SELECT * from products'));
        $validPage->render();
    }

    public function delete($prev_val = [], $err_msg = '')
    {
        $id = $_GET['id'];
        $r = 'SELECT pic FROM products where id="'.$id.'"';
        $DB = new db_pdo();
        $product = $DB->querySelect($r);
        $query = 'delete from products where id="'.$id.'"';
        $DB->query($query);
        $validPage = new web_page();
        $validPage->title = 'List Products';
        $validPage->content = array_HTML_Products($DB->querySelect('SELECT * from products'));
        $validPage->render();
    }

    public function ProductsWebService()
    {
        $DB = new db_pdo();
        $products = $DB->table('products');
        $productsJson = json_encode($products, JSON_PRETTY_PRINT);
        $content_type = 'content-Type: application/json; charset=UTF-8';
        header($content_type);
        http_response_code(200);
        echo $productsJson;
    }
}
