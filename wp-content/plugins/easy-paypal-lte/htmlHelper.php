<?php
if (class_exists("htmlHelper")) {
  echo "Problem, class htmlHelper exists! \nCannot safely continue.\n" ;
  exit ;
}
else {
  class htmlHelper {
    var $info, $warn, $err, $cwd ;
    function __construct($cwd='.') {
      $this->cwd = $cwd ;
    }
    function __destruct(){
    }
    function htmlHelper($cwd) {
      if(version_compare(PHP_VERSION,"5.0.0","<")){
        $this->__construct($cwd);
        register_shutdown_function(array($this,"__destruct"));
      }
    }
    function setInfo($info='') {
      if (empty($info)) $this->info = '' ;
      else $this->info = $info ;
    }
    function setWarn($warn='') {
      if (empty($warn)) $this->warn = '' ;
      else $this->warn = $warn ;
    }
    function setErr($err='') {
      if (empty($err)) $this->err = '' ;
      else $this->err = $err ;
    }
    function setCWD($cwd='.') {
      $this->cwd = $cwd ;
    }
    function ezppHeader($heading, $welcome='') {
      $pwd = plugins_url('/') .  basename(dirname(__FILE__)) ;
      $_SESSION['ezppURL'] = admin_url('/') . "options-general.php?page=easy-paypal-lite.php&action=" ;
      if (empty($welcome)) {
        include_once('actions.php') ;
        $welcome = showActions($actions, false) ;
      }
      if (!empty($GLOBALS['toInclude']))
        $self = array_shift(explode('.', $GLOBALS['toInclude'])) ;
      printf("
<script type='text/javascript' src='$pwd/wz_tooltip.js'></script>
<script type='text/javascript' src='$pwd/ezpp.js'></script>
<div id='ezcontainer'>
  <div id='ezheader'>
    <img src='$pwd/ezPayPal.png' width='188' height='72' alt='Ez-PayPal' style='float:left;'>
    <p id='info'>%s</p>
  </div>
  <div id='nav'>
    <ul id='sub_nav'>
      <li>%s <img onclick='popUp(\"$pwd/docs/index.php?$self\");return false;' target='_blank' style='float:right;cursor:pointer;' title='Click for Help' alt='(?)' onmouseover=\"Tip('Need help?<br />Click me!', WIDTH, 70)\" onmouseout=\"UnTip()\" src='$pwd/help.png' /></li>
    </ul>
  </div>
  <div class='clear'></div>
     <div id='ezcontent'>
       <div>", $welcome, $heading) ;
      if (!empty($this->err))
        echo "<p align='center' id='errormessage'>{$this->err}</p>" ;
      if (!empty($this->info))
        echo "<p align='center' id='infomessage'>{$this->info}</p>" ;
      if (!empty($this->warn))
        echo "<p align='center' id='warnmessage'>{$this->warn}</p>" ;
      echo '    </div>
    <div style="padding:3px; padding-top:1px; padding-bottom:5px;">
<!-- End of ezppHeader() -->
';
    }
    function ezppFooter() {
      printf('<!-- Start of ezppFooter() -->
    </div>
  </div>
</div>') ;
    }
    function ezDie($err, $heading='Error Exit', $welcome='Cannot safely continue',
      $pwd='.') {
      $this->err = $err ;
      $this->ezppHeader($heading, $welcome, $pwd) ;
      $this->ezppFooter() ;
    }
    function inError() {
      return !empty($this->err) ;
    }
    static function staticRedirect ($target, $get='') {
      if (strpos($_SERVER['PHP_SELF'], $target) !== false)
        die("Caught infinite redirect: from {$_SERVER['PHP_SELF']} to $target") ;
      if (!empty($get)) $get = "?$get" ;
      if (file_exists($target) || file_exists("pro/$target")) header("location:$target$get") ;
      else die("Problem locating <code>$target</code>. Please reinstall ezPayPal!") ;
    }
    static function redirect($target, $get='') {
      if (file_exists($target) && strpos($_SERVER['PHP_SELF'], $target) === false) {
        if (!empty($get)) $get = "?$get" ;
        header("location:$target$get") ;
      }
      else {
        die ("<br />Problem locating <code>$target</code>. Please reinstall ezPayPal!") ;
      }
    }
    static function renderDbTable($rows) {
      $ret = htmlHelper::renderDbTableHeader($rows) ;
      $alt = "" ;
      foreach ($rows as $r) {
        $ret .= htmlHelper::renderDbTableRow($r, $alt) ;
      }
      $ret .= htmlHelper::renderDbTableFooter($rows) ;
      return $ret ;
    }
    static function renderDbTableHeader($rows) {
      $ret = '' ;
      if (empty($rows) || !is_array($rows)) return $ret ;
      $saleInfo = $rows[0] ;
      if (empty($saleInfo) || !is_array($saleInfo)) return $ret ;
      $ret .= sprintf("<table id='database'><tr>") ;
      foreach ($saleInfo as $k => $v) {
        $ret .= sprintf("<th>%s</th>", ucwords(str_replace('_', ' ', $k))) ;
      }
      $ret .= sprintf("</tr>") ;
      return $ret ;
    }
    static function renderDbTableRow($saleInfo, &$alt) {
      $ret = '' ;
      if ($alt == "") $alt = "class='alt'" ;
      else $alt = "" ;
      $ret .= sprintf("<tr $alt>\n") ;
      foreach ($saleInfo as $k => $v) {
        $ret .= sprintf("<td>%s</td>\n", $v) ;
      }
      $ret .= sprintf("</tr>\n") ;
      return $ret ;
    }
    static function renderDbTableFooter($rows) {
      $ret = '' ;
      $ret .= sprintf("</table>") ;
      return $ret ;
    }
    static function dbDataProject($allSales, $cols) {
      $ret = array() ;
      if (empty($allSales)) return $ret ;
      $colKeys = array_fill_keys(array_keys(array_flip($cols)), "") ;
      foreach ($allSales as $sale) {
        $ret[] = array_merge($colKeys, array_intersect_key($sale, $colKeys)) ;
      }
      return $ret ;
    }

    static function dbDataAllBut($allSales, $cols) {
      $ret = array() ;
      if (empty($allSales)) return $ret ;
      $colKeys = array_flip($cols) ;
      foreach ($allSales as $sale) {
        $ret[] = array_diff_key($sale, $colKeys) ;
      }
      return $ret ;
    }

    static function dbDataFilter($allSales, $filter) {
      $ret = array() ;
      foreach ($allSales as $sale) {
        foreach ($filter as $fkey => $fval)
          if (in_array($sale[$fkey], $fval)) $ret[] = $sale ;
      }
      return $ret ;
    }

    static function dbGetColData($allSales, $col, $unique=true) {
      $projected = htmlHelper::dbDataProject($allSales, array(1 => $col)) ;
      $ret = array() ;
      foreach ($projected as $p) {
        $ret[] = $p[$col] ;
      }
      if ($unique) $ret = array_unique($ret) ;
      sort($ret) ;
      return $ret ;
    }
  }
}
?>