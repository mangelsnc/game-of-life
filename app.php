<?php declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use GameOfLife\GameOfLife;

// Bizarre forms - Extinguished ☠️
$nextGen = [
    ['.','.','.','*','*','.','.','.'],
    ['.','.','*','.','*','*','.','.'],
    ['.','.','*','*','*','.','.','.'],
    ['.','.','.','*','*','*','.','.'],
];

// Snake - Stable
$nextGen = [
    ['.','.','.','.','.','.','.'],
    ['.','.','.','.','.','.','.'],
    ['.','.','.','.','*','*','.'],
    ['.','*','.','*','.','*','.'],
    ['.','*','*','.','.','.','.'],
    ['.','.','.','.','.','.','.'],
];

// Oscilating Line - Infinite
$nextGen = [
    ['.','.','.','.','.'],
    ['.','.','*','.','.'],
    ['.','.','*','.','.'],
    ['.','.','*','.','.'],
    ['.','.','.','.','.'],
];

$gameOfLife = new GameOfLife($nextGen);

$gameOfLife->run();