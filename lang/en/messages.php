<?php

return [
    'auth' => [
        'registered' => 'User created successfully',
        'logged_in' => 'User logged in successfully',
        'logged_out' => 'User logged out successfully',
        'invalid_credentials'=> 'Invalid credentials',
        'reset_link_sent' => 'Reset link sent to your email',
        'email_not_found' => 'Email not found',
        'invalid_token' => 'Invalid token or email',
        'password_reset' => 'Password reset successfully',
    ],

    'address' => [
        'created'     => 'Address created successfully',
        'fetched'     => 'Addresses fetched successfully',
        'empty'       => 'No addresses found',
        'updated'     => 'Address updated successfully',
        'deleted'     => 'Address deleted successfully',
        'not_found'   => 'Address not found',
        'unauthorized'=> 'Unauthorized',
    ],

    'home' => [
        'data' => 'Home page data',
    ],

    'category' => [
        'index' => 'Categories fetched successfully',
        'show' => 'Category products fetched successfully',
    ],

    'product' => [
        'index' => 'Products fetched successfully',
        'show' => 'Product fetched successfully',
    ],

    'cart' => [
        'empty'          => 'Cart is empty',
        'fetched'        => 'Cart fetched successfully',
        'item_added'     => 'Item added to cart',
        'item_updated'   => 'Quantity updated',
        'item_removed'   => 'Item removed from cart',
        'already_exists' => 'Item already in cart',
        'out_of_stock'   => 'Only :count items available in stock',
        'limit_exceeded' => 'Maximum allowed quantity is :limit',
    ],

    'wishlist' => [
        'empty'          => 'Wishlist is empty',
        'fetched'        => 'Wishlist fetched successfully',
        'item_added'     => 'Item added to wishlist',
        'item_removed'   => 'Item removed from wishlist',
        'already_exists' => 'Item already in wishlist',
    ],

    'contact' => [
        'sent'      => 'Message sent successfully',
        'info'      => 'Contact info fetched successfully',
        'not_found' => 'Contact not found',
    ],

    'user' => [
        'fetched'           => 'User fetched successfully',
        'updated'           => 'User updated successfully',
        'password_changed'  => 'Password changed successfully',
        'wrong_password'    => 'Old password is incorrect',
        'deleted'           => 'Account deleted successfully',
    ],

    'delivery_time' => [
        'index' => 'Delivery time fetched successfully',
    ],

    'order' => [
        'index'          => 'Orders fetched successfully',
        'show'           => 'Order fetched successfully',
        'created'        => 'Order placed successfully',
        'invalid_address'=> 'invalid address',
        'invalid_cart'   => 'Your cart is empty',
        'not_found'      => 'Order not found',
    ],

    'discount_code' => [
        'invalid'      => 'Invalid or expired discount code',
        'usage_limit'  => 'This discount code has reached its usage limit',
        'already_used' => 'You have already used this discount code',
    ],

    'rate' => [
        'created'            => 'Thank you for your feedback',
        'already_rated'      => 'You have already rated this order',
        'order_not_delivered'=> 'You can only rate delivered orders',
    ],

];
