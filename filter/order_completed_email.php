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

    $hasCoupon = false;
    $hasShippableProducts = false;

    foreach ($order->get_items() as $item) {
        if ($hasCoupon && $hasShippableProducts) {
            continue;
        }

        /** @var WC_Order_Item_Product $item */
        if ($item instanceof WC_Order_Item_Product) {
            $product = $item->get_product();
            if (!$hasCoupon && isItCategory($product, COUPON_CATEGORY_SLUG)) {
                $hasCoupon = true;
            }

            if (!$hasShippableProducts && !$product->is_virtual()) {
                $hasShippableProducts = true;
            }
        }
    }

    $emailMessage = "Deine Bestellung ist abgeschlossen. Vielen Dank für Deinen Einkauf!";

    if ($hasShippableProducts) {
        $emailMessage .= " " . $additionalContent;
    }

    if ($hasCoupon) {
        $emailMessage .= " " . "Deine Gutscheine haben wir in dieser Email zum Ausdrucken angehängt.";
    }

    return $emailMessage;
}, 10, 3);

/**
 * Add coupon pdf attachment to email.
 */
add_filter('woocommerce_email_attachments', function (array $attachments, string $email_id, WC_Order$order) {
    if ($email_id !== 'customer_completed_order') {
        return $attachments;
    }

    foreach ($order->get_items() as $item) {
        $item->read_meta_data();
        if (!$item->meta_exists(ORDER_ITEM_COUPON_CODE)) {
            continue;
        }

        $couponCodes = $item->get_meta(ORDER_ITEM_COUPON_CODE, false);
        if (!empty($couponCodes)) {
            /** @var WC_Product $product */
            $product = $item->get_product();
            foreach ($couponCodes as $couponCode) {
                /** @var WC_Meta_Data $couponCode */
                $metaData = $couponCode->get_data();
                if ($pdfFilePath = Reh_Online_Coupon::createCouponPdf(
                    $metaData['value'],
                    $product->get_price(),
                    $product->get_name(),
                    $metaData['id']
                )) {
                    $attachments[] = $pdfFilePath;
                }
            }
        }
    }

    return $attachments;
}, 10, 3);

/**
 * Add display key "Gutscheincode" for coupon order item meta
 */
add_filter('woocommerce_order_item_display_meta_key', function (string $display_key, WC_Meta_Data $meta, WC_Order_Item $item) {
    if ($display_key === ORDER_ITEM_COUPON_CODE) {
        return "Gutscheincode";
    }

    return $display_key;
}, 10, 3);
