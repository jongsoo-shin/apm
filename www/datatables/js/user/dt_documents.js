  $(document).ready(function() {
  	var documentsEditor = new DataTable.Editor( {
		ajax: {
			url:'/datatables/php/dt_documents.php'
		},
  		table: '#documents',
  		fields: [ 
			{ label: "문서번호:", name: "DocNo",
				default: function () { 
					var today = new Date(); 
					var yy = (today.getFullYear().toString()).slice(-2);       	  
					var mm = ("0" + (today.getMonth()+1).toString()).slice(-2); //January is 0!					
					// var dd = ("0" + (today.getDate()).toString()).slice(-2);   
												
					return 'MK-' + yy  + mm + '-0';     
				}    			
			},				
			{ label: "발송인:", name: "Sender", default: MB_NAME},
			{ label: "발송일:", name: "Date",
				default: function () { 
					var today = new Date(); 
					var yyyy = today.getFullYear();       	  
					var mm = ("0" + (today.getMonth()+1).toString()).slice(-2); //January is 0!					
					var dd = ("0" + (today.getDate()).toString()).slice(-2);   
												
					return yyyy  + '-' + mm + '-' + dd;     
				}   			
			},			
			{ label: "수신처:", name: "Receiver" },
			{
				label: "카테고리:",
				name: "Category",
				type: "select",
                options: ["청구서(인보이스)", "거래명세서(팩킹리스트)", "견적서", "발주서", "REPORT", "기타"],
				default: "견적서"
			},
			{ label: "Project:", name: "Project" },	
			{ label: "문서제목:", name: "Subject" },
			{ label: "첨부파일:", name: "Attachment", type: "upload",
			display: function ( file_id ) {
				return '<a href="'+documentsTable.file( 'dt_documents_attachment', file_id ).web_path+'" target="_Blank"  download="'+documentsTable.file( 'dt_documents_attachment', file_id ).filename+'">'+documentsTable.file( 'dt_documents_attachment', file_id ).filename+'</a>';
				},
				clearText: "첨부 삭제", noFileText : '첨부 없음', noImageText: '첨부 없음', uploadText: "파일을 선택하세요"

			},	
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
  
  	var documentsTable = $('#documents').DataTable( {
  		dom: 'Bfrtip',
		lengthMenu: [
			[ 10, 15, 25, 50, -1 ],
			[ '10 행', '15 행', '25 행', '50 행', '전체' ]
		],		
  		ajax: '/datatables/php/dt_documents.php',
  		columns: [
			{ data: "DocNo", width: "80px" },
			{ data: "Sender", width: "80px" },
			{ data: "Date", width: "80px" },									
			{ data: "Receiver", width: "80px" },			
			{ data: "Category", width: "100px" },					
			{ data: 'Project', width: "150px", orderable: false },
			{ data: 'Subject', width: "300px", orderable: false },
			{
				data: 'Attachment', orderable: false,
				render: function (file_id) {
					return file_id
						? '<a href="'+documentsTable.file( 'dt_documents_attachment', file_id ).web_path+'" target="_Blank" download="'+documentsTable.file( 'dt_documents_attachment', file_id ).filename+'">'+documentsTable.file( 'dt_documents_attachment', file_id ).filename+'</a>' 
						: null;					
				}			
			},						
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
        order: [9, "desc"],  //등록일시 기준 정렬

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
  

  } );