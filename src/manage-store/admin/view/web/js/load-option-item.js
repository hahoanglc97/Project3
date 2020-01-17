// event click button assign
function assignProduct(url_ajax, id_product) {
    if($("#dialog"+id_product).length === 0) {
        var id_store_select = $('#selectstore').val();
        if (id_store_select === '') {
            alert('Please select store!')
        } else {
            $.ajax({
                type: "POST",
                dataType: "JSON",
                url: url_ajax,
                data: {
                    action: "get_data_product_in_store",
                    storeId: id_store_select,
                    productId: id_product
                },
                success: function (response) {
                    if (response.success) {
                        var data = response.data;
                        generatedData(data,id_product);
                        ShowPopUp(id_product);
                    } else {
                        alert('Error load data!');
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR);
                    console.log(textStatus, errorThrown);
                }
            })
        }
    }else{
        ShowPopUp(id_product);
    }
};


//display and hidden popup
function ShowPopUp(id) {
    $("#overlay").show();
    $("#dialog"+id).fadeIn(300);
    $("#overlay").click(function (e) {
        HideDialog(id);
    });
    $("#close-popup-select-item").click(function () {
        HideDialog(id);
    })
}

function HideDialog(id) {
    $("#overlay").hide();
    $("#dialog"+id).fadeOut(300);
}

function generatedData(data,id_product) {
    var html =
        '<div id="overlay" class="popup-overlay"></div>\n' +
        '<div id="dialog'+id_product+'" class="popup-dialog">\n' +
        '    <header id="title-popup">Select item for order</header>\n' +
        '    <br>\n' +
        '    <table>\n' +
        '        <thead>\n' +
        '        <tr>\n' +
        '            <th>STT</th>\n' +
        '            <th>Import Date</th>\n' +
        '            <th>Out Date</th>\n' +
        '            <th>Qty In Store</th>\n' +
        '            <th>Qty Assign</th>\n' +
        '        </tr>\n' +
        '        </thead>\n' +
        '        <tbody>\n';
    if(data){
        $.each(data, function (key, value) {
            html +='<tr>\n'+
                '<td><input type="hidden" name="id-product[]" value="'+ id_product+'"/> '+ key +'</td>'+
                '<td><input class="input-import-date" name="import-date[]" type="text" value="' + value['import_date'] + '" readonly/></td>\n' +
                '<td><input class="input-out-date" name="out-date[]" type="text" value="' + value['out_date'] + '" readonly/></td>\n' +
                '<td><input type="number" value="' + value['qty'] + '" readonly/></td>\n' +
                '<td><input name="qty-assign[]" type="number" value="0"/></td>\n'+
                '</tr>\n';
        });
    }else{
        html +='<tr>\n'+
            '<td><input type="hidden" name="id-product[]" value="'+ id_product+'"/>1</td>'+
            '<td><input class="input-import-date" name="import-date[]" type="text" readonly/></td>\n' +
            '<td><input class="input-out-date" name="out-date[]" type="text" readonly/></td>\n' +
            '<td><input type="number" readonly/></td>\n' +
            '<td><input name="qty-assign[]" type="number" value="0"/></td>\n'+
            '</tr>\n';
    }
    html += '</tbody>\n' +
        '</table>\n' +
        '<div class="button-close-popup">'+
        '<input type="button" id="close-popup-select-item" value="Close"/>'+
        '</div>'+
    '</div>\n';
    $(html).appendTo($('#post'));
}