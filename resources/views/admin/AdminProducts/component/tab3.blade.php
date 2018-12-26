<div id="menu2" class="tab-pane fade">
    <h3>Hồ sơ yêu cầu của sản phẩm vay</h3>
    <div class="marginTop20" style="width: 100%;min-height: 150px;max-height:200px;overflow-x: hidden;">
        <table class="table table-bordered table-hover">
            @if(isset($document_types))
                @foreach ($document_types as $key => $document_type)
                    <tr>
                        <td class="text-center text-middle">
                            <input type="checkbox" class="checkItem" name="product_docyment_group[]"
                                   @if(in_array($document_type['id'],$array_id_product_document)) checked="checked" @endif
                                   value="{{(int)$document_type['id']}}" />
                        </td>
                        <td class="text-left text-middle">
                            <b>{{ $document_type['name'] }}</b>
                        </td>
                    </tr>
                @endforeach
            @endif
        </table>
    </div>

</div>
