<?php
session_start();
session_destroy();
header("Location: Lobby.html");
exit();
