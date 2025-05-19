<?php
require_once ("include/initialize.php");

if (isset($_POST['sidebarLogin']) || isset($_POST['modalLogin'])) {
    $email = trim($_POST['U_USERNAME'] ?? '');
    $upass = trim($_POST['U_PASS'] ?? '');
    $h_upass = sha1($upass);

    if ($email === '' || $upass === '') {
        message("Invalid Username and Password!", "error");
        redirect(web_root . "index.php" . (isset($_POST['modalLogin']) ? "?page=6" : ""));
    } else {
        $cus = new Customer();
        $cusres = $cus::cusAuthentication($email, $h_upass);

        if ($cusres === true) {
            if (isset($_POST['modalLogin']) && !empty($_POST['proid'])) {
                global $pdo;
                $proid = $_POST['proid'];
                $cusid = $_SESSION['CUSID'];
                $sql = "INSERT INTO `tblwishlist` (`PROID`, `CUSID`, `WISHDATE`, `WISHSTATS`) VALUES (:proid, :cusid, :wishdate, 0)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':proid' => $proid,
                    ':cusid' => $cusid,
                    ':wishdate' => date('Y-m-d')
                ]);
                redirect(web_root . "index.php?q=profile");
            } else {
                $redirectPage = isset($_POST['modalLogin']) ? "orderdetails" : "profile";
                redirect(web_root . "index.php?q=" . $redirectPage);
            }
        } else {
            message("Invalid Username and Password! Please contact administrator", "error");
            redirect(web_root . "index.php");
        }
    }
}
?>