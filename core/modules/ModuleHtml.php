<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 21.05.2018
 * Time: 14:37
 */

class ModuleHtml
{
    private static $inst = null;
    private static $memcache = null;

    private function __construct()
    {

    }

    private function __sleep()
    {
    }

    private function __wakeup()
    {
    }

    public static function instance():?self
    {
        return self::$inst === null ? self::$inst = new self() : self::$inst;
    }

    public function a(string $url, $text, string $class = null): string
    {
        return $class === null
            ? "<a href='$url'>$text</a>"
            : "<a href='$url' class='$class'>$text</a>";
    }

    public function ul(array $elems, string $ulClass, string $liClass): string
    {
        $str = $ulClass === null ? "<ul>" : "<ul class='$ulClass'>";
        foreach ($elems as $elem) {
            $str .= $liClass === null ? "<li>" : "<li class='$liClass'>";
            $str .= $elem . "</li>";
        }
        $str .= "</ul>";
        return $str;
    }
    private function pages(int $left,int $right,int $page,array &$array,string $base_link):int
    {
        for ($i = $left - 1; $i > 0; $i--) {
            $array[] = $this->a($base_link
                . "/" .($page - $i), $page - $i);
        }
        $array[] = $this->a($base_link . "/" .$page, $page, "active");
        for ($i = 1; $i <= $right; $i++) {
            $array[] = $this->a($base_link . "/" .($page + $i), $page + $i);
        }
        return $i;
    }
    public function paginator(int $page, int $total, string $baseurl, int $size)
    {
        $baseurl_parts = explode("?", $baseurl);
        $base_link = $baseurl_parts[0];
        $get_link = !empty($baseurl_parts[1]) ? "?{$baseurl_parts[1]}" : "";
        $page = $page === 0 ? $page = 1 : $page;
        $links = [];

        if ($page > 1) $links[] = $this->a($base_link . "/" . ($page - 1), "&lt;", "prev");
        if ($size > $total) {
            $left = $page < $total ? $total - ($total - $page) : $page;
            $right = $total - $left;
            $i = $this->pages($left,$right,$page,$links,$base_link);
        } else {
            $left = (int)ceil($size / 2);
            $left = $left > $page ? $page : $left;
            $rightRange = $total - $page;
            $right = $size - $left;
            if ($rightRange < $right) {
                $left += $right - $rightRange;
                $right = $rightRange;
            }
            $i = $this->pages($left,$right,$page,$links,$base_link);
            if ($total - ($page + $i) > 0) {
                $links[] = $this->a("", "...");
                $links[] = $this->a($base_link . "/" .$total, $total);
            }
            if ($page - $left > 1){
                $first = array($this->a($base_link . "/" ."1", 1, ""),$this->a("", "..."));
                array_splice($links, 1, 0,$first);
            }
        }
        if ($page < $total) $links[] = $this->a($base_link . "/" . ($page + 1), "&gt;", "next");
        return $this->ul($links, "paginator", "s");
    }
}





// to 4to stoyalo vnutri ifov
//            for ($i = $left - 1; $i > 0; $i--) {
//                $links[] = $this->a($base_link . "/" .($page-$i), $page - $i);
//            }
//            $links[] = $this->a($base_link . "/" .$page, $page, "active");
//            for ($i = 1; $i <= $right; $i++) {
//                $links[] = $this->a($base_link . "/" .($page+$i), $page + $i);
//            }

//            for ($i = $left - 1; $i > 0; $i--) {
//                $links[] = $this->a($base_link
//                    . "/" .($page - $i), $page - $i);
//            }
//            $links[] = $this->a($base_link . "/" .$page, $page, "active");
//            for ($i = 1; $i <= $right; $i++) {
//                $links[] = $this->a($base_link . "/" .($page + $i), $page + $i);
//            }