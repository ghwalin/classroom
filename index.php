<?php
require_once "config.php";

session_start();

if (!isset($_SESSION["github_token"])) {
    $url = "https://github.com/login/oauth/authorize?" . http_build_query([
        "client_id" => GITHUB_CLIENT_ID,
        "redirect_uri" => GITHUB_REDIRECT_URI,
        "scope" => "repo"
    ]);
    echo "<a href='$url'>Login with GitHub</a>";
} else {
    echo "You are logged in. Go to /accept?template=templates-python/m999-lu99-a99&org=MyOrg";
}
?>
