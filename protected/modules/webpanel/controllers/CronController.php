<?php
class CronController extends Controller {

    public function actionReferralreport() {
        $total_cnt_stds = 0;
        $total_amnt = 0;
        $total_cnt_month = 0;
        $total_amnt_month = 0;
        $total_cnt_aff_new = 0;
        $total_cnt_aff_month = 0;
        $today_date = date('Y-m-d');
        
        ////start and end month
        $month_start = date('Y') . '-' . date('m') . '-01';
        $month_end   = date('Y') . '-' . date('m') . '-31';
        //////////////
        $today_disp = date('m/d/Y');
        $first_day_this_month = date('m/01/Y'); // hard-coded '01' for first day
        $last_day_this_month  = date('m/t/Y');
        
        $mail = new Sendmail;

        //$to = "vasanth@arkinfotec.com";
        $to = "danielle@americansafetyinstitute.com";

        //$ccaddress = array("vasashiner@gmail.com", "testman1@gmail.com");
         $ccaddress = array("catherine@americansafetyinstitute.com","bartjr@americansafetyinstitute.com");

        $subject = "Daily Referral Report - " . $today_disp;

        //find number of affilaites today	
        $criteria_1 = new CDbCriteria;
        $criteria_1->addCondition("aff_created_date = '" . $today_date . "'");
        $total_cnt_aff_new = DmvAffiliateInfo::model()->count($criteria_1);

        //find number of affilaites in month	
        $criteria_2 = new CDbCriteria;
        $criteria_2->addCondition("aff_created_date between '" . $month_start . "' AND '" . $month_end . "'");
        $total_cnt_aff_month = DmvAffiliateInfo::model()->count($criteria_2);

        //find number of students and amount today
        $criteria_3 = new CDbCriteria;
        $criteria_3->addCondition("payment_amount > 0");
        $criteria_3->addCondition("payment_date >= '" . $today_date . "' AND payment_date <= '" . $today_date . "'");
        $criteria_3->with = array("dmvClasses", "dmvClasses.Affliate", "dmvClasses.Affliate.affiliateCommission");
        $criteria_3->together = true;
        $ref_results = Payment::model()->findAll($criteria_3);
        foreach ($ref_results as $rinfo) {
            $referralamt = $rinfo->dmvClasses->Affliate->affiliateCommission->referral_amt;
            $class_id    = $rinfo->class_id;

            $SCount = Payment::totalstudents($class_id);
            $referral_amt = (($referralamt) * $SCount);

            $total_amnt += $referral_amt;
            $total_cnt_stds += $SCount;
        }

        //find number of students and amount based on month
        $criteria_4 = new CDbCriteria;
        $criteria_4->addCondition("payment_amount > 0");
        $criteria_4->addCondition("payment_date  between '$month_start' and '$month_end'");
        $criteria_4->with = array("dmvClasses", "dmvClasses.Affliate", "dmvClasses.Affliate.affiliateCommission");
        $criteria_4->together = true;
        $ref_mont_results = Payment::model()->findAll($criteria_4);
        foreach ($ref_mont_results as $rfinfo) {
            $referralamt = $rfinfo->dmvClasses->Affliate->affiliateCommission->referral_amt;
            $class_id = $rfinfo->class_id;

            $SCount_month = Payment::totalstudents($class_id);
            $referral_amt_month = (($referralamt) * $SCount_month);

            $total_amnt_month += $referral_amt_month;
            $total_cnt_month += $SCount_month;
        }

        $trans_array = array(
            "{total_cnt_stds}" => $total_cnt_stds,
            "{total_amnt}" => $total_amnt,
            "{total_cnt_month_stds}" => $total_cnt_month,
            "{total_amnt_month}" => $total_amnt_month,
            "{total_cnt_aff_new}" => $total_cnt_aff_new,
            "{total_cnt_aff_month}" => $total_cnt_aff_month,
            "{today_disp}" => $today_disp,
            "{first_day_this_month}" => $first_day_this_month,
            "{last_day_this_month}" => $last_day_this_month
        );
        $message = $mail->getMessage('referrel_report', $trans_array);

        $mail->send($to, $subject, $message, "", "", null, null, $ccaddress);
        echo "Successfully Sent Referral Report to your mail!!!";
        exit;
    }

}
//        $connection = Yii::app()->db;
//        $qry= "";
//        $command = $connection->createCommand($qry);
//        $rep_credentials = $command->queryAll();
//        if (!empty($rep_credentials)) {
//            foreach ($rep_credentials as $rep_credential) {                
//            }
//        } 