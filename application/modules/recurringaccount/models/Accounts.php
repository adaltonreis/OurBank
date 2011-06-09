<?php
/*
############################################################################
#  This file is part of OurBank.
############################################################################
#  OurBank is free software: you can redistribute it and/or modify
#  it under the terms of the GNU Affero General Public License as
#  published by the Free Software Foundation, either version 3 of the
#  License, or (at your option) any later version.
############################################################################
#  This program is distributed in the hope that it will be useful,
#  but WITHOUT ANY WARRANTY; without even the implied warranty of
#  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#  GNU Affero General Public License for more details.
############################################################################
#  You should have received a copy of the GNU Affero General Public License
#  along with this program.  If not, see <http://www.gnu.org/licenses/>.
############################################################################
*/
?>

<?php
class Recurringaccount_Model_Accounts extends Zend_Db_Table {
     protected $_name = 'ourbank_accounts';

     public function insertAccounts() 
     {
        $data = array('account_id'=> '');
        $this->insert($data);

     }

     public function UpDateAccounts($account_id,$accountNumber,$memberId,$productId,$grouporIndividualNumber,$createby) 
     {
        $data = array('account_number' =>$accountNumber,
                      'member_id' => $memberId,
                      'product_id' => $productId,
                      'membertype_id' => $grouporIndividualNumber,
                      'accountcreated_date' => date("Y-m-d"),
                      'accountcreated_by' => $createby,
                      'accountstatus_id'=> 1);
        $where = 'account_id = '.$account_id;
        $this->update($data , $where );
    }
	
    public function search($code) 
    {
        $this->db = Zend_Db_Table::getDefaultAdapter();
        $this->db->setFetchMode(Zend_Db::FETCH_OBJ);
         $sql="SELECT 
              DISTINCT a.id as id,
              a.familycode as code,
              a.name as name,
              b.id as officeid,
              b.name as officename,
              substr(a.familycode,5,1) as type,
	      c.type as membertype
              from
              ourbank_familymember a,
              ourbank_office b,
              ourbank_master_membertypes c,
              ourbank_groupmembers d
              where
              a.village_id= b.id and
              a.id = d.member_id and
              (a.name like '%' '$code' '%'  or a.familycode like '%' '$code' '%') AND
              substr(a.familycode,5,1) = c.id  
              union
              SELECT
	      DISTINCT a.id as id,
              a.groupcode as code,
              a.name as name,
              b.id as officeid,
              b.name as officename,
	      substr(a.groupcode,5,1) as type,
              c.type as membertype
              from
              ourbank_group a,
              ourbank_office b,
              ourbank_master_membertypes c
              where
              a.village_id= b.id and
              (a.name like '%' '$code' '%'  or a.groupcode like '%' '$code' '%') AND
              substr(a.groupcode,5,1) = c.id";
// //              echo $sql;
 
        $result = $this->db->fetchAll($sql,array($code));
        return $result;
    }
    
