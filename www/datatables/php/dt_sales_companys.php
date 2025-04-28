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

	$editor = Editor::inst( $db, 'dt_sales_companys', 'id' )
	->fields(
		Field::inst( 'id' )->set( false ),	      
		Field::inst( 'CompanyKor' )
			->validator( Validate::notEmpty( ValidateOptions::inst()
				->message( '필수 항목 입니다.' )
			) ),
		Field::inst( 'ProjectName' ),	
		Field::inst( 'Remarks' ),
		Field::inst( 'CreatedBy')->set( Field::SET_CREATE ),
		Field::inst( 'CreatedOn')->set( Field::SET_CREATE ),
		Field::inst( 'UpdatedBy')->set( Field::SET_EDIT ),
		Field::inst( 'UpdatedOn')->set( Field::SET_EDIT )		
	);

	$editor 
	->on( 'preCreate', function ( $editor, $values ) {
		$editor->field( 'CreatedOn' )->setValue( date("Y-m-d H:i:s") );		
		$editor->field( 'CreatedBy' )->setValue( isset($_SESSION['MB_NAME']) ? $_SESSION['MB_NAME'] : null );		
	})
	->on( 'preEdit', function ( $editor, $values ) {
		$editor->field( 'UpdatedOn' )->setValue( date("Y-m-d H:i:s") );	
		$editor->field( 'UpdatedBy' )->setValue( isset($_SESSION['MB_NAME']) ? $_SESSION['MB_NAME'] : null );		
	})
	->on( 'postCreate', function ( $editor, $id, $values) {
		logChange( $editor, '생성( dt_sales_company )', $id, $values );
	} )
	->on( 'postEdit', function ( $editor, $id, $values) {
		logChange( $editor, '수정( dt_sales_company )', $id, $values );
	} )
	->on( 'postRemove', function ( $editor, $id, $values ) {
		logChange( $editor, '삭제( dt_sales_company )', $id, $values );
	} );

	$editor
	->process( $_POST )
	->json();
