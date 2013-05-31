<?php

/**
 * api/initsetup.php perform database changes.
 *
 * API create and modify database tables.
 * 
 * Copyright (C) 2012 Karl Englund <karl@mastermobileproducts.com>
 *
 * LICENSE: This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 3
 * of the License, or (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://opensource.org/licenses/gpl-3.0.html>;.
 *
 * @package OpenEMR
 * @author  Karl Englund <karl@mastermobileproducts.com>
 * @link    http://www.open-emr.org
 */


$ignoreAuth = true;
require_once('classes.php');

$query1 = "CREATE TABLE IF NOT EXISTS `api_tokens` (
            `id` bigint(20) NOT NULL AUTO_INCREMENT,
            `user_id` bigint(20) DEFAULT NULL,
            `token` varchar(150) DEFAULT NULL,
            `device_token` varchar(200) NOT NULL,
            `create_datetime` datetime DEFAULT NULL,
            `expire_datetime` datetime DEFAULT NULL,
            `message_badge` int(5) NOT NULL,
            `appointment_badge` int(5) NOT NULL,
            `labreports_badge` int(5) NOT NULL,
            `prescription_badge` int(5) NOT NULL,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";

//sqlStatement($query1);
$res1 = sqlStatement($query1);

$query2 = "ALTER TABLE `users` ADD `create_date` DATE NOT NULL ,
            ADD `secret_key` VARCHAR( 100 ) NULL ,
            ADD `ip_address` VARCHAR( 20 ) NULL ,
            ADD `country_code` VARCHAR( 10 ) NULL ,
            ADD `country_name` VARCHAR( 50 ) NULL ,
            ADD `latidute` VARCHAR( 20 ) NULL ,
            ADD `longitude` VARCHAR( 20 ) NULL ,
            ADD `time_zone` VARCHAR( 10 ) NULL ,
            ADD `app_pin` VARCHAR( 100 ) NULL,
            ADD `contact_image` VARCHAR( 100 ) NULL";

//$db->query($query2);
$res2 = sqlStatement($query2);


if (($res1 && $res2) || $res3) {
    echo "<h1>Database Updated Successfully</h1>";
} else {
    echo "<h1>Database Failed to Update</h1>";
}
?>
