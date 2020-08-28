<?php
date_default_timezone_set("Asia/Shanghai");
$pm = date("Ymd").date("h")+12;
echo (date("a")=="pm") ? $pm.date(":i:s"):date("Ymdh:i:sa");

?>