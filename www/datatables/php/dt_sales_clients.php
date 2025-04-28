<?php
session_start();

// DataTables PHP library
include( "lib/DataTables.php" );

// Alias Editor classes so they are easy to use
use
	DataTables\Editor,
	DataTables\Editor\Field,
	DataTables\Editor\Format,
	DataTables\Editor\Mjoin,
	DataTables\Editor\Options,
	DataTables\Editor\Upload,
	DataTables\Editor\Validate,
	DataTables\Editor\ValidateOptions;

//Log
date_default_timezone_set("Asia/Seoul");

function logChange ( $editor, $action, $id, $values ) 
{
	$editor->db()->insert( 'dt_log', array(
		'username'   => isset($_SESSION['MB_NAME']) ? $_SESSION['MB_NAME'] : null, 
		'action' => $action,
		'datavalues' => json_encode( $values ),		
		'row'    => $id,
		'logwhen'   => date('Y-m-d H:i:s')
		)
	);
}	

if ( ! isset($_POST['CompanyId']) || ! is_numeric($_POST['CompanyId']) ) {
	echo json_encode( [ "data" => [] ] );
}
else {
	$editor = Editor::inst( $db, 'dt_sales_clients' )
	->fields(
		Field::inst( 'dt_sales_clients.CompanyId' )
			->options( 'dt_sales_companys', 'id' )
			->validator( 'Validate::dbValues' ),		
		Field::inst( 'dt_sales_clients.Department' ),
		Field::inst( 'dt_sales_clients.ClientName' )
			->validator( Validate::notEmpty( ValidateOptions::inst()
			->message( '필수 항목 입니다.' )
		) ),
		Field::inst( 'dt_sales_clients.TelNumber' ),	
		Field::inst( 'dt_sales_clients.Email' )
			->validator( Validate::email( ValidateOptions::inst()
			->message( '이메일 주소를 입력하세요.' )  
		) ),			
		Field::inst( 'dt_sales_clients.Remarks' ),
		Field::inst( 'dt_sales_clients.CreatedBy')->set( Field::SET_CREATE ),
		Field::inst( 'dt_sales_clients.CreatedOn')->set( Field::SET_CREATE ),
		Field::inst( 'dt_sales_clients.UpdatedBy')->set( Field::SET_EDIT ),
		Field::inst( 'dt_sales_clients.UpdatedOn')->set( Field::SET_EDIT )		
	);

	$editor 
	->on( 'preCreate', function ( $editor, $values ) {
		$editor->field( 'dt_sales_clients.CompanyId' )->setValue( $_POST['CompanyId'] );			
		$editor->field( 'dt_sales_clients.CreatedOn' )->setValue( date("Y-m-d H:i:s") );		
		$editor->field( 'dt_sales_clients.CreatedBy' )->setValue( isset($_SESSION['MB_NAME']) ? $_SESSION['MB_NAME'] : null );		
	})
	->on( 'preEdit', function ( $editor, $values ) {
		$editor->field( 'dt_sales_clients.UpdatedOn' )->setValue( date("Y-m-d H:i:s") );	
		$editor->field( 'dt_sales_clients.UpdatedBy' )->setValue( isset($_SESSION['MB_NAME']) ? $_SESSION['MB_NAME'] : null );		
	})
	->on( 'postCreate', function ( $editor, $id, $values) {
		logChange( $editor, '생성( dt_sales_clients )', $id, $values );
	} )
	->on( 'postEdit', function ( $editor, $id, $values) {
		logChange( $editor, '수정( dt_sales_clients )', $id, $values );
	} )
	->on( 'postRemove', function ( $editor, $id, $values ) {
		logChange( $editor, '삭제( dt_sales_clients )', $id, $values );
	} );

	$editor 
	// ->leftJoin( 'dt_sales_companys', 'dt_sales_companys.id', '=', 'dt_sales_clients.CompanyId' )
	->where( 'CompanyId', $_POST['CompanyId'] )
	->process( $_POST )
	->json();

}