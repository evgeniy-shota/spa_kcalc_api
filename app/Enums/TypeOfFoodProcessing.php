<?php

namespace App\Enums;

enum TypeOfFoodProcessing: string
{
    // Варка
    case Boiling = 'Boiling';
        // Жарка
    case Frying = 'Frying';
        // Запекание
    case Baking = 'Baking';
        // Тушение
    case Stewing = 'Stewing';
        // Пастеризация
    case Pasteurization = 'Pasteurization';
        // Стерилизация
    case Sterilization = 'Sterilization';
        // Заморозка
    case Freezing = 'Freezing';
        // Сушка
    case Drying = 'Drying';
        // Ферментация
    case Fermentation = 'Fermentation';
        // Консервирование
    case Canning = 'Canning';
        // Маринование
    case Pickling = 'Pickling';
        // Копчение
    case Smoking = 'Smoking';
}
