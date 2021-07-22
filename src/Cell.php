<?php declare(strict_types=1);

namespace GameOfLife;

final class Cell
{
    const ALIVE = '*';
    const DEAD = '.';

    private int $row;
    private int $col;
    private string $status;

    public function __construct(int $row, int $col, string $status)
    {
        $this->row = $row;
        $this->col = $col;
        $this->status = $status;
    }

    public static function createDeadCell(int $row, int $col): self
    {
        return new self($row, $col, self::DEAD);
    }

    public static function createAliveCell(int $row, int $col): self
    {
        return new self($row, $col, self::ALIVE);
    }

    public function isAlive(): bool
    {
        return $this->status === self::ALIVE;
    }

    public function print(): string
    {
        if ($this->isAlive()) {
            return self::ALIVE;
        }

        return self::DEAD;
    }

    public function getRow(): int
    {
        return $this->row;
    }

    public function getCol(): int
    {
        return $this->col;
    }
}
