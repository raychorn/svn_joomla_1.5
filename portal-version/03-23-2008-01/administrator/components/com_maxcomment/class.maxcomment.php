<?php
/*********************************************
* mXcomment - Component                      *
* Copyright (C) 2007-2008 by Bernard Gilly   *
* --------- All Rights Reserved ------------ *      
* Homepage   : www.visualclinic.fr           *
* Version    : 1.0.7                         *
* License    : Creative Commons              *
*********************************************/

defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

class mosMXComment extends mosDBTable {
  var $id=null;
  var $parentid=null;
  var $status=null;
  var $contentid=null;
  var $ip=null;
  var $name=null;
  var $web=null;	
  var $email=null;	
  var $title=null;
  var $comment=null;
  var $date=null;
  var $published=null;
  var $ordering=null;
  var $iduser=null; 
  var $subscribe=null;
  var $rating=null;
  var $currentlevelrating=null;
  var $lang=null;
  var $component=null;
  
  function mosMXComment( &$db ) {
    $this->mosDBTable( '#__mxc_comments', 'id', $db );
  }
}

class mosMX_admComment extends mosDBTable {
  var $id=null;
  var $contentid=null;
  var $name=null;
  var $title=null;
  var $comment=null;
  var $date=null;
  var $published=null;
  var $iduser=null; 
  var $rating=null;
  var $currentlevelrating=null;
  var $component=null;
  
  function mosMX_admComment( &$db ) {
    $this->mosDBTable( '#__mxc_admcomments', 'id', $db );
  }
}

class mosMXCFavoured extends mosDBTable {
  var $id=null;
  var $id_content=null;
  var $id_user=null;
  var $ip=null;
  var $date=null;

  function mosMXCFavoured( &$db ) {
    $this->mosDBTable( '#__mxc_favoured', 'id', $db );
  }
}
  
class mosMXCBadwords extends mosDBTable {
  var $id=null;
  var $badword=null;
  var $published=null;

  function mosMXCBadwords( &$db ) {
    $this->mosDBTable( '#__mxc_badwords', 'id', $db );
  }
}

class mosMXCBlockip extends mosDBTable {
  var $id=null;
  var $ipblock=null;
  var $published=null;

  function mosMXCBlockip( &$db ) {
    $this->mosDBTable( '#__mxc_blockip', 'id', $db );
  }
}
?>