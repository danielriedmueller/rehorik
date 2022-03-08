<?php
/**
 * Email Styles
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-styles.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 4.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Load colors.
$bg        = get_option( 'woocommerce_email_background_color' );
$body      = get_option( 'woocommerce_email_body_background_color' );
$base      = get_option( 'woocommerce_email_base_color' );
$base_text = wc_light_or_dark( $base, '#202020', '#ffffff' );
$text      = get_option( 'woocommerce_email_text_color' );

// Pick a contrasting color for links.
$link_color = wc_hex_is_light( $base ) ? $base : $base_text;

if ( wc_hex_is_light( $body ) ) {
	$link_color = wc_hex_is_light( $base ) ? $base_text : $base;
}

$bg_darker_10    = wc_hex_darker( $bg, 10 );
$body_darker_10  = wc_hex_darker( $body, 10 );
$base_lighter_20 = wc_hex_lighter( $base, 20 );
$base_lighter_40 = wc_hex_lighter( $base, 40 );
$text_lighter_20 = wc_hex_lighter( $text, 20 );
$text_lighter_40 = wc_hex_lighter( $text, 40 );

// !important; is a gmail hack to prevent styles being stripped if it doesn't like something.
// body{padding: 0;} ensures proper scale/positioning of the email in the iOS native email app.

$email_width = '590px';

$accent = '#CEB67F';
$primary = '#5C0D2F';
$text_color = '#3c3c3b';
$text_color_light = '#fff';

$font_family = '‘Lucida Sans Unicode’, ‘Lucida Grande’, sans-serif';
$font_size = '12px';
$font_size_small = '11px';
$font_size_h1 = '26px';
$font_size_h2 = '18px';
$spacing = '20px';
$spacing_big = '100px';
$spacing_small = '10px';
?>
body {
	padding: 0;
}

#wrapper {
	background-color: #fff;
	margin: 0;
	padding: <?= $spacing ?> 0;
	-webkit-text-size-adjust: none !important;
	width: 100%;
}

section, table td,table, #wrapper, body, div.ticket, div.qr-code {
	box-sizing: border-box;
}

#template_container {
	box-shadow: none;
	background-color: #fff;
	border: 0;
	border-radius: 0;
}

#template_header {
	background-color: #fff;
	border-radius: 0;
	border: 0;
	vertical-align: middle;
	padding: 0 <?= $spacing ?>;
}

#template_header_image {
	background-image: url(https://img.mailinblue.com/3459467/images/rnb/original/604f6fd6592e0e582b2c9d4b.png);
	background-position: center top;
	background-size: contain;
	background-repeat: no-repeat;
	padding: <?= $spacing ?>;
}

#template_footer td {
	padding: 0;
}

#template_footer p {
	text-align: center;
}

#template_footer #credit {
    background-color: <?= $accent ?>;
	border: 0;
	font-family: <?= $font_family ?>;
	font-size: <?= $font_size_small ?>;
	text-align: center;
	padding: 0 0 <?= $spacing ?> 0;
}

#template_footer #owner {
	border: 0;
	font-family: <?= $font_family ?>;
	font-size: <?= $font_size_small ?>;
	text-align: center;
	padding: <?= $spacing ?> 0;

}

#template_footer #owner p {
	color: <?= $text_color ?>;
	margin: 0;
}

#template_footer #socialmedia {
    background-color: <?= $accent ?>;
    text-align: center;
    padding: <?= $spacing ?> 0;
}

#body_content {
	background-color: #fff;
}

.mt {
	margin-top: <?= $spacing ?>;
}

.mb {
	margin-bottom: <?= $spacing ?>;
}

table {
	border: none;
	font-family: <?= $font_family ?>;
	font-size: <?= $font_size ?>;
	color: <?= $text_color ?>;
	padding: 0;
	margin: 0;
}

table th {
	border: none;
}

#body_content td ul.wc-item-meta {
	font-size: small;
	margin: 1em 0 0;
	padding: 0;
	list-style: none;
}

#body_content td ul.wc-item-meta li {
	margin: 0.5em 0 0;
	padding: 0;
}

#body_content td ul.wc-item-meta li p {
	margin: 0;
}

p {
	margin: 0;
	text-align: justify;
}

#body_content_inner {
	color: <?php echo esc_attr( $text_lighter_20 ); ?>;
	font-family: <?= $font_family ?>;
	font-size: 14px;
	line-height: 150%;
	text-align: <?php echo is_rtl() ? 'right' : 'left'; ?>;
}

table.table-details {
	margin: 0 0 <?= $spacing ?>;
}

table.table-details > thead	 > tr > th,
table.table-details > tfoot	 > tr > th,
table.table-details > tfoot	 > tr > td,
table.table-details > tbody > tr > td {
	border-bottom: 1px solid <?= $accent ?>;
	border-top: none;
	border-left: none;
	border-right: none;
	font-family: <?= $font_family ?> !important;
	font-size: <?= $font_size ?>;
	vertical-align: top;
	padding: <?= $spacing_small ?> <?= $spacing ?> <?= $spacing_small ?> 0 !important;
}

.mb {
	margin: 0 0 <?= $spacing ?> 0;
}

.address, address {
	padding: <?= $spacing ?>;
	margin: 0 <?= $spacing ?> 0 0;
	color: <?= $text_color ?>;
	border: 1px solid <?= $accent ?>;
	font-style: normal;
	font-family: <?= $font_family ?>;
	font-size: <?= $font_size ?>;
}

.text {
	color: <?= $text_color ?>;
	font-family: <?= $font_family ?>;
}

.link {
	color: <?= $text_color ?>;
}

#header_wrapper {
	padding: 36px 48px;
	display: block;
}

section {
	padding: <?= $spacing ?>;
	margin: <?= $spacing ?> 0;
	color: <?= $text_color_light ?>;
	background-color: <?= $accent ?>;
}

div.ticket {
	width: <?= $email_width ?>;
	margin: 0 0 <?= $spacing_big ?> 0;
}

div.ticket table td {
	padding: 0 !important;
}

div.ticket table.ticket-details {
	margin: <?= $spacing ?> 0;
	padding: 0 <?= $spacing ?>;
}

div.ticket table.ticket-details td {
	padding: 0 0 <?= $spacing ?> 0 !important;
	font-family: <?= $font_family ?> !important;
}

div.ticket div.qr-code {
	width: <?= $email_width ?>;
	padding: <?= $spacing ?> !important;
	background: <?= $accent ?> !important;
}

div.ticket div.qr-code table {
	margin: 0 !important;
	width: 100% !important;
	padding: 0 !important;
}

div.ticket div.qr-code table td {
	color: <?= $text_color ?> !important;
	background: <?= $accent ?> !important;
	font-family: <?= $font_family ?> !important;
}

div.ticket div.qr-code table td p,
div.ticket div.qr-code table td h3 {
	padding: 0 0 0 <?= $spacing ?> !important;
}

div.ticket div.qr-code table td h3 span {
	font-family: <?= $font_family ?> !important;
	font-weight: bold !important;
	line-height: 100% !important;
	text-align: left !important;
	margin: 0 !important;
	color: <?= $text_color ?> !important;
	font-size: <?= $font_size_h2 ?> !important;
	text-transform: uppercase;
}

div#ticket-bottom table {
	width: <?= $email_width ?> !important;
	margin: 0 !important;
	padding: 0 !important;
}

div#ticket-bottom td {
	text-align: justify;
	padding: <?= $spacing ?> !important;
}

div.ticket table.ticket-security-code td {
	font-family: <?= $font_family ?> !important;
	font-size: <?= $font_size_small ?> !important;
}

h1, h2, h3, h4 {
	color: <?= $accent ?>;
	font-family: <?= $font_family ?>;
	font-weight: bold;
	line-height: 100%;
	font-size: <?= $font_size_h1 ?>;
	text-align: center;
	margin: <?= $spacing_small ?> 0;
}

h1, h2 {
	text-transform: uppercase;
}

h2 {
	color: <?= $text_color ?>;
	font-size: <?= $font_size_h2 ?>;
	text-align: <?php echo is_rtl() ? 'right' : 'left'; ?>;
}

h3 {
	color: <?= $text_color ?>;
	font-size: <?= $font_size_h2 ?>;
	text-align: <?php echo is_rtl() ? 'right' : 'left'; ?>;
}

h4 {
	font-size: <?= $font_size_h2 ?>;
}

section h2,
section h3 {
	color: <?= $text_color_light ?>;
}

a, a[href] {
	font-weight: normal;
	text-decoration: underline;
	color: <?= $primary ?> !important;
}

h1 a, h4 a {
	text-decoration: none;
	font-weight: bold;
	color: <?= $accent ?> !important;
}

h2 a, h3 a {
	text-decoration: none;
	font-weight: bold;
	color: <?= $text_color ?> !important;
}

#template_footer a, #template_footer td {
	color: <?= $text_color_light ?> !important;
}

img {
	border: none;
	display: inline-block;
	font-size: 14px;
	font-weight: bold;
	height: auto;
	outline: none;
	text-decoration: none;
	text-transform: capitalize;
	vertical-align: middle;
	margin-<?php echo is_rtl() ? 'left' : 'right'; ?>: 10px;
	max-width: 100%;
	height: auto;
}
<?php
