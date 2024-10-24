 <?php

    include 'form.php';
    ?>

 <!DOCTYPE html>
 <html lang="en">

 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>GST Registration</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
 </head>

 <body>
     <?php
        include("navbar.php");
        ?>
     <p>
         <?php
            if (isset($_SESSION['msg'])) {
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
            }
            ?>
     </p>

     <center style="margin-top: 10px">
         <h2><u>GST Registration</u></h2>
     </center>
     <div class="container mt-4 w-50 mb-3 col-md-6">
         <div class="row">
             <form class="border border-success mx-auto p-3" action="form.php" method="post" enctype="multipart/form-data">
                 <!-- Full Width Inputs -->
                 <div class="row">
                     <div class="mb-3 mt-2 col-md-6">
                         <label for="pannumber" class="form-label">PAN NUMBER<span style="color:red">*</span></label>
                         <input type="text" name="pan_number" class="form-control" id="example_pan" required>
                     </div>

                     <div class="mb-3 mt-2 col-md-6">
                         <label for="name" class="form-label">Name<span style="color:red">*</span></label>
                         <input type="text" name="name" class="form-control" id="example_name" required>
                     </div>
                 </div>

                 <div class="row">
                     <div class="mb-3 mt-2 col-md-6">
                         <label for="phonenumber" class="form-label">Phone<span style="color:red">*</span></label>
                         <input type="number" name="phone_number" class="form-control" id="example_phone" required>
                     </div>

                     <div class="mb-3 mt-2 col-md-6">
                         <label for="email" class="form-label">Email<span style="color:red">*</span></label>
                         <input type="email" name="email" class="form-control" id="example_email" required>
                     </div>
                 </div>

                 <div class="row">
                     <div class="mb-3 col-md-6">
                         <label for="father_name" class="form-label">Father's Name<span style="color:red">*</span></label>
                         <input type="text" name="father_name" class="form-control" id="example_fathername" required>
                     </div>
                     <div class="mb-3 col-md-6">
                         <label for="b_name" class="form-label">FIRM/BUSINESS Name<span style="color:red">*</span></label>
                         <input type="text" name="b_name" class="form-control" id="example_bname" required>
                     </div>
                 </div>

                 <!-- Continue with full width inputs -->


                 <label for="b_address" class="form-label mt-2">Business Address</label>
                 <div class="form-floating mt-2 mb-2">
                     <textarea class="form-control" name="b_address" id="b_add"></textarea>
                     <label for="floatingTextarea">House No., Street/Colony, City, State</label>
                 </div>

                 <label for="validationCustom03" class="form-label">Upload Pan Front<span style="color:red">*</span></label>
                 <div class="input-group">
                     <input type="file" name="pan_front_upload_file" class="form-control mb-3" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" aria-label="Upload" required>
                 </div>

                 <!-- Side by Side File Uploads -->
                 <div class="row g-3 mb-3">
                     <div class="col-md-6">
                         <label for="validationCustom03" class="form-label">Upload Aadhar Front<span style="color:red">*</span></label>
                         <div class="input-group">
                             <input type="file" name="aadhar_front_upload_file" class="form-control" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" aria-label="Upload" required>
                         </div>
                     </div>
                     <div class="col-md-6">
                         <label for="validationCustom03" class="form-label">Upload Aadhar Back<span style="color:red">*</span></label>
                         <div class="input-group">
                             <input type="file" name="aadhar_back_upload_file" class="form-control" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" aria-label="Upload" required>
                         </div>
                     </div>
                 </div>






                 <div class="row g-3 mb-3">
                     <div class="col-md-6">
                         <label for="validationCustom03" class="form-label">Passport Size Photo<span style="color:red">*</span></label>
                         <div class="input-group">
                             <input type="file" name="user_photo_upload_file" class="form-control" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" aria-label="Upload" required>
                         </div>
                     </div>
                     <div class="col-md-6">
                         <label for="validationCustom03" class="form-label">Electricity Bill<span style="color:red">*</span></label>
                         <div class="input-group">
                             <input type="file" name="electricity_bill_upload_file" class="form-control" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" aria-label="Upload" required>
                         </div>
                     </div>
                 </div>

                 <div class="row g-3 mb-3">
                     <div class="col-md-6">
                         <label for="validationCustom03" class="form-label">Rent Agreement<span style="color:red">*</span></label>
                         <div class="input-group">
                             <input type="file" name="rent_agreement_upload_file" class="form-control" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" aria-label="Upload" required>
                         </div>
                     </div>
                     <div class="col-md-6">
                         <label for="validationCustom03" class="form-label">Attach Relative NOC<span style="color:red">*</span></label>
                         <div class="input-group">
                             <input type="file" name="relative_noc_upload_file" class="form-control" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" aria-label="Upload" required>
                         </div>
                     </div>
                 </div>


                 <div class="col-md-12 mb-3">
                     <label for="validationCustom03" class="form-label">Other Doc<span style="color:red">*</span></label>
                     <div class="input-group">
                         <input type="file" name="other_doc_upload_file" class="form-control" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" aria-label="Upload">
                     </div>
                 </div>




                 <div class="d-flex justify-content-center">
                     <button type="submit" name="submit" class="btn btn-outline-primary">Pay Now</button>
                 </div>
             </form>
         </div>
     </div>

 </body>

 </html>