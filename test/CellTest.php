<?php declare(strict_types=1);

namespace Test;

use GameOfLife\Cell;
use PHPUnit\Framework\TestCase;

final class CellTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldCreateADeadCell()
    {
        $deadCell = Cell::createDeadCell(1, 1);

        $this->assertFalse($deadCell->isAlive());
    }

    /**
     * @test
     */
    public function itShouldCreateALivingCell()
    {
        $deadCell = Cell::createAliveCell(1, 1);

        $this->assertTrue($deadCell->isAlive());
    }

    /**
     * @test
     */
    public function itShouldPrintDeadCellSymbol()
    {
        $deadCell = Cell::createDeadCell(1, 1);

        $this->assertEquals(Cell::DEAD, $deadCell->print());
    }

    /**
     * @test
     */
    public function itShouldPrintAliveCellSymbol()
    {
        $deadCell = Cell::createAliveCell(1, 1);

        $this->assertEquals(Cell::ALIVE, $deadCell->print());
    }

    /**
     * @test
     */
    public function itShouldReturnRow()
    {
        $deadCell = Cell::createDeadCell(1, 2);

        $this->assertEquals(1, $deadCell->getRow());
    }

    /**
     * @test
     */
    public function itShouldReturnColumn()
    {
        $deadCell = Cell::createDeadCell(1, 2);

        $this->assertEquals(2, $deadCell->getCol());
    }
}
