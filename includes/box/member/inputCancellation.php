        	<?php
	if ($memberRegist->getErrorCount() > 0) {
	?>
				<?php print create_error_caption($memberRegist->getError())?>
	<?php
	}
	?>

        	<form action="<?php print $_SERVER['REQUEST_URI']?>" method="post">
                <table class="tblInput" width="100%">
                    <tr>
                    	<th align="center" style="text-align: center;">
	                    	<p>本当に退会しますか？</p>
                    	</th>
                    </tr>
                    <tr>
                    	<td align="center" colspan="1" class="bt-td">
                    	<p class="colorRed">※この処理はやり直しできません。</p>
                    	<?=$inputs->submit("","regist","退会する", "circle")?>
                    	</td>
                    </tr>
                </table>
           	</form>