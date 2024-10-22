<?php
// require_once('common/master.php');

require_once("pdo_connect.php");
$db = new pdo_connect();

function test_data($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (isset($_POST['submit'])) {
    $maxFileSize = 200 * 1024;
    $allowedFileExtension = ["jpg", "jpeg", "png", "webp", "pdf"];

    // Function to handle file uploads
    function handleFileUpload($fileKey, $newFileName, $targetDirectory)
    {
        move_uploaded_file($_FILES[$fileKey]['tmp_name'], "upload/$targetDirectory/" . $newFileName);
        return "upload/$targetDirectory/$newFileName";
    }

    if (
        isset($_FILES['aadhar_front_upload_file']) &&
        isset($_FILES['aadhar_back_upload_file']) &&
        isset($_FILES['pan_front_upload_file']) &&
        isset($_FILES['user_photo_upload_file']) &&
        isset($_FILES['electricity_bill_upload_file']) &&
        isset($_FILES['rent_agreement_upload_file']) &&
        isset($_FILES['relative_noc_upload_file']) &&
        isset($_FILES['other_doc_upload_file'])
    ) {
        // Generate new file names
        $user_photo_new_name = time() . rand(10, 99) . '.' . pathinfo($_FILES['user_photo_upload_file']['name'], PATHINFO_EXTENSION);
        $electricity_bill_new_name = time() . rand(10, 99) . '.' . pathinfo($_FILES['electricity_bill_upload_file']['name'], PATHINFO_EXTENSION);
        $rent_agreement_new_name = time() . rand(10, 99) . '.' . pathinfo($_FILES['rent_agreement_upload_file']['name'], PATHINFO_EXTENSION);
        $relative_noc_new_name = time() . rand(10, 99) . '.' . pathinfo($_FILES['relative_noc_upload_file']['name'], PATHINFO_EXTENSION);
        $other_doc_new_name = time() . rand(10, 99) . '.' . pathinfo($_FILES['other_doc_upload_file']['name'], PATHINFO_EXTENSION);
        $aadhar_front_new_name = time() . rand(10, 99) . '.' . pathinfo($_FILES['aadhar_front_upload_file']['name'], PATHINFO_EXTENSION);
        $aadhar_back_new_name = time() . rand(10, 99) . '.' . pathinfo($_FILES['aadhar_back_upload_file']['name'], PATHINFO_EXTENSION);
        $pan_front_new_name = time() . '.' . pathinfo($_FILES['pan_front_upload_file']['name'], PATHINFO_EXTENSION);



        // Validate file extensions and sizes
        foreach ($_FILES as $file) {
            if (!in_array(pathinfo($file['name'], PATHINFO_EXTENSION), $allowedFileExtension) || $file['size'] > $maxFileSize) {
                $_SESSION['msg'] = "<center style='margin-bottom: 20px; color:red;'>Invalid file type or size exceeded 200kb.</center>";
                header("location:index.php");
                exit;
            }
        }

        // Move files to the target directories
        $user_photo_file_url = handleFileUpload('user_photo_upload_file', $user_photo_new_name, 'photo');
        $electricity_bill_file_url = handleFileUpload('electricity_bill_upload_file', $electricity_bill_new_name, 'electricity_bill');
        $rent_agreement_file_url = handleFileUpload('rent_agreement_upload_file', $rent_agreement_new_name, 'rent_agreement');
        $aadhar_front_file_url = handleFileUpload('aadhar_front_upload_file', $aadhar_front_new_name, 'aadhar');
        $aadhar_back_file_url = handleFileUpload('aadhar_back_upload_file', $aadhar_back_new_name, 'aadhar');
        $pan_front_file_url = handleFileUpload('pan_front_upload_file', $pan_front_new_name, 'pan');
        $relative_noc_file_url = handleFileUpload('relative_noc_upload_file', $relative_noc_new_name, 'relative_noc');
        $other_doc_file_url = handleFileUpload('other_doc_upload_file', $other_doc_new_name, 'other_doc');

        // Database connection
        global $DB_LINK_PDO; // Using the PDO connection from db.config.inc.php
        $pan_number = test_data($_POST['pan_number']);
        $name = test_data($_POST['name']);
        $phone = test_data($_POST['phone_number']);
        $email = test_data($_POST['email']);
        $father_name = test_data($_POST['father_name']);
        $b_name = test_data($_POST['b_name']);
        $b_address = test_data($_POST['b_address']);

        // Prepare SQL statement for insertion
        $sql = "INSERT INTO gst_data_tbl (user_pan_number, user_name, user_phone, user_email, user_father_name,  firm_name, firm_address, user_pan_url, aadhar_f_url, aadhar_b_url, user_photo_url, electricity_bill_url, rent_agreement_url, relative_noc_url, other_doc_url) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $params = [
            $pan_number,
            $name,
            $phone,
            $email,
            $father_name,
            $b_name,
            $b_address,
            $pan_front_file_url,
            $aadhar_front_file_url,
            $aadhar_back_file_url,
            $user_photo_file_url,
            $rent_agreement_file_url,
            $electricity_bill_file_url,
            $relative_noc_file_url,
            $other_doc_file_url,

        ];

        // Execute the insert
        if ($db->executeQueryData($sql, $params)) {
            echo "executed";
            $_SESSION['msg'] = "<center style='margin-bottom: 20px; color:green;'> <h1>Registration Successful!</h1></center>";
        } else {
            $_SESSION['msg'] = "<center style='margin-bottom: 20px; color:red;'> <h1>Error in Submission<p>" . mysqli_error($db->$DB_LINK_PDO) . "</p></h1></center>";
        }

        header("location:index.php");
        exit;
    }
}
