<?php

    // Established a network to the database
    include("connectionSql.php");

    // Send emails to the customer
    require "vendor/autoload.php";

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;

    // Set the Values all to empty
    $fname = $email = $contact_email = $phone = $address = $city = $state = $country = $checkin_date = $checkout_date = $postcode = $room_type = $no_of_adult = $no_of_child = $reference_number = $arrival_time = $room_rate = $downpayment = $roomNo = "";

    // Set array that will saves the errors
    $errors = array('fname' => '', 'email' => '', 'contact_email' => '', 'phone' => '', 'address' => '', 'city' => '', 'state' => '', 'postcode' => '', 'country' => '', 'checkin_date' => '', 'checkout_date' => '', 'room_type' => '', 'no_of_adult' => '', 'no_of_child' => '', 'reference_number' => '', 'arrival_time' => '', 'room_rate'=>'', 'downpayment'=>'', 'roomNo'=>'');


    if (isset($_POST['submit'])) {
        // First Name
        if (empty($_POST['first_Name'])) {
            $errors['fname'] = "First Name should not be empty <br/>";
        } else {
            $fname = htmlspecialchars($_POST['first_Name']);
            if (!preg_match('/^[a-zA-Z\s]+$/', $fname)) {
                $errors['fname'] = "First Name should be letters and spaces only <br/>";
            };
        };

        // Last Name
        // if(empty($_POST['last_Name'])){
        //     $errors['lname'] = "Last Name should not be empty <br/>";
        // } else {
        //     $lname = htmlspecialchars($_POST['last_Name']);
        //     if (!preg_match('/^[a-zA-Z\s]+$/', $lname)) {
        //         $errors['lname'] = "Last Name should be letters and spaces only <br/>";
        //     }
        // };


        // Email
        if (empty($_POST['email'])) {
            $errors['email'] = "Email should not be empty <br/>";
        } else {
            $email = htmlspecialchars($_POST['email']);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Should be a valid email <br/>";
            };
        };

        // Contact Email
        if (empty($_POST['contact_email'])) {
            $errors['contact_email'] = "Email should not be empty <br/>";
        } else {
            $contact_email = htmlspecialchars($_POST['contact_email']);
            if (!filter_var($contact_email, FILTER_VALIDATE_EMAIL)) {
                $errors['contact_email'] = "Should be a valid email <br/>";
            };
        };

        // Phone
        if (empty($_POST['phone'])) {
            $errors['phone'] = "Phone should not be empty <br/>";
        } else {
            $phone = htmlspecialchars($_POST['phone']);
            if (!preg_match('/^[0-9]+$/', $phone)) {
                $errors['phone'] = "Phone should be numbers only <br/>";
            } else {
                if (strlen($phone) < 11) {
                    $errors['phone'] = "Phone should be 11 numbers only <br/>";
                } else if (strlen($phone) > 12) {
                    $errors['phone'] = "Phone should not be greater than 11 numbers <br/>";
                }
            }
        };

        // Address
        if (empty($_POST['address'])) {
            $errors['address'] = "Address should not be empty <br/>";
        } else {
            $address = htmlspecialchars($_POST['address']);
            if (!preg_match('/[^[a-zA-Z0-9.]*$/', $address)) {
                $errors['address'] = "Address should be letters and spaces only <br/>";
            }
        };

        // City 
        if (empty($_POST['city'])) {
            $errors['city'] = "City should not be empty <br/>";
        } else {
            $city = htmlspecialchars($_POST['city']);
            if (!preg_match('/^[a-zA-Z\s]+$/', $city)) {
                $errors['city'] = "City should be letters and spaces only <br/>";
            }
        };

        // State
        if (empty($_POST['state'])) {
            $errors['state'] = "State should not be empty <br/>";
        } else {
            $state = htmlspecialchars($_POST['state']);
            if (!preg_match('/^[a-zA-Z\s]+$/', $state)) {
                $errors['state'] = "State should be letters and spaces only <br/>";
            }
        };

        // Postcode
        if (empty($_POST['postcode'])) {
            $errors['postcode'] = "Numbers should not be empty <br/>";
        } else {
            $postcode = htmlspecialchars($_POST['postcode']);

            if (!preg_match('/^[0-9]+$/', $postcode)) {
                $errors['postcode'] = "Postcode should be numbers only <br/>";
            } else {
                if (strlen($postcode) < 4) {
                    $errors['postcode'] = "Postcode should be atleast 4-5 numbers only <br/>";
                } else if (strlen($postcode) > 5) {
                    $errors['postcode'] = "Phone should not be greater than 4-5 numbers <br/>";
                }
            }
        };

        // Country
        if (empty($_POST['country'])) {
            $errors['country'] = "Country should not be empty <br/>";
        } else {
            $country = htmlspecialchars($_POST['country']);
            if (!preg_match('/^[a-zA-Z\s]+$/', $country)) {
                $errors['country'] = "Country should be letters and spaces only <br/>";
            }
        };

        // Checkin
        if (empty($_POST['checkin_date'])) {
            $errors['checkin_date'] = "Checkin Date should not be empty <br/>";
        } else {
            $checkin_date = htmlspecialchars($_POST['checkin_date']);
        };

        // CheckOut
        if (empty($_POST['checkout_date'])) {
            $errors['checkout_date'] = "Checkout Date should not be empty <br/>";
        } else {
            $checkout_date = htmlspecialchars($_POST['checkout_date']);
        };

        // Room Type

        // Number of Adults
        if (empty($_POST['number_of_adults'])) {
            $errors['no_of_adult'] = "It should not be empty";
        } else {
            $no_of_adult = htmlspecialchars($_POST['number_of_adults']);
        };

        // Number of Children
        if (!isset($_POST['number_of_child']) || $_POST['number_of_child'] < 0) {
            $errors['no_of_child'] = "Child number must be a non-negative integer";
        } else {
            $no_of_child = htmlspecialchars($_POST['number_of_child']);
        }

        // Room Type

        if (empty($_POST['room_type'])) {
            $errors['room_type'] = "Select Your Room Type";
        } else if (isset($_POST['room_type'])) {
            $room_type = htmlspecialchars($_POST['room_type']);
        }

        // Room Rate
        if (empty($_POST['hidden_room_rate'])) {
            $errors['hidden_room_rate'] = "Select Your Room Type";
        } else if (isset($_POST['hidden_room_rate'])) {
            $room_rate = htmlspecialchars($_POST['hidden_room_rate']);
        }

        // Downpayment
        if (empty($_POST['hidden_downpayment'])) {
            $errors['hidden_downpayment'] = "It shouldnt be empty";
        } else if (isset($_POST['hidden_downpayment'])) {
            $downpayment = htmlspecialchars($_POST['hidden_downpayment']);
        }


        // Room no
        if (empty($_POST['room_no'])) {
            $errors['room_no'] = "It shouldnt be empty";
        } else if (isset($_POST['room_no'])) {
            $roomNo = htmlspecialchars($_POST['room_no']);
        }

        // Reference Number
        if (empty($_POST['reference_number'])) {
            $errors['reference_number'] = "Reference Number should not be empty <br/>";
        } else {
            $reference_number = htmlspecialchars($_POST['reference_number']);
            if (!preg_match('/^[0-9]+$/', $reference_number)) {
                $errors['reference_number'] = "Reference Number should be 13 numbers only <br/>";
            } else {
                if (strlen($reference_number) < 12) {
                    $errors['reference_number'] = "Reference Number should be 13 numbers only <br/>";
                } else if (strlen($reference_number) > 13) {
                    $errors['reference_number'] = "Reference Number should not be greater than 13 numbers <br/>";
                }
            }
        };
        // Arrival Time
        if (empty($_POST['arrival_time'])) {
            $errors['arrival_time'] = "arrivel_time should not be empty <br/>";
        } else {
            $arrival_time = htmlspecialchars($_POST['arrival_time']);
        };


        if (array_filter($errors)) {
            // Errors will be show in the array
        } else {
            $tableName = $roomNo;
            $query = "SELECT * FROM [$tableName] WHERE Room_No =? AND (Checkin_Date BETWEEN? AND? OR Checkout_Date BETWEEN? AND?)";
            $params = array($roomNo, $checkin_date, $checkout_date, $checkin_date, $checkout_date, $checkin_date);
            $stmt = sqlsrv_prepare($conn, $query, $params);
            sqlsrv_execute($stmt);

            if (sqlsrv_has_rows($stmt)) {
                // Room number and date range already exist, display error
                $errors['checkin_date'] = "Date range already booked.";
                $errors['checkout_date'] = "Date range already booked.";
            } else {
                // Inserting the data to the Database
            $insert = "INSERT INTO tbl_reservation (First_Name, Email, Contact_Email, Phone, Address, City, State, Post_Code, Country, Checkin_Date, Checkout_Date, Room_Type, No_Of_Adult, No_Of_Children, Reference_Number, Arrival_Time, Downpayment, Room_Rate, Room_No) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

            $param = array(&$fname, &$email, &$contact_email, &$phone, &$address, &$city, &$state, &$postcode, &$country, &$checkin_date, &$checkout_date, &$room_type, &$no_of_adult, &$no_of_child, &$reference_number, &$arrival_time, &$downpayment, &$room_rate, &$roomNo);
            $inserStmt = sqlsrv_prepare($conn, $insert, $param);
            sqlsrv_execute($inserStmt);
            sqlsrv_free_stmt($inserStmt);
            // Sales reports query
            $status = "Reserved";
            $date = date("Y-m-d"); // changed from "Y-M-d" to "Y-m-d" (month should be in lowercase)
            $time = date("H:i:s", mktime(12, 0, 0)); // convert mktime result to a string in "H:i:s" format

            $insertReport = "INSERT INTO tbl_reports (Name, Checked_In, Checked_Out, Status, Date, Arrival_Time, Total_Price) VALUES (?,?,?,?,?,?,?)";
            $paramReport = array($fname, $checkin_date, $checkout_date, $status, $date, $time, $downpayment);

            $repstmt = sqlsrv_prepare($conn, $insertReport, $paramReport);
            sqlsrv_execute($repstmt);
            sqlsrv_free_stmt($repstmt);

            // Add Reservation to the specific room
            $tableName = $roomNo;
            $insertRoomNo = "INSERT INTO [$tableName] (Room_No, Room_Type, Checkin_Date, Checkout_Date, Guest_Name, Status) VALUES (?,?,?,?,?,?)";
            $paramRoomNo = array($roomNo, $room_type, $checkin_date, $checkout_date, $fname, $status);
            $roomNoStmt = sqlsrv_prepare($conn, $insertRoomNo, $paramRoomNo);
            sqlsrv_execute($roomNoStmt);
            sqlsrv_free_stmt($roomNoStmt);

            // Close connection

            sqlsrv_close($conn);

            // Sending email to the customer
            $mail = new PHPMailer(true);

            $mail->isSMTP();
            $mail->SMTPAuth = true;
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;

            $mail->Username = "valiaresllagas@gmail.com";
            $mail->Password = "gjssygfteautvudj";

            $mail->setFrom("valiaresllagas@gmail.com", "Thunderbird Hotel and Resort");
            $mail->addAddress($email, "Thunderbird");

            $mail->isHTML(true);

            $mail->Subject = "Thank you for Choosing Thunderbird Hotel & Resort";
            $mail->Body = "<p>We are thrilled to confirm your reservation at Thunderbird: Hotel & Resort. Your booking has been successfully processed, and we're excited to welcome you to our hotel.<br><br>We would like to express our gratitude for choosing to stay with us. Your reservation was conveniently made online, and we've received your 10% downpayment. Thank you for your prompt payment, which has secured your booking.<br><br>We wanted to inform you of an important policy regarding reservation arrivals. Please note that if you are unable to check in by 12:00 AM (midnight) on the date of your reservation, your booking will be considered canceled, and the room may be released to other guests.<br><br>This policy ensures that we can efficiently manage our room inventory and accommodate all our guests effectively. We kindly ask for your cooperation and understanding in adhering to this deadline.</p>";

            $mail->send();

            header('Location: ../index.html');
            echo "Successfully Added";
            }
        };
    };
