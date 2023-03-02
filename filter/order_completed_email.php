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

add_filter(/**
 * @throws Exception
 */ 'tribe_tickets_plus_woo_email_attachments', function (array $attachments, string $email_id, $order) {
    if ($email_id !== 'wootickets' || !($order instanceof WC_Order)) {
        return $attachments;
    }

    $wootickets = Tribe__Tickets_Plus__Commerce__WooCommerce__Main::get_instance();
    $attendees = $wootickets->get_attendees_by_id($order->get_id());

    foreach ($attendees as $attendee) {
        $product = wc_get_product($attendee['product_id']);
        $startDatetime = $product->get_meta(TICKET_EVENT_DATE_START_META);
        $endDatetime = $product->get_meta(TICKET_EVENT_DATE_END_META);
        $date = '';

        if ($startDatetime && $startDatetime) {
            if ($startDatetime === $startDatetime) {
                $date = date(DATE_FORMAT, $startDatetime);
            } else {
                $date = sprintf('%s - %s', date(DATE_FORMAT, $startDatetime), date(DATE_FORMAT, $endDatetime));
            }
        }

        $details = [
            'ticket_id' => $attendee['ticket_id'],
            'ticket_name' => $attendee['ticket_name'],
            'holder_name' => $attendee['holder_name'],
            'event_id' => $attendee['event_id'],
            'location' => tribe_get_venue($attendee['event_id']),
            'organizer' => tribe_get_organizer($attendee['event_id']),
            'date' => $date,
            'qr_ticket_id' => $attendee['qr_ticket_id'],
            'security_code' => $attendee['security_code']
        ];

        if (!empty($details['ticket_id'])
            && !empty($details['ticket_name'])
            && !empty($details['holder_name'])
            && !empty($details['event_id'])
            && !empty($details['location'])
            && !empty($details['organizer'])
            && !empty($details['date'])
            && !empty($details['qr_ticket_id'])
            && !empty($details['security_code'])
        ) {
            $file = 'Rehorik-Ticket-Geschenkdesign-' . $details['security_code'] . '.pdf';

            if ($pdfFilePath = Reh_Pdf_Creator::createPdf($file, '/templates/pdf/ticket-pdf', $details)) {
                $attachments[] = $pdfFilePath;
            }
        }
    }

    return $attachments;
}, 10, 3);

/**
 * Add coupon pdf attachment to email.
 */
add_filter('woocommerce_email_attachments', function (array $attachments, string $email_id, $order) {
    if ($email_id !== 'customer_completed_order' || !($order instanceof WC_Order)) {
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
