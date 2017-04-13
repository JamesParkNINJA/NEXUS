<?
/*
#    This program is free software; you can redistribute it and/or
#    modify it under the terms of the GNU General Public License
#    as published by the Free Software Foundation; either version 2
#    of the License, or (at your option) any later version.
#
#    This program is distributed in the hope that it will be useful,
#    but WITHOUT ANY WARRANTY; without even the implied warranty of
#    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#    GNU General Public License for more details.
#    http://www.gnu.org/licenses/gpl.txt
#
/*

/*** types of key ***/
define ( 'XMLSEC_AES', 1  );
define ( 'XMLSEC_DES', 2  );

define ('XMLSEC_PRIV_PEM', 8);
define ('XMLSEC_PRIV_DER', 9);

define ('XMLSEC_PUB_PEM', 10);
define ('XMLSEC_PUB_DER', 11);

define ('XMLSEC_PKCS_DER', 20);
define ('XMLSEC_PKCS_PEM', 21);

define ('XMLSEC_ROOT_CA_PEM', 31);
define ('XMLSEC_ROOT_CA_DER',32 );

define ('XMLSEC_UNTRAST_CA_DER', 33 );
define ('XMLSEC_UNTRAST_CA_DER', 34 );

define ('XMLSEC_PUB_CERT_PEM', 40);
define ('XMLSEC_PUB_CERT_DER', 41);

/*** types of symmetric algorithm  ***/
define ( 'XMLSEC_AES_128','aes128-cbc'  );
define ( 'XMLSEC_AES_256','aes256-cbc'  );
define ( 'XMLSEC_AES_192','aes192-cbc'  );
define ( 'XMLSEC_DES_128','des128-cbc'  );
define ( 'XMLSEC_DES_256','des256-cbc'  );
define ( 'XMLSEC_3DES','tripledes-cbc'  );

/*** types of dsignature algorithm  ***/
define ( 'XMLSEC_DSA_SHA1','dsa-sha1'  );
define ( 'XMLSEC_RSA_SHA1','rsa-sha1'  );

/*** key Info  ***/
define ( 'XMLSEC_X509DATA','X509Data'  );

define ( 'XMLSEC_X509CERTIFICATE', 'X509Certificate');


 /******
 *
 * class xmlsec - encrypt and decrypt data, design and verify xml data
 *               requried the installing libxmlsec from http://www.aleksey.com/xmlsec
 *
 * @author   Alexandr M. Kalendarev <akalend@mail.ru>
 *
 * @access   public
 * @version  1.0
 * @package  cryptography.xml.xmlsec
 *
 ******/
class xmlsec
{
  /*****
   * the full name of the xml keyfile
  *****/
  var $xmlkeyfilename = 'keys.xml';

  var $errorMsg = '';
  var $cmd;
  var $unlink = true;
 var $temp_path = '';

  /******
  *  xmlsec constructor
  *
  *   @parametr $xmlkeyfilename  - the full name of the xml keyfile or
  *                               default "keys.xml" in the current directory
  *   @parametr $temp_path  - set writeable directory for temp files
  *   @parametr $unlink          - unlink temp files if true (default) for debugging mode  
  *
  ******/
  function  xmlsec( $xmlkeyfilename ='' , $temp_path = '', $unlink = true)
  {
       if ( $xmlkeyfilename !='' )
           $this->xmlkeyfilename = $xmlkeyfilename;
       $this->unlink = $unlink;
       
       if ($temp_path != '') $this->temp_path = $temp_path;
       
  }


