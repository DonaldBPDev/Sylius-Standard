<?php

namespace App\Form\Extension;

use Sylius\Bundle\OrderBundle\Form\Type\CartItemType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Constraints\Regex;

class AddToCartFormExtension extends AbstractTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // First, Modify the form field with some custom attrs
        if ($builder->has('quantity')) {
            $builder->add('quantity', IntegerType::class, [
                'attr' => ['min' => 10, 'step' => 10, 'onchange' => 'productQuantityChange(this)'],
                'label' => 'sylius.ui.quantity',
                'constraints' => [
                    new Regex([
                        'pattern' => '/^(10|[1-9]\d*0)$/', // Enforce multiples of 10
                        'message' => 'Quantity must be a multiple of 10.',
                    ]),
                ],
                'empty_data' => 10,
            ]);
        }

        // Modify the initial value to avoid the number below 10
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($options) {
            $orderItem = $event->getData();
            $currentQuantity = $orderItem->getQuantity();

            if ($currentQuantity < 10) {
                $orderItem->setQuantity(10);
                $event->setData($orderItem);
            }
        });
    }

    /**
     * Define the form type this extension will extend.
     */
    public static function getExtendedTypes(): iterable
    {
        // Extend the AddToCartType form (this is the form type Sylius uses for adding products to the cart)
        return [CartItemType::class];
    }

    /**
     * Optionally, configure any options.
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        // Optionally configure the form options if needed.
    }
}
