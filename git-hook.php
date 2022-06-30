<?php
// Script to recieve git webhook requests from Bitbucket to automatically pull on push
// @see: https://gist.github.com/ryanwinchester/578c5b50647df3541794

$ip_check = $_SERVER['REMOTE_ADDR'];
$allow = false;

if(!isset($_GET['tkn']) || $_GET['tkn'] != '8EWaER8NEkr9LAnM') {
    die("Nope");
}

$content = file_get_contents('https://ip-ranges.atlassian.com/');
$ranges = json_decode($content);

foreach($ranges->items as $r) {
    $ips_allowed[] = $r->cidr;
}

function ip_in_range($ip, $range) {
    list($range, $netmask) = explode('/', $range, 2);
    $ip_decimal = ip2long($ip);
    $range_decimal = ip2long($range);
    $wildcard_decimal = pow(2, (32 - $netmask)) - 1;
    $netmask_decimal = ~ $wildcard_decimal;

    return (($ip_decimal & $netmask_decimal) == ($range_decimal & $netmask_decimal));
}

foreach ($ips_allowed as $range) {
    $allow = ip_in_range($ip_check, $range);

    if ($allow) {
        break;
    }
}

if (!$allow) {
    die('IP not allowed: '.$ip_check);
}

echo "IP allowed, pull repo\n";

$output = shell_exec('/usr/local/cpanel/3rdparty/lib/path-bin/git pull origin master');

echo "\nCommand output:\n";
echo $output;
?>
