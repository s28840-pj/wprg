<?php
    $s = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.";
    $arr = explode(' ', $s);
    $BANNED = array(",", ".", "'");

    for ($i = sizeof($arr) - 1; $i >= 0; $i -= 1) {
        foreach ($BANNED as $banned) {
            if (!str_contains($arr[$i], $banned)) continue;
            for ($j = $i + 1; $j < sizeof($arr); $j += 1)
                $arr[$j - 1] = $arr[$j];
            array_pop($arr);
            break;
        }
    }

    $assoc = array();
    for ($i = 0; $i < sizeof($arr); $i += 2)
        $assoc[$arr[$i]] = $arr[$i + 1];


    foreach ($assoc as $key => $val)
        echo $key . ' => ' . $val . '<br>';
