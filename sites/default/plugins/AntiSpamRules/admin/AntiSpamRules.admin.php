<?php
/**
 * User: silva
 * Date: 16/12/2017
 * Time: 21:50
 */

$tpl = Admin_tpl::get();
$db = \DB::getPDO();
$flash = array('flash' => false);

if (isset($_POST['ASR_WORDS_NOT_ALLOWED_EVER']) && CODOF\Access\CSRF::valid($_POST['CSRF_token'])) {
    unset($_POST['CSRF_token']);
    foreach ($_POST as $key => $value) {
        $query = "UPDATE " . PREFIX . "codo_config SET option_value=:value WHERE option_name=:key";
        $ps = $db->prepare($query);
        $ps->execute(array(':key' => $key, ':value' => htmlentities($value, ENT_QUOTES, 'UTF-8')));
    }
    $flash = array('flash' => true, 'message' => 'Settings saved successfully.');

}
CODOF\Util::get_config($db, true);

$tpl->assign('flash', $flash);
echo Admin_tpl::render('AntiSpamRules/admin/AntiSpamRules.admin.tpl');