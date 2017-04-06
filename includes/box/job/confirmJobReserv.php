<div id="formWrap">
  <h3><B>◆求人応募フォーム</B></h3>
  <p>下記フォームに必要事項を入力後、確認ボタンを押してください。</br></br>
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
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_NAME1")?>　<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_NAME2")?>
	<input type="hidden" name="JOBBOOK_NAME1" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_NAME1")?>" /><input type="hidden" name="JOBBOOK_NAME2" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_NAME2")?>" /></td>
      </tr>
      <tr>
        <th>フリガナ <font color="red">※必須</font></th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_KANA1")?>　<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_KANA2")?>
	<input type="hidden" name="JOBBOOK_KANA1" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_KANA1")?>" /><input type="hidden" name="JOBBOOK_KANA2" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_KANA2")?>" /></td>
      </tr>
      <tr>
        <th>性別 <font color="red">※必須</font></th>
        <td><?php if($collection->getByKey($collection->getKeyValue(), "SEX") == "1"){
		     print "男性";
		  }
	          else{
	 	     print "女性";
	          }?>
	<input type="hidden" name="SEX" value="<?php print $collection->getByKey($collection->getKeyValue(), "SEX")?>"  />
	</td>
      </tr>
      <tr>
        <th>生年月日 <font color="red">※必須</font></th>
        <td>西暦<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_BIRTH1")?> 年 <?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_BIRTH2")?> 月 <?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_BIRTH3")?> 日
	<input type="hidden" name="JOBBOOK_BIRTH1" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_BIRTH1")?>"  />
	<input type="hidden" name="JOBBOOK_BIRTH2" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_BIRTH2")?>"  />
	<input type="hidden" name="JOBBOOK_BIRTH3" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_BIRTH3")?>"  />
	</td>
      </tr>
      <tr>
        <th>年齢(半角数字) <font color="red">※必須</font></th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_AGE")?> 歳
	<input type="hidden" name="JOBBOOK_AGE" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_AGE")?>"  />
	</td>
      </tr>
    </table>
<br/>
  <h3>▼ご連絡先</h3>
    <table class="formTable">
      <tr>
        <th>Mail（半角）<font color="red">※必須</font></th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "MAIL_ADDRESS")?>
	<input type="hidden" name="MAIL_ADDRESS" value="<?php print $collection->getByKey($collection->getKeyValue(), "MAIL_ADDRESS")?>"  />
	</td>
      </tr>
      <tr>
        <th>ご住所 <font color="red">※必須</font></th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_PREF")?><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_CITY")?><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_ADD")?></br><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_BILD")?>
	<input type="hidden" name="JOBBOOK_PREF" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_PREF")?>"  />
	<input type="hidden" name="JOBBOOK_CITY" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_CITY")?>"  />
	<input type="hidden" name="JOBBOOK_ADD" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_ADD")?>"  />
	<input type="hidden" name="JOBBOOK_BILD" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_BILD")?>"  />
	</td>
      </tr>
<!--
       <tr>
        <th>最寄り駅 <font color="red">※必須</font></th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_ACCESS_STATION")?>駅より
	<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_ACCESS_TOOL")?>で<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_ACCESS_TIME")?>分
	<input type="hidden" name="JOBBOOK_ACCESS_STATION" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_ACCESS_STATION")?>"  />
	<input type="hidden" name="JOBBOOK_ACCESS_TOOL" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_ACCESS_TOOL")?>"  />
	<input type="hidden" name="JOBBOOK_ACCESS_TIME" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_ACCESS_TIME")?>"  />
	</td>
      </tr>
-->
      <tr>
        <th>自宅電話番号（半角）<font color="red">※必須</font></th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_TEL1")?>※携帯電話のみの方はこちらへご記入ください。
	<input type="hidden" name="JOBBOOK_TEL1" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_TEL1")?>"  />
	</td>
      </tr>
      <tr>
        <th>携帯電話番号（半角）</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_TEL2")?>
	<input type="hidden" name="JOBBOOK_TEL2" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_TEL2")?>"  />
	</td>
      </tr>
<!--
      <tr>
        <th>同居されているご家族の状況(該当するもの全て選択) <font color="red">※必須</font></th>
        <td><?php $family = implode("、",$_POST["JOBBOOK_FAMILY"])?>
	<?php print $family?>
	<input type="hidden" name="JOBBOOK_FAMILY" value="<?php print $family?>"  />
	</td>
      </tr>
-->
    </table>
