  $(document).ready(function() {
  	var documentsEditor = new DataTable.Editor( {
		//serverSide: true,
		ajax: {
			url:'/datatables/php/dt_sales_companys.php'
		},
  		table: '#companys',
  		fields: [ 
			{ label: "고객사명:", name: "CompanyKor" },
			{ label: "프로젝트명:", name: "ProjectName" },
			{ label: "기타사항:", name: "Remarks" },	
			{ label: "등록인:", name: "CreatedBy", type: "hidden" },
			{ label: "등록일시:", name: "CreatedOn", type: "hidden" },
			{ label: "변경인:", name: "UpdatedBy", type: "hidden" },
			{ label: "변경일시:", name: "UpdatedOn", type: "hidden" }
  		],
		i18n: //한글설정
		{
			"create": {
				"button": "신규",
				"title":  "<b>신규입력</b>",
				"submit": "등록"
			},
			
			"edit": {
				"button": "편집",
				"title":  "<b>편집</b>",
				"submit": "갱신"
			},
			
			"remove": {
				"button": "삭제",
				"title":  "<b>삭제</b>",
				"submit": "삭제",
				"confirm": {
					"_": "선택한 %d 행을 정말 삭제하시겠습니까?",
					"1": "선택한 행을 정말 삭제하시겠습니까?"
				}
			},
			
			"error": {
				"system": "시스템 에러가 발생했습니다. (자세한 정보를 확인하세요.)"
			},
			
			"multi": {
				"title": "다중 입력",
				"info": "선택된 아이템은 다른 값을 가지고 있습니다. 편집을 원한다면 클릭하세요. 그렇지 않으면 기존의 개별 값으로 유지됩니다.",
				"restore": "변경 취소"
			},
			
			"datetime": {
				"previous": '이전',
				"next":     '다음',
				"months":   [ '1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월' ],
				"weekdays": [ '일', '월', '화', '수', '목', '금', '토' ],
				"amPm":     [ '오전', '오후' ],
				"unknown":  '-'
			}
		}  
  	} );
  
  	var companysTable = $('#companys').DataTable( {
  		dom: 'Bfrtip',
		lengthMenu: [
			[ 10, 15, 25, 50, -1 ],
			[ '10 행', '15 행', '25 행', '50 행', '전체' ]
		],		
  		ajax: '/datatables/php/dt_sales_companys.php',
  		columns: [
  			{ data: "CompanyKor", width: "30%"	},
			{ data: "ProjectName", width: "30%"	},			
			{ data: 'Remarks', width: "40%", orderable: false},
			{ data: "CreatedBy",    visible: false },
      		{ data: "CreatedOn",	visible: false },				
			{ data: "UpdatedBy",	visible: false },
            { data: "UpdatedOn",	visible: false }
  		],
  		select: {
  			style: 'single'
  		},
  		buttons: [		
  			{ extend: 'create', editor: documentsEditor },
  			{ extend: 'edit',   editor: documentsEditor },
  			{ extend: 'remove', editor: documentsEditor },	
			{ extend: "colvis", text: "칼럼", columns: ':gt(0)', postfixButtons: [ { extend : 'colvisRestore',	text : '초기설정으로 복구' } ] }, 			
			{ extend: 'collection', text: '기타',
				buttons: [
					{ extend: "pageLength", text: "페이지 길이" },		
					{ extend: "searchBuilder", text: "조건 검색" },  
					{ extend: 'spacer', style: 'bar' },		
					{ extend: "copy", text: "복사" },		
					{ extend: "excelHtml5", text: "엑셀 변환" },	
					{ extend: "print", text: "출력" }		
				]
			}
  		],	
		pageLength: 10,
		// paging:false,
		// lengthChange: false,
		autoWidth: false,				
		// info:false,		
        order: [0, "asc"],  //회사명로 정렬

		language: //한글설정
		{     
			"decimal":        "",
			"thousands" : 	  ",",
			"emptyTable":     "데이터가 없습니다",
			"info":           "_START_ - _END_ / _TOTAL_",
			"infoEmpty":      "0 - 0 / 0",
			"infoFiltered":   "(총 _MAX_ 개)",
			"infoPostFix":    "",
			"thousands":      ",",
			"lengthMenu":     "페이지당 줄수 _MENU_",
			"loadingRecords": "읽는중...",
			"processing":     "처리중...",
			"search":         "검색:",
			"zeroRecords":    "검색 결과가 없습니다",
			"paginate": {
				"first":      "처음",
				"last":       "마지막",
				"next":       "다음",
				"previous":   "이전"
			},
			"aria": {
				"sortAscending":  ": 오름차순 정렬",
				"sortDescending": ": 내림차순 정렬"
			},
			"select": {
			
				rows: 
				{
					_: "%d 열이 선택되었습니다.",
					0: " "
				}				
				
			},
            "searchBuilder": {
                title: {
                    0: '조건 검색',
                    _: '조건 검색 (%d)'
                },
                condition: '조건',
				clearAll: '조건 초기화',
                delete: '삭제',
				add: '추가',			
				search: '검색'					
							
            }			
		}
  	} );
  
  
  	var clientsEditor = new DataTable.Editor( {
  		ajax: {
  			url: '/datatables/php/dt_sales_clients.php',
  			data: function ( d ) {
  				var selected = companysTable.row( { selected: true } );
  				if ( selected.any() ) {
  					d.CompanyId = selected.data().id;
  				}
  			}
  		},
  		table: '#clients',
  		fields: [
			{ label: "부서:", name: "dt_sales_clients.Department" },
			{ label: "이름:", name: "dt_sales_clients.ClientName" },
			{ label: "전화번호:", name: "dt_sales_clients.TelNumber" }, 
			{ label: "이메일:", name: "dt_sales_clients.Email" },
			{ label: "기타사항:", name: "dt_sales_clients.Remarks" },	
			{ label: "등록인:", name: "dt_sales_clients.CreatedBy", type: "hidden" },
			{ label: "등록일시:", name: "dt_sales_clients.CreatedOn", type: "hidden" },
			{ label: "변경인:", name: "dt_sales_clients.UpdatedBy", type: "hidden" },
			{ label: "변경일시:", name: "dt_sales_clients.UpdatedOn", type: "hidden" }			
  		],
		i18n: //한글설정
		{
			"create": {
				"button": "신규",
				"title":  "<b>신규입력</b>",
				"submit": "등록"
			},
			
			"edit": {
				"button": "편집",
				"title":  "<b>편집</b>",
				"submit": "갱신"
			},
			
			"remove": {
				"button": "삭제",
				"title":  "<b>삭제</b>",
				"submit": "삭제",
				"confirm": {
					"_": "선택한 %d 행을 정말 삭제하시겠습니까?",
					"1": "선택한 행을 정말 삭제하시겠습니까?"
				}
			},
			
			"error": {
				"system": "시스템 에러가 발생했습니다. (자세한 정보를 확인하세요.)"
			},
			
			"multi": {
				"title": "다중 입력",
				"info": "선택된 아이템은 다른 값을 가지고 있습니다. 편집을 원한다면 클릭하세요. 그렇지 않으면 기존의 개별 값으로 유지됩니다.",
				"restore": "변경 취소"
			},
			
			"datetime": {
				"previous": '이전',
				"next":     '다음',
				"months":   [ '1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월' ],
				"weekdays": [ '일', '월', '화', '수', '목', '금', '토' ],
				"amPm":     [ '오전', '오후' ],
				"unknown":  '-'
			}
		}  		
  	} );
  
  	var clientsTable = $('#clients').DataTable( {
  		dom: 'Bfrtip',
  		ajax: {
  			url: '/datatables/php/dt_sales_clients.php',
  			type: 'post',
  			data: function ( d ) {
  				var selected = companysTable.row( { selected: true } );
  				if ( selected.any() ) {
  					d.CompanyId = selected.data().id;
  				}
  			}
  		},
		// lengthMenu: [
		// 	[ 10, 25, 50, -1 ],
		// 	[ '10 행', '25 행', '50 행', '전체' ]
		// ],			
  		columns: [		
  			{ data: 'dt_sales_clients.Department', width: "60px"  },
  			{ data: 'dt_sales_clients.ClientName', width: "60px"  },
  			{ data: 'dt_sales_clients.TelNumber', width: "100px"  },
  			{ data: 'dt_sales_clients.Email', width: "150px"  },
  			{ data: 'dt_sales_clients.Remarks' },
			{ data: "dt_sales_clients.CreatedBy",   visible: false },
			{ data: "dt_sales_clients.CreatedOn",	visible: false },				
			{ data: "dt_sales_clients.UpdatedBy",	visible: false },
			{ data: "dt_sales_clients.UpdatedOn",	visible: false }
  		],
  		select: true,
  		buttons: [		
			{ extend: 'create', editor: clientsEditor },
			{ extend: 'edit',   editor: clientsEditor },
			{ extend: 'remove', editor: clientsEditor },
		    // { extend: "pageLength", text: "페이지 길이" },			
		    { extend: "colvis", text: "칼럼", columns: ':gt(0)', postfixButtons: [ { extend : 'colvisRestore',	text : '초기설정으로 복구' } ] }, 			
		    { extend: 'collection', text: '기타',
			  buttons: [
				  { extend: "searchBuilder", text: "조건 검색" },  
				  { extend: 'spacer', style: 'bar' },		
				  { extend: "copy", text: "복사" },		
				  { extend: "excelHtml5", text: "엑셀 변환" },	
				  { extend: "print", text: "출력" }		
			  ]
		  }
		],	
		paging:false,
		lengthChange: false,
		autoWidth: false,				
		info:false,
		language: //한글설정
		{     
			"decimal":        "",
			"thousands" : 	  ",",
			"emptyTable":     "데이터가 없습니다",
			"info":           "_START_ - _END_ / _TOTAL_",
			"infoEmpty":      "0 - 0 / 0",
			"infoFiltered":   "(총 _MAX_ 개)",
			"infoPostFix":    "",
			"thousands":      ",",
			"lengthMenu":     "페이지당 줄수 _MENU_",
			"loadingRecords": "읽는중...",
			"processing":     "처리중...",
			"search":         "검색:",
			"zeroRecords":    "검색 결과가 없습니다",
			"paginate": {
				"first":      "처음",
				"last":       "마지막",
				"next":       "다음",
				"previous":   "이전"
			},
			"aria": {
				"sortAscending":  ": 오름차순 정렬",
				"sortDescending": ": 내림차순 정렬"
			},
			"select": {
			
				rows: 
				{
					_: "%d 열이 선택되었습니다.",
					0: " "
				}				
				
			},
            "searchBuilder": {
                title: {
                    0: '조건 검색',
                    _: '조건 검색 (%d)'
                },
                condition: '조건',
				clearAll: '조건 초기화',
                delete: '삭제',
				add: '추가',			
				search: '검색'					
							
            }				
		}		
  	} );
  	
	var historyEditor = new DataTable.Editor( {
		ajax: {
			url: '/datatables/php/dt_sales_history.php',
			data: function ( d ) {
				var selected = companysTable.row( { selected: true } );
				if ( selected.any() ) {
					d.CompanyId = selected.data().id;
				}
			}
		},
		table: '#history',
		formOptions: 
		{
			main: {
			focus: null,
				onReturn: 'none'
			}
		},	
		fields: [ 
			{ 
				label: "날짜:", name: "dt_sales_history.Date", type: "datetime",	
				opts: {	format: 'YYYY-MM-DD', momentLocale: 'ko', firstDay: false, autoclose: true },
				default: new Date()		 			
			}, 
			{ label: "상세내용:", name: "dt_sales_history.Details", type: "textarea" }, 
			{
				label: "첨부파일:", name: "dt_sales_history.Attachment", type: "upload",
				display: function ( file_id ) {
					return '<a href="'+historyTable.file( 'dt_sales_history_attachment', file_id ).web_path+'" target="_Blank"  download="'+historyTable.file( 'dt_sales_history_attachment', file_id ).filename+'">'+historyTable.file( 'dt_sales_history_attachment', file_id ).filename+'</a>';
				},
				clearText: "첨부 삭제", noFileText : '첨부 없음', noImageText: '첨부 없음', uploadText: "파일을 선택하세요"
			},
			{ label: "등록인:", name: "dt_sales_history.CreatedBy", type: "hidden" },
			{ label: "등록일시:", name: "dt_sales_history.CreatedOn", type: "hidden" },
			{ label: "변경인:", name: "dt_sales_history.UpdatedBy", type: "hidden" },
			{ label: "변경일시:", name: "dt_sales_history.UpdatedOn", type: "hidden" }						
			
		],	
		i18n: //한글설정
		{
			"create": {
				"button": "신규",
				"title":  "<b>신규입력</b>",
				"submit": "등록"
			},
			
			"edit": {
				"button": "편집",
				"title":  "<b>편집</b>",
				"submit": "갱신"
			},
			
			"remove": {
				"button": "삭제",
				"title":  "<b>삭제</b>",
				"submit": "삭제",
				"confirm": {
					"_": "선택한 %d 행을 정말 삭제하시겠습니까?",
					"1": "선택한 행을 정말 삭제하시겠습니까?"
				}
			},
			
			"error": {
				"system": "시스템 에러가 발생했습니다. (자세한 정보를 확인하세요.)"
			},
			
			"multi": {
				"title": "다중 입력",
				"info": "선택된 아이템은 다른 값을 가지고 있습니다. 편집을 원한다면 클릭하세요. 그렇지 않으면 기존의 개별 값으로 유지됩니다.",
				"restore": "변경 취소"
			},
			
			"datetime": {
				"previous": '이전',
				"next":     '다음',
				"months":   [ '1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월' ],
				"weekdays": [ '일', '월', '화', '수', '목', '금', '토' ],
				"amPm":     [ '오전', '오후' ],
				"unknown":  '-'
			}
		}  		
	} );

	var historyTable = $('#history').DataTable( {
		dom: 'Bfrtip',
		ajax: {
			url: '/datatables/php/dt_sales_history.php',
			type: 'post',
			data: function ( d ) {
				var selected = companysTable.row( { selected: true } );
				if ( selected.any() ) {
					d.CompanyId = selected.data().id;
				}
			}
		},
		lengthMenu: [
			[ 5, 10, 25, 50, -1 ],
			[ '5 행', '10 행', '25 행', '50 행', '전체' ]
		],			
		columns: [		
			{ data: 'dt_sales_history.Date', width: "60px"  },
			{ data: 'dt_sales_history.Details' },
			{ 
				data: 'dt_sales_history.Attachment',
				render: function (file_id) {
					return file_id
						? '<a href="'+historyTable.file( 'dt_sales_history_attachment', file_id ).web_path+'" target="_Blank" download="'+historyTable.file( 'dt_sales_history_attachment', file_id ).filename+'">'+historyTable.file( 'dt_sales_history_attachment', file_id ).filename+'</a>' 
						: null;					
				}
				, width: "100px"
			},
			{ data: "dt_sales_history.CreatedBy", width: "60px" },
			{ data: "dt_sales_history.CreatedOn",	visible: false },				
			{ data: "dt_sales_history.UpdatedBy",	visible: false },
			{ data: "dt_sales_history.UpdatedOn",	visible: false }	
		],
		select: true,
		buttons: [		
			{ extend: 'create', editor: historyEditor },
			{ extend: 'edit',   editor: historyEditor },
			{ extend: 'remove', editor: historyEditor },			
		    { extend: "colvis", text: "칼럼", columns: ':gt(0)', postfixButtons: [ { extend : 'colvisRestore',	text : '초기설정으로 복구' } ] }, 			
		    { extend: 'collection', text: '기타',
			  buttons: [
				  { extend: "pageLength", text: "페이지 길이" },				
				  { extend: "searchBuilder", text: "조건 검색" },  
				  { extend: 'spacer', style: 'bar' },		
				  { extend: "copy", text: "복사" },		
				  { extend: "excelHtml5", text: "엑셀 변환" },	
				  { extend: "print", text: "출력" }		
			  ]
		  }
		],	
		// Order by Date
		order : [ 0, 'desc' ],

	//   paging:false,
	//   lengthChange: false,
    autoWidth: false,				
	//   info:false,
	  language: //한글설정
	  {     
		"decimal":        "",
		"thousands" : 	  ",",
		"emptyTable":     "데이터가 없습니다",
		"info":           "_START_ - _END_ / _TOTAL_",
		"infoEmpty":      "0 - 0 / 0",
		"infoFiltered":   "(총 _MAX_ 개)",
		"infoPostFix":    "",
		"thousands":      ",",
		"lengthMenu":     "페이지당 줄수 _MENU_",
		"loadingRecords": "읽는중...",
		"processing":     "처리중...",
		"search":         "검색:",
		"zeroRecords":    "검색 결과가 없습니다",
		"paginate": {
			"first":      "처음",
			"last":       "마지막",
			"next":       "다음",
			"previous":   "이전"
		},
		"aria": {
			"sortAscending":  ": 오름차순 정렬",
			"sortDescending": ": 내림차순 정렬"
		},
		"select": {
		
			rows: 
			{
				_: "%d 열이 선택되었습니다.",
				0: " "
			}				
			
		},
		"searchBuilder": {
		title: {
			0: '조건 검색',
			_: '조건 검색 (%d)'
		},
		condition: '조건',
		clearAll: '조건 초기화',
		delete: '삭제',
		add: '추가',			
		search: '검색'								
		}			  
	 }		
	} );

	// 고객관리 및 영업히스토리 버튼 비활성화 (영업관리에서 고객사 선택 후 활성화) 
	clientsTable.buttons().disable();		
	historyTable.buttons().disable();

  	companysTable.on( 'select', function (e) {
		clientsTable.ajax.reload();
		historyTable.ajax.reload();	
		clientsTable.buttons().enable();		
		historyTable.buttons().enable();		
  		// clientsEditor
  		// 	.field( 'dt_sales_clients.CompanyId' )
  		// 	.def( companysTable.row( { selected: true } ).data().id );
  	} );
  
  	companysTable.on( 'deselect', function () {
  		clientsTable.ajax.reload();
  		historyTable.ajax.reload();
		clientsTable.buttons().disable();		
		historyTable.buttons().disable();			
  	} );
  	  
  	// documentsEditor.on( 'submitSuccess', function () {
  	// 	clientsTable.ajax.reload();
  	// 	historyTable.ajax.reload();		
  	// } );

	// clientsEditor.on( 'submitSuccess', function () {
	// 	companysTable.ajax.reload();
  	// } );	

  } );