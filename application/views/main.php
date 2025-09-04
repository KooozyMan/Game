<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>حروف وألوف</title>
    <?php $this->load->view('partials/header'); ?>
</head>

<body>
    <div class="board">
        <?php
        $cols = count($grid[0]);
        $rows = count($grid);
        // transpose the grid for column-based layout
        $columns = [];
        for ($c = 0; $c < $cols; $c++) {
            $columns[$c] = [];
            for ($r = 0; $r < $rows; $r++) {
                $columns[$c][$r] = $grid[$r][$c];
            }
        }
        ?>

        <?php foreach ($columns as $colIndex => $col): ?>
            <div class="hex-column <?= $colIndex % 2 == 1 ? 'offset' : '' ?>">
                <?php foreach ($col as $rowIndex => $letter): ?>
                    <?php
                    $classes = "hexagon-button";
                    if ($rowIndex == 0 || $rowIndex == $rows - 1) {
                        $classes .= " red-edge"; // top/bottom edges
                    } elseif ($colIndex == 0 || $colIndex == $cols - 1) {
                        $classes .= " green-edge"; // left/right edges
                    }
                    ?>
                    <button id="<?= $letter ?>" class="<?= $classes ?>" onclick="cycleState(this)"><?= $letter ?></button>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>
</body>
<script>
    function cycleState(btn) {
        if (btn.classList.contains('state1')) {
            btn.classList.remove('state1');
            btn.classList.add('state2');
        } else if (btn.classList.contains('state2')) {
            btn.classList.remove('state2');
        } else {
            btn.classList.add('state1');
        }
    }
</script>

</html>