<br/>
  <h3>▼学歴・資格など</h3>
    <table class="formTable">
        <th>最終学歴 </th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_EDUCATION")?>
	<input type="hidden" name="JOBBOOK_EDUCATION" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_EDUCATION")?>"  />
	</td>
      </tr>
      <tr>
        <th>上記卒業校名 <br /></th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_SCHOOL_NAME")?>
	<input type="hidden" name="JOBBOOK_SCHOOL_NAME" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_SCHOOL_NAME")?>"  />
	</td>
      </tr>
      <tr>
        <th>学部・学科など <br /></th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_SCHOOL_CORSE")?>
	<input type="hidden" name="JOBBOOK_SCHOOL_CORSE" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_SCHOOL_CORSE")?>" />
	</td>
      </tr>
      <tr>
        <th>卒業年月 <br /></th>
        <td>西暦<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_GRADUATION_DATE1")?> 年 <?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_GRADUATION_DATE2")?> 月
	<input type="hidden" name="JOBBOOK_GRADUATION_DATE1" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_GRADUATION_DATE1")?>" />
	<input type="hidden" name="JOBBOOK_GRADUATION_DATE2" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_GRADUATION_DATE2")?>" />
	</td>
      </tr>
      <tr>
        <th>その他学歴<br /></th>
        <td>※在学中の学校名/学部/学科/学年/卒業見込み年月・留学・修士課程等／在学中や中途退学など<br/><br/>
	<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_SCHOOL_ETC")?>
	<input type="hidden" name="JOBBOOK_SCHOOL_ETC" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_SCHOOL_ETC")?>" />
	</td>
      </tr>
    </table>
<br/>
  <h3>▼語学・パソコンスキルなど</h3>
    <table class="formTable">
      <tr>
        <th>英語の資格</th>
        <td>
	TOEIC <?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_TOEIC")?> 点　TOEFL <?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_TOEFL")?> 点　英語検定(STEP) <?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_STEP")?> 級<br/><br/>
	英会話によるコミュニケーションのレベルを教えてください。<br/>
	<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_E_LEVEL")?>
	<input type="hidden" name="JOBBOOK_TOEIC" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_TOEIC")?>" />
	<input type="hidden" name="JOBBOOK_TOEFL" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_TOEFL")?>" />
	<input type="hidden" name="JOBBOOK_STEP" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_STEP")?>" />
	<input type="hidden" name="JOBBOOK_E_LEVEL" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_E_LEVEL")?>" />
	</td>
      </tr>
      <tr>
        <th>英語以外の外国語</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_LANGUAGE")?>
	<input type="hidden" name="JOBBOOK_LANGUAGE" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_LANGUAGE")?>" />
	</td>
      </tr>
      <tr>
        <th>使用可能なOS</th>
        <td><?php $os = implode("、",$_POST["JOBBOOK_OS"])?>
	<?php print $os?>
	<input type="hidden" name="JOBBOOK_OS" value="<?php print $os?>" />
	</td>
      </tr>
      <tr>
        <th>使用可能なソフト</th>
        <td><?php $soft = implode("、",$_POST["JOBBOOK_SOFT"])?>
	<?php print $soft?>
	<input type="hidden" name="JOBBOOK_SOFT" value="<?php print $soft?>" />
	</td>
      </tr>
      <tr>
        <th>使用可能なホテル関連ソフト</th>
        <td><?php $soft_hotel = implode("、",$_POST["JOBBOOK_SOFT_HOTEL"])?>
	<?php print $soft_hotel?>
	<input type="hidden" name="JOBBOOK_SOFT_HOTEL" value="<?php print $soft_hotel?>" />
	</td>
      </tr>
       <tr>
        <th>その他使用可能ソフト</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_SOFT_ETC")?>
	<input type="hidden" name="JOBBOOK_SOFT_ETC" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_SOFT_ETC")?>" />
	</td>
      </tr>
    </table>
<br/>
  <h3>▼その他資格</h3>
    <table class="formTable">
      <tr>
        <th>取得資格など<br /></th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_CAPACITY")?>
	<input type="hidden" name="JOBBOOK_CAPACITY" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_CAPACITY")?>" />
	</td>
      </tr>
    </table>
