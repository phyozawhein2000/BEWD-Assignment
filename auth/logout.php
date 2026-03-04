<?php
// Session ကို စတင်ခြင်း
session_start();

// Session variable အားလုံးကို ဖျက်သိမ်းခြင်း
$_SESSION = array();

// Session Cookie ကိုပါ ဖျက်လိုပါက (ပိုမိုလုံခြုံစေရန်)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Session ကို လုံးဝအဆုံးသတ်လိုက်ခြင်း
session_destroy();

// Logout လုပ်ပြီးနောက် Homepage (သို့မဟုတ်) Login Page သို့ ပြန်ပို့ခြင်း
header("Location: ../index.php");
exit();
?>