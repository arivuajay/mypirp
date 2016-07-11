<?php
/* @var $this BookordersController */
/* @var $dataProvider CActiveDataProvider */

$this->title = 'Book Orders';
$this->breadcrumbs = array(
    'Book Orders',
);
?>

<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php
        if (AdminIdentity::checkAccess('webpanel.bookorders.create')) {
            echo CHtml::link('<i class="fa fa-plus"></i>&nbsp;&nbsp;Add Book Order', array('/webpanel/bookorders/create'), array('class' => 'btn btn-success pull-right'));
        }
        ?>
    </div>
</div>

<div class="col-lg-12 col-md-12">&nbsp;</div>

<div class="col-lg-12 col-md-12">
    <div class="row">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="glyphicon glyphicon-search"></i>  Search
                </h3>
                <div class="clearfix"></div>
            </div>

            <section class="content">
                <div class="row">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'instructors-search-form',
                        'method' => 'get',
                        'action' => array('/webpanel/bookorders/'),
                        'htmlOptions' => array('role' => 'form')
                    ));
                    ?>
                    <div class="col-lg-2 col-md-2">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'startdate', array('class' => ' control-label')); ?>
                            <div class="input-group">
                                <span class="input-group-addon">  <i class="fa fa-calendar"></i></span>
                                <?php echo $form->textField($model, 'startdate', array('class' => 'form-control date')); ?>                               
                            </div>   
                            <div style="display: none;" id="startdate_error" class="errorMessage">Please select start date.</div>
                        </div>
                    </div> 

                    <div class="col-lg-2 col-md-2">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'enddate', array('class' => ' control-label')); ?>
                            <div class="input-group">
                                <span class="input-group-addon">  <i class="fa fa-calendar"></i></span>
                                <?php echo $form->textField($model, 'enddate', array('class' => 'form-control date')); ?>                               
                            </div> 
                            <div style="display: none;" id="enddate_error" class="errorMessage">Please select end date.</div>
                        </div>
                    </div> 

                    <div class="col-lg-3 col-md-3">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'affiliate_id', array('class' => ' control-label')); ?> 
                            <?php echo $form->dropDownList($model, 'affiliate_id', $affiliates, array('class' => 'form-control')); ?>            
                        </div>
                    </div> 
                    
                    <div class="col-lg-2 col-md-2">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <?php echo CHtml::submitButton('Filter', array("id" => 'print_res', 'class' => 'btn btn-primary form-control')); ?>
                        </div>
                    </div>
                    <div class="clearfix"></div> 
                    <?php echo $form->hiddenField($model, 'bookorder_page',array("value"=>"1")); ?>
                    <?php $this->endWidget(); ?>
                </div>
            </section>

        </div>
    </div>
</div>
<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php
        $gridColumns = array(
             array(
                'header' => 'Agency code',
                'name' => 'affiliateInfo.agency_code',
                'value' => $data->affiliateInfo->agency_code,
            ),
            array(
                'name' => 'payment_date',
                'value' => function($data) {
                    if (true == strtotime($data->payment_date))
                        echo Myclass::date_dispformat($data->payment_date);
                    else
                        echo "-";
                }
            ),
            'number_of_books',
            'book_fee',
            'shipping_fee',
            'payment_amount',
            array(
                'name' => 'payment_type',
                'value' => function($data) {
                    if ($data->payment_type != "") {
                        $card_types = Myclass::card_types();
                        if (array_key_exists($data->payment_type, $card_types)) {
                            echo $card_types[$data->payment_type];
                        } else {
                            echo "-";
                        }
                    }
                }
            ),
            // 'cheque_number',
            //'payment_complete',
            //'payment_notes',
            array(
                'header' => 'Actions',
                'class' => 'booster.widgets.TbButtonColumn',
                'htmlOptions' => array('style' => 'width: 180px;;text-align:center', 'vAlign' => 'middle', 'class' => 'action_column'),
                'template' => '{update}&nbsp;&nbsp;{delete}',
                'buttons' => array(
                    'update' => array('visible' => "AdminIdentity::checkAccess('webpanel.bookorders.update')"),
                    'delete' => array('visible' => "AdminIdentity::checkAccess('webpanel.bookorders.delete')"),
                )
            )
        );

        $this->widget('booster.widgets.TbExtendedGridView', array(
            //  'filter' => $model,
            'type' => 'striped bordered datatable',
            'enableSorting' => false,
            'dataProvider' => $model->search(),
            'responsiveTable' => true,
            'template' => '<div class="panel panel-primary"><div class="panel-heading"><div class="pull-right">{summary}</div><h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>  Book Orders</h3></div><div class="panel-body">{items}{pager}</div></div>',
            'columns' => $gridColumns
                )
        );
        ?>
    </div>
</div>