</br>
  <h3>▼自己PR・その他</h3>
    <table class="formTable">
      <tr>
        <th>入社可能時期 </th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_START")?>
	<input type="hidden" name="JOBBOOK_WORK_START" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_START")?>" />
	</td>
      </tr>
      <tr>
        <th>現在の年収</th>
        <td><br/><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_INCOME")?>万円　※ご記入の内容は応募先企業に公開されます。
	<input type="hidden" name="JOBBOOK_INCOME" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_INCOME")?>" />
	</td>
      </tr>
      <tr>
        <th>自己PR </th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_SELF_PR")?>
	<input type="hidden" name="JOBBOOK_SELF_PR" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_SELF_PR")?>" />
	</td>
      </tr>
      <tr>
        <th>備考</th>
        <td>寮、単身赴任、その他、応募先企業へのご希望やご質問をご記入ください。<br/><br/>
	<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_MEMO")?>
	<input type="hidden" name="JOBBOOK_MEMO" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_MEMO")?>" />
	</td>
      </tr>
    </table>

<br/>
  <h3>▼職務経歴①（最近のものよりご記入ください。最大10件まで入力可能です。）</h3>
    <table class="formTable">
      <tr>
        <th>企業名</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_COMPANY1")?>
	<input type="hidden" name="JOBBOOK_COMPANY1" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_COMPANY1")?>" />
	</td>
      </tr>
      <tr>
        <th>施設名</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_COMPANY_NAME1")?>
	<input type="hidden" name="JOBBOOK_WORK_COMPANY_NAME1" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_COMPANY_NAME1")?>" />
	</td>
      </tr>
      <tr>
        <th>業種</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_COMPANY1")?>
	<input type="hidden" name="JOBBOOK_WORK_COMPANY1" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_COMPANY1")?>" />
	</td>
      </tr>
      <tr>
        <th>在職期間</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD11")?>年<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD12")?>月
		～<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD13")?>年<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD14")?>月
	<input type="hidden" name="JOBBOOK_WORK_PERIOD11" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD11")?>" />
	<input type="hidden" name="JOBBOOK_WORK_PERIOD12" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD12")?>" />
	<input type="hidden" name="JOBBOOK_WORK_PERIOD13" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD13")?>" />
	<input type="hidden" name="JOBBOOK_WORK_PERIOD14" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD14")?>" />
	</td>
      </tr>
      <tr>
        <th>職種</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_KIND1")?>
	<input type="hidden" name="JOBBOOK_WORK_KIND1" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_KIND1")?>" />
	</td>
      </tr>
       <tr>
        <th>役職</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_POSITION1")?>
	<input type="hidden" name="JOBBOOK_WORK_POSITION1" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_POSITION1")?>" />
	</td>
      </tr>
        <th>雇用形態</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_TYPE1")?>
	<input type="hidden" name="JOBBOOK_WORK_TYPE1" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_TYPE1")?>" />
	</td>
      </tr>
      <tr>
        <th>職務内容・業務内容</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_DETAIL1")?>
	<input type="hidden" name="JOBBOOK_WORK_DETAIL1" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_DETAIL1")?>" />
	</td>
      </tr>
      <tr>
        <th>備考<br /></th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_MEMO1")?>
	<input type="hidden" name="JOBBOOK_WORK_MEMO1" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_MEMO1")?>" />
	</td>
      </tr>
    </table>
</br>
 <input type="checkbox" id="Panel1" class="ExpandCheckBox" />
  <label class="ExpandHeader" for="Panel1">▼職務経歴②　を入力する　　※クリックで入力枠を表示</label>
   <div class="panel1">
    <table class="formTable">
      <tr>
        <th>企業名</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_COMPANY2")?>
	<input type="hidden" name="JOBBOOK_COMPANY2" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_COMPANY2")?>" />
	</td>
      </tr>
      <tr>
        <th>施設名</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_COMPANY_NAME2")?>
	<input type="hidden" name="JOBBOOK_WORK_COMPANY_NAME2" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_COMPANY_NAME2")?>" />
	</td>
      </tr>
      <tr>
        <th>業種</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_COMPANY2")?>
	<input type="hidden" name="JOBBOOK_WORK_COMPANY2" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_COMPANY2")?>" />
	</td>
      </tr>
      <tr>
        <th>在職期間</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD21")?>年<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD22")?>月
		～<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD23")?>年<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD24")?>月
	<input type="hidden" name="JOBBOOK_WORK_PERIOD21" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD21")?>" />
	<input type="hidden" name="JOBBOOK_WORK_PERIOD22" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD22")?>" />
	<input type="hidden" name="JOBBOOK_WORK_PERIOD23" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD23")?>" />
	<input type="hidden" name="JOBBOOK_WORK_PERIOD24" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD24")?>" />
	</td>
      </tr>
      <tr>
        <th>職種</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_KIND2")?>
	<input type="hidden" name="JOBBOOK_WORK_KIND2" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_KIND2")?>" />
	</td>
      </tr>
       <tr>
        <th>役職</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_POSITION2")?>
	<input type="hidden" name="JOBBOOK_WORK_POSITION2" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_POSITION2")?>" />
	</td>
      </tr>
        <th>雇用形態</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_TYPE2")?>
	<input type="hidden" name="JOBBOOK_WORK_TYPE2" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_TYPE2")?>" />
	</td>
      </tr>
      <tr>
        <th>職務内容・業務内容</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_DETAIL2")?>
	<input type="hidden" name="JOBBOOK_WORK_DETAIL2" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_DETAIL2")?>" />
	</td>
      </tr>
      <tr>
        <th>備考<br /></th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_MEMO2")?>
	<input type="hidden" name="JOBBOOK_WORK_MEMO2" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_MEMO2")?>" />
	</td>
      </tr>
    </table>
   </div>
