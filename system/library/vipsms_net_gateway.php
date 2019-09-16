<?php

class VipSMSNetGateway{
  private $_soapCli;
  private $_soapSession;
  private $_err = array();
  private $_login;
  private $_password;
  private $_sign;
  
  const VERSION = '0.10';

  public function __construct($login, $password){
    try{
    $this->_soapCli = @new SoapClient('http://vipsms.net/api/soap.html', array(
      'exceptions'         => 1,
      'connection_timeout' => 5,
      'user_agent'         => 'SOAP/PHP_'.phpversion().'/opencart_'.VERSION.'/mod_'.self::VERSION
    ));
    }catch(SoapFault $ex){
      $this->_soapCli = null;
      die;
    }
    $this->_login    = $login;
    $this->_password = $password;
  }

  public function setSign($sign_name){
    $this->_sign = $sign_name;
  }

  public function testConnection(){
    if (!$this->_auth())
      return false;

    $res = $this->_soapCli->getBalance($this->_soapSession);

    if ($res->code!=0){
      $logger = new Log('vipsms_net.log');
      $logger->write('['.substr(__FILE__, strlen(DIR_SYSTEM)-1)."] Test connection is failed. Details:\n".var_export($res, true));
      $this->_explainSoapProblem($res);
      return false;
    }

    return true;
  }

  public function sendSms($dst_phone, $message){

    if (!$this->_auth())
      return false;

    try{
      $phtools = new PhoneTools();
      $abs_phone = $phtools->identNum($dst_phone, null);
      if (is_null($abs_phone)){
        $this->_err[] = $phtools->getErrorMessage();
        return false;
      }
      $res = $this->_soapCli->sendSmsOne($this->_soapSession, $abs_phone, $this->_sign, $message);
    }catch(SoapFault $ex){
      $this->_err[] = 'Soap send message failed:'.$ex->getMessage();
      return false;
    }

    if ($res->code!=0){
      $logger = new Log('vipsms_net.log');
      $logger->write('['.substr(__FILE__, strlen(DIR_SYSTEM)-1)."] Send SMS is failed. Details:\n".var_export($res, true));

      $this->_explainSoapProblem($res);
      return false;
    }
  }

  public function getErrors($sep="\n"){
    return join($sep, $this->_err);
  }

  private function _auth(){
    if (is_null($this->_soapCli)) return false;
    try{
      $res = $this->_soapCli->auth($this->_login, $this->_password);

    }catch(SoapFault $ex){
      $this->_err[] = 'Soap server connection failed:'.$ex->getMessage();
      return false;
    }

    if ($res->code!=0){
      $this->_err[] = $res->message;
      $this->_explainSoapProblem($res);
    }

    if (!empty($this->_err))
      return false;

    $this->_soapSession = $res->message;

    return true;
  }

  private function _explainSoapProblem($soap_res){
    if ($soap_res->extend && is_array($soap_res->extend)){
      $this->_err[] = var_export($soap_res->extend, true);
    }
    return;
  }

}

class PhoneTools{
  /**
   * Для процедур распознования, в случае неудачи пишем сохраняем ошибочное сообщение
   */
  private $_errString = null;

  private $_phoneCountry = null;

  private $country = array(
    '+380' => array(
      'name'   => 'Украина',   'format' => '+38 (099) 999-99-99',
    ),
    '+7' => array(
      'name'   => 'Россия',    'format' => '+7 (999) 999-99-99',
    ),
    '+375' => array(
      'name'   => 'Белоруссия','format' => '+375 (99) 999-99-99',
    ),
  );

