<?php declare(strict_types=1);

namespace GameOfLife;

final class GameOfLife
{
    private Board $board;

    public function __construct(array $board)
    {
        $this->board = new Board($board);
    }

    public function run(): void
    {
        echo $this->board->toString();

        while ($this->board->hasLife()) {
            system('clear');
            $this->board->nextGeneration();
            echo $this->board->toString();
            usleep(300000);
        }
    }
}
