<?php

/**
 * repo: verifyReddCoinAddress
 * validator.class.php
 *
 * Verify a ReddCoin address
 * 
 * @author Leonard Simonse
 * @version 1
 */
 
 class ReddCoinAddressValidator {

	public $addressversion = "3D"; // Reddcoin -> decimal 61 to HEX = 3D

	public function __construct()
    {
	
    }
	
	public function encodeHex($dec)
    {
        $chars="0123456789ABCDEF";
        $return="";
        while (bccomp($dec,0)==1)
        {
            $dv=(string)bcdiv($dec,"16",0);
            $rem=(integer)bcmod($dec,"16");
            $dec=$dv;
            $return=$return.$chars[$rem];
        }
        return strrev($return);
    }

	public function decodeBase58($base58)
    {
        $origbase58=$base58;
       
        $chars="123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz";
        $return="0";
        for($i=0;$i<strlen($base58);$i++)
        {
            $current=(string)strpos($chars,$base58[$i]);
            $return=(string)bcmul($return,"58",0);
            $return=(string)bcadd($return,$current,0);
        }
       
        $return=$this->encodeHex($return);
       
        for($i=0;$i<strlen($origbase58)&&$origbase58[$i]=="1";$i++)
        {
            $return="00".$return;
        }
       
        if(strlen($return)%2!=0)
        {
            $return="0".$return;
        }
       
        return $return;
    }

	public function _checkAddress($addr)
    {
        $addr=$this->decodeBase58($addr);
        if(strlen($addr)!=50)
        {
            return false;
        }
        $version=substr($addr,0,2);
        if(hexdec($version)>hexdec($this->addressversion))
        {
            return false;
        }
        $check=substr($addr,0,strlen($addr)-8);
        $check=pack("H*" , $check);
        $check=strtoupper(hash("sha256",hash("sha256",$check,true)));
        $check=substr($check,0,8);
        return $check==substr($addr,strlen($addr)-8);
    }
	
	public static function checkAddress($addr)
    {
        $obj = new self();
        return $obj->_checkAddress($addr);
    }
}
?>