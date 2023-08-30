<?php


return [
    [
        'icon'=>'nav-icon fas fa-tachometer-alt',
        'route'=>'dashboard.dashboard',
        'title'=>'dashboard',
        'active'=>'dashboard.dashboard'
    ],
    [
        'icon'=>'far fa-circle nav-icon',
        'route'=>'dashboard.categories.index',
        'title'=>'categories',
        'badge'=>'New',
        'active'=>'dashboard.categories.*'
    ],
    [
        'icon'=>'far fa-circle nav-icon',
        'route'=>'dashboard.products.index',
        'title'=>'products',
        'active'=>'dashboard.products.*'
    ],
    [
        'icon'=>'far fa-circle nav-icon',
        'route'=>'dashboard.categories.index',
        'title'=>'orders',
        'active'=>'dashboard.orders.*'
    ],

];