<?php
/**
 * Created by JetBrains PhpStorm.
 * User: QuynhTM
 */

namespace App\Library\AdminFunction;

use App\library\AdminFunction\Define;

class CGlobal
{
    const IS_DEV = 0;//0: trên server 1: local

    static $css_ver = 1;
    static $js_ver = 1;
    public static $POS_HEAD = 1;
    public static $POS_END = 2;
    public static $extraHeaderCSS = '';
    public static $extraHeaderJS = '';
    public static $extraFooterCSS = '';
    public static $extraFooterJS = '';
    public static $extraMeta = '';
    public static $pageAdminTitle = 'Quản trị site';
    public static $pageAdminTitleEdit = 'Quản trị site';
    public static $pageShopTitle = '';

    const project_name = 'tracnghiem.vn';
    const code_shop_share = '';
    const web_name = 'Quản trị site';
    const web_title_dashboard = 'CHÀO MỪNG BẠN ĐẾN VỚI HỆ THỐNG QUẢN TRỊ SITE';
    const web_keywords = 'Quản trị site';
    const web_description = 'Quản trị site';
    public static $pageTitle = 'Quản trị site';

    const site_name = 'Shopcuatui.com.vn';
    const meta_title = 'Chuyên các mặt hàng xách tay từ nước ngoài - Shopcuatui.com.vn';
    const meta_keywords = 'Hàng xách tay từ Đức, Nga, Nhật cao cấp';
    const meta_description = 'Shopcuatui.com.vn chuyên các mặt hàng xách tay từ nước ngoài: Đức, Nga, Nhật';

    const phoneSupport = '';

    const num_scroll_page = 2;
    const number_limit_show = 30;
    const number_show_30 = 30;
    const number_show_40 = 40;
    const number_show_20 = 20;
    const number_show_15 = 15;
    const number_show_10 = 10;
    const number_show_5 = 5;
    const number_show_8 = 8;
    const number_show_1000 = 1000;

    const status_show = 1;
    const status_hide = 0;
    const status_block = -2;

    static $arrLanguage = array(VIETNAM_LANGUAGE => 'vi', ENGLISH_LANGUAGE => 'en');

    public static $arrMenuTabTop = [
        3 => 'Shop của tui',
        2 => 'Trắc nghiệm',
        1 => 'Setting',
    ];

    public static $sex_option = [
        '' => 'Chưa cập nhật',
        SEX_NAM => 'Nam',
        SEX_NU => 'Nữ'
    ];

    public static $array_provide=[
        'VT' => 'VIETTEL',
        'MB' => 'MOBIFONE',
        'VN' => 'VINAPHONE',
        'VM' => 'VIETNAMOBILE',
        'GM' => 'GMOBILE',
        'FPT' => 'FPT',
        'OT' => 'OTHER',
    ];
    public static $arr_dauso = array(
        'VT'=>'98,97,96,163,162,164,165,166,167,168,169,86,32,33,34,35,36,37,38,39',
        'MB'=>'90,93,120,121,122,126,128,89,70,79,77,76,68',
        'VN'=>'91,94,123,124,125,127,129,88,83,84,85,81,82',
        'VM'=>'92,186,188',
        'GM'=>'99,199,59',
        'FPT'=>'28'
    );

    public static $list_bank = array(
        "ACB" => "ACB(TMCP Á châu)",
        "AGB" => "Agribank(TMCP Nông Nghiệp & Phát Triển Nông Thôn)",
        "ABB" => "AnBinh Bank(TMCP An Bình)",
        "BAB" => "BacA Bank(TMCP Bắc Á)",
        "BIDV" => "BIDV(TMCP Đầu Tư & Phát Triển)",
        "DAB" => "DongA(TMCP Đông Á)",
        "EXB" => "Eximbank(TMCP Xuất Nhập Khẩu Việt Nam)",
        "GPB" => "GP Bank(TMCP Dầu Khí Toàn Cầu",
        "HDB" => "HD Bank(TMCP Phát triển nhà TP.HCM)",
        "MBB" => "MB(TMCP Quân Đội)",
        "MSB" => "MSB(TMCP Hàng Hải Việt Nam)",
        "NAB" => "NamA Bank(TMCP Nam Á)",
        "NCB" => "NCB(TMCP Quốc Dân)",
        "OJB" => "OceanBank(NH Đại Dương)",
        "PGB" => "PG Bank(TMCP Xăng Dầu Petrolimex)",
        "SCB" => "Sacombank(TMCP Sài Gòn Thương Tín)",
        "SGB" => "Saigon Bank(TMCP Sài Gòn Công Thương)",
        "SGCB" => "SCB(TMCP Sài Gòn)",
        "SEA" => "SeABank(TMCP Đông Nam Á)",
        "SHB" => "SHB(TMCP Sài Gòn Hà Nội)",
        "TCB" => "Techcombank(TMCP Kỹ Thương Việt Nam)",
        "TPB" => "TienPhong Bank(TMCP Tiên Phong)",
        "VIB" => "VIB(NH Quốc Tế)",
        "VAB" => "VietA Bank(TMCP Việt Á)",
        "VCB" => "Vietcombank(TMCP Ngoại Thương Việt Nam)",
        "ICB" => "Vietinbank(TMCP Công Thương Việt Nam)",
        "VPB" => "VPBank(TMCP Việt Nam Thịnh Vượng)",
        "ANZ" => "ANZ(Ngân hàng ANZ)",
        "BVB" => "Baoviet Bank(Ngân hàng TMCP Bảo Việt)",
        "BIDC" => "BIDC(Ngân hàng ĐT&PT Campuchia)",
        "CTB" => "CityBank(Ngân hàng CITY BANK)",
        "COMMONWEAL" => "Commonwealth Bank(Commonwealth Bank)",
        "GAB" => "DaiA Bank(Ngân Hàng TMCP Đại Á)",
        "DBVN" => "DeutscheBank(Deutsche Bank Việt Nam)",
        "HLBVN" => "Hong Leong Viet Nam(Hong Leong Việt Nam)",
        "HSB" => "HSBC(Ngân hàng HSBC)",
        "IVB" => "Indovina Bank(Ngân Hàng Indovina)",
        "KLB" => "KienLong Bank(Ngân hàng TMCP Kiên Long)",
        "VRB" => "Liên doanh Việt - Nga(Ngân hàng Liên doanh Việt - Nga)",
        "LVB" => "Lien Viet Post Bank(Ngân hàng Bưu Điện Liên Việt)",
        "MDB" => "MDB(Ngân hàng TMCP PT Mê Kông)",
        "MHB" => "MHB(Ngân hàng TMCP PT Nhà Đồng bằng sông Cửu Long)",
        "NVB" => "Navibank(Ngân hàng TMCP Nam Việt)",
        "OCB" => "OCB(Ngân hàng TMCP Phương Đông)",
        "PNB" => "Phuong Nam Bank(Ngân hàng Phương Nam)",
        "PVB" => "PVcomBank(Ngân hàng TMCP Đại Chúng Việt Nam)",
        "SHNB" => "SHINHAN Bank(Ngân hàng SHINHAN)",
        "STCB" => "STANDARD CHARTERED(Ngân hàng STANDARD CHARTERED)",
        "SMB" => "SUMITOMO-MITSUI(Ngân hàng SUMITOMO-MITSUI)",
        "UFJ" => "UFJ(Tokyo-Mitsubishi UFJ)",
        "UOB" => "UOBank(United Overseas Bank)",
        "VCCB" => "VCCB(Ngân hàng TMCP Bản Việt)",
        "VDB" => "VDB(Ngân hàng Phát triển Việt Nam)",
        "VIDPB" => "VID Public(Ngân hàng VID Public Bank)",
        "VB" => "VietBank(Ngân hàng Việt Nam Thương Tín)",
        "VSB" => "Vinasiam Bank(Ngân Hàng Liên Doanh Việt Thái)",
        "VNCB" => "VNCB(Ngân hàng TMCP Xây dựng Việt Nam)",
    );


