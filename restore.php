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

$query1 = "ALTER TABLE `users` ADD `app_pin` VARCHAR( 100 ) DEFAULT NULL;";

$res1 = sqlStatement($query1);


if ($res1) {
    echo "<h1>Database Updated Successfully</h1>";
} else {
    echo "<h1>Database Failed to Update</h1>";
}
?>
