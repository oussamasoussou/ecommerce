<?php

namespace App\Exceptions;

use RuntimeException;

/**
 * Commande impossible (produit indisponible, stock insuffisant…).
 * Le message est destiné au client.
 */
class OrderException extends RuntimeException
{
}
