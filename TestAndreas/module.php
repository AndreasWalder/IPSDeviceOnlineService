<?php

// Constants will be defined with IP-Symcon 5.0 and newer
if (!defined('KR_READY')) {
    define('KR_READY', 10103);
}
if (!defined('IPS_BOOLEAN')) {
    define('IPS_BOOLEAN', 0);
}
if (!defined('IPS_INTEGER')) {
    define('IPS_INTEGER', 1);
}
if (!defined('IPS_FLOAT')) {
    define('IPS_FLOAT', 2);
}
if (!defined('IPS_STRING')) {
    define('IPS_STRING', 3);
}

class TestAndreas extends IPSModule
{
    public function Create()
    {
        parent::Create();

        $this->RegisterPropertyString('device1', '');
        $this->RegisterPropertyString('user1', '');
        $this->RegisterPropertyString('macaddress1', '');
        $this->RegisterPropertyBoolean('active1', 'false');
		$this->RegisterPropertyString('device2', '');
        $this->RegisterPropertyString('user2', '');
        $this->RegisterPropertyString('macaddress2', '');
        $this->RegisterPropertyBoolean('active2', 'false');
		$this->RegisterPropertyString('device3', '');
        $this->RegisterPropertyString('user3', '');
        $this->RegisterPropertyString('macaddress3', '');
        $this->RegisterPropertyBoolean('active3', 'false');
		$this->RegisterPropertyString('device4', '');
        $this->RegisterPropertyString('user4', '');
        $this->RegisterPropertyString('macaddress4', '');
        $this->RegisterPropertyBoolean('active4', 'false');
		$this->RegisterPropertyString('DebugDeviceAddress', '');
		
		$this->RegisterPropertyInteger("UpdateInterval", 30);
		
		//Timer erstellen
		$this->RegisterTimer("Update", $this->ReadPropertyInteger("UpdateInterval"), 'TA_UpdateData($_IPS[\'TARGET\']);');
		$this->RegisterTimer("Debug", 0, 'TA_Debug($_IPS[\'TARGET\']);');
		
		$associations = [];
        $associations[] = ['Wert' => 1, 'Name' => 'Anwesend'];
        $associations[] = ['Wert' => 0, 'Name' => 'Abwesend'];
        $this->CreateVarProfile('TA.Handy', IPS_INTEGER, '', 0, 0, 0, 1, 'Heart', $associations);
    }

    public function ApplyChanges()
    {
        parent::ApplyChanges();

        $device1 = $this->ReadPropertyString('device1');
        $user1 = $this->ReadPropertyString('user1');
        $macaddress1 = $this->ReadPropertyString('macaddress1');
        $active1 = $this->ReadPropertyBoolean('active1');
		$device2 = $this->ReadPropertyString('device2');
        $user2 = $this->ReadPropertyString('user2');
        $macaddress2 = $this->ReadPropertyString('macaddress2');
        $active2 = $this->ReadPropertyBoolean('active2');
		$device3 = $this->ReadPropertyString('device3');
        $user3 = $this->ReadPropertyString('user3');
        $macaddress3 = $this->ReadPropertyString('macaddress3');
        $active3 = $this->ReadPropertyBoolean('active3');
		$device4 = $this->ReadPropertyString('device4');
        $user4 = $this->ReadPropertyString('user4');
        $macaddress4 = $this->ReadPropertyString('macaddress4');
        $active4 = $this->ReadPropertyBoolean('active4');
		
		$DebugDeviceAddress = $this->ReadPropertyString('DebugDeviceAddress');
		
		$this->SetTimerInterval("Update", $this->ReadPropertyInteger("UpdateInterval")*1000*60);

		if ($device1 != '' && $user1 != '') {
               $ok1 = true;
			   $this->MaintainVariable('user1Active', $this->Translate($user1), IPS_INTEGER, 'TA.Handy', $vpos++, true);
               $this->SetStatus(102);
        } 
		else {
			 $ok1 = false;
             $this->SetStatus(104);
        }
    }
	
	// Variablenprofile erstellen
    private function CreateVarProfile($Name, $ProfileType, $Suffix, $MinValue, $MaxValue, $StepSize, $Digits, $Icon, $Asscociations = '')
    {
        if (!IPS_VariableProfileExists($Name)) {
            IPS_CreateVariableProfile($Name, $ProfileType);
            IPS_SetVariableProfileText($Name, '', $Suffix);
            IPS_SetVariableProfileValues($Name, $MinValue, $MaxValue, $StepSize);
            IPS_SetVariableProfileDigits($Name, $Digits);
            IPS_SetVariableProfileIcon($Name, $Icon);
            if ($Asscociations != '') {
                foreach ($Asscociations as $a) {
                    $w = isset($a['Wert']) ? $a['Wert'] : '';
                    $n = isset($a['Name']) ? $a['Name'] : '';
                    $i = isset($a['Icon']) ? $a['Icon'] : '';
                    $f = isset($a['Farbe']) ? $a['Farbe'] : 0;
                    IPS_SetVariableProfileAssociation($Name, $w, $n, $i, $f);
                }
            }
        }
    }
	
	     public function Debug() {
			 $DebugDeviceAddress = $this->ReadPropertyString('DebugDeviceAddress');
			 
			 $ping = Sys_Ping("$DebugDeviceAddress",1000); 
             if ($ping == true) 
             { 
                $host = gethostbyaddr($DebugDeviceAddress);
                $output = shell_exec("arp -a $DebugDeviceAddress");
				
                echo "IP: $DebugDeviceAddress -- Hostname: $host \n";
				echo "Mac: $output \n";
             }
             else 
             { 
               echo "IP: $DebugDeviceAddress --> nicht erreichbar \n"; 
             } 
		 }

         public function UpdateData() {
		   $device1 = $this->ReadPropertyString('device1');
		   $macaddress1 = $this->ReadPropertyString('macaddress1');
		   
		   $ping = Sys_Ping("$device1",10); 
           if ($ping == true) 
            { 
              $host = gethostbyaddr($adr); 
              $output = shell_exec("arp -a $device1");
              if(strpos($output,$macaddress1)!==false) {
                 SetValueBoolean(19658 /*Andreas Zuhause (Haus\Übersicht\Test\TestNetzwerkSuche)*/, true);
              }
            }
            else 
            { 
                SetValueBoolean(19658 /*Andreas Zuhause (Haus\Übersicht\Test\TestNetzwerkSuche)*/, false);
            } 
		}
		 
				
}