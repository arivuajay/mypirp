<?php

class DefaultController extends Controller {
     public $layout = '//layouts/main';
     /**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
            return array(
                array('allow',  // allow all users to perform 'index' and 'view' actions
                    'actions'=>array('index','aboutus','contactus',"innercourses"),
                    'users'=>array('*'),
                ),
                array('allow', // allow authenticated user to perform 'create' and 'update' actions
                        'actions'=>array(''),
                        'users'=>array('@'),
                ),
                array('allow', // allow admin user to perform 'admin' and 'delete' actions
                        'actions'=>array(''),
                        'users'=>array('admin'),
                ),
                array('deny',  // deny all users
                        'users'=>array('*'),
                ),
            );
	}
    
    public function actionInnercourses($cid) {
        $this->layout = '//layouts/column3';
        
        if(Yii::app()->session['language'])
        {    
            $sitelang   = Yii::app()->session['language'];
        }else{
            $sitelang   = "en";
        }  
        
        $themeurl   = Yii::app()->theme->baseUrl;
        $website_id = Yii::app()->session['wid'];
        $dname      = Yii::app()->session['dname'];
        
        $course_data = array();
        $sort_order  = array();
        
        if($cid!="" && is_numeric($cid))
        {    
            $Criteria = new CDbCriteria();
            $Criteria->condition = "wid = $website_id and cid=$cid";        
            $ch_courses_list  = WebsiteCourses::model()->find($Criteria);
            $child_courses    = $ch_courses_list->child;
            $decode_list      = json_decode($child_courses,true);
          
            if(!empty($decode_list))
            {    
                foreach($decode_list as $key =>$row)
                {
                    $arr1 = $row;
                    $arr2 = array('cid' => $key);
                    $arr3 = $arr1 + $arr2;
                    $decode_list[$key] = $arr3;
                }

                foreach($decode_list as $key =>$row)
                {
                   $sort_order[$key] = $row['sorder'];
                }    

                array_filter($sort_order);
                array_multisort($sort_order,SORT_ASC,$decode_list);
                uasort($decode_list, function($a,$b) {
                    // push all 0's to the bottom of the array
                    if( $a['sorder'] == 0 ) return 1;
                    if( $b['sorder'] == 0 ) return -1;   
                    if( $a['sorder'] == $b['sorder'] ) {return 0; }   // values are the same
                    return ($a['sorder'] < $b['sorder']) ? -1 : 1;  // smaller numbers at top of list
                }); 

                if($sitelang=="en")
                {
                    $stat_qry = " status=1";
                }elseif ($sitelang=="es") {
                    $stat_qry = " status_es=1 ";
                } 

                foreach($decode_list as $cinfo)
                { 

                    $ckey = $cinfo['cid'];

                    $course_info = array();
                    $Criteria = new CDbCriteria();
                    $Criteria->condition =  "cid = $ckey and $stat_qry";         
                    $course_info     = Courses::model()->find($Criteria);

                    if(!empty($course_info))
                    {    
                        $ctitle        = "ctitle_".$sitelang;
                        $cshortdesc    = "cshortdesc_".$sitelang;
                        $cdescription  = "cdescription_".$sitelang;
                        $cdescription_list = "cdescription_list_".$sitelang;                

                        $course_data[$ckey]['ctitle'] = $course_info->{$ctitle};
                        $course_data[$ckey]['cshortdesc']   = $course_info->{$cshortdesc};
                        $course_data[$ckey]['cdescription'] = $course_info->{$cdescription};
                        $dlist = json_decode($course_info->{$cdescription_list});
                        $course_data[$ckey]['cdescription_list'] = $dlist;

                        $course_data[$ckey]['cregisterurl']  = $cinfo['cregisterurl'];
                        $course_data[$ckey]['cregisterurl_es']  = $cinfo['cregisterurl_es'];
                        $course_data[$ckey]['cprice']    = $cinfo['cprice'];
                        $course_data[$ckey]['cdiscount'] = $cinfo['cdiscount'];
                        $course_data[$ckey]['sorder']    = $cinfo['sorder'];
                    }    
                } 
            }    
        } 
        
        $winfos = Websites::model()->findByPk($website_id);
        if(!empty($winfos))
        {
            $course_img = (!empty($winfos->course_img) && $winfos->course_img!="")?$winfos->course_img:"noimage.jpg";
        } 
             
        $this->render('_innercourses',compact('themeurl','website_id','dname','course_data','sitelang',"course_img"));
    }    
        
    public function actionIndex() {
        $this->layout = '//layouts/column3';
        
        if(Yii::app()->session['language'])
        {    
            $sitelang   = Yii::app()->session['language'];
        }else{
            $sitelang   = "en";
        }  
        
        $themeurl   = Yii::app()->theme->baseUrl;
        $website_id = Yii::app()->session['wid'];
        $dname      = Yii::app()->session['dname'];
        
        if($website_id!="")
        {    
            if($sitelang=="en")
            {
                $stat_qry = " c.status=1";
            }elseif ($sitelang=="es") {
                $stat_qry = " c.status_es=1 ";
            }  
           
            $Criteria = new CDbCriteria();
            $Criteria->condition = "wid = $website_id and $stat_qry";
            $Criteria->order = "sorder=0 ,sorder";
            $Criteria->with  = 'c';
            $courses_list    = WebsiteCourses::model()->findAll($Criteria);

            $winfos     = Websites::model()->findByPk($website_id);
            if(!empty($winfos))
            {
                $course_img = (!empty($winfos->course_img) && $winfos->course_img!="")?$winfos->course_img:"noimage.jpg";
            }
        }else
            throw new CHttpException(404,'Website not found.');   
             
        $this->render('index',compact('themeurl','website_id','dname','courses_list','sitelang',"course_img"));
    }
    
    public function actionAboutus() {
        $this->layout = '//layouts/column3';
        $aboutus     = "";
        $aboutus_img = "";
       
        $website_id = Yii::app()->session['wid']; 
        if($website_id!="")
        { 
            $winfos     = Websites::model()->findByPk($website_id);
            if(!empty($winfos))
            {
                $aboutus     = $winfos->aboutus;
                $aboutus_img = (!empty($winfos->aboutus_img) && $winfos->aboutus_img!="")?$winfos->aboutus_img:"noimage.jpg";
            } 
        }else
            throw new CHttpException(404,'Website not found.');       
        
        $this->render('_aboutus',  compact('aboutus',"aboutus_img"));
    } 
    
     public function actionContactus() {
        $this->layout = '//layouts/column3';        
        $contactus     = "";
        
        $website_id = Yii::app()->session['wid'];  
        if($website_id!="")
        { 
            $winfos     = Websites::model()->findByPk($website_id);
            if(!empty($winfos))
            {
                $contactus     = $winfos->contactus;
                $contactus_img = (!empty($winfos->contactus_img) && $winfos->contactus_img!="")?$winfos->contactus_img:"noimage.jpg";
            } 
        }else
            throw new CHttpException(404,'Website not found.');       
        
        $this->render('_contactus',compact('contactus',"contactus_img"));
    }  
   

    public function actionError() {
         $this->layout = '//layouts/unauthorize';   
        $error = Yii::app()->errorHandler->error;
        if ($error)
            $this->render('_error', array('error' => $error));
        else
            throw new CHttpException(404, 'Page not found.');
    }
  
    /**
     * Performs the AJAX validation.
     * @param RetailerDirectory $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax'])) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
