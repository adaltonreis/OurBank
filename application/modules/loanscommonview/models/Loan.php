<?php
class Loans_Model_Loan extends Zend_Db_Table {
    protected $_name = 'ourbank_productsofferdetails';

    public function searchLoan($post = array()) {
        $select = $this->select()
                        ->setIntegrityCheck(false)
                        ->join(array('a' => 'ourbank_productsofferdetails'),array('offerproductupdate_id'))
                        ->where('a.recordstatus_id = 3')
                        ->where('a.offerproductname like "%" ? "%"',$post['field6'])
                        ->where('a.offerproductshortname like "%" ? "%"',$post['field2'])
                        ->join(array('b' => 'ourbank_productsloan'),'a.offerproductupdate_id=b.offerproductupdate_id')
                        ->where('b.minimumfrequency like "%" ? "%"',$post['field3'])
                        ->where('b.maximunloanamount like "%" ? "%"',$post['field4']);
       $result = $this->fetchAll($select);
       return $result->toArray();
    }

    public function getLoan() {
        $select = $this->select()
                        ->setIntegrityCheck(false)
                        ->join(array('a' => 'ourbank_productsofferdetails'),array('offerproductupdate_id'))
                        ->where('a.recordstatus_id = 3')
                        ->join(array('b'=>'ourbank_productsloan'),'a.offerproductupdate_id = b.offerproductupdate_id')
                        ->join(array('c'=>'ourbank_productdetails'),'a.product_id = c.product_id')
                        ->where('c.category_id = 2')
                        ->where('c.recordstatus_id = 3');
       $result = $this->fetchAll($select);
       return $result->toArray();
    }



     public function getloantype() {
        $result = $this->fetchAll( "recordstatus_id = '3' OR recordstatus_id = '1'"  );
        return $result;
     }

    public function getSaving() {
        $select = $this->select()
                        ->setIntegrityCheck(false)  
                        ->join(array('a' => 'ourbank_productsofferdetails'),array('offerproductupdate_id'))
                        ->where('a.recordstatus_id = 3')
                        ->where('a.category_id = 1');
       $result = $this->fetchAll($select);
       return $result->toArray();
    }

    public function getofferproductid($offerproductupdate_id) {
        $select = $this->select()
                       ->setIntegrityCheck(false)  
                       ->join(array('a' => 'ourbank_productsofferdetails'),array('offerproductupdate_id'))
                       ->where('a.offerproductupdate_id = ?',$offerproductupdate_id);
       $result = $this->fetchAll($select);
       return $result->toArray();
    }

