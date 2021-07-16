<?php
// require_once( "wp-load.php" );
// ****************************************************************************************************
//
//		ＣＳＶ取り込みモジュール・・・rail-c yasuhiro tosa
//
//		（引数）
//		$file_name・・・取り込むファイル
//		$kugiri_moji・・・区切り文字
//		&$message・・・メッセージ
//
//		（戻り値）
//		true = 成功
//		false = 失敗
//
// ****************************************************************************************************
function csv_import($file_name, $kugiri_moji, &$message)
{

    //defined( 'ABSPATH' ) || exit;
    //$user_id = get_current_user_id();



    $ret = true;
    // ****************************************************************************************************
    // ファイルの存在チェック↓↓↓
    // ****************************************************************************************************
    if (!file_exists($file_name)) {
        $message = 'error:001 ファイルが見つかりません';
        $ret = false;
        return $ret;
    }
    // ****************************************************************************************************
    // ファイルの存在チェック↑↑↑
    // ****************************************************************************************************


    // ****************************************************************************************************
    // エラーチェック↓↓↓
    // ****************************************************************************************************
    $row = 0;
    $error_flg = false;
    $handle = fopen($file_name, "r");
    while (($data = fgetcsv($handle, 0, $kugiri_moji))) {
        $row++;
        if ($row == 1 || $row == 2 || $row ==3) {
            continue;
        }

        mb_convert_variables('UTF-8', 'SJIS-win', $data);

        if (count($data) != 23) {
            $message = 'error:101 ＣＳＶのカラム数が不正です（' . $row .'行目）';
            $error_flg = true;
            break;
        }
        $x = 1;
        $sousin_syubetsu = $data[$x];
        $x++;		// 送信種別
        $shisetsu_name = $data[$x];
        $x++;		// 法人名_施設名
        $sinryouka_name = $data[$x];
        $x++;		// 科_クリニックのみ
        $kanja_id = $data[$x];
        $x++;			// 患者ID_クリニックのみ
        $ishi_name = $data[$x];
        $x++;			// 医師_クリニックのみ
        $kentai_saisyu_date = $data[$x];
        $x++; 	// 検体採取日
        $name_sei = $data[$x];
        $x++;			// 姓
        $name_mei = $data[$x];
        $x++;			// 名
        $kana_sei = $data[$x];
        $x++;			// 姓（よみがな）
        $kana_mei = $data[$x];
        $x++;			// 名（よみがな）
        $seibetsu = $data[$x];
        $x++;			// 性別
        $seinen_gappi = $data[$x];
        $x++;		// 生年月日
        $yubin_no = $data[$x];
        $x++;			// 郵便番号_ハイフンなし
        $todou_fuken = $data[$x];
        $x++;			// 都道府県
        $jyusyo1 = $data[$x];
        $x++;				// 市区町村郡_番地
        $jyusyo2 = $data[$x];
        $x++;				// アパート名_部屋番号など
        $tel_no = $data[$x];
        $x++;				// 電話番号
        $houjin_fax_no = $data[$x];
        $x++;		// ＦＡＸ
        $mail_address = $data[$x];
        $x++;		// メールアドレス
        $coupon_code = $data[$x];
        $x++;			// クーポンコード
        $kingaku = $data[$x];
        $x++;				// 金額
        $mail_address2 = $data[$x];
        $x++;		// メールアドレス２
        $order_source_code = $data[$x];
        $x++;// メールアドレス２
        $item_code = $data[$x];
        $x++;		// メールアドレス２
        $hassou_kubun = $data[$x];
        $x++;		// メールアドレス２
        $syoumeisyo_hakkou = $data[$x];
        $x++;		// メールアドレス２



        

        $sousin_syubetsu = preg_replace('/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '', $sousin_syubetsu);	// 空白を削除
        // if( !( (int)$sousin_syubetsu === 1 || (int)$sousin_syubetsu === 2 || (int)$sousin_syubetsu === 3 )) { $error_flg = true; $message = 'error:201 送信区分が不正です（' . $row .'行目）'; break;}

        if ($sousin_syubetsu == '' && $shisetsu_name == '' && $name_sei == '') {
            continue;
        }

        if (IsCheck_String($shisetsu_name, false, $error_message) == false) {
            $error_flg = true;
            $message = 'error:202 法人名_施設名が不正です（' . $row .'行目） → ' . $error_message;
            break;
        }
        if (IsCheck_String($sinryouka_name, false, $error_message) == false) {
            $error_flg = true;
            $message = 'error:203 科_クリニックが不正です（' . $row .'行目） → ' . $error_message;
            break;
        }
        if (IsCheck_String($kanja_id, false, $error_message) == false) {
            $error_flg = true;
            $message = 'error:204 患者IDが不正です（' . $row .'行目） → ' . $error_message;
            break;
        }
        if (IsCheck_String($ishi_name, false, $error_message) == false) {
            $error_flg = true;
            $message = 'error:205 医師が不正です（' . $row .'行目） → ' . $error_message;
            break;
        }
        if (IsCheck_Hizuke($kentai_saisyu_date, false, $error_message) == false) {
            $error_flg = true;
            $message = 'error:206 検体採取日が不正です（' . $row .'行目） → ' . $error_message;
            break;
        }
        if (IsCheck_String($name_sei, false, $error_message) == false) {
            $error_flg = true;
            $message = 'error:207 姓が不正です（' . $row .'行目） → ' . $error_message;
            break;
        }
        if (IsCheck_String($name_mei, false, $error_message) == false) {
            $error_flg = true;
            $message = 'error:208 名が不正です（' . $row .'行目） → ' . $error_message;
            break;
        }
        if (IsCheck_String_Hiragana($kana_sei, false, $error_message) == false) {
            $error_flg = true;
            $message = 'error:209 姓（よみがな）が不正です（' . $row .'行目） → ' . $error_message;
            break;
        }
        if (IsCheck_String_Hiragana($kana_mei, false, $error_message) == false) {
            $error_flg = true;
            $message = 'error:210 名（よみがな）が不正です（' . $row .'行目） → ' . $error_message;
            break;
        }
        // if(!($seibetsu == '男' || $seibetsu == '女') ) { $error_flg = true; $message = 'error:211 性別が不正です（' . $row .'行目） → ' . $error_message; break;}

        if (IsCheck_Hizuke($seinen_gappi, false, $error_message) == false) {
            $error_flg = true;
            $message = 'error:212 生年月日が不正です（' . $row .'行目） → ' . $error_message;
            break;
        }
        if (IsCheck_Yubin($yubin_no, false, $error_message) == false) {
            $error_flg = true;
            $message = 'error:213 郵便番号が不正です（' . $row .'行目） → ' . $error_message;
            break;
        }
        if (IsCheck_String($todou_fuken, false, $error_message) == false) {
            $error_flg = true;
            $message = 'error:214 都道府県が不正です（' . $row .'行目） → ' . $error_message;
            break;
        }
        if (IsCheck_String($jyusyo1, false, $error_message) == false) {
            $error_flg = true;
            $message = 'error:215 市区町村郡_番地が不正です（' . $row .'行目） → ' . $error_message;
            break;
        }
        if (IsCheck_String($jyusyo2, false, $error_message) == false) {
            $error_flg = true;
            $message = 'error:216 アパート名_部屋番号が不正です（' . $row .'行目） → ' . $error_message;
            break;
        }
        if (IsCheck_Tel($tel_no, false, $error_message) == false) {
            $error_flg = true;
            $message = 'error:217 電話番号が不正です（' . $row .'行目） → ' . $error_message;
            break;
        }
        if (IsCheck_Tel($houjin_fax_no, false, $error_message) == false) {
            $error_flg = true;
            $message = 'error:218 ＦＡＸが不正です（' . $row .'行目） → ' . $error_message;
            break;
        }
        if (IsCheck_Mail($mail_address, false, $error_message) == false) {
            $error_flg = true;
            $message = 'error:219 メールアドレスが不正です（' . $row .'行目） → ' . $error_message;
            break;
        }
        if (IsCheck_String($coupon_code, false, $error_message) == false) {
            $error_flg = true;
            $message = 'error:220 クーポンコードが不正です（' . $row .'行目） → ' . $error_message;
            break;
        }
        if (IsCheck_Val($kingaku, false, $error_message) == false) {
            $error_flg = true;
            $message = 'error:221 金額が不正です（' . $row .'行目） → ' . $error_message;
            break;
        }
        if (IsCheck_Mail($mail_address2, false, $error_message) == false) {
            $error_flg = true;
            $message = 'error:222 メールアドレス２が不正です（' . $row .'行目） → ' . $error_message;
            break;
        }
    }
    fclose($handle);
    if ($error_flg == true) {
        return false;
    }
    // ****************************************************************************************************
    // エラーチェック↑↑↑
    // ****************************************************************************************************



    // ****************************************************************************************************
    // データベース接続↓↓↓
    // ****************************************************************************************************
    $kokyaku_wpdb = new wpdb(KOKYAKU_DB_USER, KOKYAKU_DB_PASSWORD, KOKYAKU_DB_NAME, DB_HOST);
    // ****************************************************************************************************
    // データベース接続↑↑↑
    // ****************************************************************************************************



    // ****************************************************************************************************
    // ファイル読み込み＋ＤＢ取り込み↓↓↓
    // ****************************************************************************************************
    $row = 0;
    $torikomi_count = 0;

    $handle = fopen($file_name, "r");
    while (($data = fgetcsv($handle, 0, $kugiri_moji))) {
        //echo "${row}行目\n";
        $row++;
        if ($row == 1 || $row == 2 || $row ==3) {
            continue;
        }
        mb_convert_variables('UTF-8', 'SJIS-win', $data);
        // ****************************************************************************************************
        // ＣＳＶデータを各変数に格納
        // ****************************************************************************************************
        $x = 1;
        $sousin_syubetsu = $data[$x];
        $x++;		// 送信種別
        $shisetsu_name = $data[$x];
        $x++;		// 法人名_施設名
        $sinryouka_name = $data[$x];
        $x++;		// 科_クリニックのみ
        $kanja_id = $data[$x];
        $x++;			// 患者ID_クリニックのみ
        $ishi_name = $data[$x];
        $x++;			// 医師_クリニックのみ
        $kentai_saisyu_date = $data[$x];
        $x++; 	// 検体採取日
        $name_sei = $data[$x];
        $x++;			// 姓
        $name_mei = $data[$x];
        $x++;			// 名
        $kana_sei = $data[$x];
        $x++;			// 姓（よみがな）
        $kana_mei = $data[$x];
        $x++;			// 名（よみがな）
        $seibetsu = $data[$x];
        $x++;			// 性別
        $seinen_gappi = $data[$x];
        $x++;		// 生年月日
        $yubin_no = $data[$x];
        $x++;			// 郵便番号_ハイフンなし
        $todou_fuken = $data[$x];
        $x++;			// 都道府県
        $jyusyo1 = $data[$x];
        $x++;				// 市区町村郡_番地
        $jyusyo2 = $data[$x];
        $x++;				// アパート名_部屋番号など
        $tel_no = $data[$x];
        $x++;				// 電話番号
        $houjin_fax_no = $data[$x];
        $x++;		// ＦＡＸ
        $mail_address = $data[$x];
        $x++;		// メールアドレス
        $coupon_code = $data[$x];
        $x++;			// クーポンコード
        $kingaku = $data[$x];
        $x++;				// 金額
        $mail_address2 = $data[$x];
        $x++;		// メールアドレス２

        $sousin_syubetsu = preg_replace('/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '', $sousin_syubetsu);	// 空白を削除
        // 送信種別、施設名、姓が空だったら、この行を飛ばす
        if ($sousin_syubetsu == '' && $shisetsu_name == '' && $name_sei == '') {
            continue;
        }
        date_default_timezone_set('Asia/Tokyo');
        $now = date('Y/m/d H:i:s');
        // ****************************************************************************************************
        // 発注番号の生成
        // ****************************************************************************************************
        while (true) {
            // 発注番号を作成（取り込みは、先頭をＺにしています）
            $hatyu_no = 'H' . substr(str_shuffle('1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 9);
            // 生成した、発注番号が既に存在しているか、ＤＢに問い合わせ
            $hatyu_no_kizon = $kokyaku_wpdb->get_row('SELECT hatyu_no FROM mst_kokyaku WHERE hatyu_no = ' . StrChange($hatyu_no), ARRAY_N);
            if ($hatyu_no_kizon[0] == null) {
                // 生成した、発注番号がなければ、ブレイク
                break;
            }
        }
        // ****************************************************************************************************
        // 個人番号の生成（取得）
        // ****************************************************************************************************
        $kojin_no = 0;
        $kojin_no_row = $kokyaku_wpdb->get_row('SELECT max(kojin_no) FROM mst_kokyaku WHERE kojin_no >= 900000000', ARRAY_N);
        if ($kojin_no_row[0] == null) {
            $kojin_no = 900000000;
        } else {
            $kojin_no = $kojin_no_row[0];
        }
        $kojin_no = $kojin_no + 1;

        // ****************************************************************************************************
        // insert 文を作成
        // ****************************************************************************************************
        $sql = '';
        $sql .= 'insert into mst_kokyaku(';
        $sql .= ' hatyu_no';
        $sql .= ',kojin_no';
        $sql .= ',sousin_syubetsu';
        $sql .= ',shisetsu_name';
        $sql .= ',sinryouka_name';
        $sql .= ',kanja_id';
        $sql .= ',ishi_name';
        $sql .= ',kentai_saisyu_date';
        $sql .= ',name_sei';
        $sql .= ',name_mei';
        $sql .= ',kana_sei';
        $sql .= ',kana_mei';
        $sql .= ',seibetsu';
        $sql .= ',seinen_gappi';
        $sql .= ',yubin_no';
        $sql .= ',todou_fuken';
        $sql .= ',jyusyo1';
        $sql .= ',jyusyo2';
        $sql .= ',tel_no';
        $sql .= ',houjin_fax_no';
        $sql .= ',mail_address';
        $sql .= ',coupon_code';
        $sql .= ',kingaku';
        $sql .= ',mail_address2';
        $sql .= ',create_at';
        $sql .= ')values(';
        $sql .= ' ' . StrChange($hatyu_no);				// 発注番号
        $sql .= ',' . Val($kojin_no);					// 個人番号
        $sql .= ',' . Val($sousin_syubetsu);			// 送信種別
        $sql .= ',' . StrChange($shisetsu_name);		// 法人名_施設名
        $sql .= ',' . StrChange($sinryouka_name);		// 科_クリニックのみ
        $sql .= ',' . StrChange($kanja_id);					// 患者ID_クリニックのみ
        $sql .= ',' . StrChange($ishi_name);			// 医師_クリニックのみ
        $sql .= ',' . DateChange($kentai_saisyu_date);	// 検体採取日
        $sql .= ',' . StrChange($name_sei);				// 姓
        $sql .= ',' . StrChange($name_mei);				// 名
        $sql .= ',' . StrChange($kana_sei);				// 姓（よみがな）
        $sql .= ',' . StrChange($kana_mei);				// 名（よみがな）
        $sql .= ',' . seibetsu_to_code($seibetsu);		// 性別
        $sql .= ',' . DateChange($seinen_gappi);		// 生年月日
        $sql .= ',' . StrChange($yubin_no);				// 郵便番号_ハイフンなし
        $sql .= ',' . StrChange($todou_fuken);			// 都道府県
        $sql .= ',' . StrChange($jyusyo1);				// 市区町村郡_番地
        $sql .= ',' . StrChange($jyusyo2);				// アパート名_部屋番号など
        $sql .= ',' . StrChange($tel_no);				// 電話番号
        $sql .= ',' . StrChange($houjin_fax_no);		// ＦＡＸ
        $sql .= ',' . StrChange($mail_address);			// メールアドレス
        $sql .= ',' . StrChange($coupon_code);			// クーポンコード
        $sql .= ',' . Val($kingaku);					// 金額
        $sql .= ',' . StrChange($mail_address2);		// メールアドレス２
        $sql .= ',' . DateChange($now);	// 作成日
        $sql .= ')';
        
        // ****************************************************************************************************
        // ＳＱＬを実行↑↑↑
        // ****************************************************************************************************
        $kokyaku_wpdb->query($sql);
        $torikomi_count = $torikomi_count + 1;
    }
    fclose($handle);
    // ****************************************************************************************************
    // ファイル読み込み＋ＤＢ取り込み
    // ****************************************************************************************************
    $message = $torikomi_count . '行取り込みました';
    //$message = $sql;
    return $ret;
}
// ****************************************************************************************************
//
//		小さい関数群↓
//
// ****************************************************************************************************
function StrChange($val)
{
    return  "'" . $val . "'";
}
function DateChange($val)
{
    return  "'" . $val . "'";
}
function Val($val)
{
    if ($val == '') {
        return "null";
    }
    
    $val = str_replace(',', '', $val);
    $val = str_replace(' ', '', $val);

    return strval($val);
}

function seibetsu_to_code($val)
{
    if ($val == '男') {
        return '1';
    } elseif ($val == '女') {
        return '2';
    } else {
        return '0';
    }
}

// function shiharaikubun_to_code($val)
// {
// 	if ($val == '前払い')
// 	{
// 		return '1';
// 	}elseif ($val == '後払い')
// 	{
// 		return '2';
// 	}else{
// 		return '0';
// 	}
// }

// ****************************************************************************************************
//
//		ＣＳＶバリデーション用
//
// ****************************************************************************************************

// 文字列のチェック
function IsCheck_String($val, $must, &$error_message)
{
    if ($must == true) {
        if (strlen($val) <= 0) {
            $error_message = 'データがセットされていません';
            return false;
        }
        return true;
    } else {
        return true;
    }
}
// 日付のチェック
function IsCheck_Hizuke($val, $must, &$error_message)
{
    if ($must == true) {
        if (strlen($val) == 0) {
            $error_message = 'データがセットされていません';
            return false;
        }
    } else {
        if (strlen($val) == 0) {
            return true;
        }
    }

    list($year, $month, $day) = explode('/', $val);

    $format_str = '%Y/%m/%d';
    //if (strptime($val, $format_str) == false) {
    if (checkdate($month, $day, $year) == false) {
        $error_message = '日付書式エラー' . $val;
        return false;
    }

    return true;
}
// ひらがなのチェック
function IsCheck_String_Hiragana($val, $must, &$error_message)
{
    if ($must == true) {
        if (strlen($val) == 0) {
            $error_message = 'データがセットされていません';
            return false;
        }
    } else {
        if (strlen($val) == 0) {
            return true;
        }
    }

    $flg = false;

    if (preg_match("/^[ぁ-ゞー]+$/u", $val) == true) {
        $flg = true;
    }

    if (preg_match("/^[ァ-ヾー]+$/u", $val) == true) {
        $flg = true;
    }

    if ($flg == false) {
        $error_message = 'ひらがな、カタカナ以外がセットされています（混在不可）-> ' . $val;
        return false;
    }

    return true;
}
// 郵便番号のチェック
function IsCheck_Yubin($val, $must, &$error_message)
{
    if ($must == true) {
        if (strlen($val) == 0) {
            $error_message = 'データがセットされていません';
            return false;
        }
    } else {
        if (strlen($val) == 0) {
            return true;
        }
    }

    if (preg_match("/^[0-9]+$/", $val) == false) {
        $error_message = '半角数字以外が含まれています';
        return false;
    }
    if (strlen($val) != 7) {
        $error_message = '７桁ではありません';
        return false;
    }
    return true;
}
// 電話番号のチェック
function IsCheck_Tel($val, $must, &$error_message)
{
    if ($must == true) {
        if (strlen($val) == 0) {
            $error_message = 'データがセットされていません';
            return false;
        }
    } else {
        if (strlen($val) == 0) {
            return true;
        }
    }

    if (preg_match("/^[0-9\-]+$/", $val) == false) {
        $error_message = '半角数字、ハイフン以外が含まれています' . $val;
        return false;
    }
    return true;
}
// 数値のチェック
function IsCheck_Val($val, $must, &$error_message)
{
    if ($must == true) {
        if (strlen($val) == 0) {
            $error_message = 'データがセットされていません';
            return false;
        }
    } else {
        if (strlen($val) == 0) {
            return true;
        }
    }

    $val = Val($val);

    if (preg_match('/^[0-9]+$/', $val) == false) {
        $error_message = '数値以外が含まれています' . $val;


        return false;
    }

    return true;
}
// メールアドレスのチェック
function IsCheck_Mail($val, $must, &$error_message)
{
    if ($must == true) {
        if (strlen($val) == 0) {
            $error_message = 'データがセットされていません';
            return false;
        }
    } else {
        if (strlen($val) == 0) {
            return true;
        }
    }

    $reg_str = "/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/";
    if (preg_match($reg_str, $val) == false) {
        $error_message = 'メールアドレスが不正です' . $val;
        return false;
    }


    return true;
}
