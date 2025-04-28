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
	$editor = Editor::inst( $db, 'dt_sales_history' )
	->fields(
		Field::inst( 'dt_sales_history.CompanyId' )
			->options( 'dt_sales_companys', 'id' )
			->validator( 'Validate::dbValues' ),		
		Field::inst( 'dt_sales_history.Date' ),
		Field::inst( 'dt_sales_history.Details' ),      
		Field::inst( 'dt_sales_history.Attachment' )
			->setFormatter( 'Format::ifEmpty', null )
			->upload( Upload::inst( $_SERVER['DOCUMENT_ROOT'].'/datatables/upload/sales_history/(__ID__)__NAME__' )
				->db( 'dt_sales_history_attachment', 'id', array(
				'filename'    => Upload::DB_FILE_NAME,
				'filesize'    => Upload::DB_FILE_SIZE,
				'web_path'    => Upload::DB_WEB_PATH,
				'system_path' => Upload::DB_SYSTEM_PATH
				) )
				->validator( function ( $file ) {
					return$file['size'] >= ( 10 * 1024 * 1024) ?
					"파일 사이즈 10M이하만 업로드 가능합니다." :
					null;
				} )
			   ->allowedExtensions( [ 'pdf', 'csv', 'hwp', 'txt', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'gif', 'png', 'jpg', 'msg' ], "문서 파일이나 그림 파일을 첨부하세요." )
			),			
		Field::inst( 'dt_sales_history.CreatedBy')->set( Field::SET_CREATE ),
		Field::inst( 'dt_sales_history.CreatedOn')->set( Field::SET_CREATE ),
		Field::inst( 'dt_sales_history.UpdatedBy')->set( Field::SET_EDIT ),
		Field::inst( 'dt_sales_history.UpdatedOn')->set( Field::SET_EDIT )		
		);

	$editor 
	->on( 'preCreate', function ( $editor, $values ) {
		$editor->field( 'dt_sales_history.CompanyId' )->setValue( $_POST['CompanyId'] );			
		$editor->field( 'dt_sales_history.CreatedOn' )->setValue( date("Y-m-d H:i:s") );		
		$editor->field( 'dt_sales_history.CreatedBy' )->setValue( isset($_SESSION['MB_NAME']) ? $_SESSION['MB_NAME'] : null );		
	})
	->on( 'preEdit', function ( $editor, $values ) {
		$editor->field( 'dt_sales_history.UpdatedOn' )->setValue( date("Y-m-d H:i:s") );	
		$editor->field( 'dt_sales_history.UpdatedBy' )->setValue( isset($_SESSION['MB_NAME']) ? $_SESSION['MB_NAME'] : null );		
	})
	->on( 'postCreate', function ( $editor, $id, $values) {
		logChange( $editor, '생성( dt_sales_history )', $id, $values );
	} )
	->on( 'postEdit', function ( $editor, $id, $values) {
		logChange( $editor, '수정( dt_sales_history )', $id, $values );
	} )
	->on( 'postRemove', function ( $editor, $id, $values ) {
		logChange( $editor, '삭제( dt_sales_history )', $id, $values );
	} );

	$editor 
	// ->leftJoin( 'dt_sales_companys', 'dt_sales_companys.id', '=', 'dt_sales_history.CompanyId' )
	->where( 'CompanyId', $_POST['CompanyId'] )
	->process( $_POST )
	->json();

}