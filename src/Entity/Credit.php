<?php
/*
 * This file is part of the Mercado Libre API client package.
 *
 * (c) Zephia <info@zephia.com.ar>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WinkelCo\MercadoLibreApi\Entity;

/**
 * Class Credit
 *
 * @package WinkelCo\MercadoLibreApi\Entity
 * @author  Mauro Moreno<moreno.mauro.emanuel@gmail.com>
 */
class Credit
{
    /**
     * @var integer
     */
    public $consumed;

    /**
     * @var string
     */
    public $credit_level_id;
}
