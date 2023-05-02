<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $products = [
            ['id' => '1', 'name' => 'Apple iPhone 13', 'description' => 'A14 Bionic Chip, Super Retina XDR display', 'price' => '999.00', 'image' => 'https://www.apple.com/iphone-13/', 'categories_ids' => [3]],
            ['id' => '2', 'name' => 'Samsung Galaxy S21', 'description' => '5G, Exynos 2100 processor', 'price' => '799.00', 'image' => 'https://www.samsung.com/us/smartphones/galaxy-s21-5g/', 'categories_ids' => [3]],
            ['id' => '3', 'name' => 'Dell XPS 13', 'description' => '13.3-inch FHD display, Intel Core i7 processor', 'price' => '1099.00', 'image' => 'https://www.dell.com/en-us/shop/dell-laptops/xps-13-laptop/spd/xps-13-9310-laptop', 'categories_ids' => [2]],
            ['id' => '4', 'name' => 'Lenovo ThinkPad X1 Carbon', 'description' => '14-inch FHD display, Intel Core i7 processor', 'price' => '1499.00', 'image' => 'https://www.lenovo.com/us/en/laptops/thinkpad/thinkpad-x1-carbon-gen-9-/p/22TP2TXX19G', 'categories_ids' => [2]],
            ['id' => '5', 'name' => 'Nike Air Max 270', 'description' => 'Breathable mesh upper, Max Air unit for cushioning', 'price' => '150.00', 'image' => 'https://www.nike.com/t/air-max-270-mens-shoe-qrzKjJ', 'categories_ids' => [5]],
            ['id' => '6', 'name' => 'Adidas Ultra Boost 21', 'description' => 'Primeknit upper, Boost cushioning technology', 'price' => '180.00', 'image' => 'https://www.adidas.com/us/ultraboost-21-shoes/FY0401.html', 'categories_ids' => [5]],
            ['id' => '7', 'name' => 'Samsung 55-inch 4K Smart TV', 'description' => 'Crystal Processor 4K, HDR, Smart TV powered by Tizen', 'price' => '799.00', 'image' => 'https://www.samsung.com/us/televisions-home-theater/tvs/uhd-tvs/55-class-ru9000-4k-uhd-smart-tv-2020-un55ru9000fxza/', 'categories_ids' => [7]],
            ['id' => '8', 'name' => 'Whirlpool French Door Refrigerator', 'description' => '28 cu. ft. capacity, fingerprint-resistant stainless steel', 'price' => '2199.00', 'image' => 'https://www.whirlpool.com/kitchen/refrigeration/refrigerators/french-door/p.36-inch-wide-french-door-refrigerator-with-indoor-plush-organizer.html', 'categories_ids' => [8]],
            ['id' => '9', 'name' => 'Bowflex Max Trainer M9', 'description' => 'Full-body workout, 20 resistance levels', 'price' => '1799.00', 'image' => 'https://www.bowflex.com/max-trainer/m9/100879.html', 'categories_ids' => [12]],
            ['id' => '10', 'name' => 'Clinique 3-Step Skincare System', 'description' => 'Cleanser, toner, and moisturizer for oily skin', 'price' => '69.00', 'image' => 'https://www.clinique.com/product/1670/15502/3-step/3-step-skin-care/oily-skin-formula-type/3-step-skin-care-set', 'categories_ids' => [14]],
            ['id' => '11', 'name' => 'Apple iPhone 13 Pro', 'description' => 'The iPhone 13 Pro is the latest flagship phone from Apple with advanced camera features and powerful performance.', 'price' => '999.99', 'image' => 'https://www.apple.com/newsroom/images/product/iphone/standard/Apple_announce-iphone-13_09142021.jpg.large.jpg', 'categories_ids' => [3]],
            ['id' => '12', 'name' => 'Adidas Ultraboost 21', 'description' => 'The Adidas Ultraboost 21 is a comfortable and supportive running shoe.', 'price' => '149.99', 'image' => 'https://assets.adidas.com/images/w_600,f_auto,q_auto:sensitive,fl_lossy/1c84d04e52064aeeb853acdd011e56c2_9366/Ultraboost_21_Shoes_Grey_FY0371_01_standard.jpg', 'categories_ids' => [5]],
            ['id' => '13', 'name' => 'Samsung 55-inch QLED TV', 'description' => 'The Samsung 55-inch QLED TV offers stunning 4K picture quality and a sleek design.', 'price' => '899.99', 'image' => 'https://pisces.bbystatic.com/image2/BestBuy_US/images/products/6410/6410161_sd.jpg', 'categories_ids' => [1]],
            ['id' => '14', 'name' => 'Calphalon Classic Stainless Steel Cookware Set', 'description' => 'The Calphalon Classic Stainless Steel Cookware Set includes pots and pans with durable stainless steel construction and long-lasting performance.', 'price' => '199.99', 'image' => 'https://www.calphalon.com/dw/image/v2/AAUJ_PRD/on/demandware.static/-/Sites-calprod-master-catalog/default/dw32d8a335/images/hi-res/KPH-10PC-Kitchen-Main-3.jpg?sw=936&sh=650&sm=cut', 'categories_ids' => [8]],
            ['id' => '15', 'name' => 'Fitbit Charge 5', 'description' => 'The Fitbit Charge 5 is an advanced fitness tracker with a built-in GPS, heart rate monitor, and other health features.', 'price' => '179.99', 'image' => 'https://www.fitbit.com/global/content/dam/fitbit/global/homepage/products/charge5/hero/charge5-black-Hero-Desktop.jpg', 'categories_ids' => [13]]
        ];

        foreach ($products as $product) {
            $_product = Product::updateOrCreate([
                'id' => $product['id']
            ], [
                'name' => $product['name'],
                'description' => $product['description'],
                'price' => $product['price'],
                'image' => $product['image']
            ]);
            $_product->categories()->sync($product['categories_ids']);
        }
    }
}
