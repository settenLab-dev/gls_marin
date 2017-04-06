<div id="formWrap">
  <h3><B>◆求人応募フォーム</B></h3>
  <p>

<?php if ($jobPlan->getByKey($jobPlan->getKeyValue(), "JOB_FLG_TYPE") == "2"){?>
<font color="red"><B>こちらは職業紹介の求人です。紹介元企業よりご連絡いたします。</B></font></br></br>
<?php } ?>

下記フォームに必要事項を入力後、確認ボタンを押してください。</br></br>
本フォームにご記入される個人情報は今回の求人応募のみに使用させていただくものです。</br>
応募先の採用担当者だけに提供され、第三者に公開することは一切ございません。</br>
また、表示・送信される情報はSSLの暗号化技術によって保護されます。</p>
<!--  <form method="post" action="mail_hotelform.php">-->
    <table class="formTable">
      <tr>
        <th>今回の応募求人</th>
        <td>応募先： <?php print $job->getByKey($job->getKeyValue(), "JOBCOMPANY_NAME")?></br>
	  求人名： <?php print $jobPlan->getByKey($jobPlan->getKeyValue(), "JOB_NAME")?></br>
	  仕事No： J-<?php print $job->getByKey($job->getKeyValue(), "COMPANY_ID")?>-<?php print $jobPlan->getByKey($jobPlan->getKeyValue(), "JOBPLAN_ID")?>
          </select>
	</td>
      </tr>
    </table>
<br/>
    <table class="formTable">
      <tr>
        <th>お名前 <font color="red">※必須</font></th>
                    	<?php print create_error_msg($jobBooking->getErrorByKey("JOBBOOK_NAME1"))?>
        <td>姓<input size="10" type="text" name="JOBBOOK_NAME1" value="<?php print $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_NAME1")?>" />名<input size="10" type="text" name="JOBBOOK_NAME2" value="<?php print $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_NAME2")?>" /></td>
      </tr>
      <tr>
        <th>フリガナ <font color="red">※必須</font></th>
        <td>セイ<input size="10" type="text" name="JOBBOOK_KANA1" value="<?php print $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_NAME_KANA1")?>" />メイ<input size="10" type="text" name="JOBBOOK_KANA2" value="<?php print $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_NAME_KANA2")?>" /></td>
      </tr>
      <tr>
        <th>性別 <font color="red">※必須</font></th>
        <td><input type="radio" id="SEX1" name="SEX" value="1"  /><label for="SEX1" > 男性</label>
          <input type="radio" id="SEX2" name="SEX" value="2"  /><label for="SEX2" > 女性</label>
      </tr>
      <tr>
        <th>生年月日 <font color="red">※必須</font></th><?php print create_error_msg($jobBooking->getErrorByKey("JOBBOOK_BIRTH1"))?>
        <td>西暦<input size="5" type="text" name="JOBBOOK_BIRTH1" /> 年<input size="5" type="text" name="JOBBOOK_BIRTH2" /> 月<input size="5" type="text" name="JOBBOOK_BIRTH3" /> 日</td>
      </tr>
      <tr>
        <th>年齢(半角数字) <font color="red">※必須</font></th>
        <td><input size="5" type="text" name="JOBBOOK_AGE" /> 歳</td>
      </tr>
    </table>
<br/>
  <h3>▼ご連絡先</h3>
    <table class="formTable">
      <tr>
        <th>Mail（半角）<font color="red">※必須</font></th>
        <td><input size="20" type="text" name="MAIL_ADDRESS" value="<?php print $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_LOGIN_ID")?>" /></td>
      </tr>
      <tr>
        <th>ご住所 <font color="red">※必須</font></th>
        <td><input size="5" type="text" name="JOBBOOK_PREF" value="沖縄県" />市町村<input size="20" type="text" name="JOBBOOK_CITY" />番地<input size="20" type="text" name="JOBBOOK_ADD" /></br>建物名<input size="20" type="text" name="JOBBOOK_BILD" /></td>
      </tr>
<!--       <tr>
        <th>最寄り駅 <font color="red">※必須</font></th>
        <td><input size="10" type="text" name="JOBBOOK_ACCESS_STATION" />駅より
	<select name="JOBBOOK_ACCESS_TOOL">
            <option value="徒歩">徒歩</option>
            <option value="車">車</option>
            <option value="バイク">バイク</option>
            <option value="モノレール">モノレール</option>
            <option value="バス">バス</option>
            <option value="自転車">自転車</option>
          </select>で<input size="5" type="text" name="JOBBOOK_ACCESS_TIME" />分</td>
      </tr>
      <tr>
-->
        <th>自宅電話番号（半角）<font color="red">※必須</font></th>
        <td><input size="20" type="text" name="JOBBOOK_TEL1" value="<?php print $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_TEL1")?>" />※携帯電話のみの方はこちらへご記入ください。</td>
      </tr>
      <tr>
        <th>携帯電話番号（半角）</th>
        <td><input size="20" type="text" name="JOBBOOK_TEL2" value="<?php print $sess->getSessionByKey($sess->getSessionLogninKey(), "MEMBER_TEL2")?>" /></td>
      </tr>
<!--      <tr>
        <th>同居されているご家族の状況(該当するもの全て選択) <font color="red">※必須</font></th>
        <td><input name="JOBBOOK_FAMILY[]" type="checkbox" value="単身" /> 単身　
          <input name="JOBBOOK_FAMILY[]" type="checkbox" value="親・兄弟姉妹と同居" /> 親・兄弟姉妹と同居　
          <input name="JOBBOOK_FAMILY[]" type="checkbox" value="配偶者あり" /> 配偶者あり　
          <input name="JOBBOOK_FAMILY[]" type="checkbox" value="子供あり" /> 子供あり</td>
      </tr>
-->
    </table>
