<?php
require_once "github.php";
session_start();

if (!isset($_SESSION["github_token"])) {
    header("Location: /index.php");
    exit;
}

$token = $_SESSION["github_token"];
$template = $_GET["template"] ?? null; // e.g. templates-python/m999-lu99-a99
$org = $_GET["org"] ?? null;

if (!$template || !$org) {
    die("Missing template or org");
}

list($template_owner, $template_repo) = explode("/", $template);

$username = get_github_login($token);
$target_repo = $template_repo . "-" . $username;

// Check if repo exists
$check = github_api("/repos/$org/$target_repo", $token);
if (isset($check["id"])) {
    header("Location: https://github.com/$org/$target_repo");
    exit;
}

// Create repo from template
$data = [
    "owner" => $org,
    "name" => $target_repo
];
$created = github_api("/repos/$template_owner/$template_repo/generate", $token, "POST", $data);

if (isset($created["html_url"])) {
    header("Location: " . $created["html_url"]);
    exit;
} else {
    die("Error creating repository");
}
?>
