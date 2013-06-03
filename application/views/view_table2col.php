<?php
/**
* Este arquivo é formatado de forma que fique sendo geral para uso de vários módulos.
*/
?>

<h3><?php echo $caption_title; ?></h3>
<hr>

<?php 
    # Criar botão de novo cadastro caso seja definido o link no Controller
    if ( !empty($form_action))
    {
        echo '<div style="text-align:right;"><a class="c-view" href="'.site_url($form_action).'" title="Novo">
              <button class="btn" type="submit"><i class="icon-plus-sign"></i> Cadastrar Novo</button></a></div>';
    }
    
    echo (!empty($message)) ? $message : NULL ;
    echo (!empty($modal))   ? $modal : NULL ;
?>

<div id="lista">
    <?php
        # Imprime a tabela retornada pelo controlador
        echo $html_lista;
    ?>
</div>

<div id="paginacao">
    <?php
        # Imprime a paginação
        echo $html_paginacao;
    ?>
</div>