</br>
 <input type="checkbox" id="Panel2" class="ExpandCheckBox" />
  <label class="ExpandHeader" for="Panel2">▼職務経歴③　を入力する　　※クリックで入力枠を表示</label>
   <div class="panel2">
    <table class="formTable">
      <tr>
        <th>企業名</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_COMPANY3")?>
	<input type="hidden" name="JOBBOOK_COMPANY3" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_COMPANY3")?>" />
	</td>
      </tr>
      <tr>
        <th>施設名</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_COMPANY_NAME3")?>
	<input type="hidden" name="JOBBOOK_WORK_COMPANY_NAME3" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_COMPANY_NAME3")?>" />
	</td>
      </tr>
      <tr>
        <th>業種</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_COMPANY3")?>
	<input type="hidden" name="JOBBOOK_WORK_COMPANY3" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_COMPANY3")?>" />
	</td>
      </tr>
      <tr>
        <th>在職期間</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD31")?>年<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD32")?>月
		～<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD33")?>年<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD34")?>月
	<input type="hidden" name="JOBBOOK_WORK_PERIOD31" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD31")?>" />
	<input type="hidden" name="JOBBOOK_WORK_PERIOD32" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD32")?>" />
	<input type="hidden" name="JOBBOOK_WORK_PERIOD33" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD33")?>" />
	<input type="hidden" name="JOBBOOK_WORK_PERIOD34" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD34")?>" />
	</td>
      </tr>
      <tr>
        <th>職種</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_KIND3")?>
	<input type="hidden" name="JOBBOOK_WORK_KIND3" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_KIND3")?>" />
	</td>
      </tr>
       <tr>
        <th>役職</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_POSITION3")?>
	<input type="hidden" name="JOBBOOK_WORK_POSITION3" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_POSITION3")?>" />
	</td>
      </tr>
        <th>雇用形態</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_TYPE3")?>
	<input type="hidden" name="JOBBOOK_WORK_TYPE3" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_TYPE3")?>" />
	</td>
      </tr>
      <tr>
        <th>職務内容・業務内容</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_DETAIL3")?>
	<input type="hidden" name="JOBBOOK_WORK_DETAIL3" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_DETAIL3")?>" />
	</td>
      </tr>
      <tr>
        <th>備考<br /></th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_MEMO3")?>
	<input type="hidden" name="JOBBOOK_WORK_MEMO3" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_MEMO3")?>" />
	</td>
      </tr>
    </table>
   </div>
