<?php

// Get the arguments
if(count($argv) > 1)
{
    $file = $argv[1];

    // Does the file exists ?
    if(file_exists($file))
    {
        // What's its extension ?
        $extension = pathinfo($file,PATHINFO_EXTENSION);
        if($extension == "txt")
        {
            // Read and show
            $content = file_get_contents($file);
            echo str_replace(" ","\n",$content);
        }
        else
        {
            echo "Le fichier doit avoir une extension txt\n";
        }

    }
    else
    {
        echo "Le fichier n'existe pas\n";
    }
}
else
{
    echo "Vous avez oublié de passer en argument le fichier à lire\n";
}