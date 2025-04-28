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

	$editor = Editor::inst( $db, 'dt_documents', 'id' )
	->fields(
		Field::inst( 'id' )->set( false ),	      
		Field::inst( 'DocNo' )
			->validator( Validate::notEmpty( ValidateOptions::inst()
				->message( '필수 항목 입니다.' )
			) )
			->validator( Validate::unique( ValidateOptions::inst()
				->message( '사용 중인 번호 입니다.' )
			) ),
		Field::inst( 'Sender' ),     
		Field::inst( 'Date' ),	         
		Field::inst( 'Receiver' ),	
		Field::inst( 'Category' ), 					
		Field::inst( 'Project' ),
		Field::inst( 'Subject' ),
		Field::inst( 'Attachment' )
			->setFormatter( 'Format::ifEmpty', null )
			->upload( Upload::inst( $_SERVER['DOCUMENT_ROOT'].'/datatables/upload/documents/(__ID__)__NAME__' )
				->db( 'dt_documents_attachment', 'id', array(
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