<br/>
 <input type="checkbox" id="Panel14" class="ExpandCheckBox" />
  <label class="ExpandHeader" for="Panel14">(任意）▼学歴・資格など ※クリックで入力枠を表示</label>
   <div class="panel14">
    <table class="formTable">
        <th>最終学歴 </th>
        <td><select name="JOBBOOK_EDUCATION">
            <option value="選択してください">選択してください</option>
            <option value="大学院">大学院</option>
            <option value="大学">大学</option>
            <option value="高専">高専</option>
            <option value="短大">短大</option>
            <option value="専門各種学校">専門各種学校</option>
            <option value="高校">高校</option>
            <option value="その他">その他</option>
          </select></td>
      </tr>
      <tr>
        <th>上記卒業校名 <br /></th>
        <td><input type="text" size="30" name="JOBBOOK_SCHOOL_NAME" /></td>
      </tr>
      <tr>
        <th>学部・学科など <br /></th>
        <td><input type="text" size="30" name="JOBBOOK_SCHOOL_CORSE" /></td>
      </tr>
      <tr>
        <th>卒業年月 <br /></th>
        <td>西暦<input type="text" size="5" name="JOBBOOK_GRADUATION_DATE1" />年 <input type="text" size="5" name="JOBBOOK_GRADUATION_DATE2" />月</td>
      </tr>
      <tr>
        <th>その他学歴<br /></th>
        <td>※在学中の学校名/学部/学科/学年/卒業見込み年月・留学・修士課程等／在学中や中途退学など<br/>
		<textarea name="JOBBOOK_SCHOOL_ETC" cols="50" rows="5"></textarea></td>
      </tr>
    </table>
	</div>
<br/>
 <input type="checkbox" id="Panel13" class="ExpandCheckBox" />
  <label class="ExpandHeader" for="Panel13">(任意）▼語学・パソコンスキルなど ※クリックで入力枠を表示</label>
   <div class="panel13">
    <table class="formTable">
      <tr>
        <th>英語の資格</th>
        <td>
	TOEIC<input type="text" size="5" name="JOBBOOK_TOEIC" />点　TOEFL<input type="text" size="5" name="JOBBOOK_TOEFL" />点　英語検定(STEP)<input type="text" size="5" name="JOBBOOK_STEP" />級<br/><br/>
	英会話によるコミュニケーションのレベルを教えてください。<br/>
	<select name="JOBBOOK_E_LEVEL">
		<option value="ビジネス英会話レベル">ビジネス英会話レベル</option>
		<option value="日常会話レベル">日常会話レベル</option>
		<option value="サービスで使えるレベル">サービスで使えるレベル</option>
		<option value="挨拶ができるレベル">挨拶ができるレベル</option>
	</select>
      </tr>
      <tr>
        <th>英語以外の外国語</th>
        <td><textarea name="JOBBOOK_LANGUAGE" cols="50" rows="5"></textarea></td>
      </tr>
      <tr>
        <th>使用可能なOS</th>
        <td><input name="JOBBOOK_OS[]" type="checkbox" value="Windows" /> Windows　
          <input name="JOBBOOK_OS[]" type="checkbox" value="Mac" /> Mac　
          <input name="JOBBOOK_OS[]" type="checkbox" value="Unix" /> Linux(UNIX系）　
          <input name="JOBBOOK_OS[]" type="checkbox" value="Android" /> Android　
          <input name="JOBBOOK_OS[]" type="checkbox" value="iOS" /> iOS　
          <input name="JOBBOOK_OS[]" type="checkbox" value="その他" /> その他</td>
      </tr>
      <tr>
        <th>使用可能なソフト</th>
        <td><input name="JOBBOOK_SOFT[]" type="checkbox" value="word" /> Word　
          <input name="JOBBOOK_SOFT[]" type="checkbox" value="excel" /> Excel　
          <input name="JOBBOOK_SOFT[]" type="checkbox" value="powerpoint" /> Powerpoint　
          <input name="JOBBOOK_SOFT[]" type="checkbox" value="access" /> Access　
          <input name="JOBBOOK_SOFT[]" type="checkbox" value="photohop" /> Photoshop　
          <input name="JOBBOOK_SOFT[]" type="checkbox" value="illustrator" /> Illustrator</td>
      </tr>
      <tr>
        <th>使用可能なホテル関連ソフト</th>
        <td><input name="JOBBOOK_SOFT_HOTEL[]" type="checkbox" value="Fidelio" /> Fidelio　
          <input name="JOBBOOK_SOFT_HOTEL[]" type="checkbox" value="NEHOPS" /> NEHOPS　
          <input name="JOBBOOK_SOFT_HOTEL[]" type="checkbox" value="その他" /> その他　
      </tr>
       <tr>
        <th>その他使用可能ソフト</th>
        <td><textarea name="JOBBOOK_SOFT_ETC" cols="50" rows="5"></textarea></td>
      </tr>
    </table>
    </div>
<br/>
 <input type="checkbox" id="Panel12" class="ExpandCheckBox" />
  <label class="ExpandHeader" for="Panel12">(任意）▼その他資格 ※クリックで入力枠を表示</label>
   <div class="panel12">
    <table class="formTable">
      <tr>
        <th>取得資格など<br /></th>
        <td><textarea name="JOBBOOK_CAPACITY" cols="50" rows="5"></textarea></td>
      </tr>
    </table>
  </div>
</br>
 <input type="checkbox" id="Panel11" class="ExpandCheckBox" />
  <label class="ExpandHeader" for="Panel11">(任意）▼自己PR・その他 ※クリックで入力枠を表示</label>
   <div class="panel11">
  <h3></h3>
    <table class="formTable">
      <tr>
        <th>入社可能時期 </th>
        <td><input type="text" size="30" name="JOBBOOK_WORK_START" /></td>
      </tr>
      <tr>
        <th>現在の年収</th>
        <td><br/><input type="text" size="10" name="JOBBOOK_INCOME" />万円　※ご記入の内容は応募先企業に公開されます。</td>
      </tr>
      <tr>
        <th>自己PR </th>
        <td><textarea name="JOBBOOK_SELF_PR" cols="50" rows="5"></textarea></td>
      </tr>
      <tr>
        <th>備考</th>
        <td>寮、単身赴任、その他、応募先企業へのご希望やご質問をご記入ください。<br/>
	<textarea name="JOBBOOK_MEMO" cols="50" rows="5"></textarea></td>
      </tr>
    </table>
	</div>

<br/>
 <input type="checkbox" id="Panel10" class="ExpandCheckBox" />
  <label class="ExpandHeader" for="Panel10">(任意）▼職務経歴① ※クリックで入力枠を表示</label>
   <div class="panel10">
    <table class="formTable">
      <tr>
        <th>企業名</th>
        <td><input size="30" type="text" name="JOBBOOK_COMPANY1" /></td>
      </tr>
      <tr>
        <th>施設名</th>
        <td><input size="30" type="text" name="JOBBOOK_WORK_COMPANY_NAME1" /></td>
      </tr>
      <tr>
        <th>業種</th>
        <td><input size="30" type="text" name="JOBBOOK_WORK_COMPANY1" /></td>
      </tr>
      <tr>
        <th>在職期間</th>
        <td><select name="JOBBOOK_WORK_PERIOD11">
		<option value="1957">1957年</option>
		<option value="1958">1958年</option>
		<option value="1959">1959年</option>
		<option value="1960">1960年</option>
		<option value="1961">1961年</option>
		<option value="1962">1962年</option>
		<option value="1963">1963年</option>
		<option value="1964">1964年</option>
		<option value="1965">1965年</option>
		<option value="1966">1966年</option>
		<option value="1967">1967年</option>
		<option value="1968">1968年</option>
		<option value="1969">1969年</option>
		<option value="1970">1970年</option>
		<option value="1971">1971年</option>
		<option value="1972">1972年</option>
		<option value="1973">1973年</option>
		<option value="1974">1974年</option>
		<option value="1975">1975年</option>
		<option value="1976">1976年</option>
		<option value="1977">1977年</option>
		<option value="1978">1978年</option>
		<option value="1979">1979年</option>
		<option value="1980">1980年</option>
		<option value="1981">1981年</option>
		<option value="1982">1982年</option>
		<option value="1983">1983年</option>
		<option value="1984">1984年</option>
		<option value="1985">1985年</option>
		<option value="1986">1986年</option>
		<option value="1987">1987年</option>
		<option value="1988">1988年</option>
		<option value="1989">1989年</option>
		<option value="1990">1990年</option>
		<option value="1991">1991年</option>
		<option value="1992">1992年</option>
		<option value="1993">1993年</option>
		<option value="1994">1994年</option>
		<option value="1995">1995年</option>
		<option value="1996">1996年</option>
		<option value="1997">1997年</option>
		<option value="1998">1998年</option>
		<option value="1999">1999年</option>
		<option value="2000">2000年</option>
		<option value="2001">2001年</option>
		<option value="2002">2002年</option>
		<option value="2003">2003年</option>
		<option value="2004">2004年</option>
		<option value="2005">2005年</option>
		<option value="2006">2006年</option>
		<option value="2007">2007年</option>
		<option value="2008">2008年</option>
		<option value="2009">2009年</option>
		<option value="2010">2010年</option>
		<option value="2011">2011年</option>
		<option value="2012">2012年</option>
		<option value="2013">2013年</option>
		<option value="2014">2014年</option>
          </select><select name="JOBBOOK_WORK_PERIOD12">
		<option value="1">1月</option>
		<option value="2">2月</option>
		<option value="3">3月</option>
		<option value="4">4月</option>
		<option value="5">5月</option>
		<option value="6">6月</option>
		<option value="7">7月</option>
		<option value="8">8月</option>
		<option value="9">9月</option>
		<option value="10">10月</option>
		<option value="11">11月</option>
		<option value="12">12月</option>
          </select>
		～<select name="JOBBOOK_WORK_PERIOD13">
		<option value="在職中">在職中</option>
		<option value="1957">1957年</option>
		<option value="1958">1958年</option>
		<option value="1959">1959年</option>
		<option value="1960">1960年</option>
		<option value="1961">1961年</option>
		<option value="1962">1962年</option>
		<option value="1963">1963年</option>
		<option value="1964">1964年</option>
		<option value="1965">1965年</option>
		<option value="1966">1966年</option>
		<option value="1967">1967年</option>
		<option value="1968">1968年</option>
		<option value="1969">1969年</option>
		<option value="1970">1970年</option>
		<option value="1971">1971年</option>
		<option value="1972">1972年</option>
		<option value="1973">1973年</option>
		<option value="1974">1974年</option>
		<option value="1975">1975年</option>
		<option value="1976">1976年</option>
		<option value="1977">1977年</option>
		<option value="1978">1978年</option>
		<option value="1979">1979年</option>
		<option value="1980">1980年</option>
		<option value="1981">1981年</option>
		<option value="1982">1982年</option>
		<option value="1983">1983年</option>
		<option value="1984">1984年</option>
		<option value="1985">1985年</option>
		<option value="1986">1986年</option>
		<option value="1987">1987年</option>
		<option value="1988">1988年</option>
		<option value="1989">1989年</option>
		<option value="1990">1990年</option>
		<option value="1991">1991年</option>
		<option value="1992">1992年</option>
		<option value="1993">1993年</option>
		<option value="1994">1994年</option>
		<option value="1995">1995年</option>
		<option value="1996">1996年</option>
		<option value="1997">1997年</option>
		<option value="1998">1998年</option>
		<option value="1999">1999年</option>
		<option value="2000">2000年</option>
		<option value="2001">2001年</option>
		<option value="2002">2002年</option>
		<option value="2003">2003年</option>
		<option value="2004">2004年</option>
		<option value="2005">2005年</option>
		<option value="2006">2006年</option>
		<option value="2007">2007年</option>
		<option value="2008">2008年</option>
		<option value="2009">2009年</option>
		<option value="2010">2010年</option>
		<option value="2011">2011年</option>
		<option value="2012">2012年</option>
		<option value="2013">2013年</option>
		<option value="2014">2014年</option>
          </select><select name="JOBBOOK_WORK_PERIOD14">
		<option value="在職中">在職中</option>
		<option value="1">1月</option>
		<option value="2">2月</option>
		<option value="3">3月</option>
		<option value="4">4月</option>
		<option value="5">5月</option>
		<option value="6">6月</option>
		<option value="7">7月</option>
		<option value="8">8月</option>
		<option value="9">9月</option>
		<option value="10">10月</option>
		<option value="11">11月</option>
		<option value="12">12月</option>
	</select></td>
      </tr>
      <tr>
        <th>職種</th>
        <td><input type="text" size="30" name="JOBBOOK_WORK_KIND1" /></td>
      </tr>
       <tr>
        <th>役職</th>
        <td><select name="JOBBOOK_WORK_POSITION1">
            <option value="従業員・スタッフ">従業員・スタッフ</option>
            <option value="主任(キャプテンクラス)">主任(キャプテンクラス)</option>
            <option value="係長・アシスタントマネージャー">係長・アシスタントマネージャー</option>
            <option value="課長(マネージャー、店長)">課長(マネージャー、店長)</option>
            <option value="部長(ディレクタークラス)">部長(ディレクタークラス)</option>
            <option value="社長(経営陣)">社長(経営陣)</option>
            <option value="その他">その他</option>
          </select></td>
      </tr>
        <th>雇用形態</th>
        <td><select name="JOBBOOK_WORK_TYPE1">
            <option value="正社員">正社員</option>
            <option value="契約社員">契約社員</option>
            <option value="派遣社員">派遣社員</option>
            <option value="パート・アルバイト">パート・アルバイト</option>
            <option value="その他">その他</option>
          </select></td>
      </tr>
      <tr>
        <th>職務内容・業務内容</th>
        <td><textarea name="JOBBOOK_WORK_DETAIL1" cols="50" rows="5"></textarea></td>
      </tr>
      <tr>
        <th>備考<br /></th>
        <td><textarea name="JOBBOOK_WORK_MEMO1" cols="50" rows="5"></textarea></td>
      </tr>
    </table>
	</div>
</br>
 <input type="checkbox" id="Panel1" class="ExpandCheckBox" />
  <label class="ExpandHeader" for="Panel1">(任意）▼職務経歴②　を入力する　　※クリックで入力枠を表示</label>
   <div class="panel1">
    <table class="formTable">
      <tr>
        <th>企業名</th>
        <td><input size="30" type="text" name="JOBBOOK_COMPANY2" /></td>
      </tr>
      <tr>
        <th>施設名</th>
        <td><input size="30" type="text" name="JOBBOOK_WORK_COMPANY_NAME2" /></td>
      </tr>
      <tr>
        <th>業種</th>
        <td><input size="30" type="text" name="JOBBOOK_WORK_COMPANY2" /></td>
      </tr>
      <tr>
        <th>在職期間</th>
        <td><select name="JOBBOOK_WORK_PERIOD21">
		<option value="1957">1957年</option>
		<option value="1958">1958年</option>
		<option value="1959">1959年</option>
		<option value="1960">1960年</option>
		<option value="1961">1961年</option>
		<option value="1962">1962年</option>
		<option value="1963">1963年</option>
		<option value="1964">1964年</option>
		<option value="1965">1965年</option>
		<option value="1966">1966年</option>
		<option value="1967">1967年</option>
		<option value="1968">1968年</option>
		<option value="1969">1969年</option>
		<option value="1970">1970年</option>
		<option value="1971">1971年</option>
		<option value="1972">1972年</option>
		<option value="1973">1973年</option>
		<option value="1974">1974年</option>
		<option value="1975">1975年</option>
		<option value="1976">1976年</option>
		<option value="1977">1977年</option>
		<option value="1978">1978年</option>
		<option value="1979">1979年</option>
		<option value="1980">1980年</option>
		<option value="1981">1981年</option>
		<option value="1982">1982年</option>
		<option value="1983">1983年</option>
		<option value="1984">1984年</option>
		<option value="1985">1985年</option>
		<option value="1986">1986年</option>
		<option value="1987">1987年</option>
		<option value="1988">1988年</option>
		<option value="1989">1989年</option>
		<option value="1990">1990年</option>
		<option value="1991">1991年</option>
		<option value="1992">1992年</option>
		<option value="1993">1993年</option>
		<option value="1994">1994年</option>
		<option value="1995">1995年</option>
		<option value="1996">1996年</option>
		<option value="1997">1997年</option>
		<option value="1998">1998年</option>
		<option value="1999">1999年</option>
		<option value="2000">2000年</option>
		<option value="2001">2001年</option>
		<option value="2002">2002年</option>
		<option value="2003">2003年</option>
		<option value="2004">2004年</option>
		<option value="2005">2005年</option>
		<option value="2006">2006年</option>
		<option value="2007">2007年</option>
		<option value="2008">2008年</option>
		<option value="2009">2009年</option>
		<option value="2010">2010年</option>
		<option value="2011">2011年</option>
		<option value="2012">2012年</option>
		<option value="2013">2013年</option>
		<option value="2014">2014年</option>
          </select><select name="JOBBOOK_WORK_PERIOD22">
		<option value="1">1月</option>
		<option value="2">2月</option>
		<option value="3">3月</option>
		<option value="4">4月</option>
		<option value="5">5月</option>
		<option value="6">6月</option>
		<option value="7">7月</option>
		<option value="8">8月</option>
		<option value="9">9月</option>
		<option value="10">10月</option>
		<option value="11">11月</option>
		<option value="12">12月</option>
          </select>
		～<select name="JOBBOOK_WORK_PERIOD23">
		<option value="在職中">在職中</option>
		<option value="1957">1957年</option>
		<option value="1958">1958年</option>
		<option value="1959">1959年</option>
		<option value="1960">1960年</option>
		<option value="1961">1961年</option>
		<option value="1962">1962年</option>
		<option value="1963">1963年</option>
		<option value="1964">1964年</option>
		<option value="1965">1965年</option>
		<option value="1966">1966年</option>
		<option value="1967">1967年</option>
		<option value="1968">1968年</option>
		<option value="1969">1969年</option>
		<option value="1970">1970年</option>
		<option value="1971">1971年</option>
		<option value="1972">1972年</option>
		<option value="1973">1973年</option>
		<option value="1974">1974年</option>
		<option value="1975">1975年</option>
		<option value="1976">1976年</option>
		<option value="1977">1977年</option>
		<option value="1978">1978年</option>
		<option value="1979">1979年</option>
		<option value="1980">1980年</option>
		<option value="1981">1981年</option>
		<option value="1982">1982年</option>
		<option value="1983">1983年</option>
		<option value="1984">1984年</option>
		<option value="1985">1985年</option>
		<option value="1986">1986年</option>
		<option value="1987">1987年</option>
		<option value="1988">1988年</option>
		<option value="1989">1989年</option>
		<option value="1990">1990年</option>
		<option value="1991">1991年</option>
		<option value="1992">1992年</option>
		<option value="1993">1993年</option>
		<option value="1994">1994年</option>
		<option value="1995">1995年</option>
		<option value="1996">1996年</option>
		<option value="1997">1997年</option>
		<option value="1998">1998年</option>
		<option value="1999">1999年</option>
		<option value="2000">2000年</option>
		<option value="2001">2001年</option>
		<option value="2002">2002年</option>
		<option value="2003">2003年</option>
		<option value="2004">2004年</option>
		<option value="2005">2005年</option>
		<option value="2006">2006年</option>
		<option value="2007">2007年</option>
		<option value="2008">2008年</option>
		<option value="2009">2009年</option>
		<option value="2010">2010年</option>
		<option value="2011">2011年</option>
		<option value="2012">2012年</option>
		<option value="2013">2013年</option>
		<option value="2014">2014年</option>
          </select><select name="JOBBOOK_WORK_PERIOD24">
		<option value="在職中">在職中</option>
		<option value="1">1月</option>
		<option value="2">2月</option>
		<option value="3">3月</option>
		<option value="4">4月</option>
		<option value="5">5月</option>
		<option value="6">6月</option>
		<option value="7">7月</option>
		<option value="8">8月</option>
		<option value="9">9月</option>
		<option value="10">10月</option>
		<option value="11">11月</option>
		<option value="12">12月</option></td>
      </tr>
      <tr>
        <th>職種</th>
        <td><input type="text" size="30" name="JOBBOOK_WORK_KIND2" /></td>
      </tr>
       <tr>
        <th>役職</th>
        <td><select name="JOBBOOK_WORK_POSITION2">
            <option value="従業員・スタッフ">従業員・スタッフ</option>
            <option value="主任(キャプテンクラス)">主任(キャプテンクラス)</option>
            <option value="係長・アシスタントマネージャー">係長・アシスタントマネージャー</option>
            <option value="課長(マネージャー、店長)">課長(マネージャー、店長)</option>
            <option value="部長(ディレクタークラス)">部長(ディレクタークラス)</option>
            <option value="社長(経営陣)">社長(経営陣)</option>
            <option value="その他">その他</option>
          </select></td>
      </tr>
        <th>雇用形態</th>
        <td><select name="JOBBOOK_WORK_TYPE2">
            <option value="正社員">正社員</option>
            <option value="契約社員">契約社員</option>
            <option value="派遣社員">派遣社員</option>
            <option value="パート・アルバイト">パート・アルバイト</option>
            <option value="その他">その他</option>
          </select></td>
      </tr>
      <tr>
        <th>職務内容・業務内容</th>
        <td><textarea name="JOBBOOK_WORK_DETAIL2" cols="50" rows="5"></textarea></td>
      </tr>
      <tr>
        <th>備考<br /></th>
        <td><textarea name="JOBBOOK_WORK_MEMO2" cols="50" rows="5"></textarea></td>
      </tr>
    </table>
   </div>
</br>
 <input type="checkbox" id="Panel2" class="ExpandCheckBox" />
  <label class="ExpandHeader" for="Panel2">(任意）▼職務経歴③　を入力する　　※クリックで入力枠を表示</label>
   <div class="panel2">
    <table class="formTable">
      <tr>
        <th>企業名</th>
        <td><input size="30" type="text" name="JOBBOOK_COMPANY3" /></td>
      </tr>
      <tr>
        <th>施設名</th>
        <td><input size="30" type="text" name="JOBBOOK_WORK_COMPANY_NAME3" /></td>
      </tr>
      <tr>
        <th>業種</th>
        <td><input size="30" type="text" name="JOBBOOK_WORK_COMPANY3" /></td>
      </tr>
      <tr>
        <th>在職期間</th>
        <td><select name="JOBBOOK_WORK_PERIOD31">
		<option value="1957">1957年</option>
		<option value="1958">1958年</option>
		<option value="1959">1959年</option>
		<option value="1960">1960年</option>
		<option value="1961">1961年</option>
		<option value="1962">1962年</option>
		<option value="1963">1963年</option>
		<option value="1964">1964年</option>
		<option value="1965">1965年</option>
		<option value="1966">1966年</option>
		<option value="1967">1967年</option>
		<option value="1968">1968年</option>
		<option value="1969">1969年</option>
		<option value="1970">1970年</option>
		<option value="1971">1971年</option>
		<option value="1972">1972年</option>
		<option value="1973">1973年</option>
		<option value="1974">1974年</option>
		<option value="1975">1975年</option>
		<option value="1976">1976年</option>
		<option value="1977">1977年</option>
		<option value="1978">1978年</option>
		<option value="1979">1979年</option>
		<option value="1980">1980年</option>
		<option value="1981">1981年</option>
		<option value="1982">1982年</option>
		<option value="1983">1983年</option>
		<option value="1984">1984年</option>
		<option value="1985">1985年</option>
		<option value="1986">1986年</option>
		<option value="1987">1987年</option>
		<option value="1988">1988年</option>
		<option value="1989">1989年</option>
		<option value="1990">1990年</option>
		<option value="1991">1991年</option>
		<option value="1992">1992年</option>
		<option value="1993">1993年</option>
		<option value="1994">1994年</option>
		<option value="1995">1995年</option>
		<option value="1996">1996年</option>
		<option value="1997">1997年</option>
		<option value="1998">1998年</option>
		<option value="1999">1999年</option>
		<option value="2000">2000年</option>
		<option value="2001">2001年</option>
		<option value="2002">2002年</option>
		<option value="2003">2003年</option>
		<option value="2004">2004年</option>
		<option value="2005">2005年</option>
		<option value="2006">2006年</option>
		<option value="2007">2007年</option>
		<option value="2008">2008年</option>
		<option value="2009">2009年</option>
		<option value="2010">2010年</option>
		<option value="2011">2011年</option>
		<option value="2012">2012年</option>
		<option value="2013">2013年</option>
		<option value="2014">2014年</option>
          </select><select name="JOBBOOK_WORK_PERIOD32">
		<option value="1">1月</option>
		<option value="2">2月</option>
		<option value="3">3月</option>
		<option value="4">4月</option>
		<option value="5">5月</option>
		<option value="6">6月</option>
		<option value="7">7月</option>
		<option value="8">8月</option>
		<option value="9">9月</option>
		<option value="10">10月</option>
		<option value="11">11月</option>
		<option value="12">12月</option>
          </select>
		～<select name="JOBBOOK_WORK_PERIOD33">
		<option value="在職中">在職中</option>
		<option value="1957">1957年</option>
		<option value="1958">1958年</option>
		<option value="1959">1959年</option>
		<option value="1960">1960年</option>
		<option value="1961">1961年</option>
		<option value="1962">1962年</option>
		<option value="1963">1963年</option>
		<option value="1964">1964年</option>
		<option value="1965">1965年</option>
		<option value="1966">1966年</option>
		<option value="1967">1967年</option>
		<option value="1968">1968年</option>
		<option value="1969">1969年</option>
		<option value="1970">1970年</option>
		<option value="1971">1971年</option>
		<option value="1972">1972年</option>
		<option value="1973">1973年</option>
		<option value="1974">1974年</option>
		<option value="1975">1975年</option>
		<option value="1976">1976年</option>
		<option value="1977">1977年</option>
		<option value="1978">1978年</option>
		<option value="1979">1979年</option>
		<option value="1980">1980年</option>
		<option value="1981">1981年</option>
		<option value="1982">1982年</option>
		<option value="1983">1983年</option>
		<option value="1984">1984年</option>
		<option value="1985">1985年</option>
		<option value="1986">1986年</option>
		<option value="1987">1987年</option>
		<option value="1988">1988年</option>
		<option value="1989">1989年</option>
		<option value="1990">1990年</option>
		<option value="1991">1991年</option>
		<option value="1992">1992年</option>
		<option value="1993">1993年</option>
		<option value="1994">1994年</option>
		<option value="1995">1995年</option>
		<option value="1996">1996年</option>
		<option value="1997">1997年</option>
		<option value="1998">1998年</option>
		<option value="1999">1999年</option>
		<option value="2000">2000年</option>
		<option value="2001">2001年</option>
		<option value="2002">2002年</option>
		<option value="2003">2003年</option>
		<option value="2004">2004年</option>
		<option value="2005">2005年</option>
		<option value="2006">2006年</option>
		<option value="2007">2007年</option>
		<option value="2008">2008年</option>
		<option value="2009">2009年</option>
		<option value="2010">2010年</option>
		<option value="2011">2011年</option>
		<option value="2012">2012年</option>
		<option value="2013">2013年</option>
		<option value="2014">2014年</option>
          </select><select name="JOBBOOK_WORK_PERIOD34">
		<option value="在職中">在職中</option>
		<option value="1">1月</option>
		<option value="2">2月</option>
		<option value="3">3月</option>
		<option value="4">4月</option>
		<option value="5">5月</option>
		<option value="6">6月</option>
		<option value="7">7月</option>
		<option value="8">8月</option>
		<option value="9">9月</option>
		<option value="10">10月</option>
		<option value="11">11月</option>
		<option value="12">12月</option></td>
      </tr>
      <tr>
        <th>職種</th>
        <td><input type="text" size="30" name="JOBBOOK_WORK_KIND3" /></td>
      </tr>
       <tr>
        <th>役職</th>
        <td><select name="JOBBOOK_WORK_POSITION3">
            <option value="従業員・スタッフ">従業員・スタッフ</option>
            <option value="主任(キャプテンクラス)">主任(キャプテンクラス)</option>
            <option value="係長・アシスタントマネージャー">係長・アシスタントマネージャー</option>
            <option value="課長(マネージャー、店長)">課長(マネージャー、店長)</option>
            <option value="部長(ディレクタークラス)">部長(ディレクタークラス)</option>
            <option value="社長(経営陣)">社長(経営陣)</option>
            <option value="その他">その他</option>
          </select></td>
      </tr>
        <th>雇用形態</th>
        <td><select name="JOBBOOK_WORK_TYPE3">
            <option value="正社員">正社員</option>
            <option value="契約社員">契約社員</option>
            <option value="派遣社員">派遣社員</option>
            <option value="パート・アルバイト">パート・アルバイト</option>
            <option value="その他">その他</option>
          </select></td>
      </tr>
      <tr>
        <th>職務内容・業務内容</th>
        <td><textarea name="JOBBOOK_WORK_DETAIL3" cols="50" rows="5"></textarea></td>
      </tr>
      <tr>
        <th>備考<br /></th>
        <td><textarea name="JOBBOOK_WORK_MEMO3" cols="50" rows="5"></textarea></td>
      </tr>
    </table>
   </div>
</br>
 <input type="checkbox" id="Panel3" class="ExpandCheckBox" />
  <label class="ExpandHeader" for="Panel3">(任意）▼職務経歴④　を入力する　　※クリックで入力枠を表示</label>
   <div class="panel3">
    <table class="formTable">
      <tr>
        <th>企業名</th>
        <td><input size="30" type="text" name="JOBBOOK_COMPANY4" /></td>
      </tr>
      <tr>
        <th>施設名</th>
        <td><input size="30" type="text" name="JOBBOOK_WORK_COMPANY_NAME4" /></td>
      </tr>
      <tr>
        <th>業種</th>
        <td><input size="30" type="text" name="JOBBOOK_WORK_COMPANY4" /></td>
      </tr>
      <tr>
        <th>在職期間</th>
        <td><select name="JOBBOOK_WORK_PERIOD41">
		<option value="1957">1957年</option>
		<option value="1958">1958年</option>
		<option value="1959">1959年</option>
		<option value="1960">1960年</option>
		<option value="1961">1961年</option>
		<option value="1962">1962年</option>
		<option value="1963">1963年</option>
		<option value="1964">1964年</option>
		<option value="1965">1965年</option>
		<option value="1966">1966年</option>
		<option value="1967">1967年</option>
		<option value="1968">1968年</option>
		<option value="1969">1969年</option>
		<option value="1970">1970年</option>
		<option value="1971">1971年</option>
		<option value="1972">1972年</option>
		<option value="1973">1973年</option>
		<option value="1974">1974年</option>
		<option value="1975">1975年</option>
		<option value="1976">1976年</option>
		<option value="1977">1977年</option>
		<option value="1978">1978年</option>
		<option value="1979">1979年</option>
		<option value="1980">1980年</option>
		<option value="1981">1981年</option>
		<option value="1982">1982年</option>
		<option value="1983">1983年</option>
		<option value="1984">1984年</option>
		<option value="1985">1985年</option>
		<option value="1986">1986年</option>
		<option value="1987">1987年</option>
		<option value="1988">1988年</option>
		<option value="1989">1989年</option>
		<option value="1990">1990年</option>
		<option value="1991">1991年</option>
		<option value="1992">1992年</option>
		<option value="1993">1993年</option>
		<option value="1994">1994年</option>
		<option value="1995">1995年</option>
		<option value="1996">1996年</option>
		<option value="1997">1997年</option>
		<option value="1998">1998年</option>
		<option value="1999">1999年</option>
		<option value="2000">2000年</option>
		<option value="2001">2001年</option>
		<option value="2002">2002年</option>
		<option value="2003">2003年</option>
		<option value="2004">2004年</option>
		<option value="2005">2005年</option>
		<option value="2006">2006年</option>
		<option value="2007">2007年</option>
		<option value="2008">2008年</option>
		<option value="2009">2009年</option>
		<option value="2010">2010年</option>
		<option value="2011">2011年</option>
		<option value="2012">2012年</option>
		<option value="2013">2013年</option>
		<option value="2014">2014年</option>
          </select><select name="JOBBOOK_WORK_PERIOD42">
		<option value="1">1月</option>
		<option value="2">2月</option>
		<option value="3">3月</option>
		<option value="4">4月</option>
		<option value="5">5月</option>
		<option value="6">6月</option>
		<option value="7">7月</option>
		<option value="8">8月</option>
		<option value="9">9月</option>
		<option value="10">10月</option>
		<option value="11">11月</option>
		<option value="12">12月</option>
          </select>
		～<select name="JOBBOOK_WORK_PERIOD43">
		<option value="在職中">在職中</option>
		<option value="1957">1957年</option>
		<option value="1958">1958年</option>
		<option value="1959">1959年</option>
		<option value="1960">1960年</option>
		<option value="1961">1961年</option>
		<option value="1962">1962年</option>
		<option value="1963">1963年</option>
		<option value="1964">1964年</option>
		<option value="1965">1965年</option>
		<option value="1966">1966年</option>
		<option value="1967">1967年</option>
		<option value="1968">1968年</option>
		<option value="1969">1969年</option>
		<option value="1970">1970年</option>
		<option value="1971">1971年</option>
		<option value="1972">1972年</option>
		<option value="1973">1973年</option>
		<option value="1974">1974年</option>
		<option value="1975">1975年</option>
		<option value="1976">1976年</option>
		<option value="1977">1977年</option>
		<option value="1978">1978年</option>
		<option value="1979">1979年</option>
		<option value="1980">1980年</option>
		<option value="1981">1981年</option>
		<option value="1982">1982年</option>
		<option value="1983">1983年</option>
		<option value="1984">1984年</option>
		<option value="1985">1985年</option>
		<option value="1986">1986年</option>
		<option value="1987">1987年</option>
		<option value="1988">1988年</option>
		<option value="1989">1989年</option>
		<option value="1990">1990年</option>
		<option value="1991">1991年</option>
		<option value="1992">1992年</option>
		<option value="1993">1993年</option>
		<option value="1994">1994年</option>
		<option value="1995">1995年</option>
		<option value="1996">1996年</option>
		<option value="1997">1997年</option>
		<option value="1998">1998年</option>
		<option value="1999">1999年</option>
		<option value="2000">2000年</option>
		<option value="2001">2001年</option>
		<option value="2002">2002年</option>
		<option value="2003">2003年</option>
		<option value="2004">2004年</option>
		<option value="2005">2005年</option>
		<option value="2006">2006年</option>
		<option value="2007">2007年</option>
		<option value="2008">2008年</option>
		<option value="2009">2009年</option>
		<option value="2010">2010年</option>
		<option value="2011">2011年</option>
		<option value="2012">2012年</option>
		<option value="2013">2013年</option>
		<option value="2014">2014年</option>
          </select><select name="JOBBOOK_WORK_PERIOD44">
		<option value="在職中">在職中</option>
		<option value="1">1月</option>
		<option value="2">2月</option>
		<option value="3">3月</option>
		<option value="4">4月</option>
		<option value="5">5月</option>
		<option value="6">6月</option>
		<option value="7">7月</option>
		<option value="8">8月</option>
		<option value="9">9月</option>
		<option value="10">10月</option>
		<option value="11">11月</option>
		<option value="12">12月</option></td>
      </tr>
      <tr>
        <th>職種</th>
        <td><input type="text" size="30" name="JOBBOOK_WORK_KIND4" /></td>
      </tr>
       <tr>
        <th>役職</th>
        <td><select name="JOBBOOK_WORK_POSITION4">
            <option value="従業員・スタッフ">従業員・スタッフ</option>
            <option value="主任(キャプテンクラス)">主任(キャプテンクラス)</option>
            <option value="係長・アシスタントマネージャー">係長・アシスタントマネージャー</option>
            <option value="課長(マネージャー、店長)">課長(マネージャー、店長)</option>
            <option value="部長(ディレクタークラス)">部長(ディレクタークラス)</option>
            <option value="社長(経営陣)">社長(経営陣)</option>
            <option value="その他">その他</option>
          </select></td>
      </tr>
        <th>雇用形態</th>
        <td><select name="JOBBOOK_WORK_TYPE4">
            <option value="正社員">正社員</option>
            <option value="契約社員">契約社員</option>
            <option value="派遣社員">派遣社員</option>
            <option value="パート・アルバイト">パート・アルバイト</option>
            <option value="その他">その他</option>
          </select></td>
      </tr>
      <tr>
        <th>職務内容・業務内容</th>
        <td><textarea name="JOBBOOK_WORK_DETAIL4" cols="50" rows="5"></textarea></td>
      </tr>
      <tr>
        <th>備考<br /></th>
        <td><textarea name="JOBBOOK_WORK_MEMO4" cols="50" rows="5"></textarea></td>
      </tr>
    </table>
   </div>
</br>
 <input type="checkbox" id="Panel4" class="ExpandCheckBox" />
  <label class="ExpandHeader" for="Panel4">(任意）▼職務経歴⑤　を入力する　　※クリックで入力枠を表示</label>
   <div class="panel4">
    <table class="formTable">
      <tr>
        <th>企業名</th>
        <td><input size="30" type="text" name="JOBBOOK_COMPANY5" /></td>
      </tr>
      <tr>
        <th>施設名</th>
        <td><input size="30" type="text" name="JOBBOOK_WORK_COMPANY_NAME5" /></td>
      </tr>
      <tr>
        <th>業種</th>
        <td><input size="30" type="text" name="JOBBOOK_WORK_COMPANY5" /></td>
      </tr>
      <tr>
        <th>在職期間</th>
        <td><select name="JOBBOOK_WORK_PERIOD51">
		<option value="1957">1957年</option>
		<option value="1958">1958年</option>
		<option value="1959">1959年</option>
		<option value="1960">1960年</option>
		<option value="1961">1961年</option>
		<option value="1962">1962年</option>
		<option value="1963">1963年</option>
		<option value="1964">1964年</option>
		<option value="1965">1965年</option>
		<option value="1966">1966年</option>
		<option value="1967">1967年</option>
		<option value="1968">1968年</option>
		<option value="1969">1969年</option>
		<option value="1970">1970年</option>
		<option value="1971">1971年</option>
		<option value="1972">1972年</option>
		<option value="1973">1973年</option>
		<option value="1974">1974年</option>
		<option value="1975">1975年</option>
		<option value="1976">1976年</option>
		<option value="1977">1977年</option>
		<option value="1978">1978年</option>
		<option value="1979">1979年</option>
		<option value="1980">1980年</option>
		<option value="1981">1981年</option>
		<option value="1982">1982年</option>
		<option value="1983">1983年</option>
		<option value="1984">1984年</option>
		<option value="1985">1985年</option>
		<option value="1986">1986年</option>
		<option value="1987">1987年</option>
		<option value="1988">1988年</option>
		<option value="1989">1989年</option>
		<option value="1990">1990年</option>
		<option value="1991">1991年</option>
		<option value="1992">1992年</option>
		<option value="1993">1993年</option>
		<option value="1994">1994年</option>
		<option value="1995">1995年</option>
		<option value="1996">1996年</option>
		<option value="1997">1997年</option>
		<option value="1998">1998年</option>
		<option value="1999">1999年</option>
		<option value="2000">2000年</option>
		<option value="2001">2001年</option>
		<option value="2002">2002年</option>
		<option value="2003">2003年</option>
		<option value="2004">2004年</option>
		<option value="2005">2005年</option>
		<option value="2006">2006年</option>
		<option value="2007">2007年</option>
		<option value="2008">2008年</option>
		<option value="2009">2009年</option>
		<option value="2010">2010年</option>
		<option value="2011">2011年</option>
		<option value="2012">2012年</option>
		<option value="2013">2013年</option>
		<option value="2014">2014年</option>
          </select><select name="JOBBOOK_WORK_PERIOD52">
		<option value="1">1月</option>
		<option value="2">2月</option>
		<option value="3">3月</option>
		<option value="4">4月</option>
		<option value="5">5月</option>
		<option value="6">6月</option>
		<option value="7">7月</option>
		<option value="8">8月</option>
		<option value="9">9月</option>
		<option value="10">10月</option>
		<option value="11">11月</option>
		<option value="12">12月</option>
          </select>
		～<select name="JOBBOOK_WORK_PERIOD53">
		<option value="在職中">在職中</option>
		<option value="1957">1957年</option>
		<option value="1958">1958年</option>
		<option value="1959">1959年</option>
		<option value="1960">1960年</option>
		<option value="1961">1961年</option>
		<option value="1962">1962年</option>
		<option value="1963">1963年</option>
		<option value="1964">1964年</option>
		<option value="1965">1965年</option>
		<option value="1966">1966年</option>
		<option value="1967">1967年</option>
		<option value="1968">1968年</option>
		<option value="1969">1969年</option>
		<option value="1970">1970年</option>
		<option value="1971">1971年</option>
		<option value="1972">1972年</option>
		<option value="1973">1973年</option>
		<option value="1974">1974年</option>
		<option value="1975">1975年</option>
		<option value="1976">1976年</option>
		<option value="1977">1977年</option>
		<option value="1978">1978年</option>
		<option value="1979">1979年</option>
		<option value="1980">1980年</option>
		<option value="1981">1981年</option>
		<option value="1982">1982年</option>
		<option value="1983">1983年</option>
		<option value="1984">1984年</option>
		<option value="1985">1985年</option>
		<option value="1986">1986年</option>
		<option value="1987">1987年</option>
		<option value="1988">1988年</option>
		<option value="1989">1989年</option>
		<option value="1990">1990年</option>
		<option value="1991">1991年</option>
		<option value="1992">1992年</option>
		<option value="1993">1993年</option>
		<option value="1994">1994年</option>
		<option value="1995">1995年</option>
		<option value="1996">1996年</option>
		<option value="1997">1997年</option>
		<option value="1998">1998年</option>
		<option value="1999">1999年</option>
		<option value="2000">2000年</option>
		<option value="2001">2001年</option>
		<option value="2002">2002年</option>
		<option value="2003">2003年</option>
		<option value="2004">2004年</option>
		<option value="2005">2005年</option>
		<option value="2006">2006年</option>
		<option value="2007">2007年</option>
		<option value="2008">2008年</option>
		<option value="2009">2009年</option>
		<option value="2010">2010年</option>
		<option value="2011">2011年</option>
		<option value="2012">2012年</option>
		<option value="2013">2013年</option>
		<option value="2014">2014年</option>
          </select><select name="JOBBOOK_WORK_PERIOD54">
		<option value="在職中">在職中</option>
		<option value="1">1月</option>
		<option value="2">2月</option>
		<option value="3">3月</option>
		<option value="4">4月</option>
		<option value="5">5月</option>
		<option value="6">6月</option>
		<option value="7">7月</option>
		<option value="8">8月</option>
		<option value="9">9月</option>
		<option value="10">10月</option>
		<option value="11">11月</option>
		<option value="12">12月</option></td>
      </tr>
      <tr>
        <th>職種</th>
        <td><input type="text" size="30" name="JOBBOOK_WORK_KIND5" /></td>
      </tr>
       <tr>
        <th>役職</th>
        <td><select name="JOBBOOK_WORK_POSITION5">
            <option value="従業員・スタッフ">従業員・スタッフ</option>
            <option value="主任(キャプテンクラス)">主任(キャプテンクラス)</option>
            <option value="係長・アシスタントマネージャー">係長・アシスタントマネージャー</option>
            <option value="課長(マネージャー、店長)">課長(マネージャー、店長)</option>
            <option value="部長(ディレクタークラス)">部長(ディレクタークラス)</option>
            <option value="社長(経営陣)">社長(経営陣)</option>
            <option value="その他">その他</option>
          </select></td>
      </tr>
        <th>雇用形態</th>
        <td><select name="JOBBOOK_WORK_TYPE5">
            <option value="正社員">正社員</option>
            <option value="契約社員">契約社員</option>
            <option value="派遣社員">派遣社員</option>
            <option value="パート・アルバイト">パート・アルバイト</option>
            <option value="その他">その他</option>
          </select></td>
      </tr>
      <tr>
        <th>職務内容・業務内容</th>
        <td><textarea name="JOBBOOK_WORK_DETAIL5" cols="50" rows="5"></textarea></td>
      </tr>
      <tr>
        <th>備考<br /></th>
        <td><textarea name="JOBBOOK_WORK_MEMO5" cols="50" rows="5"></textarea></td>
      </tr>
    </table>
   </div>
</br>
 <input type="checkbox" id="Panel5" class="ExpandCheckBox" />
  <label class="ExpandHeader" for="Panel5">(任意）▼職務経歴⑥　を入力する　　※クリックで入力枠を表示</label>
   <div class="panel5">
    <table class="formTable">
      <tr>
        <th>企業名</th>
        <td><input size="30" type="text" name="JOBBOOK_COMPANY6" /></td>
      </tr>
      <tr>
        <th>施設名</th>
        <td><input size="30" type="text" name="JOBBOOK_WORK_COMPANY_NAME6" /></td>
      </tr>
      <tr>
        <th>業種</th>
        <td><input size="30" type="text" name="JOBBOOK_WORK_COMPANY6" /></td>
      </tr>
      <tr>
        <th>在職期間</th>
        <td><select name="JOBBOOK_WORK_PERIOD61">
		<option value="1957">1957年</option>
		<option value="1958">1958年</option>
		<option value="1959">1959年</option>
		<option value="1960">1960年</option>
		<option value="1961">1961年</option>
		<option value="1962">1962年</option>
		<option value="1963">1963年</option>
		<option value="1964">1964年</option>
		<option value="1965">1965年</option>
		<option value="1966">1966年</option>
		<option value="1967">1967年</option>
		<option value="1968">1968年</option>
		<option value="1969">1969年</option>
		<option value="1970">1970年</option>
		<option value="1971">1971年</option>
		<option value="1972">1972年</option>
		<option value="1973">1973年</option>
		<option value="1974">1974年</option>
		<option value="1975">1975年</option>
		<option value="1976">1976年</option>
		<option value="1977">1977年</option>
		<option value="1978">1978年</option>
		<option value="1979">1979年</option>
		<option value="1980">1980年</option>
		<option value="1981">1981年</option>
		<option value="1982">1982年</option>
		<option value="1983">1983年</option>
		<option value="1984">1984年</option>
		<option value="1985">1985年</option>
		<option value="1986">1986年</option>
		<option value="1987">1987年</option>
		<option value="1988">1988年</option>
		<option value="1989">1989年</option>
		<option value="1990">1990年</option>
		<option value="1991">1991年</option>
		<option value="1992">1992年</option>
		<option value="1993">1993年</option>
		<option value="1994">1994年</option>
		<option value="1995">1995年</option>
		<option value="1996">1996年</option>
		<option value="1997">1997年</option>
		<option value="1998">1998年</option>
		<option value="1999">1999年</option>
		<option value="2000">2000年</option>
		<option value="2001">2001年</option>
		<option value="2002">2002年</option>
		<option value="2003">2003年</option>
		<option value="2004">2004年</option>
		<option value="2005">2005年</option>
		<option value="2006">2006年</option>
		<option value="2007">2007年</option>
		<option value="2008">2008年</option>
		<option value="2009">2009年</option>
		<option value="2010">2010年</option>
		<option value="2011">2011年</option>
		<option value="2012">2012年</option>
		<option value="2013">2013年</option>
		<option value="2014">2014年</option>
          </select><select name="JOBBOOK_WORK_PERIOD62">
		<option value="1">1月</option>
		<option value="2">2月</option>
		<option value="3">3月</option>
		<option value="4">4月</option>
		<option value="5">5月</option>
		<option value="6">6月</option>
		<option value="7">7月</option>
		<option value="8">8月</option>
		<option value="9">9月</option>
		<option value="10">10月</option>
		<option value="11">11月</option>
		<option value="12">12月</option>
          </select>
		～<select name="JOBBOOK_WORK_PERIOD63">
		<option value="在職中">在職中</option>
		<option value="1957">1957年</option>
		<option value="1958">1958年</option>
		<option value="1959">1959年</option>
		<option value="1960">1960年</option>
		<option value="1961">1961年</option>
		<option value="1962">1962年</option>
		<option value="1963">1963年</option>
		<option value="1964">1964年</option>
		<option value="1965">1965年</option>
		<option value="1966">1966年</option>
		<option value="1967">1967年</option>
		<option value="1968">1968年</option>
		<option value="1969">1969年</option>
		<option value="1970">1970年</option>
		<option value="1971">1971年</option>
		<option value="1972">1972年</option>
		<option value="1973">1973年</option>
		<option value="1974">1974年</option>
		<option value="1975">1975年</option>
		<option value="1976">1976年</option>
		<option value="1977">1977年</option>
		<option value="1978">1978年</option>
		<option value="1979">1979年</option>
		<option value="1980">1980年</option>
		<option value="1981">1981年</option>
		<option value="1982">1982年</option>
		<option value="1983">1983年</option>
		<option value="1984">1984年</option>
		<option value="1985">1985年</option>
		<option value="1986">1986年</option>
		<option value="1987">1987年</option>
		<option value="1988">1988年</option>
		<option value="1989">1989年</option>
		<option value="1990">1990年</option>
		<option value="1991">1991年</option>
		<option value="1992">1992年</option>
		<option value="1993">1993年</option>
		<option value="1994">1994年</option>
		<option value="1995">1995年</option>
		<option value="1996">1996年</option>
		<option value="1997">1997年</option>
		<option value="1998">1998年</option>
		<option value="1999">1999年</option>
		<option value="2000">2000年</option>
		<option value="2001">2001年</option>
		<option value="2002">2002年</option>
		<option value="2003">2003年</option>
		<option value="2004">2004年</option>
		<option value="2005">2005年</option>
		<option value="2006">2006年</option>
		<option value="2007">2007年</option>
		<option value="2008">2008年</option>
		<option value="2009">2009年</option>
		<option value="2010">2010年</option>
		<option value="2011">2011年</option>
		<option value="2012">2012年</option>
		<option value="2013">2013年</option>
		<option value="2014">2014年</option>
          </select><select name="JOBBOOK_WORK_PERIOD64">
		<option value="在職中">在職中</option>
		<option value="1">1月</option>
		<option value="2">2月</option>
		<option value="3">3月</option>
		<option value="4">4月</option>
		<option value="5">5月</option>
		<option value="6">6月</option>
		<option value="7">7月</option>
		<option value="8">8月</option>
		<option value="9">9月</option>
		<option value="10">10月</option>
		<option value="11">11月</option>
		<option value="12">12月</option></td>
      </tr>
      <tr>
        <th>職種</th>
        <td><input type="text" size="30" name="JOBBOOK_WORK_KIND6" /></td>
      </tr>
       <tr>
        <th>役職</th>
        <td><select name="JOBBOOK_WORK_POSITION6">
            <option value="従業員・スタッフ">従業員・スタッフ</option>
            <option value="主任(キャプテンクラス)">主任(キャプテンクラス)</option>
            <option value="係長・アシスタントマネージャー">係長・アシスタントマネージャー</option>
            <option value="課長(マネージャー、店長)">課長(マネージャー、店長)</option>
            <option value="部長(ディレクタークラス)">部長(ディレクタークラス)</option>
            <option value="社長(経営陣)">社長(経営陣)</option>
            <option value="その他">その他</option>
          </select></td>
      </tr>
        <th>雇用形態</th>
        <td><select name="JOBBOOK_WORK_TYPE6">
            <option value="正社員">正社員</option>
            <option value="契約社員">契約社員</option>
            <option value="派遣社員">派遣社員</option>
            <option value="パート・アルバイト">パート・アルバイト</option>
            <option value="その他">その他</option>
          </select></td>
      </tr>
      <tr>
        <th>職務内容・業務内容</th>
        <td><textarea name="JOBBOOK_WORK_DETAIL6" cols="50" rows="5"></textarea></td>
      </tr>
      <tr>
        <th>備考<br /></th>
        <td><textarea name="JOBBOOK_WORK_MEMO6" cols="50" rows="5"></textarea></td>
      </tr>
    </table>
   </div>
</br>
 <input type="checkbox" id="Panel6" class="ExpandCheckBox" />
  <label class="ExpandHeader" for="Panel6">(任意）▼職務経歴⑦　を入力する　　※クリックで入力枠を表示</label>
   <div class="panel6">
    <table class="formTable">
      <tr>
        <th>企業名</th>
        <td><input size="30" type="text" name="JOBBOOK_COMPANY7" /></td>
      </tr>
      <tr>
        <th>施設名</th>
        <td><input size="30" type="text" name="JOBBOOK_WORK_COMPANY_NAME7" /></td>
      </tr>
      <tr>
        <th>業種</th>
        <td><input size="30" type="text" name="JOBBOOK_WORK_COMPANY7" /></td>
      </tr>
      <tr>
        <th>在職期間</th>
        <td><select name="JOBBOOK_WORK_PERIOD71">
		<option value="1957">1957年</option>
		<option value="1958">1958年</option>
		<option value="1959">1959年</option>
		<option value="1960">1960年</option>
		<option value="1961">1961年</option>
		<option value="1962">1962年</option>
		<option value="1963">1963年</option>
		<option value="1964">1964年</option>
		<option value="1965">1965年</option>
		<option value="1966">1966年</option>
		<option value="1967">1967年</option>
		<option value="1968">1968年</option>
		<option value="1969">1969年</option>
		<option value="1970">1970年</option>
		<option value="1971">1971年</option>
		<option value="1972">1972年</option>
		<option value="1973">1973年</option>
		<option value="1974">1974年</option>
		<option value="1975">1975年</option>
		<option value="1976">1976年</option>
		<option value="1977">1977年</option>
		<option value="1978">1978年</option>
		<option value="1979">1979年</option>
		<option value="1980">1980年</option>
		<option value="1981">1981年</option>
		<option value="1982">1982年</option>
		<option value="1983">1983年</option>
		<option value="1984">1984年</option>
		<option value="1985">1985年</option>
		<option value="1986">1986年</option>
		<option value="1987">1987年</option>
		<option value="1988">1988年</option>
		<option value="1989">1989年</option>
		<option value="1990">1990年</option>
		<option value="1991">1991年</option>
		<option value="1992">1992年</option>
		<option value="1993">1993年</option>
		<option value="1994">1994年</option>
		<option value="1995">1995年</option>
		<option value="1996">1996年</option>
		<option value="1997">1997年</option>
		<option value="1998">1998年</option>
		<option value="1999">1999年</option>
		<option value="2000">2000年</option>
		<option value="2001">2001年</option>
		<option value="2002">2002年</option>
		<option value="2003">2003年</option>
		<option value="2004">2004年</option>
		<option value="2005">2005年</option>
		<option value="2006">2006年</option>
		<option value="2007">2007年</option>
		<option value="2008">2008年</option>
		<option value="2009">2009年</option>
		<option value="2010">2010年</option>
		<option value="2011">2011年</option>
		<option value="2012">2012年</option>
		<option value="2013">2013年</option>
		<option value="2014">2014年</option>
          </select><select name="JOBBOOK_WORK_PERIOD72">
		<option value="1">1月</option>
		<option value="2">2月</option>
		<option value="3">3月</option>
		<option value="4">4月</option>
		<option value="5">5月</option>
		<option value="6">6月</option>
		<option value="7">7月</option>
		<option value="8">8月</option>
		<option value="9">9月</option>
		<option value="10">10月</option>
		<option value="11">11月</option>
		<option value="12">12月</option>
          </select>
		～<select name="JOBBOOK_WORK_PERIOD73">
		<option value="在職中">在職中</option>
		<option value="1957">1957年</option>
		<option value="1958">1958年</option>
		<option value="1959">1959年</option>
		<option value="1960">1960年</option>
		<option value="1961">1961年</option>
		<option value="1962">1962年</option>
		<option value="1963">1963年</option>
		<option value="1964">1964年</option>
		<option value="1965">1965年</option>
		<option value="1966">1966年</option>
		<option value="1967">1967年</option>
		<option value="1968">1968年</option>
		<option value="1969">1969年</option>
		<option value="1970">1970年</option>
		<option value="1971">1971年</option>
		<option value="1972">1972年</option>
		<option value="1973">1973年</option>
		<option value="1974">1974年</option>
		<option value="1975">1975年</option>
		<option value="1976">1976年</option>
		<option value="1977">1977年</option>
		<option value="1978">1978年</option>
		<option value="1979">1979年</option>
		<option value="1980">1980年</option>
		<option value="1981">1981年</option>
		<option value="1982">1982年</option>
		<option value="1983">1983年</option>
		<option value="1984">1984年</option>
		<option value="1985">1985年</option>
		<option value="1986">1986年</option>
		<option value="1987">1987年</option>
		<option value="1988">1988年</option>
		<option value="1989">1989年</option>
		<option value="1990">1990年</option>
		<option value="1991">1991年</option>
		<option value="1992">1992年</option>
		<option value="1993">1993年</option>
		<option value="1994">1994年</option>
		<option value="1995">1995年</option>
		<option value="1996">1996年</option>
		<option value="1997">1997年</option>
		<option value="1998">1998年</option>
		<option value="1999">1999年</option>
		<option value="2000">2000年</option>
		<option value="2001">2001年</option>
		<option value="2002">2002年</option>
		<option value="2003">2003年</option>
		<option value="2004">2004年</option>
		<option value="2005">2005年</option>
		<option value="2006">2006年</option>
		<option value="2007">2007年</option>
		<option value="2008">2008年</option>
		<option value="2009">2009年</option>
		<option value="2010">2010年</option>
		<option value="2011">2011年</option>
		<option value="2012">2012年</option>
		<option value="2013">2013年</option>
		<option value="2014">2014年</option>
          </select><select name="JOBBOOK_WORK_PERIOD74">
		<option value="在職中">在職中</option>
		<option value="1">1月</option>
		<option value="2">2月</option>
		<option value="3">3月</option>
		<option value="4">4月</option>
		<option value="5">5月</option>
		<option value="6">6月</option>
		<option value="7">7月</option>
		<option value="8">8月</option>
		<option value="9">9月</option>
		<option value="10">10月</option>
		<option value="11">11月</option>
		<option value="12">12月</option></td>
      </tr>
      <tr>
        <th>職種</th>
        <td><input type="text" size="30" name="JOBBOOK_WORK_KIND7" /></td>
      </tr>
       <tr>
        <th>役職</th>
        <td><select name="JOBBOOK_WORK_POSITION7">
            <option value="従業員・スタッフ">従業員・スタッフ</option>
            <option value="主任(キャプテンクラス)">主任(キャプテンクラス)</option>
            <option value="係長・アシスタントマネージャー">係長・アシスタントマネージャー</option>
            <option value="課長(マネージャー、店長)">課長(マネージャー、店長)</option>
            <option value="部長(ディレクタークラス)">部長(ディレクタークラス)</option>
            <option value="社長(経営陣)">社長(経営陣)</option>
            <option value="その他">その他</option>
          </select></td>
      </tr>
        <th>雇用形態</th>
        <td><select name="JOBBOOK_WORK_TYPE7">
            <option value="正社員">正社員</option>
            <option value="契約社員">契約社員</option>
            <option value="派遣社員">派遣社員</option>
            <option value="パート・アルバイト">パート・アルバイト</option>
            <option value="その他">その他</option>
          </select></td>
      </tr>
      <tr>
        <th>職務内容・業務内容</th>
        <td><textarea name="JOBBOOK_WORK_DETAIL7" cols="50" rows="5"></textarea></td>
      </tr>
      <tr>
        <th>備考<br /></th>
        <td><textarea name="JOBBOOK_WORK_MEMO7" cols="50" rows="5"></textarea></td>
      </tr>
    </table>
   </div>
</br>
 <input type="checkbox" id="Panel7" class="ExpandCheckBox" />
  <label class="ExpandHeader" for="Panel7">(任意）▼職務経歴⑧　を入力する　　※クリックで入力枠を表示</label>
   <div class="panel7">
    <table class="formTable">
      <tr>
        <th>企業名</th>
        <td><input size="30" type="text" name="JOBBOOK_COMPANY8" /></td>
      </tr>
      <tr>
        <th>施設名</th>
        <td><input size="30" type="text" name="JOBBOOK_WORK_COMPANY_NAME8" /></td>
      </tr>
      <tr>
        <th>業種</th>
        <td><input size="30" type="text" name="JOBBOOK_WORK_COMPANY8" /></td>
      </tr>
      <tr>
        <th>在職期間</th>
        <td><select name="JOBBOOK_WORK_PERIOD81">
		<option value="1957">1957年</option>
		<option value="1958">1958年</option>
		<option value="1959">1959年</option>
		<option value="1960">1960年</option>
		<option value="1961">1961年</option>
		<option value="1962">1962年</option>
		<option value="1963">1963年</option>
		<option value="1964">1964年</option>
		<option value="1965">1965年</option>
		<option value="1966">1966年</option>
		<option value="1967">1967年</option>
		<option value="1968">1968年</option>
		<option value="1969">1969年</option>
		<option value="1970">1970年</option>
		<option value="1971">1971年</option>
		<option value="1972">1972年</option>
		<option value="1973">1973年</option>
		<option value="1974">1974年</option>
		<option value="1975">1975年</option>
		<option value="1976">1976年</option>
		<option value="1977">1977年</option>
		<option value="1978">1978年</option>
		<option value="1979">1979年</option>
		<option value="1980">1980年</option>
		<option value="1981">1981年</option>
		<option value="1982">1982年</option>
		<option value="1983">1983年</option>
		<option value="1984">1984年</option>
		<option value="1985">1985年</option>
		<option value="1986">1986年</option>
		<option value="1987">1987年</option>
		<option value="1988">1988年</option>
		<option value="1989">1989年</option>
		<option value="1990">1990年</option>
		<option value="1991">1991年</option>
		<option value="1992">1992年</option>
		<option value="1993">1993年</option>
		<option value="1994">1994年</option>
		<option value="1995">1995年</option>
		<option value="1996">1996年</option>
		<option value="1997">1997年</option>
		<option value="1998">1998年</option>
		<option value="1999">1999年</option>
		<option value="2000">2000年</option>
		<option value="2001">2001年</option>
		<option value="2002">2002年</option>
		<option value="2003">2003年</option>
		<option value="2004">2004年</option>
		<option value="2005">2005年</option>
		<option value="2006">2006年</option>
		<option value="2007">2007年</option>
		<option value="2008">2008年</option>
		<option value="2009">2009年</option>
		<option value="2010">2010年</option>
		<option value="2011">2011年</option>
		<option value="2012">2012年</option>
		<option value="2013">2013年</option>
		<option value="2014">2014年</option>
          </select><select name="JOBBOOK_WORK_PERIOD82">
		<option value="1">1月</option>
		<option value="2">2月</option>
		<option value="3">3月</option>
		<option value="4">4月</option>
		<option value="5">5月</option>
		<option value="6">6月</option>
		<option value="7">7月</option>
		<option value="8">8月</option>
		<option value="9">9月</option>
		<option value="10">10月</option>
		<option value="11">11月</option>
		<option value="12">12月</option>
          </select>
		～<select name="JOBBOOK_WORK_PERIOD83">
		<option value="在職中">在職中</option>
		<option value="1957">1957年</option>
		<option value="1958">1958年</option>
		<option value="1959">1959年</option>
		<option value="1960">1960年</option>
		<option value="1961">1961年</option>
		<option value="1962">1962年</option>
		<option value="1963">1963年</option>
		<option value="1964">1964年</option>
		<option value="1965">1965年</option>
		<option value="1966">1966年</option>
		<option value="1967">1967年</option>
		<option value="1968">1968年</option>
		<option value="1969">1969年</option>
		<option value="1970">1970年</option>
		<option value="1971">1971年</option>
		<option value="1972">1972年</option>
		<option value="1973">1973年</option>
		<option value="1974">1974年</option>
		<option value="1975">1975年</option>
		<option value="1976">1976年</option>
		<option value="1977">1977年</option>
		<option value="1978">1978年</option>
		<option value="1979">1979年</option>
		<option value="1980">1980年</option>
		<option value="1981">1981年</option>
		<option value="1982">1982年</option>
		<option value="1983">1983年</option>
		<option value="1984">1984年</option>
		<option value="1985">1985年</option>
		<option value="1986">1986年</option>
		<option value="1987">1987年</option>
		<option value="1988">1988年</option>
		<option value="1989">1989年</option>
		<option value="1990">1990年</option>
		<option value="1991">1991年</option>
		<option value="1992">1992年</option>
		<option value="1993">1993年</option>
		<option value="1994">1994年</option>
		<option value="1995">1995年</option>
		<option value="1996">1996年</option>
		<option value="1997">1997年</option>
		<option value="1998">1998年</option>
		<option value="1999">1999年</option>
		<option value="2000">2000年</option>
		<option value="2001">2001年</option>
		<option value="2002">2002年</option>
		<option value="2003">2003年</option>
		<option value="2004">2004年</option>
		<option value="2005">2005年</option>
		<option value="2006">2006年</option>
		<option value="2007">2007年</option>
		<option value="2008">2008年</option>
		<option value="2009">2009年</option>
		<option value="2010">2010年</option>
		<option value="2011">2011年</option>
		<option value="2012">2012年</option>
		<option value="2013">2013年</option>
		<option value="2014">2014年</option>
          </select><select name="JOBBOOK_WORK_PERIOD84">
		<option value="在職中">在職中</option>
		<option value="1">1月</option>
		<option value="2">2月</option>
		<option value="3">3月</option>
		<option value="4">4月</option>
		<option value="5">5月</option>
		<option value="6">6月</option>
		<option value="7">7月</option>
		<option value="8">8月</option>
		<option value="9">9月</option>
		<option value="10">10月</option>
		<option value="11">11月</option>
		<option value="12">12月</option></td>
      </tr>
      <tr>
        <th>職種</th>
        <td><input type="text" size="30" name="JOBBOOK_WORK_KIND8" /></td>
      </tr>
       <tr>
        <th>役職</th>
        <td><select name="JOBBOOK_WORK_POSITION8">
            <option value="従業員・スタッフ">従業員・スタッフ</option>
            <option value="主任(キャプテンクラス)">主任(キャプテンクラス)</option>
            <option value="係長・アシスタントマネージャー">係長・アシスタントマネージャー</option>
            <option value="課長(マネージャー、店長)">課長(マネージャー、店長)</option>
            <option value="部長(ディレクタークラス)">部長(ディレクタークラス)</option>
            <option value="社長(経営陣)">社長(経営陣)</option>
            <option value="その他">その他</option>
          </select></td>
      </tr>
        <th>雇用形態</th>
        <td><select name="JOBBOOK_WORK_TYPE8">
            <option value="正社員">正社員</option>
            <option value="契約社員">契約社員</option>
            <option value="派遣社員">派遣社員</option>
            <option value="パート・アルバイト">パート・アルバイト</option>
            <option value="その他">その他</option>
          </select></td>
      </tr>
      <tr>
        <th>職務内容・業務内容</th>
        <td><textarea name="JOBBOOK_WORK_DETAIL8" cols="50" rows="5"></textarea></td>
      </tr>
      <tr>
        <th>備考<br /></th>
        <td><textarea name="JOBBOOK_WORK_MEMO8" cols="50" rows="5"></textarea></td>
      </tr>
    </table>
   </div>
</br>
 <input type="checkbox" id="Panel8" class="ExpandCheckBox" />
  <label class="ExpandHeader" for="Panel8">(任意）▼職務経歴⑨　を入力する　　※クリックで入力枠を表示</label>
   <div class="panel8">
    <table class="formTable">
      <tr>
        <th>企業名</th>
        <td><input size="30" type="text" name="JOBBOOK_COMPANY9" /></td>
      </tr>
      <tr>
        <th>施設名</th>
        <td><input size="30" type="text" name="JOBBOOK_WORK_COMPANY_NAME9" /></td>
      </tr>
      <tr>
        <th>業種</th>
        <td><input size="30" type="text" name="JOBBOOK_WORK_COMPANY9" /></td>
      </tr>
      <tr>
        <th>在職期間</th>
        <td><select name="JOBBOOK_WORK_PERIOD91">
		<option value="1957">1957年</option>
		<option value="1958">1958年</option>
		<option value="1959">1959年</option>
		<option value="1960">1960年</option>
		<option value="1961">1961年</option>
		<option value="1962">1962年</option>
		<option value="1963">1963年</option>
		<option value="1964">1964年</option>
		<option value="1965">1965年</option>
		<option value="1966">1966年</option>
		<option value="1967">1967年</option>
		<option value="1968">1968年</option>
		<option value="1969">1969年</option>
		<option value="1970">1970年</option>
		<option value="1971">1971年</option>
		<option value="1972">1972年</option>
		<option value="1973">1973年</option>
		<option value="1974">1974年</option>
		<option value="1975">1975年</option>
		<option value="1976">1976年</option>
		<option value="1977">1977年</option>
		<option value="1978">1978年</option>
		<option value="1979">1979年</option>
		<option value="1980">1980年</option>
		<option value="1981">1981年</option>
		<option value="1982">1982年</option>
		<option value="1983">1983年</option>
		<option value="1984">1984年</option>
		<option value="1985">1985年</option>
		<option value="1986">1986年</option>
		<option value="1987">1987年</option>
		<option value="1988">1988年</option>
		<option value="1989">1989年</option>
		<option value="1990">1990年</option>
		<option value="1991">1991年</option>
		<option value="1992">1992年</option>
		<option value="1993">1993年</option>
		<option value="1994">1994年</option>
		<option value="1995">1995年</option>
		<option value="1996">1996年</option>
		<option value="1997">1997年</option>
		<option value="1998">1998年</option>
		<option value="1999">1999年</option>
		<option value="2000">2000年</option>
		<option value="2001">2001年</option>
		<option value="2002">2002年</option>
		<option value="2003">2003年</option>
		<option value="2004">2004年</option>
		<option value="2005">2005年</option>
		<option value="2006">2006年</option>
		<option value="2007">2007年</option>
		<option value="2008">2008年</option>
		<option value="2009">2009年</option>
		<option value="2010">2010年</option>
		<option value="2011">2011年</option>
		<option value="2012">2012年</option>
		<option value="2013">2013年</option>
		<option value="2014">2014年</option>
          </select><select name="JOBBOOK_WORK_PERIOD92">
		<option value="1">1月</option>
		<option value="2">2月</option>
		<option value="3">3月</option>
		<option value="4">4月</option>
		<option value="5">5月</option>
		<option value="6">6月</option>
		<option value="7">7月</option>
		<option value="8">8月</option>
		<option value="9">9月</option>
		<option value="10">10月</option>
		<option value="11">11月</option>
		<option value="12">12月</option>
          </select>
		～<select name="JOBBOOK_WORK_PERIOD93">
		<option value="在職中">在職中</option>
		<option value="1957">1957年</option>
		<option value="1958">1958年</option>
		<option value="1959">1959年</option>
		<option value="1960">1960年</option>
		<option value="1961">1961年</option>
		<option value="1962">1962年</option>
		<option value="1963">1963年</option>
		<option value="1964">1964年</option>
		<option value="1965">1965年</option>
		<option value="1966">1966年</option>
		<option value="1967">1967年</option>
		<option value="1968">1968年</option>
		<option value="1969">1969年</option>
		<option value="1970">1970年</option>
		<option value="1971">1971年</option>
		<option value="1972">1972年</option>
		<option value="1973">1973年</option>
		<option value="1974">1974年</option>
		<option value="1975">1975年</option>
		<option value="1976">1976年</option>
		<option value="1977">1977年</option>
		<option value="1978">1978年</option>
		<option value="1979">1979年</option>
		<option value="1980">1980年</option>
		<option value="1981">1981年</option>
		<option value="1982">1982年</option>
		<option value="1983">1983年</option>
		<option value="1984">1984年</option>
		<option value="1985">1985年</option>
		<option value="1986">1986年</option>
		<option value="1987">1987年</option>
		<option value="1988">1988年</option>
		<option value="1989">1989年</option>
		<option value="1990">1990年</option>
		<option value="1991">1991年</option>
		<option value="1992">1992年</option>
		<option value="1993">1993年</option>
		<option value="1994">1994年</option>
		<option value="1995">1995年</option>
		<option value="1996">1996年</option>
		<option value="1997">1997年</option>
		<option value="1998">1998年</option>
		<option value="1999">1999年</option>
		<option value="2000">2000年</option>
		<option value="2001">2001年</option>
		<option value="2002">2002年</option>
		<option value="2003">2003年</option>
		<option value="2004">2004年</option>
		<option value="2005">2005年</option>
		<option value="2006">2006年</option>
		<option value="2007">2007年</option>
		<option value="2008">2008年</option>
		<option value="2009">2009年</option>
		<option value="2010">2010年</option>
		<option value="2011">2011年</option>
		<option value="2012">2012年</option>
		<option value="2013">2013年</option>
		<option value="2014">2014年</option>
          </select><select name="JOBBOOK_WORK_PERIOD94">
		<option value="在職中">在職中</option>
		<option value="1">1月</option>
		<option value="2">2月</option>
		<option value="3">3月</option>
		<option value="4">4月</option>
		<option value="5">5月</option>
		<option value="6">6月</option>
		<option value="7">7月</option>
		<option value="8">8月</option>
		<option value="9">9月</option>
		<option value="10">10月</option>
		<option value="11">11月</option>
		<option value="12">12月</option></td>
      </tr>
      <tr>
        <th>職種</th>
        <td><input type="text" size="30" name="JOBBOOK_WORK_KIND9" /></td>
      </tr>
       <tr>
        <th>役職</th>
        <td><select name="JOBBOOK_WORK_POSITION9">
            <option value="従業員・スタッフ">従業員・スタッフ</option>
            <option value="主任(キャプテンクラス)">主任(キャプテンクラス)</option>
            <option value="係長・アシスタントマネージャー">係長・アシスタントマネージャー</option>
            <option value="課長(マネージャー、店長)">課長(マネージャー、店長)</option>
            <option value="部長(ディレクタークラス)">部長(ディレクタークラス)</option>
            <option value="社長(経営陣)">社長(経営陣)</option>
            <option value="その他">その他</option>
          </select></td>
      </tr>
        <th>雇用形態</th>
        <td><select name="JOBBOOK_WORK_TYPE9">
            <option value="正社員">正社員</option>
            <option value="契約社員">契約社員</option>
            <option value="派遣社員">派遣社員</option>
            <option value="パート・アルバイト">パート・アルバイト</option>
            <option value="その他">その他</option>
          </select></td>
      </tr>
      <tr>
        <th>職務内容・業務内容</th>
        <td><textarea name="JOBBOOK_WORK_DETAIL9" cols="50" rows="5"></textarea></td>
      </tr>
      <tr>
        <th>備考<br /></th>
        <td><textarea name="JOBBOOK_WORK_MEMO9" cols="50" rows="5"></textarea></td>
      </tr>
    </table>
   </div>
</br>
 <input type="checkbox" id="Panel9" class="ExpandCheckBox" />
  <label class="ExpandHeader" for="Panel9">(任意）▼職務経歴⑩　を入力する　　※クリックで入力枠を表示</label>
   <div class="panel9">
    <table class="formTable">
      <tr>
        <th>企業名</th>
        <td><input size="30" type="text" name="JOBBOOK_COMPANY10" /></td>
      </tr>
      <tr>
        <th>施設名</th>
        <td><input size="30" type="text" name="JOBBOOK_WORK_COMPANY_NAME10" /></td>
      </tr>
      <tr>
        <th>業種</th>
        <td><input size="30" type="text" name="JOBBOOK_WORK_COMPANY10" /></td>
      </tr>
      <tr>
        <th>在職期間</th>
        <td><select name="JOBBOOK_WORK_PERIOD101">
		<option value="1957">1957年</option>
		<option value="1958">1958年</option>
		<option value="1959">1959年</option>
		<option value="1960">1960年</option>
		<option value="1961">1961年</option>
		<option value="1962">1962年</option>
		<option value="1963">1963年</option>
		<option value="1964">1964年</option>
		<option value="1965">1965年</option>
		<option value="1966">1966年</option>
		<option value="1967">1967年</option>
		<option value="1968">1968年</option>
		<option value="1969">1969年</option>
		<option value="1970">1970年</option>
		<option value="1971">1971年</option>
		<option value="1972">1972年</option>
		<option value="1973">1973年</option>
		<option value="1974">1974年</option>
		<option value="1975">1975年</option>
		<option value="1976">1976年</option>
		<option value="1977">1977年</option>
		<option value="1978">1978年</option>
		<option value="1979">1979年</option>
		<option value="1980">1980年</option>
		<option value="1981">1981年</option>
		<option value="1982">1982年</option>
		<option value="1983">1983年</option>
		<option value="1984">1984年</option>
		<option value="1985">1985年</option>
		<option value="1986">1986年</option>
		<option value="1987">1987年</option>
		<option value="1988">1988年</option>
		<option value="1989">1989年</option>
		<option value="1990">1990年</option>
		<option value="1991">1991年</option>
		<option value="1992">1992年</option>
		<option value="1993">1993年</option>
		<option value="1994">1994年</option>
		<option value="1995">1995年</option>
		<option value="1996">1996年</option>
		<option value="1997">1997年</option>
		<option value="1998">1998年</option>
		<option value="1999">1999年</option>
		<option value="2000">2000年</option>
		<option value="2001">2001年</option>
		<option value="2002">2002年</option>
		<option value="2003">2003年</option>
		<option value="2004">2004年</option>
		<option value="2005">2005年</option>
		<option value="2006">2006年</option>
		<option value="2007">2007年</option>
		<option value="2008">2008年</option>
		<option value="2009">2009年</option>
		<option value="2010">2010年</option>
		<option value="2011">2011年</option>
		<option value="2012">2012年</option>
		<option value="2013">2013年</option>
		<option value="2014">2014年</option>
          </select><select name="JOBBOOK_WORK_PERIOD102">
		<option value="1">1月</option>
		<option value="2">2月</option>
		<option value="3">3月</option>
		<option value="4">4月</option>
		<option value="5">5月</option>
		<option value="6">6月</option>
		<option value="7">7月</option>
		<option value="8">8月</option>
		<option value="9">9月</option>
		<option value="10">10月</option>
		<option value="11">11月</option>
		<option value="12">12月</option>
          </select>
		～<select name="JOBBOOK_WORK_PERIOD103">
		<option value="在職中">在職中</option>
		<option value="1957">1957年</option>
		<option value="1958">1958年</option>
		<option value="1959">1959年</option>
		<option value="1960">1960年</option>
		<option value="1961">1961年</option>
		<option value="1962">1962年</option>
		<option value="1963">1963年</option>
		<option value="1964">1964年</option>
		<option value="1965">1965年</option>
		<option value="1966">1966年</option>
		<option value="1967">1967年</option>
		<option value="1968">1968年</option>
		<option value="1969">1969年</option>
		<option value="1970">1970年</option>
		<option value="1971">1971年</option>
		<option value="1972">1972年</option>
		<option value="1973">1973年</option>
		<option value="1974">1974年</option>
		<option value="1975">1975年</option>
		<option value="1976">1976年</option>
		<option value="1977">1977年</option>
		<option value="1978">1978年</option>
		<option value="1979">1979年</option>
		<option value="1980">1980年</option>
		<option value="1981">1981年</option>
		<option value="1982">1982年</option>
		<option value="1983">1983年</option>
		<option value="1984">1984年</option>
		<option value="1985">1985年</option>
		<option value="1986">1986年</option>
		<option value="1987">1987年</option>
		<option value="1988">1988年</option>
		<option value="1989">1989年</option>
		<option value="1990">1990年</option>
		<option value="1991">1991年</option>
		<option value="1992">1992年</option>
		<option value="1993">1993年</option>
		<option value="1994">1994年</option>
		<option value="1995">1995年</option>
		<option value="1996">1996年</option>
		<option value="1997">1997年</option>
		<option value="1998">1998年</option>
		<option value="1999">1999年</option>
		<option value="2000">2000年</option>
		<option value="2001">2001年</option>
		<option value="2002">2002年</option>
		<option value="2003">2003年</option>
		<option value="2004">2004年</option>
		<option value="2005">2005年</option>
		<option value="2006">2006年</option>
		<option value="2007">2007年</option>
		<option value="2008">2008年</option>
		<option value="2009">2009年</option>
		<option value="2010">2010年</option>
		<option value="2011">2011年</option>
		<option value="2012">2012年</option>
		<option value="2013">2013年</option>
		<option value="2014">2014年</option>
          </select><select name="JOBBOOK_WORK_PERIOD104">
		<option value="在職中">在職中</option>
		<option value="1">1月</option>
		<option value="2">2月</option>
		<option value="3">3月</option>
		<option value="4">4月</option>
		<option value="5">5月</option>
		<option value="6">6月</option>
		<option value="7">7月</option>
		<option value="8">8月</option>
		<option value="9">9月</option>
		<option value="10">10月</option>
		<option value="11">11月</option>
		<option value="12">12月</option></td>
      </tr>
      <tr>
        <th>職種</th>
        <td><input type="text" size="30" name="JOBBOOK_WORK_KIND10" /></td>
      </tr>
       <tr>
        <th>役職</th>
        <td><select name="JOBBOOK_WORK_POSITION10">
            <option value="従業員・スタッフ">従業員・スタッフ</option>
            <option value="主任(キャプテンクラス)">主任(キャプテンクラス)</option>
            <option value="係長・アシスタントマネージャー">係長・アシスタントマネージャー</option>
            <option value="課長(マネージャー、店長)">課長(マネージャー、店長)</option>
            <option value="部長(ディレクタークラス)">部長(ディレクタークラス)</option>
            <option value="社長(経営陣)">社長(経営陣)</option>
            <option value="その他">その他</option>
          </select></td>
      </tr>
        <th>雇用形態</th>
        <td><select name="JOBBOOK_WORK_TYPE10">
            <option value="正社員">正社員</option>
            <option value="契約社員">契約社員</option>
            <option value="派遣社員">派遣社員</option>
            <option value="パート・アルバイト">パート・アルバイト</option>
            <option value="その他">その他</option>
          </select></td>
      </tr>
      <tr>
        <th>職務内容・業務内容</th>
        <td><textarea name="JOBBOOK_WORK_DETAIL10" cols="50" rows="5"></textarea></td>
      </tr>
      <tr>
        <th>備考<br /></th>
        <td><textarea name="JOBBOOK_WORK_MEMO10" cols="50" rows="5"></textarea></td>
      </tr>
    </table>
   </div>
<br/>
<br/>
    <div class="mainbox">
                <div class="bottom">
                	<p>応募内容の確認画面へお進み下さい。</p>
                	<?php  print create_error_msg($jobBooking->getErrorByKey("BOOKING_NUMS"))?>
                    <input type="image" src="images/reservation/reservation-submit.jpg" name="confirm" value="a">
                </div>
	</div>
<!--  </form>-->
</div>




                <?php
                $tmp = "";
                $tmp .=  $inputs->hidden("COMPANY_ID", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));
                $tmp .=  $inputs->hidden("JOBPLAN_ID", $collection->getByKey($collection->getKeyValue(), "JOBPLAN_ID"));
                $tmp .=  $inputs->hidden("MEMBER_ID", $collection->getByKey($collection->getKeyValue(), "MEMBER_ID"));
                print $tmp;

//print_r($collection);
                ?>
