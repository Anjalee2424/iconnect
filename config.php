<?php
$documentRoot = realpath($_SERVER["DOCUMENT_ROOT"]);
$projectRoot  = realpath(__DIR__); // 1階層上がプロジェクト

$BASE_URL = str_replace($documentRoot, "", $projectRoot) . "/";

$appName = "iConnect";