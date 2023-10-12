
## Подключение класса
``` php 
require_once("./Classes/ClassPoverka.php");
```

---

## Задаем объект класса
``` php 
$poverka = new Poverka; 
```

---

## Получение сразу массива `$poverka->getRowsArray()` с результатами запроса


``` php
if (!$poverka->getResultQueryArray("SELECT * FROM `poverka` ORDER BY `poverka`.`id` DESC LIMIT 1"))
	echo $poverka->getConnError();
var_dump($poverka->getRowsArray());
```

---

## Пройтись в цикле по результатам выдачи запроса
``` php
if (!$poverka->getResultQueryArray("SELECT * FROM `poverka` ORDER BY `poverka`.`id` DESC LIMIT 1"))
	echo $poverka->getConnError();
foreach ($poverka->getRowsArray() as $row)
{
	var_dump($row);
}
```
---

## Напечатать результаты запроса
``` php
if (!$poverka->getResultQuery("SELECT * FROM `poverka` WHERE `date_naladka` IS NOT NULL ORDER BY `poverka`.`id` DESC"))
	echo $poverka->getConnError();
$poverka->getPrintResult();
```

---
## `function getConnect()`  _- выполняет соединение с сервером, возвращает bool_

---

## `function getConn()` _- проверяет было ли соединение с сервером, возвращает bool_

---

## `function getConnError()` _- если было соединение с сервером выводит либо "OK." либо строку с содержанием ошибки_

---

## `function getResultQuery($query)` _- выполнят запрос SQL, получает объект mysqli_query или возвращает false, так же задает значение количества результатов count_result_

---

## `function getResultQueryArray($query)` _- выполнят запрос SQL, получает объект mysqli_query и далее получает из него массив значений функцией mysqli_fetch_assoc или возвращает false, так же задает значение количества результатов count_result_

---

## `function getRowsArray()` _- получение массива результатов запроса, если он существует, иначе false_
