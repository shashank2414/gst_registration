<?php
require_once("pdo_connect.php"); // Change to your PDO connect file
require_once("db.config.inc.php"); // Include your database config file

if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $maxFileSize = 200 * 1024;
    $allowedFileExtension = ["jpg", "jpeg", "png", "webp", "pdf"];

    // Function to check if a file is uploaded and valid
    function isFileUploaded($fileKey)
    {
        return isset($_FILES[$fileKey]) && $_FILES[$fileKey]['error'] == 0;
    }

    // Function to retrieve file details
    function getFileDetail($fileKey, $detail)
    {
        return $_FILES[$fileKey][$detail] ?? '';
    }

    // Prepare statements for file updates
    $queries = [
        'pan' => [
            'file_key' => 'new_pan_front_upload_file',
            'db_columns' => ['user_pan_url'],
            'upload_dir' => 'upload/pan',
        ],
        'aadhar_front' => [
            'file_key' => 'new_aadhar_front_upload_file',
            'db_columns' => ['aadhar_f_url'],
            'upload_dir' => 'upload/aadhar',
        ],
        'aadhar_back' => [
            'file_key' => 'new_aadhar_back_upload_file',
            'db_columns' => ['aadhar_b_url'],
            'upload_dir' => 'upload/aadhar',
        ],
        'user_photo' => [
            'file_key' => 'new_user_photo_upload_file',
            'db_columns' => ['user_photo_url'],
            'upload_dir' => 'upload/photo',
        ],
        'electricity_bill' => [
            'file_key' => 'new_electricity_bill_upload_file',
            'db_columns' => ['electricity_bill_url'],
            'upload_dir' => 'upload/electricity_bill',
        ],
        'rent_agreement' => [
            'file_key' => 'new_rent_agreement_upload_file',
            'db_columns' => ['rent_agreement_url'],
            'upload_dir' => 'upload/rent_agreement',
        ],
        'relative_noc_url' => [
            'file_key' => 'new_relative_noc_upload_file',
            'db_columns' => ['relative_noc_url'],
            'upload_dir' => 'upload/relative_noc',
        ],
        'other_doc' => [
            'file_key' => 'new_other_doc_upload_file',
            'db_columns' => ['other_doc_url'],
            'upload_dir' => 'upload/other_doc',
        ],
    ];

    $sub_queries = [];

    foreach ($queries as $key => $query) {
        if (isFileUploaded($query['file_key'])) {
            $file_tmp = getFileDetail($query['file_key'], 'tmp_name');
            if ($file_tmp != '') {
                $file_ext = pathinfo(getFileDetail($query['file_key'], 'name'), PATHINFO_EXTENSION);
                $new_file_name = time() . rand(10, 99) . '.' . $file_ext;

                // Retrieve existing file details from the database
                $stmt = $DB_LINK_PDO->prepare("SELECT {$query['db_columns'][0]} FROM gst_data_tbl WHERE id = ?");
                $stmt->execute([$id]);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($result) {
                    $old_file_path = $result[$query['db_columns'][0]];

                    // Remove old file if it exists
                    if (!empty($old_file_path) && file_exists($old_file_path)) {
                        unlink($old_file_path);
                    }

                    // Move new file to the appropriate directory
                    move_uploaded_file($file_tmp, "{$query['upload_dir']}/{$new_file_name}");

                    // Add the update query for the file path and file name
                    $sub_queries[] = "{$query['db_columns'][0]} = '{$query['upload_dir']}/{$new_file_name}'";
                }
            }
        }
    }

    $pan_number = $_POST['pan_number'];
    $name = $_POST['name'];
    $phone = $_POST['phone_number'];
    $email = $_POST['email'];
    $father_name = $_POST['father_name'];
    $firm_name = $_POST['b_name'];
    $firm_address = $_POST['b_address'];

    // Prepare the update statement
    $sql = "UPDATE gst_data_tbl SET 
        user_pan_number = :pan_number, 
        user_name = :name, 
        user_phone = :phone, 
        user_email = :email, 
        user_father_name = :father_name, 
        firm_name = :firm_name, 
        firm_address = :firm_address" .
        (count($sub_queries) > 0 ? ', ' . implode(', ', $sub_queries) : '') .
        " WHERE id = :id";

    $stmt = $DB_LINK_PDO->prepare($sql);
    $stmt->execute([
        ':pan_number' => $pan_number,
        ':name' => $name,
        ':phone' => $phone,
        ':email' => $email,
        ':father_name' => $father_name,
        ':firm_name' => $firm_name,
        ':firm_address' => $firm_address,
        ':id' => $id,
    ]);

    if ($stmt->rowCount()) {
        $_SESSION['msg'] = "<center style='margin-top: 8px; color: green'><h5>Record Updated Successfully</h5></center>";
    } else {
        $_SESSION['msg'] = "<center style='margin-top: 8px; color: red'><h5>Error updating record.</h5></center>";
    }

    header("location: listing.php");
    exit();
} else {
    echo "Invalid request.";
}
