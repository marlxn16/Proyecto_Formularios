<?php
session_start();
session_destroy();
header("Location: index.html?msg=" . urlencode("Sesion cerrada."));
exit;