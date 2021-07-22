<?php declare(strict_types=1);

namespace Test;

use GameOfLife\Board;
use GameOfLife\EmptyBoardException;
use PHPUnit\Framework\TestCase;

final class BoardTest extends TestCase
{
    /** @test */
    public function itShouldThrowExceptionIfEmptyArrayIsPassedWhenCreating()
    {
        $this->expectException(EmptyBoardException::class);
        new Board([]);
    }

    /** @test */
    public function itShouldPrintTheBoard()
    {
        $inputBoard = [
            ['.', '.', '.'],
            ['.', '.', '.'],
            ['.', '.', '.'],
        ];

        $outputBoard = ". . . \n. . . \n. . . \n\n";

        $board = new Board($inputBoard);

        $this->assertEquals($outputBoard, $board->toString());
    }

    /**
     * @test
     * @dataProvider hasLifeProvider
     */
    public function itShouldTellIfHasLifeOrNot($hasLife, $inputBoard)
    {
        $board = new Board($inputBoard);
        $this->assertEquals($hasLife, $board->hasLife());
    }

    public function hasLifeProvider(): array
    {
        $deadBoard = [
            ['.', '.', '.'],
            ['.', '.', '.'],
            ['.', '.', '.'],
        ];

        $aliveBoard = [
            ['.', '.', '.'],
            ['.', '*', '.'],
            ['.', '.', '.'],
        ];

        return [
            'dead' => [false, $deadBoard],
            'alive' => [true, $aliveBoard],
        ];
    }

    /**
     * @test
     * @dataProvider nextGenerationProvider
     */
    public function itShouldCalculateNextGeneration($currentGeneration, $nextGeneration)
    {
        $board = new Board($currentGeneration);
        $board->nextGeneration();
        $this->assertEquals($nextGeneration, $board->toArray());
    }

    public function nextGenerationProvider()
    {
        $lineCurrentGeneration = [
            ['.','.','.','.','.'],
            ['.','.','*','.','.'],
            ['.','.','*','.','.'],
            ['.','.','*','.','.'],
            ['.','.','.','.','.'],
        ];

        $lineNextGeneration = [
            ['.','.','.','.','.'],
            ['.','.','.','.','.'],
            ['.','*','*','*','.'],
            ['.','.','.','.','.'],
            ['.','.','.','.','.'],
        ];

        $squareCurrentGeneration = [
            ['.','.','.','.'],
            ['.','*','*','.'],
            ['.','*','*','.'],
            ['.','.','.','.'],
        ];

        $squareNextGeneration = [
            ['.','.','.','.'],
            ['.','*','*','.'],
            ['.','*','*','.'],
            ['.','.','.','.'],
        ];

        return [
            'line' => [$lineCurrentGeneration, $lineNextGeneration],
            'square' => [$squareCurrentGeneration, $squareNextGeneration],
        ];
    }
}
