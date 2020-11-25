param($watch, $compress)

$source = "..\assets\main.scss"
$dest = "..\public\css\style.css"
$command = "sass " + $source + " " + $dest + " "


if ($watch -eq "watch") {
  $command += "--watch "
}

if ($compress -eq "compress") {
  $command += "--style compressed "
}

Invoke-Expression $command