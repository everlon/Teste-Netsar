<h3><?php echo $caption_title; ?></h3><br />

<?php 
    echo form_open( $form_action );
    if (!empty($id)) { echo form_hidden('id', $id); }
?>
<div class="form-horizontal">

    <?php
    $label_class = array( 'class'=>'control-label' );

    foreach ($label_campo as $key => $value)
    {
        if ( !empty($alt) ) { $conteudo_input = array('name'=>$label_campo[$key]['label'], 'id'=>$label_campo[$key]['label'], 'value'=>$$label_campo[$key]['label']); }
        else                { $conteudo_input = array('name'=>$label_campo[$key]['label'], 'id'=>$label_campo[$key]['label'] ); }

        if ($label_campo[$key]['label'] != 'id')
        {
            echo '<div class="control-group" style="float:left">';
            echo form_label(lang($label_campo[$key]['label']), $label_campo[$key]['label'], $label_class);
            echo '<div class="controls">';

            switch ($label_campo[$key]['label']) 
            {   
                case 'user':
                case 'domain':
                    $conteudo_input['style'] = 'width:300px';
                    echo form_input($conteudo_input);
                    break;

                case 'imap':
                case 'smtp':
                    $conteudo_input['style'] = 'width:300px';
                    echo form_input($conteudo_input);
                    break;

                case 'imap_protocol':
                    $conteudo_input['style'] = 'width:10px';
                    $options = array(
                                      'none' => 'Nenhum',
                                      'ssl' => 'SSL');

                    echo form_dropdown($conteudo_input['name'], $options);
                    break;

                case 'smtp_protocol':
                    $conteudo_input['style'] = 'width:10px';
                    $options = array(
                                      'NO' => 'Nenhum',
                                      'SSL' => 'SSL',
                                      'TLS' => 'TLS',
                                      'STARTLS' => 'STARTLS');
                    echo form_dropdown($conteudo_input['name'], $options);
                    break;

                case 'imap_port':
                case 'smtp_port':
                    $conteudo_input['style'] = 'width:50px';
                    echo form_input($conteudo_input);
                    break;

                case 'smtp_auth':
                    $conteudo_input['style'] = 'width:300px';
                    $options = array(
                                      '1' => 'Sim',
                                      '0' => 'Não');
                    echo form_dropdown($conteudo_input['name'], $options);
                    break;

                default:
                    echo form_input($conteudo_input);
                    break;
            }
            
            echo '</div></div>';
        }
        else{ echo form_hidden('id', $$label_campo[$key]['label']); }
    }
            
    ?>

    <div class="control-group">
        <?php echo form_label(''); ?>
            <div class="controls" style="width:100%; clear:both">
                <?php 
                    echo form_submit('submit', $caption_button, 'class="btn"').' ';
                    echo '<button class="btn btn-link" type="button" onClick="document.location.href=\''.site_url( $btn_back ).'\'">Cancelar</button>';
                    //echo form_button_cancelar();
                ?>
            </div>
    </div>

</div>

<?php echo form_close(); ?>