?>


<!DOCTYPE html>
<html lang="en">>
<?php include('templates/header.php'); ?>
<!-- STEP 2 -->
<section id="contact" class="container my-3">
    <div class="container-lg my-7">
        <h2>Thunderbird Resort and Casino</h2>
        <p class="lead">Fill up with your Information</p>
        <div class="container row align-items-start">
            <!-- Form will be place -->
            <div class="col">
                <div class="guest-details mb-4">
                    <div class="accordion" id="accordionDetails">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                    Your Details
                                </button>
                            </h2>
                            <div id="flush-collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionPayment">
                                <form method="post" action="add.php">
                                    <div class="row m-3">
                                        <div class="col">
                                            <!-- The label for the checkout date field -->
                                            <label for="checkout_date" class="form-label">CheckIn Date</label>
                                            <!-- The checkout date input field -->
                                            <input type="date" class="form-control" id="startDate" name="checkin_date" value="" required>
                                            <div class="text-danger"><?php echo $errors['checkin_date'] ?></div>
                                        </div>


                                        <!-- The checkout date field -->
                                        <div class="col">
                                            <!-- The label for the checkout date field -->
                                            <label for="checkout_date" class="form-label">Checkout Date</label>
                                            <!-- The checkout date input field -->
                                            <input type="date" class="form-control" id="endDate" name="checkout_date" value="" required>
                                            <div class="text-danger"><?php echo $errors['checkout_date'] ?></div>
                                        </div>

                                        <!-- <div class="col">
                                            <label for="numbers" class="form-label">Multiplier</label>
                                            <input type="number" class="form-control" id="numbers" name="numbers" value="">
                                        </div> -->

                                        <!-- <p id="result"></p> -->
                                    </div>


                                    <div class="row m-3">
                                        <div class="col">
                                            <label for="room_type" class="form-label">Room Type</label>
                                            <select class="form-select selections" name="room_type" id="roomType" required>
                                                <!-- This is where the option takes places -->
                                                
                                                <div class="text-danger"> <?php echo $errors['room_type']; ?> </div>
                                            </select>
                                        </div>

                                        <div class="col">
                                            <label for="room_rate" class="form-label">Room Rate</label>
                                            <input type="number" name="roomRate" class="form-control" id="rate"  value="" disabled>
                                            <input type="hidden" name="hidden_room_rate" id="hidden_rate" value="">
                                            
                                        </div>

                                        <div class="col">
                                            <label for="room_no" class="form-label">Room No.</label>
                                            <input type="text" name="roomNo" class="form-control" id="room_no"  value="">
                                        </div>

                                        <div class="col">
                                            <label class="form-label" for="number_of_adults">Number of Adults</label>
                                            <input type="number" name="number_of_adults" id="number_of_adults" min="1" max="4" class="form-control">
                                            <div class="text-danger"> <?php echo $errors['no_of_adult']; ?> </div>
                                        </div>

                                        <div class="col">
                                            <label class="form-label" for="number_of_child">Number of Children</label>
                                            <input type="number" name="number_of_child" id="number_of_child" class="form-control">
                                            <div class="text-danger"> <?php echo $errors['no_of_child']; ?> </div>
                                        </div>
                                    </div>

                                    <!-- A row with two columns, for the first and last name fields -->
                                    <div class="row m-3">
                                        <!-- The first name field -->
                                        <div class="col">
                                            <!-- The label for the first name field -->
                                            <label for="first_Name" class="form-label">First Name</label>
                                            <!-- The first name input field -->
                                            <input type="text" class="form-control" id="first_Name" name="first_Name" value="<?php echo $fname; ?>" maxlength="24" required>
                                            <div class="text-danger"><?php echo $errors['fname'] ?></div>
                                        </div>
                                        <!-- The last name field -->
                                        <!-- This is where it placed -->
                                    </div>
                                    <!-- A row with two columns, for the email and contact email fields -->
                                    <div class="row m-3">
                                        <!-- The email field -->
                                        <div class="col">
                                            <!-- The label for the email field -->
                                            <label for="email" class="form-label">Email</label>
                                            <!-- The email input field -->
                                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" required>
                                            <div class="text-danger"><?php echo $errors['email'] ?></div>
                                        </div>
                                        <!-- The contact email field -->
                                        <div class="col">
                                            <!-- The label for the contact email field -->
                                            <label for="contact_email" class="form-label">Contact Email</label>
                                            <!-- The contact email input field -->
                                            <input type="email" class="form-control" id="contact_email" name="contact_email" value="<?php echo $contact_email; ?>" required>
                                            <div class="text-danger"><?php echo $errors['contact_email'] ?></div>
                                        </div>
                                    </div>

                                    <!-- A row with two columns, for the address and additional address fields -->
                                    <div class="row m-3">
                                        <!-- The address field -->
                                        <div class="col">
                                            <!-- The label for the address field -->
                                            <label for="address" class="form-label">Address</label>
                                            <!-- The address input field -->
                                            <input type="text" class="form-control" id="address" name="address" value="<?php echo $address; ?>" required>
                                            <div class="text-danger"><?php echo $errors['address'] ?></div>
                                        </div>
                                        <!-- The Phone field -->
                                        <div class="col">
                                            <!-- The label for the email field -->
                                            <label for="email" class="form-label">Phone</label>
                                            <!-- The email input field -->
                                            <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $phone; ?>" required>
                                            <div class="text-danger"><?php echo $errors['phone'] ?></div>
                                        </div>
                                    </div>
                                    <!-- A row with two columns, for the city and state fields -->
                                    <div class="row m-3">
                                        <!-- The city field -->
                                        <div class="col">
                                            <!-- The label for the city field -->
                                            <label for="city" class="form-label">City</label>
                                            <!-- The city input field -->
                                            <input type="text" class="form-control" id="city" name="city" value="<?php echo $city; ?>" maxlength="24" required>
                                            <div class="text-danger"><?php echo $errors['city'] ?></div>
                                        </div>
                                        <!-- The state field -->
                                        <div class="col">
                                            <!-- The label for the state field -->
                                            <label for="state" class="form-label">State</label>
                                            <!-- The state input field -->
                                            <input type="text" class="form-control" id="state" name="state" value="<?php echo $state; ?>" maxlength="24" required>
                                            <div class="text-danger"><?php echo $errors['state'] ?></div>
                                        </div>
                                    </div>
                                    <!-- A row with two columns, for the country and postcode fields -->
                                    <div class="row m-3">
                                        <!-- The country field -->
                                        <div class="col">
                                            <!-- The label for the country field -->
                                            <label for="country" class="form-label">Country</label>
                                            <select class="form-select" aria-label="Default select example" name="country" id="country" required>
                                                <!-- This is where the option takes places -->
                                                <option value="Philippines">Philippines</option>
                                            </select>
                                            <div class="text-danger"><?php echo $errors['country'] ?></div>
                                        </div>
                                        <!-- The postcode field -->
                                        <div class="col">
                                            <!-- The label for the postcode field -->
                                            <label for="postcode" class="form-label">Postcode</label>
                                            <!-- The postcode input field -->
                                            <input type="text" class="form-control" id="postcode" name="postcode" value="<?php echo $postcode; ?>" required>
                                            <div class="text-danger"><?php echo $errors['postcode'] ?></div>
                                        </div>
                                    </div>
                                    <!-- A row with one column, for the checkout date field -->

                                    <div class="row m-3">
                                        <div class="col">
                                            <img src="assets/img/QRCODE.jpg" alt="Fuck this">
                                        </div>

                                        <div class="col">
                                            <label for="reference_number" class="form-label">Reference Number (Gcash)</label>
                                            <input type="text" class="form-control" id="reference_number" name="reference_number" value="<?php echo $reference_number; ?>" required>
                                            <div class="text-danger"><?php echo $errors['reference_number'] ?></div>
                                        </div>

                                        <div class="col">
                                            <label for="downpayment" class="form-label">Downpayment</label>
                                            <input type="text" name="downpayment" class="form-control" id="Downpayment"  value="" disabled>
                                            <input type="hidden" name="hidden_downpayment" id="hidden_downpayment" value="">
                                        </div>

                                        <div class="col">
                                            <!-- The label for the country field -->
                                            <label for="arrival_time" class="form-label">Planned Arrival Time</label>
                                            <select class="form-select" aria-label="Default" name="arrival_time" id="arrival_time">
                                                <!-- This is where the option takes places -->
                                                <option value="2:00PM">2:00 PM (14:00)</option>
                                                <option value="3:00PM">3:00 PM (15:00)</option>
                                                <option value="4:00PM">4:00 PM (16:00)</option>
                                                <option value="5:00PM">5:00 PM (17:00)</option>
                                                <option value="6:00PM">6:00 PM (18:00)</option>
                                                <option value="7:00PM">7:00 PM (19:00)</option>
                                                <option value="8:00PM">8:00 PM (20:00)</option>
                                                <option value="9:00PM">9:00 PM (21:00)</option>
                                                <option value="10:00PM">10:00 PM (22:00)</option>
                                                <option value="11:00PM">11:00 PM (23:00)</option>
                                            </select>
                                            <div class="text-danger"><?php echo $errors['arrival_time'] ?></div>
                                        </div>
                                    </div>
                                    <!-- The form submit button -->

                                    <div class="row m-3">
                                        <div class="col">
                                            <button type="submit" class="btn btn-primary" id="submitButton" name="submit">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-qFOQ9YFAeGj1gDOuUD61g3D+tLDv3u1ECYWqT82WQoaWrOhAY+5mRMTTVsQdWutbA5FORCnkEPEgU0OF8IzGvA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
