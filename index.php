<?php

declare(strict_types=1);

const OPERATION_EXIT = 0;
const OPERATION_ADD = 1;
const OPERATION_DELETE = 2;
const OPERATION_PRINT = 3;

$operations = [
    OPERATION_EXIT => OPERATION_EXIT . '. Завершить программу.',
    OPERATION_ADD => OPERATION_ADD . '. Добавить товар в список покупок.',
    OPERATION_DELETE => OPERATION_DELETE . '. Удалить товар из списка покупок.',
    OPERATION_PRINT => OPERATION_PRINT . '. Отобразить список покупок.',
];

$items = [];

//Функция для вывода списка покупок чтобы убрать дублирующий участок кода, в котором изменяется только сообщение
function showList($message, &$items): void
{
    echo $message . PHP_EOL;
    echo implode("\n", $items) . "\n";
}

//Функция добавления товара в список
function addItem(&$items): void
{
    echo "Введение название товара для добавления в список: \n> ";
    $itemName = trim(fgets(STDIN));
    $items[] = $itemName;
}

//Функция удаления товара из списка
function deleteItem(&$items): void
{
    // Проверить, есть ли товары в списке? Если нет, то сказать об этом и попросить ввести другую операцию
    echo 'Текущий список покупок:' . PHP_EOL;
    showList('Список покупок: ', $items);

    echo 'Введение название товара для удаления из списка:' . PHP_EOL . '> ';
    $itemName = trim(fgets(STDIN));

    if (in_array($itemName, $items, true) !== false) {
        while (($key = array_search($itemName, $items, true)) !== false) {
            unset($items[$key]);
        }
    }
}

//Функция вывода всех товаров
function printItem(&$items): void
{
    showList('Ваш список покупок: ', $items);
    echo 'Всего ' . count($items) . ' позиций. ' . PHP_EOL;
    echo 'Нажмите enter для продолжения';
    fgets(STDIN);
}

//Определаяем функцию для получения номера операции
function operationNumberFunc(&$items, &$operations): int
{
    do {
        if (count($items)) {
            echo 'Ваш список покупок: ' . PHP_EOL;
            echo implode("\n", $items) . "\n";
        } else {
            echo 'Ваш список покупок пуст.' . PHP_EOL;
        }

        echo 'Выберите операцию для выполнения: ' . PHP_EOL;
        
        echo implode(PHP_EOL, $operations) . PHP_EOL . '> ';
        $operationNumber = (int) trim(fgets(STDIN));  // используем int, чтобы привести привести к целому числу, т.к. функция должна возращать int

        if (!array_key_exists($operationNumber, $operations)) {
            system('clear');

            echo '!!! Неизвестный номер операции, повторите попытку.' . PHP_EOL;
        } else {
            return $operationNumber;
        }

    } while (!array_key_exists($operationNumber, $operations));
}

do {
    system('clear');    //    system('cls'); // windows

    $operationNumber = operationNumberFunc($items, $operations); // Вызываем функцию и получаем номер операции

    echo 'Выбрана операция: ' . $operations[$operationNumber] . PHP_EOL;

    switch ($operationNumber) {
        case OPERATION_ADD:
            addItem($items);  //Используем функцию добавления товара
            break;

        case OPERATION_DELETE:
            deleteItem($items);  //Используем функцию удаления товара
            break;

        case OPERATION_PRINT:
            printItem($items);  //Используем функцию вывода списка всех товаров
            break;
    }

    echo "\n ----- \n";
} while ($operationNumber > 0);

echo 'Программа завершена' . PHP_EOL;