<?php

namespace model;

use WC_Product;

class Reh_Mini_Cart_Item
{
    private WC_Product $product;
    private int $id;
    private ?int $variationId;
    private bool $isVariation;
    private array $attributes;

    private function __construct(
        WC_Product $product,
        int $id,
        ?int $variationId,
        array $attributes,
        bool $isVariation
    ) {
        $this->product = $product;
        $this->id = $id;
        $this->variationId = $variationId;
        $this->attributes = $attributes;
        $this->isVariation = $isVariation;
    }

    public static function createFromWcOrderItem(\WC_Order_Item $item): ?self
    {
        /** @var WC_Product $product */
        $product = $item->get_product();

        if (!$product || !$product->exists()) {
            return null;
        }

        $id = $product->get_id();
        $variationId = null;
        $attributes = [];
        $isVariation = $product->get_type() === 'variation';

        if ($isVariation) {
            $id = $product->get_parent_id();
            $variationId = $item->get_variation_id();
            $attributes = $item->get_formatted_meta_data();
        }

        return new self(
            $product,
            $id,
            $variationId,
            $attributes,
            $isVariation
        );
    }

    public static function createFromWcCartItem($item): ?self
    {
        $product = $item['data'];

        if (!$product || !$product->exists()) {
            return null;
        }

        $id = $item['product_id'];
        $variationId = $item['variation_id'] === 0 ? null : $item['variation_id'];
        $isVariation = $variationId !== null;
        $attributes = [];

        if ($isVariation) {
            foreach ($item['variation'] as $key => $value) {
                $key = rawurldecode((string)$key);
                $value = rawurldecode((string)$value);
                $attribute_key = str_replace('attribute_', '', $key);
                $display_key = wc_attribute_label($attribute_key, $product);
                $display_value = wp_kses_post($value);

                if (taxonomy_exists($attribute_key)) {
                    $term = get_term_by('slug', $value, $attribute_key);
                    if (!is_wp_error($term) && is_object($term) && $term->name) {
                        $display_value = $term->name;
                    }
                }
                $attributes[] = (object)[
                    'key' => $attribute_key,
                    'value' => $value,
                    'display_key' => $display_key,
                    'display_value' => $display_value,
                ];
            }
        }

        return new self(
            $product,
            $id,
            $variationId,
            $attributes,
            $isVariation
        );
    }

    public function getProduct(): WC_Product
    {
        return $this->product;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getVariationId(): ?int
    {
        return $this->variationId;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function getName(): string
    {
        return wp_kses_post($this->product->get_name());
    }

    public function getThumbnail(): string
    {
        return $this->product->get_image();
    }

    public function getPrice(): string
    {
        return $this->product->get_price();
    }

    public function getPermalink(): ?string
    {
        return $this->product->get_permalink();
    }

    public function hasPermalink(): bool
    {
        return empty($this->permalink);
    }

    /**
     * @return int Quantity or -1 if unlimited.
     */
    public function getMaxPurchaseQuantity(): int
    {
        return $this->product->get_max_purchase_quantity();
    }

    /**
     * @return String[]
     */
    public function getViewAttributes(): array
    {
        return array_values(array_map(function ($attribute) {
            return sprintf('%s: %s', $attribute->display_key, $attribute->display_value);
        }, $this->attributes));
    }

    public function getDataAttributes(): array
    {
        return array_values(array_map(function ($attribute) {
            return ['name' => ATTRIBUTE_SLUG_PREFIX . $attribute->key, 'value' => $attribute->value];
        }, $this->attributes));
    }

    public function isSame(Reh_Mini_Cart_Item $item): bool
    {
        if ($this->isVariation !== $item->isVariation()) {
            return false;
        }

        if ($this->isVariation) {
            return $this->id === $item->getId()
                && $this->variationId === $item->getVariationId()
                && json_encode($this->attributes) === json_encode($item->getAttributes());
        }

        return $this->id === $item->getId();
    }

    private function isVariation(): bool
    {
        return $this->isVariation;
    }
}