// ==============================================================================================================

document.getElementById("startDate").addEventListener("DOMContentLoaded", function () {
            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0'); // January is 0!
            var yyyy = today.getFullYear();
            today = yyyy + '-' + mm + '-' + dd;

            // Set the min attribute of the input date tag to today's date
            document.getElementById("startDate").setAttribute("min", today);
        });

        document.getElementById("roomForm").addEventListener("submit", function (event) {
            event.preventDefault();

            var startDate = document.getElementById("startDate").value;
            var endDate = document.getElementById("endDate").value;
            var roomType = document.getElementById("roomType").value;

            var xhr = new XMLHttpRequest();
            xhr.open("GET", "check_availability.php?startDate=" + startDate + "&endDate=" + endDate + "&roomType=" + roomType + "&_=" + new Date().getTime(), true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    var result = JSON.parse(xhr.responseText);

                    // Populate the room type select tag
                    const roomTypes = [...new Set(result.map(room => room["Room Type"]))];
                    const roomTypeSelect = document.getElementById("roomType");
                    roomTypeSelect.innerHTML = "";
                    roomTypes.forEach(roomType => {
                        const option = document.createElement("option");
                        option.value = roomType;
                        option.textContent = roomType;
                        roomTypeSelect.appendChild(option);
                    });

                    // Populate the room number select tag based on the selected room type
                    updateRoomNumberSelect(result, roomType);
                }
            };
            xhr.send();
        });

        // Add an event listener to the room type select tag to update the room number select tag
        document.getElementById("roomType").addEventListener("change", function () {
            var roomType = this.value;
            var startDate = document.getElementById("startDate").value;
            var endDate = document.getElementById("endDate").value;

            var xhr = new XMLHttpRequest();
            xhr.open("GET", "check_availability.php?startDate=" + startDate + "&endDate=" + endDate + "&roomType=" + roomType + "&_=" + new Date().getTime(), true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    var result = JSON.parse(xhr.responseText);

                    // Populate the room number select tag based on the selected room type
                    updateRoomNumberSelect(result, roomType);
                }
            };
            xhr.send();
        });

        // Add an event listener to the room number select tag to display the selected room number
        document.getElementById("roomNo").addEventListener("change", function () {
            const selectedRoomNumber = document.getElementById("selectedRoomNumber");
            if (this.value) {
                selectedRoomNumber.textContent = "Selected room: " + this.value;
            } else {
                selectedRoomNumber.textContent = "";
            }
        });

        function updateRoomNumberSelect(rooms, selectedRoomType) {
            const filteredRooms = rooms.filter(room => room["Room Type"] === selectedRoomType);
            const roomNumberSelect = document.getElementById("roomNo");
            const roomRateInput = document.getElementById("roomRate");

            // Clear the room number select tag and room rate input field
            roomNumberSelect.innerHTML = "";
            roomRateInput.value = "";

            // Populate the room number select tag with filtered rooms
            filteredRooms.forEach(room => {
                const option = document.createElement("option");
                option.value = room["Room No"];
                option.textContent = room["Room No"];
                roomNumberSelect.appendChild(option);
            });

            // Display the selected room number if one is selected
            const selectedRoomNumber = document.getElementById("selectedRoomNumber");
            if (roomNumberSelect.value) {
                selectedRoomNumber.textContent = "Selected room: " + roomNumberSelect.value;
            } else {
                selectedRoomNumber.textContent = "";
            }

            // Add change event listener to the room number select tag
            roomNumberSelect.addEventListener("change", function () {
                const selectedRoom = filteredRooms.find(room => room["Room No"] === roomNumberSelect.value);
                if (selectedRoom) {
                    roomRateInput.value = selectedRoom["Room Rate"];
                } else {
                    roomRateInput.value = "";
                }
            });
        }

        document.getElementById("startDate").addEventListener("change", function () {
            resetRoomSelection();
        });

        document.getElementById("endDate").addEventListener("change", function () {
            resetRoomSelection();
        });

        function resetRoomSelection() {
            document.getElementById("roomType").selectedIndex = 0;
            document.getElementById("roomNo").selectedIndex = 0;
            document.getElementById("roomType").innerHTML = "";
            document.getElementById("roomNo").innerHTML = "";
            docum

// ==============================================================================================================
    


    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById('number_of_adults').value = 0;
        document.getElementById('number_of_child').value = 0;
    });

    document.getElementById('number_of_child').addEventListener('input', function() {
        var childrenValue = parseInt(this.value);
        // Ensure value is within the range of 0 to 4
        if (childrenValue < 0 || childrenValue > 4) {
            this.value = Math.min(Math.max(childrenValue, 0), 4);
            childrenValue = parseInt(this.value);
        }
        var adultsMax = 4 - childrenValue;
        var adultsInput = document.getElementById('number_of_adults');
        adultsInput.max = adultsMax;
        adultsInput.min = 0;
        adultsInput.value = Math.max(adultsInput.value, 0); // Ensure value is non-negative
    });

    document.getElementById('number_of_adults').addEventListener('input', function() {
        var adultsValue = parseInt(this.value);
        // Ensure value is within the range of 0 to 4
        if (adultsValue < 0 || adultsValue > 4) {
            this.value = Math.min(Math.max(adultsValue, 0), 4);
            adultsValue = parseInt(this.value);
        }
        var childrenMax = 4 - adultsValue;
        var childrenInput = document.getElementById('number_of_child');
        childrenInput.max = childrenMax;
        childrenInput.min = 0;
        childrenInput.value = Math.max(childrenInput.value, 0); // Ensure value is non-negative
    });

    // const checkinDateInput = document.getElementById('checkin_date');
    // const checkoutDateInput = document.getElementById('checkout_date');

    // // Set the minimum date to today's date for both check-in and check-out
    // const today = new Date();
    // const minDate = new Date(today.getFullYear(), today.getMonth(), today.getDate());
    // checkinDateInput.min = minDate.toLocaleDateString('en-CA');
    // checkoutDateInput.min = minDate.toLocaleDateString('en-CA');

    // =======================================================================================================================================
    
    // const checkinDateInput = document.getElementById('checkin_date');
    // const checkoutDateInput = document.getElementById('checkout_date');
    // const rateInput = document.getElementById('rate');
    // const downpaymentInput = document.getElementById('Downpayment');
    // const hiddenDownpaymentInput = document.getElementById('hidden_downpayment');

    // // Set the minimum date for check-in to today's date
    // const today = new Date();
    // const minDate = new Date(today.getFullYear(), today.getMonth(), today.getDate());
    // checkinDateInput.min = minDate.toLocaleDateString('en-CA');

    // // Set the minimum date for check-out to be one day after check-in
    // checkinDateInput.addEventListener('input', function() {
    //     const checkinDate = new Date(checkinDateInput.value);
    //     const minCheckoutDate = new Date(checkinDate.getFullYear(), checkinDate.getMonth(), checkinDate.getDate() + 1);
    //     checkoutDateInput.min = minCheckoutDate.toLocaleDateString('en-CA');
    //     // Ensure check-out date is after check-in date
    //     if (new Date(checkoutDateInput.value) < minCheckoutDate) {
    //         checkoutDateInput.value = ''; // Clear invalid check-out date
    //     }
    //     calculateDifference();
    // });

    // // Disable past dates for check-out
    // checkoutDateInput.addEventListener('input', function() {
    //     const checkoutDate = new Date(checkoutDateInput.value);
    //     if (checkoutDate < today) {
    //         checkoutDateInput.value = ''; // Clear past check-out date
    //     }
    //     calculateDifference();
    // });

    // =======================================================================================================================================

    const checkinDateInput = document.getElementById('checkin_date');
    const checkoutDateInput = document.getElementById('checkout_date');
    const rateInput = document.getElementById('rate');
    const downpaymentInput = document.getElementById('Downpayment');
    const hiddenDownpaymentInput = document.getElementById('hidden_downpayment');

