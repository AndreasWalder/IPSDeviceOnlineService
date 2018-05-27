<?php

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
		
		$this->RegisterTimer('DebugDevice', 0, 'DeviceDebug(' . $this->InstanceID . ');');
		$this->RegisterPropertyString('DebugDevice', '');
    }

    public function ApplyChanges()
    {
        parent::ApplyChanges();

        $device1 = $this->ReadPropertyString('device1');
        $user1 = $this->ReadPropertyString('user1');
        $macaddress1 = $this->ReadPropertyString('macaddress1');
        $active1 = $this->ReadPropertyBoolean('active1');
		$device1 = $this->ReadPropertyString('device2');
        $user1 = $this->ReadPropertyString('user2');
        $macaddress1 = $this->ReadPropertyString('macaddress2');
        $active1 = $this->ReadPropertyBoolean('active2');
		$device1 = $this->ReadPropertyString('device3');
        $user1 = $this->ReadPropertyString('user3');
        $macaddress1 = $this->ReadPropertyString('macaddress3');
        $active1 = $this->ReadPropertyBoolean('active3');
		$device1 = $this->ReadPropertyString('device4');
        $user1 = $this->ReadPropertyString('user4');
        $macaddress1 = $this->ReadPropertyString('macaddress4');
        $active1 = $this->ReadPropertyBoolean('active4');
		
		$DebugDeviceName = $this->ReadPropertyString('DebugDeviceName');

        if ($device1 != '' && $user1 != '') {
            $ok1 = true;
            if ($device1 == '') {
                echo 'no value for property "device1"';
                $ok1 = false;
            }
            if ($user1 == '') {
                echo 'no value for property "user1"';
                $ok1 = false;
            }
            $this->SetStatus($ok ? 102 : 201);
        } else {
            $this->SetStatus(104);
        }
    }

    public function DebugDevice()
    {
            echo 'DebugDevice true';
            $this->SetStatus(102);
    }
}
