<?php
/* +--------------------------------------------------+ */
/* | Author : iWulai <iwulai@qq.com> <www.iwulai.com> | */
/* +--------------------------------------------------+ */
//SELECT T2.`id`,T2.`pid`,T2.`name`,T2.`url`
//    FROM (
//        SELECT
//            @r AS _id,
//              (SELECT @r := pid FROM `__MENU__` WHERE id = _id) AS pid,
//            @l := @l + 1 AS lvl
//        FROM
//        (SELECT @r :=
//              ( SELECT `id` FROM `__MENU__` WHERE `url` LIKE '%{$current_url}%' LIMIT 1 ),
//           @l := 0) vars,
//            `__MENU__` h
//        WHERE @r <> 0) T1
//    JOIN `__MENU__` T2 ON T1._id = T2.id ORDER BY T1.lvl DESC