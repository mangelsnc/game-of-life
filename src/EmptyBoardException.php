<?php declare(strict_types=1);

namespace GameOfLife;

use InvalidArgumentException;

final class EmptyBoardException extends InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct('Empty board');
    }
}