</br>
 <input type="checkbox" id="Panel3" class="ExpandCheckBox" />
  <label class="ExpandHeader" for="Panel3">▼職務経歴④　を入力する　　※クリックで入力枠を表示</label>
   <div class="panel3">
    <table class="formTable">
      <tr>
        <th>企業名</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_COMPANY4")?>
	<input type="hidden" name="JOBBOOK_COMPANY4" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_COMPANY4")?>" />
	</td>
      </tr>
      <tr>
        <th>施設名</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_COMPANY_NAME4")?>
	<input type="hidden" name="JOBBOOK_WORK_COMPANY_NAME4" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_COMPANY_NAME4")?>" />
	</td>
      </tr>
      <tr>
        <th>業種</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_COMPANY4")?>
	<input type="hidden" name="JOBBOOK_WORK_COMPANY4" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_COMPANY4")?>" />
	</td>
      </tr>
      <tr>
        <th>在職期間</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD41")?>年<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD42")?>月
		～<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD43")?>年<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD44")?>月
	<input type="hidden" name="JOBBOOK_WORK_PERIOD41" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD41")?>" />
	<input type="hidden" name="JOBBOOK_WORK_PERIOD42" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD42")?>" />
	<input type="hidden" name="JOBBOOK_WORK_PERIOD43" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD43")?>" />
	<input type="hidden" name="JOBBOOK_WORK_PERIOD44" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD44")?>" />
	</td>
      </tr>
      <tr>
        <th>職種</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_KIND4")?>
	<input type="hidden" name="JOBBOOK_WORK_KIND4" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_KIND4")?>" />
	</td>
      </tr>
       <tr>
        <th>役職</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_POSITION4")?>
	<input type="hidden" name="JOBBOOK_WORK_POSITION4" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_POSITION4")?>" />
	</td>
      </tr>
        <th>雇用形態</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_TYPE4")?>
	<input type="hidden" name="JOBBOOK_WORK_TYPE4" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_TYPE4")?>" />
	</td>
      </tr>
      <tr>
        <th>職務内容・業務内容</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_DETAIL4")?>
	<input type="hidden" name="JOBBOOK_WORK_DETAIL4" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_DETAIL4")?>" />
	</td>
      </tr>
      <tr>
        <th>備考<br /></th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_MEMO4")?>
	<input type="hidden" name="JOBBOOK_WORK_MEMO4" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_MEMO4")?>" />
	</td>
      </tr>
    </table>
   </div>
</br>
 <input type="checkbox" id="Panel4" class="ExpandCheckBox" />
  <label class="ExpandHeader" for="Panel4">▼職務経歴⑤　を入力する　　※クリックで入力枠を表示</label>
   <div class="panel4">
    <table class="formTable">
      <tr>
        <th>企業名</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_COMPANY5")?>
	<input type="hidden" name="JOBBOOK_COMPANY5" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_COMPANY5")?>" />
	</td>
      </tr>
      <tr>
        <th>施設名</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_COMPANY_NAME5")?>
	<input type="hidden" name="JOBBOOK_WORK_COMPANY_NAME5" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_COMPANY_NAME5")?>" />
	</td>
      </tr>
      <tr>
        <th>業種</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_COMPANY5")?>
	<input type="hidden" name="JOBBOOK_WORK_COMPANY5" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_COMPANY5")?>" />
	</td>
      </tr>
      <tr>
        <th>在職期間</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD51")?>年<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD52")?>月
		～<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD53")?>年<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD54")?>月
	<input type="hidden" name="JOBBOOK_WORK_PERIOD51" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD51")?>" />
	<input type="hidden" name="JOBBOOK_WORK_PERIOD52" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD52")?>" />
	<input type="hidden" name="JOBBOOK_WORK_PERIOD53" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD53")?>" />
	<input type="hidden" name="JOBBOOK_WORK_PERIOD54" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD54")?>" />
	</td>
      </tr>
      <tr>
        <th>職種</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_KIND5")?>
	<input type="hidden" name="JOBBOOK_WORK_KIND5" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_KIND5")?>" />
	</td>
      </tr>
       <tr>
        <th>役職</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_POSITION5")?>
	<input type="hidden" name="JOBBOOK_WORK_POSITION5" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_POSITION5")?>" />
	</td>
      </tr>
        <th>雇用形態</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_TYPE5")?>
	<input type="hidden" name="JOBBOOK_WORK_TYPE5" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_TYPE5")?>" />
	</td>
      </tr>
      <tr>
        <th>職務内容・業務内容</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_DETAIL5")?>
	<input type="hidden" name="JOBBOOK_WORK_DETAIL5" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_DETAIL5")?>" />
	</td>
      </tr>
      <tr>
        <th>備考<br /></th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_MEMO5")?>
	<input type="hidden" name="JOBBOOK_WORK_MEMO5" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_MEMO5")?>" />
	</td>
      </tr>
    </table>
   </div>
