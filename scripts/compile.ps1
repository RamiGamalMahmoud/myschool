
$source = "assets\main.scss"
$dest = "public\css\style.css"
$command = "sass " + $source + " " + $dest + " "


  $command += "--watch "

  $command += "--style compressed "

Invoke-Expression $command