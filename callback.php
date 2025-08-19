<?php
require_once "config.php";

session_start();

if (isset($_GET["code"])) {
    $opts = [
        "http" => [
            "method" => "POST",
            "header" => "Content-Type: application/x-www-form-urlencoded",
            "content" => http_build_query([
                "client_id" => GITHUB_CLIENT_ID,
                "client_secret" => GITHUB_CLIENT_SECRET,
                "code" => $_GET["code"],
                "redirect_uri" => GITHUB_REDIRECT_URI
            ])
        ]
    ];
    $res = file_get_contents("https://github.com/login/oauth/access_token", false, stream_context_create($opts));
    parse_str($res, $out);
    $_SESSION["github_token"] = $out["access_token"] ?? null;
    header("Location: /index.php");
    exit;
}
?>
