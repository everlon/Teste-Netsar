<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php 
    echo '<div style="width:700px; margin: 0 auto">';
    echo '<div class="'.$emphasis_classes.'"><b>'.$message. '</b> <div id="tempo"></div></div>'; 
    echo '</div>';
?>

<script language="JavaScript">
    var start = 3;
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
            setTimeout("document.location = '<?php echo site_url().$url; ?>'",2000);
        }
        start--;
    }
    diminui();
</script>