</br>
 <input type="checkbox" id="Panel5" class="ExpandCheckBox" />
  <label class="ExpandHeader" for="Panel5">▼職務経歴⑥　を入力する　　※クリックで入力枠を表示</label>
   <div class="panel5">
    <table class="formTable">
      <tr>
        <th>企業名</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_COMPANY6")?>
	<input type="hidden" name="JOBBOOK_COMPANY6" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_COMPANY6")?>" />
	</td>
      </tr>
      <tr>
        <th>施設名</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_COMPANY_NAME6")?>
	<input type="hidden" name="JOBBOOK_WORK_COMPANY_NAME6" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_COMPANY_NAME6")?>" />
	</td>
      </tr>
      <tr>
        <th>業種</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_COMPANY6")?>
	<input type="hidden" name="JOBBOOK_WORK_COMPANY6" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_COMPANY6")?>" />
	</td>
      </tr>
      <tr>
        <th>在職期間</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD61")?>年<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD62")?>月
		～<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD63")?>年<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD64")?>月
	<input type="hidden" name="JOBBOOK_WORK_PERIOD61" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD61")?>" />
	<input type="hidden" name="JOBBOOK_WORK_PERIOD62" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD62")?>" />
	<input type="hidden" name="JOBBOOK_WORK_PERIOD63" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD63")?>" />
	<input type="hidden" name="JOBBOOK_WORK_PERIOD64" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD64")?>" />
	</td>
      </tr>
      <tr>
        <th>職種</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_KIND6")?>
	<input type="hidden" name="JOBBOOK_WORK_KIND6" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_KIND6")?>" />
	</td>
      </tr>
       <tr>
        <th>役職</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_POSITION6")?>
	<input type="hidden" name="JOBBOOK_WORK_POSITION6" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_POSITION6")?>" />
	</td>
      </tr>
        <th>雇用形態</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_TYPE6")?>
	<input type="hidden" name="JOBBOOK_WORK_TYPE6" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_TYPE6")?>" />
	</td>
      </tr>
      <tr>
        <th>職務内容・業務内容</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_DETAIL6")?>
	<input type="hidden" name="JOBBOOK_WORK_DETAIL6" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_DETAIL6")?>" />
	</td>
      </tr>
      <tr>
        <th>備考<br /></th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_MEMO6")?>
	<input type="hidden" name="JOBBOOK_WORK_MEMO6" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_MEMO6")?>" />
	</td>
      </tr>
    </table>
   </div>
</br>
 <input type="checkbox" id="Panel6" class="ExpandCheckBox" />
  <label class="ExpandHeader" for="Panel6">▼職務経歴⑦　を入力する　　※クリックで入力枠を表示</label>
   <div class="panel6">
    <table class="formTable">
      <tr>
        <th>企業名</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_COMPANY7")?>
	<input type="hidden" name="JOBBOOK_COMPANY7" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_COMPANY7")?>" />
	</td>
      </tr>
      <tr>
        <th>施設名</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_COMPANY_NAME7")?>
	<input type="hidden" name="JOBBOOK_WORK_COMPANY_NAME7" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_COMPANY_NAME7")?>" />
	</td>
      </tr>
      <tr>
        <th>業種</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_COMPANY7")?>
	<input type="hidden" name="JOBBOOK_WORK_COMPANY7" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_COMPANY7")?>" />
	</td>
      </tr>
      <tr>
        <th>在職期間</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD71")?>年<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD72")?>月
		～<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD73")?>年<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD74")?>月
	<input type="hidden" name="JOBBOOK_WORK_PERIOD71" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD71")?>" />
	<input type="hidden" name="JOBBOOK_WORK_PERIOD72" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD72")?>" />
	<input type="hidden" name="JOBBOOK_WORK_PERIOD73" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD73")?>" />
	<input type="hidden" name="JOBBOOK_WORK_PERIOD74" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD74")?>" />
	</td>
      </tr>
      <tr>
        <th>職種</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_KIND7")?>
	<input type="hidden" name="JOBBOOK_WORK_KIND7" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_KIND7")?>" />
	</td>
      </tr>
       <tr>
        <th>役職</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_POSITION7")?>
	<input type="hidden" name="JOBBOOK_WORK_POSITION7" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_POSITION7")?>" />
	</td>
      </tr>
        <th>雇用形態</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_TYPE7")?>
	<input type="hidden" name="JOBBOOK_WORK_TYPE7" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_TYPE7")?>" />
	</td>
      </tr>
      <tr>
        <th>職務内容・業務内容</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_DETAIL7")?>
	<input type="hidden" name="JOBBOOK_WORK_DETAIL7" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_DETAIL7")?>" />
	</td>
      </tr>
      <tr>
        <th>備考<br /></th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_MEMO7")?>
	<input type="hidden" name="JOBBOOK_WORK_MEMO7" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_MEMO7")?>" />
	</td>
      </tr>
    </table>
   </div>
