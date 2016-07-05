<?php
/* @var $this PostdocumentController */
/* @var $dataProvider CActiveDataProvider */

$this->title = 'Documents';
$this->breadcrumbs = array(
    'Documents',
);
?>

<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php
        if (AdminIdentity::checkAccess('webpanel.postdocument.create')) {
            echo CHtml::link('<i class="fa fa-plus"></i>&nbsp;&nbsp;Add Document', array('/webpanel/postdocument/create'), array('class' => 'btn btn-success pull-right'));
        }
        ?>
    </div>
</div>

<div class="col-lg-12 col-md-12">&nbsp;</div>

<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php
        $gridColumns = array(
            array('header' => 'SN.',
                'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
            ),
            array(
                'name' => 'Affliate.agency_name',
                'value' => function($data) {
                    echo ($data->affiliate_id>0)?$data->Affliate->agency_name:"-All-";
                }
            ),
            'doc_title',
            'file_name',
            array(
                'name' => 'posted_date',
                'value' => function($data) {
                    echo Myclass::date_dispformat($data->posted_date);
                },
            ),
            array(
                'header' => 'Actions',
                'class' => 'booster.widgets.TbButtonColumn',
                'htmlOptions' => array('style' => 'width: 180px;;text-align:center', 'vAlign' => 'middle', 'class' => 'action_column'),
                'template' => '{download}&nbsp;&nbsp;&nbsp;{update}&nbsp;&nbsp;&nbsp;{delete}',
                'buttons' => array(
                    'update' => array('visible' => "AdminIdentity::checkAccess('webpanel.postdocument.update')"),
                    'delete' => array('visible' => "AdminIdentity::checkAccess('webpanel.postdocument.delete')"),
                    'download' => array(
                        'label' => "<i class='fa fa-download'></i>",
                        'url' => '(is_file(YiiBase::getPathOfAlias("webroot")."/messagedoc/".$data->file_name)) ? Yii::app()->createAbsoluteUrl("/messagedoc/".$data->file_name) : ""',
                        'options' => array('class' => 'newWindow', 'target' => '_blank', 'title' => "Download file"),
                        'visible' => '(is_file(YiiBase::getPathOfAlias("webroot")."/messagedoc/".$data->file_name))',
                    ),
                ),
            )
        );

        $this->widget('booster.widgets.TbExtendedGridView', array(
            //  'filter' => $model,
            'enableSorting' => false,
            'type' => 'striped bordered datatable',
            'dataProvider' => $model->search(),
            'responsiveTable' => true,
            'template' => '<div class="panel panel-primary">'
            . '<div class="panel-heading">'
            . '<div class="pull-right">{summary}</div>'
            . '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> Documents</h3>'
            . '</div>'
            . '<div class="panel-body">{items}{pager}</div>'
            . '</div>',
            'columns' => $gridColumns,
                )
        );
        ?>
    </div>
</div>