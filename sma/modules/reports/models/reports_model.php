<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/*
| -----------------------------------------------------
| PRODUCT NAME: 	SCHOOL MANAGER 
| -----------------------------------------------------
| AUTHER:			MIAN SALEEM 
| -----------------------------------------------------
| EMAIL:			saleem@tecdiary.com 
| -----------------------------------------------------
| COPYRIGHTS:		RESERVED BY TECDIARY IT SOLUTIONS
| -----------------------------------------------------
| WEBSITE:			http://tecdiary.net
| -----------------------------------------------------
|
| MODULE: 			Reports
| -----------------------------------------------------
| This is reports module model file.
| -----------------------------------------------------
*/


class Reports_model extends CI_Model
{
	
	
	public function __construct()
	{
		parent::__construct();

	}
	
		
	public function getAllProducts() 
	{
		$q = $this->db->get('products');
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data;
		}
	}
	
	public function getAllUsers() 
	{
		$q = $this->db->get('users');
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data;
		}
	}
	
	public function getAllCategories() 
	{
		$q = $this->db->get('categories');
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data;
		}
	}
	
	public function getStockValue() 
	{
		$q = $this->db->query("SELECT SUM(by_price) as stock_by_price, SUM(by_cost) as stock_by_cost FROM ( Select COALESCE(sum(warehouses_products.quantity), 0)*price as by_price, COALESCE(sum(warehouses_products.quantity), 0)*cost as by_cost FROM products JOIN warehouses_products ON warehouses_products.product_id=products.id GROUP BY products.id )a");
		 if( $q->num_rows() > 0 )
		  {
			return $q->row();
		  } 
		
		  return FALSE;
	}
	
	public function getWarehouseStockValue($id) 
	{

		 $q = $this->db->query("SELECT SUM(by_price) as stock_by_price, SUM(by_cost) as stock_by_cost FROM ( Select COALESCE(sum(warehouses_products.quantity), 0)*price as by_price, COALESCE(sum(warehouses_products.quantity), 0)*cost as by_cost FROM products JOIN warehouses_products ON warehouses_products.product_id=products.id WHERE warehouses_products.warehouse_id = ? GROUP BY products.id )a", array($id));
		 if( $q->num_rows() > 0 )
		  {
			return $q->row();
		  } 
		
		  return FALSE;
	}
	
	public function getmonthlyPurchases() 
	{
		$myQuery = "SELECT (CASE WHEN date_format( date, '%b' ) Is Null THEN 0 ELSE date_format( date, '%b' ) END) as month, SUM( COALESCE( total, 0 ) ) AS purchases FROM purchases WHERE date >= date_sub( now( ) , INTERVAL 12 MONTH ) GROUP BY date_format( date, '%b' ) ORDER BY date_format( date, '%m' ) ASC";
		$q = $this->db->query($myQuery);
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data;
		}
	}
	
	public function getChartData() 
	{
		$myQuery = "SELECT S.month,
					   COALESCE(S.sales, 0) as sales,
					   COALESCE( P.purchases, 0 ) as purchases,
					   COALESCE(S.tax1, 0) as tax1,
					   COALESCE(S.tax2, 0) as tax2,
					   COALESCE( P.ptax, 0 ) as ptax
					FROM (	SELECT	date_format(date, '%Y-%m') Month,
								SUM(total) Sales,
								SUM(total_tax) tax1,
								SUM(total_tax2) tax2
						FROM sales
						WHERE sales.date >= date_sub( now( ) , INTERVAL 12 MONTH )
						GROUP BY date_format(date, '%Y-%m')) S
					LEFT JOIN (	SELECT	date_format(date, '%Y-%m') Month,
									SUM(total_tax) ptax,
									SUM(total) purchases
							FROM purchases
							GROUP BY date_format(date, '%Y-%m')) P
					ON S.Month = P.Month
					GROUP BY S.Month
					ORDER BY S.Month";
		$q = $this->db->query($myQuery);
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data;
		}
	}
	
	/*public function getDailySales() 
	{
		$year = '2013'; $month = '3';
		$myQuery = "SELECT DATE_FORMAT( date,  '%e' ) AS date, SUM( COALESCE( total, 0 ) ) AS sales, SUM( COALESCE( total_tax, 0 ) ) as tax1, SUM( COALESCE( total_tax2, 0 ) ) as tax2
			FROM sales
			WHERE DATE_FORMAT( date,  '%Y-%m' ) =  '2013-4'
			GROUP BY DATE_FORMAT( date,  '%e' )";
		$q = $this->db->query($myQuery);
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data;
		}
	}*/
	
	
	public function getAllWarehouses() 
	{
		$q = $this->db->get('warehouses');
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data;
		}
	}
	
	public function getAllCustomers() 
	{
		$q = $this->db->get('customers');
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data;
		}
	}
	
	public function getAllBillers() 
	{
		$q = $this->db->get('billers');
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data;
		}
	}
	
	public function getAllSuppliers() 
	{
		$q = $this->db->get('suppliers');
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data;
		}
	}
	
	public function getDailySales($year, $month) 
	{
		
		$myQuery = "SELECT DATE_FORMAT( date,  '%e' ) AS date, SUM( COALESCE( total_tax, 0 ) ) AS tax1, SUM( COALESCE( total_tax2, 0 ) ) AS tax2, SUM( COALESCE( total, 0 ) ) AS total, SUM( COALESCE( inv_discount, 0 ) ) AS discount
			FROM sales
			WHERE DATE_FORMAT( date,  '%Y-%m' ) =  '{$year}-{$month}'
			GROUP BY DATE_FORMAT( date,  '%e' )";echo "<pre>".$myQuery. "</pre>";
		$q = $this->db->query($myQuery, false);
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data;
		}
	}
	
	public function getMonthlySales($year) 
	{
		
		$myQuery = "SELECT DATE_FORMAT( date,  '%c' ) AS date, SUM( COALESCE( total_tax, 0 ) ) AS tax1, SUM( COALESCE( total_tax2, 0 ) ) AS tax2, SUM( COALESCE( total, 0 ) ) AS total
			FROM sales
			WHERE DATE_FORMAT( date,  '%Y' ) =  '{$year}' 
			GROUP BY date_format( date, '%c' ) ORDER BY date_format( date, '%c' ) ASC";
		$q = $this->db->query($myQuery, false);
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data;
		}
	}
	
	//Metodos personalizados para los cierres de ventas 
	
	function getTotalSalesDaily($fecha=''){
		if(isset($fecha)&&!empty($fecha))
			$fecha="AND  date >='$fecha'";
		else
			$fecha="AND date= DATE_FORMAT(now(),'%Y-%m-%d')";
			
		$myQuery = "
		SELECT 
				s.id
				,s.total
			FROM sales s
			WHERE 
				1=1
				$fecha
		";
		$q = $this->db->query($myQuery, false);
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data;
		}
	}
	
	function getProductsSalesDaily($fecha=''){
		if(isset($fecha)&&!empty($fecha))
			$fecha="AND  date >='$fecha'";
		else
			$fecha="AND date= DATE_FORMAT(now(),'%Y-%m-%d')";
		
		$myQuery = "
		SELECT
				si.product_id as id
				,si.product_name as nombre
				,SUM(si.quantity) as cantidad
				,SUM(si.gross_total) as total
			FROM 
				 sale_items si
                                 ,sales s
                        WHERE
                              si.sale_id=s.id
                         $fecha			
			GROUP BY si.product_id					
		";
		$q = $this->db->query($myQuery, false);
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data;
		}
	}
	
	
	
	function getTotalSalesDailyByDate($fecha=''){
		if(isset($fecha)&&!empty($fecha))
			$fecha="AND  date >='$fecha'";
		else
			$fecha="AND date= DATE_FORMAT(now(),'%Y-%m-%d')";
			
		$myQuery = "
		SELECT 
				date as fecha
                ,s.id
				,COUNT(*) as cantidad
				,SUM(s.total) as total			
			FROM sales s
			WHERE 
				1=1
				$fecha
		GROUP BY date ORDER BY date
		";
		$q = $this->db->query($myQuery, false);
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data;
		}
	}
	
	function getProductsSalesDailyByDate($fecha=''){
		if(isset($fecha)&&!empty($fecha))
			$fecha="AND  date >='$fecha' AND date <= DATE_FORMAT(now(),'%Y-%m-%d')";
		else
			$fecha="AND date= DATE_FORMAT(now(),'%Y-%m-%d')";
	
		$myQuery = "
		SELECT
				s.date as fecha
			  ,si.product_name as nombre
			  ,SUM(si.quantity) as cantidad
			  ,SUM(si.gross_total) as total
			FROM 
				 sale_items si
                                 ,sales s
                        WHERE
                              si.sale_id=s.id							  
                         $fecha			
			GROUP BY date,si.product_id				
		";
		$q = $this->db->query($myQuery, false);
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data;
		}
	}
	
	function getClosesDay($fecha=''){
		if(isset($fecha)&&!empty($fecha))
			$fecha="AND  date ='$fecha'";
		else
			$fecha="AND date= DATE_FORMAT(now(),'%Y-%m-%d')";
	
		$myQuery = "
		SELECT
				id
				,count(*) as cantidad
			FROM 
				 closes_days
            WHERE
                              1=1
            $fecha			
		";
		$q = $this->db->query($myQuery, false);
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data;
		}
	}
	
	// funciones para cierre
	function getClosesDetailsSalesDays($close_id=''){
		if(isset($close_id)&&!empty($close_id))
			$where="AND  close_day_id ='$close_id'";
		
	
		$myQuery = "
		SELECT
				count(*) as cantidad
			FROM 
				 closes_details_sales_days
            WHERE
                              1=1
            $where			
		";
		$q = $this->db->query($myQuery, false);
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data;
		}
	}
	function getClosesTotalDays($close_id=''){
		if(isset($close_id)&&!empty($close_id))
			$where="AND  close_day_id ='$close_id'";
		
	
		$myQuery = "
		SELECT
				id
				,count(*) as cantidad
			FROM 
				 closes_total_days
            WHERE
                              1=1
            $where			
		";
		$q = $this->db->query($myQuery, false);
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data;
		}
	}
	function getClosesTotalProductsDays($close_id=''){
		if(isset($close_id)&&!empty($close_id))
			$where="AND  close_day_id ='$close_id'";
		
	
		$myQuery = "
		SELECT
				count(*) as cantidad
			FROM 
				 closes_total_products_days
            WHERE
                              1=1
            $where			
		";
		$q = $this->db->query($myQuery, false);
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data;
		}
	}
	
	//public function addSale($saleDetails = array(), $items = array(), $warehouse_id, $sid = NULL)
	public function addCloseDay($details_sales = array(), $total_sales = array(), $products_totals=array())
	{
		//insertamos la cabecera
		$closes_days=array();
		$closes_days['date']=date("Y-m-d");
		$closes_days['user_id']=2;
		//recuperamos con la fecha del dia si hubo cierres
		$closesDays=$this->getClosesDay($closes_days['date']);
		if($closesDays[0]->cantidad > 0){
			$close_id=$closesDays[0]->id;
		}else{		
			//realizamos la insercion a la tabla closes_days
			//$this->db->insert('closes_days', $closes_days);
			$close_id = $this->db->insert_id();
		}		
		$ClosesDetailsSalesDays=$this->getClosesDetailsSalesDays($close_id);
		
		if($ClosesDetailsSalesDays[0]->cantidad > 0 && (count($details_sales)>0 && $ClosesDetailsSalesDays[0]->cantidad))
			$indice_inicio=$ClosesDetailsSalesDays[0]->cantidad;
		else
			$indice_inicio=0;
		//insercion de detalles		
		for($i=$indice_inicio;$i<count($details_sales);$i++){
			$details_sales[$i]['close_day_id']= $close_id;
			//print_r($details_sales[$i]);
			//$this->db->insert('closes_details_sales_days', $details_sales[$i]);
		}	
		//$this->db->insert_batch('closes_details_sales_days', $details_sales);
		$closesTotalDays=$this->getClosesTotalDays($close_id);
		if($closesTotalDays[0]->cantidad >0){
			
			//$this->db->update('closes_total_days', $total_sales[0], array('close_day_id' => $close_id));
		}elseif($closesTotalDays[0]->cantidad ==0){
			//insercion de totales
			for($i=0;$i<count($total_sales);$i++){
				$total_sales[$i]['close_day_id']= $close_id;
				//print_r($total_sales[$i]);			
			}
			//$this->db->insert_batch('closes_total_days', $total_sales);
		}		
		
		
		$closesTotalProductsDays=$this->getClosesTotalProductsDays($close_id);
		if($closesTotalProductsDays[0]->cantidad > 0 && (count($products_totals)>0 && $closesTotalProductsDays[0]->cantidad))
			$indice_inicio=$closesTotalProductsDays[0]->cantidad;
		else
			$indice_inicio=0;
		//insercion de productos
		for($i=$indice_inicio;$i<count($products_totals);$i++){
			$products_totals[$i]['close_day_id']= $close_id;
			//print_r($products_totals[$i]);
			//echo "<br/>";
			//$this->db->insert('closes_total_products_days', $products_totals[$i]);
		}
		//$this->db->insert_batch('closes_total_products_days', $products_totals);
		
		return false;
	}
	
	
}
