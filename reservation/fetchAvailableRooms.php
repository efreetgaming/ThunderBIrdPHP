<?php

include('connectionSql.php');

$startDate = '2024-05-11';
$endDate = '2024-05-12';

// Execute SQL to create temporary table and insert data
$sql = "
IF OBJECT_ID('AllRooms') IS NOT NULL
    DROP TABLE AllRooms;

CREATE TABLE AllRooms (
    RoomNo INT,
    RoomType NVARCHAR(100),
    CheckinDate DATE,
    CheckoutDate DATE,
    Status NVARCHAR(100)
);

-- Insert data from each room table into the temporary table
INSERT INTO AllRooms (RoomNo, RoomType, CheckinDate, CheckoutDate, Status)
SELECT Room_No, Room_Type, Checkin_date, Checkout_Date, Status FROM [101]
UNION ALL
SELECT Room_No, Room_Type, Checkin_date, Checkout_Date, Status FROM [202]
UNION ALL
SELECT Room_No, Room_Type, Checkin_date, Checkout_Date, Status FROM [203]
UNION ALL
SELECT Room_No, Room_Type, Checkin_date, Checkout_Date, Status FROM [204]
UNION ALL
SELECT Room_No, Room_Type, Checkin_date, Checkout_Date, Status FROM [205]
UNION ALL
SELECT Room_No, Room_Type, Checkin_date, Checkout_Date, Status FROM [301]
UNION ALL
SELECT Room_No, Room_Type, Checkin_date, Checkout_Date, Status FROM [302]
UNION ALL
SELECT Room_No, Room_Type, Checkin_date, Checkout_Date, Status FROM [303]
UNION ALL
SELECT Room_No, Room_Type, Checkin_date, Checkout_Date, Status FROM [304]
UNION ALL
SELECT Room_No, Room_Type, Checkin_date, Checkout_Date, Status FROM [305]
UNION ALL
SELECT Room_No, Room_Type, Checkin_date, Checkout_Date, Status FROM [401]
";

// Execute the SQL command
$stmt = sqlsrv_query($conn, $sql);

if ($stmt === false) {
    echo "Error executing SQL command: " . print_r(sqlsrv_errors(), true);
} else {
    // Execute SQL to select all records from the 'AllRooms' table
    $sql = "SELECT * FROM AllRooms";

    // Execute the SQL command
    $stmt = sqlsrv_query($conn, $sql);

    if ($stmt === false) {
        echo "Error executing SQL command: " . print_r(sqlsrv_errors(), true);
    } else {
        // Fetch all the records and store them in an array
        $results = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

        // Initialize an array to store the available rooms
        $availableRooms = array();

        // Loop through each room table in the database
        $roomTables = array("[101]", "[202]", "[203]", "[204]", "[205]", "[301]", "[302]", "[303]", "[304]", "[305]", "[401]", "[402]", "[403]", "[404]", "[405]", "[501]", "[502]", "[503]", "[504]", "[505]", "[511]", "[512]", "[513]", "[514]", "[515]");

        // Loop through each room table
        foreach ($roomTables as $roomTable) {
            // Create a query to check for conflicts in each room table
            $query = "SELECT COUNT(*) FROM $roomTable WHERE Status IN ('Reserved', 'Checked In') AND (Checkin_Date < '$endDate' AND Checkout_Date > '$startDate')";

            // Execute the query
            $result = sqlsrv_query($conn, $query);

            if ($result === false) {
                echo "Error executing SQL command: " . print_r(sqlsrv_errors(), true);
                return;
            }

            $conflictCount = sqlsrv_fetch_array($result, SQLSRV_FETCH_NUMERIC);

            if ($conflictCount[0] == 0) {
                // No conflicts found, add the room to the available rooms array
                $roomNumber = str_replace(array("[", "]"), "", $roomTable);
                $roomType = getRoomType($roomNumber);
                $roomRate = getRoomRate($roomNumber);

                $availableRooms[] = array("Room No" => $roomNumber, "Room Type" => $roomType, "Room Rate" => $roomRate);
            }
        }

        // Print the available rooms
        $availableRoomsJSON = json_encode($availableRooms);

        // Output the JSON data as a JavaScript variable
        echo "<script>console.log(" . $availableRoomsJSON . ");</script>";
    }
}

function getRoomType($roomNumber)
{
    switch (substr($roomNumber, 0, 2)) {
        case "10":
            return "Presidential Suite Room";
        case "20":
            return "Superior Suite Room";
        case "30":
            return "Premier Suite Room";
        case "40":
            return "Family Suite Room";
        case "50":
            return "Junior Suite Room";
        case "51":
            return "Junior Suite Room (BayView)";
        default:
            return "Unknown";
    }
}

function getRoomRate($roomNumber)
{
    switch (substr($roomNumber, 0, 2)) {
        case "10":
            return "4200";
        case "20":
            return "2500";
        case "30":
            return "3200";
        case "40":
            return "3700";
        case "50":
            return "2200";
        case "51":
            return "2700";
        default:
            return "Unknown";
    }
}

?>