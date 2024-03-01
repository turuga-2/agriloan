<?php session_start();

// Check if there are validation errors in session
if (isset($_SESSION['validationErrors']) && !empty($_SESSION['validationErrors'])) {
    echo '<div class="error-messages">';
    echo '<h3>Error(s) occurred:</h3>';
    echo '<ul>';
    foreach ($_SESSION['validationErrors'] as $error) {
        echo '<li>' . htmlspecialchars($error) . '</li>';
    }
    echo '</ul>';
    echo '</div>';

    // Clear validation errors from session
    unset($_SESSION['validationErrors']);
}