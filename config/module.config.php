<?php
/**
 * module.config.php - Basket Config
 *
 * Main Config File for Contact Basket Plugin
 *
 * @category Config
 * @package Contact\Basket
 * @author Verein onePlace
 * @copyright (C) 2020  Verein onePlace <admin@1plc.ch>
 * @license https://opensource.org/licenses/BSD-3-Clause
 * @version 1.0.0
 * @since 1.0.0
 */

namespace OnePlace\Contact\Basket;

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    # Basket Module - Routes
    'router' => [
        'routes' => [
            'contact-basket-setup' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/contact/basket/setup',
                    'defaults' => [
                        'controller' => Controller\InstallController::class,
                        'action'     => 'checkdb',
                    ],
                ],
            ],
        ],
    ], # Routes

    # View Settings
    'view_manager' => [
        'template_path_stack' => [
            'contact-basket' => __DIR__ . '/../view',
        ],
    ],
];
