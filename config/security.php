<?php

// *** XSS ATTAC PROTECTION ***

function secure($data) {
    $data = trim($data);
    // $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>