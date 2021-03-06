<?php
    /**
     * クロスサイトスクリプティング防止関数
     */
    function sanitize($before) {
        foreach ($before as $key => $value) {
            $after[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        }
        return $after;
    }

    /**
     * プルダウンメニュー 年
     */
    function pulldown_year() {
        print '<select name="year">';
        print '<option value="2017">2017</option>';
        print '<option value="2018">2018</option>';
        print '<option value="2019">2019</option>';
        print '<option value="2020">2020</option>';
        print '</select>';
    }
    /**
     * プルダウンメニュー 月
     */
    function pulldown_month() {
        print '<select name="month">';
        print '<option value="01">01</option>';
        print '<option value="02">02</option>';
        print '<option value="03">03</option>';
        print '<option value="04">04</option>';
        print '<option value="05">05</option>';
        print '<option value="06">06</option>';
        print '<option value="07">07</option>';
        print '<option value="08">08</option>';
        print '<option value="09">09</option>';
        print '<option value="10">10</option>';
        print '<option value="11">11</option>';
        print '<option value="12">12</option>';
        print '</select>';
    }
    /**
     * プルダウンメニュー 日
     */
    function pulldown_day() {
        print '<select name="day">';
        print '<option value="01">01</option>';
        print '<option value="02">02</option>';
        print '<option value="03">03</option>';
        print '<option value="04">04</option>';
        print '<option value="05">05</option>';
        print '<option value="06">06</option>';
        print '<option value="07">07</option>';
        print '<option value="08">08</option>';
        print '<option value="09">09</option>';
        print '<option value="10">10</option>';
        print '<option value="11">11</option>';
        print '<option value="12">12</option>';
        print '<option value="13">13</option>';
        print '<option value="14">14</option>';
        print '<option value="15">15</option>';
        print '<option value="16">16</option>';
        print '<option value="17">17</option>';
        print '<option value="18">18</option>';
        print '<option value="19">19</option>';
        print '<option value="20">20</option>';
        print '<option value="21">21</option>';
        print '<option value="22">22</option>';
        print '<option value="23">23</option>';
        print '<option value="24">24</option>';
        print '<option value="25">25</option>';
        print '<option value="26">26</option>';
        print '<option value="27">27</option>';
        print '<option value="28">28</option>';
        print '<option value="29">29</option>';
        print '<option value="30">30</option>';
        print '<option value="31">31</option>';
        print '</select>';
    }

    /**
     * 評価星のタグを返す
     */
    function get_rating_star_imgtag($rating) {
        $stars = round($rating / 0.5);
        $disp_flg = false;
        $star_number = '';
        switch ($stars) {
            case 0:
                $star_number = '00';
                $disp_flg = true;
                break;
            case 1:
                $star_number = '05';
                $disp_flg = true;
                break;
            case 2:
                $star_number = '10';
                $disp_flg = true;
                break;
            case 3:
                $star_number = '15';
                $disp_flg = true;
                break;
            case 4:
                $star_number = '20';
                $disp_flg = true;
                break;
            case 5:
                $star_number = '25';
                $disp_flg = true;
                break;
            case 6:
                $star_number = '30';
                $disp_flg = true;
                break;
            case 7:
                $star_number = '35';
                $disp_flg = true;
                break;
            case 8:
                $star_number = '40';
                $disp_flg = true;
                break;
            case 9:
                $star_number = '45';
                $disp_flg = true;
                break;
            case 10:
                $star_number = '50';
                $disp_flg = true;
                break;
            default:
                break;
        }
        if ($disp_flg == true) {
            //print '<br />'.$stars.'('.$star_number.')<br />';
            print '<img src="./images/star'.$star_number.'.png" width="129" height="30">';
        }

    }
?>