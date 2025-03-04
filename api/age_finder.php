<?php

function age($bday) {
    $dob = new DateTime($bday);
    $today = new DateTime();

    $age = $dob->diff($today)->y;
    return (string)$age;
}

?>