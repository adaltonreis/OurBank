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
class Ledgerbalancebook_Form_Search extends ZendX_JQuery_Form {
	public function __construct($path) 
		{
                parent::__construct();
                //$fieldtype,$fieldname,$table,$columnname,$cssname,$labelname,$required,$validationtype,$min,$max,$decorator,$value
                $formfield = new App_Form_Field ();
                //$vtype=array('Alpha');

        		$hierarchy = $formfield->field('Select','hierarchy','','','mand','',true,'','','','','',0,'');
        		$hierarchy->setAttrib('onchange', 'getlevels(this.value,"'.$path.'")');
        		$hierarchy->setRegisterInArrayValidator(false);

        		$branch = $formfield->field('Select','branch','','','mand','Branch',true,'','','','','',0,'');
        		$branch->setAttrib('onchange', 'getgroups(this.value,"'.$path.'")');
        		$branch->setRegisterInArrayValidator(false);

        		$group = $formfield->field('Select','group','','','mand','Group',false,'','','','','',0,'');

                $datefrom = $formfield->field('Text','date1','','','mand','From date',true,'','','','','',0,'');
			
			$this->addElements(array($hierarchy,$branch,$group,$datefrom));
		}
}
