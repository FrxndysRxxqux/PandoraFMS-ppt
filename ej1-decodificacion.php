<?php 
$hackedFile_Name = "file-user-info-hacked.csv";
$unhackedFile_Name = "file-user-info-unhacked.csv";
//we open the file 
$file = fopen($hackedFile_Name, "r");

//first step validate that the file is opened for start the script.
if(!$file){
    die("Can not open the file.");
}

while (($line = fgets($file)) !== false) {
    //removing blank spaces from each line
    $line=ltrim(rtrim($line));
    $UserInfo = explode(',',$line);

    //convert the array data into defined variables for better handling
    $userName = $UserInfo[0];
    $ns_digits = $UserInfo[1]; 
    $score= $UserInfo[2];
    $ns_digits_splited = str_split($ns_digits);
    
    $base_num = count($ns_digits_splited);

    $asociative_digits = [];
    //loop through digits array to create an associative array mapping values in $associative_digits[$digit]
    foreach ( $ns_digits_splited as $key => $digit){
        $asociative_digits[$digit] = $key; 
    }

    //invert array for power of the $base_num
    $array_score_inverted = array_reverse(str_split($score));

    $total_score = 0; //total score counter
    foreach ($array_score_inverted as $key_score_inverted => $score_inverted) {
        //look for the digit value in the associative array
        $digit_value = $asociative_digits[$score_inverted]; 
        //calculate the power of the base (base_num is the base number of the system)
        $power = pow($base_num, $key_score_inverted);
        //add the result of the actual position and do it resursive. (value * base_num^power)
        $total_score += $digit_value * $power;
        // echo "Digit: $score_inverted, Value: $digit_value, $base_num raised to the power of $key_score_inverted, Total : $total_score<br>";
    }
    
    file_put_contents($unhackedFile_Name, "$userName,$total_score\n", FILE_APPEND);
}

//close file
fclose($file);
die('Done, you can close this window');


?>