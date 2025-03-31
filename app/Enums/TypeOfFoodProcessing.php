<?php

namespace App\Enums;

enum TypeOfFoodProcessing: string
{
    // Варка
    case Boiling = 'Варка';
        // Жарка
    case Frying = 'Жарка';
        // Запекание
    case Baking = 'Запекание';
        // Тушение
    case Stewing = 'Тушение';
        // Пастеризация
    case Pasteurization = 'Пастеризация';
        // Стерилизация
    case Sterilization = 'Стерилизация';
        // Заморозка
    case Freezing = 'Заморозка';
        // Сушка
    case Drying = 'Сушка';
        // Ферментация
    case Fermentation = 'Ферментация';
        // Консервирование
    case Canning = 'Консервирование';
        // Маринование
    case Pickling = 'Маринование';
        // Копчение
    case Smoking = 'Копчение';


    public static function list(): array
    {
        return self::cases();
    }
}
