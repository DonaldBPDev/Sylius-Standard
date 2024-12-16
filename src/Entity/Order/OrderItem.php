<?php

declare(strict_types=1);

namespace App\Entity\Order;

use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\OrderItem as BaseOrderItem;

#[ORM\Entity]
#[ORM\Table(name: 'sylius_order_item')]
class OrderItem extends BaseOrderItem
{
    /**
     * Set the quantity for the order item.
     *
     * @param int $quantity
     */
    public function setQuantity(int $quantity): void
    {
        if ($quantity < 10) {
            throw new \InvalidArgumentException('Quantity cannot be below 10.');
        }
        $this->quantity = $quantity;
    }
}