    public function getDetails($code)
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $sql="SELECT 
              DISTINCT a.id as id,
              a.familycode as code,
              a.name as name,
              b.id as officeid,
              b.name as officename,
              substr(a.familycode,5,1) as type,
	      c.type as membertype
              from
              ourbank_familymember a,
              ourbank_office b,
              ourbank_master_membertypes c,
              ourbank_groupmembers d
              where
              a.village_id= b.id and
              a.id = d.member_id and
              (a.name like '%' '$code' '%'  or a.familycode like '%' '$code' '%') AND
              substr(a.familycode,5,1) = c.id  
              union
              SELECT
	      DISTINCT a.id as id,
              a.groupcode as code,
              a.name as name,
              b.id as officeid,
              b.name as officename,
	      substr(a.groupcode,5,1) as type,
              c.type as membertype
              from
              ourbank_group a,
              ourbank_office b,
              ourbank_master_membertypes c
              where
              a.village_id= b.id and
              (a.name like '%' '$code' '%'  or a.groupcode like '%' '$code' '%') AND
              substr(a.groupcode,5,1) = c.id";
// // echo $sql;
        $result = $db->fetchAll($sql,array($code));
        return $result;
    }

   public function fetchSavingsProducts($applicableto) 
    {
        $db = Zend_Db_Table::getDefaultAdapter();

        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $sql = "select name,id
                from ourbank_productsoffer 
                where (applicableto = $applicableto OR applicableto = 4) AND  product_id in
                        (select id 
                                from ourbank_product 
                                where shortname ='rd')";
// // echo $sql;
        $result = $db->fetchAll($sql);
        return $result;
    }

    public function accountsSearch($membercode) 
    {
        $db = Zend_Db_Table::getDefaultAdapter();

        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $sql = "SELECT 
                    A.account_number as number,
                    B.name as name
                FROM
                    ourbank_accounts A,
                    ourbank_productsoffer B,
                    ourbank_product C,
                    ourbank_member D
                WHERE
                    (D.membercode like '$membercode' '%') AND
                    A.member_id = D.id AND 
                    substr(A.account_number,5,1) = '1' AND
                    A.product_id = B.id AND 
                    B.product_id = C.id AND 
                    C.shortname = 'rd' AND
                    C.category_id = 1

                UNION

                SELECT 
                    A.account_number as number,
                    B.name as name
                FROM
                    ourbank_accounts A,
                    ourbank_productsoffer B,
                    ourbank_product C,
                    ourbank_group D
                WHERE
                    (D.groupcode like '$membercode' '%') AND
                    A.member_id = D.id AND 
                    substr(A.account_number,5,1) = '2' AND
                    A.product_id = B.id AND 
                    B.product_id = C.id AND 
                    C.shortname = 'rd' AND
                    C.category_id = 1";
/*echo $sql;*/
        $result = $db->fetchAll($sql,array($membercode));
        return $result;
    }
    
    public function details($productId,$memberId) 
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $sql = "SELECT 
                    E.familycode as code,
                    substr(E.familycode,5,1) as typeID,
                    E.name as name,
                    F.name as officename,
                    F.id as officeid,
                    B.name as productname,
                    B.begindate as begindate,
                    B.glsubcode_id as glsubID,
                    C.minimum_deposit_amount as minbalance,
                    C.penal_Interest as mininterest
                    FROM 
                    ourbank_productsoffer B,
                    ourbank_product_fixedrecurring C,
                    ourbank_familymember E,
                    ourbank_office F
                    WHERE
                    (E.familycode like '$memberId' '%') AND 
                    B.id = $productId AND
                    B.id = C.productsoffer_id AND
                    F.id = E.village_id
                UNION
                SELECT 
                    E.groupcode as code,
                    substr(E.groupcode,5,1) as typeID,
                    E.name as name,
                    F.name as officename,
                    F.id as officeid,
                    B.name as productname,
                    B.begindate as begindate,
                    B.glsubcode_id as glsubID,
                    C.minimum_deposit_amount as minbalance,
                    C.penal_Interest as mininterest
                    FROM 
                    ourbank_productsoffer B,
                    ourbank_product_fixedrecurring C,
                    ourbank_group E,
                    ourbank_office F
                    WHERE
                    (E.groupcode like '$memberId' '%') AND 
                    B.id = $productId AND
                    B.id = C.productsoffer_id AND
                    F.id = E.village_id";
	
        $result = $db->fetchAll($sql);
        return $result;
    }

    public function getInterestRates($id)
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $sql = "SELECT
                period_ofrange_description ,
                Interest
                FROM
                ourbank_interest_periods
                WHERE
                offerproduct_id = $id 
                ";
        $result = $db->fetchAll($sql,array($id));
        return $result;
    }

    public function accUpdate($accId,$input)
    {
        $where[] = "id = '".$accId."'";
        $db = $this->getAdapter();
        $result = $db->update('ourbank_accounts',$input,$where);
    }

    public function getGlcode($officeId)
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        $sql = "select id from ourbank_glsubcode where substr(header,5)=$officeId and glcode_id=2";
        return $result = $db->fetchAll($sql);
    }

    public function interestperiods($productId) 
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        $sql = "select  max(period_ofrange_monthto) as maxperiod 
                from ourbank_interest_periods 
                where offerproduct_id='$productId' 
                AND intereststatus_id= 3 ";
        $result = $db->fetchAll($sql);
        return $result;
    }

    public function getInterestvalue($productId,$interestId) 
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        $sql = "select  Interest from ourbank_interest_periods 
                where offerproduct_id= $productId 
                AND $interestId between period_ofrange_monthfrom and period_ofrange_monthto";
        $result = $db->fetchAll($sql);
        return $result;
    }

    public function fetchmembers($group_id) 
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        $sql = "select  id,name from ourbank_member 
                where id in (select member_id from ourbank_groupmembers where id = $group_id)";
        $result = $db->fetchAll($sql);
        return $result;
    }
}
