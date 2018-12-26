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
    public static $pageAdminTitle = 'Quản trị vaymuon.vn';
    public static $pageAdminTitleEdit = 'Quản trị vaymuon.vn';
    public static $pageShopTitle = '';

    const project_name = 'vaymuon.vn';
    const code_shop_share = '';
    const web_name = 'Quản trị vaymuon.vn';
    const web_title_dashboard = 'CHÀO MỪNG BẠN ĐẾN VỚI HỆ THỐNG QUẢN TRỊ VAYMUON.VN';
    const web_keywords = 'Quản trị vaymuon.vn';
    const web_description = 'Quản trị vaymuon.vn';
    public static $pageTitle = 'Quản trị vaymuon.vn';

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
            2 => 'Người vay',
            3 => 'Nhà đầu tư',
            4 => 'Nhà đảm bảo',
            5 => 'Cty Vay mượn',
            //6 => 'Báo cáo quản trị',
            7 => 'Maketting',
            //8 => 'Đối tác',
            9 => 'Thu nợ',
            1 => 'Setting',
        ];

    // định nghĩa màu cho ô và màu chữ của status
    public static $array_color_status = [
        STATUS_NEW => ['text'=>'font-status', 'background'=>'background-new'],
        STATUS_SHOW => ['text'=>'font-status', 'background'=>'background-active'],
        STATUS_STOP => ['text'=>'font-status', 'background'=>'background-stop'],
    ];
    public static $array_content_notification_status = [
        STATUS_SHOW => ['text'=>'font-status', 'background'=>'background-active'],
        STATUS_HIDE => ['text'=>'font-status', 'background'=>'background-stop'],
    ];

    public static $array_color_lender_status = [
        STATUS_STRING_MOI => ['text'=>'font-status', 'background'=>'lender-new'],
        STATUS_STRING_CHO_DUYET => ['text'=>'font-status', 'background'=>'lender-pendding'],
        STATUS_STRING_XEP_HANG => ['text'=>'font-status', 'background'=>'lender-queue'],
        STATUS_STRING_DA_DUYET => ['text'=>'font-status', 'background'=>'lender-active'],
        STATUS_KHOA => ['text'=>'font-status', 'background'=>'lender-block'],
        STATUS_STRING_LOAI => ['text'=>'font-status', 'background'=>'lender-cancel'],
    ];

    public static $array_color_loaner_status = [
        STATUS_DEFAULT => ['text'=>'font-status', 'background'=>'background-default'],
        STATUS_NEW => ['text'=>'font-status', 'background'=>'background-moi'],
        STATUS_HOAT_DONG => ['text'=>'font-status', 'background'=>'background-hoat-dong'],
        STATUS_KHOA => ['text'=>'font-status', 'background'=>'background-khoa'],
        STATUS_KHOA_VINH_VIEN => ['text'=>'font-status', 'background'=>'background-khoa-vinh-vien'],
    ];
    public static $sex_option = [
        '' => 'Chưa cập nhật',
        SEX_NAM => 'Nam',
        SEX_NU => 'Nữ'
    ];

    public static $alego_status = [
        STATUS_INT_KHONG    => "Thất bại",
        STATUS_INT_MOT      => "Thành công",
    ];

    public static $lender_status = [
        STATUS_STRING_MOI      => "Mới",
        STATUS_STRING_CHO_DUYET  => "Chờ kích hoạt",
        STATUS_STRING_DA_DUYET  => "Kích hoạt",
        STATUS_KHOA     => "Khóa",
        STATUS_STRING_LOAI   => "Hủy",
        STATUS_STRING_XEP_HANG    => "Xếp hàng"
    ];

    public static $lender_rates = [
        STATUS_INT_MOT  => "Hạng kim cương",
        STATUS_INT_HAI    => "Hạng vàng",
        STATUS_INT_BA  => "Hạng bạc",
        STATUS_INT_BON   => "Hạng đồng",
        STATUS_INT_NAM   => "Hạng phổ thông",
        STATUS_INT_SAU  => "Chưa đạt hạng"
    ];

    public static $lender_setting_invest = [
        STATUS_INT_MOT => 'Thủ công',
        STATUS_INT_HAI => 'Tự động'
    ];

    public static $lender_setting_status = [
        STATUS_NEW  => "Mới",
        STATUS_SHOW => "Hoạt động",
        STATUS_STOP => "Khoá",
    ];

    public static $lender_loan_status = [
        STATUS_STRING_MOI          => "Mới",
        STATUS_STRING_DANG_XU_LY   => "Đang xử lý",
        STATUS_STRING_THANH_CONG   => "Thành công",
    ];

    public static $lender_contract3_status = [
        STATUS_STRING_DANG_CHO_VAY      => "Đang cho vay",
        STATUS_DANG_GIAI_NGAN    => "Đang giải ngân",
        STATUS_STRING_HOAN_TRA_TIEN     => "Hoàn trả tiền",
        STATUS_HOAN_THANH   => "Hoàn thành",
        STATUS_STRING_DA_CHI       => "Đã chi",
        STATUS_GIAI_NGAN_LOI=> "Giải ngân lỗi"
    ];

    public static $lender_contract4_status = [
        STATUS_STRING_DANG_CHO_VAY => "Đang cho vay",
        STATUS_STRING_DANG_XU_LY   => "Đang xử lý",
        STATUS_STRING_DA_TRA_NO  => "Đã trả nợ",
    ];

    public static $lender_contract_map_status = [
        STATUS_STRING_DANG_CHO_VAY         => STATUS_STRING_DANG_CHO_VAY,
        STATUS_DANG_GIAI_NGAN       => STATUS_STRING_DANG_XU_LY,
        STATUS_GIAI_NGAN_LOI   => STATUS_STRING_DANG_XU_LY,
        STATUS_STRING_HOAN_TRA_TIEN        => STATUS_STRING_DA_TRA_NO,
        STATUS_HOAN_THANH      => STATUS_STRING_DA_TRA_NO,
        STATUS_STRING_DA_CHI          => STATUS_STRING_DA_TRA_NO,
    ];

    public static $array_color_lender_rates = [
        STATUS_INT_MOT  => ['text'=>'font-status', 'background'=>'lender-rate-diamon'],
        STATUS_INT_HAI    => ['text'=>'font-status', 'background'=>'lender-rate-gold'],
        STATUS_INT_BA  => ['text'=>'font-status', 'background'=>'lender-rate-silver'],
        STATUS_INT_BON   => ['text'=>'font-status', 'background'=>'lender-rate-brass'],
        STATUS_INT_NAM   => ['text'=>'font-status', 'background'=>'lender-rate-basic'],
        STATUS_INT_SAU  => ['text'=>'font-status', 'background'=>'lender-rate-normal']
    ];

    public static $array_color_lender_loan_status = [
        STATUS_STRING_MOI          => ['text'=>'font-status', 'background'=>'lender-loan-new'],
        STATUS_STRING_DANG_XU_LY   => ['text'=>'font-status', 'background'=>'lender-rate-doing'],
        STATUS_STRING_THANH_CONG   => ['text'=>'font-status', 'background'=>'lender-rate-success'],
    ];

    public static $array_color_lender_contract_status = [
        STATUS_STRING_DANG_CHO_VAY     => ['text'=>'font-status', 'background'=>'lender-contract-doing'],
        STATUS_STRING_DANG_XU_LY       => ['text'=>'font-status', 'background'=>'lender-contract-process'],
        STATUS_STRING_DA_TRA_NO      => ['text'=>'font-status', 'background'=>'lender-contract-finish'],
    ];

    public static $array_color_lender_disburse_status = [
        ''     => ['text'=>'font-status', 'background'=>'lender-disburse-tolimit'],
        STATUS_STRING_DA_CHI       => ['text'=>'font-status', 'background'=>'lender-disburse-finish'],
        STATUS_HOAN_THANH   => ['text'=>'font-status', 'background'=>'lender-disburse-finish'],
    ];

    public static $array_color_loans_status = [
        ''     => ['text'=>'font-status', 'background'=>'loans-all'],
        STATUS_STRING_DANG_CAP_NHAT       => ['text'=>'font-status', 'background'=>'loans-dang-cap-nhat'],
        STATUS_STRING_CHO_DUYET_CAP_1   => ['text'=>'font-status', 'background'=>'loans-cho-duyet-cap-1'],
        STATUS_STRING_CHO_DUYET_CAP_2   => ['text'=>'font-status', 'background'=>'loans-cho-duyet-cap-2'],
        STATUS_STRING_THAM_DINH   => ['text'=>'font-status', 'background'=>'loans-tham-dinh'],
        STATUS_STRING_THAM_DINH_2   => ['text'=>'font-status', 'background'=>'loans-tham-dinh-2'],
        STATUS_STRING_CHO_KHE_UOC   => ['text'=>'font-status', 'background'=>'loans-cho-khe-uoc'],
        STATUS_STRING_DA_DUYET   => ['text'=>'font-status', 'background'=>'loans-da-duyet'],
        STATUS_STRING_HOAN_THANH   => ['text'=>'font-status', 'background'=>'loans-hoan-thanh'],
        STATUS_STRING_TU_CHOI   => ['text'=>'font-status', 'background'=>'loans-tu-choi'],
        STATUS_HUY   => ['text'=>'font-status', 'background'=>'loans-huy'],
        STATUS_MOI   => ['text'=>'font-status', 'background'=>'loans-moi'],
    ];
    public static $array_color_document_entity_status = [
        ''     => ['text'=>'font-status', 'background'=>'document-entity-all'],
        STATUS_STRING_CHUA_CO => ['text'=>'font-status', 'background'=>'document-entity-chua-co'],
        STATUS_STRING_MOI   => ['text'=>'font-status', 'background'=>'document-entity-moi'],
        STATUS_STRING_LOAI   => ['text'=>'font-status', 'background'=>'document-entity-loai'],
        STATUS_STRING_DUYET   => ['text'=>'font-status', 'background'=>'document-entity-duyet'],
        STATUS_STRING_XEP_HANG   => ['text'=>'font-status', 'background'=>'document-entity-xep-hang'],
    ];

    public static $lender_disburse_status = [
        '' => "Chưa thanh toán",
        STATUS_STRING_DA_CHI   => "Đã thanh toán",
        STATUS_HOAN_THANH  => "Đã thanh toán",
    ];

    public static $array_document_entity = [
        STATUS_STRING_CHUA_CO => 'Chưa có',
        STATUS_STRING_MOI => 'Mới',
        STATUS_STRING_LOAI => 'Loại',
        STATUS_STRING_DUYET => 'Duyệt',
        //STATUS_STRING_XEP_HANG => 'Xếp hạng'
    ];

    public static $array_display_document_entity = [
        DISPLAY_DOCUMENT_ENTITY_DISPLAY => 'Hiển thị',
        DISPLAY_DOCUMENT_ENTITY_HIDE => 'Ẩn'
    ];

    public static $lock_option = [
        LOCK_TIME_30 => '30 Ngày',
        LOCK_TIME_60 => '60 Ngày',
        LOCK_TIME_FOREVER => 'Vĩnh Viễn'
    ];

    public static $status_repayment = [
        ''=>'Tất Cả',
        STATUS_CHUA_THANH_TOAN =>'Chưa Thanh Toán',
        STATUS_THANH_TOAN_THIEU =>'Thanh Toán Thiếu',
        STATUS_HOAN_THANH =>'Hoàn Thành',
    ];

    public static $status_type_repayment=array(
        ''=>'Tất Cả',
        STATUS_HOAN_THANH =>'Hoàn Thành',
        STATUS_TRONG_HAN =>'Trong Hạn',
        STATUS_QUA_HAN =>'Quá Hạn',
        STATUS_AN_HAN =>'Ân Hạn',
    );

    public static $status_contracts = array(
        "" => 'Không Có',
        #STATUS_STRING_CHO_DUYET_HOP_DONG => "Chờ Duyệt Hợp Đồng",
        STATUS_CHO_GIAI_NGAN => "Chờ Giải Ngân",
        STATUS_DANG_GIAI_NGAN => "Đang Giải Ngân",
        STATUS_GIAI_NGAN_LOI => "Giải Ngân Lỗi",
        STATUS_DA_GIAI_NGAN => "Đã Giải Ngân",
        STATUS_HOAN_THANH => "Hoàn Thành",
        STATUS_DONG => "Đóng HĐ",
        STATUS_HUY => "Hủy"
    );

    public static $status_lender_contract=array(
        STATUS_STRING_DANG_CHO_VAY=>"Đang Cho Vay",
        STATUS_DANG_GIAI_NGAN => "Đang Giải Ngân",
        STATUS_STRING_HOAN_TRA_TIEN=>"Hoàn Trả Tiền",
        STATUS_HOAN_THANH => "Hoàn Thành",
        STATUS_STRING_DA_CHI=>"Đã Chi",
        STATUS_GIAI_NGAN_LOI=>"Giải Ngân Lỗi",
    );
    public static $status_lender_status_contract=array(
        LENDING_STATUS_THU_CONG=>"Thủ công",
        LENDING_STATUS_TU_DONG => "Tự động",
    );

    public static $status_loan = array(
        "" => "Tất cả",
        STATUS_STRING_MOI => "Mới",
        STATUS_STRING_DANG_CAP_NHAT => "Đang Cập Nhât",
        STATUS_STRING_CHO_DUYET_CAP_1 => "Chờ Duyệt Cấp 1",
        #STATUS_STRING_CHO_DUYET_CAP_2 => "Chờ Duyệt Cấp 2",
        STATUS_STRING_THAM_DINH => "Thẩm định 1",
        STATUS_STRING_THAM_DINH_2 => "Thẩm định 2",
        STATUS_STRING_CHO_KHE_UOC => "Chờ Khế Ước",
        STATUS_STRING_HOAN_THANH => "Đã Duyệt",
        STATUS_STRING_TU_CHOI => "Từ Chối",
        #STATUS_STRING_LOAI=>"Loại",
        STATUS_HUY => "Huỷ",
    );

    public static $status_receipt = [
        ""                      => "Chưa đủ ĐK",
        STATUS_STRING_CHO_NHAN_HOA_HONG     => "Đang chờ chi",
        STATUS_STRING_DA_THANH_TOAN_LAN_1   => "Đã chi",
        STATUS_STRING_CHO_THANH_TOAN_LAN_2  => "Đang chờ chi",
        STATUS_STRING_DA_THANH_TOAN_LAN_2   => "Đã chi",
        STATUS_QUA_HAN               => "Không đủ ĐK"
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
    public static $type_duration = array(
        "" => "Lỗi",
        NGAY => "Ngày",
        THANG => "Tháng",
    );
    public static $array_transaction_loaner_status = [
        STATUS_INT_AM_MOT   => ['text'=>'font-status', 'background'=>'transaction_loaner_H'],
        STATUS_INT_KHONG  => ['text'=>'font-status', 'background'=>'transaction_loaner_CDS'],
        STATUS_INT_MOT    => ['text'=>'font-status', 'background'=>'transaction_loaner_DDS'],
        STATUS_INT_HAI  => ['text'=>'font-status', 'background'=>'transaction_loaner_CXD'],
    ];
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

    public static $debt_group_number = array(
        DEBT_GROUP_1 => ['text'=>'font-status', 'background'=>'repayment-debt-group-1'],
        DEBT_GROUP_2 => ['text'=>'font-status', 'background'=>'repayment-debt-group-2'],
        DEBT_GROUP_3 => ['text'=>'font-status', 'background'=>'repayment-debt-group-3'],
        DEBT_GROUP_4 => ['text'=>'font-status', 'background'=>'repayment-debt-group-4'],
        DEBT_GROUP_5 => ['text'=>'font-status', 'background'=>'repayment-debt-group-5'],
        DEBT_GROUP_6 => ['text'=>'font-status', 'background'=>'repayment-debt-group-6'],
    );

    public static $repayment_process = array(
        STATUS_INT_KHONG => ['text'=>'font-status', 'background'=>'repayment-status-tiep-nhan'],
        STATUS_INT_MOT => ['text'=>'font-status', 'background'=>'repayment-status-dang-xu-li'],
        STATUS_INT_HAI => ['text'=>'font-status', 'background'=>'repayment-status-hoan-thanh'],
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

    //trạng thái phiếu thu chi
    public static $array_color_billExoenditure_status = [
        STATUS_INT_KHONG => ['text'=>'font-status', 'background'=>'background-moi'],//mới
        STATUS_INT_MOT => ['text'=>'font-status', 'background'=>'background-active'],//đã thu-chi
        STATUS_INT_AM_MOT => ['text'=>'font-status', 'background'=>'lender-cancel'],//đã hủy
        STATUS_INT_HAI => ['text'=>'font-status', 'background'=>'lender-pendding'],//đang xử lý
        STATUS_INT_AM_HAI => ['text'=>'font-status', 'background'=>'lender-block'],//chi lỗi
        STATUS_DELETE => ['text'=>'font-status', 'background'=>'lender-block'],
    ];

    public static $point_contents = [
        '1' => 'Cảm ơn quý khách đã tin tưởng sử dụng dịch vụ của Vay Mượn',
        '2' => 'Thanh toán khoản vay trước hạn/trong hạn',
        '3' => 'Đổi mã ưu đãi',
        '4' => 'Xu hoàn lại do thanh toán thừa',
        '5' => 'Quy đổi mã ưu đãi Vay Mượn',
        '6' => 'Quy đổi mã thẻ điện thoại',
        '7' => 'Giới thiệu người vay thành công',
        '8' => 'Yêu cầu vay được duyệt thành công',
    ];

    // trang thai marketing campaign
    public static $array_marketing_campaign_status = [
        STATUS_INT_AM_MOT => ['text'=>'font-status', 'background'=>'mc_cancel'],
        STATUS_INT_KHONG => ['text'=>'font-status', 'background'=>'mc_new'],
        STATUS_INT_MOT => ['text'=>'font-status', 'background'=>'mc_active'],
        STATUS_INT_HAI => ['text'=>'font-status', 'background'=>'mc_lock'],
    ];

    public static $report_duration = [
        10 => '10 ngày',
        20 => '20 ngày',
        30 => '30 ngày'
    ];

    public static $array_lender_popup_state = [
        STATUS_INT_AM_MOT => 'Mới',
        STATUS_INT_KHONG => 'Dừng',
        STATUS_INT_MOT => 'Áp Dụng',
    ];

    public static $array_lender_popup_status=[
        STATUS_INT_AM_MOT => 'Chưa có',
        STATUS_INT_KHONG => 'NĐT Chưa Kích Hoạt',
        STATUS_INT_MOT => 'NĐT Đã Kích Hoạt',
    ];

    public static $array_color_lender_popup_state = [
        STATUS_INT_AM_MOT => ['text'=>'font-status', 'background'=>'background-new'],
        STATUS_INT_MOT => ['text'=>'font-status', 'background'=>'background-active'],
        STATUS_INT_KHONG => ['text'=>'font-status', 'background'=>'background-stop'],
    ];

    //QuynhTM: role id with define id debt
    public static $arrRoleWithDebt = array(
        ROLE_ID_THU_NO_NHOM_1 => DEFINE_ID_DEBT_1,
        ROLE_ID_THU_NO_NHOM_2 => DEFINE_ID_DEBT_2,
        ROLE_ID_THU_NO_NHOM_3 => DEFINE_ID_DEBT_3,
        ROLE_ID_THU_NO_NHOM_4 => DEFINE_ID_DEBT_4,
        ROLE_ID_THU_NO_NHOM_5 => DEFINE_ID_DEBT_5,
        ROLE_ID_THU_NO_NHOM_6 => DEFINE_ID_DEBT_6,
    );

    public static $arrXacMinhTknh = array(
        0=>'Chưa kiểm tra',
        1=>'Tài khoản đúng (Thủ công)',
        2=>'Tài khoản không đúng (Thủ công)',
        3=>'Tài khoản này không hỗ trợ',
        4=>'Tài khoản đúng (tự động)',
        5=>'Tài khoản sai (tự động)',
    );
}