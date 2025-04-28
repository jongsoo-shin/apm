<?php

#권한이 사내 사용자(5) 이상이 아니라면
use Corelib\Func;
Func::chklevel(5);

?>     

<div class="row">
	<div class='col-lg-5'>
			<table id="companys" class="display">
				<thead>
					<tr>
						<th>고객사명</th>
						<th>프로젝트명</th>		
						<th>기타사항</th>		
						<th>등록인</th>
						<th>등록일시</th>
						<th>변경인</th>
						<th>변경일시</th>																									
					</tr>
				</thead>
			</table>
	</div>
	
	<div class='col-lg-7'>
		<div><h3> - 고객 정보</h3></div>		
		<div>		  			
			<table id="clients" class="display">
				<thead>
					<tr>
						<th>부서</th>
						<th>이름</th>
						<th>전화번호</th>
						<th>이메일</th>
						<th>기타사항</th>		
						<th>등록인</th>
						<th>등록일시</th>
						<th>변경인</th>
						<th>변경일시</th>											
					</tr>
				</thead>
			</table>
		</div>
		<br>
		<div><h3> - 영업 히스토리</h3></div>			
		<div>		  			
			<table id="history" class="display">
				<thead>
					<tr>
						<th>날짜</th>
						<th>상세내용</th>
						<th>첨부파일</th>	
						<th>등록인</th>
						<th>등록일시</th>
						<th>변경인</th>
						<th>변경일시</th>												
					</tr>
				</thead>
			</table>
		</div>		
    </div>
    
		<div style="display:none">         
    
    </div>
	</div>