// Set the minimum date for check-in to today's date
const today = new Date();
const minDate = new Date(today.getFullYear(), today.getMonth(), today.getDate());
checkinDateInput.min = minDate.toLocaleDateString('en-CA');

// Set the minimum date for check-out to be one day after check-in
checkinDateInput.addEventListener('input', function() {
    const checkinDate = new Date(checkinDateInput.value);
    const minCheckoutDate = new Date(checkinDate.getFullYear(), checkinDate.getMonth(), checkinDate.getDate() + 1);
    checkoutDateInput.min = minCheckoutDate.toLocaleDateString('en-CA');
    // Ensure check-out date is after check-in date
    if (new Date(checkoutDateInput.value) < minCheckoutDate) {
        checkoutDateInput.value = ''; // Clear invalid check-out date
    }
    calculateDifference()
});

// Disable past dates for check-out
checkoutDateInput.addEventListener('input', function() {
    const checkoutDate = new Date(checkoutDateInput.value);
    if (checkoutDate < today) {
        checkoutDateInput.value = ''; // Clear past check-out date
    }
    calculateDifference()
});



    // Set initial minimum date for check-out
    const initialMinCheckoutDate = new Date(today.getFullYear(), today.getMonth(), today.getDate() + 1);
    checkoutDateInput.min = initialMinCheckoutDate.toLocaleDateString('en-CA');

    function calculateDifference() {
        var rate = rateInput.value;
        var date1 = new Date(checkinDateInput.value).getTime();
        var date2 = new Date(checkoutDateInput.value).getTime();
        var difference = date2 - date1;
        var days = Math.abs(difference / 86400000); // convert milliseconds to days
        var result = (days * rate) * 0.1; // multiply by10%
        downpaymentInput.value = result; // set the value of the downpayment input field
        hiddenDownpaymentInput.value = result;
    }

    // Check gmail is the same
    const emailInput = document.getElementById('email');
    const contactEmailInput = document.getElementById('contact_email');

    contactEmailInput.addEventListener('blur', checkEmails);

    function checkEmails() {
        const emailValue = emailInput.value.trim();
        const contactEmailValue = contactEmailInput.value.trim();

        if (emailValue!== contactEmailValue) {
        console.log('Emails are different');
        }else{
            console.log('Emails are same');
        }
    }
</script>
<!-- END OF STEP 2 -->

<?php include('templates/footer.php'); ?>
</html>