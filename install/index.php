<?php $cms = '1.0'; ?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta http-equiv="content-type" content="application/xhtml+xml; charset=utf-8"/>
        <meta http-equiv="Content-Style-Type" content="text/css" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="HandheldFriendly" content="true">
        <meta name="MobileOptimized" content="width">
        <meta name="author" content="VCMS, http://vcms.su">
        <meta name="generator" content="VCMS, http://vcms.su">
        <title>Установка VCMS, версия <?php echo $cms; ?></title>
        <link rel="shortcut icon" href="/style/default/images/favicon.ico" />
        <link rel="stylesheet" href="/style/default/css/bootstrap.min.css">
        <link rel="stylesheet" href="/style/default/font-awesome-4.6.3/css/font-awesome.min.css">
        <link rel="stylesheet" href="/style/default/css/style.css">
        <script src="/style/default/js/jquery.min.js"></script>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="fon">
                        <?php

                        function split_sql($sql) {
                            $sql = trim($sql);
                            $sql = str_replace("\n#[^\n]*\n", "\n", $sql);
                            $buffer = array();
                            $ret = array();
                            $in_string = false;
                            for ($i = 0; $i < strlen($sql) - 1; $i++) {
                                if ($sql[$i] == ";" && !$in_string) {
                                    $ret[] = substr($sql, 0, $i);
                                    $sql = substr($sql, $i + 1);
                                    $i = 0;
                                }
                                if ($in_string && ($sql[$i] == $in_string) && $buffer[1] != "\\") {
                                    $in_string = false;
                                } elseif (!$in_string && ($sql[$i] == '"' || $sql[$i] == "'") && (!isset($buffer[0]) || $buffer[0] != "\\")) {
                                    $in_string = $sql[$i];
                                }
                                if (isset($buffer[1])) {
                                    $buffer[0] = $buffer[1];
                                }
                                $buffer[1] = $sql[$i];
                            }
                            if (!empty($sql)) {
                                $ret[] = $sql;
                            }
                            return ($ret);
                        }

                        function delcat($directory) {
                            $dir = scandir($directory);
                            $dir = array_slice($dir, 2);
                            foreach ($dir as $file) {
                                $file = $directory . '/' . $file;
                                if (is_dir($file)) {
                                    delcat($file);
                                    if (is_dir($file))
                                        rmdir($file);
                                } else {
                                    unlink($file);
                                }
                            }
                            rmdir($directory);
                        }

                        if ($_GET['step'] == 1) {
                            require 'step1.php';
                        } else if ($_GET['step'] == 2) {
                            require 'step2.php';
                        } else if ($_GET['step'] == 3) {
                            require 'step3.php';
                        } else if ($_GET['step'] == 4) {
                            require 'step4.php';
                        } else
                            require 'start.php';
                        ?>
                        <script src="/style/default/js/bootstrap.min.js"></script>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>