<?php

use Library\Route;

return  array(
    // site routes
    'default' => new Route('/', 'Index', 'index'),
    'clothes_list' => new Route('/clothes-{page}\.html', 'clothes', 'index', array('page' => '[0-9]+')),
    'clothes_page' => new Route('/clothesdetails-{id}\.html', 'clothes', 'show', array('id' => '[0-9]+')),
    'contact_us' => new Route('/contact-us', 'index', 'contact'),
    'cart' => new Route('/cart?', 'cart', 'index'),
//        array('cart' => '[a-zA-Z]+'), array('id' => '[0-9]+')),
    'registration' => new Route('/registration', 'registration', 'index'),
    'login' => new Route('/login', 'Security', 'login'),
    'logout' => new Route('/logout', 'Security', 'logout'),


    'admin_default' => new Route('/admin', 'Admin\Index', 'index'),
    'admin_clothes_list' => new Route('/admin/clothes', 'Admin\Clothes', 'index'),
    'admin_clothes_edit' => new Route('/admin/clothes/edit/{id}', 'Admin\Clothes', 'edit', array('id' => '[0-9]+')),

);