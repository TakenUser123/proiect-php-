<?php
//session_start();

    function check_login($con){
        if (isset($_SESSION['id'])) {
            $id = $_SESSION['id'];
            $query = "SELECT * FROM users WHERE id ='$id' LIMIT 1";
            $result = mysqli_query($con, $query);
            if ($result && mysqli_num_rows($result) > 0) {
                $user_data = mysqli_fetch_assoc($result);
                return $user_data;
            }
        }
        return false;
    }

    function exportToCSV($filename, $data) {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '.csv"');
    
        $output = fopen('php://output', 'w');

        foreach ($data as $row) {
            fputcsv($output, $row);
        }

        fclose($output);
    }


    function verifyRecaptcha($secretKey, $response) {
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = array(
            'secret' => $secretKey,
            'response' => $response
        );

        $options = array(
            'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data)
            )
        );

        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        $json = json_decode($result);

        if ($json->success) {
            return true;
        } else {
            return false;
        }
    }

?>