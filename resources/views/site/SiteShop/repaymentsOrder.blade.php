@extends('site.SiteLayouts.index')
@section('content')
    <section class="bread-crumb">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <ul class="breadcrumb">
                        <li class="home"><a href="https://bigboom.exdomain.net/"> <span><i class="fa fa-home"></i> Trang chủ</span>
                            </a> <span><i class="fa">/</i></span></li>
                        <li><strong>Thanh toán</strong></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <link href="Thanh%20to%C3%A1n_files/checkout.css" rel="stylesheet">
    <div class="container">
        <div class="page-information margin-bottom-50">
            <div class="alert alert-success"><i class="fa fa-exclamation-circle"></i> Thành công: Bạn đã thêm <a
                        href="https://bigboom.exdomain.net/kinh-mat-nam-goldsun-gs217003-s1">Kính Mát Nam GOLDSUN GS217003
                    S1 </a> vào <a href="https://bigboom.exdomain.net/checkout/cart">giỏ hàng</a>!
                <button type="button" class="close" data-dismiss="alert">×</button>
            </div>
            <div class="row">
                <div id="content" class="col-sm-12">
                    <div class="row">
                        <form method="post" action="" name="checkout_form" id="checkout_form" enctype="multipart/form-data"
                              class="form-horizontal">
                            <div class="col-sm-8">
                                <div class="panel panel-default">
                                    <div class="panel-heading"><h3 class="panel-title"><i class="fa fa-info-circle"
                                                                                          aria-hidden="true"></i> Địa chỉ
                                            nhận hàng </h3></div>
                                    <div class="panel-body"> <!-- Apply for VN -->
                                        <div class="form-group required"><label class="control-label col-md-2"
                                                                                for="input-firstname">Tên đầy đủ</label>
                                            <div class="col-sm-10"><input type="text" name="firstname" id="input-firstname"
                                                                          placeholder="Ví dụ: Nguyễn Văn A"
                                                                          class="form-control"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group required"><label class="control-label col-sm-4"
                                                                                        for="input-email">Email</label>
                                                    <div class="col-sm-8"><input type="email" name="email" id="input-email"
                                                                                 placeholder="contact@yourdomain.com"
                                                                                 class="form-control"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group required"><label class="control-label col-sm-4"
                                                                                        for="input-telephone">Điện
                                                        thoại</label>
                                                    <div class="col-sm-8"><input type="text" name="telephone"
                                                                                 id="input-telephone"
                                                                                 placeholder="Ví dụ: 01234567890"
                                                                                 class="form-control"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group required"><label class="control-label col-md-4"
                                                                                        for="input-countryid">Quốc
                                                        gia</label>
                                                    <div class="col-md-8"><select name="country_id" id="input-countryid"
                                                                                  class="form-control">
                                                            <option value="244">Aaland Islands</option>
                                                            <option value="1">Afghanistan</option>
                                                            <option value="2">Albania</option>
                                                            <option value="3">Algeria</option>
                                                            <option value="4">American Samoa</option>
                                                            <option value="5">Andorra</option>
                                                            <option value="6">Angola</option>
                                                            <option value="7">Anguilla</option>
                                                            <option value="8">Antarctica</option>
                                                            <option value="9">Antigua and Barbuda</option>
                                                            <option value="10">Argentina</option>
                                                            <option value="11">Armenia</option>
                                                            <option value="12">Aruba</option>
                                                            <option value="252">Ascension Island (British)</option>
                                                            <option value="13">Australia</option>
                                                            <option value="14">Austria</option>
                                                            <option value="15">Azerbaijan</option>
                                                            <option value="16">Bahamas</option>
                                                            <option value="17">Bahrain</option>
                                                            <option value="18">Bangladesh</option>
                                                            <option value="19">Barbados</option>
                                                            <option value="20">Belarus</option>
                                                            <option value="21">Belgium</option>
                                                            <option value="22">Belize</option>
                                                            <option value="23">Benin</option>
                                                            <option value="24">Bermuda</option>
                                                            <option value="25">Bhutan</option>
                                                            <option value="26">Bolivia</option>
                                                            <option value="245">Bonaire, Sint Eustatius and Saba</option>
                                                            <option value="27">Bosnia and Herzegovina</option>
                                                            <option value="28">Botswana</option>
                                                            <option value="29">Bouvet Island</option>
                                                            <option value="30">Brazil</option>
                                                            <option value="31">British Indian Ocean Territory</option>
                                                            <option value="32">Brunei Darussalam</option>
                                                            <option value="33">Bulgaria</option>
                                                            <option value="34">Burkina Faso</option>
                                                            <option value="35">Burundi</option>
                                                            <option value="36">Cambodia</option>
                                                            <option value="37">Cameroon</option>
                                                            <option value="38">Canada</option>
                                                            <option value="251">Canary Islands</option>
                                                            <option value="39">Cape Verde</option>
                                                            <option value="40">Cayman Islands</option>
                                                            <option value="41">Central African Republic</option>
                                                            <option value="42">Chad</option>
                                                            <option value="43">Chile</option>
                                                            <option value="44">China</option>
                                                            <option value="45">Christmas Island</option>
                                                            <option value="46">Cocos (Keeling) Islands</option>
                                                            <option value="47">Colombia</option>
                                                            <option value="48">Comoros</option>
                                                            <option value="49">Congo</option>
                                                            <option value="50">Cook Islands</option>
                                                            <option value="51">Costa Rica</option>
                                                            <option value="52">Cote D'Ivoire</option>
                                                            <option value="53">Croatia</option>
                                                            <option value="54">Cuba</option>
                                                            <option value="246">Curacao</option>
                                                            <option value="55">Cyprus</option>
                                                            <option value="56">Czech Republic</option>
                                                            <option value="237">Democratic Republic of Congo</option>
                                                            <option value="57">Denmark</option>
                                                            <option value="58">Djibouti</option>
                                                            <option value="59">Dominica</option>
                                                            <option value="60">Dominican Republic</option>
                                                            <option value="61">East Timor</option>
                                                            <option value="62">Ecuador</option>
                                                            <option value="63">Egypt</option>
                                                            <option value="64">El Salvador</option>
                                                            <option value="65">Equatorial Guinea</option>
                                                            <option value="66">Eritrea</option>
                                                            <option value="67">Estonia</option>
                                                            <option value="68">Ethiopia</option>
                                                            <option value="69">Falkland Islands (Malvinas)</option>
                                                            <option value="70">Faroe Islands</option>
                                                            <option value="71">Fiji</option>
                                                            <option value="72">Finland</option>
                                                            <option value="74">France, Metropolitan</option>
                                                            <option value="75">French Guiana</option>
                                                            <option value="76">French Polynesia</option>
                                                            <option value="77">French Southern Territories</option>
                                                            <option value="126">FYROM</option>
                                                            <option value="78">Gabon</option>
                                                            <option value="79">Gambia</option>
                                                            <option value="80">Georgia</option>
                                                            <option value="81">Germany</option>
                                                            <option value="82">Ghana</option>
                                                            <option value="83">Gibraltar</option>
                                                            <option value="84">Greece</option>
                                                            <option value="85">Greenland</option>
                                                            <option value="86">Grenada</option>
                                                            <option value="87">Guadeloupe</option>
                                                            <option value="88">Guam</option>
                                                            <option value="89">Guatemala</option>
                                                            <option value="256">Guernsey</option>
                                                            <option value="90">Guinea</option>
                                                            <option value="91">Guinea-Bissau</option>
                                                            <option value="92">Guyana</option>
                                                            <option value="93">Haiti</option>
                                                            <option value="94">Heard and Mc Donald Islands</option>
                                                            <option value="95">Honduras</option>
                                                            <option value="96">Hong Kong</option>
                                                            <option value="97">Hungary</option>
                                                            <option value="98">Iceland</option>
                                                            <option value="99">India</option>
                                                            <option value="100">Indonesia</option>
                                                            <option value="101">Iran (Islamic Republic of)</option>
                                                            <option value="102">Iraq</option>
                                                            <option value="103">Ireland</option>
                                                            <option value="254">Isle of Man</option>
                                                            <option value="104">Israel</option>
                                                            <option value="105">Italy</option>
                                                            <option value="106">Jamaica</option>
                                                            <option value="107">Japan</option>
                                                            <option value="257">Jersey</option>
                                                            <option value="108">Jordan</option>
                                                            <option value="109">Kazakhstan</option>
                                                            <option value="110">Kenya</option>
                                                            <option value="111">Kiribati</option>
                                                            <option value="253">Kosovo, Republic of</option>
                                                            <option value="114">Kuwait</option>
                                                            <option value="115">Kyrgyzstan</option>
                                                            <option value="116">Lao People's Democratic Republic</option>
                                                            <option value="117">Latvia</option>
                                                            <option value="118">Lebanon</option>
                                                            <option value="119">Lesotho</option>
                                                            <option value="120">Liberia</option>
                                                            <option value="121">Libyan Arab Jamahiriya</option>
                                                            <option value="122">Liechtenstein</option>
                                                            <option value="123">Lithuania</option>
                                                            <option value="124">Luxembourg</option>
                                                            <option value="125">Macau</option>
                                                            <option value="127">Madagascar</option>
                                                            <option value="128">Malawi</option>
                                                            <option value="129">Malaysia</option>
                                                            <option value="130">Maldives</option>
                                                            <option value="131">Mali</option>
                                                            <option value="132">Malta</option>
                                                            <option value="133">Marshall Islands</option>
                                                            <option value="134">Martinique</option>
                                                            <option value="135">Mauritania</option>
                                                            <option value="136">Mauritius</option>
                                                            <option value="137">Mayotte</option>
                                                            <option value="138">Mexico</option>
                                                            <option value="139">Micronesia, Federated States of</option>
                                                            <option value="140">Moldova, Republic of</option>
                                                            <option value="141">Monaco</option>
                                                            <option value="142">Mongolia</option>
                                                            <option value="242">Montenegro</option>
                                                            <option value="143">Montserrat</option>
                                                            <option value="144">Morocco</option>
                                                            <option value="145">Mozambique</option>
                                                            <option value="146">Myanmar</option>
                                                            <option value="147">Namibia</option>
                                                            <option value="148">Nauru</option>
                                                            <option value="149">Nepal</option>
                                                            <option value="150">Netherlands</option>
                                                            <option value="151">Netherlands Antilles</option>
                                                            <option value="152">New Caledonia</option>
                                                            <option value="153">New Zealand</option>
                                                            <option value="154">Nicaragua</option>
                                                            <option value="155">Niger</option>
                                                            <option value="156">Nigeria</option>
                                                            <option value="157">Niue</option>
                                                            <option value="158">Norfolk Island</option>
                                                            <option value="112">North Korea</option>
                                                            <option value="159">Northern Mariana Islands</option>
                                                            <option value="160">Norway</option>
                                                            <option value="161">Oman</option>
                                                            <option value="162">Pakistan</option>
                                                            <option value="163">Palau</option>
                                                            <option value="247">Palestinian Territory, Occupied</option>
                                                            <option value="164">Panama</option>
                                                            <option value="165">Papua New Guinea</option>
                                                            <option value="166">Paraguay</option>
                                                            <option value="167">Peru</option>
                                                            <option value="168">Philippines</option>
                                                            <option value="169">Pitcairn</option>
                                                            <option value="170">Poland</option>
                                                            <option value="171">Portugal</option>
                                                            <option value="172">Puerto Rico</option>
                                                            <option value="173">Qatar</option>
                                                            <option value="174">Reunion</option>
                                                            <option value="175">Romania</option>
                                                            <option value="176">Russian Federation</option>
                                                            <option value="177">Rwanda</option>
                                                            <option value="178">Saint Kitts and Nevis</option>
                                                            <option value="179">Saint Lucia</option>
                                                            <option value="180">Saint Vincent and the Grenadines</option>
                                                            <option value="181">Samoa</option>
                                                            <option value="182">San Marino</option>
                                                            <option value="183">Sao Tome and Principe</option>
                                                            <option value="184">Saudi Arabia</option>
                                                            <option value="185">Senegal</option>
                                                            <option value="243">Serbia</option>
                                                            <option value="186">Seychelles</option>
                                                            <option value="187">Sierra Leone</option>
                                                            <option value="188">Singapore</option>
                                                            <option value="189">Slovak Republic</option>
                                                            <option value="190">Slovenia</option>
                                                            <option value="191">Solomon Islands</option>
                                                            <option value="192">Somalia</option>
                                                            <option value="193">South Africa</option>
                                                            <option value="194">South Georgia &amp; South Sandwich Islands
                                                            </option>
                                                            <option value="113">South Korea</option>
                                                            <option value="248">South Sudan</option>
                                                            <option value="195">Spain</option>
                                                            <option value="196">Sri Lanka</option>
                                                            <option value="249">St. Barthelemy</option>
                                                            <option value="197">St. Helena</option>
                                                            <option value="250">St. Martin (French part)</option>
                                                            <option value="198">St. Pierre and Miquelon</option>
                                                            <option value="199">Sudan</option>
                                                            <option value="200">Suriname</option>
                                                            <option value="201">Svalbard and Jan Mayen Islands</option>
                                                            <option value="202">Swaziland</option>
                                                            <option value="203">Sweden</option>
                                                            <option value="204">Switzerland</option>
                                                            <option value="205">Syrian Arab Republic</option>
                                                            <option value="206">Taiwan</option>
                                                            <option value="207">Tajikistan</option>
                                                            <option value="208">Tanzania, United Republic of</option>
                                                            <option value="209">Thailand</option>
                                                            <option value="210">Togo</option>
                                                            <option value="211">Tokelau</option>
                                                            <option value="212">Tonga</option>
                                                            <option value="213">Trinidad and Tobago</option>
                                                            <option value="255">Tristan da Cunha</option>
                                                            <option value="214">Tunisia</option>
                                                            <option value="215">Turkey</option>
                                                            <option value="216">Turkmenistan</option>
                                                            <option value="217">Turks and Caicos Islands</option>
                                                            <option value="218">Tuvalu</option>
                                                            <option value="219">Uganda</option>
                                                            <option value="220">Ukraine</option>
                                                            <option value="221">United Arab Emirates</option>
                                                            <option value="222">United Kingdom</option>
                                                            <option value="223">United States</option>
                                                            <option value="224">United States Minor Outlying Islands</option>
                                                            <option value="225">Uruguay</option>
                                                            <option value="226">Uzbekistan</option>
                                                            <option value="227">Vanuatu</option>
                                                            <option value="228">Vatican City State (Holy See)</option>
                                                            <option value="229">Venezuela</option>
                                                            <option value="230" selected="selected">Việt Nam</option>
                                                            <option value="231">Virgin Islands (British)</option>
                                                            <option value="232">Virgin Islands (U.S.)</option>
                                                            <option value="233">Wallis and Futuna Islands</option>
                                                            <option value="234">Western Sahara</option>
                                                            <option value="235">Yemen</option>
                                                            <option value="238">Zambia</option>
                                                            <option value="239">Zimbabwe</option>
                                                        </select></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group required"><label class="control-label col-md-4"
                                                                                        for="input-zoneid" id="label-zone">Tỉnh
                                                        / TP</label>
                                                    <div class="col-md-8"><span id="load-ajax-zone"><select name="zone_id"
                                                                                                            id="input-zoneid"
                                                                                                            onchange="getWard()"
                                                                                                            class="form-control"><option
                                                                        value="3751" selected="selected">An Giang</option><option
                                                                        value="3756">Bà Rịa - Vũng Tàu</option><option value="3752">Bắc Giang</option><option
                                                                        value="3753">Bắc Kạn</option><option
                                                                        value="3754">Bạc Liêu</option><option
                                                                        value="3755">Bắc Ninh</option><option
                                                                        value="3757">Bến Tre</option><option
                                                                        value="3759">Bình Dương</option><option
                                                                        value="3760">Bình Phước</option><option
                                                                        value="3761">Bình Thuận</option><option
                                                                        value="3758">Bình Định</option><option
                                                                        value="3762">Cà Mau</option><option
                                                                        value="3763">Cần Thơ</option><option
                                                                        value="3764">Cao Bằng</option><option
                                                                        value="3771">Gia Lai</option><option
                                                                        value="3772">Hà Giang</option><option
                                                                        value="3775">Hà Nam</option><option value="3776">Hà Nội</option><option
                                                                        value="3778">Hà Tĩnh</option><option
                                                                        value="3773">Hải Dương</option><option
                                                                        value="3774">Hải Phòng</option><option
                                                                        value="3781">Hậu Giang</option><option
                                                                        value="3779">Hòa Bình</option><option
                                                                        value="3782">Hưng Yên</option><option
                                                                        value="4236">Khánh Hòa</option><option
                                                                        value="4237">Kiên Giang</option><option
                                                                        value="4238">Kon Tum</option><option
                                                                        value="4239">Lai Châu</option><option
                                                                        value="4242">Lâm Đồng</option><option
                                                                        value="4241">Lạng Sơn</option><option
                                                                        value="4240">Lào Cai</option><option
                                                                        value="4243">Long An</option><option
                                                                        value="4244">Nam Định</option><option
                                                                        value="4245">Nghệ An</option><option
                                                                        value="4246">Ninh Bình</option><option
                                                                        value="4247">Ninh Thuận</option><option
                                                                        value="4248">Phú Thọ</option><option
                                                                        value="4249">Phú Yên</option><option
                                                                        value="4250">Quảng Bình</option><option
                                                                        value="4251">Quảng Nam</option><option
                                                                        value="4252">Quảng Ngãi</option><option
                                                                        value="4253">Quảng Ninh</option><option
                                                                        value="4254">Quảng Trị</option><option
                                                                        value="4255">Sóc Trăng</option><option
                                                                        value="4256">Sơn La</option><option
                                                                        value="4257">Tây Ninh</option><option
                                                                        value="4258">Thái Bình</option><option
                                                                        value="4259">Thái Nguyên</option><option
                                                                        value="4260">Thanh Hóa</option><option value="4261">Thừa Thiên Huế</option><option
                                                                        value="4262">Tiền Giang</option><option value="3780">TP.Hồ Chí Minh</option><option
                                                                        value="4263">Trà Vinh</option><option
                                                                        value="4264">Tuyên Quang</option><option
                                                                        value="4265">Vĩnh Long</option><option
                                                                        value="4266">Vĩnh Phúc</option><option
                                                                        value="4267">Yên Bái</option><option
                                                                        value="3767">Đà Nẵng</option><option
                                                                        value="3765">Đăk Lăk</option><option
                                                                        value="3766">Đăk Nông</option><option
                                                                        value="3768">Điện Biên</option><option
                                                                        value="3769">Đồng Nai</option><option
                                                                        value="3770">Đồng Tháp</option></select></span></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group required"><label class="control-label col-md-4"
                                                                                        for="input-address">Quận /
                                                        Huyện</label>
                                                    <div class="col-sm-8"><span id="load-ajax-ward"><select name="ward_id"
                                                                                                            onchange="loadListShipping()"
                                                                                                            id="input-wardid"
                                                                                                            class="form-control"><option
                                                                        value="3" selected="selected">An Phú</option><option value="2">Châu Đốc</option><option
                                                                        value="6">Châu Phú</option><option value="9">Châu Thành</option><option
                                                                        value="10">Chợ Mới</option><option value="1">Long Xuyên</option><option
                                                                        value="5">Phú Tân</option><option value="4">Tân Châu</option><option
                                                                        value="11">Thoại Sơn</option><option
                                                                        value="7">Tịnh Biên</option><option
                                                                        value="8">Tri Tôn</option></select></span></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group required"><label class="control-label col-md-4"
                                                                                        for="input-address">Địa chỉ chi
                                                        tiết</label>
                                                    <div class="col-sm-8"><input type="text" name="address_1"
                                                                                 id="input-address"
                                                                                 placeholder="Ví dụ: Số 247, Cầu Giấy, Q. Cầu Giấy"
                                                                                 class="form-control"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group"><label class="control-label col-md-2" for="input-zoneid"
                                                                       id="label-zone">Lời nhắn</label>
                                            <div class="col-sm-10"><textarea name="comment" id="input-comment" rows="3"
                                                                             class="form-control"
                                                                             placeholder="Ví dụ: Chuyển hàng ngoài giờ hành chính"></textarea>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <div class="adr-oms checkbox"><input type="checkbox"
                                                                                     name="same_info_as_buyer_toggle"
                                                                                     id="is-delivery-address"
                                                                                     onclick="showHideDeliveryAddress()"
                                                                                     checked="checked"> <label
                                                            for="is-delivery-address"><strong>Địa chỉ nhận hàng và thanh toán
                                                            giống nhau</strong></label></div>
                                            </div>
                                        </div>
                                        <div id="container-form-address-ship" style="display: none;"><h4>Thông tin thanh
                                                toán</h4> <!-- Apply for VN -->
                                            <div class="form-group required"><label class="control-label col-md-2"
                                                                                    for="input-payment-firstname">Tên đầy
                                                    đủ</label>
                                                <div class="col-sm-10"><input type="text" name="payment_firstname"
                                                                              id="input-payment-firstname"
                                                                              placeholder="Ví dụ: Nguyễn Văn A"
                                                                              class="form-control"></div>
                                            </div>
                                            <div class="form-group required"><label class="control-label col-md-2"
                                                                                    for="input-payment-telephone">Điện
                                                    thoại</label>
                                                <div class="col-md-4"><input type="text" name="payment_telephone"
                                                                             id="input-payment-telephone"
                                                                             placeholder="Ví dụ: 01234567890"
                                                                             class="form-control"></div>
                                                <label class="control-label col-md-2"
                                                       for="input-payment-email">Email</label>
                                                <div class="col-md-4"><input type="email" name="payment_email"
                                                                             id="input-payment-email"
                                                                             placeholder="contact@yourdomain.com"
                                                                             class="form-control"></div>
                                            </div>
                                            <div class="form-group required"><label class="control-label col-md-2"
                                                                                    for="input-countryid">Quốc gia</label>
                                                <div class="col-md-4"><select name="payment_country_id"
                                                                              id="input-payment-countryid"
                                                                              class="form-control">
                                                        <option value="244">Aaland Islands</option>
                                                        <option value="1">Afghanistan</option>
                                                        <option value="2">Albania</option>
                                                        <option value="3">Algeria</option>
                                                        <option value="4">American Samoa</option>
                                                        <option value="5">Andorra</option>
                                                        <option value="6">Angola</option>
                                                        <option value="7">Anguilla</option>
                                                        <option value="8">Antarctica</option>
                                                        <option value="9">Antigua and Barbuda</option>
                                                        <option value="10">Argentina</option>
                                                        <option value="11">Armenia</option>
                                                        <option value="12">Aruba</option>
                                                        <option value="252">Ascension Island (British)</option>
                                                        <option value="13">Australia</option>
                                                        <option value="14">Austria</option>
                                                        <option value="15">Azerbaijan</option>
                                                        <option value="16">Bahamas</option>
                                                        <option value="17">Bahrain</option>
                                                        <option value="18">Bangladesh</option>
                                                        <option value="19">Barbados</option>
                                                        <option value="20">Belarus</option>
                                                        <option value="21">Belgium</option>
                                                        <option value="22">Belize</option>
                                                        <option value="23">Benin</option>
                                                        <option value="24">Bermuda</option>
                                                        <option value="25">Bhutan</option>
                                                        <option value="26">Bolivia</option>
                                                        <option value="245">Bonaire, Sint Eustatius and Saba</option>
                                                        <option value="27">Bosnia and Herzegovina</option>
                                                        <option value="28">Botswana</option>
                                                        <option value="29">Bouvet Island</option>
                                                        <option value="30">Brazil</option>
                                                        <option value="31">British Indian Ocean Territory</option>
                                                        <option value="32">Brunei Darussalam</option>
                                                        <option value="33">Bulgaria</option>
                                                        <option value="34">Burkina Faso</option>
                                                        <option value="35">Burundi</option>
                                                        <option value="36">Cambodia</option>
                                                        <option value="37">Cameroon</option>
                                                        <option value="38">Canada</option>
                                                        <option value="251">Canary Islands</option>
                                                        <option value="39">Cape Verde</option>
                                                        <option value="40">Cayman Islands</option>
                                                        <option value="41">Central African Republic</option>
                                                        <option value="42">Chad</option>
                                                        <option value="43">Chile</option>
                                                        <option value="44">China</option>
                                                        <option value="45">Christmas Island</option>
                                                        <option value="46">Cocos (Keeling) Islands</option>
                                                        <option value="47">Colombia</option>
                                                        <option value="48">Comoros</option>
                                                        <option value="49">Congo</option>
                                                        <option value="50">Cook Islands</option>
                                                        <option value="51">Costa Rica</option>
                                                        <option value="52">Cote D'Ivoire</option>
                                                        <option value="53">Croatia</option>
                                                        <option value="54">Cuba</option>
                                                        <option value="246">Curacao</option>
                                                        <option value="55">Cyprus</option>
                                                        <option value="56">Czech Republic</option>
                                                        <option value="237">Democratic Republic of Congo</option>
                                                        <option value="57">Denmark</option>
                                                        <option value="58">Djibouti</option>
                                                        <option value="59">Dominica</option>
                                                        <option value="60">Dominican Republic</option>
                                                        <option value="61">East Timor</option>
                                                        <option value="62">Ecuador</option>
                                                        <option value="63">Egypt</option>
                                                        <option value="64">El Salvador</option>
                                                        <option value="65">Equatorial Guinea</option>
                                                        <option value="66">Eritrea</option>
                                                        <option value="67">Estonia</option>
                                                        <option value="68">Ethiopia</option>
                                                        <option value="69">Falkland Islands (Malvinas)</option>
                                                        <option value="70">Faroe Islands</option>
                                                        <option value="71">Fiji</option>
                                                        <option value="72">Finland</option>
                                                        <option value="74">France, Metropolitan</option>
                                                        <option value="75">French Guiana</option>
                                                        <option value="76">French Polynesia</option>
                                                        <option value="77">French Southern Territories</option>
                                                        <option value="126">FYROM</option>
                                                        <option value="78">Gabon</option>
                                                        <option value="79">Gambia</option>
                                                        <option value="80">Georgia</option>
                                                        <option value="81">Germany</option>
                                                        <option value="82">Ghana</option>
                                                        <option value="83">Gibraltar</option>
                                                        <option value="84">Greece</option>
                                                        <option value="85">Greenland</option>
                                                        <option value="86">Grenada</option>
                                                        <option value="87">Guadeloupe</option>
                                                        <option value="88">Guam</option>
                                                        <option value="89">Guatemala</option>
                                                        <option value="256">Guernsey</option>
                                                        <option value="90">Guinea</option>
                                                        <option value="91">Guinea-Bissau</option>
                                                        <option value="92">Guyana</option>
                                                        <option value="93">Haiti</option>
                                                        <option value="94">Heard and Mc Donald Islands</option>
                                                        <option value="95">Honduras</option>
                                                        <option value="96">Hong Kong</option>
                                                        <option value="97">Hungary</option>
                                                        <option value="98">Iceland</option>
                                                        <option value="99">India</option>
                                                        <option value="100">Indonesia</option>
                                                        <option value="101">Iran (Islamic Republic of)</option>
                                                        <option value="102">Iraq</option>
                                                        <option value="103">Ireland</option>
                                                        <option value="254">Isle of Man</option>
                                                        <option value="104">Israel</option>
                                                        <option value="105">Italy</option>
                                                        <option value="106">Jamaica</option>
                                                        <option value="107">Japan</option>
                                                        <option value="257">Jersey</option>
                                                        <option value="108">Jordan</option>
                                                        <option value="109">Kazakhstan</option>
                                                        <option value="110">Kenya</option>
                                                        <option value="111">Kiribati</option>
                                                        <option value="253">Kosovo, Republic of</option>
                                                        <option value="114">Kuwait</option>
                                                        <option value="115">Kyrgyzstan</option>
                                                        <option value="116">Lao People's Democratic Republic</option>
                                                        <option value="117">Latvia</option>
                                                        <option value="118">Lebanon</option>
                                                        <option value="119">Lesotho</option>
                                                        <option value="120">Liberia</option>
                                                        <option value="121">Libyan Arab Jamahiriya</option>
                                                        <option value="122">Liechtenstein</option>
                                                        <option value="123">Lithuania</option>
                                                        <option value="124">Luxembourg</option>
                                                        <option value="125">Macau</option>
                                                        <option value="127">Madagascar</option>
                                                        <option value="128">Malawi</option>
                                                        <option value="129">Malaysia</option>
                                                        <option value="130">Maldives</option>
                                                        <option value="131">Mali</option>
                                                        <option value="132">Malta</option>
                                                        <option value="133">Marshall Islands</option>
                                                        <option value="134">Martinique</option>
                                                        <option value="135">Mauritania</option>
                                                        <option value="136">Mauritius</option>
                                                        <option value="137">Mayotte</option>
                                                        <option value="138">Mexico</option>
                                                        <option value="139">Micronesia, Federated States of</option>
                                                        <option value="140">Moldova, Republic of</option>
                                                        <option value="141">Monaco</option>
                                                        <option value="142">Mongolia</option>
                                                        <option value="242">Montenegro</option>
                                                        <option value="143">Montserrat</option>
                                                        <option value="144">Morocco</option>
                                                        <option value="145">Mozambique</option>
                                                        <option value="146">Myanmar</option>
                                                        <option value="147">Namibia</option>
                                                        <option value="148">Nauru</option>
                                                        <option value="149">Nepal</option>
                                                        <option value="150">Netherlands</option>
                                                        <option value="151">Netherlands Antilles</option>
                                                        <option value="152">New Caledonia</option>
                                                        <option value="153">New Zealand</option>
                                                        <option value="154">Nicaragua</option>
                                                        <option value="155">Niger</option>
                                                        <option value="156">Nigeria</option>
                                                        <option value="157">Niue</option>
                                                        <option value="158">Norfolk Island</option>
                                                        <option value="112">North Korea</option>
                                                        <option value="159">Northern Mariana Islands</option>
                                                        <option value="160">Norway</option>
                                                        <option value="161">Oman</option>
                                                        <option value="162">Pakistan</option>
                                                        <option value="163">Palau</option>
                                                        <option value="247">Palestinian Territory, Occupied</option>
                                                        <option value="164">Panama</option>
                                                        <option value="165">Papua New Guinea</option>
                                                        <option value="166">Paraguay</option>
                                                        <option value="167">Peru</option>
                                                        <option value="168">Philippines</option>
                                                        <option value="169">Pitcairn</option>
                                                        <option value="170">Poland</option>
                                                        <option value="171">Portugal</option>
                                                        <option value="172">Puerto Rico</option>
                                                        <option value="173">Qatar</option>
                                                        <option value="174">Reunion</option>
                                                        <option value="175">Romania</option>
                                                        <option value="176">Russian Federation</option>
                                                        <option value="177">Rwanda</option>
                                                        <option value="178">Saint Kitts and Nevis</option>
                                                        <option value="179">Saint Lucia</option>
                                                        <option value="180">Saint Vincent and the Grenadines</option>
                                                        <option value="181">Samoa</option>
                                                        <option value="182">San Marino</option>
                                                        <option value="183">Sao Tome and Principe</option>
                                                        <option value="184">Saudi Arabia</option>
                                                        <option value="185">Senegal</option>
                                                        <option value="243">Serbia</option>
                                                        <option value="186">Seychelles</option>
                                                        <option value="187">Sierra Leone</option>
                                                        <option value="188">Singapore</option>
                                                        <option value="189">Slovak Republic</option>
                                                        <option value="190">Slovenia</option>
                                                        <option value="191">Solomon Islands</option>
                                                        <option value="192">Somalia</option>
                                                        <option value="193">South Africa</option>
                                                        <option value="194">South Georgia &amp; South Sandwich Islands</option>
                                                        <option value="113">South Korea</option>
                                                        <option value="248">South Sudan</option>
                                                        <option value="195">Spain</option>
                                                        <option value="196">Sri Lanka</option>
                                                        <option value="249">St. Barthelemy</option>
                                                        <option value="197">St. Helena</option>
                                                        <option value="250">St. Martin (French part)</option>
                                                        <option value="198">St. Pierre and Miquelon</option>
                                                        <option value="199">Sudan</option>
                                                        <option value="200">Suriname</option>
                                                        <option value="201">Svalbard and Jan Mayen Islands</option>
                                                        <option value="202">Swaziland</option>
                                                        <option value="203">Sweden</option>
                                                        <option value="204">Switzerland</option>
                                                        <option value="205">Syrian Arab Republic</option>
                                                        <option value="206">Taiwan</option>
                                                        <option value="207">Tajikistan</option>
                                                        <option value="208">Tanzania, United Republic of</option>
                                                        <option value="209">Thailand</option>
                                                        <option value="210">Togo</option>
                                                        <option value="211">Tokelau</option>
                                                        <option value="212">Tonga</option>
                                                        <option value="213">Trinidad and Tobago</option>
                                                        <option value="255">Tristan da Cunha</option>
                                                        <option value="214">Tunisia</option>
                                                        <option value="215">Turkey</option>
                                                        <option value="216">Turkmenistan</option>
                                                        <option value="217">Turks and Caicos Islands</option>
                                                        <option value="218">Tuvalu</option>
                                                        <option value="219">Uganda</option>
                                                        <option value="220">Ukraine</option>
                                                        <option value="221">United Arab Emirates</option>
                                                        <option value="222">United Kingdom</option>
                                                        <option value="223">United States</option>
                                                        <option value="224">United States Minor Outlying Islands</option>
                                                        <option value="225">Uruguay</option>
                                                        <option value="226">Uzbekistan</option>
                                                        <option value="227">Vanuatu</option>
                                                        <option value="228">Vatican City State (Holy See)</option>
                                                        <option value="229">Venezuela</option>
                                                        <option value="230" selected="selected">Việt Nam</option>
                                                        <option value="231">Virgin Islands (British)</option>
                                                        <option value="232">Virgin Islands (U.S.)</option>
                                                        <option value="233">Wallis and Futuna Islands</option>
                                                        <option value="234">Western Sahara</option>
                                                        <option value="235">Yemen</option>
                                                        <option value="238">Zambia</option>
                                                        <option value="239">Zimbabwe</option>
                                                    </select></div>
                                                <label class="control-label col-md-2" for="input-payment-zoneid"
                                                       id="label-payment-zone">Tỉnh / TP</label>
                                                <div class="col-md-4"><span id="load-ajax-payment-zone"><select
                                                                name="payment_zone_id" id="input-payment-zoneid"
                                                                class="form-control"><option value="3751" selected="selected">An Giang</option><option
                                                                    value="3756">Bà Rịa - Vũng Tàu</option><option value="3752">Bắc Giang</option><option
                                                                    value="3753">Bắc Kạn</option><option value="3754">Bạc Liêu</option><option
                                                                    value="3755">Bắc Ninh</option><option value="3757">Bến Tre</option><option
                                                                    value="3759">Bình Dương</option><option
                                                                    value="3760">Bình Phước</option><option
                                                                    value="3761">Bình Thuận</option><option
                                                                    value="3758">Bình Định</option><option value="3762">Cà Mau</option><option
                                                                    value="3763">Cần Thơ</option><option value="3764">Cao Bằng</option><option
                                                                    value="3771">Gia Lai</option><option value="3772">Hà Giang</option><option
                                                                    value="3775">Hà Nam</option><option value="3776">Hà Nội</option><option
                                                                    value="3778">Hà Tĩnh</option><option value="3773">Hải Dương</option><option
                                                                    value="3774">Hải Phòng</option><option
                                                                    value="3781">Hậu Giang</option><option
                                                                    value="3779">Hòa Bình</option><option value="3782">Hưng Yên</option><option
                                                                    value="4236">Khánh Hòa</option><option
                                                                    value="4237">Kiên Giang</option><option
                                                                    value="4238">Kon Tum</option><option value="4239">Lai Châu</option><option
                                                                    value="4242">Lâm Đồng</option><option value="4241">Lạng Sơn</option><option
                                                                    value="4240">Lào Cai</option><option value="4243">Long An</option><option
                                                                    value="4244">Nam Định</option><option value="4245">Nghệ An</option><option
                                                                    value="4246">Ninh Bình</option><option
                                                                    value="4247">Ninh Thuận</option><option
                                                                    value="4248">Phú Thọ</option><option value="4249">Phú Yên</option><option
                                                                    value="4250">Quảng Bình</option><option
                                                                    value="4251">Quảng Nam</option><option
                                                                    value="4252">Quảng Ngãi</option><option
                                                                    value="4253">Quảng Ninh</option><option
                                                                    value="4254">Quảng Trị</option><option
                                                                    value="4255">Sóc Trăng</option><option value="4256">Sơn La</option><option
                                                                    value="4257">Tây Ninh</option><option
                                                                    value="4258">Thái Bình</option><option
                                                                    value="4259">Thái Nguyên</option><option
                                                                    value="4260">Thanh Hóa</option><option
                                                                    value="4261">Thừa Thiên Huế</option><option
                                                                    value="4262">Tiền Giang</option><option
                                                                    value="3780">TP.Hồ Chí Minh</option><option
                                                                    value="4263">Trà Vinh</option><option
                                                                    value="4264">Tuyên Quang</option><option
                                                                    value="4265">Vĩnh Long</option><option
                                                                    value="4266">Vĩnh Phúc</option><option value="4267">Yên Bái</option><option
                                                                    value="3767">Đà Nẵng</option><option value="3765">Đăk Lăk</option><option
                                                                    value="3766">Đăk Nông</option><option
                                                                    value="3768">Điện Biên</option><option
                                                                    value="3769">Đồng Nai</option><option
                                                                    value="3770">Đồng Tháp</option></select></span></div>
                                            </div>
                                            <div class="form-group required"><label class="control-label col-md-2"
                                                                                    for="input-payment-address">Địa chỉ chi
                                                    tiết</label>
                                                <div class="col-sm-10"><input type="text" name="payment_address_1"
                                                                              id="input-payment-address"
                                                                              placeholder="Ví dụ: Số 247, Cầu Giấy, Q. Cầu Giấy"
                                                                              class="form-control"></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="adr-oms checkbox"><input type="checkbox"
                                                                                         name="update_address"
                                                                                         id="update-address"
                                                                                         checked="checked">&nbsp;&nbsp;<label
                                                                for="update-address">Cập nhật thông tin trên làm địa chỉ hiện
                                                            tại của tôi</label></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading"><h3 class="panel-title"><i class="fa fa-credit-card"
                                                                                          aria-hidden="true"></i> Phương
                                            thức thanh toán </h3></div>
                                    <div class="panel-body" id="form_payment_method">
                                        <div class="group">
                                            <div class="adr-oms radio select-method"><input type="radio"
                                                                                            id="payment-method-bank_transfer"
                                                                                            name="payment_method"
                                                                                            value="bank_transfer"> <label
                                                        for="payment-method-bank_transfer">
                                                    <div class="adr-oms payment-method">
                                                        <div class="thumbnail"><img alt="Chuyển khoản"
                                                                                    src="Thanh%20to%C3%A1n_files/bank_transfer.png">
                                                        </div>
                                                        <div class="description">
                                                            <div class="title">Chuyển khoản</div>
                                                            <div class="subtitle">Sử dụng thẻ ATM hoặc dịch vụ Internet Banking
                                                                để tiến hành chuyển khoản cho chúng tôi
                                                            </div>
                                                            <div class="tkz-selection-info"></div>
                                                        </div>
                                                    </div>
                                                </label>
                                                <div class="payment-method-toggle box-installment installment-disabled"
                                                     id="payment-method-info-bank_transfer" style="display: none;">
                                                    <div class="disabled-cod-body">Thông tin ngân hàng<br> Ngân hàng TMCP
                                                        Ngoại thương Việt Nam - Vietcombank&nbsp;
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="group">
                                            <div class="adr-oms radio select-method"><input type="radio"
                                                                                            id="payment-method-cod"
                                                                                            name="payment_method"
                                                                                            value="cod"> <label
                                                        for="payment-method-cod">
                                                    <div class="adr-oms payment-method">
                                                        <div class="thumbnail"><img alt="Thu tiền tại nhà (COD)"
                                                                                    src="Thanh%20to%C3%A1n_files/cod.png"></div>
                                                        <div class="description">
                                                            <div class="title">Thu tiền tại nhà (COD)</div>
                                                            <div class="subtitle">Khách hàng thanh toán bằng tiền mặt cho nhân
                                                                viên giao hàng khi sản phẩm được chuyển tới địa chỉ nhận hàng
                                                            </div>
                                                            <div class="tkz-selection-info"></div>
                                                        </div>
                                                    </div>
                                                </label></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">
                                            <div class="adr-oms checkbox"><input type="checkbox" name="invoice"
                                                                                 id="request-invoice"
                                                                                 onclick="showHideInvoice();"> <label
                                                        for="request-invoice">Yêu cầu xuất hoá đơn GTGT</label></div>
                                        </h3>
                                    </div>
                                    <div class="panel-body" id="container-form-invoice" style="display: none;">
                                        <div class="form-group"><label class="control-label col-md-2" for="input-taxcode">Mã
                                                số thuế</label>
                                            <div class="col-sm-10"><input type="text" name="tax_code" id="input-taxcode"
                                                                          placeholder="Ví dụ: 398473094385"
                                                                          class="form-control"></div>
                                        </div>
                                        <div class="form-group"><label class="control-label col-md-2" for="input-company">Tên
                                                công ty</label>
                                            <div class="col-sm-10"><input type="text" name="company" id="input-company"
                                                                          placeholder="Ví dụ: Công ty Cổ phần ASIA"
                                                                          class="form-control"></div>
                                        </div>
                                        <div class="form-group"><label class="control-label col-md-2"
                                                                       for="input-company-address">Địa chỉ công ty</label>
                                            <div class="col-sm-10"><input type="text" name="company_address"
                                                                          id="input-company-address"
                                                                          placeholder="Ví dụ: 247 Cầu Giấy, Hà Nội, P. Dịch Vọng, Q. Cầu Giấy, TP. Hà Nội"
                                                                          class="form-control"></div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-12"><i>Lưu ý: Giá trị hóa đơn không bao gồm giá trị của Mã
                                                    giảm giá</i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="panel panel-default">
                                    <div class="panel-heading"><h3 class="panel-title"><i class="fa fa-shopping-cart"
                                                                                          aria-hidden="true"></i> Đơn hàng
                                            (2 sản phẩm) </h3></div>
                                    <div class="panel-body">
                                        <table class="adr-oms table table_order_items">
                                            <tbody id="orderItem">
                                            <tr class="group-type-1 item-child-0">
                                                <td>
                                                    <div class="table_order_items-cell-thumbnail">
                                                        <div class="thumbnail"><a target="_blank" rel="noopener"
                                                                                  href="https://bigboom.exdomain.net/dong-ho-bruno-sohnle"
                                                                                  title="Đồng hồ bruno-sohnle"> <img
                                                                        src="Thanh%20to%C3%A1n_files/dong-ho-bruno-sohnle-100x100.png"
                                                                        alt="Đồng hồ bruno-sohnle" width="84"> </a></div>
                                                    </div>
                                                    <div class="table_order_items-cell-detail">
                                                        <div class="table_order_items-cell-title">
                                                            <div class="table_order_items_product_name"><a target="_blank"
                                                                                                           rel="noopener"
                                                                                                           href="https://bigboom.exdomain.net/dong-ho-bruno-sohnle"
                                                                                                           title="Đồng hồ bruno-sohnle">
                                                                    <span class="title">Đồng hồ bruno-sohnle</span></a></div>
                                                        </div>
                                                    </div>
                                                    <div class="table_order_items-cell-price">
                                                        <div class="tt-price">12,500,000đ</div>
                                                        <div class="quantity">x1</div>
                                                        <div class="tt-price">12,500,000đ</div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="group-type-1 item-child-1">
                                                <td>
                                                    <div class="table_order_items-cell-thumbnail">
                                                        <div class="thumbnail"><a target="_blank" rel="noopener"
                                                                                  href="https://bigboom.exdomain.net/kinh-mat-nam-goldsun-gs217003-s1"
                                                                                  title="Kính Mát Nam GOLDSUN GS217003 S1 ">
                                                                <img src="Thanh%20to%C3%A1n_files/gs217003-100x100.jpg"
                                                                     alt="Kính Mát Nam GOLDSUN GS217003 S1 " width="84"> </a>
                                                        </div>
                                                    </div>
                                                    <div class="table_order_items-cell-detail">
                                                        <div class="table_order_items-cell-title">
                                                            <div class="table_order_items_product_name"><a target="_blank"
                                                                                                           rel="noopener"
                                                                                                           href="https://bigboom.exdomain.net/kinh-mat-nam-goldsun-gs217003-s1"
                                                                                                           title="Kính Mát Nam GOLDSUN GS217003 S1 ">
                                                                    <span class="title">Kính Mát Nam GOLDSUN GS217003 S1 </span></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="table_order_items-cell-price">
                                                        <div class="tt-price">660,000đ</div>
                                                        <div class="quantity">x1</div>
                                                        <div class="tt-price">660,000đ</div>
                                                    </div>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading"><h3 class="panel-title"><i class="fa fa-truck"
                                                                                          aria-hidden="true"></i> Vận chuyển
                                        </h3></div>
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <div class="col-sm-12"><span id="ajax-load-shipping-method"><div><strong>Tính sau</strong></div><div
                                                            class="radio"><label style="font-weight: inherit;"><input type="radio"
                                                                                                                      name="shipping_method"
                                                                                                                      onclick="updateFee()"
                                                                                                                      value="postpaid.postpaid"
                                                                                                                      checked="checked">Phí vận chuyển được tính khi xử lý đơn hàng</label></div></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading"><h3 class="panel-title"><i class="fa fa-tag"
                                                                                          aria-hidden="true"></i> Sử dụng mã
                                            giảm giá</h3></div>
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <div class="col-sm-12"><span id="show_notice_coupon"></span>
                                                <div class="input-group"><input type="text" name="coupon"
                                                                                placeholder="Nhập mã giảm giá"
                                                                                id="input-coupon" class="form-control">
                                                    <span class="input-group-btn"> <input class="btn btn-primary"
                                                                                          type="button" value="Áp dụng"
                                                                                          id="button-coupon"
                                                                                          data-loading-text="Đang áp dụng"> </span>
                                                </div>
                                                <span id="load-input-hidden"></span></div>
                                        </div>
                                        <script type="text/javascript"> $('#button-coupon').on('click', function () {
                                                var coupon_submit = '<input type="hidden" name="submit_coupon" value="1">';
                                                $('#load-input-hidden').html(coupon_submit);
                                                $.ajax({
                                                    url: '/extension/total/coupon/coupon',
                                                    type: 'post',
                                                    data: 'coupon=' + encodeURIComponent($('input[name=\'coupon\']').val()),
                                                    dataType: 'json',
                                                    beforeSend: function () {
                                                        $('#button-coupon').button('loading');
                                                    },
                                                    complete: function () {
                                                        $('#button-coupon').button('reset');
                                                    },
                                                    success: function (json) {
                                                        $('.alert').remove();
                                                        if (json['error']) {
                                                            $('#show_notice_coupon').html('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                                                        } else {
                                                            $("form#checkout_form").submit();
                                                        }
                                                    }
                                                });
                                            }); </script>
                                    </div>
                                </div>
                                <div class="panel panel-default" id="ajax-load-total">
                                    <table class="table">
                                        <tbody>
                                        <tr>
                                            <td class="text-left">Thành tiền</td>
                                            <td class="text-right" style="font-size: 13px; font-weight: bold;">13,160,000đ
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-left">Phí vận chuyển được tính khi xử lý đơn hàng</td>
                                            <td class="text-right" style="font-size: 13px; font-weight: bold;">0đ</td>
                                        </tr>
                                        <tr>
                                            <td class="text-left">Tổng số</td>
                                            <td class="text-right"
                                                style="color: #d60c0c; font-size: 16px; font-weight: bold;">13,160,000đ
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="text-center"><a class="pull-left"
                                                            href="https://bigboom.exdomain.net/checkout/cart"
                                                            title="Quay lại giỏ hàng"> <i class="fa fa-mail-reply-all"
                                                                                          aria-hidden="true"></i> Quay lại
                                        giỏ hàng </a>
                                    <button class="btn btn-primary pull-right" type="button" id="submit_form_button"
                                            onclick="$('form#checkout_form').submit();">Đặt hàng <i
                                                class="fa fa-angle-right"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript"> function loadListShipping() {
            var country_id = $("select[name=country_id]").val();
            var zone_id = $("select[name=zone_id]").val();
            var ward_id = $("select[name=ward_id]").val();
            $.ajax({
                url: '/checkout/checkout/ajaxGetHtmlShipping',
                dataType: 'json',
                method: 'post',
                data: {country_id: country_id, zone_id: zone_id, ward_id: ward_id},
                beforeSend: function () { /*$('#ajax-load-shipping-method').html('');*/
                },
                complete: function () {
                },
                success: function (json) {
                    if (json['error'] == false) {
                        $('#ajax-load-shipping-method').html(json['data']);
                        updateFee();
                    } else {
                        console.log(json['error_message']);
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        }

        function updateFee() {
            var shipping_method = (document.querySelector('input[name="shipping_method"]:checked')) ? document.querySelector('input[name="shipping_method"]:checked').value : '';
            $.ajax({
                url: '/checkout/checkout/ajaxGetTotal',
                dataType: 'json',
                method: 'post',
                data: $("#checkout_form").serialize(),
                beforeSend: function () {
                },
                complete: function () {
                },
                success: function (json) {
                    if (json['error'] == false) {
                        var html = '<table class="table">';
                        for (i = 0; i < json['data'].length; i++) {
                            if (i == json['data'].length - 1) {
                                html += '<tr>';
                                html += '<td class="text-left">' + json['data'][i]['title'] + '</td>';
                                html += '<td class="text-right" style="color: #d60c0c; font-size: 16px; font-weight: bold;">' + json['data'][i]['text'] + '</td>';
                                html += '</tr>';
                            } else {
                                html += '<tr>';
                                html += '<td class="text-left">' + json['data'][i]['title'] + '</td>';
                                html += '<td class="text-right" style="font-size: 13px; font-weight: bold;">' + json['data'][i]['text'] + '</td>';
                                html += '</tr>';
                            }
                        }
                        html += '</table>';
                        $('#ajax-load-total').html(html);
                    } else {
                        console.log(json['error_message']);
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        } </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.payment-method-toggle').hide();
            $('input[name=payment_method]').click(function () {
                $('.payment-method-toggle').hide();
                $('#payment-method-info-' + $(this).val()).toggle();
                /* Cap nhat cac loai phi */
                updateFee();
            });
            var country_id = $('#input-countryid').val();
            var zone_id = '0';
            var ward_id = '0';
            $.ajax({
                url: '/checkout/checkout/ajaxGetZone?country_id=' + country_id, dataType: 'json', beforeSend: function () {
                    $('#label-zone').append('<span class="container-spin-loading"><i class="fa fa-refresh fa-spin fa-fw"></i></span>');
                }, complete: function () {
                    $('#label-zone .container-spin-loading').remove();
                }, success: function (json) {
                    if (json['error'] == false) {
                        $('#load-ajax-zone').html('');
                        html = '<select name="zone_id" id="input-zoneid" onchange="getWard()" class="form-control">';
                        if (json['data'] != '') {
                            for (i = 0; i < json['data'].length; i++) {
                                if (json['data'][i]['zone_id'] == zone_id) {
                                    html += '<option value="' + json['data'][i]['zone_id'] + '"';
                                    html += ' selected="selected">' + json['data'][i]['name'] + '</option>';
                                } else {
                                    html += '<option value="' + json['data'][i]['zone_id'] + '"';
                                    html += '>' + json['data'][i]['name'] + '</option>';
                                }
                            }
                        }
                        html += "</select>";
                        $('#load-ajax-zone').html(html);
                        getWard();
                    } else {
                        $('#load-ajax-zone').html('<select name="zone_id" onchange="getWard()" id="input-zoneid" class="form-control"></select>');
                    }
                }, error: function (xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
            var e = document.getElementById('input-payment-countryid');
            var payment_country_id = e.options[e.selectedIndex].value;
            var payment_zone_id = '0';
            $.ajax({
                url: '/checkout/checkout/ajaxGetZone?country_id=' + payment_country_id,
                dataType: 'json',
                beforeSend: function () {
                    $('#label-payment-zone').append('<span class="container-spin-loading"><i class="fa fa-refresh fa-spin fa-fw"></i></span>');
                },
                complete: function () {
                    $('#label-payment-zone .container-spin-loading').remove();
                },
                success: function (json) {
                    if (json['error'] == false) {
                        $('#load-ajax-payment-zone').html('');
                        html = '<select name="payment_zone_id" id="input-payment-zoneid" class="form-control">';
                        if (json['data'] != '') {
                            for (i = 0; i < json['data'].length; i++) {
                                if (json['data'][i]['zone_id'] == payment_zone_id) {
                                    html += '<option value="' + json['data'][i]['zone_id'] + '"';
                                    html += ' selected="selected">' + json['data'][i]['name'] + '</option>';
                                } else {
                                    html += '<option value="' + json['data'][i]['zone_id'] + '"';
                                    html += '>' + json['data'][i]['name'] + '</option>';
                                }
                            }
                        }
                        html += "</select>";
                        $('#load-ajax-payment-zone').html(html);
                    } else {
                        $('#load-ajax-payment-zone').html('<select name="payment_zone_id" id="input-payment-zoneid" class="form-control"></select>');
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        });
        $('select[name=\'country_id\']').bind('change', function () {
            var e = document.getElementById("input-countryid");
            var country_id = e.options[e.selectedIndex].value;
            var zone_id = '0';
            $.ajax({
                url: '/checkout/checkout/ajaxGetZone?country_id=' + country_id, dataType: 'json', beforeSend: function () {
                    $('#label-zone').append('<span class="container-spin-loading"><i class="fa fa-refresh fa-spin fa-fw"></i></span>');
                }, complete: function () {
                    $('#label-zone .container-spin-loading').remove();
                }, success: function (json) {
                    if (json['error'] == false) {
                        $('#load-ajax-zone').html('');
                        html = '<select name="zone_id" onchange="getWard()" id="input-zoneid" class="form-control">';
                        if (json['data'] != '') {
                            for (i = 0; i < json['data'].length; i++) {
                                if (json['data'][i]['zone_id'] == zone_id) {
                                    html += '<option value="' + json['data'][i]['zone_id'] + '"';
                                    html += ' selected="selected">' + json['data'][i]['name'] + '</option>';
                                } else {
                                    html += '<option value="' + json['data'][i]['zone_id'] + '"';
                                    html += '>' + json['data'][i]['name'] + '</option>';
                                }
                            }
                        }
                        html += "</select>";
                        $('#load-ajax-zone').html(html);
                        getWard();
                    } else {
                        $('#load-ajax-zone').html('<select name="zone_id" onchange="getWard()" id="input-zoneid" class="form-control"></select>');
                    }
                }, error: function (xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        });
        $('select[name=\'payment_country_id\']').bind('change', function () {
            var e = document.getElementById("input-payment-countryid");
            var payment_country_id = e.options[e.selectedIndex].value;
            var payment_zone_id = '0';
            $.ajax({
                url: '/checkout/checkout/ajaxGetZone?country_id=' + payment_country_id,
                dataType: 'json',
                beforeSend: function () {
                    $('#label-payment-zone').append('<span class="container-spin-loading"><i class="fa fa-refresh fa-spin fa-fw"></i></span>');
                },
                complete: function () {
                    $('#label-payment-zone .container-spin-loading').remove();
                },
                success: function (json) {
                    if (json['error'] == false) {
                        $('#load-ajax-payment-zone').html('');
                        html = '<select name="payment_zone_id" id="input-payment-zoneid" class="form-control">';
                        if (json['data'] != '') {
                            for (i = 0; i < json['data'].length; i++) {
                                if (json['data'][i]['zone_id'] == payment_zone_id) {
                                    html += '<option value="' + json['data'][i]['zone_id'] + '"';
                                    html += ' selected="selected">' + json['data'][i]['name'] + '</option>';
                                } else {
                                    html += '<option value="' + json['data'][i]['zone_id'] + '"';
                                    html += '>' + json['data'][i]['name'] + '</option>';
                                }
                            }
                        }
                        html += "</select>";
                        $('#load-ajax-payment-zone').html(html);
                    } else {
                        $('#load-ajax-payment-zone').html('<select name="payment_zone_id" id="input-payment-zoneid" class="form-control"></select>');
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        }); </script>
    <script type="text/javascript"> function getWard() { /* Load fee */
            loadListShipping();
            var e = document.getElementById("input-zoneid");
            var select_zone_id = e.options[e.selectedIndex].value;
            var ward_id = '0';
            $.ajax({
                url: '/checkout/checkout/ajaxGetWard?zone_id=' + select_zone_id, dataType: 'json', beforeSend: function () {
                    $('#label-zone').append('<span class="container-spin-loading"><i class="fa fa-refresh fa-spin fa-fw"></i></span>');
                }, complete: function () {
                    $('#label-zone .container-spin-loading').remove();
                }, success: function (json) {
                    if (json['error'] == false) {
                        $('#load-ajax-ward').html('');
                        html = '<select name="ward_id" onchange="loadListShipping()" id="input-wardid" class="form-control">';
                        if (json['data'] != '') {
                            for (i = 0; i < json['data'].length; i++) {
                                if (json['data'][i]['ward_id'] == ward_id) {
                                    html += '<option value="' + json['data'][i]['ward_id'] + '"';
                                    html += ' selected="selected">' + json['data'][i]['name'] + '</option>';
                                } else {
                                    html += '<option value="' + json['data'][i]['ward_id'] + '"';
                                    html += '>' + json['data'][i]['name'] + '</option>';
                                }
                            }
                        }
                        html += "</select>";
                        $('#load-ajax-ward').html(html);
                        loadListShipping();
                    } else {
                        $('#load-ajax-ward').html('<select name="ward_id" onchange="loadListShipping()" id="input-wardid" class="form-control"></select>');
                    }
                }, error: function (xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        } </script>
    <script type="text/javascript"> $(document).ready(function () {
            if ($('#is-delivery-address').is(":checked") == true) {
                $('#container-form-address-ship').css('display', 'none');
            } else {
                $('#container-form-address-ship').css('display', 'block');
            }
        });

        function showHideDeliveryAddress() {
            var toggle_info_payment = $('#is-delivery-address').is(":checked");
            if (toggle_info_payment == true) {
                $('#container-form-address-ship').css('display', 'none');
            } else {
                $('#container-form-address-ship').css('display', 'block');
            }
        } </script>
    <script type="text/javascript"> $(document).ready(function () {
            if ($('#request-invoice').is(":checked") == true) {
                $('#container-form-invoice').show();
            } else {
                $('#container-form-invoice').hide();
            }
        });

        function showHideInvoice() {
            var toggle_invoice = $('#request-invoice').is(":checked");
            if (toggle_invoice == true) {
                $('#container-form-invoice').css('display', 'block');
            } else {
                $('#container-form-invoice').css('display', 'none');
            }
        } </script>
@stop