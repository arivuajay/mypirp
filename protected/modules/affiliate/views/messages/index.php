<?php
/* @var $this MessagesController */
/* @var $dataProvider CActiveDataProvider */

$this->title = 'Messages';
$this->breadcrumbs = array(
    'Messages',
);
?>

<div class="col-lg-12 col-md-12">&nbsp;</div>

<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php
        $gridColumns = array(
            array('header' => 'SN.',
                'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
            ),
            'message_title',
            array(
                'name' => 'posted_date',
                'value' => function($data) {
                    echo Myclass::date_dispformat($data->posted_date);
                },
            ),
            array(
                'header' => 'Actions',
                'class' => 'ButtonColumn',
                'evaluateID' => true,
                'htmlOptions' => array('style' => 'width: 180px;;text-align:center', 'vAlign' => 'middle', 'class' => 'action_column'),
                'template' => '{view}',
                'buttons' => array(
                    'view' => array(
                        'url' => '"javascript:void(0)"',
                        'options' => array(
                            "id" => '$data->message_id',
                            'data-target' => '#message-disp-modal',
                            'data-toggle' => 'modal',
                            'class' => 'popupmarque',
                        ),
                    ),
                ),
            )
        );

        $this->widget('booster.widgets.TbExtendedGridView', array(
            // 'filter' => $model,
            'type' => 'striped bordered datatable',
            'dataProvider' => $model->search(),
            'responsiveTable' => true,
            'template' => '<div class="panel panel-primary"><div class="panel-heading"><div class="pull-right">{summary}</div><h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> Messages</h3></div><div class="panel-body">{items}{pager}</div></div>',
            'columns' => $gridColumns
                )
        );
        ?>
    </div>
</div>
<div class="modal fade" id="message-disp-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="fa fa-folder-open-o"></i> Message</h4>
              
            </div>
            <div class="modal-body">
                  <div id="message_contents"></div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php
$cs_pos_end = CClientScript::POS_END;
$themeUrl = $this->themeUrl;
$ajax_getmessage = Yii::app()->createUrl('/affiliate/messages/view');
$js = <<< EOD
$(document).ready(function()
{   
    $('.popupmarque').live('click',function(event){
        event.preventDefault();
        var msg_value = $(this).attr("id");     
        var dataString = 'id='+msg_value;
            
        $.ajax({
            type: "POST",
            url:  '{$ajax_getmessage}',
            data: dataString,
            cache: false,
            success: function(html){             
                $("#message_contents").html(html);               
            }
         });
       
    });
  
});     
EOD;
Yii::app()->clientScript->registerScript('_form', $js);
?>