<?php

return [

    // العناوين العامة
    'orders' => 'الطلبات',

    // أعمدة الجدول
    'customer'       => 'العميل',
    'branch'         => 'الفرع',
    'items_count'    => 'عدد المنتجات',
    'total'          => 'الإجمالي',
    'payment_status' => 'حالة الدفع',
    'date'           => 'التاريخ',
    'actions'        => 'الإجراءات',
    'no_payment'     => 'لا يوجد دفع',
    'no_orders_found' => 'لا توجد طلبات',
    'status_column'    => 'حالة الطلب',
    'delivery_time'     => 'وقت التوصيل',
    // الفلاتر
    'search_by_customer' => 'ابحث باسم العميل',
    'filter_status'      => 'كل الحالات',
    'search'              => 'بحث',

    // رسائل الـ Service (تغيير الحالة)
    'invalid_transition' => 'لا يمكن تحويل الطلب من ":from" إلى ":to"',

    // حالات الأوردر (مستخدمة من جوه الـ Enum عن طريق label())
    'status' => [
        'pending'     => 'قيد الانتظار',
        'requested'   => 'تم القبول',
        'on-delivery' => 'قيد التوصيل',
        'delivered'   => 'تم التوصيل',
        'cancelled'   => 'ملغي',
        'paid'        =>'مدفوع'
    ],


    'order_number'        => 'طلب #:id',
    'back_to_orders'       => 'رجوع للطلبات',
    'order_cancelled_title' => 'الطلب ملغي',
    'order_cancelled_desc'  => 'تم إلغاء هذا الطلب ولن يتم تنفيذه',
    'items'                => 'المنتجات',
    'product'              => 'المنتج',
    'quantity'             => 'الكمية',
    'unit_price'           => 'سعر الوحدة',
    'item_total'           => 'الإجمالي',
    'additional_info'      => 'ملاحظات العميل',
    'delivery_details'     => 'تفاصيل التوصيل',
    'address'              => 'العنوان',
    'building'             => 'مبنى',
    'floor'                => 'دور',
    'apartment'            => 'شقة',
    'summary'              => 'ملخص الطلب',
    'sub_total'            => 'الإجمالي الفرعي',
    'shipping'             => 'الشحن',
    'discount'             => 'الخصم',

    'customer_rating' => 'تقييم العميل',

    'confirm_delete_order' => 'هل أنت متأكد من حذف هذا الطلب ؟',

    // ar
    'show_deleted'  => 'المحذوفة',
    'order_deleted' => 'تم حذف الطلب بنجاح',


    ];
