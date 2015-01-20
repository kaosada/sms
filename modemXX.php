<?php
    error_reporting(E_ALL);
    ini_set('display_errors','On');

    $cmd = "/usr/bin/gammu-smsd -c /etc/gammu-ttyMODEM3 -d";
        $paswd = "ruma1234\n";
    echo "The command is : ".$cmd."<br/>";

        // Create array of stdin, stdout and stderr of child process command
        $desc = array(
                0 => array('pipe', 'r'),
                1 => array('pipe', 'w'),
                2 => array('pipe', 'w')
                );

        $proc = proc_open($cmd, $desc, $pipes);
        if (is_resource($proc)){

            // Write password to stdin of child process (sudo command as a child process)
            fwrite($pipes[0], $paswd);
            fflush($pipes[0]);
            fclose($pipes[0]);

            // Read the output of child process (stdout of sudo command) if exist
            $out_prog = stream_get_contents($pipes[1]);
            if ($out_prog != ""){
                echo "Output: <b>".$out_prog."</b><br />";
            } else {

                // Read the error of child process (stderr of sudo command) if exist
                $out_err = stream_get_contents($pipes[2]);
                if ($out_err != ""){
                    echo "Error: ".$out_err."<br />";
                }

           }

            // Closing child process "handles"
            fclose($pipes[1]);
            fclose($pipes[2]);

            // Close proc_open() function
            proc_close($proc);

        } else {
        echo "Can not create process<br />";
        }
?>
