<?php

/**
 * Modify subject if all products in order are virtual.
 */
add_filter('woocommerce_email_subject_customer_completed_order', function (
    string                            $subject,
    WC_Order                          $order,
    WC_Email_Customer_Completed_Order $email) {
    foreach ($order->get_items() as $item) {
        if (!$item->get_product()->is_virtual()) {
            return $subject;
        }
    }

    return 'Deine Bestellung ist abgeschlossen';
}, 10, 3);

/**
 * Modify additional content if all products in order are virtual.
 */
add_filter('woocommerce_email_additional_content_customer_completed_order', function (
    string                            $additionalContent,
    WC_Order                          $order,
    WC_Email_Customer_Completed_Order $email) {
    foreach ($order->get_items() as $item) {
        if (!$item->get_product()->is_virtual()) {
            return $additionalContent;
        }
    }

    return 'deine Bestellung ist abgeschlossen. Vielen Dank für Deinen Einkauf!';
}, 10, 3);

/**
 * Add coupon pdf attachment to email.
 */
add_filter('woocommerce_email_attachments', function (array $attachments, string $email_id, WC_Order$order) {
    if ($email_id !== 'customer_completed_order') {
        return $attachments;
    }

    foreach ($order->get_items() as $item) {
        if (!$item->meta_exists(ORDER_ITEM_COUPON_CODE)) {
            continue;
        }

        $couponCode = $item->get_meta(ORDER_ITEM_COUPON_CODE);
        if ($couponCode) {
            $couponFactory = new Reh_Create_Coupon();
            $pdfFilePath = $couponFactory->createCouponPdf($couponCode);
            if ($pdfFilePath) {
                $attachments[] = $pdfFilePath;
            }
        }
    }

    return $attachments;
}, 10, 3);