    public static $list_tinh_thanh = array(
        "an_giang" => "An Giang",
        "ba_ria_vung_tau" => "Bà Rịa - Vũng Tàu",
        "bac_giang" => "Bắc Giang",
        "bac_kan" => "Bắc Kạn",
        "bac_lieu" => "Bạc Liêu",
        "bac_ninh" => "Bắc Ninh",
        "ben_tre" => "Bến Tre",
        "binh_dinh" => "Bình Định",
        "binh_duong" => "Bình Dương",
        "binh_phuoc" => "Bình Phước",
        "binh_thuan" => "Bình Thuận",
        "ca_mau" => "Cà Mau",
        "cao_dang" => "Cao Bằng",
        "can_tho" => "Cần Thơ",
        "dak_lak" => "Đắk Lắk",
        "dak_nong" => "Đắk Nông",
        "dien_bien" => "Điện Biên",
        "dong_nai" => "Đồng Nai",
        "dong_thap" => "Đồng Tháp",
        "da_nang" => "Đà Nẵng",
        "gia_lai" => "Gia Lai",
        "ha_giang" => "Hà Giang",
        "ha_nam" => "Hà Nam",
        "ha_noi" => "Hà Nội",
        "ha_tinh" => "Hà Tĩnh",
        "hai_phong" => "Hải Phòng",
        "hai_duong" => "Hải Dương",
        "hau_giang" => "Hậu Giang",
        "hoa_binh" => "Hòa Bình",
        "hung_yen" => "Hưng Yên",
        "tp_hcm" => "TP HCM",
        "khanh_hoa" => "Khánh Hòa",
        "kien_giang" => "Kiên Giang",
        "kon_tum" => "Kon Tum",
        "lai_chau" => "Lai Châu",
        "lam_dong" => "Lâm Đồng",
        "lang_son" => "Lạng Sơn",
        "lai_cai" => "Lào Cai",
        "long_an" => "Long An",
        "nam_dinh" => "Nam Định",
        "nghe_an" => "Nghệ An",
        "ninh_binh" => "Ninh Bình",
        "ninh_thuan" => "Ninh Thuận",
        "phu_tho" => "Phú Thọ",
        "phu_yen" => "Phú Yên",
        "quang_binh" => "Quảng Bình",
        "quang_nam" => "Quảng Nam",
        "quang_ngai" => "Quảng Ngãi",
        "quang_ninh" => "Quảng Ninh",
        "quang_tri" => "Quảng Trị",
        "soc_trang" => "Sóc Trăng",
        "son_la" => "Sơn La",
        "tay_ninh" => "Tây Ninh",
        "thai_binh" => "Thái Bình",
        "thai_nguyen" => "Thái Nguyên",
        "thanh_hoa" => "Thanh Hóa",
        "thu_thien_hue" => "Thừa Thiên Huế",
        "tien_giang" => "Tiền Giang",
        "tra_vinh" => "Trà Vinh",
        "tuyen_quang" => "Tuyên Quang",
        "vinh_long" => "Vĩnh Long",
        "vinh_phuc" => "Vĩnh Phúc",
        "yen_bai" => "Yên Bái"
    );

    public static $error_array=array(
        "resultCode"=>"error",
        "status"=>200,
        "messageCode"=>"E000",
        "message"=>"E000",
        "data"=>[],
    );
}