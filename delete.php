<?php
require_once("pdo_connect.php"); // Change to your PDO connect file
require_once("db.config.inc.php"); // Include your database config file
session_start();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch record data before deletion
    $sql_query = "SELECT id, user_pan_number, user_name, user_phone, user_email, user_father_name, firm_name, firm_address, user_pan_url, aadhar_f_url, aadhar_b_url, user_photo_url, electricity_bill_url, rent_agreement_url, relative_noc_url, other_doc_url FROM gst_data_tbl WHERE id = ?";
    $stmt = $DB_LINK_PDO->prepare($sql_query);
    $stmt->execute([$id]);

    $record = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($record) {

        // Prepare the query for moving data to the trash table
        $trash_query = "INSERT INTO gst_trash_tbl (id, user_pan_number, user_name, user_phone, user_email, user_father_name, firm_name, firm_address, user_pan_url, aadhar_f_url, aadhar_b_url, user_photo_url, electricity_bill_url, rent_agreement_url, relative_noc_url, other_doc_url)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $DB_LINK_PDO->prepare($trash_query);

        if ($stmt) {
            // Bind the parameters for the INSERT query
            $stmt->execute([
                $record['id'],
                $record['user_pan_number'],
                $record['user_name'],
                $record['user_phone'],
                $record['user_email'],
                $record['user_father_name'],
                $record['firm_name'],
                $record['firm_address'],
                $record['user_pan_url'],
                $record['aadhar_f_url'],
                $record['aadhar_b_url'],
                $record['user_photo_url'],
                $record['electricity_bill_url'],
                $record['rent_agreement_url'],
                $record['relative_noc_url'],
                $record['other_doc_url']
            ]);

            // Delete record from itr_data_tbl
            $sql_delete = "DELETE FROM gst_data_tbl WHERE id = ?";
            $stmt_delete = $DB_LINK_PDO->prepare($sql_delete);
            if ($stmt_delete->execute([$id])) {
                $_SESSION['msg'] = "<center style='margin-top: 8px; color: green'><h5>Record deleted successfully.</h5></center>";
            } else {
                $_SESSION['msg'] = "<center style='margin-top: 8px; color: red'><h5>Error deleting record.</h5></center>";
            }
        } else {
            $_SESSION['msg'] = "<center style='margin-top: 8px; color: red'><h5>Failed to prepare trash insertion query.</h5></center>";
        }
    } else {
        $_SESSION['msg'] = "<center style='margin-top: 8px; color: red'><h5>Record not found.</h5></center>";
    }
}

header("location: listing.php");
exit;
