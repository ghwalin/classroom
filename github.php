<?php
require_once "config.php";

function github_api($url, $token = null, $method = "GET", $data = null) {
    $headers = ["User-Agent: MyApp"];
    if ($token) $headers[] = "Authorization: token $token";
    if ($data) $headers[] = "Content-Type: application/json";

    $opts = [
        "http" => [
            "method" => $method,
            "header" => implode("\r\n", $headers),
            "content" => $data ? json_encode($data) : null
        ]
    ];
    $context = stream_context_create($opts);
    $res = file_get_contents(GITHUB_API . $url, false, $context);
    if ($res === false) {
        throw new Exception("Error accessing GitHub API: " . error_get_last()['message']);
    }
    return json_decode($res, true);
}

function get_github_login($token) {
    $user = github_api("/user", $token);
    return $user["login"] ?? null;
}
?>
