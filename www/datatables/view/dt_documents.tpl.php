<?php
use Corelib\Session;
use Corelib\Func;

#권한이 사내 사용자(5) 이상이 아니라면
Func::chklevel(5);

?>   



<div class="row">
	<table id="documents" class="display">
		<thead>
			<tr>			
				<th>문서번호</th>
				<th>발송인</th>
				<th>발송일</th>
				<th>수신처</th>								
				<th>카테고리</th>																		
				<th>Project</th>										
				<th>문서제목</th>
				<th>첨부파일</th>																												
				<th>등록인</th>
				<th>등록일시</th>
				<th>변경인</th>
				<th>변경일시</th>
			</tr>
		</thead>
	</table>
</div>

