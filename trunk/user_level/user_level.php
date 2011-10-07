<?php
class UserLevel {
    public $GPRS;
    public $MaxDevices;
    public $MaxAdmin;
    public $MaxUsers;
    public $DataQueries;
    public $DataHistory;
    public $DataReports;
    public $POIs;
    public $Sensors;
    public $ModDevices;
    public $EditPOI;
    public $Alerts;
    public $DefaultMap;

    public function __construct($L)
    {
        //                                  Free    Pers     Prof   Busines   Dedic    Admin
        $this->GPRS        = self::setl($L,    0,      0,       0,       0,       1,       1);
    	$this->MaxDevices  = self::setl($L,    1,      5,      10,     100, 9999999, 9999999);
        $this->MaxAdmin    = self::setl($L,    1,      1,       1,       1,       1, 9999999);
        $this->MaxUsers    = self::setl($L,    0,      1,       5, 9999999, 9999999, 9999999);
        $this->DataQueries = self::setl($L,    1,      1, 9999999, 9999999, 9999999, 9999999);
        $this->DataHistory = self::setl($L,    7,     30,      90,     730,     730, 9999999);
        $this->DataReports = self::setl($L,    0,     30,      90,     730,     730, 9999999);
        $this->POIs        = self::setl($L,    0,      0,      20, 9999999, 9999999, 9999999);
        $this->Sensors     = self::setl($L,    0,      0,       0,       1,       1,       1);
        $this->ModDevices  = self::setl($L,    1,      1,       1,       1,       0,       1);
        $this->EditPOI     = self::setl($L,    0,      1,       1,       1,       0,       1);
        $this->Alerts      = self::setl($L,    0,      1,       1,       1,       1,       1);
        $this->DefaultMap  = self::setl($L,    0,      1,       1,       1,       1,       2);
    }

    private function setl($intLevel, $Free, $Pers, $Prof, $Busi, $DBus, $Admi)
    {
        if ($intLevel == 1):      return $Admi; # Administrator
        elseif ($intLevel == 2):  return $Pers; # Personal
        elseif ($intLevel == 3):  return $Prof; # Professional
        elseif ($intLevel == 4):  return $Busi; # Business
        elseif ($intLevel == 5):  return $DBus; # Dedicated-Business
        else:                     return $Free; # Free User
        endif;
    }
}

?>
