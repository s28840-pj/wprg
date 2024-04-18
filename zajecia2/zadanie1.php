<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
    <form method="post">
        <input type="text" pattern="[0-9]+" name="fst">
        <input type="text" pattern="[0-9]+" name="snd">
        <div>
            <label>+ <input type="radio" name="op" value="plus"></label><br>
            <label>- <input type="radio" name="op" value="minus"></label><br>
            <label>* <input type="radio" name="op" value="mul"></label><br>
            <label>/ <input type="radio" name="op" value="div"></label>
        </div>
        <input type="submit" value="Calc">
    </form>
    <?php
        $tocheck = array('op', 'fst', 'snd');
        $shouldcalc = true;
        foreach ($tocheck as $v) {
            if(!isset($_POST[$v])) {
                $shouldcalc = false;
                break;
            }
        }
        if($shouldcalc) {
            echo '<div>';

            $fst = intval($_POST['fst']);
            $snd = intval($_POST['snd']);
            $sym = '';
            $res = 0;

            switch($_POST['op']) {
                case 'plus':
                    $sym = '+';
                    $res = $fst + $snd;
                    break;
                case 'minus':
                    $sym = '-';
                    $res = $fst - $snd;
                    break;
                case 'mul':
                    $sym = '*';
                    $res = $fst * $snd;
                    break;
                case 'div':
                    $sym = '/';
                    $res = $fst / $snd;
                    break;
                default:
                    $sym = '???';
                    $res = 'UNKNOWN OPERATION';
                    break;
            }

            echo $fst . ' ' . $sym . ' ' . $snd . ' = ' . $res;

            echo '</div>';
        }
    ?>
</body>
</html>
