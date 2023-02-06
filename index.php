<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>線上月曆</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        table {
            width: 800px;
            margin: auto;
            padding: 20px;
            border: 3px solid white;
            height: 600px;
            font-family: 'Microsoft JhengHei';
            font-size: 30px;
            background: gray;
            border-radius: 10px;
        }

        body {
            width: auto;
            height: auto;

            background-size: cover;
        }

        td {
            padding: 5px;
            text-align: center;
            border: 1px solid black;

        }

        td:hover {
            color: gray;
            background-color: wheat;
        }

        .dayoff {
            background-color: gray;
        }

        .special-date {
            background-color: black;
            color: white;
        }

        .nowmonth {
            text-align: center;
            display: flex;
            justify-content: center;

        }

        .nowmonthdiv {
            width: 600px;
            display: flex;
            justify-content: space-around;
            color: wheat;
            background: gray;
            border: 3px solid whitesmoke;
            border-radius: 10px;
            height: 50px;
            align-items: center;
        }

        a {
            color: wheat;
            margin: auto;
        }

        td {
            color: wheat;
        }
    </style>
</head>


<?php
if (isset($_GET["year"])) {
    $year = $_GET["year"];
} else {
    $year = date("Y");
}
if (isset($_GET["month"])) {
    $month = $_GET["month"];
} else {
    $month = date("m");
}
switch ($month) {
    case '12':
    case '01':
    case '02':
        echo '<body style="background-image: url(winter.jpg)";>';
    case '03':
    case '04':
    case '05':
        echo '<body style="background-image: url(spring.jpg)";>';
    case '06':
    case '07':
    case '08':
        echo '<body style="background-image: url(summer.jpg)";>';
    case '09':
    case '10':
    case '11':
        echo '<body style="background-image: url(fall.jpg)";>';
}

$currentDate = new DateTime("$year-$month-01");
$currentDate->modify('-1 month');
$previousYear = date("Y", $currentDate->getTimestamp());
$previousMonth = date("m", $currentDate->getTimestamp());
$currentDate = new DateTime("$year-$month-01");
$currentDate->modify('+1 month');
$nextYear = date("Y", $currentDate->getTimestamp());
$nextMonth = date("m", $currentDate->getTimestamp());
$specialDate = [''];
$firstDay = date("$year-$month-01");
$firstWeekWhiteDays = date("w", strtotime($firstDay));
$monthDays = date("t", strtotime($firstDay));
$firstWeekDays = 7 - $firstWeekWhiteDays;
$weeks = ceil(($firstWeekWhiteDays + $monthDays) / 7);

$lastWeekDays = ($firstWeekWhiteDays + $monthDays) % 7;
$lastWeekWhiteDays = 7 - $lastWeekDays;

$nowmonth = date("$year-$month");
$calendarHeader = <<<EOF
    <h1 class="nowmonth">
        <div class="nowmonthdiv">
        <a href="./index.php?year=$previousYear&month=$previousMonth"><i class="fas fa-chevron-circle-left"></i></a>
        $nowmonth
        <a href="./index.php?year=$nextYear&month=$nextMonth"><i class="fas fa-chevron-circle-right"></i></a>
        </div>
    </h1>
    EOF;
echo $calendarHeader;
echo "<br>";


echo "<table>";
echo "<tr>";
echo "<td>日</td>";
echo "<td>一</td>";
echo "<td>二</td>";
echo "<td>三</td>";
echo "<td>四</td>";
echo "<td>五</td>";
echo "<td>六</td>";

echo "</tr>";
for ($i = 0; $i < $weeks; $i++) {
    echo "<tr>";
    if ($i == 0) {

        for ($k = 0; $k < $firstWeekWhiteDays; $k++) {
            echo "<td>";
            echo "&nbsp;";
            echo "</td>";
        }

        for ($l = 0; $l < $firstWeekDays; $l++) {
            $date = date("$year-$month-") . ($i * 7 + $l + 1);
            $w = date('w', strtotime($date));

            if (array_key_exists($date, $specialDate)) {
                $sp = '';
            } else {
                $sp = '';
            }

            if ($w == 0 || $w == 6) {
                echo "<td class='dayoff $sp'>";
            } else {
                echo "<td class='$sp'>";
            }
            echo $i * 7 + $l + 1;
            echo "<br>";
            if (!empty($sp)) {
                echo $specialDate[$date];
            }
            echo "</td>";
        }
    } elseif ($i == $weeks - 1) {

        if ($lastWeekDays == 0) {
            $lastWeekDays = 7;
        }
        for ($m = 0; $m < $lastWeekDays; $m++) {
            $date = date("$year-$month-") . ($i * 7 + $m + 1 - $firstWeekWhiteDays);
            $w = date('w', strtotime($date));
            if (array_key_exists($date, $specialDate)) {
                $sp = '';
            } else {
                $sp = '';
            }
            if ($w == 0 || $w == 6) {
                echo "<td class='dayoff $sp'>";
            } else {
                echo "<td class='$sp'>";
            }
            echo $i * 7 + $m + 1 - $firstWeekWhiteDays;
            echo "<br>";
            if (!empty($sp)) {
                echo $specialDate[$date];
            }
            echo "</td>";
        }
        if ($lastWeekDays != 7) {
            for ($n = 0; $n < $lastWeekWhiteDays; $n++) {
                echo "<td>";
                echo "&nbsp;";
                echo "</td>";
            }
        }
    } else {

        for ($j = 0; $j < 7; $j++) {
            $date = date("$year-$month-") . ($i * 7 + $j + 1 - $firstWeekWhiteDays);
            $w = date('w', strtotime($date));
            if (array_key_exists($date, $specialDate)) {
                $sp = 'special-date';
            } else {
                $sp = '';
            }
            if ($w == 0 || $w == 6) {

                echo "<td class='dayoff $sp'>";
            } else {
                echo "<td class='$sp'>";
            }
            echo $i * 7 + $j + 1 - $firstWeekWhiteDays;
            echo "<br>";
            if (!empty($sp)) {
                echo $specialDate[$date];
            }
            echo "</td>";
        }
    }
    echo "</tr>";
}
echo "</table>";

?>

</div>
</body>

</html>