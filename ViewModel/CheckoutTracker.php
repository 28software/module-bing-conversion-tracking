<?php
/**
 * Copyright © 28Software (https://28software.com)
 * See LICENSE for the license details.
 */
declare(strict_types = 1);

namespace TESoftware\BingConversionTracking\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Sales\Model\Order;
use TESoftware\BingConversionTracking\Model\Config;

class CheckoutTracker implements ArgumentInterface
{
    /**
     * @var Config
     */
    private $config;

    /**
     * @var Order
     */
    private $order;

    /**
     * @var Json
     */
    private $json;

    /**
     * CheckoutTracker constructor.
     *
     * @param Config $config
     * @param Order  $order
     * @param Json   $json
     */
    public function __construct(
        Config $config,
        Order $order,
        Json $json
    ) {
        $this->config = $config;
        $this->order = $order;
        $this->json = $json;
    }
    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->config->isActive();
    }

    /**
     * @param string $incrementId
     *
     * @return string
     */
    public function getOrderSubtotalJson(string $incrementId): string
    {
        return $this->json->serialize($this->getOrderSubtotal($incrementId));
    }

    /**
     * @param string $incrementId
     *
     * @return float
     */
    public function getOrderSubtotal(string $incrementId): float
    {
        return (float) $this->order->loadByIncrementId($incrementId)->getSubtotal();
    }
}