</br>
 <input type="checkbox" id="Panel7" class="ExpandCheckBox" />
  <label class="ExpandHeader" for="Panel7">▼職務経歴⑧　を入力する　　※クリックで入力枠を表示</label>
   <div class="panel7">
    <table class="formTable">
      <tr>
        <th>企業名</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_COMPANY8")?>
	<input type="hidden" name="JOBBOOK_COMPANY8" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_COMPANY8")?>" />
	</td>
      </tr>
      <tr>
        <th>施設名</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_COMPANY_NAME8")?>
	<input type="hidden" name="JOBBOOK_WORK_COMPANY_NAME8" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_COMPANY_NAME8")?>" />
	</td>
      </tr>
      <tr>
        <th>業種</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_COMPANY8")?>
	<input type="hidden" name="JOBBOOK_WORK_COMPANY8" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_COMPANY8")?>" />
	</td>
      </tr>
      <tr>
        <th>在職期間</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD81")?>年<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD82")?>月
		～<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD83")?>年<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD84")?>月
	<input type="hidden" name="JOBBOOK_WORK_PERIOD81" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD81")?>" />
	<input type="hidden" name="JOBBOOK_WORK_PERIOD82" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD82")?>" />
	<input type="hidden" name="JOBBOOK_WORK_PERIOD83" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD83")?>" />
	<input type="hidden" name="JOBBOOK_WORK_PERIOD84" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD84")?>" />
	</td>
      </tr>
      <tr>
        <th>職種</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_KIND8")?>
	<input type="hidden" name="JOBBOOK_WORK_KIND8" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_KIND8")?>" />
	</td>
      </tr>
       <tr>
        <th>役職</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_POSITION8")?>
	<input type="hidden" name="JOBBOOK_WORK_POSITION8" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_POSITION8")?>" />
	</td>
      </tr>
        <th>雇用形態</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_TYPE8")?>
	<input type="hidden" name="JOBBOOK_WORK_TYPE8" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_TYPE8")?>" />
	</td>
      </tr>
      <tr>
        <th>職務内容・業務内容</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_DETAIL8")?>
	<input type="hidden" name="JOBBOOK_WORK_DETAIL8" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_DETAIL8")?>" />
	</td>
      </tr>
      <tr>
        <th>備考<br /></th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_MEMO8")?>
	<input type="hidden" name="JOBBOOK_WORK_MEMO8" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_MEMO8")?>" />
	</td>
      </tr>
    </table>
   </div>
</br>
 <input type="checkbox" id="Panel8" class="ExpandCheckBox" />
  <label class="ExpandHeader" for="Panel8">▼職務経歴⑨　を入力する　　※クリックで入力枠を表示</label>
   <div class="panel8">
    <table class="formTable">
      <tr>
        <th>企業名</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_COMPANY9")?>
	<input type="hidden" name="JOBBOOK_COMPANY9" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_COMPANY9")?>" />
	</td>
      </tr>
      <tr>
        <th>施設名</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_COMPANY_NAME9")?>
	<input type="hidden" name="JOBBOOK_WORK_COMPANY_NAME9" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_COMPANY_NAME9")?>" />
	</td>
      </tr>
      <tr>
        <th>業種</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_COMPANY9")?>
	<input type="hidden" name="JOBBOOK_WORK_COMPANY9" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_COMPANY9")?>" />
	</td>
      </tr>
      <tr>
        <th>在職期間</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD91")?>年<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD92")?>月
		～<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD93")?>年<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD94")?>月
	<input type="hidden" name="JOBBOOK_WORK_PERIOD91" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD91")?>" />
	<input type="hidden" name="JOBBOOK_WORK_PERIOD92" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD92")?>" />
	<input type="hidden" name="JOBBOOK_WORK_PERIOD93" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD93")?>" />
	<input type="hidden" name="JOBBOOK_WORK_PERIOD94" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD94")?>" />
	</td>
      </tr>
      <tr>
        <th>職種</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_KIND9")?>
	<input type="hidden" name="JOBBOOK_WORK_KIND9" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_KIND9")?>" />
	</td>
      </tr>
       <tr>
        <th>役職</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_POSITION9")?>
	<input type="hidden" name="JOBBOOK_WORK_POSITION9" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_POSITION9")?>" />
	</td>
      </tr>
        <th>雇用形態</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_TYPE9")?>
	<input type="hidden" name="JOBBOOK_WORK_TYPE9" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_TYPE9")?>" />
	</td>
      </tr>
      <tr>
        <th>職務内容・業務内容</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_DETAIL9")?>
	<input type="hidden" name="JOBBOOK_WORK_DETAIL9" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_DETAIL9")?>" />
	</td>
      </tr>
      <tr>
        <th>備考<br /></th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_MEMO9")?>
	<input type="hidden" name="JOBBOOK_WORK_MEMO9" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_MEMO9")?>" />
	</td>
      </tr>
    </table>
   </div>