  /******
  *   addkey -  add key info into xml keyfile.
  *
  *   @parametr $keyfilename - the name of keyfile
  *   @parametr $keyname -  the name of key
  *   @parametr constant $type -  the type of keyfile
  *   @parametr $cafiles - array of ca filenames: array( ca1_filename, ca2_filename)
  ******/
  function  addkey( $keyfilename , $keyname, $type , $cafiles = null )
  {

  /*
   if (!file_exists( $keyfilename )) {
     $this->errorMsg = "the keyfile $keyfilename d't exist";
     return false;
   }
*/
/*
   if ( $keyname == '' ){
     $this->errorMsg = "the keyname is null string";
     return false;
   }
*/
   if (!preg_match("/^([\w_-])+$/", $keyname ) ){
     $this->errorMsg = "the keyname must the alpabetic and numeric string";
     return false;
   }

   $str_cafiles = '';
   $keytype = '';
   if ( $type ==  XMLSEC_AES )
        $keytype = '--aeskey:'.$keyname;
   if ( $type ==  XMLSEC_DES )
        $keytype = '--deskey:'.$keyname;

   if ( $type ==  XMLSEC_PRIV_PEM ){
          $keytype = '--privkey-pem:'.$keyname;
          if ( is_array($cafiles) )
              $str_cafiles = ','.implode(',', $cafiles );
   }

   if ( $type ==  XMLSEC_PRIV_DER ){
          $keytype = '--privkey-der:'.$keyname;
          if ( is_array($cafiles) )
              $str_cafiles = ','.implode(',', $cafiles );
   }

   if ( $type ==  XMLSEC_PKCS_PEM ){
          $keytype = '--pkcs-pem:'.$keyname;
          if ( is_array($cafiles) )
              $str_cafiles = ','.implode(',', $cafiles );
   }

   if ( $type ==  XMLSEC_PKCS_DER ){
          $keytype = '--pkcs8-der:'.$keyname;
          if ( is_array($cafiles) )
              $str_cafiles = ','.implode(',', $cafiles );
   }

   if ( $type ==  XMLSEC_PUB_PEM ){
          $keytype = '--pubkey-pem:'.$keyname;
   }


   if ( $type ==  XMLSEC_ROOT_CA_DER ){
          $keytype = '--trusted-der';
   }

   if ( $type ==  XMLSEC_ROOT_CA_PEM ){
          $keytype = '--trusted-pem';
   }

   if ( $type ==  XMLSEC_UNTRAST_CA_DER ){
          $keytype = '--untrusted-der' ;
   }

   if ( $type ==  XMLSEC_UNTRAST_CA_PEM ){
          $keytype = '--untrusted-pem' ;
   }

   if ( $type ==  XMLSEC_PUB_CERT_PEM ){
          $keytype = '--pubkey-cert-pem:'.$keyname;
   }

   if ( $type ==  XMLSEC_PUB_CERT_DER ){
          $keytype = '--pubkey-cert-der:'.$keyname;
   }

   if ($keytype == ''){
     $this->errorMsg = "undefine type of key";
     return false;
   }

   $keysfile = '';
   if (file_exists( $this->xmlkeyfilename )) {
      $keysfile = ' --keys-file '.$this->xmlkeyfilename;
   }

   $cmd = "xmlsec1 keys $keytype $keyfilename"."$str_cafiles  $keysfile  $this->xmlkeyfilename 2>&1";
   $this->cmd =$cmd;
//   die($cmd);
   $res = $this->exec( $cmd);
   $this->errorMsg = $res ;
   
    return;

  }

  /*****
  *  internal function
  *  set temp path for temp files
  *****/
  function setPath()
  {
    if ( $this->temp_path != '') return true;
    
     $temp_path =  getenv ( 'TMPDIR');
     if ( !isset($temp_path) or  $temp_path == '' )
          $temp_path =  getenv ( 'TMP');

     if( isset($temp_path))
          $this->temp_path = $temp_path;
     else{
         $this->errorMsg = "can't define temp path";
         return false;
    }

    return true;
  }

  /*****
  *  internal function
  *  save dom xml into  temp file
  *****/
  function saveXml( &$dom , $prefix )
  {

     $tmpfname = tempnam($this->temp_path  , $prefix );

     if (!is_writable($tmpfname)) {
         $this->errorMsg = "the file $tmpfname d't writable";
         return false;
     }

     $f = fopen( $tmpfname , 'w' );
     if( !f){
         $this->errorMsg = "can't create temp file ".$tmpfname;
         return false;
     }

    $xmlstr = $dom->dump_mem(true);

//    $doc->dump_file("/tmp/test.xml", false, true);

    if (fwrite( $f, $xmlstr ) === FALSE) {
         $this->errorMsg = "can't write template file";
         fclose( $f);
         return false;
    }

    fclose( $f);

    return $tmpfname;

  }

  /*****
  *  internal function
  *  execute command
  *****/
  function exec(  )
  {
    $p = popen( $this->cmd, 'r');
    $read = fread($p , 4096);
    pclose($p);

    return $read;
  }


