<?php

class ExcelDefinitions {


	protected $def;
	protected $rowDef;
	protected $fieldDef;
			
	public function __construct( $id ) {
    	$this->_getDefinition ($id);
    }
	
					
	private function _getDefinition($id){
			
		
		
		//$mysqldb = new DB_MySql($_SESSION['DB_HOST'],$_SESSION['DB'], $_SESSION['DB_USER'], $_SESSION['DB_PASSWD']);
		//$sql = "select * from PPImport_Definition   where 	PPImport_Definition_Id = '".$id."'	";
		//$mysqldb->query($sql);

		$defs = PPImport_Definitions::where('PPImport_Definition_Id', '=', $id)->get();

		foreach ($defs as $def)
		{
    		//var_dump($def->PPImport_Definition_Id);
			//var_dump($row,true);
			$this->def = $def;
			if (strtoupper($def->PPImport_Definition_Mode) == "ROW"){
				//$mysqldb1 = new DB_MySql($_SESSION['DB_HOST'],$_SESSION['DB'], $_SESSION['DB_USER'], $_SESSION['DB_PASSWD']);
				//$sql1 = "select * from PPImport_Definition_Row   where 	PPImport_Definition_Id1 = '".$id."'	";
				//$mysqldb1->query($sql1);
				
				$defRows = PPImport_Definition_Rows::where('PPImport_Definition_Id1', '=', $id)->get();
				
				foreach ($defRows as $defRow){
					$this->rowDef[$defRow->PPImport_Definition_Rows_Col]=$defRow->PPImport_Definition_Rows_Field;
				}
			}
			
			if (strtoupper($def->PPImport_Definition_Mode) == "FIELDS"){
				//$mysqldb1 = new DB_MySql($_SESSION['DB_HOST'],$_SESSION['DB'], $_SESSION['DB_USER'], $_SESSION['DB_PASSWD']);
			
				//$sql1 = "select * from PPImport_Definition_Fields  where 	PPImport_Definition_Id2 = '".$id."'	";
				//$mysqldb1->query($sql1);
				
				$defFields = PPImport_Definition_Fields::where('PPImport_Definition_Id2', '=', $id)->orderBy('PPImport_Definition_Fields_Row')->get();
								
				
				foreach ($defFields as $defField){
					//var_dump($row2);echo("<br><br>");
					$fields['sheet']=$defField->PPImport_Definition_Fields_Sheet;
					$fields['field']=$defField->PPImport_Definition_Fields_Field;
					$fields['row']=$defField->PPImport_Definition_Fields_Row;
					$fields['col']=$defField->PPImport_Definition_Fields_Col;
					 
					$this->fieldDef[]=$fields;
				}
			}
		}
	}				

	function getCell($qfield){
		foreach ($this->fieldDef as $field) {
			if ($field['field'] == $qfield) return   array('row'=>$field['row'], 'col'=>PHPExcel_Cell::columnIndexFromString($field['col'])-1);
		}
		return false;
	}

	function getMergedCellValue ($cell, $sheet, $cellxy=""){
		
		
		
		foreach ($sheet->getMergeCells() as $cells) {
		    if ($cell->isInRange($cells)) {
		    	
				$range = explode(":",$cells);
				
				//ls
				//cpcDebug::cpc_debug('getMergeedCell'.print_r($range));
				
				//Log::info('getMergeedCell 2'.print_r($sheet->getCell($range[0])));
				return $sheet->getCell($range[0])->getValue();
		       
		    }
		}
		return False;
	}
			
	public function doPrint(){
		$this->printDef();
		$this->printRowDef();
		$this->printFieldDef();
		
	}
	
	public function isRowMode (){
		return ($this->getMode() == "ROW");		
	}

	public function isFieldsMode (){
		return ($this->getMode() == "FIELDS");		
	}

	public function getTable(){
		return $this->def['PPImport_Definition_Table'];
	}
	public function getId(){
		return $this->def['PPImport_Definition_Id'];
	}
	public function getMode(){
		return $this->def['PPImport_Definition_Mode'];
	}
	public function getStartrow(){
		return $this->def['PPImport_Definition_Startrow'];
	}
	public function getEndrow(){
		return $this->def['PPImport_Definition_Endrow'];
	}
	public function getSheetname(){
		return $this->def['PPImport_Definition_Sheetname'];
	}
	public function getRowDef(){
		if (!$this->isRowMode()) return False;
		return $this->rowDef;
	}
	public function getFieldDef(){
		if (!$this->isFieldsMode()) return False;
		return $this->fieldDef;
	}
	
	public function getField($cell){
		if (!$this->isRowMode()) return false;
		if (!isset($this->rowDef[$cell]) ) return False;
		return $this->rowDef[$cell];
	}
	
	public function getCol($field){
		if (!$this->isRowMode()) return false;
		
		//echo("<br>X".$field."<br>");
		
		foreach ($this->rowDef as $col => $def) {
			//echo("col: $col Def: $def <br>");
			if ($def == $field) return $col;
		}
		
		return false;
	}
	
	
	public function printDef(){
		return "DEFINITION: ".$this->getId()."\n".print_r($this->def,true).'\n';
	}
	public function printRowDef(){
		if ($this->getMode() != "ROW"){
			return "No Rowdef <br>";
		};
		return "Row Definition: ".$this->getId()."\n".print_r($this->rowDef,true).'\n';
	}
	public function printFieldDef(){
		if ($this->getMode() != "FIELDS"){
			return "No Filddef  <br><br>";
		};
		
		return "Field Definition: ". $this->getId()."\n".print_r($this->fieldDef,true).'\n';
	}
}
	 