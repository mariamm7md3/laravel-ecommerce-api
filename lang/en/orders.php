<?php

return [

    // General
    'orders' => 'Orders',

    // Table columns
    'customer'         => 'Customer',
    'branch'           => 'Branch',
    'items_count'      => 'Items',
    'total'            => 'Total',
    'payment_status'   => 'Payment Status',
    'date'             => 'Date',
    'actions'          => 'Actions',
    'no_payment'       => 'No payment',
    'no_orders_found'  => 'No orders found',
    'status_column'    => 'Order Status',
    'delivery_time'    => 'Delivery Time',

    // Filters
    'search_by_customer' => 'Search by customer name',
    'filter_status'       => 'All statuses',
    'search'              => 'Search',

    // Service messages (status transition)
    'invalid_transition' => 'Cannot change order status from ":from" to ":to"',

    // Order statuses (used from inside the Enum via label())
    'status' => [
        'pending'     => 'Pending',
        'requested'   => 'Requested',
        'on-delivery' => 'On Delivery',
        'delivered'   => 'Delivered',
        'cancelled'   => 'Cancelled',
        'paid'        => 'Paid',
    ],


    'order_number'          => 'Order #:id',
    'back_to_orders'        => 'Back to orders',
    'order_cancelled_title' => 'Order cancelled',
    'order_cancelled_desc'  => 'This order has been cancelled and will not be processed',
    'items'                 => 'Items',
    'product'               => 'Product',
    'quantity'              => 'Quantity',
    'unit_price'            => 'Unit price',
    'item_total'            => 'Total',
    'additional_info'       => 'Customer notes',
    'delivery_details'      => 'Delivery details',
    'address'               => 'Address',
    'building'              => 'Building',
    'floor'                 => 'Floor',
    'apartment'             => 'Apartment',
    'summary'               => 'Order summary',
    'sub_total'             => 'Subtotal',
    'shipping'              => 'Shipping',
    'discount'              => 'Discount',

    'customer_rating' => 'Customer rating',
    'confirm_delete_order' => 'Are you sure you want to delete this order?',

    // en
    'show_deleted'  => 'Deleted',
    'order_deleted' => 'Order deleted successfully',
];
