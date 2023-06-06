<?php
if (!function_exists('renderQuesAndAns')) {
    function renderQuesAndAns($text, $imageCodeArr = [])
    {
        $regImageCode = '/\[anh\d\]/';
//        $text = 'Hjhj [anh1] [anh5]';
        preg_match_all($regImageCode, $text, $matches);
        $imgCodeColArr = array_column($imageCodeArr, 'img_code');
        if (!empty($matches[0])) {
            foreach ($matches[0] as $item) {
                $imgCode = trim($item, '[]');

                $key = array_search($imgCode, $imgCodeColArr);
                if ($key === false) continue;
                $img = $imageCodeArr[$key];
                $text = str_replace($item, "<div class='p-2'><img class='w-75' src='{$img['path']}' /></div>", $text);
            }
        }
        return $text;
    }
}
