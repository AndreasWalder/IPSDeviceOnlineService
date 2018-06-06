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



class IPSDeviceOnlineService extends IPSModule
 {
	// Wird beim Setup vom Modul aufgerufen (ganz am Anfang)
    public function Create()
    {
		
        parent::Create();
		
		//Erstellen von Verlinkungen zum Modul
        $this->RegisterPropertyString('device1', '');
        $this->RegisterPropertyString('user1', '');
        $this->RegisterPropertyString('macaddress1', '');
		$this->RegisterPropertyString('hostname1', '');
		$this->RegisterPropertyInteger('dhcpType1', 0);	
        $this->RegisterPropertyBoolean('active1', 'false');
		
		$this->RegisterPropertyString('device2', '');
        $this->RegisterPropertyString('user2', '');
        $this->RegisterPropertyString('macaddress2', '');
		$this->RegisterPropertyString('hostname2', '');
		$this->RegisterPropertyInteger('dhcpType2', 0);	
        $this->RegisterPropertyBoolean('active2', 'false');
		
		$this->RegisterPropertyString('device3', '');
        $this->RegisterPropertyString('user3', '');
        $this->RegisterPropertyString('macaddress3', '');
		$this->RegisterPropertyString('hostname3', '');
		$this->RegisterPropertyInteger('dhcpType3', 0);	
        $this->RegisterPropertyBoolean('active3', 'false');
		
		$this->RegisterPropertyString('device4', '');
        $this->RegisterPropertyString('user4', '');
        $this->RegisterPropertyString('macaddress4', '');
		$this->RegisterPropertyString('hostname4', '');
		$this->RegisterPropertyInteger('dhcpType4', 0);	
        $this->RegisterPropertyBoolean('active4', 'false');
		
		$this->RegisterPropertyString('DebugDeviceAddress', '');
		
		$this->RegisterPropertyInteger("UpdateInterval", 5);
		$this->RegisterPropertyString("DebugMacAddress", '');
		$this->RegisterPropertyString("DebugHostname", '');
		
		//Timer erstellen und zum durchreichen der Schaltflächen im Modul 
		$this->RegisterTimer("Update", $this->ReadPropertyInteger("UpdateInterval"), 'IPSDOS_UpdateData($_IPS[\'TARGET\']);');
		$this->RegisterTimer("Debug", 0, 'IPSDOS_Debug($_IPS[\'TARGET\']);');
		
		//Erstellen eines Variablenprofile für Typ Integer
		$associations = [];
        $associations[] = ['Wert' => 1, 'Name' => 'Anwesend'];
        $associations[] = ['Wert' => 0, 'Name' => 'Abwesend'];
        $this->CreateVarProfile('IPSDOS.Status', IPS_INTEGER, '', 0, 0, 0, 1, 'Heart', $associations);
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
		
    // Wird aufgerufen wenn im Modul was verändert wird
    public function ApplyChanges()
    {
        parent::ApplyChanges();
		
		//Werte der Variablen laden
        $device1 = $this->ReadPropertyString('device1');
        $user1 = $this->ReadPropertyString('user1');
        $macaddress1 = $this->ReadPropertyString('macaddress1');
		$hostname1 = $this->ReadPropertyString('hostname1');
        $active1 = $this->ReadPropertyBoolean('active1');
		$device2 = $this->ReadPropertyString('device2');
        $user2 = $this->ReadPropertyString('user2');
        $macaddress2 = $this->ReadPropertyString('macaddress2');
		$hostname2 = $this->ReadPropertyString('hostname2');
        $active2 = $this->ReadPropertyBoolean('active2');
		$device3 = $this->ReadPropertyString('device3');
        $user3 = $this->ReadPropertyString('user3');
        $macaddress3 = $this->ReadPropertyString('macaddress3');
		$hostname3 = $this->ReadPropertyString('hostname3');
        $active3 = $this->ReadPropertyBoolean('active3');
		$device4 = $this->ReadPropertyString('device4');
        $user4 = $this->ReadPropertyString('user4');
        $macaddress4 = $this->ReadPropertyString('macaddress4');
		$hostname4 = $this->ReadPropertyString('hostname4');
        $active4 = $this->ReadPropertyBoolean('active4');
		
		$DebugDeviceAddress = $this->ReadPropertyString('DebugDeviceAddress');
		$DebugHostname = $this->ReadPropertyString('DebugHostname');
		
		//Timer Interval setzen für Update Function
		$this->SetTimerInterval("Update", $this->ReadPropertyInteger("UpdateInterval")*1000*60);

		$ok1 = false;	
		$dhcpType1 = $this->ReadPropertyInteger('dhcpType1'); //1-DHCP, 0-statisch
	   if ($dhcpType1 == 0) {		
		// Instanz Status setzen (aktiv -> inaktiv)
		if ($device1 != '' && $user1 != '' && ($macaddress1 != '' ||	$hostname1 != '')) {			
			   // Zeigt Info neben der Instanz
			   $this->SetSummary("Status statisch - OK");			   
               $ok1 = true;		
               // setzt Instanz Status auf aktiv			   
               $this->SetStatus(102);	   
        } 
		else {
			 $this->SetSummary("Fehler");
			 $ok1 = false;		 
             $this->SetStatus(104);
        }
	  }
	  
	  
	  
	  if ($dhcpType1 == 0) { //0-DHCP, 1-statisch
		  if ($user1 != '' && $hostname1 != '') {			
			   // Zeigt Info neben der Instanz
			   $this->SetSummary("Status DHCP - OK");
			   
               $ok1 = true;		
               // setzt Instanz Status auf aktiv			   
               $this->SetStatus(102);	   
        } 
		else {
			 $this->SetSummary("Fehler");
			 $ok1 = false;		 
             $this->SetStatus(104);
        }
	   }
	   
	  
		if ($ok1 == true)
	  {	
	   
	   
		// Variable anlegen im Ipsymcon vom Typ Integer und vom Profil IPSDOS.Status wenn $ok1 true (Module IO) ist
		$this->MaintainVariable("user1Active", $user1, IPS_INTEGER, "IPSDOS.Status", 0, $ok1);
		$this->LoggingEnable($user1); //Logging für diese Variable einschalten
				
		// ab dem Device2 nur noch Variable löschen wenn nicht alles ausgefüllt Instanz bleibt aktiv
		if ($device2 != '' && $user2 != '' && $macaddress2 != '') {
          $this->MaintainVariable("user2Active", $user2, IPS_INTEGER, "IPSDOS.Status", 0, true);        
		  $this->LoggingEnable($user2);	//Logging für diese Variable einschalten
        } 
		else {
			$this->MaintainVariable("user2Active", $user2, IPS_INTEGER, "IPSDOS.Status", 0, false); 
        }
		
		//..
		if ($device3 != '' && $user3 != '' && $macaddress3 != '') {
          $this->MaintainVariable("user3Active", $user3, IPS_INTEGER, "IPSDOS.Status", 0, true);   
          $this->LoggingEnable($user3);	//Logging für diese Variable einschalten
        } 
		else {
			$this->MaintainVariable("user3Active", $user3, IPS_INTEGER, "IPSDOS.Status", 0, false); 
        }
		
		//..
		if ($device4 != '' && $user4 != '' && $macaddress4 != '') {
          $this->MaintainVariable("user4Active", $user4, IPS_INTEGER, "IPSDOS.Status", 0, true);
          $this->LoggingEnable($user4);	//Logging für diese Variable einschalten  		  
        } 
		else {
			$this->MaintainVariable("user4Active", $user4, IPS_INTEGER, "IPSDOS.Status", 0, false); 
        }
	  }
	 }
	 
	
	
	     public function Debug() {
			 // Zum herausfinden der Mac Adresse für die Geräte Zuordnung
			 $DebugDeviceAddress = $this->ReadPropertyString('DebugDeviceAddress');
			 $DebugHostname = $this->ReadPropertyString('DebugHostname');
			 
			
			 if ($DebugDeviceAddress == '') {
				 $this->ShowMacAdresse('');
				 return;
			 }				 
			 
			 $ping = Sys_Ping("$DebugDeviceAddress",1000); 
             if ($ping == true) 
             { 
                $host = gethostbyaddr($DebugDeviceAddress);
				$this->ShowHostname($host);
                $output = shell_exec("arp -a $DebugDeviceAddress");
				
				$lines=explode("\n", $output);
                #look for the output line describing our IP address
				$macAddr="";
                foreach($lines as $line)
                 {
                   $cols=preg_split('/\s+/', trim($line));
                   if ($cols[0]==$DebugDeviceAddress)
                     {
                       $macAddr=$cols[1];
					   $this->ShowMacAdresse($macAddr);
                     }
                 }
				 
				echo "IP: $DebugDeviceAddress -- Hostname: $host \n";
				
				if ($macAddr != "") {
					echo "Mac: $macAddr \n";
				}
				else{
					echo "keine MacAdresse bitte Hostname verwenden! \n";
				}
				
				
				
				echo "\n";
				echo "Bitte Instanz (Modul) kurz schließen und wieder öffnen, dann wird \n";
				echo "die MAC-Adresse im Feld <Angezeigte Adresse> angezeigt ;-)\n";
				echo "und kann kopiert werden (Strg-C).\n";
             }
             else 
             { 
               echo "IP: $DebugDeviceAddress --> nicht erreichbar \n"; 
			   $macAddr = '';
			   $this->ShowMacAdresse($macAddr);
             }
		}
		
		private function LoggingEnable($LoggingVariableName) {
			//  Archive Control finden
            foreach (IPS_GetInstanceListByModuleType(0) as $modul)
            {
              $archive_id = false;
              $instance = IPS_GetInstance($modul);
                if ($instance['ModuleInfo']['ModuleName'] == "Archive Control"){
	              $archive_id = $modul;
	              break;
                }
            }
		    //Logging für diese Variable einschalten
		    if ($archive_id) //wenn Archive Control gefunden
            {
	          $InstanzId = $this->GetInstanzId(); // Instanz ID herausfinden
	          $VariablenID = @IPS_GetVariableIDByName($LoggingVariableName, $InstanzId); // VariableID suchen nach Variable NAME	
		      AC_SetLoggingStatus($archive_id,  $VariablenID, True); // Logging einschalten für die Variable nach ID
		      IPS_ApplyChanges($archive_id /*[Archive]*/); // Änderung in Modul Archive übernehmen
		    }			
			
		}
		
		
		private function GetInstanzId() {
		  $guid = "{8C110C1C-F011-4C65-925D-6FEE0D8F1A11}";
          // schauen ob es die Instanz gibt
          if (IPS_GetInstanceListByModuleID($guid)[0] != '') {
           $InstanzId = IPS_GetInstanceListByModuleID($guid)[0];
           }
		 return $InstanzId;
	    }
		
		private function ShowMacAdresse($setPropertyNameMac) {
		           $InstanzId = $this->GetInstanzId();
                   If ($InstanzId) {
                   IPS_SetProperty($InstanzId, "DebugMacAddress", $setPropertyNameMac); //neuen Wert setzen
				   IPS_ApplyChanges($InstanzId); //neuen Wert übernehmen
                   //echo $InstanzId;
				   }			
		}
		
		private function ShowHostname($setPropertyHostname) {
		           $InstanzId = $this->GetInstanzId();
                   If ($InstanzId) {
                   IPS_SetProperty($InstanzId, "DebugHostname", $setPropertyHostname); //neuen Wert setzen
				   IPS_ApplyChanges($InstanzId); //neuen Wert übernehmen
                   //echo $InstanzId;
				   }			
		}
		

         public function UpdateData() {
			 
		  for ($x = 0; $x <= 5; $x++) {

		  
				   //Function für Device 1:
				   $active1 = $this->ReadPropertyBoolean('active1');
				   if ($active1 == true) {
					   
					 $device1 = $this->ReadPropertyString('device1');
					 $macaddress1 = $this->ReadPropertyString('macaddress1');
					 $user1 = $this->ReadPropertyString('user1');
					 $hostname1 = $this->ReadPropertyString('hostname1');
					 $dhcpType1 = $this->ReadPropertyInteger('dhcpType1'); //0-DHCP, 1-statisch
					 
					if ($dhcpType1 == 1) {
					 if ($device1 != '' && $user1 != '') {
                      if ($macaddress1 != '' ||	$hostname1 != '') {				 
					  $ping1 = Sys_Ping("$device1",10); 
					  if ($ping1 == true) 
					   { 
			   
						$host1 = gethostbyaddr($device1); 
						$output1 = shell_exec("arp -a $device1");
						 if ($macaddress1 != '') {
						  if(strpos($output1,$macaddress1)!==false) {
						  $this->SetValue('user1Active', true);
						  }
						 }
						 if ($hostname1 != '') {
						  if(strpos($host1,$hostname1)!==false) {
						  $this->SetValue('user1Active', true);
						  }
						 }
						 
					   }
					   else 
					   { 
						 $this->SetValue('user1Active', false);
					   }
					}
				   }
				  }
				  if ($dhcpType1 == 0) {
					if ($hostname1 != '' && $user1 != '') {
					  $ping1 = Sys_Ping("$hostname1",10); 
					  if ($ping1 == true) 
					   { 
						  $this->SetValue('user1Active', true);	 
					   }
					   else 
					   { 
						 $this->SetValue('user1Active', false);
					   }
					}						
				  }
				 }
				 
				 
				  //Function für Device 2:
				   $active2 = $this->ReadPropertyBoolean('active2');
				   if ($active2 == true) {
					   
					 $device2 = $this->ReadPropertyString('device2');
					 $macaddress2 = $this->ReadPropertyString('macaddress2');
					 $user2 = $this->ReadPropertyString('user2');
					 $hostname2 = $this->ReadPropertyString('hostname2');
					 
					 if ($device2 != '' && $user2 != '') {
                      if ($macaddress2 != '' ||	$hostname2 != '') {				 
					  $ping2 = Sys_Ping("$device2",10); 
					  if ($ping2 == true) 
					   { 
			   
						$host2 = gethostbyaddr($device2); 
						$output2 = shell_exec("arp -a $device2");
						 if ($macaddress2 != '') {
						  if(strpos($output2,$macaddress2)!==false) {
						  $this->SetValue('user2Active', true);
						  }
						 }
						 if ($hostname2 != '') {
						  if(strpos($host2,$hostname2)!==false) {
						  $this->SetValue('user2Active', true);
						  }
						 }
						 
					   }
					   else 
					   { 
						 $this->SetValue('user2Active', false);
					   }
					}
				   }
				  }
				
				
				  //Function für Device 3:
				   $active3 = $this->ReadPropertyBoolean('active3');
				   if ($active3 == true) {
					 $device3 = $this->ReadPropertyString('device3');
					 $macaddress3 = $this->ReadPropertyString('macaddress3');
					 $user3 = $this->ReadPropertyString('user3');
					 $hostname3 = $this->ReadPropertyString('hostname3');
					 
					 if ($device3 != '' && $user3 != '' && $macaddress3 != '') {		   
					  $ping3 = Sys_Ping("$device3",10); 
					  if ($ping3 == true) 
					   { 
						$host3 = gethostbyaddr($device3); 
						$output3 = shell_exec("arp -a $device3");
						  if(strpos($output3,$macaddress3)!==false) {
						  $this->SetValue('user3Active', true);
						  }
					   }
					   else 
					   { 
						 $this->SetValue('user3Active', false);
					   }
					}
				  }
				  
				  //Function für Device 4:
				   $active4 = $this->ReadPropertyBoolean('active4');
				   if ($active4 == true) {
					 $device4 = $this->ReadPropertyString('device4');
					 $macaddress4 = $this->ReadPropertyString('macaddress4');
					 $user4 = $this->ReadPropertyString('user4');
					 $hostname4 = $this->ReadPropertyString('hostname4');
					 
					 if ($device4 != '' && $user4 != '' && $macaddress4 != '') {		   
					  $ping4 = Sys_Ping("$device4",10); 
					  if ($ping4 == true) 
					   { 
						$host4 = gethostbyaddr($device4); 
						$output4 = shell_exec("arp -a $device4");
						  if(strpos($output4,$macaddress4)!==false) {
						  $this->SetValue('user4Active', true);
						  }
					   }
					   else 
					   { 
						 $this->SetValue('user4Active', false);
					   }
					}
				  }

		    }
		}
  
				
}