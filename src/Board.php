<?php declare(strict_types=1);

namespace GameOfLife;

final class Board
{
    const NECESSARY_NEIGHBOURS_TO_REBORN = 3;
    const MINIMUM_NEIGHBOURS_TO_STAY_ALIVE = 2;
    const MAXIMUM_NEIGHBOURS_TO_STAY_ALIVE = 3;

    private array $board;
    private int $rows;
    private int $cols;

    public function __construct(array $board)
    {
        if (empty($board)) {
            throw new EmptyBoardException();
        }

        $this->rows = count($board);
        $this->cols = count($board[0]);

        $this->loadBoard($board);
    }

    public function toArray(): array
    {
        $array = [];
        for ($row = 0; $row < $this->rows; $row++) {
            for ($col = 0; $col < $this->cols; $col++) {
                $array[$row][$col] = $this->board[$row][$col]->print();
            }
        }

        return $array;
    }

    private function loadBoard(array $board): void
    {
        for ($row = 0; $row < $this->rows; $row++) {
            for ($col = 0; $col < $this->cols; $col++) {
                if (Cell::ALIVE === $board[$row][$col]) {
                    $this->board[$row][$col] = Cell::createAliveCell($row, $col);
                } else {
                    $this->board[$row][$col] = Cell::createDeadCell($row, $col);
                }
            }
        }
    }

    public function toString(): string
    {
        $string = '';
        for ($row = 0; $row < $this->rows; $row++) {
            for ($col = 0; $col < $this->cols; $col++) {
                $string .= $this->board[$row][$col]->print() . ' ';
            }
            $string .= PHP_EOL;
        }

        $string .= PHP_EOL;

        return $string;
    }

    public function nextGeneration()
    {
        $nextGeneration = [];

        for ($row = 0; $row < $this->rows; $row++) {
            $nextGeneration[] = [];

            for ($col = 0; $col < $this->cols; $col++) {
                $cell = $this->board[$row][$col];

                if ($cell->isAlive()) {
                    $nextGeneration[$row][$col] = Cell::ALIVE;

                    if (!$this->itSurvives($cell)) {
                        $nextGeneration[$row][$col] = Cell::DEAD;
                    }

                } else {
                    $nextGeneration[$row][$col] = Cell::DEAD;

                    if ($this->shouldReborn($cell)) {
                        $nextGeneration[$row][$col] = Cell::ALIVE;
                    }
                }
            }
        }

        $this->loadBoard($nextGeneration);
    }

    private function itSurvives(Cell $cell): bool
    {
        $aliveNeighbours = $this->aliveNeighbours($cell);

        return ($aliveNeighbours >= self::MINIMUM_NEIGHBOURS_TO_STAY_ALIVE && $aliveNeighbours <= self::MAXIMUM_NEIGHBOURS_TO_STAY_ALIVE);
    }

    private function shouldReborn(Cell $cell): bool
    {
        $aliveNeighbours = $this->aliveNeighbours($cell);

        return (self::NECESSARY_NEIGHBOURS_TO_REBORN === $aliveNeighbours);
    }

    private function aliveNeighbours(Cell $cell): int
    {
        $aliveNeighbours = 0;

        if ($neighbour = $this->getUpperNeighbour($cell)) {
            if ($neighbour->isAlive()) {
                $aliveNeighbours++;
            }
        }

        if ($neighbour = $this->getBottomNeighbour($cell)) {
            if ($neighbour->isAlive()) {
                $aliveNeighbours++;
            }
        }

        if ($neighbour = $this->getLeftNeighbour($cell)) {
            if ($neighbour->isAlive()) {
                $aliveNeighbours++;
            }
        }

        if ($neighbour = $this->getRightNeighbour($cell)) {
            if ($neighbour->isAlive()) {
                $aliveNeighbours++;
            }
        }

        if ($neighbour = $this->getUpperLeftNeighbour($cell)) {
            if ($neighbour->isAlive()) {
                $aliveNeighbours++;
            }
        }

        if ($neighbour = $this->getUpperRightNeighbour($cell)) {
            if ($neighbour->isAlive()) {
                $aliveNeighbours++;
            }
        }

        if ($neighbour = $this->getBottomLeftNeighbour($cell)) {
            if ($neighbour->isAlive()) {
                $aliveNeighbours++;
            }
        }

        if ($neighbour = $this->getBottomRightNeighbour($cell)) {
            if ($neighbour->isAlive()) {
                $aliveNeighbours++;
            }
        }

        return $aliveNeighbours;
    }