  /**
   *
   * @var array Ассоцияция префиксов к мобильным операторам.
   * Важно. Не менять названия операторов. Используется для переключения шлюза.
   */
  private $operators = array(
    '380' => array(
      '067' => 'kyivstar',
      '097' => 'kyivstar',
      '096' => 'kyivstar',
      '098' => 'kyivstar',
      '050' => 'MTC',
      '066' => 'MTC',
      '095' => 'MTC',
      '099' => 'MTC',
      '063' => 'life:)',
      '093' => 'life:)',
      '068' => 'Beeline',
      '091' => 'Utel',
      '094' => 'Intertelekom',
    ),
    '7' => Array(
      '903' => 'Beeline.ru',
      '905' => 'Beeline.ru',
      '906' => 'Beeline.ru',
      '909' => 'Beeline.ru',
      '910' => 'MTC.ru',
      '911' => 'MTC.ru',
      '912' => 'MTC.ru',
      '913' => 'MTC.ru',
      '914' => 'MTC.ru',
      '915' => 'MTC.ru',
      '916' => 'MTC.ru',
      '917' => 'MTC.ru',
      '918' => 'MTC.ru',
      '919' => 'MTC.ru',
      '920' => 'Megafon',
      '921' => 'Megafon',
      '922' => 'Megafon',
      '923' => 'Megafon',
      '924' => 'Megafon',
      '925' => 'Megafon',
      '926' => 'Megafon',
      '927' => 'Megafon',
      '928' => 'Megafon',
      '929' => 'Megafon',
      '931' => 'Megafon',
      '937' => 'Megafon',
      '960' => 'Beeline.ru',
      '961' => 'Beeline.ru',
      '962' => 'Beeline.ru',
      '963' => 'Beeline.ru',
      '964' => 'Beeline.ru',
      '980' => 'MTC.ru',
      '981' => 'MTC.ru',
      '982' => 'MTC.ru',
      '983' => 'MTC.ru',
      '985' => 'MTC.ru',
      '987' => 'MTC.ru',
      '988' => 'MTC.ru',

    ),
  );

  const OPERATOR_NONAME = 'noname';
  const COUNTRY_DEFAULT = '+380';
  const PREFIX_UA = '380';
  const PREFIX_RU = '7';
  const PREFIX_BY = '375';
  

  public function __construct(){
  }

  /**
   * Пытается распознать номер телефона и определить к какой стране относится номер.
   * @param $phonenum string Номер телефона
   * @param $country string код префикса для страны
   * @return string Номер телефона в международном формате. Номер начинается с "+"
   */
  public function identNum( $phonenum, $country = null){
    $this->_setErrorMessage(null);
    $this->_setPhoneContry(null);
    $is_inter_format = false;
    if (is_null($country) || !$this->existsCountryCode($country) ) $country = self::COUNTRY_DEFAULT;
    if (strpos($country,'+')!==0) $country = '+'.$country;
    if (preg_match('/^\s*\+\s*/', $phonenum)) $is_inter_format = true;
    $clear_num = preg_replace('/[^\d]/', '', $phonenum);
    if ( $is_inter_format ){
      $clear_num = '+'.$clear_num;
      return $this->_identAbsNum($clear_num);
    }else{
      $this->_setPhoneContry($country);
      if ( $country == '+'.self::PREFIX_UA){
        //8067 428 75 88
        if (strlen($clear_num) >= 11 && ( substr($clear_num, -11, 1)=='8')){
          $clear_num = '+'.self::PREFIX_UA.substr($clear_num, -9);
          return $clear_num;
        //067 428 75 88
        }else if (strlen($clear_num) == 10 && strpos($clear_num, '0')===0){
          $clear_num = '+'.self::PREFIX_UA.substr($clear_num, -9);
          return $clear_num;
        }else{
          $this->_setErrorMessage('Не удалось распознать номер для страны Украина');
        }
      }else if ($country == '+'.self::PREFIX_BY){
        if (strlen($clear_num) == 9){
          $clear_num = '+'.self::PREFIX_BY.substr($clear_num, -9);
          return $clear_num;
        }else{
          $this->_setErrorMessage('Не удалось распознать номер для страны Белоруссия');
        }
      }else if ($country == '+'.self::PREFIX_RU){
        if (strlen($clear_num) == 10){
          $clear_num = '+'.self::PREFIX_RU.substr($clear_num, -10);
          return $clear_num;
        }else{
          $this->_setErrorMessage('Не удалось распознать номер для страны Россия');
        }
      }else{
        $this->_setPhoneContry(null);
        $this->_setErrorMessage('Не удалось распознать номер');
      }
    }
    return null;
  }