  /******
  *  encrypt data
  *  make template for encryption
  *
  *  <EncryptedData xmlns="http://www.w3.org/2001/04/xmlenc#">
  *    <EncryptionMethod Algorithm="http://www.w3.org/2001/04/xmlenc#aes128-cbc" />
  *    <KeyInfo xmlns="http://www.w3.org/2000/09/xmldsig#">
  *      <KeyName />
  *    </KeyInfo>
  *    <CipherData>
  *        <CipherValue />
  *    </CipherData>
  *  </EncryptedData>
  *
  *   @parametr $xmldoc - input dom document for encryption
  *   @parametr constant $type -  the type of encryption algorithm
  *
  *   @return true - success and for false see $this->errorMsg
  *
  ******/
  function  encrypt( &$xmldoc ,  $type='')
  {

     $xmldoctpl = domxml_new_doc("1.0"  );

//     $root = $xmldoctpl->add_root("EncryptedData");



//     $root = $xmldoctpl->create_element_ns ( "http://www.w3.org/2001/04/xmlenc#", 'EncryptedData'  );
     $root = $xmldoctpl->create_element (  'EncryptedData' );
     $root->set_attribute("xmlns", "http://www.w3.org/2001/04/xmlenc#");

     $xmldoctpl->append_child($root);
 //    $xmlstr = $xmldoctpl->dump_mem(true);

     $EncryptionMethod = $xmldoctpl->create_element ( 'EncryptionMethod' );


     if ( $type==''){
         $this->errorMsg = "the algorithm don't assigned";
         return false;
     }

     $aldorithm = '';

     if ( $type == XMLSEC_AES_128 )
            $aldorithm = 'http://www.w3.org/2001/04/xmlenc#'. XMLSEC_AES_128;

     if ( $type == XMLSEC_AES_256 )
            $aldorithm = 'http://www.w3.org/2001/04/xmlenc#'.XMLSEC_AES_256;

     if ( $type == XMLSEC_AES_192 )
            $aldorithm = 'http://www.w3.org/2001/04/xmlenc#'.XMLSEC_AES_192;

     if ( $type == XMLSEC_DES_128 )
            $aldorithm = 'http://www.w3.org/2001/04/xmlenc#'.XMLSEC_DES_128;

     if ( $type == XMLSEC_DES_256 )
            $aldorithm = 'http://www.w3.org/2001/04/xmlenc#'.XMLSEC_DES_256;

     if ( $type == XMLSEC_3DES )
            $aldorithm = 'http://www.w3.org/2001/04/xmlenc#'.XMLSEC_3DES;

     if ( $aldorithm == ''){
         $this->errorMsg = "the algorithm don't assigned";
         return false;
     }

     $EncryptionMethod->set_attribute("Algorithm", $aldorithm);
     $root->append_child( $EncryptionMethod );


//     $KeyInfo = $xmldoctpl->create_element_ns ( "http://www.w3.org/2000/09/xmldsig#", 'KeyInfo' ,'ds');
      $KeyInfo = $xmldoctpl->create_element ( 'KeyInfo' );
      $KeyInfo->set_attribute("xmlns", "http://www.w3.org/2000/09/xmldsig#");

     $root->append_child( $KeyInfo );


     $KeyName = $xmldoctpl->create_element(  'KeyName'  );
     $KeyInfo->append_child( $KeyName );

     $CipherData = $xmldoctpl->create_element( "CipherData" );
     $root->append_child( $CipherData );
     $CipherValue = $xmldoctpl->create_element( "CipherValue" );
     $CipherData->append_child( $CipherValue );

     if ( !$this->setPath() ) return false;

     $tmpfname = $this->saveXml( $xmldoctpl , "tmpl");
     if( !$tmpfname  )  return false;


     if( isset($this->temp_path))
          $outputName = tempnam($this->temp_path  , "out");
     else{
         $this->errorMsg = "can't define temp path";
         return false;
    }

     $inputName = $this->saveXml( $xmldoc , "in" );
     if( !$inputName )  return false;


    $keyfile = $this->xmlkeyfilename;
    $cmd = "xmlsec1 encrypt --output $outputName --binary-data  $inputName --keys-file $keyfile $tmpfname 2>&1";
    $this->cmd = $cmd ; // for debugging

    $this->exec();
    $outDocument = file_get_contents($outputName);

    if ( $this->unlink and !unlink($outputName)){
         $this->errorMsg = "can't unlink data file ".$outputName;
         return false;
     }

    if ( $this->unlink and !unlink($inputName)){
         $this->errorMsg = "can't unlink data file ".$inputName;
         return false;
     }

    if ( $this->unlink and !unlink($tmpfname)){
         $this->errorMsg = "can't unlink data file ".$tmpfname;
         return false;
     }

     if ( $outDocument == '' ){
         $this->errorMsg = "the error in the crypto conversion ";
         $this->errorMsg .= "\n ".$read;
         return false;
     }


//    print_r( $retArr);
//    print "\ncode:". $retCode;

   return $outDocument;

  }