    private function getUpperNeighbour(Cell $cell): ?Cell
    {
        if ($this->hasUpperNeighbour($cell)) {
            return $this->board[$cell->getRow() - 1][$cell->getCol()];
        }

        return null;
    }

    private function hasUpperNeighbour(Cell $cell): bool
    {
        return ($cell->getRow() - 1) > 0;
    }

    private function getBottomNeighbour(Cell $cell): ?Cell
    {
        if ($this->hasBottomNeighbour($cell)) {
            return $this->board[$cell->getRow() + 1][$cell->getCol()];
        }

        return null;
    }

    private function hasBottomNeighbour(Cell $cell): bool
    {
        return ($cell->getRow() + 1) < $this->rows;
    }

    private function getLeftNeighbour(Cell $cell): ?Cell
    {
        if ($this->hasLeftNeighbour($cell)) {
            return $this->board[$cell->getRow()][$cell->getCol() - 1];
        }

        return null;
    }

    private function hasLeftNeighbour(Cell $cell): bool
    {
        return ($cell->getCol() - 1) > 0;
    }

    private function getRightNeighbour(Cell $cell): ?Cell
    {
        if ($this->hasRightNeighbour($cell)) {
            return $this->board[$cell->getRow()][$cell->getCol() + 1];
        }

        return null;
    }

    private function hasRightNeighbour(Cell $cell): bool
    {
        return ($cell->getCol() + 1) < $this->cols;
    }

    private function getUpperLeftNeighbour(Cell $cell): ?Cell
    {
        if ($this->hasUpperLeftNeighbour($cell)) {
            return $this->board[$cell->getRow() - 1][$cell->getCol() - 1];
        }

        return null;
    }

    private function hasUpperLeftNeighbour(Cell $cell): bool
    {
        return ($cell->getRow() - 1) >= 0 && ($cell->getCol() - 1) > 0;
    }

    private function getUpperRightNeighbour(Cell $cell): ?Cell
    {
        if ($this->hasUpperRightNeighbour($cell)) {
            return $this->board[$cell->getRow() - 1][$cell->getCol() + 1];
        }

        return null;
    }

    private function hasUpperRightNeighbour(Cell $cell): bool
    {
        return ($cell->getRow() - 1) >= 0 && ($cell->getCol() + 1) < $this->cols;
    }

    private function getBottomLeftNeighbour(Cell $cell): ?Cell
    {
        if ($this->hasBottomLeftNeighbour($cell)) {
            return $this->board[$cell->getRow() + 1][$cell->getCol() - 1];
        }

        return null;
    }

    private function hasBottomLeftNeighbour(Cell $cell): bool
    {
        return ($cell->getRow() + 1) < $this->rows && ($cell->getCol() - 1) > 0;
    }

    private function getBottomRightNeighbour(Cell $cell): ?Cell
    {
        if ($this->hasBottomRightNeighbour($cell)) {
            return $this->board[$cell->getRow() + 1][$cell->getCol() + 1];
        }

        return null;
    }

    private function hasBottomRightNeighbour(Cell $cell): bool
    {
        return ($cell->getRow() + 1) < $this->rows && ($cell->getCol() + 1) < $this->cols;
    }

    public function hasLife(): bool
    {
        for ($row = 0; $row < $this->rows; $row++) {
            for ($col = 0; $col < $this->cols; $col++) {
                $cell = $this->board[$row][$col];

                if ($cell->isAlive()) {
                    return true;
                }
            }
        }

        return false;
    }
}