  private function _identAbsNum( $clear_num ){
    $this->_setPhoneContry(null);
    foreach( array_keys($this->country) as $cprefix ){
      //if (YII_DEBUG) Yii::trace( $cprefix.'='.$clear_num.' = ');
      if (strpos($clear_num, $cprefix)===0){
        $this->_setPhoneContry($cprefix);
        switch( $cprefix ){
          case '+'.self::PREFIX_UA: //+380 GG NNN NN NN
                if (strlen($clear_num)==13) return $clear_num;
                $this->_setErrorMessage('Длина номера не соответствует стандарту страны - '.$this->getNameOfCountry($cprefix));
                return null;
                break;
          case '+'.self::PREFIX_BY:
                if (strlen($clear_num)==13) return $clear_num;
                $this->_setErrorMessage('Длина номера не соответствует стандарту страны - '.$this->getNameOfCountry($cprefix));
                return null;
                break;
          case '+'.self::PREFIX_RU:
                if (strlen($clear_num)==12) return $clear_num;
                $this->_setErrorMessage('Длина номера не соответствует стандарту страны - '.$this->getNameOfCountry($cprefix));
                return null;
                break;
        }
      }else{        
      }
    }
    $this->_setErrorMessage('Указанный номер не соответствует стандарту для стран: Украина, Россия, Белоруссия.'.$clear_num.'|');
    return null;
  }

  /**
   * Возвращает имя страны с распознаного номера
   * @param string $country_code
   * @return strong навзание страны Украина, Россия, Белоруссия
   */
  public function getNameOfCountry( $country_code ){
    $code = $this->existsCountryCode($country_code);
    if ( !is_null($code)){
      return $this->country[$code]['name'];
    }
    return null;
  }

  /**
   * Возвращает код страны с распознаного номера
   * @param string $country_code
   * @return int код страны без знака +
   */
  public function getCodeNumberOfCountry( $country_code ){
    $code = $this->existsCountryCode($country_code);
    if ( !is_null($code)){
      //Без знака +
      return $code*1;
    }
    return null;
  }

  /**
   * Форматирует представления телефона согласно принятым форматом вывода определенной страны
   *
   * @param string $country_code префикс страны, не обязательно начинается на +
   * @param string $phone номер телефона
   * @return string
   */
  public function printFormaterNum( $country_code, $phone ){
    #if ( $code = in_array(array($country_code, '+'.$country_code), array_keys( $this->country ))){
    $code = $this->existsCountryCode($country_code);
    
    if ( !is_null($code)){
      $format = $this->country[$code]['format'];
      $format_pos = strlen($format)-1;
      $out = '';
      for($i = strlen($phone); $i>0; $i--){
        
        $char = substr($phone, $i-1, 1);
        while($format_pos>=0){
          $format_char = substr($format, $format_pos,1);
          if ($format_char=='9'){
            $out = $char.$out;
            $format_pos--;
            
            break;
          }else{
            $out = $format_char.$out;
          }
          $format_pos--;
        }
      }
      return $out;
    }
    return $phone;
  }

  /**
   * Прверяем можно ли вообще работать с таким кодом страны.
   * 
   * @param string $country_code
   * @return string|null Код существует в классе, возвращаем его значение, начинается с +.
   *                     Если не знаем ничего про код, то 0
   */
  private function existsCountryCode( $country_code ){
    $code = null;
    $country = $country_code;
    
    if (strpos($country,'+')!==0) $code = '+'.$country;
    else $code = $country;
    if ( !in_array($code, array_keys( $this->country ))) $code = null;
    return $code;
  }

  /**
   * Сохраняем сообщение об ошибки
   * @param string $message
   */
  private function _setErrorMessage( $message ){
    $this->_errString = $message;
  }

  /**
   * Во время распознования номера телефона, може сохранять код распознаной страны
   * @param <type> $code
   */
  private function _setPhoneContry( $code ){
    $this->_phoneCountry = $code;
  }


  /**
   * Выводим сообщение об ошибке
   * @return string сообщение об ошибке
   */
  public function getErrorMessage(){
    return $this->_errString;
  }

  /**
   *
   * @return string
   */
  public function getPhoneCountry(){
    return $this->_phoneCountry;
  }

  /**
   *
   * @return array Список всех кодов стран по которым мы можем определять номера
   */
  public function getAvailablesCountrys(){
    return array(self::PREFIX_UA, self::PREFIX_RU, self::PREFIX_BY);
  }

}
