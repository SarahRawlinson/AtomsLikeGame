<?php
require_once "include.php";
$str = "";

if (!isset($_SESSION['game_data']))
{
    header('Location: Main.php');
}
if (isset($_POST['row_count']))
{
    $_SESSION['game_data']->setRowCount($_POST['row_count']);
    echo $_SESSION['game_data']->RowCount();
}
if (isset($_POST['column_count']))
{
    $_SESSION['game_data']->setColumnCount($_POST['column_count']);
    echo $_SESSION['game_data']->ColumnCount();
}

?>
<!DOCTYPE html>
<a href="Main.php">Back</a><br><br>
<html lang="en">
<head><title>Settings</title>
    <link rel="stylesheet" href="../CSS/GAME.css" type="text/css">
</head>

<body>
<!--<p>--><?//=$str?><!--</p>-->

<form action="settings.php" method="post">
    <label for="row_count">Row Count:</label>
    <select name="row_count" id="row_count">
        <?php
        $rowCount = $_SESSION['game_data']->RowCount();
            for ($i = 3; $i <= 15; $i++)
            {
                $selected = $i==$rowCount?"selected='selected'":"";
                echo "<option value=$i $selected>$i</option>";
            }
        ?>
    </select>
    <button type="submit">Select</button>
</form>

<form action="settings.php" method="post">
    <label for="column_count">Column Count:</label>
    <select name="column_count" id="column_count">
        <?php
        $columnCount = $_SESSION['game_data']->ColumnCount();
        for ($i = 3; $i <= 15; $i++)
        {
            $selected = $i==$columnCount?"selected='selected'":"";
            echo "<option value=$i $selected>$i</option>";
        }
        ?>
    </select>
    <button type="submit">Select</button>
</form>
</body>

</html>
