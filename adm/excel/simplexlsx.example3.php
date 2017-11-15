<?php
if (isset($_FILES['file'])) {

    require_once "simplexlsx.class.php";

//$xlsx = new SimpleXLSX("testImport.xlsx");

    $xlsx = new SimpleXLSX($_FILES['file']['tmp_name']);

    echo '<h1>Parsing Result</h1>';
//  echo '<table border="1" cellpadding="3" style="border-collapse: collapse">';

    list($cols, ) = $xlsx->dimension();
    $web = "Web";
    $winlose = "Win/Lose";
    $total = "Total";



    $i = 1;
    foreach ($xlsx->rows() as $k => $r) {
        if ($k != 0) {
            continue;
        }
        for ($c = 0; $c < $cols - 1; $c++) {


            $name = ( (isset($r[$c])) ? $r[$c] : NULL );

            $keyWeb = $c;
            $keyWinLose = $c + 1;



            if ($name != NULL) {
                echo '<table border="1" cellpadding="3" style="border-collapse: collapse">';
                echo '<tr>';
                echo '<td>' . $name . '</td>';
                echo '<td></td>';
                echo '</tr>';
                echo '<tr>';
                echo '<td>' . $web . '</td>';
                echo '<td>' . $winlose . '</td>';
                echo '</tr>';


                foreach ($xlsx->rows() as $k2 => $r2) {
                    if ($k2 < 3) {
                        continue;
                    }


                    $col_web = ( (isset($r2[$keyWeb])) ? $r2[$keyWeb] : NULL );
                    $col_wl = ( (isset($r2[$keyWinLose])) ? $r2[$keyWinLose] : NULL );

                    if (is_numeric($col_web)) {
                        continue;
                    }
                    if (!is_numeric($col_wl)) {
                        continue;
                    }

                    if ($col_web != NULL) {
                        echo '<tr>';
                        echo '<td>' . ( $col_web != NULL ? $col_web : '&nbsp;' ) . '</td>';
                        echo '<td>' . ( $col_wl != NULL ? $col_wl : '&nbsp;' ) . '</td>';
                        echo '</tr>';
                    }
                }
                echo '</table> <br/>';
            }
        }



//        echo '<tr>';
//        $cols = 2;
//        for ($i = 0; $i < $cols; $i++) {
//            echo '<td>' . ( (isset($r[$i])) ? $r[$i] : '&nbsp;' ) . '</td>';
//        }
//        echo '</tr>';
    }
//echo '</table>';
}
?>
<h1>Upload</h1>
<form method="post" enctype="multipart/form-data">
    *.XLSX <input type="file" name="file"  />&nbsp;&nbsp;<input type="submit" value="Parse" />
</form>
