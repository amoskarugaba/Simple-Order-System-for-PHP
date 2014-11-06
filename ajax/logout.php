<?php
session_start();
session_unset();
session_destroy();
echo '<p>You are now logged out.</p>';
