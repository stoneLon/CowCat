<?php
if ( ! function_exists('two_dimensional_array_unique')) {

    /**
     * 移除二维数组中指定键名重复的值
     *
     * @param  $array
     * @param  $key
     *
     * @return array
     */
    function two_dimensional_array_unique($array, $key)
    {
        $i = 0;
        $key_array = [];
        $temp_array = [];

        foreach ($array as $value) {
            if ( ! in_array($value[$key], $key_array)) {
                $key_array[$i] = $value[$key];
                $temp_array[$i] = $value;
            }
            $i++;
        }

        return $temp_array;
    }
}

if ( ! function_exists('array_random')) {

    /**
     * 随机返回数组中的值
     *
     * @param  $array
     *
     * @return mixed
     */
    function array_random($array)
    {
        return $array[array_rand($array)];
    }
}

if ( ! function_exists('two_dimensional_array_sort')) {

    /**
     * 二维数组排序
     *
     * @param  $array
     * @param  $on
     * @param  $order
     *
     * @return array
     */
    function two_dimensional_array_sort($array, $on, $order = SORT_ASC)
    {
        $new_array = [];
        $sortable_array = [];
        $on = (string)$on;
        if (count($array) > 0) {
            foreach ($array as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $k2 => $v2) {
                        if ($k2 == $on) {
                            $sortable_array[$k] = $v2;
                        }
                    }
                } else {
                    $sortable_array[$k] = $v;
                }
            }

            switch ($order) {
                case SORT_ASC:
                    asort($sortable_array);
                    break;
                case SORT_DESC:
                    arsort($sortable_array);
                    break;
            }

            foreach ($sortable_array as $k => $v) {
                $new_array[$k] = $array[$k];
            }
        }

        return $new_array;
    }
}

if ( ! function_exists('create_level_tree')) {

    /**
     * 生成一维数组 HTML 层级树
     *
     * @param        $data
     * @param int    $parent_id
     * @param int    $level
     * @param string $html
     *
     * @return array
     */
    function create_level_tree($data, $parent_id = 0, $level = 0, $html = '-')
    {
        $tree = [];
        foreach ($data as $item) {
            $item['html'] = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $level);
            $item['html'] .= $level === 0 ? "" : '|';
            $item['html'] .= str_repeat($html, $level);

            if ($item['parent_id'] == $parent_id) {
                $tree[] = $item;
                $tree = array_merge($tree, create_level_tree($data, $item['id'], $level + 1));
            }
        }

        return $tree;
    }
}

if ( ! function_exists('create_node_tree')) {

    /**
     * 生成二维数组节点树
     *
     * @param        $data
     * @param int    $parent_id
     * @param string $name
     *
     * @return array
     */
    function create_node_tree($data, $parent_id = 0, $name = 'child')
    {
        $tree = [];

        foreach ($data as $item) {
            if ($item['parent_id'] == $parent_id) {
                $item[$name] = create_node_tree($data, $item['id']);
                $tree[] = $item;
            }
        }

        return $tree;
    }
}

if ( ! function_exists('get_week_start_time_and_end_date')) {

    /**
     * 获取一个星期的开始(星期日)与结束(星期六)日期
     *
     * @return array
     */
    function get_week_start_time_and_end_date()
    {
        $day = date('w');
        $end = 6 - $day;
        $start = 6 - $end;
        $arr[] = date('Y-m-d 00:00:00', strtotime('now -' . $start . ' day'));
        $arr[] = date('Y-m-d 23:59:59', strtotime('now +' . $end . ' day'));

        return $arr;
    }
}

if ( ! function_exists('getParentsByChildId')) {
    /**
     * 根据子元素 ID 获取所有的父元素
     *
     * @param $data
     * @param $child_id
     *
     * @return array
     */
    function getParentsByChildId($data, $child_id)
    {
        $arr = [];
        foreach ($data as $item) {
            if ($data['id'] == $child_id) {
                $arr[] = $item;
                $arr = array_merge($arr, getParentsByChildId($data, $item['parent_id']));
            }
        }

        return $arr;
    }
}

if ( ! function_exists('getChildsByParentId')) {
    /**
     * 根据父元素 ID 获取所有的子元素
     *
     * @param $data
     * @param $parent_id
     *
     * @return array
     */
    function getChildsByParentId($data, $parent_id)
    {
        $arr = [];
        foreach ($data as $item) {
            if ($data['parent_id'] == $parent_id) {
                $arr[] = $item;
                $arr = array_merge($arr, getChildsByParentId($data, $item['parent_id']));
            }
        }

        return $arr;
    }
}

if ( ! function_exists('get_dir_files')) {

    /**
     * 遍历文件目录,获取所有的文件路径
     *
     * @param $dir
     *
     * @return array
     */
    function get_dir_files($dir)
    {
        $files = [];

        if ( ! is_dir($dir)) {
            return $files;
        }

        $handle = opendir($dir);
        if ($handle) {
            while (false !== ($file = readdir($handle))) {
                if ($file != '.' && $file != '..') {
                    $filename = $dir . "/" . $file;
                    if (is_file($filename)) {
                        $files[] = $filename;
                    } else {
                        $files = array_merge($files, get_dir_files($filename));
                    }
                }
            }   //  end while
            closedir($handle);
        }

        return $files;
    }
}