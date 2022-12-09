<?php

return [

    'invoice_number' => 'चालान संख्या',
    'invoice_date' => 'चालान तारीख',
    'invoice_amount' => 'चालान राशि',
    'total_price' => 'कुल कीमत',
    'due_date' => 'नियत तारीख',
    'order_number' => 'क्रम संख्या',
    'bill_to' => 'बिल प्राप्तकर्ता',
    'cancel_date' => 'रद्द करने की तारीख',

    'quantity' => 'मात्रा',
    'price' => 'कीमत',
    'sub_total' => 'पूर्ण योग',
    'discount' => 'छूट',
    'item_discount' => 'पंक्ति डिस्काउंट',
    'tax_total' => 'कुल कर',
    'total' => 'कुल',

    'item_name' => 'वस्तु का नाम|वस्तु का नाम',
    'recurring_invoices' => 'आवर्ती चालान|आवर्ती चालान',

    'show_discount' => ':discount% छूट',
    'add_discount' => 'छूट जोड़ें',
    'discount_desc' => 'पूर्ण योग का',

    'payment_due' => 'भुगतान राशि',
    'paid' => 'भुगतान किया है',
    'histories' => 'इतिहास',
    'payments' => 'भुगतान',
    'add_payment' => 'भुगतान जोड़ें',
    'mark_paid' => 'मार्क करे की भुगतान किया हुआ है',
    'mark_sent' => 'मार्क करे की भेजा गया',
    'mark_viewed' => 'मार्क किया हुआ देखे',
    'mark_cancelled' => 'रद्द किए हुए में मार्क करे',
    'download_pdf' => 'डाउनलोड PDF',
    'send_mail' => 'ईमेल भेजें',
    'all_invoices' => 'सभी चालान देखने के लिए लॉगिन करें',
    'create_invoice' => 'चालान बनाएँ',
    'send_invoice' => 'चालान भेजें',
    'get_paid' => 'भुगतान प्राप्त करना',
    'accept_payments' => 'ऑनलाइन भुगतान स्वीकार करें',
    'payment_received' => 'भुगतान प्राप्त',

    'form_description' => [
        'billing' => 'बिलिंग विवरण आपके चालान में दिखाई देते हैं। इनवॉइस दिनांक का उपयोग डैशबोर्ड और रिपोर्ट में किया जाता है। उस तिथि का चयन करें जिसे आप नियत तिथि के रूप में भुगतान प्राप्त करने की अपेक्षा करते हैं।',
    ],

    'messages' => [
        'email_required' => 'इस ग्राहक के लिए कोई ईमेल पता नहीं!',
        'draft' => 'यह एक <b>ड्राफ्ट</b> चालान है और इसे भेजे जाने के बाद चार्ट में प्रतिबिंबित होगा।',

        'status' => [
            'created' => ':date को बनाया गया',
            'viewed' => 'देखा गया',
            'send' => [
                'draft' => 'नहीं भेजा गया',
                'sent' => ':date को भेजें',
            ],
            'paid' => [
                'await' => 'भुगतान का इंतजार',
            ],
        ],
    ],

    'slider' => [
        'create' => ':user ने यह चालान :date को बनाया',
        'create_recurring' => ':user ने यह आवर्ती टेम्पलेट :date को बनाया',
        'schedule' => ':date  के बाद से हर :interval :frequency में दोहराएं',
        'children' => ':count चालान स्वचालित रूप से बनाए गए थे',
    ],

    'share' => [
        'show_link' => 'आपका ग्राहक इस लिंक पर चालान देख सकता है',
        'copy_link' => 'लिंक को कॉपी करें और अपने ग्राहक के साथ साझा करें।',
        'success_message' => 'शेयर लिंक को क्लिपबोर्ड पर कॉपी किया गया!',
    ],

    'sticky' => [
        'description' => 'आप पूर्वावलोकन कर रहे हैं कि आपका ग्राहक आपके चालान के वेब संस्करण को कैसे देखेगा।',
    ],

];
