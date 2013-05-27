<?php
/**
 * api/updatepatient.php Update patient information.
 *
 * API is allowed to update patient demographics, insurance details
 * and profile image.
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

header("Content-Type:text/xml");
$ignoreAuth = true;
require_once('classes.php');

$xml_array = array();

$token = $_POST['token'];
$patientId = $_POST['patientId'];

$id = $_POST['id'];

$title = $_POST['title'];
$language = $_POST['language']; //d
$firstname = $_POST['firstname']; // d
$lastname = $_POST['lastname']; //d
$middlename = $_POST['middlename']; //d
$dob = $_POST['dob']; //d
$street = $_POST['street']; // streetAddressLine1, streetAddressLine2
$postal_code = $_POST['postal_code']; // ZipCode d
$city = $_POST['city']; //d
$state = $_POST['state']; //d
$country_code = $_POST['country_code'];
$ss = $_POST['ss']; // if suffix d
$occupation = $_POST['occupation'];
$phone_home = $_POST['phone_home']; //d
$phone_biz = $_POST['phone_biz']; //d
$phone_contact = $_POST['phone_contact']; // d
$phone_cell = $_POST['phone_cell']; //d
$status = $_POST['status'];
$drivers_lincense = $_POST['drivers_license'];
$contact_relationship = $_POST['contact_relationship']; //d
$sex = $_POST['sex']; //d
$email = $_POST['email']; //d
$race = $_POST['race']; //d
$ethnicity = $_POST['ethnicity']; //d
$usertext1 = $_POST['notes']; // note d
$nickname = $_POST['nickname'];
$mothersname = $_POST['mothersname'];
$guardiansname = $_POST['guardiansname'];

$p_insurance_company = $_POST['p_provider'];
$p_subscriber_employer_status = $_POST['p_subscriber_employer'];
$p_group_number = $_POST['p_group_number'];
$p_plan_name = $_POST['p_plan_name'];
$p_subscriber_relationship = $_POST['p_subscriber_relationship'];
$p_insurance_id = $_POST['p_insurance_id'];


$s_insurance_company = $_POST['s_provider'];
$s_subscriber_employer_status = $_POST['s_subscriber_employer'];
$s_group_number = $_POST['s_group_number'];
$s_plan_name = $_POST['s_plan_name'];
$s_subscriber_relationship = $_POST['s_subscriber_relationship'];
$s_insurance_id = $_POST['s_insurance_id'];

$o_insurance_company = $_POST['o_provider'];
$o_subscriber_employer_status = $_POST['o_subscriber_employer'];
$o_group_number = $_POST['o_group_number'];
$o_plan_name = $_POST['o_plan_name'];
$o_subscriber_relationship = $_POST['o_subscriber_relationship'];
$o_insurance_id = $_POST['o_insurance_id'];

$image_data = isset($_POST['image_data']) ? $_POST['image_data'] : '';

if ($userId = validateToken($token)) {
    $user = getUsername($userId);
    
    $acl_allow = acl_check('patients', 'demo', $user);

    if ($acl_allow) {

        $postData = array(
            'id' => $id,
            'title' => $title,
            'fname' => $firstname,
            'lname' => $lastname,
            'mname' => $middlename,
            'sex' => $sex,
            'status' => $status,
            'drivers_license' => $drivers_lincense,
            'contact_relationship' => $contact_relationship,
            'phone_biz' => $phone_biz,
            'phone_cell' => $phone_cell,
            'phone_contact' => $phone_contact,
            'phone_home' => $phone_home,
            'DOB' => $dob,
            'language' => $language,
            'financial' => $financial,
            'street' => $street,
            'postal_code' => $postal_code,
            'city' => $city,
            'state' => $state,
            'country_code' => $country_code,
            'ss' => $ss,
            'occupation' => $occupation,
            'email' => $email,
            'race' => $race,
            'ethnicity' => $ethnicity,
            'usertext1' => $usertext1,
            'genericname1' => $nickname,
            'mothersname' => $mothersname,
            'guardiansname' => $guardiansname,
        );


        updatePatientData($patientId, $postData, $create = false);


        $primary_insurace_data = getInsuranceData($patientId);

        $secondary_insurace_data = getInsuranceData($patientId, 'secondary');

        $other_insurace_data = getInsuranceData($patientId, 'tertiary');

        $p_insurace_data = array(
            'provider' => $p_insurance_company,
            'group_number' => $p_group_number,
            'plan_name' => $p_plan_name,
            'subscriber_employer' => $p_subscriber_employer_status,
            'subscriber_relationship' => $p_subscriber_relationship,
            'policy_number' => $p_insurance_id
        );

        if ($primary_insurace_data) {
            updateInsuranceData($primary_insurace_data['id'], $p_insurace_data);
        } else {
            newInsuranceData(
                    $patientId, $type = "primary", $p_insurance_company, $policy_number = $p_insurance_id, $group_number = $p_group_number, $plan_name = $p_plan_name, $subscriber_lname = "", $subscriber_mname = "", $subscriber_fname = "", $subscriber_relationship =
                    $p_subscriber_relationship, $subscriber_ss = "", $subscriber_DOB = "", $subscriber_street = "", $subscriber_postal_code = "", $subscriber_city = "", $subscriber_state = "", $subscriber_country = "", $subscriber_phone = "", $subscriber_employer =
                    $p_subscriber_employer_status, $subscriber_employer_street = "", $subscriber_employer_city = "", $subscriber_employer_postal_code = "", $subscriber_employer_state = "", $subscriber_employer_country = "", $copay = "", $subscriber_sex = "", $effective_date = "0000-00-00", $accept_assignment = "TRUE"
            );
        }

        $s_insurace_data = array(
            'provider' => $s_insurance_company,
            'group_number' => $s_group_number,
            'plan_name' => $s_plan_name,
            'subscriber_employer' => $s_subscriber_employer_status,
            'subscriber_relationship' => $s_subscriber_relationship,
            'policy_number' => $s_insurance_id
        );

        if ($secondary_insurace_data) {
            updateInsuranceData($secondary_insurace_data['id'], $s_insurace_data);
        } else {
            newInsuranceData(
                    $patientId, $type = "secondary", $s_insurance_company, $policy_number = $s_insurance_id, $group_number = $s_group_number, $plan_name = $s_plan_name, $subscriber_lname = "", $subscriber_mname = "", $subscriber_fname = "", $subscriber_relationship = $s_subscriber_relationship, $subscriber_ss = "", $subscriber_DOB = "", $subscriber_street = "", $subscriber_postal_code = "", $subscriber_city = "", $subscriber_state = "", $subscriber_country = "", $subscriber_phone = "", $subscriber_employer = $s_subscriber_employer_status, $subscriber_employer_street = "", $subscriber_employer_city = "", $subscriber_employer_postal_code = "", $subscriber_employer_state = "", $subscriber_employer_country = "", $copay = "", $subscriber_sex = "", $effective_date = "0000-00-00", $accept_assignment = "TRUE");
        }

        $o_insurace_data = array(
            'provider' => $o_insurance_company,
            'group_number' => $o_group_number,
            'plan_name' => $o_plan_name,
            'subscriber_employer' => $o_subscriber_employer_status,
            'subscriber_relationship' => $o_subscriber_relationship,
            'policy_number' => $o_insurance_id
        );

        if ($other_insurace_data) {
            updateInsuranceData($other_insurace_data['id'], $o_insurace_data);
        } else {
            newInsuranceData(
                    $patientId, $type = "tertiary", $o_insurance_company, $policy_number = $o_insurance_id, $group_number = $o_group_number, $plan_name = $o_plan_name, $subscriber_lname = "", $subscriber_mname = "", $subscriber_fname = "", $subscriber_relationship = $o_subscriber_relationship, $subscriber_ss = "", $subscriber_DOB = "", $subscriber_street = "", $subscriber_postal_code = "", $subscriber_city = "", $subscriber_state = "", $subscriber_country = "", $subscriber_phone = "", $subscriber_employer = $o_subscriber_employer_status, $subscriber_employer_street = "", $subscriber_employer_city = "", $subscriber_employer_postal_code = "", $subscriber_employer_state = "", $subscriber_employer_country = "", $copay = "", $subscriber_sex = "", $effective_date = "0000-00-00", $accept_assignment = "TRUE");
        }


        if ($image_data) {

            $id = 1;
            $type = "file_url";
            $size = '';
            $date = date('Y-m-d H:i:s');
            $url = '';
            $mimetype = 'image/jpeg';
            $hash = '';
            $patient_id = $patientId;
            $ext = 'png';
//            $cat_title = 'Patient Profile Image';
            $cat_title = 'Patient Photograph';
            
            $strQuery2 = "SELECT id from `categories` WHERE name LIKE ?";

            $result3 = sqlQuery($strQuery2, array($cat_title));

            if ($result3) {
                $cat_id = $result3['id'];
            } else {
                sqlStatement("lock tables categories read");

                $result4 = sqlQuery("select max(id)+1 as id from categories");

                $cat_id = $result4['id'];

                sqlStatement("unlock tables");

                $cat_insert_query = "INSERT INTO `categories`(`id`, `name`, `value`, `parent`, `lft`, `rght`) 
                VALUES (" . add_escape_custom($cat_id) . ",'" . add_escape_custom($cat_title) . "','',1,0,0)";

                sqlStatement($cat_insert_query);
            }

            $strQuery4 = "SELECT d.url,d.id
                                FROM `documents` AS d
                                INNER JOIN `categories_to_documents` AS c2d ON d.id = c2d.document_id
                                WHERE d.foreign_id = ?
                                AND c2d.category_id = ?
                                ORDER BY category_id, d.date DESC";

            $result4 = sqlQuery($strQuery4, array($patient_id, $cat_id));

            if ($result4) {
                $file_path = $result4['url'];
                $document_id = $result4['id'];
                unlink($file_path);

                $strQueryD = "DELETE FROM `documents` WHERE id =?";
                $resultD = sqlStatement($strQueryD, array($document_id));

                $strQueryD1 = "DELETE FROM `categories_to_documents` WHERE document_id =?";
                $resultD = sqlStatement($strQueryD1, array($document_id));
            }

            $image_path = $sitesDir . "$site}/documents/{$patient_id}";

            if (!file_exists($image_path)) {
                mkdir($image_path);
            }

            $image_date = date('Y-m-d_H-i-s');

            file_put_contents($image_path . "/" . $image_date . "." . $ext, base64_decode($image_data));


            sqlStatement("lock tables documents read");

            $result = sqlQuery("select max(id)+1 as did from documents");

            sqlStatement("unlock tables");

            if ($result['did'] > 1) {
                $id = $result['did'];
            }

            $hash = sha1_file($image_path . "/" . $image_date . "." . $ext);

            $url = "file://" . $image_path . "/" . $image_date . "." . $ext;

            $size = filesize($url);

            $strQuery = "INSERT INTO `documents`( `id`, `type`, `size`, `date`, `url`, `mimetype`, `foreign_id`, `docdate`, `hash`, `list_id`) 
             VALUES (" . add_escape_custom($id) . ",'" . add_escape_custom($type) . "','" . add_escape_custom($size) . "','" . add_escape_custom($date) . "','" . add_escape_custom($url) . "','" . add_escape_custom($mimetype) . "'," . add_escape_custom($patient_id) . ",'" . add_escape_custom($docdate) . "','" . add_escape_custom($hash) . "','" . add_escape_custom($list_id) . "')";

            $result = sqlStatement($strQuery);

            $strQuery1 = "INSERT INTO `categories_to_documents`(`category_id`, `document_id`) VALUES (" . add_escape_custom($cat_id)."," . add_escape_custom($id).")";

            $result1 = sqlStatement($strQuery1);
        }

        $xml_array['status'] = 0;
        $xml_array['reason'] = 'Patient updated successfully';
    } else {
        $xml_array['status'] = -2;
        $xml_array['reason'] = 'You are not Authorized to perform this action';
    }
} else {
    $xml_array['status'] = -2;
    $xml_array['reason'] = 'Invalid Token';
}

$xml = ArrayToXML::toXml($xml_array, 'Patient');
echo $xml;
?>