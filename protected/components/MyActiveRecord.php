<?php
class MyActiveRecord extends CActiveRecord {
   
    private static $dbold = null;
 
    protected static function getOldDbConnection()
    {
        if (self::$dbold !== null)
            return self::$dbold;
        else
        {
            self::$dbold = Yii::app()->dbold;
            if (self::$dbold instanceof CDbConnection)
            {
                self::$dbold->setActive(true);
                return self::$dbold;
            }
            else
                throw new CDbException(Yii::t('yii','Active Record requires a "db" CDbConnection application component.'));
        }
    }
    
    public function getDbConnection()
    {
        return (isset(Yii::app()->session['currentdb']) && Yii::app()->session['currentdb']=="olddb")?self::getOldDbConnection():parent::getDbConnection();       
    }
    
}    