	public function fetchAllglsubcode() {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('a' => 'ourbank_glsubcodeupdates'),array('glsubcode_id'))
			->where('a.recordstatus_id = 3 or a.recordstatus_id = 1')
			->where('a.subledger_id = 2')
			->join(array('c' => 'ourbank_glsubcode'),'a.glsubcode_id = c.glsubcode_id');
		$result = $this->fetchAll($select);
		return $result->toArray();
	}

	public function fetchAllinteresttypes() {
		$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('a' => 'ourbank_interesttypes'),array('interesttype_id'));
		$result = $this->fetchAll($select);
		return $result->toArray();
	}

    public function getInsurance() {
        $select = $this->select()
                       ->setIntegrityCheck(false)  
                       ->join(array('a' => 'ourbank_productsofferdetails'),array('offerproductupdate_id'))
                       ->where('a.recordstatus_id = 3')
                       ->join(array('b'=>'ourbank_productsloan'),'a.offerproductupdate_id = b.offerproductupdate_id')
                       ->join(array('c'=>'ourbank_productdetails'),'a.product_id = c.product_id')
                       ->where('c.category_id = 3')
                       ->where('c.recordstatus_id = 3');
       $result = $this->fetchAll($select);
       return $result->toArray();
    }

    public function viewLoan($offerproductupdate_id) {
echo "dbid".$offerproductupdate_id;
//         $select = $this->select()
//                        ->setIntegrityCheck(false)  
//                        ->join(array('a' => 'ourbank_productsoffer'),array('id'))
//                        ->where('a.id = ?',$offerproductupdate_id)
//                        ->join(array('b' => 'ourbank_productsloan'),'a.id = b.productsoffer_id') 
//                        ->join(array('c' => 'ourbank_master_membertypes'),'c.id = a.applicableto')
// //                        ->join(array('h' => 'ourbank_glsubcodes'),'a.glsubcode_id = h.glsubcode_id')
// //                        ->where('h.recordstatus_id = 3 or h.recordstatus_id = 1')
// //                        ->join(array('i' => 'ourbank_glsubcode'),'h.glsubcode_id = i.glsubcode_id')
//                        ->join(array('j' => 'ourbank_interest_periods'),'b.interesttype_id  = j.id')
//                        ->join(array('f' => 'ourbank_product'),'f.id = a.product_id');
// //                        ->where('f.recordstatus_id = 3 or f.recordstatus_id = 1');
//        $result = $this->fetchAll($select);
//        return $result->toArray();
    }

    public function viewLoan1($offerproductupdate_id) {
        $select = $this->select()
                       ->setIntegrityCheck(false)  
                       ->join(array('a' => 'ourbank_productsofferdetails'),array('offerproductupdate_id'))
                       ->where('a.offerproductupdate_id = ?',$offerproductupdate_id)
                       ->where('a.recordstatus_id = 3')
                       ->join(array('b' => 'ourbank_productfee'),'a.offerproductupdate_id = b.offerproduct_id') 
                       ->join(array('c' => 'ourbank_feedetails'),'b.fee_id = c.fee_id')
                       ->where('b.feestatus_id = 3')
                       ->where('c.recordstatus_id = 3');
        $result = $this->fetchAll($select);
        return $result->toArray();
   }

    public function viewLoan2($offerproductupdate_id) {
        $select = $this->select()
                       ->setIntegrityCheck(false)  
                       ->join(array('a' => 'ourbank_productsofferdetails'),array('offerproductupdate_id'))
                       ->where('a.offerproductupdate_id = ?',$offerproductupdate_id)
                       ->where('a.recordstatus_id = 3')
                       ->join(array('b' => 'ourbank_productfund'),'a.offerproductupdate_id = b.offerproduct_id') 
                       ->join(array('c' => 'ourbank_funderdetails'),'b.fund_id = c.funder_id')
                       ->where('b.fundstatus_id = 3')
                       ->where('c.recordstatus_id = 3');
        $result = $this->fetchAll($select);
        return $result->toArray();
    }

    public function viewLoan3($offerproduct_id) {
        $select = $this->select()
                       ->setIntegrityCheck(false)  
                       ->join(array('a' => 'ourbank_productsofferdetails'),array('offerproductupdate_id'))
                       ->where('a.offerproduct_id = ?',$offerproduct_id)
                       ->where('a.recordstatus_id = 3')
                       ->join(array('b' => 'ourbank_interest_periods'),'a.offerproduct_id = b.offerproduct_id') 
                       ->where('b.intereststatus_id = 3');
//         die($select->__toString());
        $result = $this->fetchAll($select);
        return $result->toArray();
    }

    public function viewLoan4($offerproductupdate_id) {
        $select = $this->select()
                       ->setIntegrityCheck(false)  
                       ->join(array('a' => 'ourbank_productsofferdetails'),array('offerproductupdate_id'))
                       ->where('a.offerproductupdate_id = ?',$offerproductupdate_id)
                       ->where('a.recordstatus_id = 3')
                       ->join(array('b' => 'ourbank_glsubcodeupdates'),'a.Interest_glsubcode_id = b.glsubcode_id')
                       ->join(array('c' => 'ourbank_glsubcode'),'b.glsubcode_id = c.glsubcode_id') 
                       ->where('b.recordstatus_id = 3');
        $result = $this->fetchAll($select);
        return $result->toArray();
    }

    public function viewLoan5($offerproductupdate_id) {
        $select = $this->select()
                       ->setIntegrityCheck(false)  
                       ->join(array('a' => 'ourbank_productsofferdetails'),array('offerproductupdate_id'))
                       ->where('a.offerproductupdate_id = ?',$offerproductupdate_id)
                       ->where('a.recordstatus_id = 3')
                       ->join(array('b' => 'ourbank_glsubcodeupdates'),'a.fee_glsubcode_id = b.glsubcode_id')
                       ->join(array('c' => 'ourbank_glsubcode'),'b.glsubcode_id = c.glsubcode_id') 
                       ->where('b.recordstatus_id = 3');
        $result = $this->fetchAll($select);
        return $result->toArray();
   }

    public function editLoan($post,$offerproduct_id) { 
        $data = array('offerproductupdate_id'=>'',
                      'offerproduct_id' => $offerproduct_id,
                      'offerproductname' => $post['offerproductname'],
                      'offerproductshortname' => $post['offerproductshortname'],
                      'offerproduct_description' => $post['offerproduct_description'],
                      'product_id' => $post['product_id'],
                      'begindate' => $post['begindate'],
                      'closedate' => $post['closedate'],
                      'applicableto' => $post['applicableto'],
                      'glsubcode_id' => $post['glsubcode_id'],
                      'capital_glsubcode_id' => '',
                      'Interest_glsubcode_id' => '',
                      'fee_glsubcode_id' => '',
                      'recordstatus_id' => 3,
                      'createdby' => '',
                      'createddate' => '',
                      'editedby' => '',
                      'editeddate' => date('Y-m-d'),
                      'remarks' => '');
        $this->insert($data);
    }

    public function addProductDetails($post,$offerproduct_id,$createdby) {
        $data = array('offerproductupdate_id'=>'',
                      'offerproduct_id'=>$offerproduct_id,
                      'offerproductname'=>$post['offerproductname'],
                      'offerproductshortname'=>$post['offerproductshortname'],
                      'product_id'=>$post['product_id'],
                      'offerproduct_description'=>$post['offerproduct_description'],
                      'begindate'=>$post['begindate'],
                      'closedate'=>$post['closedate'],
                      'applicableto'=>$post['applicableto'],
		      'glsubcode_id'=>$post['glsubcode_id'],
                      'recordstatus_id'=>'3',
                      'createdby'=>$createdby,
                      'createddate'=>date('Y-m-d'),
                      'editedby' => '',
                      'editeddate' => '',
                      'remarks' => '');
         $this->insert($data);
    }

    public function updateLoan($offerproductupdate_id) {
        $data = array('recordstatus_id'=> 2);
        $where = 'offerproductupdate_id = '.$offerproductupdate_id;
        $this->update($data , $where);
    }

    public function insertRow4($input = array()) {
        $this->db = Zend_Db_Table::getDefaultAdapter();
        $this->db->insert('ourbank_interest_periods',$input);
    }

    public function deleteLoans($offerproductupdate_id,$remarks) {
        $data = array('recordstatus_id'=> 5,'remarks'=>$remarks);
        $where = 'offerproductupdate_id = '.$offerproductupdate_id;
        $this->update($data , $where );
    }

    public function deleteinterestLoans($offerproductupdate_id,$remarks) {
        $data = array('recordstatus_id'=> 5,'remarks'=>$remarks);
        $where = 'offerproductupdate_id = '.$offerproductupdate_id;
        $this->update($data , $where );
    }

    public function insertRow5($input = array()) {
        $this->db = Zend_Db_Table::getDefaultAdapter();
        $this->db->insert('ourbank_interest_periods',$input);
        return '1';
    }

    public function viewproduct($product_id) {
        $select = $this->select()
                       ->setIntegrityCheck(false)
                       ->join(array('a' => 'ourbank_productdetails'),array('product_id'))
			->where('a.product_id = ?',$product_id)
                       ->where('a.recordstatus_id = 3 or a.recordstatus_id = 1');
       $result = $this->fetchAll($select);
       return $result->toArray();
    }

    public function viewappliesto($applicableto) {
        $select = $this->select()
                       ->setIntegrityCheck(false)
                       ->join(array('a' => 'ourbank_membertypes'),array('membertype_id'))
			->where('a.membertype_id = ?',$applicableto);
       $result = $this->fetchAll($select);
       return $result->toArray();
    }

	public function loanUpdate($updateOldloan= array(),$updateNewloan= array(),$createdby,$offerproduct_id)
	{
		$this->db = Zend_Db_Table::getDefaultAdapter();
		$match = array();
		foreach ($updateOldloan as $key=>$val) {
			if ($val != $updateNewloan[$key]) {
                        /** if the values are changed */
				$match[] = $key;
    		}
		}
		if(count($match) <= 0){
		} else {
			foreach($match as $loan) {
				$tableName ='ourbank_productsofferdetails';
				$loanUpdates = array('loanproductupdates_id'=>'',
							'offerproduct_id' => $offerproduct_id,
							'table_name'=>$tableName,
							'fieldname'=>$loan,
							'previous_data'=>$updateOldloan[$loan],
							'current_data'=>$updateNewloan[$loan],
							'modified_by'=>$createdby,
							'modified_date'=>date("Y-m-d"));
				$this->db->insert("ourbank_loanupdates",$loanUpdates);
			}
		}
	}
}