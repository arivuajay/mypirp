<?php
/* @var $this AffliatesController */
/* @var $dataProvider CActiveDataProvider */
$this->title = 'Affiliates Management';
$this->breadcrumbs = array(
    'Affiliate Infos',
);
$themeUrl = $this->themeUrl;
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;

$cs->registerCssFile($themeUrl . '/css/datepicker/datepicker3.css');
$cs->registerScriptFile($themeUrl . '/js/datepicker/bootstrap-datepicker.js', $cs_pos_end);
?>
<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php
        if (AdminIdentity::checkAccess('webpanel.affliates.create')) {
            echo CHtml::link('<i class="fa fa-plus"></i>&nbsp;&nbsp;Create an Affiliate', array('/webpanel/affiliates/create'), array('class' => 'btn btn-success pull-right'));
        }
        ?>
    </div>
</div>
<div class="col-lg-12 col-md-12">&nbsp;</div>
<?php $this->renderPartial('_search', compact('model')); ?>
<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php
        $gridColumns = array(
            'agency_name',
            'agency_code',
            'user_id',
            array(
                'header' => 'Referral code',
                'name' => 'affiliateCommission.referral_code',
                'value' => $data->affiliateCommission->referral_code,
            ),
            array(
                'header' => 'Referral Amount',
                'name' => 'affiliateCommission.referral_amt',
                'value' => function($data) {
                    echo "$" . $data->affiliateCommission->referral_amt;
                }),
            array(
                'header' => 'status',
                'name' => 'enabled',
                'htmlOptions' => array('style' => 'width: 180px;text-align:center', 'vAlign' => 'middle'),
                'type' => 'raw',
                'sortable' => false,
                'filter' => CHtml::activeDropDownList($model, 'enabled', array("Y" => "Enabled", "N" => "Disabled"), array('class' => 'form-control', 'prompt' => 'All')),
                'value' => function($data) {
            echo ($data->enabled == "Y") ? "<i class='fa fa-circle text-green'></i>" : "<i class='fa fa-circle text-red'></i>";
        }),
            array(
                'header' => 'Actions',
                'class' => 'booster.widgets.TbButtonColumn',
                'htmlOptions' => array('style' => 'width: 180px;;text-align:center', 'vAlign' => 'middle', 'class' => 'action_column'),
                'template' => '{update}&nbsp;&nbsp;{delete}',
                'buttons' => array(
                    'update' => array('visible' => "AdminIdentity::checkAccess('webpanel.affliates.edit')" ),
                    'delete' => array('visible' => "AdminIdentity::checkAccess('webpanel.affliates.delete')" )
                ),
            )
        );
        $this->widget('booster.widgets.TbExtendedGridView', array(
            'filter' => $model,
            'type' => 'striped bordered datatable',
            'dataProvider' => $model->search(),
            'responsiveTable' => true,
            'template' => '<div class="panel panel-primary"><div class="panel-heading"><div class="pull-right">{summary}</div><h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> Affiliate Infos</h3></div><div class="panel-body">{items}{pager}</div></div>',
            'columns' => $gridColumns
                )
        );
        ?>
    </div>
</div>
<?php
$js = <<< EOD
$(document).ready(function(){
        
$("#export_csv").click(function() {
    var startdate = $("#DmvAffiliateInfo_start_date").val();
    var enddate = $("#DmvAffiliateInfo_end_date").val();
        
    $("#startdate_error").hide();    
    $("#enddate_error").hide();
   
   if(startdate=="")
    {
        $("#startdate_error").show();
        return false;
    }
    
   if(enddate=="")
    {
        $("#enddate_error").show();
        return false;
    }
        
    return true;
        
}); 
        
$('.year').datepicker({ dateFormat: 'yyyy' });
$('.date').datepicker({ format: 'yyyy-mm-dd' }); 
    
});
EOD;
Yii::app()->clientScript->registerScript('_form_instructor', $js);
?>