  /******
  *  decrypt data
  *
  *  @parametr $xmldoc - input dom document for decryption
  *
  *  @return xml string if success and for false see $this->errorMsg
  *
  ******/
  function  decrypt( &$xmldoc )
  {
     if ( !$this->setPath() )
           return false;

     $inputName = $this->saveXml( $xmldoc , "in" );
     if( !$inputName )  return false;

     if( isset($this->temp_path))
          $outputName = tempnam($this->temp_path  , "out");
     else{
         $this->errorMsg = "can't define temp path";
         return false;
    }

    $keyfile = $this->xmlkeyfilename;
    $cmd = "xmlsec1>$outputName decrypt --keys-file $keyfile $inputName 2>&1";

    // #xmlsec>output.txt decrypt --keys-file deskey.xml decrypt.xml

    $this->cmd = $cmd;
    $this->exec();
    $outDocument = file_get_contents($outputName);

    if ( $this->unlink and !unlink($outputName)){
         $this->errorMsg = "can't unlink data file ".$outputName;
         return false;
     }

    if ( $this->unlink and !unlink($inputName)){
         $this->errorMsg = "can't unlink data file ".$inputName;
         return false;
     }


     return $outDocument;

  }

  /****
  *  sign xml data
  *  make template for signature

    <Signature xmlns="http://www.w3.org/2000/09/xmldsig#">
    <SignedInfo>
      <CanonicalizationMethod Algorithm="http://www.w3.org/TR/2001/REC-xml-c14n-20010315" />
      <SignatureMethod Algorithm="http://www.w3.org/2000/09/xmldsig#rsa-sha1" />
      <Reference URI="">
        <Transforms>
          <Transform Algorithm="http://www.w3.org/2000/09/xmldsig#enveloped-signature" />
        </Transforms>
        <DigestMethod Algorithm="http://www.w3.org/2000/09/xmldsig#sha1" />
        <DigestValue></DigestValue>
      </Reference>
    </SignedInfo>
    <SignatureValue/>
    <KeyInfo>
        <KeyName/>
    </KeyInfo>
  </Signature>

  *
  *   @parametr $xmldoc - input dom document for encryption
  *   @parametr constant $type -  the type of digital signature algorithm
  *   @parametr  $keyInfo - array of keyinfo information , for example XMLSEC_X509DATA make tag <X509Data>
  
  *   @return true - success and for false see $this->errorMsg
  *
  **/
  function sign($xmldoc, $type , $keyInfoArr =null)
  {

     $root = $xmldoc->document_element();

     $rootDs = $xmldoc->create_element (  'Signature' );
     $rootDs->set_attribute("xmlns", "http://www.w3.org/2000/09/xmldsig#");

     $root->append_child($rootDs);

     $SignedInfo = $xmldoc->create_element ( 'SignedInfo' );
     $rootDs->append_child($SignedInfo);

     $SignatureValue  = $xmldoc->create_element ( 'SignatureValue' );
     $rootDs->append_child($SignatureValue);

     $KeyInfo = $xmldoc->create_element ( 'KeyInfo' );
     $rootDs->append_child($KeyInfo);
         $KeyName = $xmldoc->create_element ( 'KeyName' );
         $KeyInfo ->append_child($KeyName);
	 
	 if (  $keyInfoArr != null  && is_array($keyInfoArr)  )
	 {
	     foreach( $keyInfoArr as $keyInfoEl => $keyInfoE2 ){
	           $el = '';
		   if ($keyInfoEl  == XMLSEC_X509DATA )
	     		$el = XMLSEC_X509DATA;
		   if ($el == '') continue;
	
	              $el2 = '';
		  if ($keyInfoE2  == XMLSEC_X509CERTIFICATE )
	     		$el2 = XMLSEC_X509CERTIFICATE;
		   if ($el2 == '') continue;
		   
		   $elDom = $xmldoc->create_element ( $el );
		   $el2Dom = $xmldoc->create_element ( $el2 );
		   
		   $elDom ->append_child($el2Dom );
		   $KeyInfo ->append_child($elDom);
	     }
	 }

     $CanonicalizationMethod = $xmldoc->create_element ( 'CanonicalizationMethod' );
     $CanonicalizationMethod -> set_attribute("Algorithm", "http://www.w3.org/TR/2001/REC-xml-c14n-20010315");
     $SignedInfo -> append_child($CanonicalizationMethod);

     $SignatureMethod  = $xmldoc->create_element ( 'SignatureMethod' );

     $algorithm = '';
     if ($type == XMLSEC_DSA_SHA1 )
          $algorithm = 'http://www.w3.org/2000/09/xmldsig#'.XMLSEC_DSA_SHA1;
     if ($type == XMLSEC_RSA_SHA1 )
          $algorithm = 'http://www.w3.org/2000/09/xmldsig#'.XMLSEC_RSA_SHA1;
     if ( $algorithm == ''){
           $this->errorMsg = "undefinit algorithm type:  ".$type;
            return false;
     }

     $SignatureMethod  -> set_attribute("Algorithm", $algorithm );
     $SignedInfo -> append_child($SignatureMethod );

     $Reference  = $xmldoc->create_element ( 'Reference' );
     $Reference  -> set_attribute("URI", "");
     $SignedInfo -> append_child($Reference );


     $Transforms = $xmldoc->create_element ( 'Transforms' );
     $Reference -> append_child($Transforms);

     $Transform = $xmldoc->create_element ( 'Transform' );
     $Transform  -> set_attribute("Algorithm", 'http://www.w3.org/2000/09/xmldsig#enveloped-signature' );
     $Transforms-> append_child($Transform);


     $DigestMethod  = $xmldoc->create_element ( 'DigestMethod' );



     $DigestMethod  -> set_attribute("Algorithm", 'http://www.w3.org/2000/09/xmldsig#sha1' );
     $Reference -> append_child($DigestMethod );

     $DigestValue  = $xmldoc->create_element ( 'DigestValue' );
     $Reference -> append_child($DigestValue );

     if ( !$this->setPath() ) return false;

     $tmplName = $this->saveXml( $xmldoc , "in" );
     if( !$tmplName)  return false;

     if( isset($this->temp_path))
          $outputName = tempnam($this->temp_path  , "out");
     else {
         $this->errorMsg = "can't define temp path";
         return false;
     }

    $keyfile = $this->xmlkeyfilename;
    $cmd = "xmlsec1 sign  --output $outputName  --keys-file  $keyfile $tmplName 2>&1";
    $this->cmd = $cmd ; // for debugging


    $this->exec();
    $outDocument = file_get_contents($outputName);

    if ( $this->unlink and !unlink($outputName)){
         $this->errorMsg = "can't unlink data file ".$outputName;
         return false;
     }

    if ( $this->unlink and !unlink($tmplName)){
         $this->errorMsg = "can't unlink data file ".$tmplName;
         return false;
     }

     if ( $outDocument == '' ){
         $this->errorMsg = "the error in the crypto conversion ";
         $this->errorMsg .= "\n ".$read;
         return false;
     }

     return $outDocument;

  }   // end sign()


  /******
  *  verify data
  *
  *  @parametr $xmldoc - input signed dom document
  *  @parametr $cert - name of certificate file, default null string, d't using  certificate
  *
  *  @return verify result if success and for false see $this->errorMsg
  *
  ******/
  function verify( &$xmldoc , $cert ='')
  {
    if ( !$this->setPath() )
           return false;

     $inputName = $this->saveXml( $xmldoc , "in" );
     if( !$inputName )  return false;

    $keyfile = $this->xmlkeyfilename;

   if ( $cert =='')
    $cmd = "xmlsec1 verify --ignore-manifests --keys-file $keyfile $inputName 2>&1";
else
    $cmd = "xmlsec1 verify --ignore-manifests  --trusted-pem  $cert $inputName 2>&1";
    
    
    $this->cmd = $cmd;

    $res = $this->exec();

    if ( $this->unlink and !unlink($inputName)){
         $this->errorMsg = "can't unlink data file ".$inputName;
         return false;
     }

     if ( trim($res)  =='OK') return true;
     $this->errorMsg = $res;
     return false;

  } // end verify()


}  // end class


?>