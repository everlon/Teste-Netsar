<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php 
    echo '<div style="width:700px; margin: 0 auto"><div>'.$message.' <div id="tempo"></div></div></div>';

    /*
    # Visualizar os dados capturados
    echo '<pre>';
    echo $user.'<br>';
    echo $domain.'<br>';
    echo $imap.'<br>';
    echo $imap_port.'<br>';
    echo $imap_protocol.'<br>';
    echo $smtp.'<br>';
    echo $smtp_port.'<br>';
    echo $smtp_protocol.'<br>';
    echo $smtp_auth.'<br>';
    echo $password.'<br>';
    echo '</pre>';
    */
?>

<script language="JavaScript">
    var start = 10;
    function diminui ()
    {
        document.getElementById("tempo").innerHTML = start;
        if (start > 0) 
        {
            window.setTimeout ("diminui()", 1000);
        }
        else 
        {
            document.getElementById("tempo").innerHTML = "Redirecionando...";
            setTimeout("document.location = '<?php echo site_url().$url; ?>'",3000);
        }
        start--;
    }
    diminui();
</script>