<?php
session_destroy();
header('Location: login.php?logout=1');