</br>
 <input type="checkbox" id="Panel9" class="ExpandCheckBox" />
  <label class="ExpandHeader" for="Panel9">▼職務経歴⑩　を入力する　　※クリックで入力枠を表示</label>
   <div class="panel9">
    <table class="formTable">
      <tr>
        <th>企業名</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_COMPANY10")?>
	<input type="hidden" name="JOBBOOK_COMPANY10" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_COMPANY10")?>" />
	</td>
      </tr>
      <tr>
        <th>施設名</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_COMPANY_NAME10")?>
	<input type="hidden" name="JOBBOOK_WORK_COMPANY_NAME10" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_COMPANY_NAME10")?>" />
	</td>
      </tr>
      <tr>
        <th>業種</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_COMPANY10")?>
	<input type="hidden" name="JOBBOOK_WORK_COMPANY10" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_COMPANY10")?>" />
	</td>
      </tr>
      <tr>
        <th>在職期間</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD101")?>年<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD102")?>月
		～<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD103")?>年<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD104")?>月
	<input type="hidden" name="JOBBOOK_WORK_PERIOD101" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD101")?>" />
	<input type="hidden" name="JOBBOOK_WORK_PERIOD102" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD102")?>" />
	<input type="hidden" name="JOBBOOK_WORK_PERIOD103" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD103")?>" />
	<input type="hidden" name="JOBBOOK_WORK_PERIOD104" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_PERIOD104")?>" />
	</td>
      </tr>
      <tr>
        <th>職種</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_KIND10")?>
	<input type="hidden" name="JOBBOOK_WORK_KIND10" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_KIND10")?>" />
	</td>
      </tr>
       <tr>
        <th>役職</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_POSITION10")?>
	<input type="hidden" name="JOBBOOK_WORK_POSITION10" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_POSITION10")?>" />
	</td>
      </tr>
        <th>雇用形態</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_TYPE10")?>
	<input type="hidden" name="JOBBOOK_WORK_TYPE10" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_TYPE10")?>" />
	</td>
      </tr>
      <tr>
        <th>職務内容・業務内容</th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_DETAIL10")?>
	<input type="hidden" name="JOBBOOK_WORK_DETAIL10" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_DETAIL10")?>" />
	</td>
      </tr>
      <tr>
        <th>備考<br /></th>
        <td><?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_MEMO10")?>
	<input type="hidden" name="JOBBOOK_WORK_MEMO10" value="<?php print $collection->getByKey($collection->getKeyValue(), "JOBBOOK_WORK_MEMO10")?>" />
	</td>
      </tr>
    </table>
   </div>
<br/>
<br/>
    <div class="mainbox">
                <div class="bottom">
                	<p>この内容で応募する場合は送信ボタンを押してください。</p>
                	<table  border="0" style="border:none; width: 200px;" width="200">
                		<tr>
                			<td style="border:none;">
					<input type="image" src="images/reservation/btn_regist.jpg" name="regist" value="この内容で応募する">
                			<!--<?=$inputs->submit("","regist","この内容で応募する", "")?>-->
                			</td>
                			<td style="border:none;">
					<input type="image" src="images/reservation/btn_change.jpg" name="change" value="変更する">
                			<!--<?=$inputs->submit("","change","変更する", "")?>-->
                			</td>
                		</tr>
                	</table>
                </div>
	</div>
<!--  </form>-->
</div>




                <?php
                $tmp = "";
                $tmp .=  $inputs->hidden("COMPANY_ID", $collection->getByKey($collection->getKeyValue(), "COMPANY_ID"));
                $tmp .=  $inputs->hidden("JOBPLAN_ID", $jobPlan->getByKey($jobPlan->getKeyValue(), "JOBPLAN_ID"));
                $tmp .=  $inputs->hidden("MEMBER_ID", $collection->getByKey($collection->getKeyValue(), "MEMBER_ID"));
                print $tmp;
                ?>

<!--<?php print_r($collection)?>-->